<?php

namespace Square\Tests;

use Core\Types\CallbackCatcher;

use Square\APIException;
use Square\APIHelper;
use Square\Exceptions;

use Square\Apis\MobileAuthorizationApi;
use Square\Apis\LocationsApi;
use Square\Models\CreateMobileAuthorizationCodeRequest;
use Square\Models\CreateMobileAuthorizationCodeResponse;
use PHPUnit\Framework\TestCase;

class MobileAuthorizationTest extends TestCase
{

    /**
     * @var \Square\Apis\MobileAuthorizationApi Controller instance
     */
    protected static $controller;

    /**
     * @var CallbackCatcher Callback
     */
    protected static $httpResponse;

    /**
     * @var \Square\LocationsApi Controller instance
     */
    protected static $Locations;

    /**
     * Setup test class
     */
    public static function setUpBeforeClass(): void
    {
        self::$httpResponse = new CallbackCatcher();
        $client = ClientFactory::create(self::$httpResponse);
        self::$controller = $client->getMobileAuthorizationApi();
        self::$Locations = $client->getLocationsApi();
    }

    public function testCreateMobileAuthorizationCode() 
    {
        $locationsResult = self::$Locations->listLocations();

        $this->assertTrue($locationsResult->isSuccess());

        $locationId = $locationsResult->getResult()->getLocations()[0]->getId();
        $body = new CreateMobileAuthorizationCodeRequest();
        $body->setLocationId($locationId);
        $apiResponse = self::$controller->createMobileAuthorizationCode($body);

        $this->assertEquals($apiResponse->getStatusCode(), 200);
        $this->assertTrue($apiResponse->isSuccess());
        $this->assertFalse($apiResponse->isError());
        $this->assertTrue($apiResponse->getResult() instanceof CreateMobileAuthorizationCodeResponse);
    }
   
}