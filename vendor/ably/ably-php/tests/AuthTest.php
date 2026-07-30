<?php
namespace authTest;
use Ably\AblyRest;
use Ably\Auth;
use Ably\Exceptions\AblyException;
use Ably\Http;
use Ably\Models\TokenDetails;
use Ably\Models\TokenParams;
use Ably\Models\TokenRequest;
use Ably\Utils\Miscellaneous;
use tests\AssertsRegularExpressions;

require_once __DIR__ . '/factories/TestApp.php';

class AuthTest extends \PHPUnit\Framework\TestCase {

    use AssertsRegularExpressions;

    protected static $testApp;
    protected static $defaultOptions;

    public static function setUpBeforeClass(): void {
        self::$testApp = new \tests\TestApp();
        self::$defaultOptions = self::$testApp->getOptions();
    }

    public static function tearDownAfterClass(): void {
        self::$testApp->release();
    }

    /**
     * Init library with a key over unsecure connection
     */
    public function testAuthWithKeyInsecure() {
        $this->expectException(AblyException::class);
        $this->expectExceptionCode(40103);

        $ably = new AblyRest( array_merge( self::$defaultOptions, [
            'key' => self::$testApp->getAppKeyDefault()->string,
            'tls' => false,
        ] ) );
    }

    /**
     * Init library without any valid auth
     */
    public function testNoAuthParams() {
        $this->expectException(AblyException::class);
        $this->expectExceptionCode(40103);

        $ably = new AblyRest( );
    }

    /**
     * Init library with a token
     */
    public function testAuthWithToken() {
        $ably_for_token = new AblyRest( array_merge( self::$defaultOptions, [
            'key' => self::$testApp->getAppKeyDefault()->string,
        ] ) );
        $tokenDetails = $ably_for_token->auth->requestToken();

        $this->assertNotNull($tokenDetails->token, 'Expected token id' );

        $ably = new AblyRest( array_merge( self::$defaultOptions, [
            'tokenDetails' => $tokenDetails,
        ] ) );

        $this->assertFalse( $ably->auth->isUsingBasicAuth(), 'Expected token auth to be used' );

        $ably->stats(); // authorized request, should pass
    }

    /**
     * Init library with a key, force use of token with useTokenAuth
     */
    public function testAuthWithKeyForceToken() {
        $ably = new AblyRest( [
            'key' => 'fake.key:totallyFake',
            'useTokenAuth' => true,
        ] );

        $this->assertFalse( $ably->auth->isUsingBasicAuth(), 'Expected token auth to be used' );
    }

    /**
     * Init library without providing a key or a token, force use of token with useTokenAuth
     */
    public function testAuthEmptyForceToken() {
        $this->expectException(AblyException::class);
        $this->expectExceptionCode(40103);

        $ably = new AblyRest( [
            'useTokenAuth' => true,
        ] );
    }

    /**
     * Verify than token auth works without TLS
     */
    public function testTokenWithoutTLS() {
        $ably_for_token = new AblyRest( array_merge( self::$defaultOptions, [
            'key' => self::$testApp->getAppKeyDefault()->string,
        ] ) );
        $tokenDetails = $ably_for_token->auth->requestToken();

        $this->assertNotNull($tokenDetails->token, 'Expected token id' );

        $ablyInsecure = new AblyRest( array_merge( self::$defaultOptions, [
            'tokenDetails' => $tokenDetails,
            'tls' => false,
        ] ) );

        $this->assertFalse( $ablyInsecure->auth->isUsingBasicAuth(), 'Expected token auth to be used' );

        $ablyInsecure->stats(); // authorized request, should pass
    }

    /**
     * Init library with a token callback that returns a signed TokenRequest
     */
    public function testTokenRequestWithAuthCallbackReturningSignedRequest() {
        $callbackCalled = false;

        $ably = new AblyRest( array_merge( self::$defaultOptions, [
            'authCallback' => function( $tokenParams ) use( &$callbackCalled ) {
                $callbackCalled = true;

                return new TokenRequest( [
                    'token' => 'this_is_not_really_a_token_request',
                    'timestamp' => time()*1000,
                    'keyName' => 'fakeKeyName',
                    'mac' => 'not_really_hmac',
                ] );
            },
            'httpClass' => 'authTest\HttpMock',
        ] ) );

        $tokenDetails = $ably->auth->requestToken();

        $this->assertTrue( $callbackCalled, 'Expected token callback to be called' );
        $this->assertEquals( 'mock_token_requestToken', $tokenDetails->token, 'Expected mock token to be used' );
        $this->assertFalse( $ably->auth->isUsingBasicAuth(), 'Expected token auth to be used' );
    }

