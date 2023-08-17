<?php

namespace Visanduma\NovaTwoFactor\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Crypt;

class TwoFa extends Model
{
    protected $table = 'nova_twofa';

    protected $fillable = ['recovery', 'google2fa_secret'];

    protected $casts = [
        'confirmed' => 'boolean',
        'google2fa_enable' => 'boolean'
    ];

    public function getConnectionName()
    {
        return config('nova-two-factor.connection_name') ?? config('database.default');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('nova-two-factor.user_model'));
    }

    public function getGoogle2faSecretAttribute()
    {
        $value = $this->attributes['google2fa_secret'];

        if ($value !== null && config('nova-two-factor.encrypt_google2fa_secrets')) {
            $value = Crypt::decrypt($value);
        }

        return $value;
    }

    public function setGoogle2faSecretAttribute($value)
    {
        if ($value !== null && config('nova-two-factor.encrypt_google2fa_secrets')) {
            $value = Crypt::encrypt($value);
        }

        $this->attributes['google2fa_secret'] = $value;
    }
}
