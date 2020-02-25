<?php namespace Admin\Classes;

use Igniter\Flame\Auth\Manager;

/**
 * Admin User authentication manager
 * @package Admin
 */
class User extends Manager
{
    protected $sessionKey = 'admin_info';

    protected $model = 'Admin\Models\Users_model';

    protected $groupModel = 'Admin\Models\Staff_groups_model';

    protected $identifier = 'username';

    protected $isSuperUser = FALSE;

    public function isLogged()
    {
        return $this->check();
    }

    public function isSuperUser()
    {
        return $this->user()->isSuperUser();
    }

    public function canImpersonateCustomer()
    {
        return $this->isSuperUser() OR $this->staffGroup()->customer_account_access;
    }

    /**
     * @return \Admin\Models\Staffs_model
     */
    public function staff()
    {
        return $this->user()->staff;
    }

    /**
     * @return \Admin\Models\Staff_groups_model
     */
    public function staffGroup()
    {
        return $this->staff()->group;
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
        $query->with(['staff', 'staff.group', 'staff.locations']);
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

    public function getStaffGroupId()
    {
        return $this->staffGroup()->staff_group_id;
    }

    public function getStaffGroupName()
    {
        return $this->staffGroup()->staff_group_name;
    }
}