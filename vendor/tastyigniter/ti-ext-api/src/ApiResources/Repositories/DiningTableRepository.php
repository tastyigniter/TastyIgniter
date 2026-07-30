<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources\Repositories;

use Igniter\Api\Classes\AbstractRepository;
use Igniter\Reservation\Models\DiningTable;

class DiningTableRepository extends AbstractRepository
{
    protected ?string $modelClass = DiningTable::class;

    protected static $locationAwareConfig = [];
}
