<?php

declare(strict_types=1);

namespace Square\Tests\Apis;

use Square\Apis\LocationsApi;
use Square\Exceptions;

class LocationsApiTest extends BaseTestController
{
    /**
     * @var LocationsApi LocationsApi instance
     */
    protected static $controller;

    /**
     * Setup test class
     */
    public static function setUpBeforeClass(): void
    {
        self::$controller = parent::getClient()->getLocationsApi();
    }

    public function testListLocations()
    {
        // Perform API call
        $result = null;
        try {
            $result = self::$controller->listLocations()->getResult();
        } catch (Exceptions\ApiException $e) {
        }

        // Assert result with expected response
        $this->newTestCase($result)->expectStatus(200)->assert();
    }
}
