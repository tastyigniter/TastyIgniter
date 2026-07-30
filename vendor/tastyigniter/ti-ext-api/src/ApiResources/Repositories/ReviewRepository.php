<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources\Repositories;

use Igniter\Api\Classes\AbstractRepository;
use Igniter\Local\Models\Review;

class ReviewRepository extends AbstractRepository
{
    protected ?string $modelClass = Review::class;

    protected static $locationAwareConfig = [];

    protected static $customerAwareConfig = [];
}
