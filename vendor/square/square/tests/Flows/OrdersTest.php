<?php
namespace Square\Tests;

use Core\Types\CallbackCatcher;

use Square\Exceptions\ApiException;
use Square\Exceptions;
use Square\ApiHelper;
use Square\Apis\OrdersApi;
use Square\Apis\LocationsApi;
use Square\Models\CreateOrderResponse;
use Square\Models\SearchOrdersRequest;
use Square\Models\SearchOrdersResponse;
use Square\Models\SearchOrdersQuery;
use Square\Models\SearchOrdersFilter;
use Square\Models\UpdateOrderResponse;
use Square\Models\BatchRetrieveOrdersResponse;
use Square\Models\PayOrderResponse;
use Square\Models\OrderMoneyAmounts;
use Square\Models\Order;
use Square\Models\CreateOrderRequest;
use Square\Models\OrderState;
use Square\Models\Money;
use Square\Models\UpdateOrderRequest;
use Square\Models\SearchOrdersStateFilter;
use Square\Models\BatchRetrieveOrdersRequest;
use Square\Models\PayOrderRequest;
use Square\Models;

use PHPUnit\Framework\TestCase;

class OrdersTest extends TestCase
{
    /**
     * @var \Square\Apis\OrdersApi Controller instance
     */
    protected static $controller;

    /**
     * @var \Square\LocationsApi Controller instance
     */
    protected static $Locations;

    /**
     * @var CallbackCatcher Callback
     */
    protected static $httpResponse;

    /**
     * Setup test class
     */
    public static function setUpBeforeClass(): void
    {
        self::$httpResponse = new CallbackCatcher();
        $client = ClientFactory::create(self::$httpResponse);
        self::$controller = $client->getOrdersApi();
        self::$Locations = $client->getLocationsApi();
    }


    public function testSearchOrders() 
    {

        $locationsResult = self::$Locations->listLocations();

        $this->assertTrue($locationsResult->isSuccess());

        $locationId = $locationsResult->getResult()->getLocations()[0]->getId();

       
        $body = new SearchOrdersRequest;
        $body->setLocationIds([$locationId]);
        $body->setQuery(new SearchOrdersQuery);
        $body->getQuery()->setFilter(new SearchOrdersFilter);
        $body_query_filter_stateFilter_states = [OrderState::COMPLETED];
        $body->getQuery()->getFilter()->setStateFilter(new SearchOrdersStateFilter(
            $body_query_filter_stateFilter_states
        ));

        $body->setLimit(3);
        $body->setReturnEntries(true);

        $apiResponse = self::$controller->searchOrders($body);


        $this->assertTrue($apiResponse->isSuccess());
        $this->assertTrue($apiResponse->getResult() instanceof SearchOrdersResponse);
    }

    public function testCreateOrder() 
    {

        $locationsResult = self::$Locations->listLocations();

        $this->assertTrue($locationsResult->isSuccess());

        $locationId = $locationsResult->getResult()->getLocations()[0]->getId();

        $body_idempotencyKey = uniqid();
        $order = new Order($locationId);

        $body = new CreateOrderRequest;
        $body->setIdempotencyKey($body_idempotencyKey);
        $body->setOrder($order);

        $apiResponse = self::$controller->createOrder($body);

        $this->assertTrue($apiResponse->isSuccess());
        $this->assertTrue($apiResponse->getResult() instanceof CreateOrderResponse);
        $this->assertTrue($apiResponse->getResult()->getOrder() instanceof Order);
        $this->assertEquals($apiResponse->getResult()->getOrder()->getLocationId(), $locationId);

        $orderId = $apiResponse->getResult()->getOrder()->getId();
        $version = $apiResponse->getResult()->getOrder()->getVersion();
        return array($orderId,$locationId,$version);
    }


    /**
     * @depends testCreateOrder
     */
    public function testUpdateOrder(array $orderLocationVersion)
    {
        $orderId = $orderLocationVersion[0];
        $locationId = $orderLocationVersion[1];
        $version  = $orderLocationVersion[2];

        $order = new Order($locationId);
        $order->setVersion($version);
        
        $body = new UpdateOrderRequest();
        $body->setOrder($order);

        $apiResponse = self::$controller->updateOrder($orderId, $body);

        $this->assertTrue($apiResponse->isSuccess());
        $this->assertTrue($apiResponse->getResult() instanceof UpdateOrderResponse);
        $this->assertTrue($apiResponse->getResult()->getOrder() instanceof Order);
        $this->assertEquals($apiResponse->getResult()->getOrder()->getLocationId(), $locationId);
        $this->assertEquals($apiResponse->getResult()->getOrder()->getVersion(), $version + 1);

        return array($orderId,$locationId);
    }

    /**
     * @depends testUpdateOrder
     */
    public function testBatchRetrieveOrders(array $orderIdLocationId) 
    {
        $orderId = $orderIdLocationId[0];
        $locationId = $orderIdLocationId[1];

        $body_orderIds = [$orderId];
        $body = new BatchRetrieveOrdersRequest(
            $body_orderIds
        );

        $apiResponse = self::$controller->batchRetrieveOrders($body);

        $this->assertTrue($apiResponse->isSuccess());
        $this->assertTrue($apiResponse->getResult() instanceof BatchRetrieveOrdersResponse );
        $this->assertEquals($apiResponse->getResult()->getOrders()[0]->getLocationId(), $locationId);

        return $orderId;
    }

    /**
     * @depends testBatchRetrieveOrders
     */
    public function testPayOrder($orderId)
    {
        $body_idempotencyKey = uniqid();
        $body = new PayOrderRequest(
            $body_idempotencyKey
        );

        // Empty since dollar value is zero
        $body->setPaymentIds([]);

        $apiResponse = self::$controller->payOrder($orderId, $body);

        $this->assertTrue($apiResponse->isSuccess());
        $this->assertTrue($apiResponse->getResult() instanceof PayOrderResponse );
        $this->assertTrue($apiResponse->getResult()->getOrder() instanceof Order );
        $this->assertEquals($apiResponse->getResult()->getOrder()->getState(), OrderState::COMPLETED);
        $this->assertTrue($apiResponse->getResult()->getOrder()->getTotalMoney() instanceof Money);
        $this->assertEquals($apiResponse->getResult()->getOrder()->getTotalMoney()->getAmount(), 0);

    }

}
