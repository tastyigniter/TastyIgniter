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

    public function getId()
    {
        return $this->fromModel('user_id', 'user');
    }

    public function getUserName()
    {
        return $this->fromModel('username', 'user');
    }

    public function getStaffId()
    {
        return $this->fromModel('staff_id', 'user');
    }

    public function getStaffName()
    {
        return $this->fromModel('staff_name', 'staff');
    }

    public function getStaffEmail()
    {
        return $this->fromModel('staff_email', 'staff');
    }

    public function getLocationId()
    {
        return $this->fromModel('staff_location_id', 'staff', params('default_location_id'));
    }

    public function getLocationName()
    {
        return $this->fromModel('location_name', 'location');
    }

    public function staffGroupName()
    {
        return $this->fromModel('staff_group_name', 'group');
    }

    public function location()
    {
        return $this->staff()->location;
    }

    public function staffGroup()
    {
        return $this->user()->staff->group;
    }

    public function staff()
    {
        return $this->user()->staff;
    }

    public function getStaffGroupId()
    {
        return $this->fromModel('staff_group_id', 'staff');
    }

    public function canAccessCustomerAccount()
    {
        return $this->isSuperUser() OR $this->fromModel('customer_account_access', 'group');
    }

    public function isStrictLocation()
    {
        return (is_single_location() OR $this->user()->hasStrictLocationAccess());
    }

    protected function fromModel($key, $related = null, $default = null)
    {
        $user = $this->user();

        switch ($related) {
            case 'staff':
                return $user->staff[$key] ?? $default;
            case 'group':
                return $user->staff->group[$key] ?? $default;
            case 'location':
                return $user->staff->location[$key] ?? $default;
            default:
                return $user[$key] ?? $default;
        }
    }
}