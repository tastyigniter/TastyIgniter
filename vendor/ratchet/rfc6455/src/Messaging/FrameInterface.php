<?php
namespace Ratchet\RFC6455\Messaging;

interface FrameInterface extends DataInterface {
    /**
     * Add incoming data to the frame from peer
     * @param string
     */
    public function addBuffer(string $buf): void;

    /**
     * Is this the final frame in a fragmented message?
     * @return bool
     */
    public function isFinal(): bool;

    /**
     * Is the payload masked?
     * @return bool
     */
    public function isMasked(): bool;

    /**
     * @return int
     */
    public function getOpcode(): int;

    /**
     * @return int
     */
    //public function getReceivedPayloadLength(): int;

    /**
     * 32-big string
     * @return string
     */
    public function getMaskingKey(): string;
}
