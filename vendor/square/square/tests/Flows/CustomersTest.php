<?php

namespace Square\Tests;

use Core\Types\CallbackCatcher;

use Square\Models\Address;
use Square\Models\CreateCustomerCustomAttributeDefinitionRequest;
use Square\Models\CreateCustomerCustomAttributeDefinitionResponse;
use Square\Models\CreateCustomerRequest;
use Square\Models\CreateCustomerResponse;
use Square\Models\CustomAttribute;
use Square\Models\CustomAttributeDefinition;
use Square\Models\CustomAttributeDefinitionVisibility;
use Square\Models\Customer;
use Square\Models\DeleteCustomerCustomAttributeDefinitionResponse;
use Square\Models\RetrieveCustomerResponse;
use Square\Models\UpdateCustomerCustomAttributeDefinitionRequest;
use Square\Models\UpdateCustomerCustomAttributeDefinitionResponse;
use Square\Models\UpdateCustomerRequest;
use Square\Models\UpdateCustomerResponse;
use Square\Models\UpsertCustomerCustomAttributeRequest;
use Square\Models\UpsertCustomerCustomAttributeResponse;

use PHPUnit\Framework\TestCase;

class CustomersTest extends TestCase
{
    /**
     * @var \Square\Apis\CustomersApi Controller instance
     */
    protected static $controller;

    /**
     * @var \Square\Apis\CustomerCustomAttributesApi Controller instance
     */
    protected static $customAttributesController;

    /**
     * @var \Square\CustomersApi Controller instance
     */
    protected static $Locations;

    /**
     * @var CallbackCatcher Callback
     */
    protected static $httpResponse;

    private static $key;

    /**
     * Setup test class
     */
    public static function setUpBeforeClass(): void
    {
        self::$key = 'favorite-drink_' . phpversion();
        self::$httpResponse = new CallbackCatcher();
        self::$controller = ClientFactory::create(self::$httpResponse)->getCustomersApi();
        self::$customAttributesController = ClientFactory::create(self::$httpResponse)->getCustomerCustomAttributesApi();
    }

    public function testCreateCustomer(): ?Customer
    {
        $phone_number = "1-212-555-4240";

        $postal_code = "10003";

        // Create customer
        $request = new CreateCustomerRequest;
        $request->setGivenName('Amelia');
        $request->setFamilyName('Earhart');
        $request->setPhoneNumber($phone_number);
        $request->setNote('a customer');

        $address = new Address;
        $address->setAddressLine1("500 Electric Ave");
        $address->setAddressLine2("Suite 600");
        $address->setLocality("New York");
        $address->setAdministrativeDistrictLevel1("NY");
        $address->setPostalCode($postal_code);
        $address->setCountry("US");

        $request->setAddress($address);

        $response = self::$controller->createCustomer($request);
        $result = $response->getResult();
        assert($result instanceof CreateCustomerResponse);
        $data = $result->getCustomer();

        $this->assertEquals($data->getPhoneNumber(), $phone_number);
        $this->assertEquals($data->getAddress()->getPostalCode(), $postal_code);
        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertTrue($response->isSuccess());
        $this->assertFalse($response->isError());

        return $data;
    }

    /**
     * @depends testCreateCustomer
     */
    public function testGetCustomer(Customer $prevData): ?Customer
    {
        // Retrieve customer
        $customer_id = $prevData->getId();
        $response = self::$controller->retrieveCustomer($customer_id);
        $result = $response->getResult();
        assert($result instanceof RetrieveCustomerResponse);
        $data = $result->getCustomer();

        $this->assertTrue($response->isSuccess());
        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertEquals($data->getPhoneNumber(), $prevData->getPhoneNumber());
        $this->assertEquals($data->getAddress()->getPostalCode(), $prevData->getAddress()->getPostalCode());

        return $data;
    }

