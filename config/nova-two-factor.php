<?php

/*
 *  Nova Two Factor config file
 *
 * */

return [

    'enabled' => env('NOVA_TWO_FA_ENABLE', true),

    'user_table' => 'users',

    'user_id_column' => 'id',

    'connection_name' => env('DB_CONNECTION'),

    /* Encrypt the google secret values saved in database */
    'encrypt_google2fa_secrets' => false,

    /* QR code can be generate using  online API or inbuilt 'BaconQrCode' package*/
    'use_offline_qr' => false,

    'user_model' => \App\Models\User::class,

    /* Change visibility of Nova Two Fa menu in right sidebar */
    'showin_sidebar' => true,

    'menu_text' => 'Two FA',

    'menu_icon' => 'lock-closed',

    /* Exclude any routes from 2fa security */
    'except_routes' => [
        //
    ],

    /**
     * reauthorize these urls before access, within given timeout
     * you are allowed to use wildcards pattern for url matching
     **/
    'reauthorize_urls' => [
       // 'nova/resources/users/new',
       // 'nova/resources/users/*/edit',
    ],

    /* timeout in minutes */
    'reauthorize_timeout' => 5,

    'enable_max_attempts' => false,

    'max_attempts_per_minute' => 3,

];
