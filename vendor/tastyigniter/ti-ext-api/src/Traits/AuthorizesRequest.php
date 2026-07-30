<?php

declare(strict_types=1);

namespace Igniter\Api\Traits;

trait AuthorizesRequest
{
    /**
     * Get the authenticated token.
     *
     * @return mixed
     */
    protected function token()
    {
        return request()->user()->currentAccessToken();
    }

    /**
     * Get the authenticated user.
     *
     * @return mixed
     */
    protected function user()
    {
        return request()->user();
    }

    protected function auth()
    {
        return app('auth');
    }

    protected function getToken()
    {
        return $this->token();
    }

    protected function tokenCan($ability = '*')
    {
        return request()->user()->tokenCan($ability);
    }
}
