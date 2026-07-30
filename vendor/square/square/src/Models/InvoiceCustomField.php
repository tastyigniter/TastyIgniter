<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * An additional seller-defined and customer-facing field to include on the invoice. For more
 * information,
 * see [Custom fields](https://developer.squareup.com/docs/invoices-api/overview#custom-fields).
 *
 * Adding custom fields to an invoice requires an
 * [Invoices Plus subscription](https://developer.squareup.com/docs/invoices-api/overview#invoices-plus-
 * subscription).
 */
class InvoiceCustomField implements \JsonSerializable
{
    /**
     * @var array
     */
    private $label = [];

    /**
     * @var array
     */
    private $value = [];

    /**
     * @var string|null
     */
    private $placement;

    /**
     * Returns Label.
     * The label or title of the custom field. This field is required for a custom field.
     */
    public function getLabel(): ?string
    {
        if (count($this->label) == 0) {
            return null;
        }
        return $this->label['value'];
    }

    /**
     * Sets Label.
     * The label or title of the custom field. This field is required for a custom field.
     *
     * @maps label
     */
    public function setLabel(?string $label): void
    {
        $this->label['value'] = $label;
    }

    /**
     * Unsets Label.
     * The label or title of the custom field. This field is required for a custom field.
     */
    public function unsetLabel(): void
    {
        $this->label = [];
    }

    /**
     * Returns Value.
     * The text of the custom field. If omitted, only the label is rendered.
     */
    public function getValue(): ?string
    {
        if (count($this->value) == 0) {
            return null;
        }
        return $this->value['value'];
    }

    /**
     * Sets Value.
     * The text of the custom field. If omitted, only the label is rendered.
     *
     * @maps value
     */
    public function setValue(?string $value): void
    {
        $this->value['value'] = $value;
    }

    /**
     * Unsets Value.
     * The text of the custom field. If omitted, only the label is rendered.
     */
    public function unsetValue(): void
    {
        $this->value = [];
    }

    /**
     * Returns Placement.
     * Indicates where to render a custom field on the Square-hosted invoice page and in emailed or PDF
     * copies of the invoice.
     */
    public function getPlacement(): ?string
    {
        return $this->placement;
    }

    /**
     * Sets Placement.
     * Indicates where to render a custom field on the Square-hosted invoice page and in emailed or PDF
     * copies of the invoice.
     *
     * @maps placement
     */
    public function setPlacement(?string $placement): void
    {
        $this->placement = $placement;
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
        if (!empty($this->label)) {
            $json['label']     = $this->label['value'];
        }
        if (!empty($this->value)) {
            $json['value']     = $this->value['value'];
        }
        if (isset($this->placement)) {
            $json['placement'] = $this->placement;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
