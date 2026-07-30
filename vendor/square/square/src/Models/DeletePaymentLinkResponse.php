<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class DeletePaymentLinkResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var string|null
     */
    private $id;

    /**
     * @var string|null
     */
    private $cancelledOrderId;

    /**
     * Returns Errors.
     *
     * @return Error[]|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * Sets Errors.
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
     * Returns Id.
     * The ID of the link that is deleted.
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Sets Id.
     * The ID of the link that is deleted.
     *
     * @maps id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns Cancelled Order Id.
     * The ID of the order that is canceled. When a payment link is deleted, Square updates the
     * the `state` (of the order that the checkout link created) to CANCELED.
     */
    public function getCancelledOrderId(): ?string
    {
        return $this->cancelledOrderId;
    }

    /**
     * Sets Cancelled Order Id.
     * The ID of the order that is canceled. When a payment link is deleted, Square updates the
     * the `state` (of the order that the checkout link created) to CANCELED.
     *
     * @maps cancelled_order_id
     */
    public function setCancelledOrderId(?string $cancelledOrderId): void
    {
        $this->cancelledOrderId = $cancelledOrderId;
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
        if (isset($this->id)) {
            $json['id']                 = $this->id;
        }
        if (isset($this->cancelledOrderId)) {
            $json['cancelled_order_id'] = $this->cancelledOrderId;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
