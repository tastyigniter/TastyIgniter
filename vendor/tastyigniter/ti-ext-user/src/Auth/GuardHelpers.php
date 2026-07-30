<?php

declare(strict_types=1);

namespace Igniter\User\Auth;

use Igniter\User\Auth\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

/**
 * @mixin CustomerGuard
 * @mixin UserGuard
 */
trait GuardHelpers
{
    public function login(Authenticatable $user, $remember = false): void
    {
        /** @var User $user */
        $user->beforeLogin();

        parent::login($user, $remember);

        $user->afterLogin();
    }

    public function getById(int|string $identifier): ?User
    {
        return $this->getProvider()->retrieveById($identifier);
    }

    public function getByToken(int|string $identifier, string $token): ?User
    {
        return $this->getProvider()->retrieveByToken($identifier, $token);
    }

    public function getByCredentials(array $credentials): ?User
    {
        return $this->getProvider()->retrieveByCredentials($credentials);
    }

    public function validateCredentials(User $user, $credentials): bool
    {
        return $this->getProvider()->validateCredentials($user, $credentials);
    }

    //
    // Impersonation
    //

    /**
     * Impersonates the given user and sets properties
     * in the session but not the cookie.
     */
    public function impersonate(User $user): void
    {
        $oldUserId = $this->session->get($this->getName()) ?? 0;
        $oldUser = empty($oldUserId) ? null : $this->getById($oldUserId);

        $user->fireEvent('model.auth.beforeImpersonate', [$oldUser]);
        $this->login($user);

        if (!$this->isImpersonator()) {
            $this->session->put($this->getName().'_impersonate', $oldUserId);
        }
    }

    public function stopImpersonate(): void
    {
        $currentUserId = $this->session->get($this->getName()) ?? 0;
        $currentUser = empty($currentUserId) ? null : $this->getById($currentUserId);

        $oldUserId = $this->session->pull($this->getName().'_impersonate');
        $oldUser = empty($oldUserId) ? null : $this->getById($oldUserId);

        $currentUser?->fireEvent('model.auth.afterImpersonate', [$oldUser]);

        $this->session->remove($this->getName());

        if ($oldUser) {
            $this->login($oldUser);
        }
    }

    public function isImpersonator(): bool
    {
        return $this->session->has($this->getName().'_impersonate');
    }

    public function getImpersonator(): ?User
    {
        // Check supplied session/cookie is an array (user id, persist code)
        if (!$userId = $this->session->get($this->getName().'_impersonate')) {
            return null;
        }

        return $this->getById($userId);
    }
}
