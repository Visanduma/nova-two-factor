<?php


namespace Visanduma\NovaTwoFactor;

use Visanduma\NovaTwoFactor\Helpers\NovaUser;
use Visanduma\NovaTwoFactor\Models\TwoFa;

trait ProtectWith2FA
{
    public function twoFa()
    {
        return $this->hasOne(TwoFa::class, 'user_id', config('nova-two-factor.user_id_column'));
    }

    public function twoFaEnabled(): bool
    {
        return $this->twoFa && $this->twoFa->google2fa_enable;
    }

    public function twoFaConfirmed(): bool
    {
        return $this->twoFa && $this->twoFa->confirmed;
    }
}
