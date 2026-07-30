<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources;

use Igniter\Api\ApiResources\Repositories\CurrencyRepository;
use Igniter\Api\ApiResources\Transformers\CurrencyTransformer;
use Igniter\Api\Classes\ApiController;
use Igniter\Api\Http\Actions\RestController;
use Igniter\System\Http\Requests\CurrencyRequest;

/**
 * Currencies API Controller
 */
class Currencies extends ApiController
{
    public array $implement = [RestController::class];

    public $restConfig = [
        'actions' => [
            'index' => [
                'pageLimit' => 20,
            ],
        ],
        'request' => CurrencyRequest::class,
        'repository' => CurrencyRepository::class,
        'transformer' => CurrencyTransformer::class,
    ];

    protected string|array $requiredAbilities = ['currencies:*'];
}
