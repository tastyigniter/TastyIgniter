<?php
namespace tests;
use Ably\AblyRest;
use Ably\Defaults;
use Ably\Exceptions\AblyRequestException;
use Ably\Http;
use Ably\Models\ClientOptions;
use Ably\Models\TokenDetails;
use Ably\Utils\Miscellaneous;

require_once __DIR__ . '/factories/TestApp.php';

class AblyRestTest extends \PHPUnit\Framework\TestCase {

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
     * Init library with a key string
     */
    public function testInitLibWithKeyString() {
        $key = 'fake.key:veryFake';
        $ably = new AblyRest( $key );
        $this->assertTrue( $ably->auth->isUsingBasicAuth(), 'Expected basic auth to be used' );
    }

    /**
     * Init library with a key in options
     */
    public function testInitLibWithKeyOption() {
        $key = 'fake.key:veryFake';
        $ably = new AblyRest( ['key' => $key ] );
        $this->assertTrue( $ably->auth->isUsingBasicAuth(), 'Expected basic auth to be used' );
    }

    /**
     * Init library with a token string
     */
    public function testInitLibWithTokenString() {
        $token = 'fake_token'; // token string never contains a colon
        $ably = new AblyRest( $token );
        $this->assertFalse( $ably->auth->isUsingBasicAuth(), 'Expected token auth to be used' );
    }

    /**
     * Init library with a token string in options
     */
    public function testInitLibWithTokenOption() {
        $ably = new AblyRest( [
            'token' => "this_is_not_really_a_token",
        ] );

        $this->assertFalse( $ably->auth->isUsingBasicAuth(), 'Expected token auth to be used' );
    }

    /**
     * Init library with a tokenDetails in options
     */
    public function testInitLibWithTokenDetailsOption() {
        $ably = new AblyRest( [
            'tokenDetails' => new TokenDetails( "this_is_not_really_a_token" ),
        ] );

        $this->assertFalse( $ably->auth->isUsingBasicAuth(), 'Expected token auth to be used' );
    }

    /**
     * Init library with a specified host
     */
    public function testInitLibWithSpecifiedHost() {
        $opts = [
            'key' => 'fake.key:veryFake',
            'restHost'  => 'some.other.host',
            'httpClass' => 'tests\HttpMockInitTest',
        ];
        $ably = new AblyRest( $opts );
        $ably->time(); // make a request
        $this->assertMatchesRegularExpression( '/^https?:\/\/some\.other\.host/', $ably->http->lastUrl, 'Unexpected host mismatch' );
    }

    /**
     * Init library with a specified port
     */
    public function testInitLibWithSpecifiedPort() {
        $opts = [
            'key' => 'fake.key:veryFake',
            'restHost'  => 'some.other.host',
            'tlsPort' => 999,
            'httpClass' => 'tests\HttpMockInitTest',
        ];
        $ably = new AblyRest( $opts );
        $ably->time(); // make a request
        $this->assertStringContainsString(
            'https://' . $opts['restHost'] . ':' . $opts['tlsPort'],
            $ably->http->lastUrl,
            'Unexpected host/port mismatch'
        );

        $opts = [
            'token' => 'fakeToken',
            'restHost'  => 'some.other.host',
            'port' => 999,
            'tls' => false,
            'httpClass' => 'tests\HttpMockInitTest',
        ];
        $ably = new AblyRest( $opts );
        $ably->time(); // make a request
        $this->assertStringContainsString(
            'http://' . $opts['restHost'] . ':' . $opts['port'],
            $ably->http->lastUrl,
            'Unexpected host/port mismatch'
        );
    }

    /**
     * Init library with specified environment
     */
    public function testInitLibWithSpecifiedEnv() {
        $ably = new AblyRest( [
            'key' => 'fake.key:veryFake',
            'environment'  => 'sandbox',
            'httpClass' => 'tests\HttpMockInitTest',
        ] );
        $ably->time(); // make a request
        $this->assertEquals( 'https://sandbox-rest.ably.io:443/time', $ably->http->lastUrl, 'Unexpected host mismatch' );
    }

