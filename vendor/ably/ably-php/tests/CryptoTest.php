<?php
namespace tests;
use Ably\Models\CipherParams;
use Ably\Models\Message;
use Ably\Models\PresenceMessage;
use Ably\Utils\Crypto;

require_once __DIR__ . '/factories/TestApp.php';

class CryptoTest extends \PHPUnit\Framework\TestCase {

    public function testGenerateRandomKey() {
        $keyDefault = Crypto::generateRandomKey();
        $this->assertEquals( 256, strlen( $keyDefault ) * 8, 'Expected the default key length to be 256 bits' );
        $this->assertIsString( $keyDefault, 'Expected to return a binary string' );

        $key128 = Crypto::generateRandomKey( 128 );
        $this->assertEquals( 128, strlen( $key128 ) * 8, 'Expected to return a random key of specified length (128 bits)' );
    }

    public function testGetDefaultParams() {
        $key = Crypto::generateRandomKey( 128 );

        $cipherParams = Crypto::getDefaultParams([ 'key' => $key ]);
        $this->assertInstanceOf( 'Ably\Models\CipherParams', $cipherParams );
        $this->assertEquals( $key, $cipherParams->key, 'Expected the key to match the provided key' );
        $this->assertEquals( 'aes', $cipherParams->algorithm, 'Expected \'aes\' algorithm' );
        $this->assertEquals( 128, $cipherParams->keyLength, 'Expected keyLength of 128' );
        $this->assertEquals( 'cbc', $cipherParams->mode, 'Expected \'cbc\' mode' );
        $this->assertEquals( strlen( $key ), strlen( $cipherParams->iv), 'Expected key length and IV length to match' );

        $defaults = [
            'key' => $key,
            'keyLength' => 128,
            'iv' => Crypto::generateRandomKey( 128 ),
            'algorithm' => 'aes',
            'mode' => 'cbc',
        ];

        $cipherParamsDef = Crypto::getDefaultParams( $defaults );
        $this->assertEquals( get_object_vars( $cipherParamsDef ), $defaults, 'Expected created CipherParams to match provided values');

        $defaultsB64 = $defaults; // copied by value in PHP
        $defaultsB64['key'] = base64_encode( $defaultsB64['key'] );
        $defaultsB64['base64Key'] = true;
        $defaultsB64['iv'] = strtr( base64_encode( $defaultsB64['iv'] ), '/+', '_-' ); // RFC4648 section 5 ("url-safe")
        $defaultsB64['base64Iv'] = true;

        $cipherParamsDefB64 = Crypto::getDefaultParams( $defaultsB64 );
        $this->assertEquals( get_object_vars( $cipherParamsDefB64 ), $defaults,
            'Expected created CipherParams to match provided values and decode base64 fields'
        );

        try {
            Crypto::getDefaultParams( [] );
        } catch (\Exception $ex) {
            $this->assertInstanceOf( 'Ably\Exceptions\AblyException', $ex,
                                     'Expected to check for key being provided' );
        }

        try {
            Crypto::getDefaultParams([ 'key' => 'abcd', 'keyLength' => 128 ]); // 32-bit key
        } catch (\Exception $ex) {
            $this->assertInstanceOf( 'Ably\Exceptions\AblyException', $ex,
                                     'Expected to check for key and keyLength mismatch' );
        }

        try {
            Crypto::getDefaultParams([ 'key' => 'abcd', 'keyLength' => 32 ]); // 32-bit key
        } catch (\Exception $ex) {
            $this->assertInstanceOf( 'Ably\Exceptions\AblyException', $ex,
                                     'Expected to check for an unacceptable key length' );
        }

        try {
            Crypto::getDefaultParams([ 'key' => Crypto::generateRandomKey(), 'algorithm' => 'fake' ]);
        } catch (\Exception $ex) {
            $this->assertInstanceOf( 'Ably\Exceptions\AblyException', $ex,
                                     'Expected to raise an exception on unknown encryption algorithm' );
        }

        try {
            Crypto::getDefaultParams([ 'key' => Crypto::generateRandomKey(), 'mode' => 'fake' ]);
        } catch (\Exception $ex) {
            $this->assertInstanceOf( 'Ably\Exceptions\AblyException', $ex,
                                     'Expected to raise an exception on unknown encryption mode' );
        }
    }

    public function testNonAESEncryptionSupport() {
        $cipherParams = Crypto::getDefaultParams( [
            'key' => Crypto::generateRandomKey(128),
            'algorithm' => 'sm4',
            'mode' => 'ecb',
        ]);

        $encrypted = Crypto::encrypt( 'test', $cipherParams );
        $decrypted = Crypto::decrypt( $encrypted, $cipherParams );
        $this->assertNotEquals( $encrypted, $decrypted );
        $this->assertEquals( 'test', $decrypted );

        try {
            Crypto::getDefaultParams([ 'key' => Crypto::generateRandomKey(), 'algorithm' => 'fake' ]);
        } catch (\Exception $ex) {
            $this->assertInstanceOf( 'Ably\Exceptions\AblyException', $ex, 'Expected to raise an exception on unknown encryption mode' );
        }
    }

