
<p align="center">
<img src="https://github.com/Visanduma/nova-two-factor/blob/c26d41cb38c5850e7ee3863e34e5fd3b0c3f18a5/resources/img/nova-two-factor-banner.png?raw=true" />
</p>

[![Latest Stable Version](http://poser.pugx.org/visanduma/nova-two-factor/v)](https://packagist.org/packages/visanduma/nova-two-factor) [![Total Downloads](http://poser.pugx.org/visanduma/nova-two-factor/downloads)](https://packagist.org/packages/visanduma/nova-two-factor) [![Latest Unstable Version](http://poser.pugx.org/visanduma/nova-two-factor/v/unstable)](https://packagist.org/packages/visanduma/nova-two-factor) [![License](http://poser.pugx.org/visanduma/nova-two-factor/license)](https://packagist.org/packages/visanduma/nova-two-factor) [![PHP Version Require](http://poser.pugx.org/visanduma/nova-two-factor/require/php)](https://packagist.org/packages/visanduma/nova-two-factor)

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