    /**
     * @depends testGetCustomer
     */
    public function testUpdateCustomer(Customer $prevData): ?Customer
    {
        $phone_number2 = "1-917-500-1000";
        $postal_code2 = "98100";
        $customer_id = $prevData->getId();

        // Update customer
        $updateRequest = new UpdateCustomerRequest;
        $updateRequest->setGivenName($prevData->getGivenName());
        $updateRequest->setFamilyName($prevData->getFamilyName());
        $updateRequest->setCompanyName($prevData->getCompanyName());
        $updateRequest->setNickname($prevData->getNickname());
        $updateRequest->setEmailAddress($prevData->getEmailAddress());
        $updateRequest->setAddress($prevData->getAddress());
        $updateRequest->setPhoneNumber($prevData->getPhoneNumber());
        $updateRequest->setReferenceId($prevData->getReferenceId());
        $updateRequest->setNote($prevData->getNote());
        $updateRequest->setBirthday($prevData->getBirthday());
        $updateRequest->setPhoneNumber($phone_number2);
        $updateRequest->getAddress()->setPostalCode($postal_code2);

        $response = self::$controller->updateCustomer($customer_id, $updateRequest);
        $result = $response->getResult();
        assert($result instanceof UpdateCustomerResponse);
        $data = $result->getCustomer();

        $this->assertTrue($response->isSuccess());
        $this->assertEquals($data->getPhoneNumber(), $phone_number2);
        $this->assertEquals($data->getAddress()->getPostalCode(), $postal_code2);
        $this->assertEquals($response->getStatusCode(), 200);

        return $data;
    }

    // Delete the `favorite-drink` definition if it exists
    public function testCleanupCustomerCustomAttributeDefinition()
    {
        $response = self::$customAttributesController->deleteCustomerCustomAttributeDefinition(self::$key);
        $result = $response->getResult();
        assert($result instanceof DeleteCustomerCustomAttributeDefinitionResponse);

        $this->assertEmpty($response->getErrors());
        $this->assertTrue($response->isSuccess());
        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertNull($result->getErrors());
    }

    /**
     * @depends testCleanupCustomerCustomAttributeDefinition
     */
    public function testCreateCustomerCustomAttributeDefinition(): ?CustomAttributeDefinition
    {
        $definition = new CustomAttributeDefinition;
        $definition->setKey(self::$key);
        $definition->setName('Favorite Drink' . phpversion());
        $definition->setDescription('The customer\'s favorite drink');
        $definition->setVisibility(CustomAttributeDefinitionVisibility::VISIBILITY_READ_WRITE_VALUES);
        $definition->setSchema('{"$ref":"https://developer-production-s.squarecdn.com/schemas/v1/common.json#squareup.common.String"}');
        $createRequest = new CreateCustomerCustomAttributeDefinitionRequest($definition);

        $response = self::$customAttributesController->createCustomerCustomAttributeDefinition($createRequest);
        $responseResult = $response->getResult();
        assert($responseResult instanceof CreateCustomerCustomAttributeDefinitionResponse);
        $data = $responseResult->getCustomAttributeDefinition();

        $this->assertEmpty($response->getErrors());
        $this->assertTrue($response->isSuccess());
        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertNull($responseResult->getErrors());
        $this->assertEquals($data->getKey(), self::$key);
        $this->assertEquals($data->getName(), 'Favorite Drink' . phpversion());
        $this->assertEquals($data->getDescription(), 'The customer\'s favorite drink');
        $this->assertEquals($data->getVisibility(), 'VISIBILITY_READ_WRITE_VALUES');
        $this->assertEquals($data->getVersion(), 1);
        $expectedSchema = json_decode('{ "$ref": "https://developer-production-s.squarecdn.com/schemas/v1/common.json#squareup.common.String" }');
        $this->assertEquals($data->getSchema(), $expectedSchema);

        return $data;
    }

