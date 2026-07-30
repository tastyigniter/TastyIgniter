<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Details about a refund's destination.
 */
class DestinationDetails implements \JsonSerializable
{
    /**
     * @var DestinationDetailsCardRefundDetails|null
     */
    private $cardDetails;

    /**
     * Returns Card Details.
     */
    public function getCardDetails(): ?DestinationDetailsCardRefundDetails
    {
        return $this->cardDetails;
    }

    /**
     * Sets Card Details.
     *
     * @maps card_details
     */
    public function setCardDetails(?DestinationDetailsCardRefundDetails $cardDetails): void
    {
        $this->cardDetails = $cardDetails;
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
        if (isset($this->cardDetails)) {
            $json['card_details'] = $this->cardDetails;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
