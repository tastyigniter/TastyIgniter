<?php

namespace Clue\Redis\Protocol\Serializer;

use Clue\Redis\Protocol\Model\ModelInterface;
use Clue\Redis\Protocol\Model\MultiBulkReply;

interface SerializerInterface
{
    /**
     * create a serialized unified request protocol message
     *
     * This is the *one* method most redis client libraries will likely want to
     * use in order to send a serialized message (a request) over the* wire to
     * your redis server instance.
     *
     * This method should be used in favor of constructing a request model and
     * then serializing it. While its effect might be equivalent, this method
     * is likely to (i.e. it /could/) provide a faster implementation.
     *
     * @param string $command
     * @param array $args
     * @return string
     * @see self::createRequestMessage()
     */
    public function getRequestMessage($command, array $args = array());

    /**
     * create a unified request protocol message model
     *
     * @param string $command
     * @param array $args
     * @return MultiBulkReply
     */
    public function createRequestModel($command, array $args = array());

    /**
     * create a serialized unified protocol reply message
     *
     * This is most useful for a redis server implementation which needs to
     * process client requests and send resulting reply messages.
     *
     * This method does its best to guess to right reply type and then returns
     * a serialized version of the message. It follows the "redis to lua
     * conversion table" (see link) which means most basic types can be mapped
     * as is.
     *
     * This method should be used in favor of constructing a reply model and
     * then serializing it. While its effect might be equivalent, this method
     * is likely to (i.e. it /could/) provide a faster implementation.
     *
     * Note however, you may still want to explicitly create a nested reply
     * model hierarchy if you need more control over the serialized message. For
     * instance, a null value will always be returned as a Null-Bulk-Reply, so
     * there's no way to express a Null-Multi-Bulk-Reply, unless you construct
     * it explicitly.
     *
     * @param mixed $data
     * @return string
     * @see self::createReplyModel()
     * @link http://redis.io/commands/eval
     */
    public function getReplyMessage($data);

    /**
     * create response message by determining datatype from given argument
     *
     * @param mixed $data
     * @return ModelInterface
     */
    public function createReplyModel($data);

    public function getBulkMessage($data);

    public function getErrorMessage($data);

    public function getIntegerMessage($data);

    public function getMultiBulkMessage($data);

    public function getStatusMessage($data);
}
