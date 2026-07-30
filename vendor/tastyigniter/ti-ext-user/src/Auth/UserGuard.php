<?php

declare(strict_types=1);

namespace Igniter\User\Auth;

use Igniter\User\Models\User;
use Illuminate\Auth\SessionGuard;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;

/**
 * User Class
 */
class UserGuard extends SessionGuard
{
    use GuardHelpers;

    /**
     * @var null|User
     */
    protected $user;

    public function isLogged()
    {
        return $this->check();
    }

    public function isSuperUser()
    {
        return $this->user?->isSuperUser();
    }

    public function staff(): User|Authenticatable|null
    {
        return $this->user();
    }

    /**
     * @return Collection
     */
    public function locations()
    {
        return $this->user?->locations;
    }

    //
    //
    //

    public function getId()
    {
        return $this->id();
    }

    public function getUserName()
    {
        return $this->user?->username;
    }

    public function getUserEmail()
    {
        return $this->user?->email;
    }

    public function getStaffName()
    {
        return $this->user?->name;
    }

    public function getStaffEmail()
    {
        return $this->user?->email;
    }
}
