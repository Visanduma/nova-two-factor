<?php

namespace Visanduma\NovaTwoFactor\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TwoFa extends Model
{
    protected $table = 'nova_twofa';

    protected $casts = [
        'confirmed' => 'boolean',
        'google2fa_enable' => 'boolean'
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(config('nova-two-factor.user_model'));
    }
}
