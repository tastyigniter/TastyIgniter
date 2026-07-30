<?php
namespace Ably\Models;

class DevicePushDetails extends BaseOptions {

    /**
     * @var \Ably\Models\ErrorInfo
     */
    public $errorReason;

    /**
     * @var array
     */
    public $recipient;

    /**
     * @var string
     */
    public $state;

}
