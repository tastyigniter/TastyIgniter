<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources;

use Igniter\Admin\Http\Requests\StatusRequest;
use Igniter\Api\ApiResources\Repositories\StatusRepository;
use Igniter\Api\ApiResources\Transformers\StatusTransformer;
use Igniter\Api\Classes\ApiController;
use Igniter\Api\Http\Actions\RestController;

class Status extends ApiController
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
        'request' => StatusRequest::class,
        'repository' => StatusRepository::class,
        'transformer' => StatusTransformer::class,
    ];

    protected string|array $requiredAbilities = ['status:*'];
}
