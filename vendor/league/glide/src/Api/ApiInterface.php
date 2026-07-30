<?php

namespace League\Glide\Api;

interface ApiInterface
{
    /**
     * Perform image manipulations.
     *
     * @param string $source Source image binary data.
     * @param array  $params The manipulation params.
     *
     * @return string Manipulated image binary data.
     */
    public function run($source, array $params);
}
