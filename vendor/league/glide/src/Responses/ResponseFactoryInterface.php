<?php

namespace League\Glide\Responses;

use League\Flysystem\FilesystemOperator;

interface ResponseFactoryInterface
{
    /**
     * Create response.
     *
     * @param FilesystemOperator $cache Cache file system.
     * @param string             $path  Cached file path.
     *
     * @return mixed The response object.
     */
    public function create(FilesystemOperator $cache, $path);
}
