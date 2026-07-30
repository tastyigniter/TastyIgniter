<?php

declare(strict_types=1);

namespace Igniter\Admin\Traits;

use Igniter\Admin\Helpers\AdminHelper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

trait ControllerHelpers
{
    public function pageUrl(?string $path = null, array $parameters = [], ?bool $secure = null): string
    {
        return AdminHelper::url($path, $parameters, $secure);
    }

    public function redirect(?string $path = null, int $status = 302, array $headers = [], ?bool $secure = null): RedirectResponse
    {
        return AdminHelper::redirect($path, $status, $headers, $secure);
    }

    public function redirectGuest(?string $path = null, int $status = 302, array $headers = [], ?bool $secure = null): RedirectResponse
    {
        return AdminHelper::redirectGuest($path, $status, $headers, $secure);
    }

    public function redirectIntended(?string $path = null, int $status = 302, array $headers = [], ?bool $secure = null): RedirectResponse
    {
        return AdminHelper::redirectIntended($path, $status, $headers, $secure);
    }

    public function redirectBack(int $status = 302, array $headers = [], mixed $fallback = false): RedirectResponse
    {
        return Redirect::back($status, $headers, AdminHelper::url($fallback ?: 'dashboard'));
    }

    public function refresh(): RedirectResponse
    {
        return Redirect::back();
    }
}
