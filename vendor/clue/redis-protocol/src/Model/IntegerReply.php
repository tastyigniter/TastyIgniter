<?php

namespace Clue\Redis\Protocol\Model;

use Clue\Redis\Protocol\Serializer\SerializerInterface;

class IntegerReply implements ModelInterface
{
    private $value;

    /**
     * create integer reply
     *
     * @param int $data
     */
    public function __construct($value)
    {
        $this->value = (int)$value;
    }

    public function getValueNative()
    {
        return $this->value;
    }

    public function getMessageSerialized(SerializerInterface $serializer)
    {
        return $serializer->getIntegerMessage($this->value);
    }
}
