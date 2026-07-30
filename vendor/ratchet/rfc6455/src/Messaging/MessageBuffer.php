<?php
namespace Ratchet\RFC6455\Messaging;

use Ratchet\RFC6455\Handshake\PermessageDeflateOptions;

class MessageBuffer {
    private CloseFrameChecker $closeFrameChecker;

    /**
     * @var callable
     */
    private $exceptionFactory;

    private ?MessageInterface $messageBuffer = null;

    private ?FrameInterface $frameBuffer = null;

    /**
     * @var callable
     */
    private $onMessage;

    /**
     * @var callable
     */
    private $onControl;

    private bool $checkForMask;

    /**
     * @var callable
     */
    private $sender;

    private string $leftovers = '';

    private int $streamingMessageOpCode = -1;

    private PermessageDeflateOptions $permessageDeflateOptions;

    private bool $deflateEnabled;

    private int $maxMessagePayloadSize;

    private int $maxFramePayloadSize;

    private bool $compressedMessage = false;

    /**
     * @var resource|bool|null
     */
    private $inflator = null;

    /**
     * @var resource|bool|null
     */
    private $deflator = null;

    public function __construct(
        CloseFrameChecker $frameChecker,
        callable $onMessage,
        ?callable $onControl = null,
        bool $expectMask = true,
        ?callable $exceptionFactory = null,
        ?int $maxMessagePayloadSize = null, // null for default - zero for no limit
        ?int $maxFramePayloadSize = null,   // null for default - zero for no limit
        ?callable $sender = null,
        ?PermessageDeflateOptions $permessageDeflateOptions = null
    ) {
        $this->closeFrameChecker = $frameChecker;
        $this->checkForMask = $expectMask;

        $this->exceptionFactory = $exceptionFactory ?: static fn (string $msg) => new \UnderflowException($msg);

        $this->onMessage = $onMessage;
        $this->onControl = $onControl ?: static function (): void {};

        $this->sender = $sender;

        $this->permessageDeflateOptions = $permessageDeflateOptions ?: PermessageDeflateOptions::createDisabled();

        $this->deflateEnabled = $this->permessageDeflateOptions->isEnabled();

        if ($this->deflateEnabled && !is_callable($this->sender)) {
            throw new \InvalidArgumentException('sender must be set when deflate is enabled');
        }

        $memory_limit_bytes = static::getMemoryLimit();

        if ($maxMessagePayloadSize === null) {
            $maxMessagePayloadSize = (int)($memory_limit_bytes / 4);
        }
        if ($maxFramePayloadSize === null) {
            $maxFramePayloadSize = (int)($memory_limit_bytes / 4);
        }

        if ($maxFramePayloadSize > 0x7FFFFFFFFFFFFFFF || $maxFramePayloadSize < 0) { // this should be interesting on non-64 bit systems
            throw new \InvalidArgumentException($maxFramePayloadSize . ' is not a valid maxFramePayloadSize');
        }
        $this->maxFramePayloadSize = $maxFramePayloadSize;

        if ($maxMessagePayloadSize > 0x7FFFFFFFFFFFFFFF || $maxMessagePayloadSize < 0) {
            throw new \InvalidArgumentException($maxMessagePayloadSize . 'is not a valid maxMessagePayloadSize');
        }
        $this->maxMessagePayloadSize = $maxMessagePayloadSize;
    }

