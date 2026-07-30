<?php
namespace tests;
use Ably\AblyRest;
use Ably\Channel;
use Ably\Models\Message;

require_once __DIR__ . '/factories/TestApp.php';

class ChannelHistoryTest extends \PHPUnit\Framework\TestCase {

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
     * Publish events and check expected order (forwards)
     */
    public function testPublishEventsAndCheckOrderForwards() {
        // publish some messages
        $history1 = self::$ably->channel('persisted:history1');
        
        $msgsToSend = [];
        for ( $i = 0; $i < 50; $i++ ) {
            $msg = new Message();
            $msg->name = 'history'.$i;
            $msg->data = (string) $i;
            $msgsToSend[] = $msg;
        }
        $history1->publish( $msgsToSend );

        // get the history for this channel
        $messages = $history1->history( ['direction' => 'forwards'] );
        $this->assertEquals( 50, count($messages->items), 'Expected 50 messages' );

        // verify message order
        $actual_message_history = [];
        foreach ($messages->items as $msg) {
            $actual_message_history[] = (int) $msg->data;
        }
        $expected_message_history = range(0, 49);
        $this->assertEquals( $expected_message_history, $actual_message_history, 'Expect messages in forward order');
    }

    /**
     * Publish events and check expected order (backwards)
     */
    public function testPublishEventsAndCheckOrderBackwards() {
        // publish some messages
        $history2 = self::$ably->channel('persisted:history2');
        
        $msgsToSend = [];
        for ( $i = 0; $i < 50; $i++ ) {
            $msg = new Message();
            $msg->name = 'history'.$i;
            $msg->data = (string) $i;
            $msgsToSend[] = $msg;
        }
        $history2->publish( $msgsToSend );

        $messages = $history2->history( ['direction' => 'backwards'] );
        $this->assertEquals( 50, count($messages->items), 'Expected 50 messages' );

        // verify message order
        $actual_message_history = [];
        foreach ($messages->items as $msg) {
            $actual_message_history[] = (int) $msg->data;
        }
        $expected_message_history = range(49, 0, -1);
        $this->assertEquals( $expected_message_history, $actual_message_history, 'Expect messages in backward order');
    }

    /**
     * Test default limit (100 messages) and default order (backwards)
     */
    public function testDefaults() {
        $channel = self::$ably->channel('persisted:history_def_limit');
        
        $msgsToSend = [];
        for ( $i = 0; $i < 101; $i++ ) {
            $msg = new Message();
            $msg->data = (string) $i;
            $msgsToSend[] = $msg;
        }
        $channel->publish( $msgsToSend );

        $messages = $channel->history();
        $this->assertEquals( 100, count( $messages->items ), 'Expected 100 messages' );

        // verify message order
        $actual_message_history = [];
        foreach ($messages->items as $msg) {
            $actual_message_history[] = (int) $msg->data;
        }
        $expected_message_history = range(100, 1, -1);
        $this->assertEquals( $expected_message_history, $actual_message_history, 'Expect messages in backward order');
    }

    /**
     * Publish events, get limited history, check expected order (forwards) and pagination
     */
    public function testPublishEventsGetLimitedHistoryAndCheckOrderForwards() {
        // publish some messages
        $history3 = self::$ably->channel( 'persisted:history3' );

        $msgsToSend = [];
        for ( $i = 0; $i < 50; $i++ ) {
            $msg = new Message();
            $msg->name = 'history'.$i;
            $msg->data = (string) $i;
            $msgsToSend[] = $msg;
        }
        $history3->publish( $msgsToSend );

        $messages = $history3->history( ['direction' => 'forwards', 'limit' => 25] );
        $this->assertEquals( 25, count($messages->items), 'Expected 25 messages' );

        // verify message order
        $actual_message_history = [];
        foreach ($messages->items as $msg) {
            $actual_message_history[] = (int) $msg->data;
        }
        $expected_message_history = range(0, 24);
        $this->assertEquals( $expected_message_history, $actual_message_history, 'Expect messages in forward order');

        // check pagination
        $this->assertTrue( $messages->isPaginated(), 'Expected messages to be paginated' );
        $this->assertTrue( $messages->hasFirst(), 'Expected to have first page' );
        $this->assertTrue( $messages->hasNext(), 'Expected to have next page' );
        $this->assertFalse( $messages->isLast(), 'Expected not to be the last page' );

        // next page
        $messages2 = $messages->next();
        $this->assertEquals( 25, count($messages2->items), 'Expected 25 messages on 2nd page' );

        $actual_message_history2 = [];
        foreach ($messages2->items as $msg) {
            $actual_message_history2[] = (int) $msg->data;
        }
        $expected_message_history2 = range(25, 49);
        $this->assertEquals( $expected_message_history2, $actual_message_history2, 'Expect messages in forward order on 2nd page');

        $this->assertTrue( $messages2->isPaginated(), 'Expected messages to be paginated' );
        $this->assertTrue( $messages2->hasFirst(), 'Expected to have first page' );
        $this->assertFalse( $messages2->hasNext(), 'Expected not to have next page' );
        $this->assertTrue( $messages2->isLast(), 'Expected to be the last page' );
        $this->assertNull( $messages2->next(), 'Expected the 3rd page to be null' );

        // get the first page from the 2nd page
        $messages1 = $messages2->first();
        $this->assertEquals( 25, count($messages1->items), 'Expected 25 messages on the 1st page' );

        $actual_message_history1 = [];
        foreach ($messages1->items as $msg) {
            $actual_message_history1[] = (int) $msg->data;
        }
        $this->assertEquals( $expected_message_history, $actual_message_history1, 'Expect messages to match the first page');

    }

