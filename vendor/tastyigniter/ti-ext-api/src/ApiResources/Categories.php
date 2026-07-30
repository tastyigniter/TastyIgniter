<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources;

use Igniter\Api\ApiResources\Repositories\CategoryRepository;
use Igniter\Api\ApiResources\Transformers\CategoryTransformer;
use Igniter\Api\Classes\ApiController;
use Igniter\Api\Http\Actions\RestController;
use Igniter\Cart\Http\Requests\CategoryRequest;

/**
 * Categories API Controller
 */
class Categories extends ApiController
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
        'request' => CategoryRequest::class,
        'repository' => CategoryRepository::class,
        'transformer' => CategoryTransformer::class,
    ];

    protected string|array $requiredAbilities = ['categories:*'];
}