    public function onData(string $data): void {
        $data = $this->leftovers . $data;
        $dataLen = strlen($data);

        if ($dataLen < 2) {
            $this->leftovers = $data;

            return;
        }

        $frameStart = 0;
        while ($frameStart + 2 <= $dataLen) {
            $headerSize     = 2;
            $payload_length = unpack('C', $data[$frameStart + 1] & "\x7f")[1];
            $isMasked       = ($data[$frameStart + 1] & "\x80") === "\x80";
            $headerSize     += $isMasked ? 4 : 0;
            $payloadLenOver2GB = false;
            if ($payload_length > 125 && ($dataLen - $frameStart < $headerSize + 125)) {
                // no point of checking - this frame is going to be bigger than the buffer is right now
                break;
            }
            if ($payload_length > 125) {
                $payloadLenBytes = $payload_length === 126 ? 2 : 8;
                $headerSize      += $payloadLenBytes;
                $bytesToUpack    = substr($data, $frameStart + 2, $payloadLenBytes);

                if ($payload_length === 126){
                    $payload_length = unpack('n', $bytesToUpack)[1];
                } else {
                    $payloadLenOver2GB = unpack('N', $bytesToUpack)[1] > 0; //Decode only the 4 first bytes
                    if (PHP_INT_SIZE == 4) { // if 32bits PHP
                        $bytesToUpack = substr($bytesToUpack, 4); //Keep only 4 last bytes
                        $payload_length = unpack('N', $bytesToUpack)[1];
                    } else {
                        $payload_length = unpack('J', $bytesToUpack)[1];
                    }
                }
            }

            $closeFrame = null;

            if ($payload_length < 0) {
                // this can happen when unpacking in php
                $closeFrame = $this->newCloseFrame(Frame::CLOSE_PROTOCOL, 'Invalid frame length');
            }

            if (!$closeFrame && PHP_INT_SIZE == 4 && $payloadLenOver2GB) {
                $closeFrame = $this->newCloseFrame(Frame::CLOSE_TOO_BIG, 'Frame over 2GB can\'t be handled on 32bits PHP');
            }

            if (!$closeFrame && $this->maxFramePayloadSize > 1 && $payload_length > $this->maxFramePayloadSize) {
                $closeFrame = $this->newCloseFrame(Frame::CLOSE_TOO_BIG, 'Maximum frame size exceeded');
            }

            if (!$closeFrame && $this->maxMessagePayloadSize > 0
                && $payload_length + ($this->messageBuffer ? $this->messageBuffer->getPayloadLength() : 0) > $this->maxMessagePayloadSize) {
                $closeFrame = $this->newCloseFrame(Frame::CLOSE_TOO_BIG, 'Maximum message size exceeded');
            }

            if ($closeFrame !== null) {
                $onControl = $this->onControl;
                $onControl($closeFrame);
                $this->leftovers = '';

                return;
            }

            $isCoalesced = $dataLen - $frameStart >= $payload_length + $headerSize;
            if (!$isCoalesced) {
                break;
            }
            $this->processData(substr($data, $frameStart, $payload_length + $headerSize));
            $frameStart = $frameStart + $payload_length + $headerSize;
        }

        $this->leftovers = substr($data, $frameStart);
    }

    /**
     * @param string $data
     * @return void
     */
    private function processData(string $data): void {
        $this->messageBuffer ?: $this->messageBuffer = $this->newMessage();
        $this->frameBuffer   ?: $this->frameBuffer   = $this->newFrame();

        $this->frameBuffer->addBuffer($data);

        $onMessage = $this->onMessage;
        $onControl = $this->onControl;

        $this->frameBuffer = $this->frameCheck($this->frameBuffer);

        $this->frameBuffer->unMaskPayload();

        $opcode = $this->frameBuffer->getOpcode();

        if ($opcode > 2) {
            $onControl($this->frameBuffer, $this);

            if (Frame::OP_CLOSE === $opcode) {
                return;
            }
        } else {
            if ($this->messageBuffer->count() === 0 && $this->frameBuffer->getRsv1()) {
                $this->compressedMessage = true;
            }
            if ($this->compressedMessage) {
                $this->frameBuffer = $this->inflateFrame($this->frameBuffer);
            }

            $this->messageBuffer->addFrame($this->frameBuffer);
        }

        $this->frameBuffer = null;

        if ($this->messageBuffer->isCoalesced()) {
            $msgCheck = $this->checkMessage($this->messageBuffer);

            $msgBuffer = $this->messageBuffer;
            $this->messageBuffer = null;

            if (true !== $msgCheck) {
                $onControl($this->newCloseFrame($msgCheck, 'Ratchet detected an invalid UTF-8 payload'), $this);
            } else {
                $onMessage($msgBuffer, $this);
            }

            $this->messageBuffer = null;
            $this->compressedMessage = false;

            if ($this->permessageDeflateOptions->getServerNoContextTakeover()) {
                $this->inflator = null;
            }
        }
    }

