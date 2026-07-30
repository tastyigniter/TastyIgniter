<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Additional details about Clearpay payments.
 */
class ClearpayDetails implements \JsonSerializable
{
    /**
     * @var array
     */
    private $emailAddress = [];

    /**
     * Returns Email Address.
     * Email address on the buyer's Clearpay account.
     */
    public function getEmailAddress(): ?string
    {
        if (count($this->emailAddress) == 0) {
            return null;
        }
        return $this->emailAddress['value'];
    }

    /**
     * Sets Email Address.
     * Email address on the buyer's Clearpay account.
     *
     * @maps email_address
     */
    public function setEmailAddress(?string $emailAddress): void
    {
        $this->emailAddress['value'] = $emailAddress;
    }

    /**
     * Unsets Email Address.
     * Email address on the buyer's Clearpay account.
     */
    public function unsetEmailAddress(): void
    {
        $this->emailAddress = [];
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
        if (!empty($this->emailAddress)) {
            $json['email_address'] = $this->emailAddress['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
