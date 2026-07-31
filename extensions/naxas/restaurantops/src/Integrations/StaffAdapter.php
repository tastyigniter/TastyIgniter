<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Integrations;

use Igniter\User\Models\User;

final class StaffAdapter extends OfficialModelAdapter
{
    public function modelClass(): string
    {
        return User::class;
    }
}
