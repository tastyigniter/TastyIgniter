<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources;

use Igniter\Api\ApiResources\Repositories\LocationSettingsRepository;
use Igniter\Api\ApiResources\Requests\LocationSettingsRequest;
use Igniter\Api\ApiResources\Transformers\LocationSettingsTransformer;
use Igniter\Api\Classes\ApiController;
use Igniter\Api\Http\Actions\RestController;

/**
 * LocationSettings API Controller
 */
class LocationSettings extends ApiController
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
        'request' => LocationSettingsRequest::class,
        'repository' => LocationSettingsRepository::class,
        'transformer' => LocationSettingsTransformer::class,
    ];

    protected string|array $requiredAbilities = ['location_settings:*'];
}
