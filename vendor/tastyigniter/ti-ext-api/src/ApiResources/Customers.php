<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources;

use Igniter\Api\ApiResources\Repositories\CustomerRepository;
use Igniter\Api\ApiResources\Transformers\CustomerTransformer;
use Igniter\Api\Classes\ApiController;
use Igniter\Api\Http\Actions\RestController;
use Igniter\User\Http\Requests\CustomerRequest;
use Illuminate\Support\Facades\Request;

/**
 * Customers API Controller
 */
class Customers extends ApiController
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
        'request' => CustomerRequest::class,
        'repository' => CustomerRepository::class,
        'transformer' => CustomerTransformer::class,
    ];

    protected string|array $requiredAbilities = ['customers:*'];

    public function store()
    {
        if (($token = $this->getToken()) && $token->isForCustomer()) {
            Request::merge(['customer_id' => $token->tokenable_id]);
        }

        return $this->asExtension('RestController')->store();
    }
}
