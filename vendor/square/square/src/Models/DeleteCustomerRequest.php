<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines the fields that are included in a request to the `DeleteCustomer`
 * endpoint.
 */
class DeleteCustomerRequest implements \JsonSerializable
{
    /**
     * @var int|null
     */
    private $version;

    /**
     * Returns Version.
     * The current version of the customer profile.
     *
     * As a best practice, you should include this parameter to enable [optimistic concurrency](https:
     * //developer.squareup.com/docs/build-basics/common-api-patterns/optimistic-concurrency) control.  For
     * more information, see [Delete a customer profile](https://developer.squareup.com/docs/customers-
     * api/use-the-api/keep-records#delete-customer-profile).
     */
    public function getVersion(): ?int
    {
        return $this->version;
    }

    /**
     * Sets Version.
     * The current version of the customer profile.
     *
     * As a best practice, you should include this parameter to enable [optimistic concurrency](https:
     * //developer.squareup.com/docs/build-basics/common-api-patterns/optimistic-concurrency) control.  For
     * more information, see [Delete a customer profile](https://developer.squareup.com/docs/customers-
     * api/use-the-api/keep-records#delete-customer-profile).
     *
     * @maps version
     */
    public function setVersion(?int $version): void
    {
        $this->version = $version;
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
        if (isset($this->version)) {
            $json['version'] = $this->version;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
