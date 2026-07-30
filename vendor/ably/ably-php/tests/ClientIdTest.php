<?php
namespace tests;
use Ably\AblyRest;
use Ably\Models\Message;
use Ably\Models\TokenParams;
use Ably\Exceptions\AblyException;

require_once __DIR__ . '/factories/TestApp.php';

class ClientIdTest extends \PHPUnit\Framework\TestCase {

    protected static $testApp;
    protected static $defaultOptions;

    public static function setUpBeforeClass(): void {
        self::$testApp = new TestApp();
        self::$defaultOptions = self::$testApp->getOptions();
    }

    public static function tearDownAfterClass(): void {
        self::$testApp->release();
    }

    /**
     * Init library with a key and clientId; expect token auth to be chosen; expect Auth::clientId to return the id
     */
    public function testInitWithKeyAndClientId() {
        $ably = new AblyRest( array_merge( self::$defaultOptions, [
            'key'      => self::$testApp->getAppKeyDefault()->string,
            'clientId' => 'testClientId',
        ] ) );

        $this->assertTrue( $ably->auth->isUsingBasicAuth(), 'Expected basic auth to be used' );

        $ably->auth->authorize();
        $this->assertEquals( 'testClientId', $ably->auth->clientId,
                             'Expected clientId result to match the provided id' );
        $this->assertEquals( 'testClientId', $ably->auth->getTokenDetails()->clientId,
                             'Expected clientId in tokenDetails to match the provided id' );
    }

    /**
     * (RSA7c) A clientId provided in the ClientOptions when instancing the
     * library must be either null or a string, and cannot contain only a
     * wildcard '*' string value as that client ID value is reserved
     */
    public function testInitWithWildcardClientId() {
        $this->expectException(AblyException::class);
        $this->expectExceptionCode(40012);

        $ably = new AblyRest( array_merge( self::$defaultOptions, [
            'key'      => self::$testApp->getAppKeyDefault()->string,
            'clientId' => '*',
        ] ) );
    }

    /**
     * Check is Auth::clientId is returning expected null values
     */
    public function testGetClientIdNull() {
        // no clientId provided anywhere, should be null
        $ably = new AblyRest( array_merge( self::$defaultOptions, [
            'key' => self::$testApp->getAppKeyDefault()->string,
        ] ) );

        $ably->auth->authorize(); // switch to token based auth

        $this->assertNull( $ably->auth->getTokenDetails()->clientId, 'Expected tokenDetails clientId to be null' );
        $this->assertNull( $ably->auth->clientId, 'Expected clientId to be null' );

        // test not yet authorised lib without a clientId specified on ClientOptions
        $ablyImplicitCId = new AblyRest( array_merge( self::$defaultOptions, [
            'key' => self::$testApp->getAppKeyDefault()->string,
            'defaultTokenParams' => new TokenParams( [
                'clientId' => 'testClientId',
            ] ),
        ] ) );

        $this->assertNull( $ablyImplicitCId->auth->clientId, 'Expected clientId to be null prior to authorising' );

        $ablyImplicitCId->auth->authorize();

        $this->assertEquals( 'testClientId', $ablyImplicitCId->auth->clientId,
                             'Expected clientId to match after authorising' );
    }

    /**
     * Check is Auth::clientId is returning expected non null values
     */
    public function testGetClientIdNonNull() {
        // test wildcard clientId provided via tokenDetails
        $ablyKey = new AblyRest( array_merge( self::$defaultOptions, [
            'key' => self::$testApp->getAppKeyDefault()->string,
        ] ) );

        $wildcardToken = $ablyKey->auth->requestToken( [ 'clientId' => '*' ] );

        $ablyWildcard = new AblyRest( array_merge( self::$defaultOptions, [
            'tokenDetails' => $wildcardToken,
        ] ) );

        $this->assertEquals( '*', $ablyWildcard->auth->getTokenDetails()->clientId,
                             'Expected tokenDetails clientId to be *' );
        $this->assertEquals( '*', $ablyWildcard->auth->clientId, 'Expected clientId to be *' );

        // test specified clientId specified in ClientOptions
        $ablyCid = new AblyRest( array_merge( self::$defaultOptions, [
            'key' => self::$testApp->getAppKeyDefault()->string,
            'clientId' => 'testClientId',
        ] ) );

        $this->assertEquals( 'testClientId', $ablyCid->auth->clientId );

        // test clientId overridden by authOptions
        $ablyCid->auth->authorize( [], [ 'clientId' => 'overriddenClientId_authOptions' ] );
        $this->assertEquals( 'overriddenClientId_authOptions', $ablyCid->auth->clientId );

        // test clientId overridden by tokenParams
        $ablyCid->auth->authorize( [ 'clientId' => 'overriddenClientId_tokenParams' ] );
        $this->assertEquals( 'overriddenClientId_tokenParams', $ablyCid->auth->clientId );
    }

