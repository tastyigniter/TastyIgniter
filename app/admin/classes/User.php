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
     * @return \Admin\Models\Staffs_model
     */
    public function staff()
    {
        return $this->user()->staff;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function locations()
    {
        return $this->user()->staff->locations;
    }

    //
    //
    //

    public function extendUserQuery($query)
    {
        $query->with(['staff', 'staff.role', 'staff.groups', 'staff.locations']);
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
}
