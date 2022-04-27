<?php

namespace Visanduma\NovaTwoFactor\Http\Controller;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lifeonscreen\Google2fa\Google2FAAuthenticator;
use PragmaRX\Google2FA\Google2FA as G2fa;
use PragmaRX\Recovery\Recovery;

class TwoFactorController extends Controller
{
    public function registerUser()
    {

        if(auth()->user()->user2fa && auth()->user()->user2fa->confirmed == 1){
            return response()->json([
                'message' => 'Already verified !'
            ]);
        }

        $google2fa = new G2fa();
        $recovery = new Recovery();
        $secretKey = $google2fa->generateSecretKey();

        $data['recovery'] = $recovery
            ->setCount(config('lifeonscreen2fa.recovery_codes.count'))
            ->setBlocks(config('lifeonscreen2fa.recovery_codes.blocks'))
            ->setChars(config('lifeonscreen2fa.recovery_codes.chars_in_block'))
            ->toArray();

        $recoveryHashes = $data['recovery'];
        array_walk($recoveryHashes, function (&$value) {
            $value = password_hash($value, config('lifeonscreen2fa.recovery_codes.hashing_algorithm'));
        });



        $user2faModel = config('lifeonscreen2fa.models.user2fa');
        $user2faModel::where('user_id', auth()->user()->id)->delete();
        $user2fa = new $user2faModel();
        $user2fa->user_id = auth()->user()->id;
        $user2fa->google2fa_secret = $secretKey;
        $user2fa->recovery = json_encode($recoveryHashes);
        $user2fa->save();



        $google2fa_url = $this->getQRCodeGoogleUrl(
            config('app.name'),
            auth()->user()->email,
            $secretKey
        );

        $data['google2fa_url'] = $google2fa_url;

        return $data;
    }

    public function verifyOtp()
    {
        $otp = request()->get('otp');
        request()->merge(['one_time_password' => $otp]);

        $authenticator = app(Google2FAAuthenticator::class)->boot(request());

        if ($authenticator->isAuthenticated()) {
            // otp auth success!

            auth()->user()->user2fa()->update([
                'confirmed' => true,
                'google2fa_enable' => true
            ]);

            return response()->json([
                'message' => '2FA security successfully activated !'
            ]);
        }

        return response()->json([
            'message' => 'Invalid OTP !. Please try again'
        ],422);
    }

    public function toggle2Fa(Request $request)
    {
        $status = $request->get('status') === 1;
        auth()->user()->user2fa()->update([
            'google2fa_enable' => $status
        ]);

        return response()->json([
            'message' => $status ? '2FA feature enabled!' : '2FA feature disabled !'
        ]);
    }

    public function getStatus()
    {
        $user = auth()->user();
        $res = [
            "registered" => !empty($user->user2fa),
            "enabled" => auth()->user()->user2fa->google2fa_enable ?? false,
            "confirmed" => auth()->user()->user2fa->confirmed ?? false
        ];
        return $res;
    }

    public function getQRCodeGoogleUrl($company, $holder, $secret, $size = 200)
    {
        $g2fa = new G2fa();
        $url = $g2fa->getQRCodeUrl($company, $holder, $secret);

        return self::generateGoogleQRCodeUrl('https://chart.googleapis.com/', 'chart', 'chs='.$size.'x'.$size.'&chld=M|0&cht=qr&chl=', $url);
    }

    public static function generateGoogleQRCodeUrl($domain, $page, $queryParameters, $qrCodeUrl)
    {
        $url = $domain.
            rawurlencode($page).
            '?'.$queryParameters.
            urlencode($qrCodeUrl);

        return $url;
    }

}