    /**
     * Init library with a token callback that returns TokenDetails
     */
    public function testTokenRequestWithAuthCallbackReturningTokenDetails() {
        $callbackCalled = false;

        $ably = new AblyRest( array_merge( self::$defaultOptions, [
            'authCallback' => function( $tokenParams ) use( &$callbackCalled ) {
                $callbackCalled = true;

                return new TokenDetails( [
                    'token' => 'mock_TokenDetails',
                    'issued' => time()*1000,
                    'expires' => time()*1000 + 3600*1000,
                ] );
            },
            'httpClass' => 'authTest\HttpMock',
        ] ) );

        $tokenDetails = $ably->auth->requestToken();

        $this->assertTrue( $callbackCalled, 'Expected token callback to be called' );
        $this->assertEquals( 'mock_TokenDetails', $tokenDetails->token, 'Expected mock token to be used' );
        $this->assertFalse( $ably->auth->isUsingBasicAuth(), 'Expected token auth to be used' );
    }

    /**
     * Init library with a token callback that returns token as a string
     */
    public function testTokenRequestWithAuthCallbackReturningTokenString() {
        $callbackCalled = false;

        $ably = new AblyRest( array_merge( self::$defaultOptions, [
            'authCallback' => function( $tokenParams ) use( &$callbackCalled ) {
                $callbackCalled = true;

                return 'mock_tokenString';
            },
            'httpClass' => 'authTest\HttpMock',
        ] ) );

        $tokenDetails = $ably->auth->requestToken();

        $this->assertTrue( $callbackCalled, 'Expected token callback to be called' );
        $this->assertEquals( 'mock_tokenString', $tokenDetails->token, 'Expected mock token to be used' );
        $this->assertFalse( $ably->auth->isUsingBasicAuth(), 'Expected token auth to be used' );
    }

    /**
     * Init library with an authUrl that returns a signed TokenRequest
     */
    public function testTokenRequestWithAuthUrlReturningSignedRequest() {
        $method = 'POST';

        $ably = new AblyRest( array_merge( self::$defaultOptions, [
            'authUrl' => 'https://TEST/tokenRequest',
            'httpClass' => 'authTest\HttpMock',
        ] ) );

        $tokenDetails = $ably->auth->requestToken();

        $this->assertEquals( 'mock_token_requestToken', $tokenDetails->token, 'Expected mock token to be used' );
        $this->assertFalse( $ably->auth->isUsingBasicAuth(), 'Expected token auth to be used' );
    }

    /**
     * Init library with an authUrl that returns TokenDetails
     */
    public function testTokenRequestWithAuthUrlReturningTokenDetails() {
        $ably = new AblyRest( array_merge( self::$defaultOptions, [
            'authUrl' => 'https://TEST/tokenDetails',
            'httpClass' => 'authTest\HttpMock',
        ] ) );

        $tokenDetails = $ably->auth->requestToken();

        $this->assertEquals( 'mock_token_authurl_TokenDetails', $tokenDetails->token, 'Expected mock token to be used' );
        $this->assertFalse( $ably->auth->isUsingBasicAuth(), 'Expected token auth to be used' );
    }

    /**
     * Init library with an authUrl that returns a token string
     */
    public function testTokenRequestWithAuthUrlReturningTokenString() {
        $ably = new AblyRest( array_merge( self::$defaultOptions, [
            'authUrl' => 'https://TEST/tokenString',
            'httpClass' => 'authTest\HttpMock',
        ] ) );

        $tokenDetails = $ably->auth->requestToken();

        $this->assertEquals( 'mock_token_authurl_tokenString', $tokenDetails->token, 'Expected mock token to be used' );
        $this->assertFalse( $ably->auth->isUsingBasicAuth(), 'Expected token auth to be used' );
    }