    /**
     * Verify encrypted defaults to true, makes a request to https://rest.ably.io/...
     */
    public function testTLSDefaultIsTrue() {
        $opts = [
            'key' => 'fake.key:veryFake',
            'httpClass' => 'tests\HttpMockInitTest',
        ];
        $ably = new AblyRest( $opts );
        $ably->time(); // make a request
        $this->assertMatchesRegularExpression( '/^https:\/\/rest\.ably\.io/', $ably->http->lastUrl, 'Unexpected scheme/url mismatch' );
    }

    /**
     * Verify encrypted can be set to false, makes a request to http://rest.ably.io/...
     */
    public function testTLSCanBeFalse() {
        $opts = [
            'token' => 'fake.token',
            'httpClass' => 'tests\HttpMockInitTest',
            'tls' => false,
        ];
        $ably = new AblyRest( $opts );
        $ably->time(); // make a request
        $this->assertMatchesRegularExpression( '/^http:\/\/rest\.ably\.io/', $ably->http->lastUrl, 'Unexpected scheme/url mismatch' );
    }

    /**
     * Verify that connection is encrypted when set to true explicitly, makes a request to https://rest.ably.io/...
     */
    public function testTLSExplicitTrue() {
        $opts = [
            'token' => 'fake.token',
            'httpClass' => 'tests\HttpMockInitTest',
            'tls' => true,
        ];
        $ably = new AblyRest( $opts );
        $ably->time(); // make a request
        $this->assertMatchesRegularExpression( '/^https:\/\/rest\.ably\.io/', $ably->http->lastUrl, 'Unexpected scheme/url mismatch' );
    }


    /**
     * Verify that the httpMaxRetryCount option is honored
     * @testdox RSC15a
     */
    public function testMaxRetryCount() {
        $opts = [
            'key' => 'fake.key:veryFake',
            'httpClass' => 'tests\HttpMockInitTestTimeout',
            'httpMaxRetryCount' => 2,
        ];

        $ably = new AblyRest( $opts );
        try {
            $ably->time(); // make a request
            $this->fail('Expected the request to fail');
        } catch(AblyRequestException $e) {
            $this->assertCount(3, $ably->http->visitedHosts, 'Expected to have tried 1 main host and 2 fallback hosts');
        }
    }

    /**
     * Verify that fallback hosts are working and used in correct order
     * @testdox RSC15a, RSC15b. RSC15d, RSC15g3, RSC15b1 (use fallbacks when custom host, port or tlsport is not set)
     */
    public function testFallbackHosts() {
        $opts = [
            'key' => 'fake.key:veryFake',
            'httpClass' => 'tests\HttpMockInitTestTimeout',
            'httpMaxRetryCount' => 5,
        ];
        $ably = new AblyRest( $opts );
        try {
            $ably->time(); // make a request
            $this->fail('Expected the request to fail');
        } catch(AblyRequestException $e) {
            $this->assertCount(6, $ably->http->visitedHosts);
            $this->assertEquals( 'rest.ably.io' , $ably->http->visitedHosts[0],'Expected to try primary restHost first' );

            $expectedFallbackHosts = array_merge( [ 'rest.ably.io' ], Defaults::$fallbackHosts );
            $this->assertNotEquals( $expectedFallbackHosts, $ably->http->visitedHosts,'Expected to have fallback hosts randomized' );

            sort($expectedFallbackHosts);
            $actualVisitedHosts = $ably->http->visitedHosts; // copied by value;
            sort($actualVisitedHosts);
            $this->assertEquals( $expectedFallbackHosts, $actualVisitedHosts,'Expected to have tried all the fallback hosts' );
        }
    }

