<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a [ListLoyaltyPromotions]($e/Loyalty/ListLoyaltyPromotions) response.
 * One of `loyalty_promotions`, an empty object, or `errors` is present in the response.
 * If additional results are available, the `cursor` field is also present along with
 * `loyalty_promotions`.
 */
class ListLoyaltyPromotionsResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var LoyaltyPromotion[]|null
     */
    private $loyaltyPromotions;

    /**
     * @var string|null
     */
    private $cursor;

    /**
     * Returns Errors.
     * Any errors that occurred during the request.
     *
     * @return Error[]|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * Sets Errors.
     * Any errors that occurred during the request.
     *
     * @maps errors
     *
     * @param Error[]|null $errors
     */
    public function setErrors(?array $errors): void
    {
        $this->errors = $errors;
    }

    /**
     * Returns Loyalty Promotions.
     * The retrieved loyalty promotions.
     *
     * @return LoyaltyPromotion[]|null
     */
    public function getLoyaltyPromotions(): ?array
    {
        return $this->loyaltyPromotions;
    }

    /**
     * Sets Loyalty Promotions.
     * The retrieved loyalty promotions.
     *
     * @maps loyalty_promotions
     *
     * @param LoyaltyPromotion[]|null $loyaltyPromotions
     */
    public function setLoyaltyPromotions(?array $loyaltyPromotions): void
    {
        $this->loyaltyPromotions = $loyaltyPromotions;
    }

    /**
     * Returns Cursor.
     * The cursor to use in your next call to this endpoint to retrieve the next page of results
     * for your original request. This field is present only if the request succeeded and additional
     * results are available. For more information, see [Pagination](https://developer.squareup.
     * com/docs/build-basics/common-api-patterns/pagination).
     */
    public function getCursor(): ?string
    {
        return $this->cursor;
    }

    /**
     * Sets Cursor.
     * The cursor to use in your next call to this endpoint to retrieve the next page of results
     * for your original request. This field is present only if the request succeeded and additional
     * results are available. For more information, see [Pagination](https://developer.squareup.
     * com/docs/build-basics/common-api-patterns/pagination).
     *
     * @maps cursor
     */
    public function setCursor(?string $cursor): void
    {
        $this->cursor = $cursor;
    }

    /**
     * Encode this object to JSON
     *
     * @param bool $asArrayWhenEmpty Whether to serialize this model as an array whenever no fields
     *        are set. (default: false)
     *
     * @return array|stdClass
     */
    #[\ReturnTypeWillChange] // @phan-suppress-current-line PhanUndeclaredClassAttribute for (php < 8.1)
    public function jsonSerialize(bool $asArrayWhenEmpty = false)
    {
        $json = [];
        if (isset($this->errors)) {
            $json['errors']             = $this->errors;
        }
        if (isset($this->loyaltyPromotions)) {
            $json['loyalty_promotions'] = $this->loyaltyPromotions;
        }
        if (isset($this->cursor)) {
            $json['cursor']             = $this->cursor;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
