<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * The timeline for card payments.
 */
class CardPaymentTimeline implements \JsonSerializable
{
    /**
     * @var array
     */
    private $authorizedAt = [];

    /**
     * @var array
     */
    private $capturedAt = [];

    /**
     * @var array
     */
    private $voidedAt = [];

    /**
     * Returns Authorized At.
     * The timestamp when the payment was authorized, in RFC 3339 format.
     */
    public function getAuthorizedAt(): ?string
    {
        if (count($this->authorizedAt) == 0) {
            return null;
        }
        return $this->authorizedAt['value'];
    }

    /**
     * Sets Authorized At.
     * The timestamp when the payment was authorized, in RFC 3339 format.
     *
     * @maps authorized_at
     */
    public function setAuthorizedAt(?string $authorizedAt): void
    {
        $this->authorizedAt['value'] = $authorizedAt;
    }

    /**
     * Unsets Authorized At.
     * The timestamp when the payment was authorized, in RFC 3339 format.
     */
    public function unsetAuthorizedAt(): void
    {
        $this->authorizedAt = [];
    }

    /**
     * Returns Captured At.
     * The timestamp when the payment was captured, in RFC 3339 format.
     */
    public function getCapturedAt(): ?string
    {
        if (count($this->capturedAt) == 0) {
            return null;
        }
        return $this->capturedAt['value'];
    }

    /**
     * Sets Captured At.
     * The timestamp when the payment was captured, in RFC 3339 format.
     *
     * @maps captured_at
     */
    public function setCapturedAt(?string $capturedAt): void
    {
        $this->capturedAt['value'] = $capturedAt;
    }

    /**
     * Unsets Captured At.
     * The timestamp when the payment was captured, in RFC 3339 format.
     */
    public function unsetCapturedAt(): void
    {
        $this->capturedAt = [];
    }

    /**
     * Returns Voided At.
     * The timestamp when the payment was voided, in RFC 3339 format.
     */
    public function getVoidedAt(): ?string
    {
        if (count($this->voidedAt) == 0) {
            return null;
        }
        return $this->voidedAt['value'];
    }

    /**
     * Sets Voided At.
     * The timestamp when the payment was voided, in RFC 3339 format.
     *
     * @maps voided_at
     */
    public function setVoidedAt(?string $voidedAt): void
    {
        $this->voidedAt['value'] = $voidedAt;
    }

    /**
     * Unsets Voided At.
     * The timestamp when the payment was voided, in RFC 3339 format.
     */
    public function unsetVoidedAt(): void
    {
        $this->voidedAt = [];
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
        if (!empty($this->authorizedAt)) {
            $json['authorized_at'] = $this->authorizedAt['value'];
        }
        if (!empty($this->capturedAt)) {
            $json['captured_at']   = $this->capturedAt['value'];
        }
        if (!empty($this->voidedAt)) {
            $json['voided_at']     = $this->voidedAt['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
