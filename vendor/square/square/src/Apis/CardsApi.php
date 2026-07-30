<?php

declare(strict_types=1);

namespace Square\Apis;

use Core\Request\Parameters\BodyParam;
use Core\Request\Parameters\HeaderParam;
use Core\Request\Parameters\QueryParam;
use Core\Request\Parameters\TemplateParam;
use CoreInterfaces\Core\Request\RequestMethod;
use Square\Http\ApiResponse;
use Square\Models\CreateCardRequest;
use Square\Models\CreateCardResponse;
use Square\Models\DisableCardResponse;
use Square\Models\ListCardsResponse;
use Square\Models\RetrieveCardResponse;

class CardsApi extends BaseApi
{
    /**
     * Retrieves a list of cards owned by the account making the request.
     * A max of 25 cards will be returned.
     *
     * @param string|null $cursor A pagination cursor returned by a previous call to this endpoint.
     *        Provide this to retrieve the next set of results for your original query.
     *
     *        See [Pagination](https://developer.squareup.com/docs/build-basics/common-api-
     *        patterns/pagination) for more information.
     * @param string|null $customerId Limit results to cards associated with the customer supplied.
     *        By default, all cards owned by the merchant are returned.
     * @param bool|null $includeDisabled Includes disabled cards. By default, all enabled cards
     *        owned by the merchant are returned.
     * @param string|null $referenceId Limit results to cards associated with the reference_id
     *        supplied.
     * @param string|null $sortOrder Sorts the returned list by when the card was created with the
     *        specified order.
     *        This field defaults to ASC.
     *
     * @return ApiResponse Response from the API call
     */
    public function listCards(
        ?string $cursor = null,
        ?string $customerId = null,
        ?bool $includeDisabled = false,
        ?string $referenceId = null,
        ?string $sortOrder = null
    ): ApiResponse {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/cards')
            ->auth('global')
            ->parameters(
                QueryParam::init('cursor', $cursor),
                QueryParam::init('customer_id', $customerId),
                QueryParam::init('include_disabled', $includeDisabled),
                QueryParam::init('reference_id', $referenceId),
                QueryParam::init('sort_order', $sortOrder)
            );

        $_resHandler = $this->responseHandler()->type(ListCardsResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Adds a card on file to an existing merchant.
     *
     * @param CreateCardRequest $body An object containing the fields to POST for the request. See
     *        the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function createCard(CreateCardRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/cards')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()->type(CreateCardResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Retrieves details for a specific Card.
     *
     * @param string $cardId Unique ID for the desired Card.
     *
     * @return ApiResponse Response from the API call
     */
    public function retrieveCard(string $cardId): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/cards/{card_id}')
            ->auth('global')
            ->parameters(TemplateParam::init('card_id', $cardId));

        $_resHandler = $this->responseHandler()->type(RetrieveCardResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Disables the card, preventing any further updates or charges.
     * Disabling an already disabled card is allowed but has no effect.
     *
     * @param string $cardId Unique ID for the desired Card.
     *
     * @return ApiResponse Response from the API call
     */
    public function disableCard(string $cardId): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/cards/{card_id}/disable')
            ->auth('global')
            ->parameters(TemplateParam::init('card_id', $cardId));

        $_resHandler = $this->responseHandler()->type(DisableCardResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }
}
