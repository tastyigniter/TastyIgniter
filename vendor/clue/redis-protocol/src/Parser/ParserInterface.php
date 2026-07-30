<?php

namespace Clue\Redis\Protocol\Parser;

interface ParserInterface
{
    /**
     * push a chunk of the redis protocol message into the buffer and parse
     *
     * You can push any number of bytes of a redis protocol message into the
     * parser and it will try to parse messages from its data stream. So you can
     * pass data directly from your socket stream and the parser will return the
     * right amount of message model objects for you.
     *
     * If you pass an incomplete message, expect it to return an empty array. If
     * your incomplete message is split to across multiple chunks, the parsed
     * message model will be returned once the parser has sufficient data.
     *
     * @param string $dataChunk
     * @return \Clue\Redis\Protocol\Model\ModelInterface[] 0+ message models
     * @throws \Clue\Redis\Protocol\Parser\ParserException if the message can not be parsed
     * @see self::popIncomingModel()
     */
    public function pushIncoming($dataChunk);
}