    /**
     * @depends testCreateCustomerCustomAttributeDefinition
     */
    public function testUpdateCustomerCustomAttributeDefinition(CustomAttributeDefinition $created): ?CustomAttributeDefinition
    {
        $created->setName('Preferred Drink' . phpversion());
        $updateRequest = new UpdateCustomerCustomAttributeDefinitionRequest($created);

        $response = self::$customAttributesController->updateCustomerCustomAttributeDefinition($created->getKey(), $updateRequest);
        $responseResult = $response->getResult();
        assert($responseResult instanceof UpdateCustomerCustomAttributeDefinitionResponse);
        $data = $responseResult->getCustomAttributeDefinition();

        $this->assertEmpty($response->getErrors());
        $this->assertTrue($response->isSuccess());
        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertNull($responseResult->getErrors());
        $this->assertEquals($data->getKey(), self::$key);
        $this->assertEquals($data->getName(), 'Preferred Drink' . phpversion());
        $this->assertEquals($data->getDescription(), 'The customer\'s favorite drink');
        $this->assertEquals($data->getVisibility(), 'VISIBILITY_READ_WRITE_VALUES');
        $this->assertEquals($data->getVersion(), 2);
        $expectedSchema = json_decode('{ "$ref": "https://developer-production-s.squarecdn.com/schemas/v1/common.json#squareup.common.String" }');
        $this->assertEquals($data->getSchema(), $expectedSchema);

        return $data;
    }

    /**
     * @depends testUpdateCustomer
     * @depends testUpdateCustomerCustomAttributeDefinition
     */
    public function testCreateCustomerCustomAttribute(Customer $customerData, CustomAttributeDefinition $definitionData): ?CustomAttribute
    {
        $customAttribute = new CustomAttribute;
        $customAttribute->setValue('Double-shot breve');
        $upsertRequest = new UpsertCustomerCustomAttributeRequest($customAttribute);

        $customerId = $customerData->getId();
        $key = $definitionData->getKey();
        $response = self::$customAttributesController->upsertCustomerCustomAttribute($customerId, $key, $upsertRequest);

        $this->assertEmpty($response->getErrors());
        $this->assertTrue($response->isSuccess());
        $this->assertEquals($response->getStatusCode(), 200);
        $responseResult = $response->getResult();
        assert($responseResult instanceof UpsertCustomerCustomAttributeResponse);
        $this->assertNull($responseResult->getErrors());
        $result = $responseResult->getCustomAttribute();
        $this->assertEquals($result->getKey(), self::$key);
        $this->assertEquals($result->getValue(), 'Double-shot breve');
        $this->assertEquals($result->getVersion(), 1);
        $this->assertEquals($result->getVisibility(), 'VISIBILITY_READ_WRITE_VALUES');

        return $result;
    }

    /**
     * @depends testUpdateCustomer
     * @depends testCreateCustomerCustomAttributeDefinition
     * @depends testCreateCustomerCustomAttribute
     */
    public function testUpdateCustomerCustomAttribute(Customer $customerData, CustomAttributeDefinition $definitionData, CustomAttribute $created)
    {
        $customAttribute = new CustomAttribute;
        $customAttribute->setVersion($created->getVersion());
        $customAttribute->setValue('Black coffee');
        $upsertRequest = new UpsertCustomerCustomAttributeRequest($customAttribute);

        $customerId = $customerData->getId();
        $key = $definitionData->getKey();
        $response = self::$customAttributesController->upsertCustomerCustomAttribute($customerId, $key, $upsertRequest);

        $this->assertEmpty($response->getErrors());
        $this->assertTrue($response->isSuccess());
        $this->assertEquals($response->getStatusCode(), 200);
        $responseResult = $response->getResult();
        assert($responseResult instanceof UpsertCustomerCustomAttributeResponse);
        $this->assertNull($responseResult->getErrors());
        $result = $responseResult->getCustomAttribute();
        $this->assertEquals($result->getKey(), self::$key);
        $this->assertEquals($result->getValue(), 'Black coffee');
        $this->assertEquals($result->getVersion(), 2);
        $this->assertEquals($result->getVisibility(), 'VISIBILITY_READ_WRITE_VALUES');

        return $customerId;
    }

    /**
     * @depends testUpdateCustomerCustomAttribute
     */
    public function testDelete($customer_id)
    {
        // Delete customer
        $response = self::$controller->deleteCustomer($customer_id);
        $this->assertEquals($response->getStatusCode(), 200);
    }
}
