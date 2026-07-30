<?php
namespace Ably;

use Ably\Models\PaginatedResult;

class Presence {

    private $ably;
    private $channel;

    /**
     * Constructor
     * @param AblyRest $ably Ably API instance
     * @param Channel $channel Associated channel
     */
    public function __construct( AblyRest $ably, Channel $channel ) {
        $this->ably = $ably;
        $this->channel = $channel;
    }

    /**
     * Retrieves channel's presence data
     * @param array $params Parameters to be sent with the request
     * @return PaginatedResult
     */
    public function get( $params = [] ) {
        return new PaginatedResult( $this->ably, 'Ably\Models\PresenceMessage', $this->channel->getCipherParams(), 'GET', $this->channel->getPath() . '/presence', $params );
    }

    /**
     * Retrieves channel's history of presence data
     * @param array $params Parameters to be sent with the request
     * @return PaginatedResult
     */
    public function history( $params = [] ) {
        return new PaginatedResult( $this->ably, 'Ably\Models\PresenceMessage', $this->channel->getCipherParams(), 'GET', $this->channel->getPath() . '/presence/history', $params );
    }
}