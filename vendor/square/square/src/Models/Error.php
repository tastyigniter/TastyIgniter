<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents an error encountered during a request to the Connect API.
 *
 * See [Handling errors](https://developer.squareup.com/docs/build-basics/handling-errors) for more
 * information.
 */
class Error implements \JsonSerializable
{
    /**
     * @var string
     */
    private $category;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string|null
     */
    private $detail;

    /**
     * @var string|null
     */
    private $field;

    /**
     * @param string $category
     * @param string $code
     */
    public function __construct(string $category, string $code)
    {
        $this->category = $category;
        $this->code = $code;
    }

    /**
     * Returns Category.
     * Indicates which high-level category of error has occurred during a
     * request to the Connect API.
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * Sets Category.
     * Indicates which high-level category of error has occurred during a
     * request to the Connect API.
     *
     * @required
     * @maps category
     */
    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    /**
     * Returns Code.
     * Indicates the specific error that occurred during a request to a
     * Square API.
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * Sets Code.
     * Indicates the specific error that occurred during a request to a
     * Square API.
     *
     * @required
     * @maps code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * Returns Detail.
     * A human-readable description of the error for debugging purposes.
     */
    public function getDetail(): ?string
    {
        return $this->detail;
    }

    /**
     * Sets Detail.
     * A human-readable description of the error for debugging purposes.
     *
     * @maps detail
     */
    public function setDetail(?string $detail): void
    {
        $this->detail = $detail;
    }

    /**
     * Returns Field.
     * The name of the field provided in the original request (if any) that
     * the error pertains to.
     */
    public function getField(): ?string
    {
        return $this->field;
    }

    /**
     * Sets Field.
     * The name of the field provided in the original request (if any) that
     * the error pertains to.
     *
     * @maps field
     */
    public function setField(?string $field): void
    {
        $this->field = $field;
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
        $json['category']   = $this->category;
        $json['code']       = $this->code;
        if (isset($this->detail)) {
            $json['detail'] = $this->detail;
        }
        if (isset($this->field)) {
            $json['field']  = $this->field;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
