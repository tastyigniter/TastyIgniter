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
     * @var Model Stores the logged in admin user model.
     */
    protected $currentUser;

    /**
     * Class constructor
     *
     */
//    public function __construct()
//    {
//        $this->libraries[] = 'user';
//
//        parent::__construct();
//
//        if (!$this->user OR !class_exists(get_class($this->user), FALSE))
//            throw new SystemException('User library class must be loaded to use Authentication.');
//
//        // Ensures that a user is logged in, if required
//        if ($this->requireAuthentication) {
//            $this->setUser();
//        }
//
//        log_message('info', 'Authenticated Controller Class Initialized');
//    }

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

