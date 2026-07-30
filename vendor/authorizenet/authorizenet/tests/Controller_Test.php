<?php
use \net\authorize\api\controller\base\ApiOperationBase;

require_once __DIR__ . '/../autoload.php';
//include if tests/bootstrap.php is not loaded automatically
require_once __DIR__ . '/bootstrap.php';

class Controller_Test extends PHPUnit_Framework_TestCase
{
    public function testARBGetSubscriptionList()
    {
        //$this->markTestSkipped('Ignoring for Travis. Will fix after release.'); //TODO

        $name =           (defined('AUTHORIZENET_API_LOGIN_ID')    && ''!=AUTHORIZENET_API_LOGIN_ID)    ? AUTHORIZENET_API_LOGIN_ID    : getenv("api_login_id");
        $transactionKey = (defined('AUTHORIZENET_TRANSACTION_KEY') && ''!=AUTHORIZENET_TRANSACTION_KEY) ? AUTHORIZENET_TRANSACTION_KEY : getenv("transaction_key");

        $merchantAuthentication = new net\authorize\api\contract\v1\MerchantAuthenticationType();
        $merchantAuthentication->setName($name);
        $merchantAuthentication->setTransactionKey($transactionKey);
        //$merchantAuthentication->setMobileDeviceId()

        $refId = 'ref' . time();

        $sorting = new net\authorize\api\contract\v1\ARBGetSubscriptionListSortingType();
        $sorting->setOrderBy('firstName');
        $sorting->setOrderDescending(false);

        $paging = new net\authorize\api\contract\v1\PagingType();
        $paging->setLimit(10);
        $paging->setOffset(1);

        $request = new net\authorize\api\contract\v1\ARBGetSubscriptionListRequest();
        $request->setSearchType('subscriptionActive');
        $request->setRefId( $refId);
        $request->setSorting($sorting);
        $request->setPaging($paging);
        $request->setMerchantAuthentication($merchantAuthentication);

        //$controller = new ApiOperationBase($request, 'net\authorize\api\contract\v1\ARBGetSubscriptionListResponse');
        $controller = new net\authorize\api\controller\ARBGetSubscriptionListController( $request);
        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);

        // Handle the response.
        $this->assertNotNull($response, "null response");
        $this->assertNotNull($response->getMessages());

