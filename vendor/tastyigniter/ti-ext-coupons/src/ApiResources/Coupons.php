<?php

declare(strict_types=1);

namespace Igniter\Coupons\ApiResources;

use Igniter\Api\Classes\ApiController;
use Igniter\Api\Http\Actions\RestController;
use Igniter\Coupons\ApiResources\Repositories\CouponsRepository;
use Igniter\Coupons\ApiResources\Transformers\CouponsTransformer;
use Igniter\Coupons\Http\Requests\CouponRequest;

/**
 * Coupons API Controller
 */
class Coupons extends ApiController
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
        'request' => CouponRequest::class,
        'repository' => CouponsRepository::class,
        'transformer' => CouponsTransformer::class,
    ];

    protected string|array $requiredAbilities = ['coupons:*'];
}
