<?php
namespace tests;
use Ably\AblyRest;
use Ably\Http;
use Ably\Models\Message;
use Ably\Exceptions\AblyRequestException;
use Ably\Utils\Miscellaneous;
use MessagePack\MessagePack;
use MessagePack\PackOptions;

require_once __DIR__ . '/factories/TestApp.php';


class HttpMockIdempotent extends Http {
    public function request( $method, $url, $headers = [], $params = [] ) {
        static $failures = 0;

        $ret = parent::request($method, $url, $headers, $params);
        if ( $method == 'POST' and $failures < 2) {
            $failures++;
            throw new AblyRequestException( 'fake error', 50000, 500 );
        }
        return $ret;
    }
}


class ChannelIdempotentTest extends \PHPUnit\Framework\TestCase {
    protected static $testApp;
    protected static $defaultOptions;
    protected static $ably;

    public static function setUpBeforeClass(): void {
        self::$testApp = new TestApp();
        self::$defaultOptions = self::$testApp->getOptions();
        self::$ably = new AblyRest( array_merge( self::$defaultOptions, [
            'key' => self::$testApp->getAppKeyDefault()->string,
            'idempotentRestPublishing' => true,
        ] ) );
    }

    public static function tearDownAfterClass(): void {
        self::$testApp->release();
    }

    /**
     * RSL1j
     */
    public function testMessageSerialization() {
        $channel = self::$ably->channel( 'messageSerialization' );

        $msg = new Message();
        $msg->name = 'name';
        $msg->data = 'data';
        $msg->clientId = 'clientId';
        $msg->id = 'foobar';

        $body = $channel->__publish_request_body( $msg );
        if(self::$ably->options->useBinaryProtocol) {
            $body = MessagePack::unpack($body);
            Miscellaneous::deepConvertArrayToObject($body);
        }
        else
            $body = json_decode($body);

        $this->assertTrue( property_exists($body, 'name') );
        $this->assertTrue( property_exists($body, 'data') );
        $this->assertTrue( property_exists($body, 'clientId') );
        $this->assertTrue( property_exists($body, 'id') );
    }

    /**
     * RSL1k1
     */
    public function testIdempotentLibraryGenerated() {
        $channel = self::$ably->channel( 'idempotentLibraryGenerated' );

        $msg = new Message();
        $msg->name = 'name';
        $msg->data = 'data';

        $body = $channel->__publish_request_body( $msg );
        if(self::$ably->options->useBinaryProtocol) {
            $body = MessagePack::unpack($body);
            Miscellaneous::deepConvertArrayToObject($body);
        }
        else
            $body = json_decode($body);

        $id = explode ( ":", $body->id);
        $this->assertEquals( count($id), 2);
        $this->assertGreaterThanOrEqual( 9, strlen(base64_decode($id[0])) );
        $this->assertEquals( $id[1], "0");

        $channel->publish($msg);
        $messages = $channel->history();
        $this->assertEquals(1, count($messages->items));
        $this->assertEquals($messages->items[0]->id, $msg->id);
    }

    /**
     * RSL1k2
     */
    public function testIdempotentClientSupplied() {
        $channel = self::$ably->channel( 'idempotentClientSupplied' );

        $msg = new Message();
        $msg->name = 'name';
        $msg->data = 'data';
        $msg->id = 'foobar';

        $body = $channel->__publish_request_body( $msg );
        if(self::$ably->options->useBinaryProtocol) {
            $body = MessagePack::unpack($body);
            Miscellaneous::deepConvertArrayToObject($body);
        }
        else
            $body = json_decode($body);

        $this->assertEquals( $body->id, "foobar" );

        $channel->publish($msg);
        $messages = $channel->history();
        $this->assertEquals(count($messages->items), 1);
        $this->assertEquals($messages->items[0]->id, $msg->id);
    }

    /**
     * RSL1k3
     */
    public function testIdempotentMixedIds() {
        $channel = self::$ably->channel( 'idempotentMixedIds' );

        $messages = [];

        $msg = new Message();
        $msg->name = 'name';
        $msg->data = 'data';
        $msg->id = 'foobar';
        $messages[] = $msg;

        $msg = new Message();
        $msg->name = 'name';
        $msg->data = 'data';
        $messages[] = $msg;

        $body = $channel->__publish_request_body( $messages );
        if(self::$ably->options->useBinaryProtocol) {
            $body = MessagePack::unpack($body);
            Miscellaneous::deepConvertArrayToObject($body);
        }
        else
            $body = json_decode($body);

        $this->assertEquals( $body[0]->id, "foobar" );
        $this->assertFalse( property_exists($body[1], 'id') );

        $this->expectException(AblyRequestException::class);
        $channel->publish($messages);
    }

    /**
     * RSL1k4
     */
    public function testIdempotentLibraryGeneratedPublish() {
        $ably = new AblyRest( array_merge( self::$defaultOptions, [
            'key' => self::$testApp->getAppKeyDefault()->string,
            'idempotentRestPublishing' => true,
            'httpClass' => 'tests\HttpMockIdempotent',
            'fallbackHosts' => [
                self::$ably->options->getPrimaryRestHost(),
                self::$ably->options->getPrimaryRestHost(),
                self::$ably->options->getPrimaryRestHost(),
            ],
        ] ) );

        $channel = $ably->channel( 'idempotentLibraryGeneratedPublish' );

        $msg = new Message();
        $msg->name = 'name';
        $msg->data = 'data';

        $body = $channel->publish( $msg );

        $messages = $channel->history();
        $this->assertEquals( 1, count($messages->items));
    }

    /**
     * RSL1k5
     */
    public function testIdempotentClientSuppliedPublish() {
        $channel = self::$ably->channel( 'idempotentClientSuppliedPublish' );

        $msg = new Message();
        $msg->name = 'name';
        $msg->data = 'data';
        $msg->id = 'foobar';

        $body = $channel->publish( $msg );
        $body = $channel->publish( $msg );
        $body = $channel->publish( $msg );

        $messages = $channel->history();
        $this->assertEquals( 1, count($messages->items));
    }

}