    /**
     * Check if messages can be assigned a clientId with a wildcard lib instance
     */
    public function testWildcardClientIdMsg() {
        $ablyKey = new AblyRest( array_merge( self::$defaultOptions, [
            'key' => self::$testApp->getAppKeyDefault()->string,
        ] ) );

        $wildcardToken = $ablyKey->auth->requestToken( [ 'clientId' => '*' ] );

        $ablyWildcard = new AblyRest( array_merge( self::$defaultOptions, [
            'tokenDetails' => $wildcardToken,
        ] ) );

        $clientId = 'testClientId';
        $msg = new Message();
        $msg->data = 'test';
        $msg->clientId = $clientId;

        $keyChan = $ablyKey->channels->get( 'persisted:clientIdTestKey' );
        $keyChan->publish( $msg );
        $retrievedMsg = $keyChan->history()->items[0];
        $this->assertEquals( $clientId, $retrievedMsg->clientId, 'Expected clientIds to match');

        $tokenChan = $ablyWildcard->channels->get( 'persisted:clientIdTestToken' );
        $tokenChan->publish( $msg );
        $retrievedMsg = $tokenChan->history()->items[0];
        $this->assertEquals( $clientId, $retrievedMsg->clientId, 'Expected clientIds to match');
    }

    /**
     * Check if messages are assigned a clientID automatically with a non-anonymous lib instance
     * Verify that clientID mismatch produces an exception within the library
     */
    public function testClientIdLib() {
        $clientId = 'testClientId';

        $ablyCId = new AblyRest( array_merge( self::$defaultOptions, [
            'key' => self::$testApp->getAppKeyDefault()->string,
            'clientId' => $clientId,
            'useTokenAuth' => true,
        ] ) );

        $this->assertEquals( $clientId, $ablyCId->auth->clientId,
                             'Expected a token with specified clientId to be used' );

        $msg = new Message();
        $msg->data = 'test';

        $channel = $ablyCId->channels->get( 'persisted:clientIdTestLib' );
        $channel->publish( $msg );
        $retrievedMsg = $channel->history()->items[0];

        $this->assertEquals( $clientId, $retrievedMsg->clientId, 'Expected clientIds to match');
        $this->assertFalse( $ablyCId->auth->isUsingBasicAuth(), 'Expected library to switch to token auth');
        $this->assertEquals( $clientId, $ablyCId->auth->getTokenDetails()->clientId,
                             'Expected auth token to be bound to the provided clientId');

        $msg = new Message();
        $msg->data = 'test';
        $msg->clientId = 'testClientId';

        $channel = $ablyCId->channels->get( 'persisted:clientIdTestLib' );
        $channel->publish( $msg ); // matching clientIds, this should work

        $msg = new Message();
        $msg->data = 'test';
        $msg->clientId = 'DIFFERENT_clientId';

        $this->expectException(AblyException::class);
        $this->expectExceptionCode(40012);
        $channel->publish( $msg ); // mismatched clientIds, should throw an exception
    }

    /**
     * (RSA7a4) When a clientId value is provided in both
     * ClientOptions#clientId and ClientOptions#defaultTokenParams, the
     * ClientOptions#clientId takes precendence and is used for all Auth
     * operations
     */
    public function testClientIdPrecedence() {
        $ablyCId = new AblyRest( array_merge( self::$defaultOptions, [
            'key' => self::$testApp->getAppKeyDefault()->string,
            'useTokenAuth' => true,
            'clientId' => 'overriddenClientId',
            'defaultTokenParams' => new TokenParams( [
                'clientId' => 'tokenParamsClientId',
            ] ),
        ] ) );

        $ablyCId->auth->authorize(); // obtain a token
        $this->assertEquals( 'overriddenClientId', $ablyCId->auth->clientId,
                             'Expected defaultTokenParams to override provided clientId' );

        $channel = $ablyCId->channels->get( 'persisted:testClientIdPrecedence' );
        $channel->publish( 'testEvent', 'testData' );

        $this->assertEquals( 'overriddenClientId', $channel->history()->items[0]->clientId,
                             'Expected message clientId to match' );
    }

