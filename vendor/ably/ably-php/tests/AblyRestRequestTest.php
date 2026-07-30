<?php
namespace tests;
use Ably\AblyRest;
require_once __DIR__ . '/factories/TestApp.php';

class AblyRestRequestTest extends \PHPUnit\Framework\TestCase {

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
     * Batch publishes messages for given list of channels
     * RSC19
     * https://ably.com/docs/api/rest-api#batch-publish
     * @throws \Ably\Exceptions\AblyRequestException
     */
    public function testBatchPublishMultipleChannelsUsingPostRequest() {

        $payload = array(
            "channels" => ["channel1", "channel2", "channel3", "channel4"],
            "messages" => array(
                "id" => "1",
                "data" => "foo"
            )
        );

        $batchPublishPaginatedResult = self::$ably->request("POST","/messages", [], $payload);
        $this->assertNotNull($batchPublishPaginatedResult);
        $this->assertEquals(201, $batchPublishPaginatedResult->statusCode);
        $this->assertTrue($batchPublishPaginatedResult->success);
        $this->assertNull($batchPublishPaginatedResult->errorCode);
        $this->assertNull($batchPublishPaginatedResult->errorMessage);
        $this->assertTrue( $batchPublishPaginatedResult->isLast(), 'Expected not to be the last page' );

        if (self::$ably->options->useBinaryProtocol) {
            $this->assertEquals("application/x-msgpack", $batchPublishPaginatedResult->headers["Content-Type"]);
        } else {
            $this->assertEquals("application/json", $batchPublishPaginatedResult->headers["Content-Type"]);
        }
        $this->assertCount(4, $batchPublishPaginatedResult->items);
        foreach ($batchPublishPaginatedResult->items as $key=> $item) {
            $this->assertEquals("channel".($key + 1), $item->channel);
            $this->assertEquals(1, $item->messageId);
        }

        foreach (["channel1", "channel2", "channel3", "channel4"] as $channelName) {
            $channel = self::$ably->channel($channelName);
            $paginatedHistory = $channel->history();
            foreach ($paginatedHistory->items as $msg) {
                $this->assertEquals("1", $msg->id);
                $this->assertEquals("foo", $msg->data);
            }
        }
    }
}
