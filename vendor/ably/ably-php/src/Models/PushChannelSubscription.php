<?php
namespace Ably\Models;


class PushChannelSubscription extends BaseOptions {

    /**
     * @var string
     */
    public $deviceId;

    /**
     * @var string
     */
    public $clientId;

    /**
     * @var string
     */
    public $channel;

    public function __construct( array $options = [] ) {
        parent::__construct( $options );

        if ($this->deviceId && $this->clientId) {
            throw new \InvalidArgumentException(
                'both device and client id given, only one expected'
            );
        }
    }

}
