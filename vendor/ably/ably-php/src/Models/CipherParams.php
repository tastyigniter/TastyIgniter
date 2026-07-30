<?php
namespace Ably\Models;

/**
 * Cipher parameters.
 * @see Crypto
 */
class CipherParams {
    /** @var string Key used for encryption, may be a binary string. */
    public $key;
    /** @var string Algorithm to be used for encryption. The only officially supported algorithm is currently 'aes'. */
    public $algorithm;
    /** @var string Key length of the algorithm. Valid values for 'aes' are 128 or 256. */
    public $keyLength;
    /** @var string Algorithm mode. The only supported mode for 'aes' is currently 'cbc'. */
    public $mode;
    /** @var string Initialization vector for encryption, may be a binary string. */
    public $iv;

    public function __construct() {
    }

    /**
     * @return string Algorithm string as required by openssl - for instance `aes-128-cbc`
     */
    public function getAlgorithmString() {
        return $this->algorithm
               . ($this->keyLength ? '-' . $this->keyLength : '')
               . ($this->mode ? '-' . $this->mode : '');
    }

    public function generateIV() {
        $length = openssl_cipher_iv_length( $this->getAlgorithmString() );
        if ( $length > 0 ) {
            $this->iv = openssl_random_pseudo_bytes( $length );
        }
    }

    public function checkValidAlgorithm() {
        $validAlgs = openssl_get_cipher_methods( true );
        return in_array( $this->getAlgorithmString(), $validAlgs );
    }
}
