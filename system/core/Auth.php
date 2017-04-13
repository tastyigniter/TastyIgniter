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
 * @since File available since Release 2.2
 */
namespace Igniter\Core;

use Exception;

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Auth Class
 *
 * Adapted from Ion Auth.
 * @link https://github.com/benedmunds/CodeIgniter-Ion-Auth
 *
 * @category       Core
 * @package        Igniter\Core\Auth.php
 * @link           http://docs.tastyigniter.com
 */
class Auth
{

    /**
     * @var object The currently authenticated user.
     */
    protected $user;

    /**
     * @var object The hash implementation
     */
    protected $hasher;

    /**
     * @var string The user model to use
     */
    protected $model;

    /**
     * @var string The model identifier column (username or email)
     */
    protected $identifier;

    /**
     * @var bool Indicates if the logout method has been called.
     */
    protected $loggedOut;

    /**
     * Indicates if a token user retrieval has been attempted.
     *
     * @var bool
     */
    protected $tokenRetrievalAttempted = FALSE;

    /**
     * @var string Number of seconds the reset password request expires,
     * Set to 0 to next expire
     **/
    protected $_reset_expiration;

    /**
     * Class Constructor
     */
    public function __construct()
    {
        $this->load->helper('cookie');
        $config = $this->config->load('auth', TRUE);

        if (!empty($config)) foreach ($config as $key => $val) {
            if (property_exists($this, '_'.$key))
                $this->{'_'.$key} = $val;
        }
    }

    /*
     * Auth Methods
     */

    /**
     * Determine if the current user is authenticated.
     */
    public function check()
    {
        return !is_null($this->user());
    }

    /**
     * Determine if the current user is a guest.
     */
    public function guest()
    {
        return !$this->check();
    }

    /**
     * Get the currently authenticated user.
     */
    public function user()
    {
        if ($this->loggedOut)
            return;

        if (!is_null($this->user))
            return $this->user;

        $user = null;

        // Load the user using session identifier
        $id = $this->getSessionUserId();

        $model = $this->createModel();
        if (!is_null($id))
            $user = $model->getById($id);

        // If no user is found in session,
        // load the user using cookie token
        $rememberCookie = $this->getRememberCookie();

        if (is_null($user) AND $rememberCookie) {
            $user = $this->getUserByRememberCookie($rememberCookie);

            if ($user) {
                $this->updateSession($user->getAuthIdentifier());
            }
        }

        $this->user = $user;

        return $this->user;
    }

    /**
     * Get the ID for the currently authenticated user.
     *
     * @return int|null
     */
    public function id()
    {
        if ($this->loggedOut)
            return;

        $id = $this->getSessionUserId();
        if (is_null($id) AND $this->user()) {
            $id = $this->user()->getAuthIdentifier();
        }

        return $id;
    }

    /**
     * Get the currently authenticated user model.
     * @return object
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the current user model
     *
     * @param $userModel
     */
    public function setUser($userModel)
    {
        $this->user = $userModel;
    }

    /**
     * Validate a user using the given credentials.
     *
     * @param array $credentials
     * @param bool $remember
     * @param bool $login
     *
     * @return bool
     */
    public function validate(array $credentials = [], $remember = FALSE, $login = TRUE)
    {
        $model = $this->createModel();

        $userModel = $model->getByCredentials($credentials);

        // Validate the user against the given credentials,
        // if valid log the user into the application
        if (!is_null($userModel) AND $model->validateCredentials($userModel, $credentials)) {
            if ($login)
                $this->login($userModel, $remember);

            return TRUE;
        }

        return FALSE;
    }

    /**
     * Log a user into the application without sessions or cookies.
     *
     * @param array $credentials
     */
    public function loginOnce($credentials = [])
    {
    }

    /**
     * Log a user into the application.
     *
     * @param $userModel
     * @param bool $remember
     */
    public function login($userModel, $remember = FALSE)
    {
        $this->updateSession($userModel);

        // If the user should be permanently "remembered" by the application.
        if ($remember) {
            $this->createRememberToken($userModel);
            $this->rememberUser($userModel);
        }

        $this->setUser($userModel);
    }

