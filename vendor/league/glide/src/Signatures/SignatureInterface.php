<?php

namespace League\Glide\Signatures;

interface SignatureInterface
{
    /**
     * Add an HTTP signature to manipulation params.
     *
     * @param string $path   The resource path.
     * @param array  $params The manipulation params.
     *
     * @return array The updated manipulation params.
     */
    public function addSignature($path, array $params);

    /**
     * Validate a request signature.
     *
     * @param string $path   The resource path.
     * @param array  $params The manipulation params.
     *
     * @throws SignatureException
     */
    public function validateRequest($path, array $params);
}
