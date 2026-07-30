<?php

declare(strict_types=1);

namespace Square\Apis;

use Core\Request\Parameters\BodyParam;
use Core\Request\Parameters\HeaderParam;
use Core\Request\Parameters\QueryParam;
use Core\Request\Parameters\TemplateParam;
use CoreInterfaces\Core\Request\RequestMethod;
use Square\Http\ApiResponse;
use Square\Models\AccumulateLoyaltyPointsRequest;
use Square\Models\AccumulateLoyaltyPointsResponse;
use Square\Models\AdjustLoyaltyPointsRequest;
use Square\Models\AdjustLoyaltyPointsResponse;
use Square\Models\CalculateLoyaltyPointsRequest;
use Square\Models\CalculateLoyaltyPointsResponse;
use Square\Models\CancelLoyaltyPromotionResponse;
use Square\Models\CreateLoyaltyAccountRequest;
use Square\Models\CreateLoyaltyAccountResponse;
use Square\Models\CreateLoyaltyPromotionRequest;
use Square\Models\CreateLoyaltyPromotionResponse;
use Square\Models\CreateLoyaltyRewardRequest;
use Square\Models\CreateLoyaltyRewardResponse;
use Square\Models\DeleteLoyaltyRewardResponse;
use Square\Models\ListLoyaltyProgramsResponse;
use Square\Models\ListLoyaltyPromotionsResponse;
use Square\Models\RedeemLoyaltyRewardRequest;
use Square\Models\RedeemLoyaltyRewardResponse;
use Square\Models\RetrieveLoyaltyAccountResponse;
use Square\Models\RetrieveLoyaltyProgramResponse;
use Square\Models\RetrieveLoyaltyPromotionResponse;
use Square\Models\RetrieveLoyaltyRewardResponse;
use Square\Models\SearchLoyaltyAccountsRequest;
use Square\Models\SearchLoyaltyAccountsResponse;
use Square\Models\SearchLoyaltyEventsRequest;
use Square\Models\SearchLoyaltyEventsResponse;
use Square\Models\SearchLoyaltyRewardsRequest;
use Square\Models\SearchLoyaltyRewardsResponse;

class LoyaltyApi extends BaseApi
{
    /**
     * Creates a loyalty account. To create a loyalty account, you must provide the `program_id` and a
     * `mapping` with the `phone_number` of the buyer.
     *
     * @param CreateLoyaltyAccountRequest $body An object containing the fields to POST for the
     *        request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function createLoyaltyAccount(CreateLoyaltyAccountRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/loyalty/accounts')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()->type(CreateLoyaltyAccountResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Searches for loyalty accounts in a loyalty program.
     *
     * You can search for a loyalty account using the phone number or customer ID associated with the
     * account. To return all loyalty accounts, specify an empty `query` object or omit it entirely.
     *
     * Search results are sorted by `created_at` in ascending order.
     *
     * @param SearchLoyaltyAccountsRequest $body An object containing the fields to POST for the
     *        request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function searchLoyaltyAccounts(SearchLoyaltyAccountsRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/loyalty/accounts/search')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()->type(SearchLoyaltyAccountsResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Retrieves a loyalty account.
     *
     * @param string $accountId The ID of the [loyalty account](entity:LoyaltyAccount) to retrieve.
     *
     * @return ApiResponse Response from the API call
     */
    public function retrieveLoyaltyAccount(string $accountId): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/loyalty/accounts/{account_id}')
            ->auth('global')
            ->parameters(TemplateParam::init('account_id', $accountId));

