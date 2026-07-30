<?php

declare(strict_types=1);

/*
 * This file is part of the JsonSchema package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JsonSchema\Uri\Retrievers;

use JsonSchema\Exception\ResourceNotFoundException;

/**
 * Tries to retrieve JSON schemas from a URI using file_get_contents()
 *
 * @author Sander Coolen <sander@jibber.nl>
 */
class FileGetContents extends AbstractRetriever
{
    protected $messageBody;

    /**
     * {@inheritdoc}
     *
     * @see \JsonSchema\Uri\Retrievers\UriRetrieverInterface::retrieve()
     */
    public function retrieve($uri)
    {
        if (function_exists('http_clear_last_response_headers')) {
            http_clear_last_response_headers();
        }

        $errorMessage = null;
        set_error_handler(function ($errno, $errstr) use (&$errorMessage) {
            $errorMessage = $errstr;
        });
        $response = file_get_contents($uri);
        restore_error_handler();

        if ($errorMessage) {
            throw new ResourceNotFoundException($errorMessage);
        }

        if (false === $response) {
            throw new ResourceNotFoundException('JSON schema not found at ' . $uri);
        }

        if ($response == ''
            && substr($uri, 0, 7) == 'file://' && substr($uri, -1) == '/'
        ) {
            throw new ResourceNotFoundException('JSON schema not found at ' . $uri);
        }

        $this->messageBody = $response;

        if (function_exists('http_get_last_response_headers')) {
            // Use http_get_last_response_headers() for compatibility with PHP 8.5+
            // where $http_response_header is deprecated.
            $httpResponseHeaders = http_get_last_response_headers();
        } else {
            /** @phpstan-ignore nullCoalesce.variable ($http_response_header can non-existing when no http request was done) */
            $httpResponseHeaders = $http_response_header ?? [];
        }

        if (!empty($httpResponseHeaders)) {
            $this->fetchContentType($httpResponseHeaders);
        } else {
            $this->contentType = null;
        }

        return $this->messageBody;
    }

    /**
     * @param array $headers HTTP Response Headers
     *
     * @return bool Whether the Content-Type header was found or not
     */
    private function fetchContentType(array $headers): bool
    {
        foreach (array_reverse($headers) as $header) {
            if ($this->contentType = self::getContentTypeMatchInHeader($header)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $header
     *
     * @return string|null
     */
    protected static function getContentTypeMatchInHeader($header)
    {
        if (0 < preg_match("/Content-Type:(\V*)/ims", $header, $match)) {
            return trim($match[1]);
        }

        return null;
    }
}
