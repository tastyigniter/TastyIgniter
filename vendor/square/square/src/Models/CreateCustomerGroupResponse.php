<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines the fields that are included in the response body of
 * a request to the [CreateCustomerGroup]($e/CustomerGroups/CreateCustomerGroup) endpoint.
 *
 * Either `errors` or `group` is present in a given response (never both).
 */
class CreateCustomerGroupResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var CustomerGroup|null
     */
    private $group;

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
     * Returns Group.
     * Represents a group of customer profiles.
     *
     * Customer groups can be created, be modified, and have their membership defined using
     * the Customers API or within the Customer Directory in the Square Seller Dashboard or Point of Sale.
     */
    public function getGroup(): ?CustomerGroup
    {
        return $this->group;
    }

    /**
     * Sets Group.
     * Represents a group of customer profiles.
     *
     * Customer groups can be created, be modified, and have their membership defined using
     * the Customers API or within the Customer Directory in the Square Seller Dashboard or Point of Sale.
     *
     * @maps group
     */
    public function setGroup(?CustomerGroup $group): void
    {
        $this->group = $group;
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
            $json['errors'] = $this->errors;
        }
        if (isset($this->group)) {
            $json['group']  = $this->group;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
