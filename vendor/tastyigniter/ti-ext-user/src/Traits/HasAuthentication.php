<?php

declare(strict_types=1);

namespace Igniter\User\Traits;

use Igniter\User\Facades\AdminAuth;
use Igniter\User\Models\User;
use Illuminate\Contracts\Auth\Access\Gate;

/**
 * Has Authentication Trait Class
 */
trait HasAuthentication
{
    protected ?User $currentUser = null;

    public function checkUser()
    {
        return AdminAuth::check();
    }

    public function setUser($currentUser): void
    {
        $this->currentUser = $currentUser;
    }

    public function getUser()
    {
        return $this->currentUser;
    }

    public function authorize($ability)
    {
        if (is_array($ability)) {
            $ability = implode(',', $ability);
        }

        return app(Gate::class)->inspect($ability)->allowed();
    }
}
