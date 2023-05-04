<?php

namespace Visanduma\NovaTwoFactor\Http\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PragmaRX\Google2FAQRCode\Google2FA;
use PragmaRX\Google2FA\Google2FA as G2fa;
use Visanduma\NovaTwoFactor\Models\TwoFa;
use Visanduma\NovaTwoFactor\TwoFaAuthenticator;

class TwoFactorController
{
    private $novaGuard;

    public function __construct()
    {
        $this->novaGuard = config('nova.guard', 'web');
    }

    public function index()
    {
        return inertia('NovaTwoFactor');
    }

    public function registerUser()
    {
        if (auth($this->novaGuard)->user()->twoFa && auth($this->novaGuard)->user()->twoFa->confirmed == 1) {
            return response()->json([
                'message' => __('Already verified !')
            ]);
        }

        $google2fa = new G2fa();
        $secretKey = $google2fa->generateSecretKey();

        $recoveryKey = strtoupper(Str::random(16));
        $recoveryKey = str_split($recoveryKey, 4);
        $recoveryKey = implode("-", $recoveryKey);

        $recoveryKeyHashed = bcrypt($recoveryKey);

        $data['recovery'] = $recoveryKey;


        $userTwoFa = new TwoFa();
        $userTwoFa::where('user_id', auth($this->novaGuard)->id())->delete();
        $user2fa = new $userTwoFa();
        $user2fa->user_id = auth($this->novaGuard)->id();
        $user2fa->google2fa_secret = $secretKey;
        $user2fa->recovery = $recoveryKeyHashed;
        $user2fa->save();

        $url = null;
        $company = config('app.name');
        $email = auth($this->novaGuard)->user()->email;

        if (config('nova-two-factor.use_google_qr_code_api')) {
            $url = $this->getQRCodeUsingGoogle($company, $email, $secretKey);
        } else {
            $url = (new Google2FA())->getQRCodeInline($company, $email, $secretKey, 500);
        }

        $data['google2fa_url'] = $url;

        return $data;
    }

    public function verifyOtp()
    {
        $otp = request()->get('otp');
        request()->merge(['one_time_password' => $otp]);

        $authenticator = app(TwoFaAuthenticator::class)->boot(request());

        if ($authenticator->isAuthenticated()) {
            // otp auth success!

            auth($this->novaGuard)->user()->twoFa()->update([
                'confirmed' => true,
                'google2fa_enable' => true
            ]);

            return response()->json([
                'message' => __('2FA security successfully activated !')
            ]);
        }

        // auth fail
        return response()->json([
            'message' => __('Invalid OTP !. Please try again')
        ], 422);
    }

    public function toggle2Fa(Request $request)
    {
        $status = $request->get('status', false);

        auth($this->novaGuard)->user()->twoFa()->update([
            'google2fa_enable' => $status
        ]);

        return response()->json([
            'message' => $status ? __('2FA feature enabled!') : __('2FA feature disabled !')
        ]);
    }

    public function getStatus()
    {
        $user = auth($this->novaGuard)->user();

        return [
            "registered" => !empty($user->twoFa),
            "enabled" => auth($this->novaGuard)->user()->twoFa->google2fa_enable ?? false,
            "confirmed" => auth($this->novaGuard)->user()->twoFa->confirmed ?? false
        ];
    }

    public function getQRCodeUsingGoogle($company, $holder, $secret, $size = 500)
    {
        $g2fa = new G2fa();
        $url = $g2fa->getQRCodeUrl($company, $holder, $secret);

        return self::generateGoogleQRCodeUrl('https://chart.googleapis.com/', 'chart', 'chs=' . $size . 'x' . $size . '&chld=M|0&cht=qr&chl=', $url);
    }

    public static function generateGoogleQRCodeUrl($domain, $page, $queryParameters, $qrCodeUrl)
    {
        $url = $domain .
            rawurlencode($page) .
            '?' . $queryParameters .
            urlencode($qrCodeUrl);

        return $url;
    }

    public function authenticate(Request $request)
    {
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

        if (Hash::check($request->get('recovery_code'), auth($this->novaGuard)->user()->twoFa->recovery)) {
            // reset 2fa
            auth($this->novaGuard)->user()->twoFa()->delete();
            return redirect()->to(config('nova.path'));
        } else {
            return back()->withErrors([__('Incorrect recovery code !')]);
        }
    }

    public function validatePrompt(Request $request)
    {
        $authenticator = app(TwoFaAuthenticator::class)->boot($request);

        if ($authenticator->isValidOtp()) {

            session()->put('2fa.prompt_at', now());

            return response()->json([
                'goto' => session()->get('url.intended')
            ]);
        }


        return response()->json([
            'message' =>  __('Incorrect OTP')
        ], 422);
    }

    public function clear(Request $request)
    {
        if ($request->isMethod('get')) {
            return inertia('NovaTwoFactor.Clear');
        }

        $request->validate([
            'password' => 'required|current_password'
        ]);

        $user = auth($this->novaGuard)->user();

        $user->twoFa()->delete();

        return response()->json(['message' => __('Two FA settings has been cleared')]);
    }
}
