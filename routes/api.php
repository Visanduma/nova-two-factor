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

Route::match(['get','post'],'/recover', [\Visanduma\NovaTwoFactor\Http\Controller\TwoFactorController::class,'recover'])->name('nova-two-factor.recover');

Route::get('/status', [\Visanduma\NovaTwoFactor\Http\Controller\TwoFactorController::class,'getStatus']);

Route::post('/confirm', [\Visanduma\NovaTwoFactor\Http\Controller\TwoFactorController::class,'verifyOtp']);

Route::post('/toggle', [\Visanduma\NovaTwoFactor\Http\Controller\TwoFactorController::class,'toggle2Fa']);

Route::post('/authenticate', [\Visanduma\NovaTwoFactor\Http\Controller\TwoFactorController::class,'authenticate'])->name('nova-two-factor.auth');

Route::post('validatePrompt', [\Visanduma\NovaTwoFactor\Http\Controller\TwoFactorController::class,'validatePrompt']);

Route::view('auth-otp','nova-two-factor::sign-in')->name('nova-two-factor.auth-form');
