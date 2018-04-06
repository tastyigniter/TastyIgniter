<?php
//
//namespace Admin\Traits;
//
//use App;
//
///**
// * User Trait Class
// *
// * @package Admin
// */
//trait UserTrait
//{
//    protected $hasher;
//
//    /**
//     * Gets the hasher.
//     *
//     * @return \BcryptHash
//     */
//    public function getHasher()
//    {
//        return $this->hasher ?: App::make('hash');
//    }
//
//    /**
//     * Sets the hasher.
//     *
//     * @param  string $hasher
//     *
//     * @return $this
//     */
//    public function setHasher($hasher)
//    {
//        $this->hasher = $hasher;
//
//        return $this;
//    }
//
//    /**
//     * Get the name of the unique identifier for the user.
//     *
//     * @return string
//     */
//    public function getAuthIdentifierName()
//    {
//        return $this->getKeyName();
//    }
//
//    /**
//     * Get the unique identifier for the user.
//     *
//     * @return mixed
//     */
//    public function getAuthIdentifier()
//    {
//        $name = $this->getAuthIdentifierName();
//
//        return $this->attributes[$name];
//    }
//
//    /**
//     * Get the password for the user.
//     *
//     * @return string
//     */
//    public function getAuthPassword()
//    {
//        return $this->attributes['password'];
//    }
//
//    /**
//     * @param $identifier
//     */
//    public function getById($identifier)
//    {
//        return $this->newQuery()->find($identifier);
//    }
//
//    /**
//     * @param $identifier
//     * @param $token
//     *
//     * @return mixed
//     */
//    public function getByToken($identifier, $token)
//    {
//        return $this->newQuery()
//                    ->where($this->getAuthIdentifierName(), $identifier)
//                    ->where($this->getRememberTokenName(), $token)
//                    ->first();
//    }
//
//    /**
//     * @param array $credentials
//     */
//    public function getByCredentials(array $credentials)
//    {
//        if (empty($credentials))
//            return;
//
//        $query = $this->newQuery();
//
//        foreach ($credentials as $key => $value) {
//            if (!contains_substring($key, 'password')) {
//                $query->where($key, $value);
//            }
//        }
//
//        return $query->first();
//    }
//
//    /**
//     * @param $userModel
//     * @param $credentials
//     */
//    public function validateCredentials($userModel, $credentials)
//    {
//        $plain = $credentials['password'];
//
//        $hasher = $this->getHasher();
//
//        // Backward compatibility to turn SHA1 passwords to BCrypt
//        if ($userModel->hasShaPassword($plain)) {
//            $this->updateHashPassword($userModel, $hasher->make($plain));
//        }
//
//        return $hasher->check($plain, $userModel->getAuthPassword());
//    }
//
//    /**
//     * Get the token value for the "remember me" session.
//     */
//    public function getRememberToken()
//    {
//        return $this->attributes[$this->getRememberTokenName()];
//    }
//
//    /**
//     * Set the token value for the "remember me" session.
//     *
//     * @param string $token
//     */
//    public function setRememberToken($token)
//    {
//        $this->attributes[$this->getRememberTokenName()] = $token;
//    }
//
//    /**
//     * Get the column name for the "remember me" token.
//     */
//    public function getRememberTokenName()
//    {
//        return 'remember_token';
//    }
//
//    public function updateRememberToken($token)
//    {
//        $this->setRememberToken($token);
//        $this->save();
//    }
//
//    public function hasShaPassword($plainPassword)
//    {
//        $salt = $this->attributes['salt'];
//
//        if (is_null($salt))
//            return FALSE;
//
//        $hashedPassword = $this->attributes['password'];
//        $shaPassword = sha1($salt.sha1($salt.sha1($plainPassword)));
//
//        return ($hashedPassword === $shaPassword);
//    }
//
//    public function updateHashPassword($userModel, $hashedPassword)
//    {
//        $userModel->password = $hashedPassword;
//        $userModel->salt = null;
//        return $userModel->save();
//    }
//
//    public function createResetCode($userModel)
//    {
//        $email = $userModel->getReminderEmail();
//        $value = sha1($email.spl_object_hash($this).microtime(TRUE));
//
//        return hash_hmac('sha1', $value, $this->getHasher()->getHashKey());
//    }
//
//    /**
//     * Sets the reset password columns to NULL
//     *
//     * @param string $code
//     *
//     * @return bool
//     */
//    public function clearResetPasswordCode($code)
//    {
//        if (is_null($code))
//            return FALSE;
//
//        $query = $this->newQuery()->where('reset_code', $code);
//
//        if ($row = $query->isEnabled()->first()) {
//            $query->update([
//                'reset_code' => null,
//                'reset_time' => null,
//            ]);
//
//            return TRUE;
//        }
//
//        return FALSE;
//    }
//
//}