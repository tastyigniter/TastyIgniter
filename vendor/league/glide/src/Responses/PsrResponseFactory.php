<?php

namespace League\Glide\Responses;

use Closure;
use League\Flysystem\FilesystemOperator;
use Psr\Http\Message\ResponseInterface;

class PsrResponseFactory implements ResponseFactoryInterface
{
    /**
     * Base response object.
     *
     * @var ResponseInterface
     */
    protected $response;

    /**
     * Callback to create stream.
     *
     * @var Closure
     */
    protected $streamCallback;

    /**
     * Create PsrResponseFactory instance.
     *
     * @param ResponseInterface $response       Base response object.
     * @param Closure           $streamCallback Callback to create stream.
     */
    public function __construct(ResponseInterface $response, Closure $streamCallback)
    {
        $this->response = $response;
        $this->streamCallback = $streamCallback;
    }

    /**
     * Create response.
     *
     * @param FilesystemOperator $cache Cache file system.
     * @param string             $path  Cached file path.
     *
     * @return ResponseInterface Response object.
     */
    public function create(FilesystemOperator $cache, $path)
    {
        $stream = $this->streamCallback->__invoke(
            $cache->readStream($path)
        );

        $contentType = $cache->mimeType($path);
        $contentLength = (string) $cache->fileSize($path);
        $cacheControl = 'max-age=31536000, public';
        $expires = date_create('+1 years')->format('D, d M Y H:i:s').' GMT';

        return $this->response->withBody($stream)
            ->withHeader('Content-Type', $contentType)
            ->withHeader('Content-Length', $contentLength)
            ->withHeader('Cache-Control', $cacheControl)
            ->withHeader('Expires', $expires);
    }
}
