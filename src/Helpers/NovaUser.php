<?php

namespace Visanduma\NovaTwoFactor\Helpers;

trait NovaUser
{
    public function novaUser()
    {
        return auth(config('nova.guard', 'web'))->user();
    }
}