    /**
     * When using custom environment, should use custom env. fallback hosts
     * @testdox RSC15b1,RSC15g2
     */
    public function testEnvFallbackHosts() {
        $opts = [
            'key' => 'fake.key:veryFake',
            'httpClass' => 'tests\HttpMockInitTestTimeout',
            'httpMaxRetryCount' => 5,
            'environment' => 'alpha'
        ];
        $ably = new AblyRest( $opts );
        try {
            $ably->time(); // make a request
            $this->fail('Expected the request to fail');
        } catch(AblyRequestException $e) {
            $this->assertCount(6, $ably->http->visitedHosts);
            $this->assertEquals( 'alpha-rest.ably.io' , $ably->http->visitedHosts[0],'Expected to try primary restHost first' );

            $expectedFallbackHosts = array_merge( [ 'alpha-rest.ably.io' ], Defaults::getEnvironmentFallbackHosts('alpha'));
            $this->assertNotEquals( $expectedFallbackHosts, $ably->http->visitedHosts,'Expected to have fallback hosts randomized' );

            sort($expectedFallbackHosts);
            $actualVisitedHosts = $ably->http->visitedHosts; // copied by value;
            sort($actualVisitedHosts);
            $this->assertEquals( $expectedFallbackHosts, $actualVisitedHosts,'Expected to have tried all the fallback hosts' );
        }
    }

    /**
     * Verify that no fallbacks are tried when empty fallbacks are provided
     * @testdox RSC15b2
     */
    public function testNoFallbackOnEmptyCustomFallbacks() {
        $opts = [
            'key' => 'fake.key:veryFake',
            'httpClass' => 'tests\HttpMockInitTestTimeout',
            'restHost' => 'custom.host.com',
            'fallbackHosts' => [],
        ];
        $ably = new AblyRest( $opts );
        try {
            $ably->time(); // make a request
            $this->fail('Expected the request to fail');
        } catch(AblyRequestException $e) {
            $this->assertCount(1, $ably->http->visitedHosts);
            $this->assertEquals( [ 'custom.host.com' ], $ably->http->visitedHosts, 'Expected to have tried only the custom host' );
        }
    }

    /**
     * Verify that custom restHost and custom fallbackHosts are working
     * @testdox RSC15b2, RSC15g1
     */
    public function testCustomHostAndFallbacks() {
        $customFallbacks = [
            'first-fallback.custom.com',
            'second-fallback.custom.com',
            'third-fallback.custom.com',
        ];
        $defaultOpts = new ClientOptions([
            'restHost' => 'rest.custom.com',
            'fallbackHosts' => $customFallbacks,
        ]);

        $opts = array_merge ( $defaultOpts->toArray(), [
            'key' => 'fake.key:veryFake',
            'httpClass' => 'tests\HttpMockInitTestTimeout',
            'httpMaxRetryCount' => 3,
        ]);
        $ably = new AblyRest( $opts );
        try {
            $ably->time(); // make a request
            $this->fail('Expected the request to fail');
        } catch(AblyRequestException $e) {
            $this->assertCount(4, $ably->http->visitedHosts);
            $this->assertEquals( 'rest.custom.com' , $ably->http->visitedHosts[0],'Expected to try primary restHost first' );

            $expectedFallbackHosts = array_merge( [ $defaultOpts->restHost ], $customFallbacks);
            sort($expectedFallbackHosts);
            $actualVisitedHosts = $ably->http->visitedHosts; // copied by value;
            sort($actualVisitedHosts);
            $this->assertEquals($expectedFallbackHosts, $actualVisitedHosts, 'Expected to have tried all the fallback hosts' );
        }
    }

    /**
     * Verify that fallback hosts are not called on error code < 500 or > 504
     * @testdox RSC15d
     */
    public function testNoFallbackOnClientError() {

        $opts = [
            'key' => 'fake.key:veryFake',
            'httpClass' => 'tests\HttpMockInitTestTimeout',
        ];

        $ably = new AblyRest( $opts );
        $ably->http->httpErrorCode = 401;
        $ably->http->errorCode = 40101; // auth error

        try {
            $ably->time(); // make a request
            $this->fail('Expected the request to fail');
        } catch(AblyRequestException $e) {
            $this->assertCount(1, $ably->http->visitedHosts);
            $this->assertEquals( [ 'rest.ably.io' ], $ably->http->visitedHosts, 'Expected to have tried only the default host' );
        }
    }

