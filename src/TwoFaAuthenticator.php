<?php


namespace Visanduma\NovaTwoFactor;

use Exception;
use PragmaRX\Google2FALaravel\Support\Authenticator;
use Visanduma\NovaTwoFactor\Helpers\NovaUser;

class TwoFaAuthenticator extends Authenticator
{

    use NovaUser;

    protected function canPassWithoutCheckingOTP()
    {
        return
            !$this->isEnabled() ||
            $this->noUserIsAuthenticated() ||
            $this->twoFactorAuthStillValid();
    }

    /**
     * @return mixed
     * @throws Exception
     */
    protected function getGoogle2FASecretKey()
    {
        $secret = $this->getUser()->twoFa->google2fa_secret;
        if (is_null($secret) || empty($secret)) {
            throw new Exception('Secret key cannot be empty.');
        }

        return $secret;
    }

    public function isValidOtp(): bool
    {
        return $this->checkOTP() == 'valid';
    }

    protected function getUser()
    {
        return $this->novaUser();
    }
}
