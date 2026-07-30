<?php
namespace tests;
use Ably\AblyRest;

require_once __DIR__ . '/factories/TestApp.php';

class AppStatsTest extends \PHPUnit\Framework\TestCase {

    protected static $testApp;
    protected static $defaultOptions;
    protected static $ably;
    protected static $timestamp;
    protected static $timestampOlder;
    protected static $timestampMs;
    protected static $timestampOlderMs;

    public static function setUpBeforeClass(): void {
        self::$testApp = new TestApp();
        self::$defaultOptions = self::$testApp->getOptions();
        self::$ably = new AblyRest( array_merge( self::$defaultOptions, [
            'key' => self::$testApp->getAppKeyDefault()->string,
        ] ) );

        self::$timestamp = strtotime( "first day of -1 month 14:00:00" );
        self::$timestampOlder = strtotime( "first day of -2 month 14:00:00" );
        self::$timestampMs = self::$timestamp * 1000;
        self::$timestampOlderMs = self::$timestampOlder * 1000;

        $fixtureEntries = [
            [
                "intervalId" => gmdate( 'Y-m-d:H:i', self::$timestamp ),
                "inbound" =>  [ "realtime" => [ "messages" => [ "count" => 50, "data" => 5000 ] ] ],
                "outbound" => [ "realtime" => [ "messages" => [ "count" => 20, "data" => 2000 ] ] ]
            ],
            [
                "intervalId" => gmdate( 'Y-m-d:H:i', self::$timestamp + 60 ),
                "inbound" =>  [ "realtime" => [ "messages" => [ "count" => 60, "data" => 6000 ] ] ],
                "outbound" => [ "realtime" => [ "messages" => [ "count" => 10, "data" => 1000 ] ] ]
            ],
            [
                "intervalId" => gmdate( 'Y-m-d:H:i', self::$timestamp + 120 ),
                "inbound" =>       [ "realtime" => [ "messages" => [ "count" => 70, "data" => 7000 ] ] ],
                "outbound" =>      [ "realtime" => [ "messages" => [ "count" => 40, "data" => 4000 ] ] ],
                "persisted" =>     [ "presence" => [ "count" => 20, "data" => 2000 ] ],
                "connections" =>   [ "tls" =>      [ "peak" => 20,  "opened" => 10 ] ],
                "channels" =>      [ "peak" => 50, "opened" => 30 ],
                "apiRequests" =>   [ "succeeded" => 50, "failed" => 10 ],
                "tokenRequests" => [ "succeeded" => 60, "failed" => 20 ]
            ]
        ];

        for ($i = 0; $i < 101; $i++) {
            $fixtureEntries[] = [
                "intervalId" => gmdate( 'Y-m-d:H:i', self::$timestampOlder + $i * 60 ),
                "channels" => [ "peak" => ($i + 1), "opened" => 1 ]
            ];
        }

        self::$ably->post( '/stats', [], $fixtureEntries );
    }

    public static function tearDownAfterClass(): void {
        self::$testApp->release();
    }

    /**
     * Check if stats are automatically populated by zeroes
     */
    public function testStatsDefaultValues() {
        $stats = new \Ably\Models\Stats();
        $this->assertTrue( $this->iterateObjectCheck0( $stats ), 'Expected newly created Stats to have zero values.' );
    }

    protected function iterateObjectCheck0($obj, $level = 0) {
        $valid = true;

        foreach ($obj as $key => $value) {
            if (is_object($value)) {
                if (!$this->iterateObjectCheck0($value, $level + 1)) $valid = false;
            } else {
                if ($level > 0 && $value !== 0) $valid = false;
            }
        }

        return $valid;
    }

    /**
     * Check minute-level stats exist (forwards)
     */
    public function testAppstatsMinute0() {
        $oneMinuteMs = 60 * 1000;
        $twoMinutesMs = 120 * 1000;
        // get the stats for this channel 
        // note that bounds are inclusive 
        $stats = self::$ably->stats([
            "direction" => "forwards",
            "start" => self::$timestampMs,
            "end" => self::$timestampMs
        ]);
        $this->assertEquals( 1, count( $stats->items ), "Expected 1 record" );
        $this->assertEquals( 50, $stats->items[0]->inbound->all->all->count, "Expected 50 messages" );

        $stats = self::$ably->stats([
            "direction" => "forwards",
            "start" => self::$timestampMs + $oneMinuteMs,
            "end" => self::$timestampMs + $oneMinuteMs
        ]);
        $this->assertEquals( 1, count( $stats->items ), "Expected 1 record" );
        $this->assertEquals( 60, $stats->items[0]->inbound->all->all->count, "Expected 60 messages" );

        $stats = self::$ably->stats([
            "direction" => "forwards",
            "start" => self::$timestampMs + $twoMinutesMs,
            "end" => self::$timestampMs + $twoMinutesMs
        ]);
        $this->assertEquals( 1, count( $stats->items ), "Expected 1 record" );
        $this->assertEquals( 70, $stats->items[0]->inbound->all->all->count, "Expected 70 messages" );
    }

