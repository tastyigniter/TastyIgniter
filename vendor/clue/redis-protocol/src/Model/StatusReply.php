<?php

namespace Clue\Redis\Protocol\Model;

use Clue\Redis\Protocol\Serializer\SerializerInterface;
/**
 *
 * @link http://redis.io/topics/protocol#status-reply
 */
class StatusReply implements ModelInterface
{
    private $message;

    /**
     * create status reply (single line message)
     *
     * @param string $message
     * @return string
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    public function getValueNative()
    {
        return $this->message;
    }

    public function getMessageSerialized(SerializerInterface $serializer)
    {
        return $serializer->getStatusMessage($this->message);
    }
}
