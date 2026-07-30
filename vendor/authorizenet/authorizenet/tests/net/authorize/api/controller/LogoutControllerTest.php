<?php
namespace net\authorize\api\controller\test;

use net\authorize\api\contract\v1 AS apiContract;
use net\authorize\api\controller AS apiController;

require_once __DIR__ . '/ApiCoreTestBase.php';

class LogoutControllerTest extends ApiCoreTestBase
{
    public function testLogout()
    {
        $merchantAuthentication = new apiContract\MerchantAuthenticationType();
        $merchantAuthentication->setName(self::$LoginName);
        $merchantAuthentication->setTransactionKey(self::$TransactionKey);

        $request = new apiContract\LogoutRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setRefId( $this->refId);

        $controller = new apiController\LogoutController($request);
        $response = $controller->executeWithApiResponse( self::$TestEnvironment);
        // Handle the response.
        $this->assertNotNull($response, "null response");
        $this->assertNotNull($response->getMessages());

        $this->assertEquals("Ok", $response->getMessages()->getResultCode());
        $this->assertEquals( $this->refId, $response->getRefId());
        $this->assertTrue(0 < count($response->getMessages()));
        foreach ($response->getMessages() as $message)
        {
            $this->assertEquals("I00001", $message->getCode());
            $this->assertEquals("Successful.", $response->getText());
        }
    }
}
