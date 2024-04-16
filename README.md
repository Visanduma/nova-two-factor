<p align="center">

<img src="https://github.com/Visanduma/nova-two-factor/blob/c26d41cb38c5850e7ee3863e34e5fd3b0c3f18a5/resources/img/nova-two-factor-banner.png?raw=true" />

</p>

[![Latest Stable Version](http://poser.pugx.org/visanduma/nova-two-factor/v)](https://packagist.org/packages/visanduma/nova-two-factor) [![Total Downloads](http://poser.pugx.org/visanduma/nova-two-factor/downloads)](https://packagist.org/packages/visanduma/nova-two-factor) [![Latest Unstable Version](http://poser.pugx.org/visanduma/nova-two-factor/v/unstable)](https://packagist.org/packages/visanduma/nova-two-factor) [![License](http://poser.pugx.org/visanduma/nova-two-factor/license)](https://packagist.org/packages/visanduma/nova-two-factor) [![PHP Version Require](http://poser.pugx.org/visanduma/nova-two-factor/require/php)](https://packagist.org/packages/visanduma/nova-two-factor)

# Nova-Two-Factor
Laravel nova in-dashboard 2FA security feature.


## What's New

### v2.2.3
- Fixed foreign key issue (need to run migration)
- Translation fixes

### v2.2.2
- Clear option for current Two  FA settings
### v2.2.0
- Reauthorize any routes using *2FA Prompt* dialog.



## Interface

Setup 2FA

![screenshot](/resources/img/sc-1.png)

Enable/Disable feature

![screenshot](/resources/img/sc-2.png)

Nova login screen with 2FA security

![screenshot](/resources/img/sc-3.png)

Reauthorize any route using 2FA prompt

![screenshot](/resources/img/sc-4.png)

Install the package

`` composer require visanduma/nova-two-factor ``


1. Pubish config & migration

`` php artisan vendor:publish --provider="Visanduma\NovaTwoFactor\ToolServiceProvider" ``


Change configs as your needs

``` 

return [
    
     // enable or disable 2FA feature. default is enabled
    'enabled' => env('NOVA_TWO_FA_ENABLE',true),
    
    // name of authenticatable entity table. usually - users
    'user_table' => 'users',
    
    // Entity primary key
    'user_id_column' => 'id',
    
    // authenticatable model class
    'user_model' => \App\Models\User::class

    /* Change visibility of Nova Two Fa menu in right sidebar */
    'showin_sidebar' => true,

    'menu_text' => 'Two FA',

    'menu_icon' => 'lock-closed',

    /* Exclude any routes from 2fa security */
    'except_routes' => [
        //
    ],

    /**
     * reauthorize these urls before access, withing given timeout
     * you are allowed to use wildcards pattern for url matching
     **/

    'reauthorize_urls' => [
       // 'nova/resources/users/new',
       // 'nova/resources/users/*/edit',
    ],

    /* timeout in minutes */

    'reauthorize_timeout' => 5,


    /* QR code can be generate using  online API or inbuilt 'BaconQrCode' package*/

    'use_offline_qr' => false,

];

```


2. Use ProtectWith2FA trait in configured model

``` 
<?php

namespace App\Models;

use Visanduma\NovaTwoFactor\ProtectWith2FA;

class User extends Authenticatable{

    use ProtectWith2FA;
}

```



3. Add TwoFa middleware to nova config file


``` 
/*
    |--------------------------------------------------------------------------
    | Nova Route Middleware
    |--------------------------------------------------------------------------
    |
    | These middleware will be assigned to every Nova route, giving you the
    | chance to add your own middleware to this stack or override any of
    | the existing middleware. Or, you can just stick with this stack.
    |
    */

    'middleware' => [
        ...
        \Visanduma\NovaTwoFactor\Http\Middleware\TwoFa::class
    ],

```


4. Register NovaTwoFactor tool in Nova Service Provider

``` 
<?php

class NovaServiceProvider extends NovaApplicationServiceProvider{

public function tools()
    {
        return [
            ...
            new \Visanduma\NovaTwoFactor\NovaTwoFactor()

        ];
    }

}


```

5. Run `` php artisan migrate ``
6. You are done !
