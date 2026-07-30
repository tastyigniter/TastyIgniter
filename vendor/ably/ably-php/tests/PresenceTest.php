<?php
namespace tests;
use Ably\AblyRest;
use Ably\Exceptions\AblyRequestException;
use Ably\Utils\Crypto;
use Ably\Utils\Miscellaneous;

require_once __DIR__ . '/factories/TestApp.php';

class PresenceTest extends \PHPUnit\Framework\TestCase {

    protected static $testApp;
    protected static $defaultOptions;
    protected static $ably;

    protected static $presenceFixture;
    protected static $channel;

    public static function setUpBeforeClass(): void {

        self::$testApp = new TestApp();
        self::$defaultOptions = self::$testApp->getOptions();
        self::$ably = new AblyRest( array_merge( self::$defaultOptions, [
            'key' => self::$testApp->getAppKeyDefault()->string,
        ] ) );

        $fixture = self::$testApp->getFixture();
        self::$presenceFixture = $fixture->post_apps->channels[0]->presence;

        $cipherParams = Crypto::getDefaultParams([
            'key'       => $fixture->cipher->key,
            'algorithm' => $fixture->cipher->algorithm,
            'keyLength' => $fixture->cipher->keylength,
            'mode'      => $fixture->cipher->mode,
            'iv'        => $fixture->cipher->iv,
            'base64Key' => true,
            'base64Iv' => true,
        ]);

        $options = [
            'cipher' => $cipherParams,
        ];

        self::$channel = self::$ably->channel('persisted:presence_fixtures', $options);
    }

    public static function tearDownAfterClass(): void {
        self::$testApp->release();
    }

    /**
     * Compare presence data with fixture
     */
    public function testComparePresenceDataWithFixture() {
        $presence = self::$channel->presence->get();

        // verify presence existence and count
        $this->assertNotNull( $presence, 'Expected non-null presence data' );
        $this->assertEquals( 6, count($presence->items), 'Expected 6 presence messages' );

        // verify presence contents
        $fixturePresenceMap = [];
        foreach (self::$presenceFixture as $entry) {
            $fixturePresenceMap[$entry->clientId] = $entry->data;
        }

        foreach ($presence->items as $entry) {
            $this->assertNotNull( $entry->clientId, 'Expected non-null client ID' );
            $this->assertTrue(
                array_key_exists($entry->clientId, $fixturePresenceMap),
                'Expected presence contents to match'
            );
            if(self::$ably->options->useBinaryProtocol && $entry->clientId === 'client_encoded'){
                $this->assertEquals(
                    base64_decode($fixturePresenceMap[$entry->clientId]), $entry->originalData,
                    'Expected encrypted presence contents values to be equal match'
                );
            }
            else {
                $this->assertEquals(
                    $fixturePresenceMap[$entry->clientId], $entry->originalData,
                    'Expected presence contents values to be equal match'
                );
            }
        }

        // verify limit / pagination
        $firstPage = self::$channel->presence->get( [ 'limit' => 3, 'direction' => 'forwards' ] );

        $this->assertEquals( 3, count($firstPage->items), 'Expected 3 presence entries on the 1st page' );

        $nextPage = $firstPage->next();
        $this->assertEquals( 3, count($nextPage->items), 'Expected 3 presence entries on the 2nd page' );
        $this->assertTrue( $nextPage->isLast(), 'Expected last page' );
    }

    /**
     * Compare presence history with fixture
     */
    public function testComparePresenceHistoryWithFixture() {
        $history = self::$channel->presence->history();

        // verify history existence and count
        $this->assertNotNull( $history, 'Expected non-null history data' );
        $this->assertEquals( 6, count($history->items), 'Expected 6 history entries' );

        // verify history contents
        $fixtureHistoryMap = [];
        foreach (self::$presenceFixture as $entry) {
            $fixtureHistoryMap[$entry->clientId] = $entry->data;
        }

        foreach ($history->items as $entry) {
            $this->assertNotNull( $entry->clientId, 'Expected non-null client ID' );
            $this->assertTrue(
                isset($fixtureHistoryMap[$entry->clientId]) && $fixtureHistoryMap[$entry->clientId] == $entry->originalData,
                'Expected presence contents to match'
            );
        }

        // verify limit / pagination - forwards
        $firstPage = self::$channel->presence->history( [ 'limit' => 3, 'direction' => 'forwards' ] );

        $this->assertEquals( 3, count($firstPage->items), 'Expected 3 presence entries' );

        $nextPage = $firstPage->next();

        $this->assertEquals( self::$presenceFixture[0]->clientId, $firstPage->items[0]->clientId, 'Expected least recent presence activity to be the first' );
        $this->assertEquals( self::$presenceFixture[5]->clientId, $nextPage->items[2]->clientId, 'Expected most recent presence activity to be the last' );

        // verify limit / pagination - backwards (default)
        $firstPage = self::$channel->presence->history( [ 'limit' => 3 ] );

        $this->assertEquals( 3, count($firstPage->items), 'Expected 3 presence entries' );

        $nextPage = $firstPage->next();

        $this->assertEquals( self::$presenceFixture[5]->clientId, $firstPage->items[0]->clientId, 'Expected most recent presence activity to be the first' );
        $this->assertEquals( self::$presenceFixture[0]->clientId, $nextPage->items[2]->clientId, 'Expected least recent presence activity to be the last' );
    }

