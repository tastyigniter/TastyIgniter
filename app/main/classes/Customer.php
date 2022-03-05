<?php

namespace Main\Classes;

use Admin\Models\CustomerGroup;

/**
 * Customer Class
 */
class Customer extends \Igniter\Flame\Auth\Manager
{
    protected $sessionKey = 'customer_auth';

    protected $model = \Admin\Models\Customer::class;

    public function __construct()
    {
        $this->requireApproval = optional(CustomerGroup::getDefault())->requiresApproval() ?? $this->requireApproval;
    }

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

    public function getName()
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

    public function getEmail()
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

    /**
     * Registers a user by giving the required credentials
     *
     * @param array $credentials
     *
     * @param bool $activate
     * @return \Admin\Models\Customer
     * @throws \Exception
     */
    public function register(array $attributes, $activate = FALSE)
    {
        $model = $this->createModel();
        $model->fill($attributes);
        $model->save();

        if ($activate) {
            $model->completeActivation($model->getActivationCode());
        }

        // Prevents subsequent saves to this model object
        $model->password = null;

        return $this->user = $model;
    }

    public function extendUserQuery($query)
    {
        $query->isEnabled();
    }
}
