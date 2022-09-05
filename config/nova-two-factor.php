<?php

/*
 *  Nova Two Factor config file
 *
 * */

return [


    'enabled' => env('NOVA_TWO_FA_ENABLE',true),


    'user_table' => 'users',


    'user_id_column' => 'id',


    'user_model' => \App\Models\User::class,

    /* Change visibility of Nova Two Fa menu in right sidebar */
    'showin_sidebar' => true,

    'menu_text' => 'Two FA',

    'menu_icon' => 'lock-closed',

    /* Exclude any routes from 2fa security */
    'except_routes' => [
        //
    ]

];
