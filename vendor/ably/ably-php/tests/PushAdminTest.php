<?php
namespace tests;
use Ably\AblyRest;
use Ably\Exceptions\AblyRequestException;
use InvalidArgumentException;

require_once __DIR__ . '/factories/TestApp.php';


class PushAdminTest extends \PHPUnit\Framework\TestCase {
    protected static $testApp;
    protected static $defaultOptions;
    protected static $ably;

    public static function setUpBeforeClass(): void {
        self::$testApp = new TestApp();
        self::$defaultOptions = self::$testApp->getOptions();
        self::$ably = new AblyRest( array_merge( self::$defaultOptions, [
            'key' => self::$testApp->getAppKeyDefault()->string,
        ] ) );
    }

    public static function tearDownAfterClass(): void {
        self::$testApp->release();
    }

    /**
     * RSH1a
     */
    public function testAdminPublish() {
        $channelName = 'pushenabled:push_admin_publish-ok';
        $recipient = [
            'transportType' => 'ablyChannel',
            'channel' => $channelName,
            'ablyKey' => self::$ably->options->key,
            'ablyUrl' => self::$testApp->server
        ];
        $data = [ 'data' => [ 'foo' => 'bar' ] ];

        self::$ably->push->admin->publish( $recipient, $data , true );
        sleep(5); // It takes some time for the message to show up in the history
        $channel = self::$ably->channel($channelName);
        $history = $channel->history();
        $this->assertEquals( 1, count($history->items), 'Expected 1 message' );
    }

    public function badValues() {
        $recipient = [ 'clientId' => 'ablyChannel' ];
        $data = [ 'data' => [ 'foo' => 'bar' ] ];

        return [
            [ [], $data ],
            [ $recipient, [] ],
        ];
    }

    /**
     * @dataProvider badValues
     */
    public function testAdminPublishInvalid($recipient, $data) {
        $this->expectException(InvalidArgumentException::class);
        self::$ably->push->admin->publish( $recipient, $data );
    }

    public function errorValues() {
        $recipient = [ 'clientId' => 'ablyChannel' ];
        $data = [ 'data' => [ 'foo' => 'bar' ] ];

        return [
            [ $recipient, [ 'xxx' => 25 ] ],
        ];
    }

    /**
     * @dataProvider errorValues
     */
    public function testAdminPublishError($recipient, $data) {
        $this->expectException(AblyRequestException::class);
        self::$ably->push->admin->publish( $recipient, $data );
    }

}
