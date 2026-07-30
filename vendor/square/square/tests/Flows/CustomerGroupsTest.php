<?php

namespace Square\Tests;

use Core\Types\CallbackCatcher;

use Square\APIException;
use Square\APIHelper;
use Square\Exceptions;
use Square\Models\CustomerGroup;
use Square\Models\CreateCustomerGroupRequest;
use Square\Models\DeleteCustomerGroupResponse;
use Square\Models\UpdateCustomerGroupRequest;
use Square\Models\UpdateCustomerGroupResponse;
use Square\Models\RetrieveCustomerGroupResponse;
use Square\Models\ListCustomerGroupsResponse;
use Square\Models\CreateCustomerGroupResponse;
use Square\Apis\CustomerGroupsApi;

use PHPUnit\Framework\TestCase;

class CustomerGroupsTest extends TestCase
{

    /**
     * @var \Square\Apis\CustomerGroupsApi Controller instance
     */
    protected static $controller;

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
        self::$controller = ClientFactory::create(self::$httpResponse)->getCustomerGroupsApi();
    }

    public function testListCustomerGroups() 
    {
        $apiResponse = self::$controller->listCustomerGroups();

        $this->assertTrue($apiResponse->isSuccess());
        $this->assertFalse($apiResponse->isError());
        $this->assertTrue($apiResponse->getResult() instanceof ListCustomerGroupsResponse);
    }

    public function testCreateCustomerGroup() 
    {
        // uniqid ensures that group name is unique 
        // used in test to avoid errors caused by concurrently running tests
        $body_group_name = uniqid('Great Customers');
        $body_group = new CustomerGroup(
            $body_group_name
        );
        $body = new CreateCustomerGroupRequest(
            $body_group
        );

        $apiResponse = self::$controller->createCustomerGroup($body);

        $this->assertEquals($apiResponse->getStatusCode(), 200);
        $this->assertTrue($apiResponse->isSuccess());
        $this->assertFalse($apiResponse->isError());
        $this->assertTrue($apiResponse->getResult() instanceof CreateCustomerGroupResponse);
        $this->assertTrue($apiResponse->getResult()->getGroup() instanceof CustomerGroup);

        return $apiResponse->getResult()->getGroup()->getId();
    }

    /**
     * @depends testCreateCustomerGroup
     */
    public function testRetrieveCustomerGroup($groupId) 
    {
        $apiResponse = self::$controller->retrieveCustomerGroup($groupId);;

        $this->assertEquals($apiResponse->getStatusCode(), 200);
        $this->assertTrue($apiResponse->isSuccess());
        $this->assertFalse($apiResponse->isError());
        $this->assertTrue($apiResponse->getResult() instanceof RetrieveCustomerGroupResponse);
        $this->assertTrue($apiResponse->getResult()->getGroup() instanceof CustomerGroup);
        $this->assertEquals($apiResponse->getResult()->getGroup()->getId(), $groupId);

        return $groupId;
    }

    /**
     * @depends testRetrieveCustomerGroup
     */
    public function testUpdateCustomerGroup($groupId) 
    {
        $body_group_name = uniqid('The Best Customers' );
        $body_group = new CustomerGroup(
            $body_group_name
        );
        $body = new UpdateCustomerGroupRequest(
            $body_group
        );

        $apiResponse = self::$controller->updateCustomerGroup($groupId, $body);

        $this->assertEquals($apiResponse->getStatusCode(), 200);
        $this->assertTrue($apiResponse->isSuccess());
        $this->assertFalse($apiResponse->isError());
        $this->assertTrue($apiResponse->getResult() instanceof UpdateCustomerGroupResponse);
        $this->assertTrue($apiResponse->getResult()->getGroup() instanceof CustomerGroup);
        $this->assertEquals($apiResponse->getResult()->getGroup()->getId(), $groupId);

        return $groupId;
    }

    /**
     * @depends testUpdateCustomerGroup
     */
    public function testDeleteCustomerGroup($groupId) 
    {
        $apiResponse = self::$controller->deleteCustomerGroup($groupId);

        $this->assertEquals($apiResponse->getStatusCode(), 200);
        $this->assertTrue($apiResponse->isSuccess());
        $this->assertTrue($apiResponse->getResult() instanceof DeleteCustomerGroupResponse);
    }
}
