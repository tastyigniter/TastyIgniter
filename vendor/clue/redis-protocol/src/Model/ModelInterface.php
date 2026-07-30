<?php

namespace Clue\Redis\Protocol\Model;

use Clue\Redis\Protocol\Serializer\SerializerInterface;

interface ModelInterface
{
    /**
     * Returns value of this model as a native representation for PHP
     *
     * @return mixed
     */
    public function getValueNative();

    /**
     * Returns the serialized representation of this protocol message
     *
     * @param SerializerInterface $serializer;
     * @return string
     */
    public function getMessageSerialized(SerializerInterface $serializer);
}
