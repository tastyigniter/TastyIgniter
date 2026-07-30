<?php
namespace Ably\Models;

class DeviceDetails extends BaseOptions {

    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $clientId;

    /**
     * @var string
     */
    public $formFactor;

    /**
     * @var array
     */
    public $metadata;

    /**
     * @var string
     */
    public $platform;

    /**
     * @var \Ably\Models\DevicePushDetails
     */
    public $push;

    /**
     * @var string
     */
    public $deviceSecret;

}
