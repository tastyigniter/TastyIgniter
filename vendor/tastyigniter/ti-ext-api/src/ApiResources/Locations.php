<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources;

use Igniter\Api\ApiResources\Repositories\LocationRepository;
use Igniter\Api\ApiResources\Transformers\LocationTransformer;
use Igniter\Api\Classes\ApiController;
use Igniter\Api\Http\Actions\RestController;
use Igniter\Local\Http\Requests\LocationRequest;

/**
 * Locations API Controller
 */
class Locations extends ApiController
{
    public array $implement = [RestController::class];

    public $restConfig = [
        'actions' => [
            'index' => [
                'pageLimit' => 20,
            ],
            'store' => [],
            'show' => [],
            'update' => [],
            'destroy' => [],
        ],
        'request' => LocationRequest::class,
        'repository' => LocationRepository::class,
        'transformer' => LocationTransformer::class,
    ];

    protected string|array $requiredAbilities = ['locations:*'];
}
