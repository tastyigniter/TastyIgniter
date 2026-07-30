<?php

namespace Ratchet\RFC6455\Test\Unit\Messaging;

use Ratchet\RFC6455\Messaging\Frame;
use Ratchet\RFC6455\Messaging\Message;
use PHPUnit\Framework\TestCase;

/**
 * @covers Ratchet\RFC6455\Messaging\Message
 */
class MessageTest extends TestCase {
    /** @var Message */
    protected $message;

    protected function setUp(): void {
        $this->message = new Message;
    }

    public function testNoFrames(): void {
        $this->assertFalse($this->message->isCoalesced());
    }

    public function testNoFramesOpCode(): void {
        $this->expectException(\UnderflowException::class);
        $this->message->getOpCode();
    }

    public function testFragmentationPayload(): void {
        $a = 'Hello ';
        $b = 'World!';
        $f1 = new Frame($a, false);
        $f2 = new Frame($b, true, Frame::OP_CONTINUE);
        $this->message->addFrame($f1)->addFrame($f2);
        $this->assertEquals(strlen($a . $b), $this->message->getPayloadLength());
        $this->assertEquals($a . $b, $this->message->getPayload());
    }

    public function testUnbufferedFragment(): void {
        $this->message->addFrame(new Frame('The quick brow', false));
        $this->expectException(\UnderflowException::class);
        $this->message->getPayload();
    }

    public function testGetOpCode(): void {
        $this->message
            ->addFrame(new Frame('The quick brow', false, Frame::OP_TEXT))
            ->addFrame(new Frame('n fox jumps ov', false, Frame::OP_CONTINUE))
            ->addFrame(new Frame('er the lazy dog', true, Frame::OP_CONTINUE))
        ;
        $this->assertEquals(Frame::OP_TEXT, $this->message->getOpCode());
    }

    public function testGetUnBufferedPayloadLength(): void {
        $this->message
            ->addFrame(new Frame('The quick brow', false, Frame::OP_TEXT))
            ->addFrame(new Frame('n fox jumps ov', false, Frame::OP_CONTINUE))
        ;
        $this->assertEquals(28, $this->message->getPayloadLength());
    }
}
