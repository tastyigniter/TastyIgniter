<?php
namespace Ably\Models;

use Ably\Utils\Crypto;

/**
 * Channel options
 */
class ChannelOptions extends BaseOptions {

    /**
     * @var \Ably\Models\CipherParams|null Parameters of the cipher used on the channel, null if unencrypted
     */
    public $cipher = null;

    /**
     * Transforms `cipher` from array to CipherParams, if necessary
     */
    public function __construct( $options = [] ) {
        parent::__construct( $options );
        
        if ( is_array( $this->cipher ) ) {
        	$this->cipher = Crypto::getDefaultParams( $this->cipher );
        }
    }
}