<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources;

use Igniter\Api\ApiResources\Repositories\DiningTableRepository;
use Igniter\Api\ApiResources\Transformers\DiningTableTransformer;
use Igniter\Api\Classes\ApiController;
use Igniter\Api\Http\Actions\RestController;
use Igniter\Reservation\Http\Requests\DiningTableRequest;

/**
 * Tables API Controller
 */
class DiningTables extends ApiController
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
        'request' => DiningTableRequest::class,
        'repository' => DiningTableRepository::class,
        'transformer' => DiningTableTransformer::class,
    ];

    protected string|array $requiredAbilities = ['tables:*'];
}
