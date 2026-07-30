<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources\Repositories;

use Igniter\Admin\Models\Status;
use Igniter\Api\Classes\AbstractRepository;

class StatusRepository extends AbstractRepository
{
    protected ?string $modelClass = Status::class;

    protected static $locationAwareConfig = [];
}
