<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a [ListBookingCustomAttributes]($e/BookingCustomAttributes/ListBookingCustomAttributes)
 * response.
 * Either `custom_attributes`, an empty object, or `errors` is present in the response. If additional
 * results are available, the `cursor` field is also present along with `custom_attributes`.
 */
class ListBookingCustomAttributesResponse implements \JsonSerializable
{
    /**
     * @var CustomAttribute[]|null
     */
    private $customAttributes;

    /**
     * @var string|null
     */
    private $cursor;

    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * Returns Custom Attributes.
     * The retrieved custom attributes. If `with_definitions` was set to `true` in the request,
     * the custom attribute definition is returned in the `definition` field of each custom attribute.
     *
     * If no custom attributes are found, Square returns an empty object (`{}`).
     *
     * @return CustomAttribute[]|null
     */
    public function getCustomAttributes(): ?array
    {
        return $this->customAttributes;
    }

    /**
     * Sets Custom Attributes.
     * The retrieved custom attributes. If `with_definitions` was set to `true` in the request,
     * the custom attribute definition is returned in the `definition` field of each custom attribute.
     *
     * If no custom attributes are found, Square returns an empty object (`{}`).
     *
     * @maps custom_attributes
     *
     * @param CustomAttribute[]|null $customAttributes
     */
    public function setCustomAttributes(?array $customAttributes): void
    {
        $this->customAttributes = $customAttributes;
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
        if (isset($this->customAttributes)) {
            $json['custom_attributes'] = $this->customAttributes;
        }
        if (isset($this->cursor)) {
            $json['cursor']            = $this->cursor;
        }
        if (isset($this->errors)) {
            $json['errors']            = $this->errors;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
