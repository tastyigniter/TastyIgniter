<?php
namespace tests;
use Ably\AblyRest;
use Ably\Exceptions\AblyException;
use Ably\Models\PushChannelSubscription;
use Ably\Models\PaginatedResult;

require_once __DIR__ . '/factories/TestApp.php';
require_once __DIR__ . '/Utils.php';


function deviceData () {
    return [
        'id' => random_string(26),
        'clientId' => random_string(12),
        'platform' => 'ios',
        'formFactor' => 'phone',
        'push' => [
            'recipient' => [
                'transportType' => 'apns',
                'deviceToken' => '740f4707bebcf74f9b7c25d48e3358945f6aa01da5ddb387462c7eaf61bb78ad'
            ]
        ],
        'deviceSecret' => random_string(12),
    ];
}


class PushChannelSubscriptionsTest extends \PHPUnit\Framework\TestCase {
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
     * RSH1c1
     */
    public function testList() {
        $channel = 'pushenabled:list';

        // Register devices and subscribe
        $deviceIds = [];
        $clientIds = [];
        foreach(range(1,5) as $index) {
            // Register device
            $data = deviceData();
            self::$ably->push->admin->deviceRegistrations->save($data);
            $deviceIds[] = $data['id'];
            // Subscribe
            self::$ably->push->admin->channelSubscriptions->save([
                'channel' => $channel,
                'deviceId' => $data['id'],
            ]);
        }
        foreach(range(1,5) as $index) {
            // Register device
            $data = deviceData();
            self::$ably->push->admin->deviceRegistrations->save($data);
            $clientIds[] = $data['clientId'];
            // Subscribe
            self::$ably->push->admin->channelSubscriptions->save([
                'channel' => $channel,
                'clientId' => $data['clientId'],
            ]);
        }

        $params = [ 'channel' => $channel ];
        $response = self::$ably->push->admin->channelSubscriptions->list_($params);
        $this->assertInstanceOf(PaginatedResult::class, $response);
        $this->assertGreaterThanOrEqual(10, count($response->items));
        $this->assertInstanceOf(PushChannelSubscription::class, $response->items[0]);
        $this->assertContains($response->items[0]->deviceId, $deviceIds);

        // limit
        $response = self::$ably->push->admin->channelSubscriptions->list_(
            array_merge($params, ['limit' => 2])
        );
        $this->assertEquals(2, count($response->items));

        // Filter by device id
        $deviceId = $deviceIds[0];
        $response = self::$ably->push->admin->channelSubscriptions->list_(
            array_merge($params, ['deviceId' => $deviceId])
        );
        $this->assertEquals(1, count($response->items));
        $response = self::$ably->push->admin->channelSubscriptions->list_(
            array_merge($params, ['deviceId' => random_string(26)])
        );
        $this->assertEquals(0, count($response->items));

        // Filter by client id
        $clientId = $clientIds[0];
        $response = self::$ably->push->admin->channelSubscriptions->list_(
            array_merge($params, ['clientId' => $clientId])
        );
        $this->assertEquals(1, count($response->items));
        $response = self::$ably->push->admin->channelSubscriptions->list_(
            array_merge($params, ['clientId' => random_string(12)])
        );
        $this->assertEquals(0, count($response->items));
    }


    /**
     * RSH1c2
     */
    public function testListChannels() {
        $channelSubscriptions = self::$ably->push->admin->channelSubscriptions;

        // Register several subscriptions
        $clientId = random_string(12);
        foreach ( ['pushenabled:test1', 'pushenabled:test2', 'pushenabled:test3' ] as $name ) {
            $channelSubscriptions->save(['channel' => $name, 'clientId' => $clientId]);
        }

        $response = $channelSubscriptions->listChannels();
        $this->assertInstanceOf(PaginatedResult::class, $response);
        $this->assertTrue(is_array($response->items));
        $this->assertTrue(is_string($response->items[0]));
        $this->assertGreaterThanOrEqual(3, count($response->items));

        // limit
        $response = $channelSubscriptions->listChannels([ 'limit' => 2]);
        $this->assertEquals(2, count($response->items));
    }


