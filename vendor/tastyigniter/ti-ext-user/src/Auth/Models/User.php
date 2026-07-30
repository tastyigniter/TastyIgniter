<?php

declare(strict_types=1);

namespace Igniter\User\Auth\Models;

use Exception;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Exception\SystemException;
use Igniter\User\Models\Notification;
use Illuminate\Auth\Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Override;

/**
 * User Model Class
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $email_verified_at
 * @property string $password
 * @property string|null $salt
 * @property string|null $remember_token
 * @property string|null $reset_code
 * @property Carbon|null $reset_time
 * @property string|null $activation_code
 * @property bool|null $is_activated
 * @property Carbon|null $activated_at
 * @property string|null $created_at
 * @property string|null $updated_at
 * @mixin Model
 */
abstract class User extends Model implements \Illuminate\Contracts\Auth\Authenticatable
{
    use Authenticatable;
    use HasApiTokens;
    use Notifiable;

    public const string REMEMBER_TOKEN_NAME = 'remember_token';

    protected static $resetExpiration = 1440;

    abstract public function beforeLogin(): void;

    abstract public function afterLogin(): void;

    abstract public function register(array $attributes, bool $activate): self;

    abstract public function extendUserQuery($query);

    /**
     * Get the column name for the "remember me" token.
     */
    #[Override]
    public function getRememberTokenName()
    {
        return static::REMEMBER_TOKEN_NAME;
    }

    public function updateRememberToken($token): void
    {
        $this->setRememberToken($token);
        $this->save();
    }

    /**
     * Checks the given remember token.
     * @param string $token
     * @return bool
     */
    public function checkRememberToken($token)
    {
        if (!$token || !$this->remember_token) {
            return false;
        }

        return $token == $this->remember_token;
    }

    public function updateLastSeen($expireAt): void
    {
        $this->newQuery()
            ->whereKey($this->getKey())
            ->update(['last_seen' => $expireAt]);
    }

    //
    // Password
    //

    //
    // Reset
    //

    /**
     * Reset a user password,
     */
    public function resetPassword()
    {
        $this->reset_code = $this->generateResetCode();
        $resetCode = $this->reset_code;
        $this->reset_time = Carbon::now();
        $this->save();

        return $resetCode;
    }

    /**
     * Generate a unique hash for this order.
     * @return string
     */
    protected function generateResetCode()
    {
        $random = str_random(42);
        while ($this->newQuery()->where('reset_code', $random)->count() > 0) {
            $random = str_random(42);
        }

        return $random;
    }

    /**
     * Sets the reset password columns to NULL
     */
    public function clearResetPasswordCode(): void
    {
        $this->reset_code = null;
        $this->reset_time = null;
        $this->save();
    }

    /**
     * Sets the new password on user requested reset
     *
     * @return bool
     * @throws Exception
     */
    public function completeResetPassword($code, $password)
    {
        if (!$this->checkResetPasswordCode($code)) {
            return false;
        }

        $this->password = Hash::make($password);
        $this->reset_time = null;
        $this->reset_code = null;

        return $this->save();
    }

    /**
     * Checks if the provided user reset password code is valid without actually resetting the password.
     *
     * @param string $resetCode
     */
    public function checkResetPasswordCode($resetCode): bool
    {
        if ($this->reset_code != $resetCode) {
            return false;
        }

        $expiration = self::$resetExpiration;
        if ($expiration > 0 && Carbon::now()->gte($this->reset_time->addMinutes($expiration))) {
            // Reset password request has expired, so clear code.
            $this->clearResetPasswordCode();

            return false;
        }

        return true;
    }

    //
    // Activation
    //

    public function getActivationCode()
    {
        $this->updateQuietly([
            'activation_code' => $this->activation_code = $this->generateActivationCode(),
            'activated_at' => null,
        ]);

        return $this->activation_code;
    }

    /**
     * Attempts to activate the given user by checking the activate code. If the user is activated already, an Exception is thrown.
     * @param string $activationCode
     */
    public function completeActivation($activationCode): bool
    {
        if ($this->is_activated) {
            throw new SystemException('User is already active!');
        }

        if ($activationCode == $this->activation_code) {
            $this->updateQuietly([
                'activation_code' => $this->activation_code = null,
                'is_activated' => $this->is_activated = true,
                'activated_at' => $this->activated_at = $this->freshTimestamp(),
            ]);

            return true;
        }

        return false;
    }

    protected function generateActivationCode()
    {
        $random = str_random(42);
        while ($this->newQuery()->where('activation_code', $random)->count() > 0) {
            $random = str_random(42);
        }

        return $random;
    }

    //
    //
    //

    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable')->latest();
    }
}
