<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class UpdatePaymentLinkRequest implements \JsonSerializable
{
    /**
     * @var PaymentLink
     */
    private $paymentLink;

    /**
     * @param PaymentLink $paymentLink
     */
    public function __construct(PaymentLink $paymentLink)
    {
        $this->paymentLink = $paymentLink;
    }

    /**
     * Returns Payment Link.
     */
    public function getPaymentLink(): PaymentLink
    {
        return $this->paymentLink;
    }

    /**
     * Sets Payment Link.
     *
     * @required
     * @maps payment_link
     */
    public function setPaymentLink(PaymentLink $paymentLink): void
    {
        $this->paymentLink = $paymentLink;
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
        $json['payment_link'] = $this->paymentLink;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
