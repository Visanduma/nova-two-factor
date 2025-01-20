<?php

namespace Visanduma\NovaTwoFactor\Http\Controller;

use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use PragmaRX\Google2FA\Google2FA as G2fa;
use PragmaRX\Google2FAQRCode\Google2FA;
use PragmaRX\Google2FAQRCode\QRCode\Bacon;
use Visanduma\NovaTwoFactor\Helpers\NovaUser;
use Visanduma\NovaTwoFactor\NovaTwoFactor;
use Visanduma\NovaTwoFactor\TwoFaAuthenticator;

class TwoFactorController
{
    use NovaUser;

    public function register()
    {
        if ($this->novaUser()->twoFaConfirmed()) {
            return $this->settings();
        }

        return inertia('NovaTwoFactor.Register', [
            ...$this->registerUser(),
        ]);
    }

    public function settings()
    {
        return inertia('NovaTwoFactor.Settings', [
            'enabled' => $this->novaUser()->twoFaEnabled(),
        ]);
    }

    private function generateRecoveryCode(): string
    {
        $recoveryKey = strtoupper(Str::random(16));
        $recoveryKey = str_split($recoveryKey, 4);
        $recoveryKey = implode('-', $recoveryKey);

        return $recoveryKey;
    }

    private function registerUser()
    {
        $google2fa = new G2fa;
        $secretKey = $google2fa->generateSecretKey();

        $recovery = $this->generateRecoveryCode();
        $recoveryKeyHashed = bcrypt($recovery);

        if ($this->novaUser()->twofa) {

            $this->novaUser()->twofa->update([
                'recovery' => $recoveryKeyHashed,
            ]);
        } else {

            $this->novaUser()->twofa()->create([
                'google2fa_secret' => $secretKey,
                'recovery' => $recoveryKeyHashed,
            ]);
        }

        $this->novaUser()->refresh();

        $url = null;
        $company = config('nova-two-factor.display_name', config('app.name'));
        $email = $this->novaUser()->email;
        $secretKey = $this->novaUser()->twofa->google2fa_secret;
        $isSvg = false;

        if (! config('nova-two-factor.use_offline_qr')) {
            $url = $this->getOnlineQrCode($company, $email, $secretKey);

        } else {
            $isSvg = true;
            $imageBackEnd = new SvgImageBackEnd;
            $qrCodeService = new Bacon($imageBackEnd);
            $url = (new Google2FA($qrCodeService))->getQRCodeInline($company, $email, $secretKey, 250);
        }

        $data = [
            'qr_url' => $url,
            'recovery' => $recovery,
            'svg' => $isSvg,
        ];

        return $data;
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required',
        ]);

        $otp = request()->get('otp');
        request()->merge(['one_time_password' => $otp]);

        $authenticator = app(TwoFaAuthenticator::class)->boot(request());

        if ($authenticator->isAuthenticated()) {
            // otp auth success!

            $this->novaUser()->twoFa()->update([
                'confirmed' => true,
                'google2fa_enable' => true,
            ]);

            return response()->json([
                'message' => __('2FA security successfully activated !'),
                'url' => '/nova-two-factor/settings',
            ]);
        }

        // auth fail
        return response()->json([
            'message' => __('Invalid OTP !. Please try again'),
        ], 422);
    }

    public function toggle2Fa(Request $request)
    {
        $status = $request->get('status', false);

        $this->novaUser()->twoFa()->update([
            'google2fa_enable' => $status,
        ]);

        return response()->json([
            'message' => $status ? __('2FA feature enabled!') : __('2FA feature disabled !'),
        ]);
    }

    public function getOnlineQrCode($company, $holder, $secret, $size = 500)
    {

        $url = (new Google2FA)->getQRCodeUrl($company, $holder, $secret);

        return "https://api.qrserver.com/v1/create-qr-code/?size={$size}x{$size}&data={$url}";

    }

    public function authenticate(Request $request)
    {
        if (config('nova-two-factor.enable_max_attempts')) {
            $throttleKey = 'nova-two-factor:authenticate:'.$this->novaUser()->id;
            $attempts = config('nova-two-factor.max_attempts_per_minute');

            if (RateLimiter::tooManyAttempts($throttleKey, $attempts)) {
                return back()->withErrors([__('Too many attempts!')]);
            }

            RateLimiter::hit($throttleKey);
        }

        $authenticator = app(TwoFaAuthenticator::class)->boot(request());

        if ($authenticator->isAuthenticated()) {
            session()->put('2fa.logged_at', now());
            session()->put('2fa.prompt', false);

            return redirect()->intended(config('nova.path'));
        }

        return back()->withErrors([__('Incorrect OTP !')]);
    }

    public function recover(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('nova-two-factor::recover');
        }

        if (Hash::check($request->get('recovery_code'), $this->novaUser()->twoFa->recovery)) {
            // reset 2fa
            $this->novaUser()->twoFa()->delete();

            return redirect()->to(config('nova.path'));
        } else {
            return back()->withErrors([__('Incorrect recovery code !')]);
        }
    }

    public function validatePrompt(Request $request)
    {
        $authenticator = app(TwoFaAuthenticator::class)->boot($request);

        if ($authenticator->isValidOtp()) {

            NovaTwoFactor::setLastPromptTime();

            return response()->json([
                // 'goto' => session()->get('url.intended')
            ]);
        }

        return response()->json([
            'message' => __('Incorrect OTP'),
        ], 422);
    }

    public function clear(Request $request)
    {
        if ($request->isMethod('get')) {
            return inertia('NovaTwoFactor.Clear');
        }

        $request->validate([
            'password' => 'required|current_password:'.config('nova.guard'),
        ]);

        app(TwoFaAuthenticator::class)->logout();

        $this->novaUser()->twoFa()->delete();

        return response()->json(['message' => __('Two FA settings has been cleared')]);
    }
}