    /**
     * Tests if example messages match actual messages after encryption/decryption and vice versa:
     * decrypt(encrypted_example) == unencrypted_example
     * encrypt(unencrypted_example) == encrypted_example
     *
     * @dataProvider filenameProvider
     */
    public function testMessageEncryptionAgainstFixture( $filename ) {
        $fixture = json_decode( file_get_contents( $filename ) );

        foreach ($fixture->items as $example) {
            $cipherParams = Crypto::getDefaultParams([ // instantiate every time, as same IV is required
                'key'       => $fixture->key,
                'algorithm' => $fixture->algorithm,
                'keyLength' => $fixture->keylength,
                'mode'      => $fixture->mode,
                'iv'        => $fixture->iv,
                'base64Key' => true,
                'base64Iv' => true,
            ]);

            $decodedExample = new Message();
            $decodedExample->fromJSON( $example->encoded );
            $decryptedExample = new Message();
            $decryptedExample->setCipherParams( $cipherParams );
            $decryptedExample->fromJSON( $example->encrypted );

            $this->assertEquals( $decodedExample->data, $decryptedExample->data,
                                 'Expected unencrypted and decrypted message\'s contents to match' );

            $decodedExample->setCipherParams( $cipherParams );
            $encryptedJSON = json_decode( $decodedExample->toJSON() );
            $this->assertEquals( $example->encrypted->data, $encryptedJSON->data,
                                 'Expected encrypted and example encrypted message\'s contents to match' );
        }
    }

    /**
     * Tests Message:fromEncodedArray
     *
     * @dataProvider filenameProvider
     */
    public function testMessageFromEncodedArray( $filename ) {
        $fixture = json_decode( file_get_contents( $filename ) );

        $cipherParams = Crypto::getDefaultParams([
            'key'       => $fixture->key,
            'algorithm' => $fixture->algorithm,
            'keyLength' => $fixture->keylength,
            'mode'      => $fixture->mode,
            'iv'        => $fixture->iv,
            'base64Key' => true,
            'base64Iv' => true,
        ]);

        $encrypted = array_map( function ( $x ) { return $x->encrypted ; }, $fixture->items );
        $encoded = array_map( function ( $x ) { return $x->encoded ; }, $fixture->items );

        $encrypted = Message::fromEncodedArray( $encrypted, $cipherParams );
        $encoded = Message::fromEncodedArray( $encoded );

        foreach ($encrypted as $i => $decryptedExample) {
            $decodedExample = $encoded[$i];
            $this->assertEquals( $decodedExample->data, $decryptedExample->data,
                                 'Expected unencrypted and decrypted message\'s contents to match' );
        }
    }

    /**
     * Tests if example presence messages match actual presence messages after encryption/decryption and vice versa:
     * decrypt(encrypted_example) == unencrypted_example
     * encrypt(unencrypted_example) == encrypted_example
     *
     * @dataProvider filenameProvider
     */
    public function testPresenceMessageEncryptionAgainstFixture( $filename ) {
        $fixture = json_decode( file_get_contents( $filename ) );

        foreach ($fixture->items as $example) {
            $cipherParams = Crypto::getDefaultParams([ // instantiate every time, as same IV is required
                'key'       => $fixture->key,
                'algorithm' => $fixture->algorithm,
                'keyLength' => $fixture->keylength,
                'mode'      => $fixture->mode,
                'iv'        => $fixture->iv,
                'base64Key' => true,
                'base64Iv' => true,
            ]);

            unset ($example->encoded->name); // we're reusing fixtures for standard messages, but presence messages do not have a name
            unset ($example->encrypted->name);

            $decodedExample = new PresenceMessage();
            $decodedExample->fromJSON( $example->encoded );
            $decryptedExample = new PresenceMessage();
            $decryptedExample->setCipherParams( $cipherParams );
            $decryptedExample->fromJSON( $example->encrypted );

            $this->assertEquals( $decodedExample->data, $decryptedExample->data,
                                 'Expected unencrypted and decrypted message\'s contents to match' );

            $decodedExample->setCipherParams( $cipherParams );
            $encryptedJSON = json_decode( $decodedExample->toJSON() );
            $this->assertEquals( $example->encrypted->data, $encryptedJSON->data,
                                 'Expected encrypted and example encrypted message\'s contents to match' );
        }
    }

    /**
     * Tests PresenceMessage:fromEncodedArray
     *
     * @dataProvider filenameProvider
     */
    public function testPresenceMessageFromEncodedArray( $filename ) {
        $fixture = json_decode( file_get_contents( $filename ) );

        $cipherParams = Crypto::getDefaultParams([
            'key'       => $fixture->key,
            'algorithm' => $fixture->algorithm,
            'keyLength' => $fixture->keylength,
            'mode'      => $fixture->mode,
            'iv'        => $fixture->iv,
            'base64Key' => true,
            'base64Iv' => true,
        ]);

        $encrypted = array_map( function ( $x ) { return $x->encrypted ; }, $fixture->items );
        $encoded = array_map( function ( $x ) { return $x->encoded ; }, $fixture->items );

        $encrypted = PresenceMessage::fromEncodedArray( $encrypted, $cipherParams );
        $encoded = PresenceMessage::fromEncodedArray( $encoded );

        foreach ($encrypted as $i => $decryptedExample) {
            $decodedExample = $encoded[$i];
            $this->assertEquals( $decodedExample->data, $decryptedExample->data,
                                 'Expected unencrypted and decrypted message\'s contents to match' );
        }
    }

    public function filenameProvider() {
        return [
            [ __DIR__ . '/../ably-common/test-resources/crypto-data-128.json'],
            [ __DIR__ . '/../ably-common/test-resources/crypto-data-256.json'],
        ];
    }
}
