<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources;

use Igniter\Api\ApiResources\Repositories\ReviewRepository;
use Igniter\Api\ApiResources\Transformers\ReviewTransformer;
use Igniter\Api\Classes\ApiController;
use Igniter\Api\Http\Actions\RestController;
use Igniter\Local\Http\Requests\ReviewRequest;

/**
 * Reviews API Controller
 */
class Reviews extends ApiController
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
        'request' => ReviewRequest::class,
        'repository' => ReviewRepository::class,
        'transformer' => ReviewTransformer::class,
    ];

    protected string|array $requiredAbilities = ['reviews:*'];
}
