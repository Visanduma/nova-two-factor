<?php


namespace Visanduma\NovaTwoFactor\Http\Middleware;


use Closure;
use Illuminate\Support\Str;
use Nette\Utils\Html;
use PragmaRX\Google2FA\Google2FA as G2fa;
use Visanduma\NovaTwoFactor\TwoFaAuthenticator;

class TwoFa
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     * @throws \PragmaRX\Google2FA\Exceptions\InsecureCallException
     */
    public function handle($request, Closure $next)
    {

        $except = [
            'nova-vendor/nova-two-factor/authenticate',
            'nova-vendor/nova-two-factor/recover'
        ];

        $except = array_merge($except,config('nova-two-factor.except_routes'));


        if (!config('nova-two-factor.enabled') || in_array($request->path(),$except)) {
            return $next($request);
        }

        $authenticator = app(TwoFaAuthenticator::class)->boot($request);
        if (auth()->guest() || $authenticator->isAuthenticated()) {
            return $next($request);
        }

        // turn off security if no user2fa record
        if(!auth()->user()->twoFa){
            return $next($request);
        }

        // turn off security if 2fa is off
        if(auth()->user()->twoFa && auth()->user()->twoFa->google2fa_enable === 0){
            return $next($request);
        }


        return response(view('nova-two-factor::sign-in'));
    }

}
