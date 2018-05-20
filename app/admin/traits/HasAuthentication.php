<?php namespace Admin\Traits;

use AdminAuth;
use Model;

/**
 * Has Authentication Trait Class
 *
 * @package Admin
 */
trait HasAuthentication
{
    /**
     * @var bool If TRUE, this class requires the user to be logged in before
     * accessing any method.
     */
    protected $requireAuthentication = TRUE;

    /**
     * @var \Admin\Models\Users_model Stores the logged in admin user model.
     */
    protected $currentUser;

    public function checkUser()
    {
        return AdminAuth::check();
    }

    public function setUser($currentUser)
    {
        $this->currentUser = $currentUser;
    }

    public function getUser()
    {
        return $this->currentUser;
    }
}

