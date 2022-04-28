<?php


namespace Visanduma\NovaTwoFactor;


use Visanduma\NovaTwoFactor\Models\TwoFa;

trait ProtectWith2FA
{
    public function twoFa()
    {
        return $this->hasOne(TwoFa::class);
    }
}