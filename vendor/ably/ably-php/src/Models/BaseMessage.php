<?php
namespace Ably\Models;

use Ably\Exceptions\AblyException;
use Ably\Utils\Crypto;
use Ably\Log;
use Ably\Utils\Miscellaneous;
use stdClass;

/**
 * Base class for messages sent over channels.
 * Provides automatic encoding and decoding.
 */
abstract class BaseMessage {

    /**
     * @var string|null The clientId of the client that published the message.
     * This property is populated by the system, where the clientId is known.
     */
    public $clientId;

    /**
     * @var string|null ID of the connection.
     * This property is populated by the system.
     */
    public $connectionId;

    /**
     * @var mixed|null The message payload.
     */
    public $data;

    /**
     * @var string|null Transformations to be applied to this message.
     * If specified for new messages, it is assumed that $data is already encoded
     * in the specified format, including any encryption.
     * Otherwise the encoding is automatically inferred from $data.
     */
    public $encoding;

    /**
     * @var array
     */
    public $extras;

    /**
     * @var string Unique ID for this message. Populated by the system.
     */
    public $id;

    /**
     * @var int The timestamp of this message. Populated by the system.
     */
    public $timestamp;

    /**
     * @var mixed Original received data, without any transformations, ignored when sending.
     */
    public $originalData;

    /**
     * @var mixed Original received encoding, ignored when sending.
     */
    public $originalEncoding;

    /**
     * @var CipherParams|null Cipher parameters for encrypted messages.
     */
    protected $cipherParams;

    /**
     * Creates a JSON representation of this message, ready to be sent to the API.
     *
     * If there is an $encoding specified, the data will be left untouched.
     * If not specified the encoding is inferred from the type of $data and any transformations
     * such as base64 encoding for binary data and encryption are applied.
     */
    public function toJSON() {
        return json_encode( $this->encode() );
    }

    /**
     * Populates the message from JSON and automatically decodes data.
     * @param string|stdClass $json JSON string or an already decoded object.
     * @param bool $keepOriginal When set to true, the message won't be decoded or decrypted
     * @throws AblyException
     */
    public function fromJSON( $json, $keepOriginal = false ) {
        $this->clearFields();

        if (!is_string( $json )) {
            $obj = $json;
        } else {
            $obj = @json_decode($json);
            if (!$obj) {
                throw new AblyException( 'Invalid object or JSON encoded object' );
            }
        }

        $class = get_class( $this );
        foreach ($obj as $key => $value) {
            if (property_exists( $class, $key )) {
                $this->$key = $value;
            }
        }

        if ($keepOriginal) return;

        $this->decode();
    }

    /**
     * Creates and returns a new message from the given encoded message like object
     * @param stdClass $obj Message-like object
     * @param CipherParams|null $cipherParams
     */
    public static function fromEncoded( $obj, ?CipherParams $cipherParams = null ) {
        $class = get_called_class();

        $msg = new $class();
        if ($cipherParams != null) {
            $msg->setCipherParams( $cipherParams );
        }

        foreach ($obj as $key => $value) {
            if (property_exists( $class, $key )) {
                $msg->$key = $value;
            }
        }

        $msg->decode();

        return $msg;
    }

    /**
     * Creates and returns a new message from the given encoded message like object
     * @param array $objs Array of Message-Like objects
     * @param CipherParams|null $cipherParams
     */
    public static function fromEncodedArray( $objs, ?CipherParams $cipherParams = null ) {
        return array_map(
            function( $obj ) use ($cipherParams) { return static::fromEncoded($obj, $cipherParams); },
            $objs
        );
    }

    /**
     * Returns an encoded message as a stdClass ready for stringifying
     */
    protected function encode() {
        $msg = new \stdClass();

        if ($this->id) {
            $msg->id = $this->id;
        }

        if ($this->clientId) {
            $msg->clientId = $this->clientId;
        }

        if ($this->extras) {
            $msg->extras = $this->extras;
        }

        if ($this->encoding) {
            $msg->encoding = $this->encoding;
            $msg->data = $this->data;

            return $msg;
        }

        $isBinary = false;
        $encodings = [];

        if ( is_array( $this->data ) || $this->data instanceof \stdClass ) {
            $encodings[] = 'json';
            $msg->data = json_encode($this->data);
        } else if ( is_string( $this->data ) ){
            if ( mb_check_encoding( $this->data, 'UTF-8' ) ) { // it's a UTF-8 string
                $msg->data = $this->data;
            } else { // not UTF-8, assuming it's a binary string
                $msg->data = $this->data;
                $isBinary = true;
            }
        } else if ( !isset( $this->data ) || $this->data === null ) {
            return $msg;
        } else {
            throw new AblyException(
                'Message data must be either, string, string with binary data, JSON-encodable array or object, or null.', 40003, 400
            );
        }

        if ( $this->cipherParams ) {
            if ( !$isBinary ) {
                $encodings[] = 'utf-8';
            }

            $msg->data = base64_encode( Crypto::encrypt( $msg->data, $this->cipherParams ) );
            $encodings[] = 'cipher+' . $this->cipherParams->getAlgorithmString();
            $encodings[] = 'base64';
        } else {
            if ( $isBinary ) {
                $msg->data = base64_encode( $this->data );
                $encodings[] = 'base64';
            }
        }

        if ( count( $encodings ) ) {
            $msg->encoding = implode( '/', $encodings );
        } else {
            $msg->encoding = '';
        }

        return $msg;
    }

    /**
     * Decodes message's data field according to encoding
     * @throws AblyException
     */
    protected function decode() {
        $this->originalData = $this->data;
        $this->originalEncoding = $this->encoding;

        if (!empty( $this->encoding )) {
            $encodings = explode( '/', $this->encoding );

            foreach (array_reverse( $encodings ) as $encoding) {
                if ($encoding == 'base64') {
                    $this->data = base64_decode( $this->data );

                    if ($this->data === false) {
                        throw new AblyException( 'Could not base64-decode message data' );
                    }

                    array_pop( $encodings );
                } else if ($encoding == 'json') {
                    $this->data = json_decode( $this->data );

                    if ($this->data === null) {
                        throw new AblyException( 'Could not JSON-decode message data' );
                    }

                    array_pop( $encodings );
                } else if (strpos( $encoding, 'cipher+' ) === 0) {
                    if (!$this->cipherParams) {
                        Log::e( 'Could not decrypt message data, no cipherParams provided' );
                        break;
                    }

                    $data = Crypto::decrypt( $this->data, $this->cipherParams );

                    if ($data === false) {
                        Log::e( 'Could not decrypt message data' );
                        break;
                    }

                    $this->data = $data;
                    array_pop( $encodings );
                }
            }

            $this->encoding = count( $encodings ) ? implode( '/', $encodings ) : null;
        }
    }

    /**
     * Sets all the public fields to null
     */
    protected function clearFields() {
        $fields = get_object_vars( $this );
        unset( $fields['cipherParams'] );

        foreach ($fields as $key => $value) {
            $this->$key = null;
        }
    }

    /**
     * Sets cipher parameters for this message for automatic encryption and decryption.
     * @param CipherParams $cipherParams
     */
    public function setCipherParams( CipherParams $cipherParams ) {
        $this->cipherParams = $cipherParams;
    }

    public function encodeAsArray() {
        $encoded = (array)$this->encode();

        Miscellaneous::deepConvertObjectToArray($encoded);
        return $encoded;
    }
}