    /**
     * Check minute-level stats exist (backwards)
     */
    public function testAppstatsMinute1() {
        $oneMinuteMs = 60 * 1000;
        $twoMinutesMs = 120 * 1000;
        // get the stats for this channel 
        // note that bounds are inclusive 
        $stats = self::$ably->stats([
            "direction" => "backwards",
            "start" => self::$timestampMs,
            "end" => self::$timestampMs
        ]);
        $this->assertEquals( 1, count( $stats->items ), "Expected 1 record" );
        $this->assertEquals( 50, $stats->items[0]->inbound->all->all->count, "Expected 50 messages" );

        $stats = self::$ably->stats([
            "direction" => "backwards",
            "start" => self::$timestampMs + $oneMinuteMs,
            "end" => self::$timestampMs + $oneMinuteMs
        ]);
        $this->assertEquals( 1, count( $stats->items ), "Expected 1 record" );
        $this->assertEquals( 60, $stats->items[0]->inbound->all->all->count, "Expected 60 messages" );

        $stats = self::$ably->stats([
            "direction" => "backwards",
            "start" => self::$timestampMs + $twoMinutesMs,
            "end" => self::$timestampMs + $twoMinutesMs
        ]);
        $this->assertEquals( 1, count( $stats->items ), "Expected 1 record" );
        $this->assertEquals( 70, $stats->items[0]->inbound->all->all->count, "Expected 70 messages" );
    }

    /**
     * Check hour-level stats exist (forwards)
     */
    public function testAppstatsHour0() {
        $twoMinutesMs = 120 * 1000;
        $stats = self::$ably->stats([
            "direction" => "forwards",
            "start" => self::$timestampMs,
            "end" => self::$timestampMs + $twoMinutesMs,
            "unit" => "hour"
        ]);
        $this->assertEquals( 1, count( $stats->items ), "Expected 1 record" );
        $this->assertEquals( 180, $stats->items[0]->inbound->all->all->count, "Expected 180 messages" );
    }

    /**
     * Check day-level stats exist (forwards)
     */
    public function testAppstatsDay0() {
        $twoMinutesMs = 120 * 1000;
        $stats = self::$ably->stats([
            "direction" => "forwards",
            "start" => self::$timestampMs,
            "end" => self::$timestampMs + $twoMinutesMs,
            "unit" => "day"
        ]);
        $this->assertEquals( 1, count( $stats->items ), "Expected 1 record" );
        $this->assertEquals( 180, $stats->items[0]->inbound->all->all->count, "Expected 180 messages" );
    }

    /**
     * Check month-level stats exist (forwards)
     */
    public function testAppstatsMonth0() {
        $twoMinutesMs = 120 * 1000;
        $stats = self::$ably->stats([
            "direction" => "forwards",
            "start" => self::$timestampMs,
            "end" => self::$timestampMs + $twoMinutesMs,
            "unit" => "month"
        ]);

        $this->assertEquals( 1, count( $stats->items ), "Expected 1 record" );
        $this->assertEquals( 180, $stats->items[0]->inbound->all->all->count, "Expected 180 messages" );
    }

    /**
     * Publish events and check limit query param (backwards)
     */
    public function testAppstatsLimit0() {
        $twoMinutesMs = 120 * 1000;
        $stats = self::$ably->stats([
            "direction" => "backwards",
            "start" => self::$timestampMs,
            "end" => self::$timestampMs + $twoMinutesMs,
            "limit" => 1
        ]);
        $this->assertEquals( 1, count( $stats->items ), "Expected 1 record" );
        $this->assertEquals( 70, $stats->items[0]->inbound->all->all->count, "Expected 70 messages" );
    }

    /**
     * Check limit query param (forwards)
     */
    public function testAppstatsLimit1() {
        $twoMinutesMs = 120 * 1000;
        $stats = self::$ably->stats([
            "direction" => "forwards",
            "start" => self::$timestampMs,
            "end" => self::$timestampMs + $twoMinutesMs,
            "limit" => 1
        ]);
        $this->assertEquals( 1, count( $stats->items ), "Expected 1 record" );
        $this->assertEquals( 50, $stats->items[0]->inbound->all->all->count, "Expected 50 messages" );
    }

