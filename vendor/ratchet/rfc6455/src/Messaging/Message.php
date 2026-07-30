<?php
namespace Ratchet\RFC6455\Messaging;

class Message implements \IteratorAggregate, MessageInterface {
    private \SplDoublyLinkedList $_frames;

    private int $len;

    public function __construct() {
        $this->_frames = new \SplDoublyLinkedList;
        $this->len = 0;
    }

    public function getIterator(): \Traversable {
        return $this->_frames;
    }

    /**
     * {@inheritdoc}
     */
    public function count(): int {
        return count($this->_frames);
    }

    /**
     * {@inheritdoc}
     */
    public function isCoalesced(): bool {
        if (count($this->_frames) == 0) {
            return false;
        }

        $last = $this->_frames->top();

        return $last->isCoalesced() && $last->isFinal();
    }

    /**
     * {@inheritdoc}
     */
    public function addFrame(FrameInterface $fragment): MessageInterface {
        $this->len += $fragment->getPayloadLength();
        $this->_frames->push($fragment);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOpcode(): int {
        if (count($this->_frames) == 0) {
            throw new \UnderflowException('No frames have been added to this message');
        }

        return $this->_frames->bottom()->getOpcode();
    }

    /**
     * {@inheritdoc}
     */
    public function getPayloadLength(): int {
        return $this->len;
    }

    /**
     * {@inheritdoc}
     */
    public function getPayload(): string {
        if (!$this->isCoalesced()) {
            throw new \UnderflowException('Message has not been put back together yet');
        }

        return $this->__toString();
    }

    /**
     * {@inheritdoc}
     */
    public function getContents(): string {
        if (!$this->isCoalesced()) {
            throw new \UnderflowException("Message has not been put back together yet");
        }

        $buffer = '';

        foreach ($this->_frames as $frame) {
            $buffer .= $frame->getContents();
        }

        return $buffer;
    }

    public function __toString(): string {
        $buffer = '';

        foreach ($this->_frames as $frame) {
            $buffer .= $frame->getPayload();
        }

        return $buffer;
    }

    /**
     * @return boolean
     */
    public function isBinary(): bool {
        if ($this->_frames->isEmpty()) {
            throw new \UnderflowException('Not enough data has been received to determine if message is binary');
        }

        return Frame::OP_BINARY === $this->_frames->bottom()->getOpcode();
    }

    /**
     * @return boolean
     */
    public function getRsv1(): bool {
        if ($this->_frames->isEmpty()) {
            return false;
            //throw new \UnderflowException('Not enough data has been received to determine if message is binary');
        }

        return $this->_frames->bottom()->getRsv1();
    }
}
