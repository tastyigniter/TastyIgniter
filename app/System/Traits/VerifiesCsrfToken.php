<?php

namespace System\Traits;

use Carbon\Carbon;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Cookie;

/**
 * Verifies CSRF token Trait
 */
trait VerifiesCsrfToken
{
    public $enableCsrfProtection = TRUE;

    protected function makeXsrfCookie()
    {
        $config = config('session');

        return new Cookie(
            'XSRF-TOKEN',
            Session::token(),
            Carbon::now()->addMinutes((int)$config['lifetime'])->getTimestamp(),
            $config['path'],
            $config['domain'],
            $config['secure'],
            FALSE,
            FALSE,
            $config['same_site'] ?? null
        );
    }

    protected function verifyCsrfToken()
    {
        if (!config('system.enableCsrfProtection', TRUE) || !$this->enableCsrfProtection)
            return TRUE;

        if (in_array(Request::method(), ['HEAD', 'GET', 'OPTIONS']))
            return TRUE;

        if (!strlen($token = $this->getCsrfTokenFromRequest()))
            return FALSE;

        return is_string(Request::session()->token())
            && is_string($token)
            && hash_equals(Request::session()->token(), $token);
    }

    /**
     * Get the CSRF token from the request.
     *
     * @return string
     */
    protected function getCsrfTokenFromRequest()
    {
        $token = Request::input('_token') ?: Request::header('X-CSRF-TOKEN');

        if (!$token && $header = Request::header('X-XSRF-TOKEN')) {
            try {
                $token = Crypt::decrypt($header, static::serialized());
            }
            catch (DecryptException $e) {
                $token = '';
            }
        }

        return $token;
    }

    /**
     * Determine if the cookie contents should be serialized.
     *
     * @return bool
     */
    public static function serialized()
    {
        return EncryptCookies::serialized('XSRF-TOKEN');
    }
}
