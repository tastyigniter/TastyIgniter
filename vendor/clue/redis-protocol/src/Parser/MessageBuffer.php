<?php

namespace Clue\Redis\Protocol\Parser;

use UnderflowException;

class MessageBuffer implements ParserInterface
{
    private $parser;
    private $incomingQueue = array();

    public function __construct(ParserInterface $parser)
    {
        $this->parser = $parser;
    }

    public function popIncomingModel()
    {
        if (!$this->incomingQueue) {
            throw new UnderflowException('Incoming message queue is empty');
        }
        return array_shift($this->incomingQueue);
    }

    public function hasIncomingModel()
    {
        return ($this->incomingQueue) ? true : false;
    }

    public function pushIncoming($data)
    {
        $ret = $this->parser->pushIncoming($data);

        foreach ($ret as $one) {
            $this->incomingQueue []= $one;
        }

        return $ret;
    }
}
