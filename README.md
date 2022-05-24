# Nova-Two-Factor
Laravel nova in-dashboard 2FA security feature

1. pubish config & migration

`` php artisan vendor:publish --provider="Visanduma\NovaTwoFactor\ToolServiceProvider" ``


Change configs as your needs

``` 

return [

    'enabled' => env('NOVA_TWO_FA_ENABLE',true),
    'user_table' => 'users',
    'user_id_column' => 'id',
    'user_model' => \App\Models\User::class

];

```


2. use ProtectWith2FA trait in user model

`` use ProtectWith2FA ``

3. add TwoFa middleware to nova config file


`` \Visanduma\NovaTwoFactor\Http\Middleware\TwoFa::class ``


4. register NovaTwoFactor tool in Nova Service Provider

`` new \Visanduma\NovaTwoFactor\NovaTwoFactor() ``

5. run php artisan migrate
6. You are done !