    /**
     * RSH1c3
     */
    public function testSave() {
        // Create
        $data = deviceData();
        self::$ably->push->admin->deviceRegistrations->save($data);

        // Subscribe
        $channelSubscription = self::$ably->push->admin->channelSubscriptions->save([
            'channel' => 'pushenabled:test',
            'deviceId' => $data['id'],
        ]);
        $this->assertInstanceOf(PushChannelSubscription::class, $channelSubscription);
        $this->assertEquals($channelSubscription->channel, 'pushenabled:test');
        $this->assertEquals($channelSubscription->deviceId, $data['id']);

        // Update, doesn't fail
        self::$ably->push->admin->channelSubscriptions->save([
            'channel' => 'pushenabled:test',
            'deviceId' => $data['id'],
        ]);

        // Fail
        $clientId = random_string(12);
        $this->expectException(\InvalidArgumentException::class);
        self::$ably->push->admin->channelSubscriptions->save([
            'channel' => 'pushenabled:test',
            'deviceId' => $data['id'],
            'clientId' => $clientId,
        ]);
    }

    public function badValues() {
        $data = deviceData();
        return [
            [ [ 'channel' => 'notallowed', 'deviceId' => $data['id'] ] ],
            [ [ 'channel' => 'pushenabled:test', 'deviceId' => 'notregistered' ] ]
        ];
    }

    /**
     * @dataProvider badValues
     */
    public function testSaveInvalid($data) {
        $this->expectException(AblyException::class);
        self::$ably->push->admin->channelSubscriptions->save($data);
    }


    /**
     * RSH1c4
     */
    public function testRemove() {
        $admin = self::$ably->push->admin;
        $channelSubscriptions = $admin->channelSubscriptions;

        // Register device
        $data = deviceData();
        $admin->deviceRegistrations->save($data);
        $deviceId = $data['id'];
        $clientId = $data['clientId'];

        // Remove by device id
        $subscription = $channelSubscriptions->save([
            'channel' => 'pushenabled:test',
            'deviceId' => $deviceId,
        ]);

        $params = ['deviceId' => $deviceId];
        $response = $channelSubscriptions->list_($params);
        $this->assertEquals(1, count($response->items));
        $channelSubscriptions->remove($subscription);
        $response = $channelSubscriptions->list_($params);
        $this->assertEquals(0, count($response->items));

        // Remove by client id
        $subscription = $channelSubscriptions->save([
            'channel' => 'pushenabled:test',
            'clientId' => $clientId,
        ]);

        $params = ['clientId' => $clientId];
        $response = $channelSubscriptions->list_($params);
        $this->assertEquals(1, count($response->items));
        $channelSubscriptions->remove($subscription);
        $response = $channelSubscriptions->list_($params);
        $this->assertEquals(0, count($response->items));

        // Remove again, no error
        $channelSubscriptions->remove($subscription);
   }


    /**
     * RSH1c5
     */
    public function testRemoveWhere() {
        $admin = self::$ably->push->admin;
        $channelSubscriptions = $admin->channelSubscriptions;

        // Register device
        $data = deviceData();
        $admin->deviceRegistrations->save($data);
        $deviceId = $data['id'];
        $clientId = $data['clientId'];

        // Remove by device id
        $channelSubscriptions->save([
            'channel' => 'pushenabled:test',
            'deviceId' => $deviceId,
        ]);

        $params = ['deviceId' => $deviceId];
        $response = $channelSubscriptions->list_($params);
        $this->assertEquals(1, count($response->items));
        $channelSubscriptions->removeWhere($params);
        sleep(3); // Deletion is async: wait a few seconds
        $response = $channelSubscriptions->list_($params);
        $this->assertEquals(0, count($response->items));

        // Remove by client id
        $channelSubscriptions->save([
            'channel' => 'pushenabled:test',
            'clientId' => $clientId,
        ]);

        $params = ['clientId' => $clientId];
        $response = $channelSubscriptions->list_($params);
        $this->assertEquals(1, count($response->items));
        $channelSubscriptions->removeWhere($params);
        sleep(3); // Deletion is async: wait a few seconds
        $response = $channelSubscriptions->list_($params);
        $this->assertEquals(0, count($response->items));

        // Remove again, no error
        $channelSubscriptions->removeWhere($params);
   }

}