    /**
     * Verify that auth parameters and their overriding works properly when using authUrl
     */
    public function testTokenRequestWithAuthUrlParams() {
        $headers = [ 'Test header: yes', 'Another one: no' ];
        $authParams = [ 'param1' => 'value1', 'test' => 1, 'ttl' => 720000 ];
        $overriddenTokenParams = [ 'ttl' => 360000 ];
        // authParams and tokenParams should be merged
        // `ttl` should be overwritten by $overriddenTokenParams
        $expectedAuthParams = [ 'param1' => 'value1', 'test' => 1, 'ttl' => 360000 ];
        $method = 'POST';

        $ably = new AblyRest( array_merge( self::$defaultOptions, [
            'authUrl' => 'https://TEST/tokenRequest',
            'authHeaders' => $headers,
            'authParams' => $authParams,
            'authMethod' => $method,
            'httpClass' => 'authTest\HttpMock',
        ] ) );

        $ably->auth->requestToken( $overriddenTokenParams );

        $this->assertTrue( is_a( $ably->http, '\authTest\HttpMock' ) , 'Expected HttpMock class to be used' );
        $this->assertEquals( $headers, $ably->http->headers, 'Expected authHeaders to match' );
        $this->assertEquals( $expectedAuthParams, $ably->http->params, 'Expected authParams to match' );
        $this->assertEquals( $method, $ably->http->method, 'Expected authMethod to match' );

        $overriddenAuthParams = [
            'authHeaders' => [ 'CompletelyNewHeaders: true' ],
            'authParams' => [ 'completelyNewParams' => 'yes' ],
        ];
        $expectedAuthParams = [ 'completelyNewParams' => 'yes', 'ttl' => 360000 ];
        $forceReauth = true;

        $ably->auth->requestToken( $overriddenTokenParams, $overriddenAuthParams );

        $this->assertEquals( $overriddenAuthParams['authHeaders'], $ably->http->headers,
                             'Expected authHeaders to be completely replaced' );
        $this->assertEquals( $expectedAuthParams, $ably->http->params,
                             'Expected authParams to be completely replaced' );
    }

    /**
     * Verify that createTokenRequest() creates valid signed token requests (unique nonce > 16B, valid HMAC)
     * and checks if ttl can be left blank
     */
    public function testCreateTokenRequestValidity() {
        $ably = new AblyRest( array_merge( self::$defaultOptions, [
            'key' => self::$testApp->getAppKeyDefault()->string,
        ] ) );

        $tokenRequest = $ably->auth->createTokenRequest();
        $tokenRequest2 = $ably->auth->createTokenRequest();

        $this->assertTrue( strlen( $tokenRequest->nonce ) >= 16, 'Expected nonce to be at least 16 bytes long' );
        $this->assertFalse( $tokenRequest->nonce == $tokenRequest2->nonce, 'Expected nonces to be unique' );
        $this->assertNotNull( $tokenRequest->mac, 'Expected hmac to be generated' );

        $timestamp = $ably->time();

        $ably = new AblyRest( array_merge( self::$defaultOptions, [
            'authCallback' => function( $tokenParams ) use( $tokenRequest ) {
                return $tokenRequest;
            },
        ] ) );

        $ably->auth->authorize();

        $this->assertFalse( $ably->auth->isUsingBasicAuth(), 'Expected token auth to be used' );
        $this->assertLessThan(
            300,
            abs($timestamp - $ably->auth->getTokenDetails()->issued),
            'Expected token issued timestamp to be near to the time of request (allowing for clock skew)'
        );
        $ably->stats(); // requires valid token, throws exception if invalid
    }

    private function stripTokenRequestVariableParams($tokenRequest) {
        $arr = $tokenRequest->toArray();
        unset($arr['nonce']);
        unset($arr['mac']);
        unset($arr['timestamp']);
        return $arr;
    }