    /**
     * Verify that default fallback hosts are NOT used when using a custom host
     * @testdox RSC15k
     */
    public function testNoFallbackOnCustomHost() {
        $opts = [
            'key' => 'fake.key:veryFake',
            'httpClass' => 'tests\HttpMockInitTestTimeout',
            'restHost' => 'custom.host.com',
        ];
        $ably = new AblyRest( $opts );
        try {
            $ably->time(); // make a request
            $this->fail('Expected the request to fail');
        } catch(AblyRequestException $e) {
            $this->assertCount(1, $ably->http->visitedHosts);
            $this->assertEquals( [ 'custom.host.com' ], $ably->http->visitedHosts, 'Expected to have tried only the custom host' );
        }
    }

    /**
     * Verify that fallback hosts are working - first 3 fail, 4th works
     * @testdox RSC15a
     */
    public function testFallbackHostsFailFirst3() {
        $opts = [
            'key' => 'fake.key:veryFake',
            'httpClass' => 'tests\HttpMockInitTestTimeout',
            'httpMaxRetryCount' => 5,
        ];
        $ably = new AblyRest( $opts );
        $ably->http->hostFailures = 3;
        $data = $ably->time(); // make a request

        $this->assertCount( 3, $ably->http->visitedHosts, 'Expected 3 hosts to fail' );
        $this->assertEquals( 999999, $data, 'Expected to receive test data' );
    }

    /**
     * Verify that Host header is set for fallback host
     * @testdox RSC15j
     */
    public function testFallbackHostHeader() {
        $customFallbacks = [
            'first-fallback.custom.com',
            'second-fallback.custom.com',
            'third-fallback.custom.com',
        ];
        $opts = new ClientOptions([
            'restHost' => 'rest.custom.com',
            'fallbackHosts' => $customFallbacks,
            'key' => 'fake.key:veryFake',
            'httpClass' => 'tests\HttpMockInitTestTimeout'
        ]);
        $ably = new AblyRest( $opts );
        try {
            $ably->time(); // make a request
            $this->fail('Expected the request to fail');
        } catch(AblyRequestException $e) {
            $this->assertCount(3, $ably->http->hostHeaders);
            $actualHostHeaders = $ably->http->hostHeaders;
            sort($actualHostHeaders);
            $this->assertEquals($customFallbacks, $actualHostHeaders);
        }
    }

    /**
     * Cached fallback host
     * @testdox RSC15f
     */
    public function testCachedFallback() {
        $fallbackCacheTimeoutInMs = 1999;
        $ably = new AblyRest( array_merge( self::$defaultOptions, [
            'key' => self::$testApp->getAppKeyDefault()->string,
            'fallbackRetryTimeout' => $fallbackCacheTimeoutInMs,
            'httpClass' => 'tests\HttpMockCachedFallback',
            'restHost' => 'custom.host.com',
            'fallbackHosts' => [
                'fallback1',
                'c.ably-realtime.com', // valid fallback host
                'fallback2',
            ],
        ]));

        $ably->time();
        $this->assertEquals("c.ably-realtime.com", $ably->host->getPreferredHost()); // check for cached host
        $this->assertGreaterThanOrEqual(1, $ably->http->fallbackRetries );
        $ably->http->resetRetries();

        $ably->time();
        $ably->time();
        $this->assertEquals("c.ably-realtime.com", $ably->host->getPreferredHost()); // check for cached host
        $this->assertEquals( 0, $ably->http->fallbackRetries); // zero retries since cached fallback is used

        sleep( 2); // expire cached host

        $ably->time();
        $this->assertEquals("c.ably-realtime.com", $ably->host->getPreferredHost()); // check for cached host
        $this->assertGreaterThanOrEqual( 1, $ably->http->fallbackRetries );
    }

