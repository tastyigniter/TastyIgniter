<?php

namespace Clue\Redis\Protocol\Model;

use Clue\Redis\Protocol\Serializer\SerializerInterface;
use InvalidArgumentException;
use UnexpectedValueException;

class MultiBulkReply implements ModelInterface
{
    /**
     * @var array|null
     */
    private $data;

    /**
     * create multi bulk reply (an array of other replies, usually bulk replies)
     *
     * @param array|null $data
     * @throws InvalidArgumentException
     */
    public function __construct($data = null)
    {
        if ($data !== null && !is_array($data)) { // manual type check to support legacy PHP < 7.1
            throw new InvalidArgumentException('Argument #1 ($data) expected array|null');
        }
        $this->data = $data;
    }

    public function getValueNative()
    {
        if ($this->data === null) {
            return null;
        }

        $ret = array();
        foreach ($this->data as $one) {
            if ($one instanceof ModelInterface) {
                $ret []= $one->getValueNative();
            } else {
                $ret []= $one;
            }
        }
        return $ret;
    }

    public function getMessageSerialized(SerializerInterface $serializer)
    {
        return $serializer->getMultiBulkMessage($this->data);
    }

    /**
     * Checks whether this model represents a valid unified request protocol message
     *
     * The new unified protocol was introduced in Redis 1.2, but it became the
     * standard way for talking with the Redis server in Redis 2.0. The unified
     * request protocol is what Redis already uses in replies in order to send
     * list of items to clients, and is called a Multi Bulk Reply.
     *
     * @return boolean
     * @link http://redis.io/topics/protocol
     */
    public function isRequest()
    {
        if (!$this->data) {
            return false;
        }

        foreach ($this->data as $one) {
            if (!($one instanceof BulkReply) && !is_string($one)) {
                return false;
            }
        }

        return true;
    }

    public function getRequestModel()
    {
        if (!$this->data) {
            throw new UnexpectedValueException('Null-multi-bulk message can not be represented as a request, must contain string/bulk values');
        }

        $command = null;
        $args = array();

        foreach ($this->data as $one) {
            if ($one instanceof BulkReply) {
                $one = $one->getValueNative();
            } elseif (!is_string($one)) {
                throw new UnexpectedValueException('Message can not be represented as a request, must only contain string/bulk values');
            }

            if ($command === null) {
                $command = $one;
            } else {
                $args []= $one;
            }
        }

        return new Request($command, $args);
    }
}