    /**
     * Verify that createTokenRequest() supports tokenparams, authparams and overrides values correctly
     */
    public function testCreateTokenRequestParams() {
        $ablyKey = new AblyRest( array_merge( self::$defaultOptions, [
            'key' => self::$testApp->getAppKeyDefault()->string,
            'httpClass' => 'authTest\HttpMock',
            'clientId' => 'libClientId',
            'queryTime' => false,
            'defaultTokenParams' => new TokenParams( [
                'ttl' => 1000000,
                'capability' => '{"test":"dtp"}',
                'clientId' =>  'dtpClientId',
            ] ),
        ] ) );

        $tokenParamsOverride = [
            'clientId' => 'tokenParamsClientId',
            'ttl' => 2000000,
            'capability' => '{"test":"tp"}',
        ];

        $authOptionsOverride = [
            'key' => 'testKey.Name:testKeySecret',
            'clientId' => 'authOptionsClientId',
            'queryTime' => true,
        ];

        $tokenRequest = $ablyKey->auth->createTokenRequest();
        $this->assertIsInt( $tokenRequest->timestamp );
        $this->assertEquals(
            [
                'ttl' => 1000000,
                'capability' => '{"test":"dtp"}',
                'clientId' =>  'libClientId',
                'keyName' => self::$testApp->getAppKeyDefault()->name,
            ],
            $this->stripTokenRequestVariableParams($tokenRequest));

        $this->assertNotNull( $tokenRequest->mac, 'Expected hmac to be generated' );
        $this->assertFalse( $ablyKey->http->timeQueried, 'Expected server NOT to be queried for time' );

        $tokenRequest = $ablyKey->auth->createTokenRequest($tokenParamsOverride);
        $this->assertIsInt( $tokenRequest->timestamp );
        $this->assertEquals(
            [
                'ttl' => 2000000,
                'capability' => '{"test":"tp"}',
                'clientId' =>  'tokenParamsClientId',
                'keyName' => self::$testApp->getAppKeyDefault()->name,
            ],
            $this->stripTokenRequestVariableParams($tokenRequest));
        $this->assertNotNull( $tokenRequest->mac, 'Expected hmac to be generated' );
        $this->assertFalse( $ablyKey->http->timeQueried, 'Expected server NOT to be queried for time' );

        $tokenReqAuthOptions = $ablyKey->auth->createTokenRequest([], $authOptionsOverride);
        $this->assertIsInt( $tokenRequest->timestamp );
        $this->assertEquals(
            [
                'ttl' => 1000000,
                'capability' => '{"test":"dtp"}',
                'clientId' => 'authOptionsClientId',
                'keyName' => 'testKey.Name',
            ],
            $this->stripTokenRequestVariableParams($tokenReqAuthOptions));
        $this->assertNotNull( $tokenReqAuthOptions->mac, 'Expected hmac to be generated' );
        $this->assertTrue( $ablyKey->http->timeQueried, 'Expected server to be queried for time' );
        $ablyKey->http->timeQueried = false;

        $tokenRequest = $ablyKey->auth->createTokenRequest($tokenParamsOverride, $authOptionsOverride);
        $this->assertIsInt( $tokenRequest->timestamp );
        $this->assertEquals(
            [
                'ttl' => 2000000,
                'capability' => '{"test":"tp"}',
                'clientId' =>  'tokenParamsClientId',
                'keyName' => 'testKey.Name',
            ], $this->stripTokenRequestVariableParams($tokenRequest),
            'Unexpected values in TokenRequest built from ClientOptions + TokenParams + AuthOptions'
        );
        $this->assertNotNull( $tokenRequest->mac, 'Expected hmac to be generated' );
        $this->assertTrue( $ablyKey->http->timeQueried, 'Expected server to be queried for time' );
        $ablyKey->http->timeQueried = false;
    }

    /**
     * Verify that authorize() switches to token auth, calls requestToken,
     * keeps using the same token, and renews it when forced
     */
    public function testAuthorize() {
        $ably = new AblyRest( array_merge( self::$defaultOptions, [
            'key' => self::$testApp->getAppKeyDefault()->string,
            'authClass' => 'authTest\AuthMock'
        ] ) );

        $this->assertTrue( $ably->auth->isUsingBasicAuth(), 'Expected basic auth to be used' );

        $this->assertFalse( $ably->auth->requestTokenCalled,
                            'Expected requestToken not to be called before using authorize()' );

        $tokenOriginal = $ably->auth->authorize();

        $this->assertTrue( $ably->auth->requestTokenCalled, 'Expected authorize() to call requestToken()' );

        $this->assertFalse( $ably->auth->isUsingBasicAuth(), 'Expected token auth to be used' );
        $this->assertInstanceOf( 'Ably\Models\TokenDetails', $tokenOriginal,
                                 'Expected authorize to return a TokenDetails object' );

        $ably->auth->authorize();
        $this->assertFalse( $tokenOriginal->token == $ably->auth->getTokenDetails()->token,
                            'Expected token to renew' );
    }

