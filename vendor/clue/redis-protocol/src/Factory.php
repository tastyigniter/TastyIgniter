<?php

namespace Clue\Redis\Protocol;

use Clue\Redis\Protocol\Parser\ParserInterface;
use Clue\Redis\Protocol\Parser\ResponseParser;
use Clue\Redis\Protocol\Serializer\SerializerInterface;
use Clue\Redis\Protocol\Serializer\RecursiveSerializer;
use Clue\Redis\Protocol\Parser\RequestParser;

/**
 * Provides factory methods used to instantiate the best available protocol implementation
 */
class Factory
{
    /**
     * instantiate the best available protocol response parser implementation
     *
     * This is the parser every redis client implementation should use in order
     * to parse incoming response messages from a redis server.
     *
     * @return ParserInterface
     */
    public function createResponseParser()
    {
        return new ResponseParser();
    }

    /**
     * instantiate the best available protocol request parser implementation
     *
     * This is most useful for a redis server implementation which needs to
     * process client requests.
     *
     * @return ParserInterface
     */
    public function createRequestParser()
    {
        return new RequestParser();
    }

    /**
     * instantiate the best available protocol serializer implementation
     *
     * @return SerializerInterface
     */
    public function createSerializer()
    {
        return new RecursiveSerializer();
    }
}
