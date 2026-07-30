<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents communication preferences for the customer profile.
 */
class CustomerPreferences implements \JsonSerializable
{
    /**
     * @var array
     */
    private $emailUnsubscribed = [];

    /**
     * Returns Email Unsubscribed.
     * Indicates whether the customer has unsubscribed from marketing campaign emails. A value of `true`
     * means that the customer chose to opt out of email marketing from the current Square seller or from
     * all Square sellers. This value is read-only from the Customers API.
     */
    public function getEmailUnsubscribed(): ?bool
    {
        if (count($this->emailUnsubscribed) == 0) {
            return null;
        }
        return $this->emailUnsubscribed['value'];
    }

    /**
     * Sets Email Unsubscribed.
     * Indicates whether the customer has unsubscribed from marketing campaign emails. A value of `true`
     * means that the customer chose to opt out of email marketing from the current Square seller or from
     * all Square sellers. This value is read-only from the Customers API.
     *
     * @maps email_unsubscribed
     */
    public function setEmailUnsubscribed(?bool $emailUnsubscribed): void
    {
        $this->emailUnsubscribed['value'] = $emailUnsubscribed;
    }

    /**
     * Unsets Email Unsubscribed.
     * Indicates whether the customer has unsubscribed from marketing campaign emails. A value of `true`
     * means that the customer chose to opt out of email marketing from the current Square seller or from
     * all Square sellers. This value is read-only from the Customers API.
     */
    public function unsetEmailUnsubscribed(): void
    {
        $this->emailUnsubscribed = [];
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
        if (!empty($this->emailUnsubscribed)) {
            $json['email_unsubscribed'] = $this->emailUnsubscribed['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
