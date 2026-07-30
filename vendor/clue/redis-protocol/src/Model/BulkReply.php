<?php

namespace Clue\Redis\Protocol\Model;

use Clue\Redis\Protocol\Serializer\SerializerInterface;

class BulkReply implements ModelInterface
{
    private $value;

    /**
     * create bulk reply (string reply)
     *
     * @param string|null $data
     */
    public function __construct($value)
    {
        if ($value !== null) {
            $value = (string)$value;
        }
        $this->value = $value;
    }

    public function getValueNative()
    {
        return $this->value;
    }

    public function getMessageSerialized(SerializerInterface $serializer)
    {
        return $serializer->getBulkMessage($this->value);
    }
}
