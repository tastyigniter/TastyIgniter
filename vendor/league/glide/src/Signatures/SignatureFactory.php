<?php

namespace League\Glide\Signatures;

class SignatureFactory
{
    /**
     * Create HttpSignature instance.
     *
     * @param string $signKey Secret key used to generate signature.
     *
     * @return Signature The HttpSignature instance.
     */
    public static function create($signKey)
    {
        return new Signature($signKey);
    }
}
