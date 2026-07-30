<?php
namespace Ably\Models;

/**
 * Provides parameters of a token request.
 */
class TokenParams extends BaseOptions {

    /**
     * @var integer Requested time to live for the token in milliseconds. If the token request
     * is successful, the TTL of the returned token will be less than or equal to this value depending
     * on application settings and the attributes of the issuing key.
     */
    public $ttl;

    /**
     * @var string Capability of the token. If the token request is successful,
     * the capability of the returned token will be the intersection of
     * this capability with the capability of the issuing key.
     */
    public $capability;

    /**
     * @var string A clientId to associate with this token. The generated token
     * may be used to authenticate as this clientId.
     */
    public $clientId;

    /**
     * @var integer The timestamp (in millis since the epoch) of this request.
     * Timestamps, in conjunction with the nonce, are used to prevent
     * token requests from being replayed.
     */
    public $timestamp;
    
    /**
     * Constructor. Automatically canonicalizes capability, if provided as array or object.
     * If capability is a string, it is assumed that it's already a canonicalized json_encoded string.
     */
    public function __construct( $options = [] ) {
        parent::__construct( $options );

        if (is_object( $this->capability )) {
            $this->capability = (array) $this->capability;
        }

        if (is_array( $this->capability )) {
            ksort( $this->capability );
            $this->capability = json_encode( $this->capability );
        }
    }
}