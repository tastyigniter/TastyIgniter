<?php

declare(strict_types=1);

namespace Igniter\User\Models\Observers;

use Igniter\User\Models\User;

class UserObserver
{
    public function deleting(User $user): void
    {
        $user->groups()->detach();
        $user->locations()->detach();
    }

    public function saved(User $user): void
    {
        $user->restorePurgedValues();

        if ($user->status && is_null($user->is_activated)) {
            $user->completeActivation($user->getActivationCode());
        }
    }
}
