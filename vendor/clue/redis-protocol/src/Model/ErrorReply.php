<?php

namespace Clue\Redis\Protocol\Model;

use Clue\Redis\Protocol\Serializer\SerializerInterface;
use Exception;

/**
 *
 * @link http://redis.io/topics/protocol#status-reply
 */
class ErrorReply extends Exception implements ModelInterface
{
    /**
     * create error status reply (single line error message)
     *
     * @param string $message
     * @return string
     */
    public function __construct($message, $code = 0, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function getValueNative()
    {
        return $this->getMessage();
    }

    public function getMessageSerialized(SerializerInterface $serializer)
    {
        return $serializer->getErrorMessage($this->getMessage());
    }
}
