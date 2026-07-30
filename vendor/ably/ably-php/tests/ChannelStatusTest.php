<?php
namespace tests;
use Ably\AblyRest;

require_once __DIR__ . '/factories/TestApp.php';


class ChannelStatusTest extends \PHPUnit\Framework\TestCase
{
    protected static $testApp;
    protected static $defaultOptions;
    protected static $ably;

    public static function setUpBeforeClass(): void
    {
        self::$testApp = new TestApp();
        self::$defaultOptions = self::$testApp->getOptions();
        self::$ably = new AblyRest(array_merge(self::$defaultOptions, [
            'key' => self::$testApp->getAppKeyDefault()->string,
        ]));
    }

    public static function tearDownAfterClass(): void
    {
        self::$testApp->release();
    }

    /**
     * @testdox RSL8, CHD1
     */
    public function testChannelStatus()
    {
        $channel = self::$ably->channel('channel1');
        $channelStatus = $channel->status();
        self::assertNotNull($channelStatus->channelId);
        self::assertEquals("channel1", $channelStatus->channelId);
        self::assertEquals("channel1", $channelStatus->name);
        self::assertTrue($channelStatus->status->isActive);
    }
}
