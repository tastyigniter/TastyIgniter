<?php

namespace Ably\Models\Status;

/**
 * https://docs.ably.io/client-lib-development-guide/features/#CHD1
 */
class ChannelDetails
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $channelId;

    /**
     * @var ChannelStatus
     */
    public $status;

    /**
     * @param \stdClass
     * @return ChannelDetails
     */
    static function from($object) {
        $channelDetails = new self();
        $channelDetails->name = $object->name;
        $channelDetails->channelId = $object->channelId;
        $channelDetails->status = ChannelStatus::from($object->status);
        return $channelDetails;
    }
}

/**
 * https://docs.ably.io/client-lib-development-guide/features/#CHS1
 */
class ChannelStatus
{
    /**
     * @var bool
     */
    public $isActive;

    /**
     * @var ChannelOccupancy
     */
    public $occupancy;

    /**
     * @param \stdClass
     * @return ChannelStatus
     */
    static function from($object) {
        $channelStatus = new self();
        $channelStatus->isActive = $object->isActive;
        $channelStatus->occupancy = ChannelOccupancy::from($object->occupancy);
        return $channelStatus;
    }
}

/**
 * https://docs.ably.io/client-lib-development-guide/features/#CHO1
 */
class ChannelOccupancy
{
    /**
     * @var ChannelMetrics
     */
    public $metrics;

    /**
     * @param \stdClass
     * @return ChannelOccupancy
     */
    static function from($object) {
        $occupancy = new self();
        $occupancy->metrics = ChannelMetrics::from($object->metrics);
        return $occupancy;
    }
}

/**
 * https://docs.ably.io/client-lib-development-guide/features/#CHM1
 */
class ChannelMetrics
{
    /**
     * @var int
     */
    public $connections;

    /**
     * @var int
     */
    public $presenceConnections;

    /**
     * @var int
     */
    public $presenceMembers;

    /**
     * @var int
     */
    public $presenceSubscribers;

    /**
     * @var int
     */
    public $publishers;

    /**
     * @var int
     */
    public $subscribers;

    /**
     * @param \stdClass
     * @return ChannelMetrics
     */
    static function from($object) {
        $metrics = new self();
        $metrics->connections = $object->connections;
        $metrics->presenceConnections= $object->presenceConnections;
        $metrics->presenceMembers = $object->presenceMembers;
        $metrics->presenceSubscribers= $object->presenceSubscribers;
        $metrics->publishers = $object->publishers;
        $metrics->subscribers = $object->subscribers;
        return $metrics;
    }
}
