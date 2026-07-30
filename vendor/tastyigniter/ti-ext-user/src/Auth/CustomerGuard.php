<?php

declare(strict_types=1);

namespace Igniter\User\Auth;

use Igniter\User\Models\Customer;
use Illuminate\Auth\SessionGuard;

/**
 * Customer Class
 */
class CustomerGuard extends SessionGuard
{
    use GuardHelpers;

    /**
     * @var null|Customer
     */
    protected $user;

    public function customer()
    {
        return $this->user();
    }

    public function isLogged()
    {
        return $this->check();
    }

    public function getId()
    {
        return $this->user->customer_id;
    }

    public function getFullName()
    {
        return $this->user->full_name;
    }

    public function getFirstName()
    {
        return $this->user->first_name;
    }

    public function getLastName()
    {
        return $this->user->last_name;
    }

    public function getEmail(): string
    {
        return strtolower($this->user->email);
    }

    public function getTelephone()
    {
        return $this->user->telephone;
    }

    public function getAddressId()
    {
        return $this->user->address_id;
    }

    public function getGroupId()
    {
        return $this->user->customer_group_id;
    }
}
