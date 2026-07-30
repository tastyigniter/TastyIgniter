<?php

namespace Mollie\Api\Resources;

class Capture extends BaseResource
{
    /**
     * Always 'capture' for this object
     *
     * @var string
     */
    public $resource;

    /**
     * Id of the capture
     * @var string
     */
    public $id;

    /**
     * Mode of the capture, either "live" or "test" depending on the API Key that was used.
     *
     * @var string
     */
    public $mode;

    /**
     * Status of the capture.
     *
     * @var string
     */
    public $status;

    /**
     * Amount object containing the value and currency
     *
     * @var \stdClass
     */
    public $amount;

    /**
     * Amount object containing the settlement value and currency
     *
     * @var \stdClass
     */
    public $settlementAmount;

    /**
     * Id of the capture's payment (on the Mollie platform).
     *
     * @var string
     */
    public $paymentId;

    /**
     * Id of the capture's shipment (on the Mollie platform).
     *
     * @var string
     */
    public $shipmentId;

    /**
     * Id of the capture's settlement (on the Mollie platform).
     *
     * @var string
     */
    public $settlementId;

    /**
     * Provide any data you like, for example a string or a JSON object. The data will be saved alongside the capture.
     * Whenever you fetch the capture, the metadata will be included.
     * You can use up to approximately 1kB on this field.
     *
     * @var \stdClass|mixed|null
     */
    public $metadata;

    /**
     * @var string
     */
    public $createdAt;

    /**
     * @var \stdClass
     */
    public $_links;
}
