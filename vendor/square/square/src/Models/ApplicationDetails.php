<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Details about the application that took the payment.
 */
class ApplicationDetails implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $squareProduct;

    /**
     * @var array
     */
    private $applicationId = [];

    /**
     * Returns Square Product.
     * A list of products to return to external callers.
     */
    public function getSquareProduct(): ?string
    {
        return $this->squareProduct;
    }

    /**
     * Sets Square Product.
     * A list of products to return to external callers.
     *
     * @maps square_product
     */
    public function setSquareProduct(?string $squareProduct): void
    {
        $this->squareProduct = $squareProduct;
    }

    /**
     * Returns Application Id.
     * The Square ID assigned to the application used to take the payment.
     * Application developers can use this information to identify payments that
     * their application processed.
     * For example, if a developer uses a custom application to process payments,
     * this field contains the application ID from the Developer Dashboard.
     * If a seller uses a [Square App Marketplace](https://developer.squareup.com/docs/app-marketplace)
     * application to process payments, the field contains the corresponding application ID.
     */
    public function getApplicationId(): ?string
    {
        if (count($this->applicationId) == 0) {
            return null;
        }
        return $this->applicationId['value'];
    }

    /**
     * Sets Application Id.
     * The Square ID assigned to the application used to take the payment.
     * Application developers can use this information to identify payments that
     * their application processed.
     * For example, if a developer uses a custom application to process payments,
     * this field contains the application ID from the Developer Dashboard.
     * If a seller uses a [Square App Marketplace](https://developer.squareup.com/docs/app-marketplace)
     * application to process payments, the field contains the corresponding application ID.
     *
     * @maps application_id
     */
    public function setApplicationId(?string $applicationId): void
    {
        $this->applicationId['value'] = $applicationId;
    }

    /**
     * Unsets Application Id.
     * The Square ID assigned to the application used to take the payment.
     * Application developers can use this information to identify payments that
     * their application processed.
     * For example, if a developer uses a custom application to process payments,
     * this field contains the application ID from the Developer Dashboard.
     * If a seller uses a [Square App Marketplace](https://developer.squareup.com/docs/app-marketplace)
     * application to process payments, the field contains the corresponding application ID.
     */
    public function unsetApplicationId(): void
    {
        $this->applicationId = [];
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
        if (isset($this->squareProduct)) {
            $json['square_product'] = $this->squareProduct;
        }
        if (!empty($this->applicationId)) {
            $json['application_id'] = $this->applicationId['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
