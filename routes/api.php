<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Lifeonscreen\Google2fa\Google2FAAuthenticator;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. They are protected
| by your tool's "Authorize" middleware by default. Now, go build!
|
*/

Route::get('/register', [\Visanduma\NovaTwoFactor\Http\Controller\TwoFactorController::class,'registerUser']);

Route::get('/status', [\Visanduma\NovaTwoFactor\Http\Controller\TwoFactorController::class,'getStatus']);

Route::post('/confirm', [\Visanduma\NovaTwoFactor\Http\Controller\TwoFactorController::class,'verifyOtp']);

Route::post('/toggle', [\Visanduma\NovaTwoFactor\Http\Controller\TwoFactorController::class,'toggle2Fa']);
