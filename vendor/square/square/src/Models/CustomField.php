<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Describes a custom form field to add to the checkout page to collect more information from buyers
 * during checkout.
 * For more information,
 * see [Specify checkout options](https://developer.squareup.com/docs/checkout-api/optional-checkout-
 * configurations#specify-checkout-options-1).
 */
class CustomField implements \JsonSerializable
{
    /**
     * @var string
     */
    private $title;

    /**
     * @param string $title
     */
    public function __construct(string $title)
    {
        $this->title = $title;
    }

    /**
     * Returns Title.
     * The title of the custom field.
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Sets Title.
     * The title of the custom field.
     *
     * @required
     * @maps title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
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
        $json['title'] = $this->title;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
