<?php
namespace Ably\Models;

use Ably\Exceptions\AblyException;
use stdClass;

/**
 * Model for stats
 */
#[\AllowDynamicProperties]
class Stats {
    /**
     * @var \Ably\Models\Stats\MessageTypes $all MessageTypes representing the total of all inbound and
     *      outbound message traffic. This is the aggregate number that is considered in applying account
     *      message limits.
     * @var \Ably\Models\Stats\MessageTraffic $inbound MessageTraffic representing inbound messages
     *      (ie published by clients and sent inbound to the Ably service) by all transport types.
     * @var \Ably\Models\Stats\MessageTraffic $outbound MessageTraffic representing outbound messages
     *      (ie delivered by the Ably service to connected and subscribed clients).
     * @var \Ably\Models\Stats\MessageTypes $persisted MessageTypes representing the aggregate volume
     *      of messages persisted.
     * @var \Ably\Models\Stats\ConnectionTypes $connections ConnectionTypes representing the usage
     *      of connections.
     * @var \Ably\Models\Stats\ResourceCount $channels ResourceCount representing the number of channels
     *       activated and used.
     * @var \Ably\Models\Stats\RequestCount $apiRequests RequestCount representing the number of requests
     *      made to the REST API.
     * @var \Ably\Models\Stats\RequestCount $tokenRequests RequestCount representing the number of requests
     *      made to issue access tokens.
     * @var string $intervalId The interval that this statistic applies to.
     * @var string $intervalGranularity The granularity of the interval for the stat. May be one of values:
     *      minute, hour, day, month
     * @var int $intervalTime A timestamp representing the start of the interval.
     */
    public $all;
    public $inbound;
    public $outbound;
    public $persisted;
    public $connections;
    public $channels;
    public $apiRequests;
    public $tokenRequests;
    public $intervalId;
    public $intervalGranularity;
    public $intervalTime;

    public function __construct() {
        $this->clearFields();
    }
    /**
     * Populates stats from JSON
     * @param string|stdClass $json JSON string or an already decoded object.
     * @throws AblyException
     */
    public function fromJSON( $json ) {
        $this->clearFields();

        if (is_object( $json )) {
            $obj = $json;
        }
        else if(is_array( $json) ){
            $obj = (object)$json;
        }
        else {
            $obj = @json_decode($json);
            if (!$obj) {
                throw new AblyException( 'Invalid object or JSON encoded object' );
            }
        }

        self::deepCopy( $obj, $this );
    }

    protected static function deepCopy( $target, $dst ) {
        foreach ( $target as $key => $value ) {
            if ( is_object( $value )) {
                self::deepCopy( $value, $dst->$key );
            } else {
                $dst->$key = $value;
            }
        }
    }

    /**
     * Sets all the public fields to null
     */
    public function clearFields() {
        $this->all                 = new Stats\MessageTypes();
        $this->inbound             = new Stats\MessageTraffic();
        $this->outbound            = new Stats\MessageTraffic();
        $this->persisted           = new Stats\MessageTypes();
        $this->connections         = new Stats\ConnectionTypes();
        $this->channels            = new Stats\ResourceCount();
        $this->apiRequests         = new Stats\RequestCount();
        $this->tokenRequests       = new Stats\RequestCount();
        $this->intervalId          = '';
        $this->intervalGranularity = '';
        $this->intervalTime        = 0;
    }
}
