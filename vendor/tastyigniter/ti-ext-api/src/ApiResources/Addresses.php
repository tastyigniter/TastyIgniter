<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources;

use Igniter\Api\ApiResources\Repositories\AddressRepository;
use Igniter\Api\ApiResources\Requests\AddressRequest;
use Igniter\Api\ApiResources\Transformers\AddressTransformer;
use Igniter\Api\Classes\ApiController;
use Igniter\Api\Http\Actions\RestController;

/**
 * Addresses API Controller
 */
class Addresses extends ApiController
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
        'request' => AddressRequest::class,
        'repository' => AddressRepository::class,
        'transformer' => AddressTransformer::class,
        'resourceKey' => 'addresses',
    ];

    protected string|array $requiredAbilities = ['addresses:*'];
}