    /**
     * Verify accuracy of time (to within 2 seconds of actual time)
     *
     * RSC16 RestClient#time function sends a get request to rest.ably.io/time
     * and returns the server time in milliseconds since epoch
     */
    public function testTimeAndAccuracy() {
        $opts = [
            'key' => 'fake.key:veryFake',
        ];
        $ably = new AblyRest( $opts );

        $time = $ably->time();
        $this->assertIsInt( $time );

        $systemTime = Miscellaneous::systemTime();
        $this->assertIsInt( $systemTime );

        $this->assertLessThan ( 2000, abs($time - $systemTime) );
    }

    /**
     * @testdox RTN17c
     */
    public function testActiveInternetConnection() {
        $opts = [
            'key' => 'fake.key:veryFake',
        ];
        $ably = new AblyRest( $opts );
        $this->assertTrue($ably ->hasActiveInternetConnection());
    }

    /**
     * Verify that time fails without valid host
     */
    public function testTimeFailsWithInvalidHost() {
        $ablyInvalidHost = new AblyRest( [
            'key' => 'fake.key:veryFake',
            'restHost' => 'this.host.does.not.exist',
        ]);

        $this->expectException(AblyRequestException::class);
        $reportedTime = $ablyInvalidHost->time();
    }

    /**
     * Verify that custom request timeout works.
     * Connection/open timeout not reliably testable.
     */
    public function testHttpTimeout() {
        $ably = new AblyRest( [
            'key' => 'fake.key:veryFake',
        ]);

        $ablyTimeout = new AblyRest( [
            'key' => 'fake.key:veryFake',
            'httpRequestTimeout' => 20, // 20 ms
        ]);

        $ably->http->get('https://rest.ably.io/time'); // should work
        $this->expectException(AblyRequestException::class);
        $this->expectExceptionCode(50003);
        $ablyTimeout->http->get('https://rest.ably.io/time'); // guaranteed to take more than 20 ms
    }
}


class HttpMockInitTest extends Http {
    public $lastUrl;
    
    public function request($method, $url, $headers = [], $params = []) {
        $this->lastUrl = $url;

        // mock response to /time
        return [
            'headers' => '',
            'body' => [ round( microtime( true ) * 1000 ), 0 ]
        ];
    }
}


class HttpMockInitTestTimeout extends Http {
    public $visitedHosts = [];
    public $hostFailures = 100; // number of attempts to time out before starting to return data
    public $httpErrorCode = 500;
    public $errorCode = 50003; // timeout
    public $hostHeaders = [];

    static function parseHeaders($raw_headers)
    {
        $headers = array();
        foreach ($raw_headers as $raw_header) {
            $h = explode(':', $raw_header);
            $headers[$h[0]] = trim($h[1]);
        }
        return $headers;
    }

    public function request($method, $url, $headers = [], $params = []) {
        $parsedHeaders = self::parseHeaders($headers);
        if (isset($parsedHeaders["Host"])) {
            $this->hostHeaders[] = $parsedHeaders["Host"];
        }
        if ($this->hostFailures > 0) {
            $this->visitedHosts[] = parse_url($url, PHP_URL_HOST) ;
            $this->hostFailures--;
            throw new AblyRequestException( 'Fake error', $this->errorCode, $this->httpErrorCode );
        }

        return [
            'headers' => 'HTTP/1.1 200 OK'."\n",
            'body' => [ 999999, 0 ],
        ];
    }
}


class HttpMockCachedFallback extends Http {
    public $fallbackRetries;

    public function __construct( $clientOptions ) {
        parent::__construct( $clientOptions );
        $this->fallbackRetries = 0;
    }

    public function request( $method, $url, $headers = [], $params = [] ) {
        if ( parse_url($url, PHP_URL_HOST) == "c.ably-realtime.com" ) { // cache specific host
            return parent::request($method, $url, $headers, $params);
        }
        $this->fallbackRetries++;
        throw new AblyRequestException( 'fake error', 50000, 500 );
    }

    public function resetRetries() {
        $this->fallbackRetries = 0;
    }
}