    /**
     * Log the given user ID into the application.
     *
     * @param $id
     * @param bool $remember
     *
     * @return mixed
     */
    public function loginUsingId($id, $remember = FALSE)
    {
        $userModel = $this->provider->retrieveById($id);
        $this->login($userModel, $remember);

        return $userModel;
    }

    /**
     * Log the user out of the application.
     *
     * @return void
     * @author Mathew
     **/
    public function logout()
    {
        $user = $this->user();

        // delete the remember me cookies if they exist
        if (!is_null($this->user))
            $this->refreshRememberToken($user);

        $this->clearUserDataFromStorage();

        $this->user = null;

        $this->loggedOut = TRUE;
    }

    /**
     * Check whether authenticated user belongs to a group
     *
     * @param mixed group(s) to check
     * @param bool user id
     * @param bool check if all groups is present, or any of the groups
     *
     * @return bool
     * @author Phil Sturgeon
     **/
    public function inGroup($check_group, $id = FALSE, $check_all = FALSE)
    {
        $this->ion_auth_model->trigger_events('in_group');

        $id || $id = $this->session->userdata('user_id');

        if (!is_array($check_group)) {
            $check_group = [$check_group];
        }

        if (isset($this->_cache_user_in_group[$id])) {
            $groups_array = $this->_cache_user_in_group[$id];
        } else {
            $users_groups = $this->ion_auth_model->get_users_groups($id)->result();
            $groups_array = [];
            foreach ($users_groups as $group) {
                $groups_array[$group->id] = $group->name;
            }
            $this->_cache_user_in_group[$id] = $groups_array;
        }
        foreach ($check_group as $key => $value) {
            $groups = (is_string($value)) ? $groups_array : array_keys($groups_array);

            /**
             * if !all (default), in_array
             * if all, !in_array
             */
            if (in_array($value, $groups) xor $check_all) {
                /**
                 * if !all (default), true
                 * if all, false
                 */
                return !$check_all;
            }
        }

        /**
         * if !all (default), false
         * if all, true
         */
        return $check_all;
    }

    /*
     * Session & Cookie
     */

    /**
     * @return mixed
     */
    public function getSessionUserId()
    {
        $sessionArray = $this->getSessionArray();

        return isset($sessionArray['id']) ? $sessionArray['id'] : null;
    }

    public function getSessionArray()
    {
        $sessionData = $this->session->userdata($this->getSessionName());

        if (is_null($sessionData))
            return [];

        $sessionData = base64_decode($sessionData);

        return unserialize($sessionData);
    }

    public function getSessionName()
    {
        return strtolower(get_class($this)).'_info';
    }

    protected function updateSession($userModel)
    {
        $id = $userModel->getAuthIdentifier();
        $identityName = $userModel->getAuthIdentifierName();

        $sessionData = base64_encode(serialize([
            'id'              => $id,
            $identityName     => $id,
            $this->identifier => $userModel->{$this->identifier},
            'last_check'      => time(),
        ]));

        $this->session->set_userdata($this->getSessionName(), $sessionData);
    }

    /**
     * @param $userModel
     */
    protected function refreshRememberToken($userModel)
    {
        $userModel->setRememberToken($token = random_string(60));

        $this->createModel()->updateRememberToken($userModel, $token);
    }

    /**
     * Create a new "remember me" token for the user
     * if one doesn't already exist.
     *
     * @param $userModel
     */
    protected function createRememberToken($userModel)
    {
        if (empty($userModel->getRememberToken())) {
            $this->refreshRememberToken($userModel);
        }
    }

    /**
     * Get the decrypted remember cookie for the request.
     *
     * @return string|null
     */
    protected function getRememberCookie()
    {
        return get_cookie($this->getRememberCookieName());
    }

    /**
     * Get the user ID from the remember cookie.
     *
     * @return string|null
     */
    protected function getRememberCookieId()
    {
        if ($this->validateRememberCookie($rememberCookie = $this->getRememberCookie())) {
            return reset(explode('|', $rememberCookie));
        }
    }

    /**
     * Determine if the remember cookie is in a valid format.
     *
     * @param  string $cookie
     *
     * @return bool
     */
    protected function validateRememberCookie($cookie)
    {
        if (!is_string($cookie) OR strpos($cookie, '|') === FALSE)
            return FALSE;

        $segments = explode('|', $cookie);

        return count($segments) == 2 AND !empty(trim($segments[0])) AND !empty(trim($segments[1]));
    }