    /**
     * (RSA8f1) Request a token with a null value clientId, authenticate a client with the token,
     * publish a message without an explicit clientId, and ensure the message published does not
     * have a clientId. Check that Auth#clientId is null
     */
    public function testRSA8f1() {
        $ablyMain = new AblyRest( array_merge( self::$defaultOptions, [
            'key' => self::$testApp->getAppKeyDefault()->string,
        ] ) );

        $tokenDetails = $ablyMain->auth->requestToken();

        $ablyClient = new AblyRest( array_merge( self::$defaultOptions, [
            'tokenDetails' => $tokenDetails,
        ] ) );

        $channel = $ablyClient->channels->get( 'persisted:RSA8f1' );
        $channel->publish( 'testEvent', 'testData' );

        $this->assertNull( $ablyClient->auth->clientId, 'Expected clientId to be null' );
        $this->assertNull( $channel->history()->items[0]->clientId, 'Expected message not to have a clientId' );
        $this->assertEquals( 'testData', $channel->history()->items[0]->data, 'Expected message payload to match' );
    }

    /**
     * (RSA8f2) Request a token with a null value clientId, authenticate a client with the token,
     * publish a message with an explicit clientId value, and ensure that the message is rejected
     */
    public function testRSA8f2() {
        $ablyMain = new AblyRest( array_merge( self::$defaultOptions, [
            'key' => self::$testApp->getAppKeyDefault()->string,
        ] ) );

        $tokenDetails = $ablyMain->auth->requestToken();

        $ablyClient = new AblyRest( array_merge( self::$defaultOptions, [
            'tokenDetails' => $tokenDetails,
        ] ) );

        $channel = $ablyClient->channels->get( 'persisted:RSA8f2' );

        $this->expectException(AblyException::class);
        $this->expectExceptionCode(40012);
        $channel->publish( 'testEvent', 'testData', 'testClientId' );
    }

    /**
     * (RSA8f3) Request a token with a wildcard '*' value clientId, authenticate a client with the token,
     * publish a message without an explicit clientId, and ensure the message published does not have
     * a clientId. Check that Auth#clientId is a string with value '*'.
     */
    public function testRSA8f3() {
        $ablyMain = new AblyRest( array_merge( self::$defaultOptions, [
            'key' => self::$testApp->getAppKeyDefault()->string,
        ] ) );

        $tokenDetails = $ablyMain->auth->requestToken( [ 'clientId' => '*' ] );

        $ablyClient = new AblyRest( array_merge( self::$defaultOptions, [
            'tokenDetails' => $tokenDetails,
        ] ) );

        $channel = $ablyClient->channels->get( 'persisted:RSA8f3' );
        $channel->publish( 'testEvent', 'testData' );

        $this->assertEquals( '*', $ablyClient->auth->clientId, 'Expected clientId to be null' );
        $this->assertNull( $channel->history()->items[0]->clientId, 'Expected message not to have a clientId' );
        $this->assertEquals( 'testData', $channel->history()->items[0]->data, 'Expected message payload to match' );
    }

    /**
     * (RSA8f4) Request a token with a wildcard '*' value clientId, authenticate a client with the token,
     * publish a message with an explicit clientId value, and ensure that the message published has
     * the provided clientId
     */
    public function testRSA8f4() {
        $ablyMain = new AblyRest( array_merge( self::$defaultOptions, [
            'key' => self::$testApp->getAppKeyDefault()->string,
        ] ) );

        $tokenDetails = $ablyMain->auth->requestToken( [ 'clientId' => '*' ] );

        $ablyClient = new AblyRest( array_merge( self::$defaultOptions, [
            'tokenDetails' => $tokenDetails,
        ] ) );

        $channel = $ablyClient->channels->get( 'persisted:RSA8f4' );
        $channel->publish( 'testEvent', 'testData', 'testClientId' );

        $this->assertEquals( 'testClientId', $channel->history()->items[0]->clientId,
                             'Expected message clientId to match' );
        $this->assertEquals( 'testData', $channel->history()->items[0]->data, 'Expected message payload to match' );
    }
}
