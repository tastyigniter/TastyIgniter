<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Integrations;

use Igniter\Reservation\Models\Reservation;

final class ReservationAdapter extends OfficialModelAdapter
{
    public function modelClass(): string
    {
        return Reservation::class;
    }
}
