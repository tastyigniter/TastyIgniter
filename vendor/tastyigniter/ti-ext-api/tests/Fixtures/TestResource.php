<?php

declare(strict_types=1);

namespace Igniter\Api\Tests\Fixtures;

use Igniter\Api\Classes\ApiController;
use Igniter\Api\Http\Actions\RestController;

class TestResource extends ApiController
{
    public array $implement = [RestController::class];

    public array $restConfig = [
        'actions' => [],
        'repository' => TestRepository::class,
        'transformer' => TestTransformer::class,
    ];
}
