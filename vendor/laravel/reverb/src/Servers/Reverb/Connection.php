<?php

namespace Laravel\Reverb\Servers\Reverb;

use Evenement\EventEmitter;
use Laravel\Reverb\Contracts\WebSocketConnection;
use Laravel\Reverb\Servers\Reverb\Http\Connection as HttpConnection;
use Ratchet\RFC6455\Messaging\CloseFrameChecker;
use Ratchet\RFC6455\Messaging\DataInterface;
use Ratchet\RFC6455\Messaging\Frame;
use Ratchet\RFC6455\Messaging\FrameInterface;
use Ratchet\RFC6455\Messaging\MessageBuffer;

class Connection extends EventEmitter implements WebSocketConnection
{
    /**
     * The message buffer.
     *
     * @var MessageBuffer
     */
    protected $buffer;

    /**
     * The message handler.
     *
     * @var ?callable
     */
    protected $onMessage;

    /**
     * The control frame handler.
     *
     * @var ?callable
     */
    protected $onControl;

    /**
     * The connection close handler.
     *
     * @var ?callable
     */
    protected $onClose;

    /**
     * The maximum number of allowed bytes for each message.
     *
     * @var int
     */
    protected $maxMessageSize;

    /**
     * Create a new websocket connection instance.
     */
    public function __construct(public HttpConnection $connection)
    {
        //
    }

    /**
     * Undocumented function
     */
    public function openBuffer(): void
    {
        $this->buffer = new MessageBuffer(
            new CloseFrameChecker,
            maxMessagePayloadSize: $this->maxMessageSize,
            onMessage: $this->onMessage ?: fn () => null,
            onControl: fn (FrameInterface $message) => $this->control($message),
            sender: [$this->connection, 'send']
        );

        $this->connection->on('data', [$this->buffer, 'onData']);
        $this->connection->on('close', $this->onClose ?: fn () => null);
    }

    /**
     * Send a message to the connection.
     */
    public function send(mixed $message): void
    {
        $this->connection->send(
            $message instanceof DataInterface ?
                $message->getContents() :
                (new Frame($message))->getContents()
        );
    }

    /**
     * Handle control frames.
     */
    public function control(FrameInterface $message): void
    {
        if ($this->onControl) {
            ($this->onControl)($message);
        }

        match ($message->getOpcode()) {
            Frame::OP_PING => $this->send(new Frame($message->getPayload(), opcode: Frame::OP_PONG)),
            Frame::OP_PONG => fn () => null,
            Frame::OP_CLOSE => $this->close($message),
        };
    }

    /**
     * Set the message handler.
     */
    public function onMessage(callable $callback): void
    {
        $this->onMessage = $callback;
    }

    /**
     * Set the control frame handler.
     */
    public function onControl(callable $callback): void
    {
        $this->onControl = $callback;
    }

    /**
     * Set the close handler.
     */
    public function onClose(callable $callback): void
    {
        $this->onClose = $callback;
    }

    /**
     * Set the maximum number of allowed bytes for each message from the client.
     */
    public function withMaxMessageSize(int $size): void
    {
        $this->maxMessageSize = $size;
    }

    /**
     * Close the connection.
     */
    public function close(mixed $message = null): void
    {
        if ($message) {
            $frame = $message instanceof FrameInterface ?
                $message :
                new Frame($message, opcode: Frame::OP_CLOSE);

            $this->send($frame);
        }

        $this->connection->close();
    }

    /**
     * Get the raw socket connection identifier.
     */
    public function id(): int
    {
        return $this->connection->id();
    }
}