    /**
     * Check query pagination (backwards)
     */
    public function testAppstatsPagination0() {
        $twoMinutesMs = 120 * 1000;
        $stats = self::$ably->stats([
            "direction" => "backwards",
            "start" => self::$timestampMs,
            "end" => self::$timestampMs + $twoMinutesMs,
            "limit" => 1
        ]);
        $this->assertEquals( 1, count( $stats->items ), "Expected 1 record" );
        $this->assertEquals( 70, $stats->items[0]->inbound->all->all->count, "Expected 70 messages" );
        // get next page 
        $stats = $stats->next();
        $this->assertEquals( 1, count( $stats->items ), "Expected 1 record" );
        $this->assertEquals( 60, $stats->items[0]->inbound->all->all->count, "Expected 60 messages" );
        // get next page 
        $stats = $stats->next();
        $this->assertEquals( 1, count( $stats->items ), "Expected 1 record" );
        $this->assertEquals( 50, $stats->items[0]->inbound->all->all->count, "Expected 50 messages" );
        // verify that there is no next page 
        $this->assertFalse( $stats->hasNext(), "Expected not to have next page" );
        $this->assertNull( $stats->next(), "Expected null next page" );
    }

    /**
     * Check query pagination (forwards)
     */
    public function testAppstatsPagination1() {
        $twoMinutesMs = 120 * 1000;
        $stats = self::$ably->stats([
            "direction" => "forwards",
            "start" => self::$timestampMs,
            "end" => self::$timestampMs + $twoMinutesMs,
            "limit" => 1
        ]);
        $this->assertEquals( 1, count( $stats->items ), "Expected 1 record" );
        $this->assertEquals( 50, $stats->items[0]->inbound->all->all->count, "Expected 50 messages" );
        // get next page 
        $stats = $stats->next();
        $this->assertEquals( 1, count( $stats->items ), "Expected 1 record" );
        $this->assertEquals( 60, $stats->items[0]->inbound->all->all->count, "Expected 60 messages" );
        // get next page 
        $stats = $stats->next();
        $this->assertEquals( 1, count( $stats->items ), "Expected 1 record" );
        $this->assertEquals( 70, $stats->items[0]->inbound->all->all->count, "Expected 70 messages" );
        // verify that there is no next page 
        $this->assertFalse( $stats->hasNext(), "Expected not to have next page" );
        $this->assertNull( $stats->next(), "Expected null next page" );
    }

    /**
     * Check query pagination rel="first" (backwards)
     */
    public function testAppstatsPagination2() {
        $twoMinutesMs = 120 * 1000;
        $stats = self::$ably->stats([
            "direction" => "backwards",
            "start" => self::$timestampMs,
            "end" => self::$timestampMs + $twoMinutesMs,
            "limit" => 1
        ]);
        $this->assertEquals( 1, count( $stats->items ), "Expected 1 record" );
        $this->assertEquals( 70, $stats->items[0]->inbound->all->all->count, "Expected 70 messages" );
        // get next page 
        $stats = $stats->next();
        $this->assertEquals( 1, count( $stats->items ), "Expected 1 record" );
        $this->assertEquals( 60, $stats->items[0]->inbound->all->all->count, "Expected 60 messages" );
        // get first page 
        $stats = $stats->first();
        $this->assertEquals( 1, count( $stats->items ), "Expected 1 record" );
        $this->assertEquals( 70, $stats->items[0]->inbound->all->all->count, "Expected 70 messages" );
    }

    /**
     * Check query pagination rel="first" (forwards)
     */
    public function testAppstatsPagination3() {
        $twoMinutesMs = 120 * 1000;
        $stats = self::$ably->stats([
            "direction" => "forwards",
            "start" => self::$timestampMs,
            "end" => self::$timestampMs + $twoMinutesMs,
            "limit" => 1
        ]);
        $this->assertEquals( 1, count( $stats->items ), "Expected 1 record" );
        $this->assertEquals( 50, $stats->items[0]->inbound->all->all->count, "Expected 50 messages" );
        // get next page 
        $stats = $stats->next();
        $this->assertEquals( 1, count( $stats->items ), "Expected 1 record" );
        $this->assertEquals( 60, $stats->items[0]->inbound->all->all->count, "Expected 60 messages" );
        // get first page 
        $stats = $stats->first();
        $this->assertEquals( 1, count( $stats->items ), "Expected 1 record" );
        $this->assertEquals( 50, $stats->items[0]->inbound->all->all->count, "Expected 50 messages" );
    }

    /**
     * Verify default pagination limit (100), direction (backwards) and unit (minute)
     */
    public function testPaginationDefaults () {
        $twoHoursMs = 120 * 60 * 1000;
        $stats = self::$ably->stats([
            "start" => self::$timestampOlderMs,
            "end" => self::$timestampOlderMs + $twoHoursMs,
        ]);
        $this->assertEquals( 100, count( $stats->items ), "Expected 100 records" );
 
        // verify order
        $actualRecordsPeakData = [];
        foreach ($stats->items as $minute) {
            $actualRecordsPeakData[] = (int) $minute->channels->peak;
        }
        $expectedData = range( 101, 2, -1 );
        $this->assertEquals( $expectedData, $actualRecordsPeakData, 'Expected records in backward order' );
    }
}