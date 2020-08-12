<?php

namespace Main\Classes;

/**
 * Customer Class
 */
class Customer extends \Igniter\Flame\Auth\Manager
{
    protected $sessionKey = 'customer_auth';

    protected $model = 'Admin\Models\Customers_model';

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
     * @return \Admin\Models\Customers_model
     * @throws \Exception
     */
    public function register(array $credentials, $activate = FALSE)
    {
        $model = $this->createModel();
        $model->fill($credentials);
        $model->save();

        if ($activate) {
            $model->completeActivation($model->getActivationCode());
        }

        // Prevents subsequent saves to this model object
        $model->password = null;

        return $this->user = $model;
    }
}
