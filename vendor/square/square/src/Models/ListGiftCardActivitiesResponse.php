<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A response that contains a list of `GiftCardActivity` objects. If the request resulted in errors,
 * the response contains a set of `Error` objects.
 */
class ListGiftCardActivitiesResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var GiftCardActivity[]|null
     */
    private $giftCardActivities;

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
     * Returns Gift Card Activities.
     * The requested gift card activities or an empty object if none are found.
     *
     * @return GiftCardActivity[]|null
     */
    public function getGiftCardActivities(): ?array
    {
        return $this->giftCardActivities;
    }

    /**
     * Sets Gift Card Activities.
     * The requested gift card activities or an empty object if none are found.
     *
     * @maps gift_card_activities
     *
     * @param GiftCardActivity[]|null $giftCardActivities
     */
    public function setGiftCardActivities(?array $giftCardActivities): void
    {
        $this->giftCardActivities = $giftCardActivities;
    }

    /**
     * Returns Cursor.
     * When a response is truncated, it includes a cursor that you can use in a
     * subsequent request to retrieve the next set of activities. If a cursor is not present, this is
     * the final response.
     * For more information, see [Pagination](https://developer.squareup.com/docs/working-with-
     * apis/pagination).
     */
    public function getCursor(): ?string
    {
        return $this->cursor;
    }

    /**
     * Sets Cursor.
     * When a response is truncated, it includes a cursor that you can use in a
     * subsequent request to retrieve the next set of activities. If a cursor is not present, this is
     * the final response.
     * For more information, see [Pagination](https://developer.squareup.com/docs/working-with-
     * apis/pagination).
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
            $json['errors']               = $this->errors;
        }
        if (isset($this->giftCardActivities)) {
            $json['gift_card_activities'] = $this->giftCardActivities;
        }
        if (isset($this->cursor)) {
            $json['cursor']               = $this->cursor;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
