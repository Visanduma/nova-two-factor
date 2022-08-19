<?php


return [

    'enabled' => env('NOVA_TWO_FA_ENABLE',true),


    'user_table' => 'users',


    'user_id_column' => 'id',


    'user_model' => \App\Models\User::class,


    'excect_routes' => [
        //
    ]

];
