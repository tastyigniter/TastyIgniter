<?php

declare(strict_types=1);

namespace Igniter\Flame\Currency\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class CurrencyMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): mixed
    {
        // Don't redirect the console
        if (App::runningInConsole()) {
            return $next($request);
        }

        // Check for a user defined currency
        if (($currency = $this->getUserCurrency($request)) === null) {
            $currency = $this->getDefaultCurrency();
        }

        // Set user currency
        if ($currency !== currency()->getUserCurrency()) {
            $this->setUserCurrency($currency, $request);
        }

        return $next($request);
    }

    /**
     * Get the user selected currency.
     */
    protected function getUserCurrency(Request $request): ?string
    {
        // Check request for currency
        $currency = $request->get('currency');
        if ($currency && currency()->isActive($currency)) {
            return $currency;
        }

        // Get currency from session
        $currency = $request->getSession()->get('igniter.currency');
        if ($currency && currency()->isActive($currency)) {
            return $currency;
        }

        return null;
    }

    /**
     * Get the application default currency.
     */
    protected function getDefaultCurrency(): string
    {
        return currency()->config('default');
    }

    /**
     * Set the user currency.
     */
    private function setUserCurrency(string $currency, Request $request): void
    {
        // Set user selection globally
        currency()->setUserCurrency($currency = strtoupper($currency));

        // Save it for later too!
        $request->getSession()->set('igniter.currency', $currency);
    }
}
