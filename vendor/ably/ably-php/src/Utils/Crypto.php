<?php
namespace Ably\Utils;

use Ably\Models\CipherParams;
use Ably\Exceptions\AblyException;

/**
* Provides static methods for encryption/decryption
*/
class Crypto {
    /**
     * Encrypts data and returns binary payload. Automatically updates $cipherParams with a new IV.
     * @return string|false Binary payload coposed of concatenated IV and encrypted data, false if unsuccessful.
     */
    public static function encrypt( $plaintext, $cipherParams ) {
        $raw = defined( 'OPENSSL_RAW_DATA' ) ? OPENSSL_RAW_DATA : true;

        $ciphertext = openssl_encrypt( $plaintext, $cipherParams->getAlgorithmString(), $cipherParams->key, $raw, $cipherParams->iv ?? '' );

        if ($ciphertext === false) {
            return false;
        }

        $iv = $cipherParams->iv;

        self::updateIV( $cipherParams );

        return $iv.$ciphertext;
    }

    /**
     * Decrypts payload and returns original data.
     * @return string|false Original data as string or string containing binary data, false if unsuccessful.
     */
    public static function decrypt( $payload, $cipherParams ) {
        $raw = defined( 'OPENSSL_RAW_DATA' ) ? OPENSSL_RAW_DATA : true;

        $ivLength = openssl_cipher_iv_length( $cipherParams->getAlgorithmString() );
        $iv = substr( $payload, 0, $ivLength );
        $ciphertext = substr( $payload, $ivLength );
        return openssl_decrypt( $ciphertext, $cipherParams->getAlgorithmString(), $cipherParams->key, $raw, $iv );
    }

    /**
     * Returns default encryption parameters.
     * @param $params Array Array containing optional cipher parameters. A `key` must be specified.
     * The key may be either a binary string or a base64 encoded string, in which case `'base64Key' => true` must be set.
     * `iv` can also be provided as binary or base64 string (`'base64IV' => true`), although you shouldn't need it in most cases.
     * @return CipherParams Default encryption parameters.
     */
    public static function getDefaultParams( $params ) {
        if ( !isset( $params['key'] ) ) throw new AblyException ( 'No key specified.', 40003, 400 );

        $cipherParams = new CipherParams();

        if ( isset( $params['base64Key'] ) && $params['base64Key'] ) {
            $params['key'] = strtr( $params['key'], '_-', '/+' );
            $params['key'] = base64_decode( $params['key'] );
        }

        $cipherParams->key = $params['key'];
        $cipherParams->algorithm = isset( $params['algorithm'] ) ? $params['algorithm'] : 'aes';

        if ($cipherParams->algorithm == 'aes') {
            $cipherParams->mode = isset( $params['mode'] ) ? $params['mode'] : 'cbc';
            $cipherParams->keyLength = isset( $params['keyLength'] ) ? $params['keyLength'] : strlen( $cipherParams->key ) * 8;

            if ( !in_array( $cipherParams->keyLength, [ 128, 256 ] ) ) {
                throw new AblyException ( 'Unsupported keyLength. Only 128 and 256 bits are supported.', 40003, 400 );
            }

            if ( $cipherParams->keyLength / 8 != strlen( $cipherParams->key ) ) {
                throw new AblyException ( 'keyLength does not match the actual key length.', 40003, 400 );
            }

            if ( !in_array( $cipherParams->getAlgorithmString(), [ 'aes-128-cbc', 'aes-256-cbc' ] ) ) {
                throw new AblyException ( 'Unsupported cipher configuration "' . $cipherParams->getAlgorithmString()
                    . '". The supported configurations are aes-128-cbc and aes-256-cbc', 40003, 400 );
            }
        } else {
            if ( isset( $params['mode'] ) ) $cipherParams->mode = $params['mode'];
            if ( isset( $params['keyLength'] ) ) $cipherParams->keyLength = $params['keyLength'];

            if ( !$cipherParams->checkValidAlgorithm() ) {
                throw new AblyException( 'The specified algorithm "'.$cipherParams->getAlgorithmString().'"'
                    . ' is not supported by openssl. See openssl_get_cipher_methods.', 40003, 400 );
            }
        }

        if ( isset( $params['iv'] ) ) {
            $cipherParams->iv = $params['iv'];
            if ( isset( $params['base64Iv'] ) && $params['base64Iv'] ) {
                $cipherParams->iv = strtr( $cipherParams->iv, '_-', '/+' );
                $cipherParams->iv = base64_decode( $cipherParams->iv );
            }
        } else {
            $cipherParams->generateIV();
        }

        return $cipherParams;
    }

    /**
     * Generates a random encryption key.
     * @param $keyLength|null The length of the key to be generated in bits, defaults to 256.
     */
    public static function generateRandomKey( $keyLength = 256 ) {
        return openssl_random_pseudo_bytes( $keyLength / 8 );
    }

    /**
     * Updates CipherParams' Initialization Vector by encrypting a fixed string
     * with current CipherParams state, thus randomizing it.
     */
    protected static function updateIV( CipherParams $cipherParams ) {
        $raw = defined( 'OPENSSL_RAW_DATA' ) ? OPENSSL_RAW_DATA : true;

        $ivLength = strlen( $cipherParams->iv ?? '' );

        $cipherParams->iv = openssl_encrypt( str_repeat( ' ', $ivLength ), $cipherParams->getAlgorithmString(), $cipherParams->key, $raw, $cipherParams->iv ?? '' );
        $cipherParams->iv = substr( $cipherParams->iv, 0, $ivLength );
    }
}
