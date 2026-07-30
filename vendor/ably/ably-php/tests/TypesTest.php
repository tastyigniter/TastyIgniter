<?php
namespace tests;
use Ably\AblyRest;
use Ably\Auth;
use Ably\Defaults;
use Ably\Exceptions\AblyException;

require_once __DIR__ . '/factories/TestApp.php';

class TypesTest extends \PHPUnit\Framework\TestCase {

    public static function setUpBeforeClass(): void {
    }

    public static function tearDownAfterClass(): void {
    }

    protected function verifyClassMembers( $class, $expectedMembers ) {
        $valid = true;
        foreach( $expectedMembers as $member ) {
            $this->assertTrue( property_exists( $class, $member ),
                               "Expected class `$class` to contain a field named `$member`." );
        }
    }

    protected function verifyClassConstants( $class, $expectedMembers ) {
        foreach( $expectedMembers as $member => $value ) {
            $this->assertEquals( $value, constant( "$class::$member" ),
                "Expected class `$class` to have a constant `$member` with a value of `$value`."
            );
        }
    }

    protected function verifyObjectTypes( $obj, $expectedTypes ) {
        foreach( $obj as $key => $value ) {
            if ( gettype( $value ) == 'object' ) {
                $this->assertEquals( $expectedTypes[$key], get_class( $value ),
                    "Expected object (".get_class($obj).") to contain a member `$key` of type `".$expectedTypes[$key]."`."
                );
            } else {
                $this->assertEquals( $expectedTypes[$key], gettype( $value ),
                    "Expected object (".get_class($obj).") to contain a member `$key` of type `".$expectedTypes[$key]."`."
                );
            }
        }
    }

    public function testMessageType() {
        $this->verifyClassMembers( '\Ably\Models\Message', [
            'id',
            'clientId',
            'connectionId',
            'connectionKey',
            'name',
            'data',
            'encoding',
            'timestamp',
        ] );
    }

    public function testPresenceMessageType() {
        $this->verifyClassMembers( '\Ably\Models\PresenceMessage', [
            'id',
            'action',
            'clientId',
            'connectionId',
            'data',
            'encoding',
            'timestamp',
            'memberKey'
        ] );

        $this->verifyClassConstants( '\Ably\Models\PresenceMessage', [
            'ABSENT'  => 0,
            'PRESENT' => 1,
            'ENTER'   => 2,
            'LEAVE'   => 3,
            'UPDATE'  => 4
        ] );
    }

    public function testTokenRequestType() {
        $this->verifyClassMembers( '\Ably\Models\TokenRequest', [
            'keyName',
            'clientId',
            'nonce',
            'mac',
            'capability',
            'ttl',
        ] );
    }

    public function testTokenDetailsType() {
        $this->verifyClassMembers( '\Ably\Models\TokenDetails', [
            'token',
            'expires',
            'issued',
            'capability',
            'clientId',
        ] );
    }

    public function testStatsType() {
        $this->verifyClassMembers( '\Ably\Models\Stats', [
            'all',
            'apiRequests',
            'channels',
            'connections',
            'inbound',
            'intervalGranularity',
            'intervalId',
            'intervalTime',
            'outbound',
            'persisted',
            'tokenRequests'
        ] );
    }

    public function testErrorInfoType() {
        $this->verifyClassMembers( '\Ably\Models\ErrorInfo', [
            'code',
            'statusCode',
            'message',
        ] );
    }

    public function testClientOptionsType() {
        $this->verifyClassMembers( '\Ably\Models\ClientOptions', [
            'clientId',
            'logLevel',
            'logHandler',
            'tls',
            'useBinaryProtocol',
            'key',
            'token',
            'tokenDetails',
            'useTokenAuth',
            'authCallback',
            'authUrl',
            'authMethod',
            'authHeaders',
            'authParams',
            'queryTime',
            'environment',
            'restHost',
            'port',
            'tlsPort',
            'httpOpenTimeout',
            'httpRequestTimeout',
            'httpMaxRetryCount',
            'idempotentRestPublishing',
        ] );

        $co = new \Ably\Models\ClientOptions();
        $this->assertEquals( 4000, $co->httpOpenTimeout );
        $this->assertEquals( 10000, $co->httpRequestTimeout );
        $this->assertEquals( 3, $co->httpMaxRetryCount );
        $this->assertEquals( 15000, $co->httpMaxRetryDuration );
    }

