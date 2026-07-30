<?php

declare(strict_types=1);

namespace Square\Apis;

use Core\Request\Parameters\BodyParam;
use Core\Request\Parameters\HeaderParam;
use Core\Request\Parameters\QueryParam;
use Core\Request\Parameters\TemplateParam;
use CoreInterfaces\Core\Request\RequestMethod;
use Square\Http\ApiResponse;
use Square\Models\CancelInvoiceRequest;
use Square\Models\CancelInvoiceResponse;
use Square\Models\CreateInvoiceRequest;
use Square\Models\CreateInvoiceResponse;
use Square\Models\DeleteInvoiceResponse;
use Square\Models\GetInvoiceResponse;
use Square\Models\ListInvoicesResponse;
use Square\Models\PublishInvoiceRequest;
use Square\Models\PublishInvoiceResponse;
use Square\Models\SearchInvoicesRequest;
use Square\Models\SearchInvoicesResponse;
use Square\Models\UpdateInvoiceRequest;
use Square\Models\UpdateInvoiceResponse;

class InvoicesApi extends BaseApi
{
    /**
     * Returns a list of invoices for a given location. The response
     * is paginated. If truncated, the response includes a `cursor` that you
     * use in a subsequent request to retrieve the next set of invoices.
     *
     * @param string $locationId The ID of the location for which to list invoices.
     * @param string|null $cursor A pagination cursor returned by a previous call to this endpoint.
     *        Provide this cursor to retrieve the next set of results for your original query.
     *
     *        For more information, see [Pagination](https://developer.squareup.com/docs/working-
     *        with-apis/pagination).
     * @param int|null $limit The maximum number of invoices to return (200 is the maximum `limit`).
     *        If not provided, the server uses a default limit of 100 invoices.
     *
     * @return ApiResponse Response from the API call
     */
    public function listInvoices(string $locationId, ?string $cursor = null, ?int $limit = null): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/invoices')
            ->auth('global')
            ->parameters(
                QueryParam::init('location_id', $locationId),
                QueryParam::init('cursor', $cursor),
                QueryParam::init('limit', $limit)
            );

        $_resHandler = $this->responseHandler()->type(ListInvoicesResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Creates a draft [invoice]($m/Invoice)
     * for an order created using the Orders API.
     *
     * A draft invoice remains in your account and no action is taken.
     * You must publish the invoice before Square can process it (send it to the customer's email address
     * or charge the customer’s card on file).
     *
     * @param CreateInvoiceRequest $body An object containing the fields to POST for the request.
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function createInvoice(CreateInvoiceRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/invoices')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()->type(CreateInvoiceResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Searches for invoices from a location specified in
     * the filter. You can optionally specify customers in the filter for whom to
     * retrieve invoices. In the current implementation, you can only specify one location and
     * optionally one customer.
     *
     * The response is paginated. If truncated, the response includes a `cursor`
     * that you use in a subsequent request to retrieve the next set of invoices.
     *
     * @param SearchInvoicesRequest $body An object containing the fields to POST for the request.
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function searchInvoices(SearchInvoicesRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/invoices/search')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()->type(SearchInvoicesResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Deletes the specified invoice. When an invoice is deleted, the
     * associated order status changes to CANCELED. You can only delete a draft
     * invoice (you cannot delete a published invoice, including one that is scheduled for processing).
     *
     * @param string $invoiceId The ID of the invoice to delete.
     * @param int|null $version The version of the [invoice](entity:Invoice) to delete. If you do
     *        not know the version, you can call [GetInvoice](api-endpoint:Invoices-GetInvoice) or
     *        [ListInvoices](api-endpoint:Invoices-ListInvoices).
     *
     * @return ApiResponse Response from the API call
     */
    public function deleteInvoice(string $invoiceId, ?int $version = null): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::DELETE, '/v2/invoices/{invoice_id}')
            ->auth('global')
            ->parameters(TemplateParam::init('invoice_id', $invoiceId), QueryParam::init('version', $version));

        $_resHandler = $this->responseHandler()->type(DeleteInvoiceResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Retrieves an invoice by invoice ID.
     *
     * @param string $invoiceId The ID of the invoice to retrieve.
     *
     * @return ApiResponse Response from the API call
     */
    public function getInvoice(string $invoiceId): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/invoices/{invoice_id}')
            ->auth('global')
            ->parameters(TemplateParam::init('invoice_id', $invoiceId));

        $_resHandler = $this->responseHandler()->type(GetInvoiceResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Updates an invoice by modifying fields, clearing fields, or both. For most updates, you can use a
     * sparse
     * `Invoice` object to add fields or change values and use the `fields_to_clear` field to specify
     * fields to clear.
     * However, some restrictions apply. For example, you cannot change the `order_id` or `location_id`
     * field and you
     * must provide the complete `custom_fields` list to update a custom field. Published invoices have
     * additional restrictions.
     *
     * @param string $invoiceId The ID of the invoice to update.
     * @param UpdateInvoiceRequest $body An object containing the fields to POST for the request.
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function updateInvoice(string $invoiceId, UpdateInvoiceRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::PUT, '/v2/invoices/{invoice_id}')
            ->auth('global')
            ->parameters(
                TemplateParam::init('invoice_id', $invoiceId),
                HeaderParam::init('Content-Type', 'application/json'),
                BodyParam::init($body)
            );

        $_resHandler = $this->responseHandler()->type(UpdateInvoiceResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Cancels an invoice. The seller cannot collect payments for
     * the canceled invoice.
     *
     * You cannot cancel an invoice in the `DRAFT` state or in a terminal state: `PAID`, `REFUNDED`,
     * `CANCELED`, or `FAILED`.
     *
     * @param string $invoiceId The ID of the [invoice](entity:Invoice) to cancel.
     * @param CancelInvoiceRequest $body An object containing the fields to POST for the request.
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function cancelInvoice(string $invoiceId, CancelInvoiceRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/invoices/{invoice_id}/cancel')
            ->auth('global')
            ->parameters(
                TemplateParam::init('invoice_id', $invoiceId),
                HeaderParam::init('Content-Type', 'application/json'),
                BodyParam::init($body)
            );

        $_resHandler = $this->responseHandler()->type(CancelInvoiceResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Publishes the specified draft invoice.
     *
     * After an invoice is published, Square
     * follows up based on the invoice configuration. For example, Square
     * sends the invoice to the customer's email address, charges the customer's card on file, or does
     * nothing. Square also makes the invoice available on a Square-hosted invoice page.
     *
     * The invoice `status` also changes from `DRAFT` to a status
     * based on the invoice configuration. For example, the status changes to `UNPAID` if
     * Square emails the invoice or `PARTIALLY_PAID` if Square charge a card on file for a portion of the
     * invoice amount.
     *
     * @param string $invoiceId The ID of the invoice to publish.
     * @param PublishInvoiceRequest $body An object containing the fields to POST for the request.
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function publishInvoice(string $invoiceId, PublishInvoiceRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/invoices/{invoice_id}/publish')
            ->auth('global')
            ->parameters(
                TemplateParam::init('invoice_id', $invoiceId),
                HeaderParam::init('Content-Type', 'application/json'),
                BodyParam::init($body)
            );

        $_resHandler = $this->responseHandler()->type(PublishInvoiceResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }
}
