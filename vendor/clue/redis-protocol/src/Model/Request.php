<?php

namespace Clue\Redis\Protocol\Model;

use Clue\Redis\Protocol\Serializer\SerializerInterface;

class Request implements ModelInterface
{
    private $command;
    private $args;

    public function __construct($command, array $args = array())
    {
        $this->command = $command;
        $this->args    = $args;
    }

    public function getCommand()
    {
        return $this->command;
    }

    public function getArgs()
    {
        return $this->args;
    }

    public function getReplyModel()
    {
        $models = array(new BulkReply($this->command));
        foreach ($this->args as $arg) {
            $models []= new BulkReply($arg);
        }

        return new MultiBulkReply($models);
    }

    public function getValueNative()
    {
        $ret = $this->args;
        array_unshift($ret, $this->command);

        return $ret;
    }

    public function getMessageSerialized(SerializerInterface $serializer)
    {
        return $serializer->getRequestMessage($this->command, $this->args);
    }
}