    // TO3n
    public function testClientOptionsIdempotent()
    {
        // Test default value
        $co = new \Ably\Models\ClientOptions();
        if (Defaults::API_VERSION <= '1.1') {
            $this->assertEquals( false, $co->idempotentRestPublishing );
        } else {
            $this->assertEquals( true, $co->idempotentRestPublishing );
        }

        // Test explicit value
        $co = new \Ably\Models\ClientOptions( array( 'idempotentRestPublishing' => true ) );
        $this->assertEquals( true, $co->idempotentRestPublishing );

        $co = new \Ably\Models\ClientOptions( array( 'idempotentRestPublishing' => false ) );
        $this->assertEquals( false, $co->idempotentRestPublishing );
    }

    public function testAuthOptionsType() {
        $this->verifyClassMembers( '\Ably\Models\ClientOptions', [
            'key',
            'authCallback',
            'authUrl',
            'authMethod',
            'authHeaders',
            'authParams',
            'queryTime',
        ] );
    }

    public function testTokenParamsType() {
        $this->verifyClassMembers( '\Ably\Models\TokenParams', [
            'ttl',
            'capability',
            'clientId',
            'timestamp',
        ] );
    }

    public function testChannelOptionsType() {
        $this->verifyClassMembers( '\Ably\Models\ChannelOptions', [
            'cipher',
        ] );
    }

    public function testCipherParamsType() {
        $this->verifyClassMembers( '\Ably\Models\CipherParams', [
            'algorithm',
            'key',
            'keyLength',
            'mode'
        ] );
    }

    public function testStatsTypes() {
        $stats = new \Ably\Models\Stats();
        $this->verifyObjectTypes( $stats, [
            'all'                 => 'Ably\Models\Stats\MessageTypes',
            'inbound'             => 'Ably\Models\Stats\MessageTraffic',
            'outbound'            => 'Ably\Models\Stats\MessageTraffic',
            'persisted'           => 'Ably\Models\Stats\MessageTypes',
            'connections'         => 'Ably\Models\Stats\ConnectionTypes',
            'channels'            => 'Ably\Models\Stats\ResourceCount',
            'apiRequests'         => 'Ably\Models\Stats\RequestCount',
            'tokenRequests'       => 'Ably\Models\Stats\RequestCount',
            'intervalId'          => 'string',
            'intervalGranularity' => 'string',
            'intervalTime'        => 'integer',
        ] );

        // verify MessageTypes
        $this->verifyObjectTypes( $stats->all, [
            'all'      => 'Ably\Models\Stats\MessageCount',
            'messages' => 'Ably\Models\Stats\MessageCount',
            'presence' => 'Ably\Models\Stats\MessageCount',
        ] );

        // verify MessageCount
        $this->verifyObjectTypes( $stats->all->all, [
            'count' => 'integer',
            'data'  => 'integer',
        ] );

        // verify MessageTraffic
        $this->verifyObjectTypes( $stats->inbound, [
            'all'      => 'Ably\Models\Stats\MessageTypes',
            'realtime' => 'Ably\Models\Stats\MessageTypes',
            'rest'     => 'Ably\Models\Stats\MessageTypes',
            'webhook'  => 'Ably\Models\Stats\MessageTypes',
        ] );

        // verify ConnectionTypes
        $this->verifyObjectTypes( $stats->connections, [
            'all'   => 'Ably\Models\Stats\ResourceCount',
            'plain' => 'Ably\Models\Stats\ResourceCount',
            'tls'   => 'Ably\Models\Stats\ResourceCount',
        ] );

        // verify ResourceCount
        $this->verifyObjectTypes( $stats->connections->all, [
            'mean'    => 'integer',
            'min'     => 'integer',
            'opened'  => 'integer',
            'peak'    => 'integer',
            'refused' => 'integer',
        ] );

        // verify RequestCount
        $this->verifyObjectTypes( $stats->apiRequests, [
            'failed'    => 'integer',
            'refused'   => 'integer',
            'succeeded' => 'integer',
        ] );
    }

    public function testHttpPaginatedResponseType() {
        $this->verifyClassMembers( '\Ably\Models\HttpPaginatedResponse', [
            'items',
            'statusCode',
            'success',
            'errorCode',
            'errorMessage',
            'headers',
        ] );
    }
}
