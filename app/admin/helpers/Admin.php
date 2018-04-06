<?php namespace Admin\Helpers;

use Config;
use Igniter\Flame\Support\RouterHelper;
use Redirect;
use Request;
use URL;

/**
 * Admin Helper
 * @package Admin
 * @see \Admin\Facades\Admin
 */
class Admin
{
    /**
     * Returns the admin URI segment.
     */
    public function uri()
    {
        return Config::get('system.adminUri', 'admin');
    }

    /**
     * Generate an absolute URL in context of the Admin
     *
     * @param string $path
     * @param array $parameters
     * @param  bool|null $secure
     *
     * @return string
     */
    public function url($path = null, $parameters = [], $secure = null)
    {
        return URL::to($this->uri().'/'.$path, $parameters, $secure);
    }

    /**
     * Returns the base admin URL from which this request is executed.
     *
     * @param string $path
     *
     * @return string
     */
    public function baseUrl($path = null)
    {
        $adminUri = $this->uri();
        $baseUrl = Request::getBaseUrl();

        if ($path === null) {
            return $baseUrl.'/'.$adminUri;
        }

        $path = RouterHelper::normalizeUrl($path);

        return $baseUrl.'/'.$adminUri.$path;
    }

    /**
     * Create a new redirect response to a given admin path.
     *
     * @param string $path
     * @param int $status
     * @param array $headers
     * @param bool|null $secure
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirect($path, $status = 302, $headers = [], $secure = null)
    {
        return Redirect::to($this->uri().'/'.$path, $status, $headers, $secure);
    }

    /**
     * Create a new admin redirect response, while putting the current URL in the session.
     *
     * @param $path
     * @param int $status
     * @param array $headers
     * @param null $secure
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectGuest($path, $status = 302, $headers = [], $secure = null)
    {
        return Redirect::guest($this->uri().'/'.$path, $status, $headers, $secure);
    }

    /**
     * Create a new redirect response to the previously intended admin location.
     *
     * @param $path
     * @param int $status
     * @param array $headers
     * @param null $secure
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectIntended($path = '/', $status = 302, $headers = [], $secure = null)
    {
        $path = $path == '/' ? $path : '/'.$path;

        return Redirect::intended($this->uri().$path, $status, $headers, $secure);
    }
}