    /**
     * Verify that all the parameters are supported and saved as defaults
     */
    public function testAuthorizeParams() {
        $ably = new AblyRest( array_merge( self::$defaultOptions, [
            'key' => self::$testApp->getAppKeyDefault()->string,
            'authClass' => 'authTest\AuthMock'
        ] ) );
        $ably->auth->fakeRequestToken = true;

        $tokenParams = [
            'clientId' => 'tokenParamsClientId',
            'ttl' => 2000000,
            'capability' => '{"test":"tp"}',
            'timestamp' => $ably->time(),
        ];

        $authOptions = [
            'clientId' => 'authOptionsClientId',
            'key' => 'testKey.Name:testKeySecret',
            'token' => 'testToken',
            'tokenDetails' => new TokenDetails( 'testToken' ),
            'useTokenAuth' => true,
            'authCallback' => 'not a callback',
            'authUrl' =>  'not a url',
            'authHeaders' => [ 'blah' => 'yes' ],
            'authParams' => [ 'param' => 'yep' ],
            'authMethod' => 'TEST',
            'queryTime' => true,
        ];

        // test with empty params first
        $ably->auth->authorize();
        $this->assertTrue( $ably->auth->requestTokenCalled, 'Expected authorize() to call requestToken()' );
        $this->assertEmpty( $ably->auth->lastTokenParams,
                            'Expected authorize() to pass empty tokenParams to requestToken()');
        $this->assertEmpty( $ably->auth->lastAuthOptions,
                            'Expected authorize() to pass empty authOptions to requestToken()');
        $ably->auth->lastTokenParams = $ably->auth->lastAuthOptions = null;

        // provide both tokenParams and authOptions and see if they get passed to requestToken
        $ably->auth->authorize( $tokenParams, $authOptions );
        $this->assertEquals( $tokenParams, $ably->auth->lastTokenParams,
                             'Expected authorize() to pass provided tokenParams to requestToken()');
        $this->assertEquals( $authOptions, $ably->auth->lastAuthOptions,
                             'Expected authorize() to pass provided authOptions to requestToken()');

        $this->assertFalse ( isset ( $ably->auth->getSavedAuthorizeTokenParams()['timestamp'] ),
            'Expected authorize() to save provided tokenParams without the `timestamp` field');
        $this->assertFalse ( isset ( $ably->auth->getSavedAuthorizeAuthOptions()['force'] ),
            'Expected authorize() to save provided authOptions without the `force` field');
        $ably->auth->lastTokenParams = $ably->auth->lastAuthOptions = null;

        // provide no tokenParams or authOptions and see if previously saved params get passed to requestToken
        unset( $tokenParams['timestamp'] ); // expecting timestamp not to be remembered

        $ably->auth->authorize();
        $this->assertEquals( $tokenParams, $ably->auth->lastTokenParams,
                             'Expected authorize() to pass saved tokenParams to requestToken()');
        $this->assertEquals( $authOptions, $ably->auth->lastAuthOptions,
                             'Expected authorize() to pass saved authOptions to requestToken()');
        $ably->auth->lastTokenParams = $ably->auth->lastAuthOptions = null;

        // check if parameter overriding works correctly
        $ably->auth->authorize( [ 'ttl' => 99999 ], [ 'queryTime' => false ] );

        $expectedTokenParams = $tokenParams; // arrays are copied by value in PHP
        $expectedTokenParams['ttl'] = 99999;
        $expectedAuthOptions = $authOptions;
        $expectedAuthOptions['queryTime'] = false;
        $this->assertEquals( $expectedTokenParams, $ably->auth->lastTokenParams,
                             'Expected authorize() to pass combined tokenParams to requestToken()');
        $this->assertEquals( $expectedAuthOptions, $ably->auth->lastAuthOptions,
                             'Expected authorize() to pass combined authOptions to requestToken()');
    }

    /**
     * Verify that authorize() stores the provided parameters and uses them as defaults from then on
     */
    public function testAuthorizeRememberDefaults() {
        $ably = new AblyRest( array_merge( self::$defaultOptions, [
            'key' => self::$testApp->getAppKeyDefault()->string,
            'clientId' => 'originalClientId',
        ] ) );

        $token1 = $ably->auth->authorize([
            'ttl' => 10000,
        ], [
            'clientId' => 'overriddenClientId',
        ]);

        $token2 = $ably->auth->authorize();

        $this->assertFalse( $token1 == $token2, 'Expected different tokens to be issued') ;
        $this->assertEquals( 'overriddenClientId', $ably->auth->clientId,
                             'Expected to use a new clientId as a default' );
        $this->assertLessThan( Miscellaneous::systemTime() + 20000, $token2->expires,
                               'Expected to use a new ttl as a default' );
    }

