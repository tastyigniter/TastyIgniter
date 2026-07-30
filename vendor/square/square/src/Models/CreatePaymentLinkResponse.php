<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class CreatePaymentLinkResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var PaymentLink|null
     */
    private $paymentLink;

    /**
     * @var PaymentLinkRelatedResources|null
     */
    private $relatedResources;

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
     * Returns Payment Link.
     */
    public function getPaymentLink(): ?PaymentLink
    {
        return $this->paymentLink;
    }

    /**
     * Sets Payment Link.
     *
     * @maps payment_link
     */
    public function setPaymentLink(?PaymentLink $paymentLink): void
    {
        $this->paymentLink = $paymentLink;
    }

    /**
     * Returns Related Resources.
     */
    public function getRelatedResources(): ?PaymentLinkRelatedResources
    {
        return $this->relatedResources;
    }

    /**
     * Sets Related Resources.
     *
     * @maps related_resources
     */
    public function setRelatedResources(?PaymentLinkRelatedResources $relatedResources): void
    {
        $this->relatedResources = $relatedResources;
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
            $json['errors']            = $this->errors;
        }
        if (isset($this->paymentLink)) {
            $json['payment_link']      = $this->paymentLink;
        }
        if (isset($this->relatedResources)) {
            $json['related_resources'] = $this->relatedResources;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
