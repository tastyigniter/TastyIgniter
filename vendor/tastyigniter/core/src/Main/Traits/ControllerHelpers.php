<?php

declare(strict_types=1);

namespace Igniter\Main\Traits;

use Igniter\Main\Helpers\MainHelper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

trait ControllerHelpers
{
    public function url(?string $path = null, array $params = []): string
    {
        if (is_null($path)) {
            return $this->currentPageUrl($params);
        }

        return URL::to($path, $params);
    }

    public function pageUrl(?string $path = null, array $params = []): string
    {
        if (is_null($path)) {
            return $this->currentPageUrl($params);
        }

        return MainHelper::pageUrl($path, $params);
    }

    public function currentPageUrl(array $params = []): string
    {
        return $this->pageUrl($this->page->getBaseFileName(), $params);
    }

    public function param(string $name, mixed $default = null): mixed
    {
        return $this->router->getParameter($name, $default);
    }

    public function refresh(): RedirectResponse
    {
        return Redirect::back();
    }

    public function redirect(string $path, int $status = 302, array $headers = [], ?bool $secure = null): RedirectResponse
    {
        return Redirect::to($path, $status, $headers, $secure);
    }

    public function redirectGuest(string $path, int $status = 302, array $headers = [], ?bool $secure = null): RedirectResponse
    {
        return Redirect::guest($path, $status, $headers, $secure);
    }

    public function redirectIntended(string $path, int $status = 302, array $headers = [], ?bool $secure = null): RedirectResponse
    {
        return Redirect::intended($path, $status, $headers, $secure);
    }

    public function redirectBack(): RedirectResponse
    {
        return Redirect::back();
    }
}
