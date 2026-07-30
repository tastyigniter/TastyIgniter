<?php

namespace Laravel\Reverb\Servers\Reverb\Http;

use GuzzleHttp\Psr7\Message;
use OverflowException;
use Psr\Http\Message\RequestInterface;

class Request
{
    /**
     * End of message delimiter.
     *
     * @var string
     */
    const EOM = "\r\n\r\n";

    /**
     * Turn the raw message into a Psr7 request.
     */
    public static function from(string $message, Connection $connection, int $maxRequestSize): ?RequestInterface
    {
        $connection->appendToBuffer($message);

        if ($connection->bufferLength() > $maxRequestSize) {
            throw new OverflowException('Maximum HTTP buffer size of '.$maxRequestSize.'exceeded.');
        }

        if (static::isEndOfMessage($buffer = $connection->buffer())) {
            $request = Message::parseRequest($buffer);

            if (! $contentLength = $request->getHeader('Content-Length')) {
                return $request;
            }

            if ($request->getBody()->getSize() < $contentLength[0] ?? 0) {
                return null;
            }

            $connection->clearBuffer();

            return $request;
        }

        return null;
    }

    /**
     * Determine if the message has been buffered as per the HTTP specification
     */
    protected static function isEndOfMessage(string $message): bool
    {
        return (bool) strpos($message, static::EOM);
    }
}
