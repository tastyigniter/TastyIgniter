<?php
namespace Ratchet\RFC6455\Messaging;

interface DataInterface extends \Stringable {
    /**
     * Determine if the message is complete or still fragmented
     * @return bool
     */
    public function isCoalesced(): bool;

    /**
     * Get the number of bytes the payload is set to be
     * @return int
     */
    public function getPayloadLength(): int;

    /**
     * Get the payload (message) sent from peer
     * @return string
     */
    public function getPayload(): string;

    /**
     * Get raw contents of the message
     * @return string
     */
    public function getContents(): string;
}
