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
namespace Igniter\Traits;

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User Trait Class
 *
 * @package Igniter\Traits
 * @author TastyIgniter Dev Team
 * @link https://docs.tastyigniter.com
 */
trait UserTrait
{
    protected $hasher = 'bcrypthash';

    /**
     * Gets the hasher.
     *
     * @return \BcryptHash
     */
    public function getHasher()
    {
        if (!isset($this->{$this->hasher}))
            $this->load->library($this->hasher);

        return $this->{$this->hasher};
    }

    /**
     * Sets the hasher.
     *
     * @param  string $hasher
     *
     * @return $this
     */
    public function setHasher($hasher)
    {
        $this->hasher = $hasher;

        return $this;
    }

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return $this->primaryKey;
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        $name = $this->getAuthIdentifierName();

        return $this->attributes[$name];
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->attributes['password'];
    }

    /**
     * @param $identifier
     */
    public function getById($identifier)
    {
        return $this->newQuery()->find($identifier);
    }

    /**
     * @param $identifier
     * @param $token
     *
     * @return mixed
     */
    public function getByToken($identifier, $token)
    {
        return $this->newQuery()
                    ->where($this->getAuthIdentifierName(), $identifier)
                    ->where($this->getRememberTokenName(), $token)
                    ->first();
    }

    /**
     * @param array $credentials
     */
    public function getByCredentials(array $credentials)
    {
        if (empty($credentials))
            return;

        $query = $this->newQuery();

        foreach ($credentials as $key => $value) {
            if (!contains_substring($key, 'password')) {
                $query->where($key, $value);
            }
        }

        return $query->first();
    }

    /**
     * @param $userModel
     * @param $credentials
     */
    public function validateCredentials($userModel, $credentials)
    {
        $plain = $credentials['password'];

        $hasher = $this->getHasher();

        // Backward compatibility to turn SHA1 passwords to BCrypt
        if ($userModel->hasShaPassword($plain)) {
            $this->updateHashPassword($userModel, $hasher->make($plain));
        }

        return $hasher->check($plain, $userModel->getAuthPassword());
    }

    /**
     * Get the token value for the "remember me" session.
     */
    public function getRememberToken()
    {
        return $this->attributes[$this->getRememberTokenName()];
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param string $token
     */
    public function setRememberToken($token)
    {
        $this->attributes[$this->getRememberTokenName()] = $token;
    }

    /**
     * Get the column name for the "remember me" token.
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    public function updateRememberToken($userModel, $token)
    {
        $userModel->setRememberToken($token);
        $userModel->save();
    }

    public function hasShaPassword($plainPassword)
    {
        $salt = $this->attributes['salt'];

        if (is_null($salt))
            return FALSE;

        $hashedPassword = $this->attributes['password'];
        $shaPassword = sha1($salt.sha1($salt.sha1($plainPassword)));

        return ($hashedPassword === $shaPassword);
    }

    public function updateHashPassword($userModel, $hashedPassword)
    {
        return $userModel->save([
            'password' => $hashedPassword,
            'salt'     => null,
        ]);
    }

    public function createResetCode($userModel)
    {
        $email = $userModel->getReminderEmail();
        $value = sha1($email.spl_object_hash($this).microtime(TRUE));

        return hash_hmac('sha1', $value, $this->getHasher()->getHashKey());
    }

    /**
     * Sets the reset password columns to NULL
     *
     * @param string $code
     *
     * @return bool
     */
    public function clearResetPasswordCode($code)
    {
        if (is_null($code))
            return FALSE;

        $query = $this->newQuery()->where('reset_code', $code);

        if ($row = $query->isEnabled()->firstAsArray()) {
            $query->update([
                'reset_code' => null,
                'reset_time' => null,
            ]);

            return TRUE;
        }

        return FALSE;
    }

}