        $_resHandler = $this->responseHandler()->type(RetrieveLoyaltyAccountResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Adds points earned from a purchase to a [loyalty account]($m/LoyaltyAccount).
     *
     * - If you are using the Orders API to manage orders, provide the `order_id`. Square reads the order
     * to compute the points earned from both the base loyalty program and an associated
     * [loyalty promotion]($m/LoyaltyPromotion). For purchases that qualify for multiple accrual
     * rules, Square computes points based on the accrual rule that grants the most points.
     * For purchases that qualify for multiple promotions, Square computes points based on the most
     * recently created promotion. A purchase must first qualify for program points to be eligible for
     * promotion points.
     *
     * - If you are not using the Orders API to manage orders, provide `points` with the number of points
     * to add.
     * You must first perform a client-side computation of the points earned from the loyalty program and
     * loyalty promotion. For spend-based and visit-based programs, you can call
     * [CalculateLoyaltyPoints]($e/Loyalty/CalculateLoyaltyPoints)
     * to compute the points earned from the base loyalty program. For information about computing points
     * earned from a loyalty promotion, see
     * [Calculating promotion points](https://developer.squareup.com/docs/loyalty-api/loyalty-
     * promotions#calculate-promotion-points).
     *
     * @param string $accountId The ID of the target [loyalty account](entity:LoyaltyAccount).
     * @param AccumulateLoyaltyPointsRequest $body An object containing the fields to POST for the
     *        request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function accumulateLoyaltyPoints(string $accountId, AccumulateLoyaltyPointsRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/loyalty/accounts/{account_id}/accumulate')
            ->auth('global')
            ->parameters(
                TemplateParam::init('account_id', $accountId),
                HeaderParam::init('Content-Type', 'application/json'),
                BodyParam::init($body)
            );

        $_resHandler = $this->responseHandler()->type(AccumulateLoyaltyPointsResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Adds points to or subtracts points from a buyer's account.
     *
     * Use this endpoint only when you need to manually adjust points. Otherwise, in your application flow,
     * you call
     * [AccumulateLoyaltyPoints]($e/Loyalty/AccumulateLoyaltyPoints)
     * to add points when a buyer pays for the purchase.
     *
     * @param string $accountId The ID of the target [loyalty account](entity:LoyaltyAccount).
     * @param AdjustLoyaltyPointsRequest $body An object containing the fields to POST for the
     *        request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function adjustLoyaltyPoints(string $accountId, AdjustLoyaltyPointsRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/loyalty/accounts/{account_id}/adjust')
            ->auth('global')
            ->parameters(
                TemplateParam::init('account_id', $accountId),
                HeaderParam::init('Content-Type', 'application/json'),
                BodyParam::init($body)
            );

        $_resHandler = $this->responseHandler()->type(AdjustLoyaltyPointsResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Searches for loyalty events.
     *
     * A Square loyalty program maintains a ledger of events that occur during the lifetime of a
     * buyer's loyalty account. Each change in the point balance
     * (for example, points earned, points redeemed, and points expired) is
     * recorded in the ledger. Using this endpoint, you can search the ledger for events.
     *
     * Search results are sorted by `created_at` in descending order.
     *
     * @param SearchLoyaltyEventsRequest $body An object containing the fields to POST for the
     *        request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function searchLoyaltyEvents(SearchLoyaltyEventsRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/loyalty/events/search')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()->type(SearchLoyaltyEventsResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Returns a list of loyalty programs in the seller's account.
     * Loyalty programs define how buyers can earn points and redeem points for rewards. Square sellers can
     * have only one loyalty program, which is created and managed from the Seller Dashboard. For more
     * information, see [Loyalty Program Overview](https://developer.squareup.com/docs/loyalty/overview).
     *
     *
     * Replaced with [RetrieveLoyaltyProgram](api-endpoint:Loyalty-RetrieveLoyaltyProgram) when used with
     * the keyword `main`.
     *
     * @deprecated
     *
     * @return ApiResponse Response from the API call
     */
    public function listLoyaltyPrograms(): ApiResponse
    {
        trigger_error('Method ' . __METHOD__ . ' is deprecated.', E_USER_DEPRECATED);

        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/loyalty/programs')->auth('global');

        $_resHandler = $this->responseHandler()->type(ListLoyaltyProgramsResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Retrieves the loyalty program in a seller's account, specified by the program ID or the keyword
     * `main`.
     *
     * Loyalty programs define how buyers can earn points and redeem points for rewards. Square sellers can
     * have only one loyalty program, which is created and managed from the Seller Dashboard. For more
     * information, see [Loyalty Program Overview](https://developer.squareup.com/docs/loyalty/overview).
     *
     * @param string $programId The ID of the loyalty program or the keyword `main`. Either value
     *        can be used to retrieve the single loyalty program that belongs to the seller.
     *
     * @return ApiResponse Response from the API call
     */
    public function retrieveLoyaltyProgram(string $programId): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/loyalty/programs/{program_id}')
            ->auth('global')
            ->parameters(TemplateParam::init('program_id', $programId));

        $_resHandler = $this->responseHandler()->type(RetrieveLoyaltyProgramResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Calculates the number of points a buyer can earn from a purchase. Applications might call this
     * endpoint
     * to display the points to the buyer.
     *
     * - If you are using the Orders API to manage orders, provide the `order_id` and (optional)
     * `loyalty_account_id`.
     * Square reads the order to compute the points earned from the base loyalty program and an associated
     * [loyalty promotion]($m/LoyaltyPromotion).
     *
     * - If you are not using the Orders API to manage orders, provide `transaction_amount_money` with the
     * purchase amount. Square uses this amount to calculate the points earned from the base loyalty
     * program,
     * but not points earned from a loyalty promotion. For spend-based and visit-based programs, the
     * `tax_mode`
     * setting of the accrual rule indicates how taxes should be treated for loyalty points accrual.
     * If the purchase qualifies for program points, call
     * [ListLoyaltyPromotions]($e/Loyalty/ListLoyaltyPromotions) and perform a client-side computation
     * to calculate whether the purchase also qualifies for promotion points. For more information, see
     * [Calculating promotion points](https://developer.squareup.com/docs/loyalty-api/loyalty-
     * promotions#calculate-promotion-points).
     *
     * @param string $programId The ID of the [loyalty program](entity:LoyaltyProgram), which
     *        defines the rules for accruing points.
     * @param CalculateLoyaltyPointsRequest $body An object containing the fields to POST for the
     *        request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function calculateLoyaltyPoints(string $programId, CalculateLoyaltyPointsRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/loyalty/programs/{program_id}/calculate')
            ->auth('global')
            ->parameters(
                TemplateParam::init('program_id', $programId),
                HeaderParam::init('Content-Type', 'application/json'),
                BodyParam::init($body)
            );

        $_resHandler = $this->responseHandler()->type(CalculateLoyaltyPointsResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Lists the loyalty promotions associated with a [loyalty program]($m/LoyaltyProgram).
     * Results are sorted by the `created_at` date in descending order (newest to oldest).
     *
     * @param string $programId The ID of the base [loyalty program](entity:LoyaltyProgram). To get
     *        the program ID,
     *        call [RetrieveLoyaltyProgram](api-endpoint:Loyalty-RetrieveLoyaltyProgram) using the
     *        `main` keyword.
     * @param string|null $status The status to filter the results by. If a status is provided, only
     *        loyalty promotions
     *        with the specified status are returned. Otherwise, all loyalty promotions associated
     *        with
     *        the loyalty program are returned.
     * @param string|null $cursor The cursor returned in the paged response from the previous call
     *        to this endpoint.
     *        Provide this cursor to retrieve the next page of results for your original request.
     *        For more information, see [Pagination](https://developer.squareup.com/docs/build-
     *        basics/common-api-patterns/pagination).
     * @param int|null $limit The maximum number of results to return in a single paged response.
     *        The minimum value is 1 and the maximum value is 30. The default value is 30.
     *        For more information, see [Pagination](https://developer.squareup.com/docs/build-
     *        basics/common-api-patterns/pagination).
     *
     * @return ApiResponse Response from the API call
     */
    public function listLoyaltyPromotions(
        string $programId,
        ?string $status = null,
        ?string $cursor = null,
        ?int $limit = null
    ): ApiResponse {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/loyalty/programs/{program_id}/promotions')
            ->auth('global')
            ->parameters(
                TemplateParam::init('program_id', $programId),
                QueryParam::init('status', $status),
                QueryParam::init('cursor', $cursor),
                QueryParam::init('limit', $limit)
            );

        $_resHandler = $this->responseHandler()->type(ListLoyaltyPromotionsResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Creates a loyalty promotion for a [loyalty program]($m/LoyaltyProgram). A loyalty promotion
     * enables buyers to earn points in addition to those earned from the base loyalty program.
     *
     * This endpoint sets the loyalty promotion to the `ACTIVE` or `SCHEDULED` status, depending on the
     * `available_time` setting. A loyalty program can have a maximum of 10 loyalty promotions with an
     * `ACTIVE` or `SCHEDULED` status.
     *
     * @param string $programId The ID of the [loyalty program](entity:LoyaltyProgram) to associate
     *        with the promotion.
     *        To get the program ID, call [RetrieveLoyaltyProgram](api-endpoint:Loyalty-
     *        RetrieveLoyaltyProgram)
     *        using the `main` keyword.
     * @param CreateLoyaltyPromotionRequest $body An object containing the fields to POST for the
     *        request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function createLoyaltyPromotion(string $programId, CreateLoyaltyPromotionRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/loyalty/programs/{program_id}/promotions')
            ->auth('global')
            ->parameters(
                TemplateParam::init('program_id', $programId),
                HeaderParam::init('Content-Type', 'application/json'),
                BodyParam::init($body)
            );

        $_resHandler = $this->responseHandler()->type(CreateLoyaltyPromotionResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Retrieves a loyalty promotion.
     *
     * @param string $promotionId The ID of the [loyalty promotion](entity:LoyaltyPromotion) to
     *        retrieve.
     * @param string $programId The ID of the base [loyalty program](entity:LoyaltyProgram). To get
     *        the program ID,
     *        call [RetrieveLoyaltyProgram](api-endpoint:Loyalty-RetrieveLoyaltyProgram) using the
     *        `main` keyword.
     *
     * @return ApiResponse Response from the API call
     */
    public function retrieveLoyaltyPromotion(string $promotionId, string $programId): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(
            RequestMethod::GET,
            '/v2/loyalty/programs/{program_id}/promotions/{promotion_id}'
        )
            ->auth('global')
            ->parameters(
                TemplateParam::init('promotion_id', $promotionId),
                TemplateParam::init('program_id', $programId)
            );

        $_resHandler = $this->responseHandler()->type(RetrieveLoyaltyPromotionResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Cancels a loyalty promotion. Use this endpoint to cancel an `ACTIVE` promotion earlier than the
     * end date, cancel an `ACTIVE` promotion when an end date is not specified, or cancel a `SCHEDULED`
     * promotion.
     * Because updating a promotion is not supported, you can also use this endpoint to cancel a promotion
     * before
     * you create a new one.
     *
     * This endpoint sets the loyalty promotion to the `CANCELED` state
     *
     * @param string $promotionId The ID of the [loyalty promotion](entity:LoyaltyPromotion) to
     *        cancel. You can cancel a
     *        promotion that has an `ACTIVE` or `SCHEDULED` status.
     * @param string $programId The ID of the base [loyalty program](entity:LoyaltyProgram).
     *
     * @return ApiResponse Response from the API call
     */
    public function cancelLoyaltyPromotion(string $promotionId, string $programId): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(
            RequestMethod::POST,
            '/v2/loyalty/programs/{program_id}/promotions/{promotion_id}/cancel'
        )
            ->auth('global')
            ->parameters(
                TemplateParam::init('promotion_id', $promotionId),
                TemplateParam::init('program_id', $programId)
            );

        $_resHandler = $this->responseHandler()->type(CancelLoyaltyPromotionResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Creates a loyalty reward. In the process, the endpoint does following:
     *
     * - Uses the `reward_tier_id` in the request to determine the number of points
     * to lock for this reward.
     * - If the request includes `order_id`, it adds the reward and related discount to the order.
     *
     * After a reward is created, the points are locked and
     * not available for the buyer to redeem another reward.
     *
     * @param CreateLoyaltyRewardRequest $body An object containing the fields to POST for the
     *        request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function createLoyaltyReward(CreateLoyaltyRewardRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/loyalty/rewards')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()->type(CreateLoyaltyRewardResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Searches for loyalty rewards. This endpoint accepts a request with no query filters and returns
     * results for all loyalty accounts.
     * If you include a `query` object, `loyalty_account_id` is required and `status` is  optional.
     *
     * If you know a reward ID, use the
     * [RetrieveLoyaltyReward]($e/Loyalty/RetrieveLoyaltyReward) endpoint.
     *
     * Search results are sorted by `updated_at` in descending order.
     *
     * @param SearchLoyaltyRewardsRequest $body An object containing the fields to POST for the
     *        request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function searchLoyaltyRewards(SearchLoyaltyRewardsRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/loyalty/rewards/search')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()->type(SearchLoyaltyRewardsResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Deletes a loyalty reward by doing the following:
     *
     * - Returns the loyalty points back to the loyalty account.
     * - If an order ID was specified when the reward was created
     * (see [CreateLoyaltyReward]($e/Loyalty/CreateLoyaltyReward)),
     * it updates the order by removing the reward and related
     * discounts.
     *
     * You cannot delete a reward that has reached the terminal state (REDEEMED).
     *
     * @param string $rewardId The ID of the [loyalty reward](entity:LoyaltyReward) to delete.
     *
     * @return ApiResponse Response from the API call
     */
    public function deleteLoyaltyReward(string $rewardId): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::DELETE, '/v2/loyalty/rewards/{reward_id}')
            ->auth('global')
            ->parameters(TemplateParam::init('reward_id', $rewardId));

        $_resHandler = $this->responseHandler()->type(DeleteLoyaltyRewardResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Retrieves a loyalty reward.
     *
     * @param string $rewardId The ID of the [loyalty reward](entity:LoyaltyReward) to retrieve.
     *
     * @return ApiResponse Response from the API call
     */
    public function retrieveLoyaltyReward(string $rewardId): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/loyalty/rewards/{reward_id}')
            ->auth('global')
            ->parameters(TemplateParam::init('reward_id', $rewardId));

        $_resHandler = $this->responseHandler()->type(RetrieveLoyaltyRewardResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Redeems a loyalty reward.
     *
     * The endpoint sets the reward to the `REDEEMED` terminal state.
     *
     * If you are using your own order processing system (not using the
     * Orders API), you call this endpoint after the buyer paid for the
     * purchase.
     *
     * After the reward reaches the terminal state, it cannot be deleted.
     * In other words, points used for the reward cannot be returned
     * to the account.
     *
     * @param string $rewardId The ID of the [loyalty reward](entity:LoyaltyReward) to redeem.
     * @param RedeemLoyaltyRewardRequest $body An object containing the fields to POST for the
     *        request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function redeemLoyaltyReward(string $rewardId, RedeemLoyaltyRewardRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/loyalty/rewards/{reward_id}/redeem')
            ->auth('global')
            ->parameters(
                TemplateParam::init('reward_id', $rewardId),
                HeaderParam::init('Content-Type', 'application/json'),
                BodyParam::init($body)
            );

        $_resHandler = $this->responseHandler()->type(RedeemLoyaltyRewardResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }
}