    /**
     * When using Basic Auth, the API key is sent in the `Authorization: Basic` header with a Base64 encoded value
     */
    public function testHTTPHeadersKey() {
        $fakeKey = 'fake.key:totallyFake';
        $ably = new AblyRest( [
            'key' => $fakeKey,
            'httpClass' => 'authTest\HttpMock',
        ] );

        $ably->get("/dummy_test");

        $this->assertMatchesRegularExpression('/Authorization\s*:\s*Basic\s+'.base64_encode($fakeKey).'/i', $ably->http->headers[0]);
    }

    /**
     * Verify that the token string is Base64 encoded and used in the `Authorization: Bearer` header
     */
    public function testHTTPHeadersToken() {
        $fakeToken = 'fakeToken';
        $ably = new AblyRest( [
            'token' => $fakeToken,
            'httpClass' => 'authTest\HttpMock',
        ] );

        $ably->get("/dummy_test");

        $this->assertMatchesRegularExpression('/Authorization\s*:\s*Bearer\s+'.base64_encode($fakeToken).'/i', $ably->http->headers[0]);
    }
}

class HttpMock extends Http {
    public $headers;
    public $params;
    public $method;
    public $timeQueried = false;

    public function request($method, $url, $headers = [], $params = []) {
        if ( preg_match( '/\/time$/', $url ) ) {
            $this->timeQueried = true;

            return [
                'headers' => 'HTTP/1.1 200 OK'."\n",
                'body' => [ time() ],
            ];
        } else if ($url == 'https://TEST/tokenRequest') {
            $this->method = $method;
            $this->headers = $headers;
            $this->params = $params;

            $tokenRequest = new TokenRequest( [
                'timestamp' => time()*1000,
                'keyName' => 'fakeKeyName',
                'mac' => 'not_really_hmac',
            ] );

            $response = json_encode( $tokenRequest->toArray() );

            return [
                'headers' => 'HTTP/1.1 200 OK'."\n",
                'body' => json_decode ( $response ),
            ];
        } else if ($url == 'https://TEST/tokenDetails') {
            $this->method = $method;
            $this->headers = $headers;
            $this->params = $params;

            $tokenDetails = new TokenDetails( [
                'token' => 'mock_token_authurl_TokenDetails',
                'issued' => time()*1000,
                'expires' => time()*1000 + 3600*1000,
            ] );

            $response = json_encode( $tokenDetails->toArray() );

            return [
                'headers' => 'HTTP/1.1 200 OK'."\n",
                'body' => json_decode ( $response ),
            ];
        } else if ($url == 'https://TEST/tokenString') {
            $this->method = $method;
            $this->headers = $headers;
            $this->params = $params;

            return [
                'headers' => 'HTTP/1.1 200 OK'."\n",
                'body' => 'mock_token_authurl_tokenString',
            ];
        } else if ( preg_match( '/\/keys\/[^\/]*\/requestToken$/', $url ) ) {
            // token-generating ably endpoint simulation

            $tokenDetails = new TokenDetails( [
                'token' => 'mock_token_requestToken',
                'issued' => time()*1000,
                'expires' => time()*1000 + 3600*1000,
            ] );

            $response = json_encode( $tokenDetails->toArray() );

            return [
                'headers' => 'HTTP/1.1 200 OK'."\n",
                'body' => json_decode ( $response ),
            ];
        } else {
            $this->method = $method;
            $this->headers = $headers;
            $this->params = $params;

            return [
                'headers' => 'HTTP/1.1 200 OK'."\n",
                'body' => (object) ['defaultRoute' => true],
            ];
        }
    }
}

class AuthMock extends Auth {
    public $requestTokenCalled = false;
    public $fakeRequestToken = false;
    public $lastTokenParams;
    public $lastAuthOptions;

    public function requestToken( $tokenParams = [], $authOptions = [] ) {
        $this->requestTokenCalled = true;
        $this->lastTokenParams = $tokenParams;
        $this->lastAuthOptions = $authOptions;

        if ( $this->fakeRequestToken ) return new TokenDetails( 'FAKE' );

        $args = func_get_args();
        return call_user_func_array( [ Auth::class, __FUNCTION__ ], $args ); // passthru
    }

    public function getSavedAuthorizeAuthOptions() {
        return $this->defaultAuthorizeAuthOptions;
    }

    public function getSavedAuthorizeTokenParams() {
        return $this->defaultAuthorizeTokenParams;
    }

}
