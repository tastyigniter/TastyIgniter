<?php

declare(strict_types=1);

namespace Igniter\Flame\Translation\Middleware;

use Closure;
use Igniter\Flame\Support\Facades\Igniter;
use Illuminate\Http\Request;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Igniter::hasDatabase()) {
            Igniter::runningInAdmin()
                ? $this->loadAdminLocale()
                : $this->loadLocale();
        }

        return $next($request);
    }

    protected function loadAdminLocale()
    {
        $localization = app('translator.localization');

        $userLocale = $this->getUserLocale() ?? $localization->getDefaultLocale();

        $localization->setLocale($userLocale);
    }

    protected function loadLocale()
    {
        $localization = app('translator.localization');

        if ($localization->loadLocaleFromRequest()) {
            return;
        }

        if ($localization->loadLocaleFromBrowser()) {
            return;
        }

        if ($localization->loadLocaleFromSession()) {
            return;
        }

        $localization->setLocale($localization->getDefaultLocale());
    }

    protected function getUserLocale()
    {
        if (!app('admin.auth')->isLogged()) {
            return null;
        }

        return app('admin.auth')->user()->getLocale();
    }
}
