<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources\Repositories;

use Igniter\Api\Classes\AbstractRepository;
use Igniter\Local\Models\LocationSettings;

class LocationSettingsRepository extends AbstractRepository
{
    protected ?string $modelClass = LocationSettings::class;
}