    /**
     * Check a frame to be added to the current message buffer
     * @param FrameInterface $frame
     * @return FrameInterface
     */
    public function frameCheck(FrameInterface $frame): FrameInterface {
        if ((false !== $frame->getRsv1() && !$this->deflateEnabled) ||
            false !== $frame->getRsv2() ||
            false !== $frame->getRsv3()
        ) {
            return $this->newCloseFrame(Frame::CLOSE_PROTOCOL, 'Ratchet detected an invalid reserve code');
        }

        if ($this->checkForMask && !$frame->isMasked()) {
            return $this->newCloseFrame(Frame::CLOSE_PROTOCOL, 'Ratchet detected an incorrect frame mask');
        }

        $opcode = $frame->getOpcode();

        if ($opcode > 2) {
            if ($frame->getPayloadLength() > 125 || !$frame->isFinal()) {
                return $this->newCloseFrame(Frame::CLOSE_PROTOCOL, 'Ratchet detected a mismatch between final bit and indicated payload length');
            }

            switch ($opcode) {
                case Frame::OP_CLOSE:
                    $closeCode = 0;

                    $bin = $frame->getPayload();

                    if (empty($bin)) {
                        return $this->newCloseFrame(Frame::CLOSE_NORMAL);
                    }

                    if (strlen($bin) === 1) {
                        return $this->newCloseFrame(Frame::CLOSE_PROTOCOL, 'Ratchet detected an invalid close code');
                    }

                    if (strlen($bin) >= 2) {
                        list($closeCode) = array_merge(unpack('n*', substr($bin, 0, 2)));
                    }

                    $checker = $this->closeFrameChecker;
                    if (!$checker($closeCode)) {
                        return $this->newCloseFrame(Frame::CLOSE_PROTOCOL, 'Ratchet detected an invalid close code');
                    }

                    if (!$this->checkUtf8(substr($bin, 2))) {
                        return $this->newCloseFrame(Frame::CLOSE_BAD_PAYLOAD, 'Ratchet detected an invalid UTF-8 payload in the close reason');
                    }

                    return $frame;
                case Frame::OP_PING:
                case Frame::OP_PONG:
                    break;
                default:
                    return $this->newCloseFrame(Frame::CLOSE_PROTOCOL, 'Ratchet detected an invalid OP code');
            }

            return $frame;
        }

        if (Frame::OP_CONTINUE === $frame->getOpcode() && 0 === count($this->messageBuffer)) {
            return $this->newCloseFrame(Frame::CLOSE_PROTOCOL, 'Ratchet detected the first frame of a message was a continue');
        }

        if (count($this->messageBuffer) > 0 && Frame::OP_CONTINUE !== $frame->getOpcode()) {
            return $this->newCloseFrame(Frame::CLOSE_PROTOCOL, 'Ratchet detected invalid OP code when expecting continue frame');
        }

        return $frame;
    }

    /**
     * Determine if a message is valid
     * @param MessageInterface
     * @return bool|int true if valid - false if incomplete - int of recommended close code
     */
    public function checkMessage(MessageInterface $message) {
        if (!$message->isBinary()) {
            if (!$this->checkUtf8($message->getPayload())) {
                return Frame::CLOSE_BAD_PAYLOAD;
            }
        }

        return true;
    }

    private function checkUtf8(string $string): bool {
        if (extension_loaded('mbstring')) {
            return mb_check_encoding($string, 'UTF-8');
        }

        return preg_match('//u', $string);
    }

    /**
     * @return MessageInterface
     */
    public function newMessage(): MessageInterface {
        return new Message;
    }

    /**
     * @param string|null $payload
     * @param bool        $final
     * @param int         $opcode
     * @return FrameInterface
     */
    public function newFrame(?string $payload = null, bool $final = true, int $opcode = Frame::OP_TEXT): FrameInterface {
        return new Frame($payload, $final, $opcode, $this->exceptionFactory);
    }

    public function newCloseFrame(int $code, string $reason = ''): FrameInterface {
        return $this->newFrame(pack('n', $code) . $reason, true, Frame::OP_CLOSE);
    }

    public function sendFrame(FrameInterface $frame): void {
        if ($this->sender === null) {
            throw new \Exception('To send frames using the MessageBuffer, sender must be set.');
        }

        if ($this->deflateEnabled &&
            ($frame->getOpcode() === Frame::OP_TEXT || $frame->getOpcode() === Frame::OP_BINARY)) {
            $frame = $this->deflateFrame($frame);
        }

        if (!$this->checkForMask) {
            $frame->maskPayload();
        }

        $sender = $this->sender;
        $sender($frame->getContents());
    }

    public function sendMessage(string $messagePayload, bool $final = true, bool $isBinary = false): void {
        $opCode = $isBinary ? Frame::OP_BINARY : Frame::OP_TEXT;
        if ($this->streamingMessageOpCode === -1) {
            $this->streamingMessageOpCode = $opCode;
        }

        if ($this->streamingMessageOpCode !== $opCode) {
            throw new \Exception('Binary and text message parts cannot be streamed together.');
        }

        $frame = $this->newFrame($messagePayload, $final, $opCode);

        $this->sendFrame($frame);

        if ($final) {
            // reset deflator if client doesn't remember contexts
            if ($this->getDeflateNoContextTakeover()) {
                $this->deflator = null;
            }
            $this->streamingMessageOpCode = -1;
        }
    }