    /**
     * Publish events, get limited history, check expected order (backwards) and pagination
     */
    public function testPublishEventsGetLimitedHistoryAndCheckOrderBackwards() {
        // publish some messages
        $history4 = self::$ably->channel('persisted:history4');
        
        $msgsToSend = [];
        for ( $i = 0; $i < 50; $i++ ) {
            $msg = new Message();
            $msg->name = 'history'.$i;
            $msg->data = (string) $i;
            $msgsToSend[] = $msg;
        }
        $history4->publish( $msgsToSend );

        $messages = $history4->history( ['direction' => 'backwards', 'limit' => 25] );
        $this->assertEquals( 25, count($messages->items), 'Expected 25 messages' );

        // verify message order
        $actual_message_history = [];
        foreach ($messages->items as $msg) {
            $actual_message_history[] = (int) $msg->data;
        }
        $expected_message_history = range(49, 25, -1);
        $this->assertEquals( $expected_message_history, $actual_message_history, 'Expect messages in backward order');

        // check pagination
        $this->assertTrue( $messages->isPaginated(), 'Expected messages to be paginated' );
        $this->assertTrue( $messages->hasFirst(), 'Expected to have first page' );
        $this->assertTrue( $messages->hasNext(), 'Expected to have next page' );
        $this->assertFalse( $messages->isLast(), 'Expected not to be the last page' );

        // next page
        $messages2 = $messages->next();
        $this->assertEquals( 25, count($messages2->items), 'Expected 25 messages on 2nd page' );

        $actual_message_history2 = [];
        foreach ($messages2->items as $msg) {
            $actual_message_history2[] = (int) $msg->data;
        }
        $expected_message_history2 = range(24, 0, -1);
        $this->assertEquals( $expected_message_history2, $actual_message_history2, 'Expect messages in backward order on 2nd page');

        $this->assertTrue( $messages2->isPaginated(), 'Expected messages to be paginated' );
        $this->assertTrue( $messages2->hasFirst(), 'Expected to have first page' );
        if ($messages2->hasNext()) {
            $messages3 = $messages2->next();
            $this->assertTrue( $messages3->isLast(), 'Expected to be the last page' );
            $this->assertNull( $messages3->next(), 'Expected the 4th page to be null' );
        } else {
            $this->assertTrue( $messages2->isLast(), 'Expected to be the last page' );
            $this->assertNull( $messages2->next(), 'Expected the 3rd page to be null' );
        }

        // get the first page from the 2nd page
        $messages1 = $messages2->first();
        $this->assertEquals( 25, count($messages1->items), 'Expected 25 messages on the 1st page' );

        $actual_message_history1 = [];
        foreach ($messages1->items as $msg) {
            $actual_message_history1[] = (int) $msg->data;
        }
        $this->assertEquals( $expected_message_history, $actual_message_history1, 'Expect messages to match the first page');
    }

    /**
     * Publish events and check expected history based on time slice (forwards)
     */
    public function testPublishEventsAndCheckExpectedHistoryInTimeSlicesForwards() {
        $interval_start = $interval_end = 0;

        // first publish some messages
        $history5 = self::$ably->channel('persisted:history5');

        // send batches of messages with short inter-message delay
        for ($i=0; $i<2; $i++) {
            $history5->publish( 'history'.$i, (string) $i );
            usleep(100000); // sleep for 0.1 of a second
        }
        $interval_start = self::$ably->time();
        for ($i=2; $i<4; $i++) {
            $history5->publish( 'history'.$i, (string) $i );
            usleep(100000); // sleep for 0.1 of a second
        }
        $interval_end = self::$ably->time();
        for ($i=4; $i<6; $i++) {
            $history5->publish( 'history'.$i, (string) $i );
            usleep(100000); // sleep for 0.1 of a second
        }

        // get the history for this channel
        $messages = $history5->history([
            'direction' => 'forwards',
            'start'     => $interval_start,
            'end'       => $interval_end,
        ]);
        $this->assertEquals( 2, count($messages->items), 'Expected 2 messages' );

        // verify message order
        $actual_message_history = [];
        for ($i=2; $i<4; $i++) {
            $actual_message_history[] = $messages->items[$i-2]->data;
        }
        $expected_message_history = [ 2, 3 ];
        $this->assertEquals( $expected_message_history, $actual_message_history, 'Expect messages in forward order');
    }

    /**
     * Publish events and check expected history based on time slice (backwards)
     */
    public function testPublishEventsAndCheckExpectedHistoryInTimeSlicesBackwards() {
        $interval_start = $interval_end = 0;

        // first publish some messages
        $history6 = self::$ably->channel('persisted:history6');

        // send batches of messages with short inter-message delay
        for ($i=0; $i<2; $i++) {
            $history6->publish( 'history'.$i, (string) $i );
            usleep(100000); // sleep for 0.1 of a second
        }
        $interval_start = self::$ably->time();
        for ($i=2; $i<4; $i++) {
            $history6->publish( 'history'.$i, (string) $i );
            usleep(100000); // sleep for 0.1 of a second
        }
        $interval_end = self::$ably->time();
        for ($i=4; $i<6; $i++) {
            $history6->publish( 'history'.$i, (string) $i );
            usleep(100000); // sleep for 0.1 of a second
        }

        // get the history for this channel
        $messages = $history6->history([
            'direction' => 'backwards',
            'start'     => $interval_start,
            'end'       => $interval_end,
        ]);

        $this->assertEquals( 2, count($messages->items), 'Expected 20 messages' );

        // verify message order
        $actual_message_history = [];
        for ($i=2; $i<4; $i++) {
            $actual_message_history[] = $messages->items[$i-2]->data;
        }
        $expected_message_history = [ 3, 2 ];
        $this->assertEquals( $expected_message_history, $actual_message_history, 'Expect messages in backward order' );
    }
}
