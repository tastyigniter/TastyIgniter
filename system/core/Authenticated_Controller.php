<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package Igniter
 * @author Samuel Adepoyigi
 * @copyright (c) 2013 - 2016. Samuel Adepoyigi
 * @copyright (c) 2016 - 2017. TastyIgniter Dev Team
 * @link https://tastyigniter.com
 * @license http://opensource.org/licenses/MIT The MIT License
 * @since File available since Release 1.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Authenticated Controller Class
 *
 * @category       Libraries
 * @package        Igniter\Core\Authenticated_Controller.php
 * @link           http://docs.tastyigniter.com
 */
class Authenticated_Controller extends BaseController
{
    /**
     * @var bool If TRUE, this class requires the user to be logged in before
     * accessing any method.
     */
    protected $authentication = FALSE;

    /**
     * @var object Stores the logged in admin user.
     */
    protected $current_user;

    /**
     * Class constructor
     *
     */
    public function __construct()
    {
        $this->libraries[] = 'user';

        parent::__construct();

        // Ensures that a user is logged in, if required
        if ($this->authentication) {
            $this->setUser();
        }

        log_message('info', 'Authenticated Controller Class Initialized');
    }

    protected function setUser()
    {
        if (class_exists('User', FALSE)) {
            // Load the currently logged-in user for convenience
            if ($this->user->auth() AND $this->user->isLogged()) {
                $this->current_user = $this->user;
            }
        }
    }
}

/* End of file Authenticated_Controller.php */
/* Location: ./system/tastyigniter/core/Authenticated_Controller.php */
