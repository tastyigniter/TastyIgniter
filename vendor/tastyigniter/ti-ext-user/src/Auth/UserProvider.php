<?php

declare(strict_types=1);

namespace Igniter\User\Auth;

use Igniter\User\Auth\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;
use Override;

class UserProvider implements \Illuminate\Contracts\Auth\UserProvider
{
    /**
     * CustomerProvider constructor.
     */
    public function __construct(protected $config = null) {}

    #[Override]
    public function retrieveById($identifier): ?User
    {
        return $this->createModelQuery()->find($identifier);
    }

    #[Override]
    public function retrieveByToken($identifier, $token): ?User
    {
        $query = $this->createModelQuery();
        $model = $query->getModel();

        return $query
            ->where($model->getAuthIdentifierName(), $identifier)
            ->where($model->getRememberTokenName(), $token)
            ->first();
    }

    #[Override]
    public function updateRememberToken(Authenticatable $user, $token): void
    {
        /** @var User $user */
        $user->setRememberToken($token);

        $timestamps = $user->timestamps;

        $user->timestamps = false;

        $user->save();

        $user->timestamps = $timestamps;
    }

    #[Override]
    public function retrieveByCredentials(array $credentials): ?User
    {
        $query = $this->createModelQuery();

        foreach ($credentials as $key => $value) {
            if (!str_contains((string)$key, 'password')) {
                $query->where($key, $value);
            }
        }

        return $query->first();
    }

    #[Override]
    public function validateCredentials(Authenticatable $user, array $credentials): bool
    {
        if (is_null($plain = $credentials['password'])) {
            return false;
        }

        // Backward compatibility to turn SHA1 passwords to BCrypt
        if ($this->hasShaPassword($user, $credentials)) {
            /** @var User $user */
            $user->forceFill([
                $user->getAuthPasswordName() => Hash::make($credentials['password']),
                'salt' => null,
            ])->save();
        }

        return Hash::check($plain, $user->getAuthPassword());
    }

    public function hasShaPassword(Authenticatable $user, array $credentials): bool
    {
        /** @var User $user */
        if (is_null($user->salt)) {
            return false;
        }

        return $user->password === sha1($user->salt.sha1($user->salt.sha1((string)$credentials['password'])));
    }

    #[Override]
    public function rehashPasswordIfRequired(Authenticatable $user, array $credentials, bool $force = false): void
    {
        /** @var User $user */
        if (!Hash::needsRehash($user->getAuthPassword()) && !$force) {
            return;
        }

        $user->forceFill([
            $user->getAuthPasswordName() => Hash::make($credentials['password']),
        ])->save();
    }

    public function register(array $attributes, bool $activate = false): User
    {
        return $this->createModel()->register($attributes, $activate);
    }

    /**
     * Prepares a query derived from the user model.
     */
    protected function createModelQuery()
    {
        $model = $this->createModel();
        $query = $model->newQuery();

        $model->extendUserQuery($query);

        return $query;
    }

    protected function createModel(): User
    {
        return new $this->config['model'];
    }
}