        $this->assertEquals("Ok", $response->getMessages()->getResultCode());
        $this->assertEquals($response->getRefId(), $refId);
        $this->assertTrue(0 < count($response->getMessages()));
        foreach ($response->getMessages() as $message)
        {
            $this->assertEquals("I00001", $message->getCode());
            $this->assertEquals("Successful.", $response->getText());
       }
    }

    public function testARBGetSubscription()
    {
        $name =           (defined('AUTHORIZENET_API_LOGIN_ID')    && ''!=AUTHORIZENET_API_LOGIN_ID)    ? AUTHORIZENET_API_LOGIN_ID    : getenv("api_login_id");
        $transactionKey = (defined('AUTHORIZENET_TRANSACTION_KEY') && ''!=AUTHORIZENET_TRANSACTION_KEY) ? AUTHORIZENET_TRANSACTION_KEY : getenv("transaction_key");

        $merchantAuthentication = new net\authorize\api\contract\v1\MerchantAuthenticationType();
        $merchantAuthentication->setName($name);
        $merchantAuthentication->setTransactionKey($transactionKey);

        $refId = 'ref' . time();

        $request = new net\authorize\api\contract\v1\ARBGetSubscriptionRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setRefId($refId);
        $request->setSubscriptionId("2930242");

        $controller = new net\authorize\api\controller\ARBGetSubscriptionController($request);

        $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);

        $this->assertNotNull($response, "null response");
        $this->assertNotNull($response->getMessages());

        $this->assertEquals("Ok", $response->getMessages()->getResultCode());
        $this->assertEquals($response->getRefId(), $refId);
        $this->assertTrue(0 < count($response->getMessages()));

        foreach ($response->getMessages() as $message)
        {
            $this->assertEquals("I00001", $message->getCode());
            $this->assertEquals("Successful.", $response->getText());
        }
    }

    public function testGetCustomerPaymentProfileList()
    {
        $name =           (defined('AUTHORIZENET_API_LOGIN_ID')    && ''!=AUTHORIZENET_API_LOGIN_ID)    ? AUTHORIZENET_API_LOGIN_ID    : getenv("api_login_id");
        $transactionKey = (defined('AUTHORIZENET_TRANSACTION_KEY') && ''!=AUTHORIZENET_TRANSACTION_KEY) ? AUTHORIZENET_TRANSACTION_KEY : getenv("transaction_key");

        $merchantAuthentication = new net\authorize\api\contract\v1\MerchantAuthenticationType();
        $merchantAuthentication->setName($name);
        $merchantAuthentication->setTransactionKey($transactionKey);

        $refId = 'ref' . time();

        $paging = new net\authorize\api\contract\v1\PagingType();
        $paging->setLimit("1000");
        $paging->setOffset("1");


        $sorting = new net\authorize\api\contract\v1\CustomerPaymentProfileSortingType();
        $sorting->setOrderBy("id");
        $sorting->setOrderDescending("false");

        $request = new net\authorize\api\contract\v1\GetCustomerPaymentProfileListRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setRefId($refId);
        $request->setPaging($paging);
        $request->setSorting($sorting);
        $request->setSearchType("cardsExpiringInMonth");
        $request->setMonth("2020-12");

        $controller = new net\authorize\api\controller\GetCustomerPaymentProfileListController($request);
        $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);

        $this->assertNotNull($response, "null response");
        $this->assertNotNull($response->getMessages());

        $this->assertEquals("Ok", $response->getMessages()->getResultCode());
        $this->assertEquals($response->getRefId(), $refId);
        $this->assertTrue(0 < count($response->getMessages()));

        foreach ($response->getMessages() as $message)
        {
            $this->assertEquals("I00001", $message->getCode());
            $this->assertEquals("Successful.", $response->getText());
        }
    }

    public function testDecryptPaymentData()
    {
        //$this->markTestSkipped('Ignoring for Travis. Will fix after release.'); //TODO

        //using sandbox account log in to mint and enable visa checkout
        //You'll get a VCO api key.
        //on web page you can create and grab (from the JS console) Visa Checkout Payment Data
        //http://brianmc.github.io/checkout.html

        $name =           (defined('AUTHORIZENET_API_LOGIN_ID')    && ''!=AUTHORIZENET_API_LOGIN_ID)    ? AUTHORIZENET_API_LOGIN_ID    : getenv("api_login_id");
        $transactionKey = (defined('AUTHORIZENET_TRANSACTION_KEY') && ''!=AUTHORIZENET_TRANSACTION_KEY) ? AUTHORIZENET_TRANSACTION_KEY : getenv("transaction_key");

        $merchantAuthentication = new net\authorize\api\contract\v1\MerchantAuthenticationType();
        $merchantAuthentication->setName($name);
        $merchantAuthentication->setTransactionKey($transactionKey);

        $refId = 'ref' . time();
        $callId = "8880580142324354001";

        $opaqueData = new net\authorize\api\contract\v1\OpaqueDataType();
        $opaqueData->setDataDescriptor("COMMON.VCO.ONLINE.PAYMENT");
        $opaqueData->setDataKey("TD3LP3/b2IGMVDAxcAq8414q6L/6mKZ3RItyemrW4BAEIx3GQYOa52cduN1FIU7PQC/Ie4RHQZyp+amY4BTzPg485tn5lJTib++K1IuWbN+LaSCKQ/37g4b47mw02MFr");
        $opaqueData->setDataValue("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");
        //"partialShippingAddress":{"countryCode":"US","postalCode":"98103"},"callid":"8880580142324354001","vInitRequest":{"apikey":"GY3CQNLRHKE63GWCVLHH13Ff12umyj4ZglGhGdCM6y6Liy0YE","paymentRequest":{"currencyCode":"USD","total":"16.00"},"parentUrl":"http://brianmc.github.io/checkout.html","browserLocale":"en_US","clientId":"848a93dc-8d84-48fe-9d88-e7d1e9e50abb","allowEnrollment":true,"settings":{}}}

        $request = new net\authorize\api\contract\v1\DecryptPaymentDataRequest();
        $request->setRefId( $refId);
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setOpaqueData($opaqueData);
        $request->setCallId($callId);

        $controller = new net\authorize\api\controller\DecryptPaymentDataController( $request);
        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);

        // Handle the response.
        $this->assertNotNull($response, "null response");
        $this->assertNotNull($response->getMessages());

        $this->assertEquals("Ok", $response->getMessages()->getResultCode());
        //$this->assertEquals($response->getRefId(), $refId);
        $this->assertTrue(0 < count($response->getMessages()));
        foreach ($response->getMessages() as $message)
        {
            $this->assertEquals("I00001", $message->getCode());
            $this->assertEquals("Successful.", $response->getText());
        }
    }
}
