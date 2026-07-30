<?php

declare(strict_types=1);

namespace Igniter\Admin\Helpers;

use Igniter\Flame\Exception\SystemException;
use Igniter\Flame\Support\Facades\Igniter;
use Igniter\Flame\Support\RouterHelper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;

/**
 * Admin Helper
 * @see AdminHelper
 */
class AdminHelper
{
    public const HANDLER_REDIRECT = 'X_IGNITER_REDIRECT';

    /**
     * Returns the admin URI segment.
     */
    public static function uri(): string
    {
        return Igniter::adminUri();
    }

    /** Generate an absolute URL in context of the Admin */
    public static function url(?string $path = null, array $parameters = [], ?bool $secure = null): string
    {
        return URL::to(self::uri().'/'.$path, $parameters, $secure);
    }

    /** Returns the base admin URL from which this request is executed. */
    public static function baseUrl(?string $path = null): string
    {
        $adminUri = self::uri();
        $baseUrl = Request::getBaseUrl();

        if ($path !== null) {
            $path = RouterHelper::normalizeUrl($path);
        }

        return $baseUrl.'/'.$adminUri.$path;
    }

    /** Create a new redirect response to a given admin path. */
    public static function redirect(?string $path = null, int $status = 302, array $headers = [], ?bool $secure = null): RedirectResponse
    {
        return Redirect::to(self::uri().'/'.$path, $status, $headers, $secure);
    }

    /** Create a new admin redirect response, while putting the current URL in the session. */
    public static function redirectGuest(?string $path = null, int $status = 302, array $headers = [], ?bool $secure = null): RedirectResponse
    {
        return Redirect::guest(self::uri().'/'.$path, $status, $headers, $secure);
    }

    /** Create a new redirect response to the previously intended admin location. */
    public static function redirectIntended(?string $path = null, int $status = 302, array $headers = [], ?bool $secure = null): RedirectResponse
    {
        return Redirect::intended(self::uri().'/'.$path, $status, $headers, $secure);
    }

    public static function hasAjaxHandler(): bool
    {
        return !empty(request()->header('X-IGNITER-REQUEST-HANDLER'));
    }

    /** Returns the AJAX handler for the current request, if available. */
    public static function getAjaxHandler(): ?string
    {
        if (request()->ajax() && $handler = request()->header('X-IGNITER-REQUEST-HANDLER')) {
            return trim($handler);
        }

        if ($handler = post('_handler')) {
            return trim((string)$handler);
        }

        return null;
    }

    public static function validateAjaxHandler(string $handler): void
    {
        if (!preg_match('/^(?:\w+\:{2})?on[A-Z]{1}[\w+]*$/', $handler)) {
            throw new SystemException(sprintf(lang('igniter::admin.alert_invalid_ajax_handler_name'), $handler));
        }
    }

    public static function validateAjaxHandlerPartials(): array
    {
        if (empty($partials = trim(request()->header('X-IGNITER-REQUEST-PARTIALS', '')))) {
            return [];
        }

        $partials = explode('&', $partials);

        foreach ($partials as $partial) {
            if (!preg_match('/^(?:\w+\:{2}|@)?[a-z0-9\_\-\.\/]+$/i', $partial)) {
                throw new SystemException(sprintf(lang('igniter::admin.alert_invalid_ajax_partial_name'), $partial));
            }
        }

        return $partials;
    }
}
