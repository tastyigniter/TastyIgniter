<?php

declare(strict_types=1);

namespace Square\Apis;

use Core\Request\Parameters\QueryParam;
use Core\Request\Parameters\TemplateParam;
use CoreInterfaces\Core\Request\RequestMethod;
use Square\Http\ApiResponse;
use Square\Models\CaptureTransactionResponse;
use Square\Models\ListTransactionsResponse;
use Square\Models\RetrieveTransactionResponse;
use Square\Models\VoidTransactionResponse;

class TransactionsApi extends BaseApi
{
    /**
     * Lists transactions for a particular location.
     *
     * Transactions include payment information from sales and exchanges and refund
     * information from returns and exchanges.
     *
     * Max results per [page](https://developer.squareup.com/docs/working-with-apis/pagination): 50
     *
     * @deprecated
     *
     * @param string $locationId The ID of the location to list transactions for.
     * @param string|null $beginTime The beginning of the requested reporting period, in RFC 3339
     *        format.
     *
     *        See [Date ranges](https://developer.squareup.com/docs/build-basics/working-with-
     *        dates) for details on date inclusivity/exclusivity.
     *
     *        Default value: The current time minus one year.
     * @param string|null $endTime The end of the requested reporting period, in RFC 3339 format.
     *        See [Date ranges](https://developer.squareup.com/docs/build-basics/working-with-
     *        dates) for details on date inclusivity/exclusivity.
     *
     *        Default value: The current time.
     * @param string|null $sortOrder The order in which results are listed in the response (`ASC`
     *        for
     *        oldest first, `DESC` for newest first).
     *
     *        Default value: `DESC`
     * @param string|null $cursor A pagination cursor returned by a previous call to this endpoint.
     *        Provide this to retrieve the next set of results for your original query.
     *
     *        See [Paginating results](https://developer.squareup.com/docs/working-with-
     *        apis/pagination) for more information.
     *
     * @return ApiResponse Response from the API call
     */
    public function listTransactions(
        string $locationId,
        ?string $beginTime = null,
        ?string $endTime = null,
        ?string $sortOrder = null,
        ?string $cursor = null
    ): ApiResponse {
        trigger_error('Method ' . __METHOD__ . ' is deprecated.', E_USER_DEPRECATED);

        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/locations/{location_id}/transactions')
            ->auth('global')
            ->parameters(
                TemplateParam::init('location_id', $locationId),
                QueryParam::init('begin_time', $beginTime),
                QueryParam::init('end_time', $endTime),
                QueryParam::init('sort_order', $sortOrder),
                QueryParam::init('cursor', $cursor)
            );

        $_resHandler = $this->responseHandler()->type(ListTransactionsResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Retrieves details for a single transaction.
     *
     * @deprecated
     *
     * @param string $locationId The ID of the transaction's associated location.
     * @param string $transactionId The ID of the transaction to retrieve.
     *
     * @return ApiResponse Response from the API call
     */
    public function retrieveTransaction(string $locationId, string $transactionId): ApiResponse
    {
        trigger_error('Method ' . __METHOD__ . ' is deprecated.', E_USER_DEPRECATED);

        $_reqBuilder = $this->requestBuilder(
            RequestMethod::GET,
            '/v2/locations/{location_id}/transactions/{transaction_id}'
        )
            ->auth('global')
            ->parameters(
                TemplateParam::init('location_id', $locationId),
                TemplateParam::init('transaction_id', $transactionId)
            );

        $_resHandler = $this->responseHandler()->type(RetrieveTransactionResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Captures a transaction that was created with the [Charge](api-endpoint:Transactions-Charge)
     * endpoint with a `delay_capture` value of `true`.
     *
     *
     * See [Delayed capture transactions](https://developer.squareup.
     * com/docs/payments/transactions/overview#delayed-capture)
     * for more information.
     *
     * @deprecated
     *
     * @param string $locationId
     * @param string $transactionId
     *
     * @return ApiResponse Response from the API call
     */
    public function captureTransaction(string $locationId, string $transactionId): ApiResponse
    {
        trigger_error('Method ' . __METHOD__ . ' is deprecated.', E_USER_DEPRECATED);

        $_reqBuilder = $this->requestBuilder(
            RequestMethod::POST,
            '/v2/locations/{location_id}/transactions/{transaction_id}/capture'
        )
            ->auth('global')
            ->parameters(
                TemplateParam::init('location_id', $locationId),
                TemplateParam::init('transaction_id', $transactionId)
            );

        $_resHandler = $this->responseHandler()->type(CaptureTransactionResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Cancels a transaction that was created with the [Charge](api-endpoint:Transactions-Charge)
     * endpoint with a `delay_capture` value of `true`.
     *
     *
     * See [Delayed capture transactions](https://developer.squareup.
     * com/docs/payments/transactions/overview#delayed-capture)
     * for more information.
     *
     * @deprecated
     *
     * @param string $locationId
     * @param string $transactionId
     *
     * @return ApiResponse Response from the API call
     */
    public function voidTransaction(string $locationId, string $transactionId): ApiResponse
    {
        trigger_error('Method ' . __METHOD__ . ' is deprecated.', E_USER_DEPRECATED);

        $_reqBuilder = $this->requestBuilder(
            RequestMethod::POST,
            '/v2/locations/{location_id}/transactions/{transaction_id}/void'
        )
            ->auth('global')
            ->parameters(
                TemplateParam::init('location_id', $locationId),
                TemplateParam::init('transaction_id', $transactionId)
            );

        $_resHandler = $this->responseHandler()->type(VoidTransactionResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }
}
