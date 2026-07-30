<?php
namespace Ably\Models;

/**
 * Class for signed token request
 */
class TokenRequest extends TokenParams {
    
    /**
     * @var string The keyName of the key against which this request is made.
     */
    public $keyName;

    /**
     * @var string An opaque nonce string of at least 16 characters to ensure
     * uniqueness of this request. Any subsequent request using the
     * same nonce will be rejected.
     */
    public $nonce;

    /**
     * @var string The Message Authentication Code for this request. See the Ably
     * Authentication documentation for more details.
     */
    public $mac;
}