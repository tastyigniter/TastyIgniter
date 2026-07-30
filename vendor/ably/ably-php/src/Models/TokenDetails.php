<?php
namespace Ably\Models;

/**
 * Class representing a token
 */
class TokenDetails extends BaseOptions {
    
    /**
     * @var string The token itself
     */
    public $token;

    /**
     * @var integer The time (in millis since the epoch) at which this token expires.
     */
    public $expires;

    /**
     * @var integer The time (in millis since the epoch) at which this token was issued.
     */
    public $issued;

    /**
     * @var string A json_encoded capability associated with this token. See the Ably Authentication
     * documentation for details.
     */
    public $capability;

    /**
     * @var string The clientId, if any, bound to this token. If a clientId is included,
     * then the token authenticates its bearer as that clientId, and the
     * token may only be used to perform operations on behalf of that clientId.
     */
    public $clientId;

    /**
     * @param string|array $options
     */
    public function __construct( $options = [] ) {
        if (is_string( $options )) {
            $this->token = $options;
        } else {
            parent::__construct( $options );
        }
    }
}