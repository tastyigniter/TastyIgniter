<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources;

use Igniter\Api\ApiResources\Repositories\MenuRepository;
use Igniter\Api\ApiResources\Transformers\MenuTransformer;
use Igniter\Api\Classes\ApiController;
use Igniter\Api\Http\Actions\RestController;
use Igniter\Cart\Http\Requests\MenuRequest;

/**
 * Menus API Controller
 */
class Menus extends ApiController
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
        'request' => MenuRequest::class,
        'repository' => MenuRepository::class,
        'transformer' => MenuTransformer::class,
    ];

    protected string|array $requiredAbilities = ['menus:*'];
}
