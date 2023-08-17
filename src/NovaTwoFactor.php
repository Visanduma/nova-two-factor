<?php

namespace Visanduma\NovaTwoFactor;

use Illuminate\Http\Request;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class NovaTwoFactor extends Tool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        Nova::script('nova-two-factor', __DIR__ . '/../dist/js/tool.js');
        Nova::style('nova-two-factor', __DIR__ . '/../dist/css/tool.css');
    }

    /**
     * Build the view that renders the navigation links for the tool.
     *
     * @return \Illuminate\View\View
     */
    public function menu(Request $request)
    {
        if (config('nova-two-factor.showin_sidebar', true)) {
            return MenuSection::make(config('nova-two-factor.menu_text'))
                ->path('/nova-two-factor')
                ->icon(config('nova-two-factor.menu_icon'));
        }
    }

    public static function promptEnabled(Request $request)
    {

        $timeout = config('nova-two-factor.reauthorize_timeout', 5);

        $promptFor = config('nova-two-factor.reauthorize_urls', []);

        $hasUrl = $request->is($promptFor);

        $lastAttempt = session()->get('2fa.prompt_at', now()->subMinutes($timeout + 1));

        if ($lastAttempt->diffInMinutes(now()) > $timeout && $hasUrl) {
            return true;
        }

        return false;
    }


    public static function prompt()
    {
        return inertia('NovaTwoFactor.Prompt', [
            'referer' => request()->url()
        ]);
    }
}
