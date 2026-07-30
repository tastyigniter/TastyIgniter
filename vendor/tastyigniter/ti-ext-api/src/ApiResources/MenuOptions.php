<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources;

use Igniter\Api\ApiResources\Repositories\MenuOptionRepository;
use Igniter\Api\ApiResources\Requests\MenuOptionRequest;
use Igniter\Api\ApiResources\Transformers\MenuOptionTransformer;
use Igniter\Api\Classes\ApiController;
use Igniter\Api\Http\Actions\RestController;

/**
 * Options API Controller
 */
class MenuOptions extends ApiController
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
        'request' => MenuOptionRequest::class,
        'repository' => MenuOptionRepository::class,
        'transformer' => MenuOptionTransformer::class,
    ];

    protected string|array $requiredAbilities = ['menu_options:*'];
}
