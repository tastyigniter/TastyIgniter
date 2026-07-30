<?php
namespace Ratchet\RFC6455\Messaging;

interface MessageInterface extends DataInterface, \Traversable, \Countable {
    /**
     * @param FrameInterface $fragment
     * @return MessageInterface
     */
    public function addFrame(FrameInterface $fragment): self;

    /**
     * @return int
     */
    public function getOpcode(): int;

    /**
     * @return bool
     */
    public function isBinary(): bool;
}
