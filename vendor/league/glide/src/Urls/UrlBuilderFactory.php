<?php

namespace League\Glide\Urls;

use League\Glide\Signatures\SignatureFactory;

class UrlBuilderFactory
{
    /**
     * Create UrlBuilder instance.
     *
     * @param string      $baseUrl URL prefixed to generated URL.
     * @param string|null $signKey Secret key used to secure URLs.
     *
     * @return UrlBuilder The UrlBuilder instance.
     */
    public static function create($baseUrl, $signKey = null)
    {
        $httpSignature = null;

        if (!is_null($signKey)) {
            $httpSignature = SignatureFactory::create($signKey);
        }

        return new UrlBuilder($baseUrl, $httpSignature);
    }
}
