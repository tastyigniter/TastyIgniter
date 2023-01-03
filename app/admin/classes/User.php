<?php

namespace Admin\Classes;

use Igniter\Flame\Auth\Manager;

/**
 * Admin User authentication manager
 */
class User extends Manager
{
    protected $sessionKey = 'admin_auth';

    protected $model = 'Admin\Models\Users_model';

    protected $isSuperUser = false;

    public function isLogged()
    {
        return $this->check();
    }

    public function isSuperUser()
    {
        return $this->user()->isSuperUser();
    }

    /**
     * @return \Admin\Models\Staffs_model
     */
    public function staff()
    {
        return optional($this->user())->staff;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function locations()
    {
        return optional($this->staff())->locations;
    }

    //
    //
    //

    public function extendUserQuery($query)
    {
        $query
            ->with(['staff', 'staff.role', 'staff.groups', 'staff.locations'])
            ->whereHas('staff', function ($query) {
                $query->where('staff_status', true);
            });
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
        return $this->staff()->staff_id;
    }

    public function getStaffName()
    {
        return $this->staff()->staff_name;
    }

    public function getStaffEmail()
    {
        return $this->staff()->staff_email;
    }

    public function register(array $attributes, $activate = false)
    {
        $model = $this->createModel();

        $staff = $model->staff()->getModel()->newInstance();
        $staff->staff_email = $attributes['staff_email'];
        $staff->staff_name = $attributes['staff_name'];
        $staff->language_id = $attributes['language_id'] ?? null;
        $staff->staff_role_id = $attributes['staff_role_id'] ?? null;
        $staff->staff_status = $attributes['staff_status'] ?? true;
        $staff->user = [
            'username' => $attributes['username'],
            'password' => $attributes['password'],
            'super_user' => $attributes['super_user'] ?? false,
            'activate' => $activate,
        ];

        $staff->save();

        $staff->groups()->attach($attributes['groups']);

        if (array_key_exists('locations', $attributes))
            $staff->locations()->attach($attributes['locations']);

        return $staff->reload()->user;
    }
}
