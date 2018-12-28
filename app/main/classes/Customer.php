<?php namespace Main\Classes;

use Session;

/**
 * Customer Class
 *
 * @package Main
 */
class Customer extends \Igniter\Flame\Auth\Manager
{
    protected $sessionKey = 'customer_info';

    protected $model = 'Admin\Models\Customers_model';

    protected $identifier = 'email';

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

    //
    // Impersonation
    //

    /**
     * Impersonates the given user and sets properties
     * in the session but not the cookie.
     *
     * @param $userModel
     *
     * @throws \Exception
     */
    public function impersonate($userModel)
    {
        $oldSession = Session::get(static::AUTH_KEY_NAME);

        $this->login($userModel, FALSE);

        Session::put(static::AUTH_KEY_NAME.'_impersonate', $oldSession);
    }

    public function stopImpersonate()
    {
        $oldSession = Session::get(static::AUTH_KEY_NAME.'_impersonate');

        Session::put(static::AUTH_KEY_NAME, $oldSession);
    }

    public function isImpersonator()
    {
        return Session::has(static::AUTH_KEY_NAME.'_impersonate');
    }

    public function getImpersonator()
    {
        $impersonateArray = Session::get(static::AUTH_KEY_NAME.'_impersonate');

        // Check supplied session/cookie is an array (user id, persist code)
        if (!is_array($impersonateArray) OR count($impersonateArray) !== 2)
            return FALSE;

        $id = reset($impersonateArray);

        return $this->createModel()->find($id);
    }
}
