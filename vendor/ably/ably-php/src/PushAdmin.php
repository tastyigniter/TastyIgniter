<?php
namespace Ably;

class PushAdmin {

    private $ably;
    public $deviceRegistrations;
    public $channelSubscriptions;

    /**
     * Constructor
     * @param AblyRest $ably Ably API instance
     */
    public function __construct( AblyRest $ably ) {
        $this->ably = $ably;
        $this->deviceRegistrations = new PushDeviceRegistrations( $ably );
        $this->channelSubscriptions = new PushChannelSubscriptions ( $ably );
    }

    public function publish ( array $recipient, array $data, $returnHeaders = false ) {
        if ( empty($recipient) ) {
            throw new \InvalidArgumentException('recipient is empty');
        }

        if ( empty($data) ) {
            throw new \InvalidArgumentException('data is empty');
        }

        $params = array_merge( $data, [ 'recipient' => $recipient ] );
        $this->ably->post( '/push/publish', [], $params, $returnHeaders );
    }

}
