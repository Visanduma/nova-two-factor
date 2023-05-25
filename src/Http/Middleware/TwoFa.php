<?php


namespace Visanduma\NovaTwoFactor\Http\Middleware;


use Closure;
use Visanduma\NovaTwoFactor\Helpers\NovaUser;
use Visanduma\NovaTwoFactor\NovaTwoFactor;
use Visanduma\NovaTwoFactor\TwoFaAuthenticator;

class TwoFa
{
    use NovaUser;

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
            'nova-vendor/nova-two-factor/recover',
            'nova-vendor/nova-two-factor/validatePrompt',
        ];


        $except = array_merge($except,config('nova-two-factor.except_routes'));


        if (!config('nova-two-factor.enabled') || in_array($request->path(),$except)) {
            return $next($request);
        }

        $authenticator = app(TwoFaAuthenticator::class)->boot($request);

         // turn off security if  user has not 2fa record
        if(!$this->novaUser()?->twoFa){
            return $next($request);
        }

        // re prompt for OTP
        if(NovaTwoFactor::promptEnabled($request)){
            return NovaTwoFactor::prompt();
        }

        // allow access if already authenticated
        if ($authenticator->isAuthenticated()) {
            // return inertia('NovaTwoFactor.Prompt');
            return $next($request);
        }

        // turn off security if 2fa is off
        if(!$this->novaUser()?->twoFa?->google2fa_enable){
            return $next($request);
        }

        return response(view('nova-two-factor::sign-in'));
    }

}
