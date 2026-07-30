<?php

declare(strict_types=1);

namespace Square\Apis;

use Core\Request\Parameters\BodyParam;
use Core\Request\Parameters\HeaderParam;
use CoreInterfaces\Core\Request\RequestMethod;
use Square\Http\ApiResponse;
use Square\Models\RegisterDomainRequest;
use Square\Models\RegisterDomainResponse;

class ApplePayApi extends BaseApi
{
    /**
     * Activates a domain for use with Apple Pay on the Web and Square. A validation
     * is performed on this domain by Apple to ensure that it is properly set up as
     * an Apple Pay enabled domain.
     *
     * This endpoint provides an easy way for platform developers to bulk activate
     * Apple Pay on the Web with Square for merchants using their platform.
     *
     * Note: The SqPaymentForm library is deprecated as of May 13, 2021, and will only receive critical
     * security updates until it is retired on October 31, 2022.
     * You must migrate your payment form code to the Web Payments SDK to continue using your domain for
     * Apple Pay. For more information on migrating to the Web Payments SDK, see [Migrate to the Web
     * Payments SDK](https://developer.squareup.com/docs/web-payments/migrate).
     *
     * To learn more about the Web Payments SDK and how to add Apple Pay, see [Take an Apple Pay
     * Payment](https://developer.squareup.com/docs/web-payments/apple-pay).
     *
     * @param RegisterDomainRequest $body An object containing the fields to POST for the request.
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function registerDomain(RegisterDomainRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/apple-pay/domains')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()->type(RegisterDomainResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }
}