    /**
     * Pull a user from the repository by its recaller ID.
     *
     * @param  string $rememberCookie
     *
     * @return mixed
     */
    protected function getUserByRememberCookie($rememberCookie)
    {
        if ($this->validateRememberCookie($rememberCookie) AND !$this->tokenRetrievalAttempted) {
            $this->tokenRetrievalAttempted = TRUE;
            list($id, $token) = explode('|', $rememberCookie, 2);
            $user = $this->createModel()->getByToken($id, $token);

            return $user;
        }
    }

    /**
     *
     */
    protected function getRememberCookieName()
    {
        return 'remember_'.strtolower(get_class($this)).'_info';
    }

    /**
     * Create a "remember me" cookie for a given ID.
     *
     * @param  object $userModel
     */
    protected function rememberUser($userModel)
    {
        $value = $userModel->getAuthIdentifier().'|'.$userModel->getRememberToken();
        set_cookie($this->getRememberCookieName(), $value);
    }

    /**
     * Remove the user data from the session and cookies.
     *
     * @return void
     */
    protected function clearUserDataFromStorage()
    {
        $this->session->unset_userdata($this->getSessionName());

        if (!is_null($this->getRememberCookie())) {
            $rememberCookie = $this->getRememberCookieName();
            delete_cookie($rememberCookie);
        }
    }

    /*
     * Model
     */

    /**
     * Create a new instance of the model
     * if it doesn't already exist.
     *
     * @return mixed
     */
    public function createModel()
    {
        if (!class_exists($this->model, FALSE))
            $this->load->model($this->model);

        return $this->{$this->model};
    }

    /**
     * Gets the name of the user model
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Sets the name of the user model
     *
     * @param $model
     *
     * @return $this
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /*
     * Reset Password
     */

    /**
     * Reset password feature
     *
     * @param string $identity The user email
     *
     * @return bool|array
     */
    public function resetPassword($identity)
    {
        $model = $this->createModel();

        // Reset the user password and send email link
        if ($model->resetPassword($identity)) {

            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Validate a password reset for the given credentials.
     *
     * @param $credentials
     *
     * @return bool
     */
    public function validateResetPassword($credentials)
    {
        $userModel = $this->createModel()->getByCredentials($credentials);

        if (is_null($userModel))
            return FALSE;

        $token = $credentials['reset_code'];

        if (!$userModel) {
            return FALSE;
        } else {
            $expiration = $this->_reset_expiration;
            if ($expiration > 0) {
                if ((time() - strtotime($userModel->reset_time)) > $expiration) {
                    // Reset password request has expired, so clear code.
                    $this->createModel()->clearResetPasswordCode($token);

                    return FALSE;
                }
            }

            return $userModel;
        }
    }

    /**
     * Complete a password reset request
     *
     * @param $credentials
     *
     * @return bool
     */
    public function completeResetPassword($credentials)
    {
        $userModel = $this->validateResetPassword($credentials);

        if (!$userModel)
            return FALSE;

        if ($this->createModel()->completeResetPassword($userModel->getAuthIdentifier(), $credentials))
            return TRUE;

        return FALSE;
    }

    /*
     * Magic! Magic!! Magic!!!
     */

    /**
     * Dynamically call the model methods.
     *
     * @param $method
     * @param $arguments
     *
     * @return mixed
     * @throws Exception
     */
    public function __call($method, $arguments)
    {
//        $userModel = $this->getUser();
//        if (!is_null($userModel) AND !method_exists($userModel, $method)) {
//            throw new Exception("Undefined method {$this->getModel()}::{$method}() called");
//        }
//
//        return call_user_func_array([$userModel, $method], $arguments);
    }

    /**
     * Dynamically access the model's attributes or CI super-global.
     *
     * @param    $var
     *
     * @return    mixed
     */
    public function __get($var)
    {
//        $model = $this->createModel();
//        if (!is_null($model) AND isset($model->attributes[$var]))
//            return $model->attributes[$var];
//
        return get_instance()->$var;
    }

}