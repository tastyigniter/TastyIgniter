<?php

namespace Square\Tests;

use Core\Types\CallbackCatcher;

use Square\APIException;
use Square\APIHelper;
use Square\Apis\MerchantsApi;
use Square\Exceptions;
use Square\Models\ListMerchantsResponse;
use Square\Models\Merchant;
use Square\Models\RetrieveMerchantResponse;

use PHPUnit\Framework\TestCase;

class MarchantsTest extends TestCase
{

    /**
     * @var \Square\Apis\MerchantsApi Controller instance
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
        self::$controller =  ClientFactory::create(self::$httpResponse)->getMerchantsApi();
    }

    public function testListMerchants() 
    {
        $apiResponse = self::$controller->listMerchants();

        $this->assertEquals($apiResponse->getStatusCode(), 200);
        $this->assertTrue($apiResponse->isSuccess());
        $this->assertFalse($apiResponse->isError());
        $this->assertTrue($apiResponse->getResult() instanceof ListMerchantsResponse);
        $this->assertIsArray($apiResponse->getResult()->getMerchant());

        return $apiResponse->getResult()->getMerchant()[0]->getId();
    }


    /**
     * @depends testListMerchants
     */
    public function testRetrieveMerchant($merchantId) 
    {

        $apiResponse = self::$controller->retrieveMerchant($merchantId);

        $this->assertEquals($apiResponse->getStatusCode(), 200);
        $this->assertTrue($apiResponse->isSuccess());
        $this->assertFalse($apiResponse->isError());
        $this->assertTrue($apiResponse->getResult() instanceof RetrieveMerchantResponse);
        $this->assertTrue($apiResponse->getResult()->getMerchant() instanceof Merchant);
        $this->assertEquals($apiResponse->getResult()->getMerchant()->getId(), $merchantId);
    }
   
}