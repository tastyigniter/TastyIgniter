<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources;

use Igniter\Api\ApiResources\Repositories\ReservationRepository;
use Igniter\Api\ApiResources\Requests\ReservationRequest;
use Igniter\Api\ApiResources\Requests\StatusRequest;
use Igniter\Api\ApiResources\Transformers\ReservationTransformer;
use Igniter\Api\Classes\ApiController;
use Igniter\Api\Http\Actions\RestController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Reservations API Controller
 */
class Reservations extends ApiController
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
            'updateStatus' => [],
        ],
        'request' => ReservationRequest::class,
        'repository' => ReservationRepository::class,
        'transformer' => ReservationTransformer::class,
    ];

    protected string|array $requiredAbilities = ['reservations:*'];

    public function updateStatus(StatusRequest $request, int $reservationId): Response
    {
        throw_if(
            ($token = $this->getToken()) && $token->isForCustomer(),
            new AccessDeniedHttpException('Customers are not allowed to update reservation status.')
        );

        $data = $request->validated();

        $reservation = app(ReservationRepository::class)->find($reservationId);

        $data['staff_id'] = $this->user()->getKey();

        $reservation->addStatusHistory((int) $data['status_id'], array_only($data, ['comment', 'notify', 'staff_id']));

        $response = $this->fractal()
            ->item($reservation->refresh())
            ->transformWith(new ReservationTransformer)
            ->withResourceName('reservations')
            ->toArray();

        return response()->json($response);
    }
}
