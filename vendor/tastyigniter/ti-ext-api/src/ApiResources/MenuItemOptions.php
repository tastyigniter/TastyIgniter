<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources;

use Igniter\Api\ApiResources\Repositories\MenuItemOptionRepository;
use Igniter\Api\ApiResources\Requests\MenuItemOptionRequest;
use Igniter\Api\ApiResources\Transformers\MenuItemOptionTransformer;
use Igniter\Api\Classes\ApiController;
use Igniter\Api\Http\Actions\RestController;

/**
 * Options API Controller
 */
class MenuItemOptions extends ApiController
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
        'request' => MenuItemOptionRequest::class,
        'repository' => MenuItemOptionRepository::class,
        'transformer' => MenuItemOptionTransformer::class,
    ];

    protected string|array $requiredAbilities = ['menu_item_options:*'];
}
