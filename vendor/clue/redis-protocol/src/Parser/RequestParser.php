<?php

namespace Clue\Redis\Protocol\Parser;

use Clue\Redis\Protocol\Model\Request;

class RequestParser implements ParserInterface
{
    const CRLF = "\r\n";

    private $incomingBuffer = '';
    private $incomingOffset = 0;

    public function pushIncoming($dataChunk)
    {
        $this->incomingBuffer .= $dataChunk;

        $parsed = array();

        do {
            $saved = $this->incomingOffset;
            $message = $this->readRequest();
            if ($message === null) {
                // restore previous position for next parsing attempt
                $this->incomingOffset = $saved;
                break;
            }

            if ($message !== false) {
                $parsed []= $message;
            }
        } while($this->incomingBuffer !== '');

        if ($this->incomingOffset !== 0) {
            $this->incomingBuffer = (string)substr($this->incomingBuffer, $this->incomingOffset);
            $this->incomingOffset = 0;
        }

        return $parsed;
    }

    /**
     * try to parse request from incoming buffer
     *
     * @throws ParserException if the incoming buffer is invalid
     * @return Request|null
     */
    private function readRequest()
    {
        $crlf = strpos($this->incomingBuffer, "\r\n", $this->incomingOffset);
        if ($crlf === false) {
            return null;
        }

        // line starts with a multi-bulk header "*"
        if (isset($this->incomingBuffer[$this->incomingOffset]) && $this->incomingBuffer[$this->incomingOffset] === '*') {
            $line = substr($this->incomingBuffer, $this->incomingOffset + 1, $crlf - $this->incomingOffset + 1);
            $this->incomingOffset = $crlf + 2;
            $count = (int)$line;

            if ($count <= 0) {
                return false;
            }
            $command = null;
            $args    = array();
            for ($i = 0; $i < $count; ++$i) {
                $sub = $this->readBulk();
                if ($sub === null) {
                    return null;
                }
                if ($command === null) {
                    $command = $sub;
                } else {
                    $args []= $sub;
                }
            }
            return new Request($command, $args);
        }

        // parse an old inline request instead
        $line = substr($this->incomingBuffer, $this->incomingOffset, $crlf - $this->incomingOffset);
        $this->incomingOffset = $crlf + 2;

        $args = preg_split('/ +/', trim($line, ' '));
        $command = array_shift($args);

        if ($command === '') {
            return false;
        }

        return new Request($command, $args);
    }

    private function readBulk()
    {
        $crlf = strpos($this->incomingBuffer, "\r\n", $this->incomingOffset);
        if ($crlf === false) {
            return null;
        }

        // line has to start with a bulk header "$"
        if (!isset($this->incomingBuffer[$this->incomingOffset]) || $this->incomingBuffer[$this->incomingOffset] !== '$') {
            throw new ParserException('ERR Protocol error: expected \'$\', got \'' . substr($this->incomingBuffer, $this->incomingOffset, 1) . '\'');
        }

        $line = substr($this->incomingBuffer, $this->incomingOffset + 1, $crlf - $this->incomingOffset + 1);
        $this->incomingOffset = $crlf + 2;
        $size = (int)$line;

        if ($size < 0) {
            throw new ParserException('ERR Protocol error: invalid bulk length');
        }

        if (!isset($this->incomingBuffer[$this->incomingOffset + $size + 1])) {
            // check enough bytes + crlf are buffered
            return null;
        }

        $ret = substr($this->incomingBuffer, $this->incomingOffset, $size);
        $this->incomingOffset += $size + 2;

        return $ret;
    }
}