    private function getDeflateNoContextTakeover(): ?bool {
        return $this->checkForMask ?
            $this->permessageDeflateOptions->getServerNoContextTakeover() :
            $this->permessageDeflateOptions->getClientNoContextTakeover();
    }

    private function getDeflateWindowBits(): int {
        return $this->checkForMask ? $this->permessageDeflateOptions->getServerMaxWindowBits() : $this->permessageDeflateOptions->getClientMaxWindowBits();
    }

    private function getInflateNoContextTakeover(): ?bool {
        return $this->checkForMask ?
            $this->permessageDeflateOptions->getClientNoContextTakeover() :
            $this->permessageDeflateOptions->getServerNoContextTakeover();
    }

    private function getInflateWindowBits(): int {
        return $this->checkForMask ? $this->permessageDeflateOptions->getClientMaxWindowBits() : $this->permessageDeflateOptions->getServerMaxWindowBits();
    }

    private function inflateFrame(FrameInterface $frame): Frame {
        if ($this->inflator === null) {
            $this->inflator = inflate_init(
                ZLIB_ENCODING_RAW,
                [
                    'level'    => -1,
                    'memory'   => 8,
                    'window'   => $this->getInflateWindowBits(),
                    'strategy' => ZLIB_DEFAULT_STRATEGY
                ]
            );
        }

        $terminator = '';
        if ($frame->isFinal()) {
            $terminator = "\x00\x00\xff\xff";
        }

        gc_collect_cycles(); // memory runs away if we don't collect ??

        return new Frame(
            inflate_add($this->inflator, $frame->getPayload() . $terminator),
            $frame->isFinal(),
            $frame->getOpcode()
        );
    }

    private function deflateFrame(FrameInterface $frame): FrameInterface
    {
        if ($frame->getRsv1()) {
            return $frame; // frame is already deflated
        }

        if ($this->deflator === null) {
            $bits = $this->getDeflateWindowBits();
            if ($bits === 8) {
                $bits = 9;
            }
            $this->deflator = deflate_init(
                ZLIB_ENCODING_RAW,
                [
                    'level'    => -1,
                    'memory'   => 8,
                    'window'   => $bits,
                    'strategy' => ZLIB_DEFAULT_STRATEGY
                ]
            );
        }

        // there is an issue in the zlib extension for php where
        // deflate_add does not check avail_out to see if the buffer filled
        // this only seems to be an issue for payloads between 16 and 64 bytes
        // This if statement is a hack fix to break the output up allowing us
        // to call deflate_add twice which should clear the buffer issue
//        if ($frame->getPayloadLength() >= 16 && $frame->getPayloadLength() <= 64) {
//            // try processing in 8 byte chunks
//            // https://bugs.php.net/bug.php?id=73373
//            $payload = "";
//            $orig = $frame->getPayload();
//            $partSize = 8;
//            while (strlen($orig) > 0) {
//                $part = substr($orig, 0, $partSize);
//                $orig = substr($orig, strlen($part));
//                $flags = strlen($orig) > 0 ? ZLIB_PARTIAL_FLUSH : ZLIB_SYNC_FLUSH;
//                $payload .= deflate_add($this->deflator, $part, $flags);
//            }
//        } else {
        $payload = deflate_add(
            $this->deflator,
            $frame->getPayload(),
            ZLIB_SYNC_FLUSH
        );
//        }

        $deflatedFrame = new Frame(
            substr($payload, 0, $frame->isFinal() ? -4 : strlen($payload)),
            $frame->isFinal(),
            $frame->getOpcode()
        );

        if ($frame->isFinal()) {
            $deflatedFrame->setRsv1();
        }

        return $deflatedFrame;
    }

    /**
     * This is a separate function for testing purposes
     * $memory_limit is only used for testing
     *
     * @param null|string $memory_limit
     * @return int
     */
    private static function getMemoryLimit(?string $memory_limit = null): int {
        $memory_limit = $memory_limit === null ? \trim(\ini_get('memory_limit')) : $memory_limit;
        $memory_limit_bytes = 0;
        if ($memory_limit !== '') {
            $shifty = ['k' => 0, 'm' => 10, 'g' => 20];
            $multiplier = strlen($memory_limit) > 1 ? substr(strtolower($memory_limit), -1) : '';
            $memory_limit = (int)$memory_limit;
            $memory_limit_bytes = in_array($multiplier, array_keys($shifty), true) ? $memory_limit * 1024 << $shifty[$multiplier] : $memory_limit;
        }

        return $memory_limit_bytes < 0 ? 0 : $memory_limit_bytes;
    }
}
