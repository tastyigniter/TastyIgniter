<?php

namespace Admin\Classes;

use Admin\Models\User as UserModel;
use Exception;
use Igniter\Flame\Auth\Manager;

/**
 * Admin User authentication manager
 */
class User extends Manager
{
    protected $sessionKey = 'admin_auth';

    protected $model = \Admin\Models\User::class;

    protected $isSuperUser = FALSE;

    public function isLogged()
    {
        return $this->check();
    }

    public function isSuperUser()
    {
        return $this->user()->isSuperUser();
    }

    /**
     * @return \Admin\Models\User
     */
    public function staff()
    {
        return $this->user();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function locations()
    {
        return $this->user()->locations;
    }

    //
    //
    //

    public function extendUserQuery($query)
    {
        $query
            ->with(['role', 'groups', 'locations'])
            ->isEnabled();
    }

    //
    //
    //

    public function getId()
    {
        return $this->user()->user_id;
    }

    public function getUserName()
    {
        return $this->user()->username;
    }

    public function getUserEmail()
    {
        return $this->user()->email;
    }

    public function getStaffId()
    {
        throw new Exception('Deprecated method');
    }

    public function getStaffName()
    {
        return $this->user()->name;
    }

    public function getStaffEmail()
    {
        return $this->user()->email;
    }

    public function register(array $attributes, $activate = FALSE)
    {
        $user = new UserModel;
        $user->name = array_get($attributes, 'name');
        $user->email = array_get($attributes, 'email');
        $user->username = array_get($attributes, 'username');
        $user->password = array_get($attributes, 'password');
        $user->language_id = array_get($attributes, 'language_id');
        $user->user_role_id = array_get($attributes, 'user_role_id');
        $user->super_user = array_get($attributes, 'super_user', FALSE);
        $user->status = array_get($attributes, 'status', TRUE);

        if ($activate) {
            $user->is_activated = TRUE;
            $user->date_activated = now();
        }

        $user->save();

        // Prevents subsequent saves to this model object
        $user->password = null;

        if (array_key_exists('groups', $attributes))
            $user->groups()->attach($attributes['groups']);

        if (array_key_exists('locations', $attributes))
            $user->locations()->attach($attributes['locations']);

        return $user->reload();
    }
}
