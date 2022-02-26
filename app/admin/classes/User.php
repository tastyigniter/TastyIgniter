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

    protected $model = 'Admin\Models\User';

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
     * @return \Admin\Models\Staff
     */
    public function staff()
    {
        throw new Exception('Deprecated method');
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
        $user->name = $attributes['name'] ?? null;
        $user->email = $attributes['email'] ?? null;
        $user->username = $attributes['username'];
        $user->password = $attributes['password'];
        $user->language_id = $attributes['language_id'] ?? null;
        $user->role_id = $attributes['role_id'] ?? null;
        $user->super_user = $attributes['super_user'] ?? FALSE;
        $user->activate = $activate;
        $user->status = $attributes['status'] ?? TRUE;

        $user->save();

        $user->groups()->attach($attributes['groups']);

        if (array_key_exists('locations', $attributes))
            $user->locations()->attach($attributes['locations']);

        return $user->reload()->user;
    }
}