    /*
     * Check whether time range queries work properly
     */
    public function testPresenceHistoryTimeRange() {
        // ensure some time has passed since mock presence data was sent
        $delay = 1000; // sleep for 1000ms
        usleep($delay * 1000); // in microseconds

        $timeOffset = self::$ably->time() - Miscellaneous::systemTime();
        $now = $timeOffset + Miscellaneous::systemTime();

        // test with start parameter
        try {
            $history = self::$channel->presence->history( [ 'start' => $now ] );
            $this->assertEquals( 0, count($history->items), 'Expected 0 presence messages' );
        } catch (AblyRequestException $e) {
            $this->fail( 'Start parameter - ' . $e->getMessage() . ', HTTP code: ' . $e->getCode() );
        }

        // test with end parameter
        try {
            $history = self::$channel->presence->history( [ 'end' => $now ] );
            $this->assertEquals( 6, count($history->items), 'Expected 6 presence messages' );
        } catch (AblyRequestException $e) {
            $this->fail( 'End parameter - ' . $e->getMessage() . ', HTTP code: ' . $e->getCode() );
        }

        // test with both start and end parameters - time range: ($now - 500ms) ... $now
        try {
            $history = self::$channel->presence->history( [ 'start' => $now - ($delay / 2), 'end' => $now ] );
            $this->assertEquals( 0, count($history->items), 'Expected 0 presence messages' );
        } catch (AblyRequestException $e) {
            $this->fail( 'Start + end parameter - ' . $e->getMessage() . ', HTTP code: ' . $e->getCode() );
        }

        // test ISO 8601 date format
        try {
            $history = self::$channel->presence->history( [ 'end' => gmdate('c', intval($now / 1000)) ] );
            $this->assertEquals( 6, count($history->items), 'Expected 6 presence messages' );
        } catch (AblyRequestException $e) {
            $this->fail( 'ISO format: ' . $e->getMessage() . ', HTTP code: ' . $e->getCode() );
        }
    }

    /**
     * Compare presence data with fixture
     */
    public function testComparePresenceDataWithFixtureEncrypted() {
        $presence = self::$channel->presence->get();

        // verify presence existence and count
        $this->assertNotNull( $presence, 'Expected non-null presence data' );
        $this->assertEquals( 6, count($presence->items), 'Expected 6 presence messages' );

        // verify presence contents
        $messageMap = [];
        foreach ($presence->items as $entry) {
            $messageMap[$entry->clientId] = $entry->data;
        }

        $this->assertEquals( $messageMap['client_decoded'], $messageMap['client_encoded'], 'Expected decrypted and sample data to match' );
    }

    /**
     * Ensure clientId and connectionId filters on Presence GET works
     */
    public function testFilters() {
        $presenceClientFilter = self::$channel->presence->get( [ 'clientId' => 'client_string' ] );
        $this->assertEquals( 1, count($presenceClientFilter->items), 'Expected the clientId filter to return 1 user' );

        $connId = $presenceClientFilter->items[0]->connectionId;

        $presenceConnFilter1 = self::$channel->presence->get( [ 'connectionId' => $connId ] );
        $this->assertEquals( 6, count($presenceConnFilter1->items), 'Expected the connectionId filter to return 6 users' );

        $presenceConnFilter2 = self::$channel->presence->get( [ 'connectionId' => '*FAKE CONNECTION ID*' ] );
        $this->assertEquals( 0, count($presenceConnFilter2->items), 'Expected the connectionId filter to return no users' );
    }
}
