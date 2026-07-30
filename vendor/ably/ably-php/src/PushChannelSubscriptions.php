<?php
namespace Ably;

use Ably\Models\PaginatedResult;
use Ably\Models\PushChannelSubscription;

class PushChannelSubscriptions {

    private $ably;

    /**
     * Constructor
     * @param AblyRest $ably Ably API instance
     */
    public function __construct( AblyRest $ably ) {
        $this->ably = $ably;
    }

    /**
     * Creates a new push channel subscription. Returns a
     * PushChannelSubscription object.
     *
     * @param array $subscription an array with the subscription information
     */
    public function save ( $subscription ) {
        $obj = new PushChannelSubscription( $subscription );
        $path = '/push/channelSubscriptions' ;
        $params = $obj->toArray();
        $body = $this->ably->post( $path, [], $params );
        $body = json_decode(json_encode($body), true); // Convert stdClass to array
        return new PushChannelSubscription ( $body );
    }

    /**
     *  Returns a PaginatedResult object with the list of PushChannelSubscription
     *  objects, filtered by the given parameters.
     *
     *  @param array $params the parameters used to filter the list
     */
    public function list_ (array $params = []) {
        $path = '/push/channelSubscriptions';
        return new PaginatedResult( $this->ably, 'Ably\Models\PushChannelSubscription',
                                    $cipher = false, 'GET', $path, $params );
    }

    /**
     *  Returns a PaginatedResult object with the list of channel names.
     *
     *  @param array $params the parameters used to filter the list
     */
    public function listChannels (array $params = []) {
        $path = '/push/channels';
        return new PaginatedResult( $this->ably, NULL,
                                    $cipher = false, 'GET', $path, $params );
    }

    /**
     *  Removes the given channel subscription.
     *
     *  @param string $subscription the id of the device
     */
    public function remove ($subscription) {
        $params = $subscription->toArray();
        $path = '/push/channelSubscriptions';
        return $this->ably->delete( $path, [], $params, false );
    }

    /**
     *  Removes the channel subscriptions identified by the given parameters.
     *
     *  @param string $subscription the id of the device
     */
    public function removeWhere (array $params = []) {
        $path = '/push/channelSubscriptions';
        return $this->ably->delete( $path, [], $params, false );
    }
}
