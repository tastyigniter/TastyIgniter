<?php

namespace Square\Tests;

use Square\SquareClient;
use Square\APIException;
use Square\Exceptions;
use Square\APIHelper;
use Square\Models;
use PHPUnit\Framework\TestCase;

class ErrorsTest extends TestCase
{
    public function testV2Error()
    {
        $client = new SquareClient([
            'environment' => \Square\Environment::SANDBOX,
            'accessToken' => 'BAD_TOKEN'
        ]);

        $response = $client->getLocationsApi()->listLocations();

        $this->assertEquals(401, $response->getStatusCode());
        $this->assertEquals(1, count($response->getErrors()));
        $this->assertEquals("AUTHENTICATION_ERROR", $response->getErrors()[0]->getCategory());
        $this->assertEquals("UNAUTHORIZED", $response->getErrors()[0]->getCode());
    }
}
