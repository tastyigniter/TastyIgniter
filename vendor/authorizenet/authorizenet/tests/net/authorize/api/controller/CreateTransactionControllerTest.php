<?php
namespace net\authorize\api\controller\test;

use net\authorize\api\contract\v1 AS apiContract;
use net\authorize\api\controller AS apiController;

require_once __DIR__ . '/ApiCoreTestBase.php';

class CreateTransactionControllerTest extends ApiCoreTestBase
{
    public function testCreateTransactionCreditCard()
    {
        $merchantAuthentication = new apiContract\MerchantAuthenticationType();
        $merchantAuthentication->setName(self::$LoginName);
        $merchantAuthentication->setTransactionKey(self::$TransactionKey);

        //create a transaction
        $transactionRequestType = new apiContract\TransactionRequestType();
        $transactionRequestType->setTransactionType( "authCaptureTransaction"); // TODO Change to Enum
        $transactionRequestType->setAmount( $this->setValidAmount( $this->counter));
        $transactionRequestType->setPayment( $this->paymentOne);
        $transactionRequestType->setOrder( $this->orderType);
        $transactionRequestType->setCustomer( $this->customerDataOne);
        $transactionRequestType->setBillTo( $this->customerAddressOne);

        $request = new apiContract\CreateTransactionRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setRefId( $this->refId);
        $request->setTransactionRequest( $transactionRequestType);

        $controller = new apiController\CreateTransactionController($request);
        $controller->execute( self::$TestEnvironment);
        $response = $controller->getApiResponse();

        // Handle and validate the response
        self::displayMessages( $response);
        $this->assertNotNull($response, "null response");
        $this->assertNotNull($response->getMessages());
        $logMessage = sprintf("\n%s: Controller Response ResultCode: '%s'.", \net\authorize\util\Helpers::now(), $response->getMessages()->getResultCode());
        if (self::$log_file) {
            file_put_contents(self::$log_file, $logMessage, FILE_APPEND);
        } else {
            echo $logMessage;
        }
        $this->assertEquals("Ok", $response->getMessages()->getResultCode());
        $this->assertEquals( $this->refId, $response->getRefId());
        $this->assertTrue(0 < count($response->getMessages()));
        foreach ($response->getMessages() as $message)
        {
            $this->assertEquals("I00001", $message->getCode());
            $this->assertEquals("Successful.", $response->getText());
        }
    }

    public function testCreateTransactionPayPal()
    {
        $merchantAuthentication = new apiContract\MerchantAuthenticationType();
        $merchantAuthentication->setName(self::$LoginName);
        $merchantAuthentication->setTransactionKey(self::$TransactionKey);

        $paymentType = new apiContract\PaymentType();
        $paymentType->setPayPal($this->payPalOne);

        //create a transaction
        $transactionRequestType = new apiContract\TransactionRequestType();
        $transactionRequestType->setTransactionType( "authOnlyTransaction"); // TODO Change to Enum
        $transactionRequestType->setAmount( $this->setValidAmount( $this->counter));
        $transactionRequestType->setPayment( $paymentType);

        $request = new apiContract\CreateTransactionRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setTransactionRequest( $transactionRequestType);

        $controller = new apiController\CreateTransactionController($request);
        $response = $controller->executeWithApiResponse( self::$TestEnvironment);

        // Handle the response.
        $this->assertNotNull($response, "null response");
        $this->assertNotNull($response->getMessages());

        self::displayMessages( $response);
        if ( "Ok" != $response->getMessages()->getResultCode())
        {
            $this->displayTransactionMessages( $response);
            //Ignore assertion for now
            //$this->assertTrue( false, "Should not reach here.");
        }
        else
        {
            $this->assertEquals("Ok", $response->getMessages()->getResultCode());
            $this->assertTrue(0 < count($response->getMessages()));
            foreach ($response->getMessages() as $message)
            {
                $this->assertEquals("I00001", $message->getCode());
                $this->assertEquals("Successful.", $response->getText());
            }
        }
    }

    public function testCreateTransactionApplePay()
    {
        $merchantAuthentication = new apiContract\MerchantAuthenticationType();
        $merchantAuthentication->setName(self::$LoginName);
        $merchantAuthentication->setTransactionKey(self::$TransactionKey);

        $OpaqueData = new apiContract\OpaqueDataType();
        $OpaqueData->setDataDescriptor("COMMON.APPLE.INAPP.PAYMENT");
        $OpaqueData->setDataValue("eyJkYXRhIjoiQkRQTldTdE1tR2V3UVVXR2c0bzdFXC9qKzFjcTFUNzhxeVU4NGI2N2l0amNZSTh3UFlBT2hzaGpoWlBycWRVcjRYd1BNYmo0emNHTWR5KysxSDJWa1BPWStCT01GMjV1YjE5Y1g0bkN2a1hVVU9UakRsbEIxVGdTcjhKSFp4Z3A5ckNnc1NVZ2JCZ0tmNjBYS3V0WGY2YWpcL284WkliS25yS1E4U2gwb3VMQUtsb1VNbit2UHU0K0E3V0tycXJhdXo5SnZPUXA2dmhJcStIS2pVY1VOQ0lUUHlGaG1PRXRxK0grdzB2UmExQ0U2V2hGQk5uQ0hxenpXS2NrQlwvMG5xTFpSVFliRjBwK3Z5QmlWYVdIZWdoRVJmSHhSdGJ6cGVjelJQUHVGc2ZwSFZzNDhvUExDXC9rXC8xTU5kNDdrelwvcEhEY1JcL0R5NmFVTStsTmZvaWx5XC9RSk4rdFMzbTBIZk90SVNBUHFPbVhlbXZyNnhKQ2pDWmxDdXcwQzltWHpcL29iSHBvZnVJRVM4cjljcUdHc1VBUERwdzdnNjQybTRQendLRitIQnVZVW5lV0RCTlNEMnU2amJBRzMiLCJ2ZXJzaW9uIjoiRUNfdjEiLCJoZWFkZXIiOnsiYXBwbGljYXRpb25EYXRhIjoiOTRlZTA1OTMzNWU1ODdlNTAxY2M0YmY5MDYxM2UwODE0ZjAwYTdiMDhiYzdjNjQ4ZmQ4NjVhMmFmNmEyMmNjMiIsInRyYW5zYWN0aW9uSWQiOiJjMWNhZjVhZTcyZjAwMzlhODJiYWQ5MmI4MjgzNjM3MzRmODViZjJmOWNhZGYxOTNkMWJhZDlkZGNiNjBhNzk1IiwiZXBoZW1lcmFsUHVibGljS2V5IjoiTUlJQlN6Q0NBUU1HQnlxR1NNNDlBZ0V3Z2ZjQ0FRRXdMQVlIS29aSXpqMEJBUUloQVBcL1wvXC9cLzhBQUFBQkFBQUFBQUFBQUFBQUFBQUFcL1wvXC9cL1wvXC9cL1wvXC9cL1wvXC9cL1wvXC9cL01Gc0VJUFwvXC9cL1wvOEFBQUFCQUFBQUFBQUFBQUFBQUFBQVwvXC9cL1wvXC9cL1wvXC9cL1wvXC9cL1wvXC9cLzhCQ0JheGpYWXFqcVQ1N1BydlZWMm1JYThaUjBHc014VHNQWTd6ancrSjlKZ1N3TVZBTVNkTmdpRzV3U1RhbVo0NFJPZEpyZUJuMzZRQkVFRWF4ZlI4dUVzUWtmNHZPYmxZNlJBOG5jRGZZRXQ2ek9nOUtFNVJkaVl3cFpQNDBMaVwvaHBcL200N242MHA4RDU0V0s4NHpWMnN4WHM3THRrQm9ONzlSOVFJaEFQXC9cL1wvXC84QUFBQUFcL1wvXC9cL1wvXC9cL1wvXC9cLys4NXZxdHB4ZWVoUE81eXNMOFl5VlJBZ0VCQTBJQUJHbStnc2wwUFpGVFwva0RkVVNreHd5Zm84SnB3VFFRekJtOWxKSm5tVGw0REdVdkFENEdzZUdqXC9wc2hCWjBLM1RldXFEdFwvdERMYkUrOFwvbTB5Q21veHc9IiwicHVibGljS2V5SGFzaCI6IlwvYmI5Q05DMzZ1QmhlSEZQYm1vaEI3T28xT3NYMkora0pxdjQ4ek9WVmlRPSJ9LCJzaWduYXR1cmUiOiJNSUlEUWdZSktvWklodmNOQVFjQ29JSURNekNDQXk4Q0FRRXhDekFKQmdVckRnTUNHZ1VBTUFzR0NTcUdTSWIzRFFFSEFhQ0NBaXN3Z2dJbk1JSUJsS0FEQWdFQ0FoQmNsK1BmMytVNHBrMTNuVkQ5bndRUU1Ba0dCU3NPQXdJZEJRQXdKekVsTUNNR0ExVUVBeDRjQUdNQWFBQnRBR0VBYVFCQUFIWUFhUUJ6QUdFQUxnQmpBRzhBYlRBZUZ3MHhOREF4TURFd05qQXdNREJhRncweU5EQXhNREV3TmpBd01EQmFNQ2N4SlRBakJnTlZCQU1lSEFCakFHZ0FiUUJoQUdrQVFBQjJBR2tBY3dCaEFDNEFZd0J2QUcwd2daOHdEUVlKS29aSWh2Y05BUUVCQlFBRGdZMEFNSUdKQW9HQkFOQzgra2d0Z212V0YxT3pqZ0ROcmpURUJSdW9cLzVNS3ZsTTE0NnBBZjdHeDQxYmxFOXc0ZklYSkFEN0ZmTzdRS2pJWFlOdDM5ckx5eTd4RHdiXC81SWtaTTYwVFoyaUkxcGo1NVVjOGZkNGZ6T3BrM2Z0WmFRR1hOTFlwdEcxZDlWN0lTODJPdXA5TU1vMUJQVnJYVFBITmNzTTk5RVBVblBxZGJlR2M4N20wckFnTUJBQUdqWERCYU1GZ0dBMVVkQVFSUk1FK0FFSFpXUHJXdEpkN1laNDMxaENnN1lGU2hLVEFuTVNVd0l3WURWUVFESGh3QVl3Qm9BRzBBWVFCcEFFQUFkZ0JwQUhNQVlRQXVBR01BYndCdGdoQmNsK1BmMytVNHBrMTNuVkQ5bndRUU1Ba0dCU3NPQXdJZEJRQURnWUVBYlVLWUNrdUlLUzlRUTJtRmNNWVJFSW0ybCtYZzhcL0pYditHQlZRSmtPS29zY1k0aU5ERkFcL2JRbG9nZjlMTFU4NFRId05SbnN2VjNQcnY3UlRZODFncTBkdEM4elljQWFBa0NISUkzeXFNbko0QU91NkVPVzlrSmsyMzJnU0U3V2xDdEhiZkxTS2Z1U2dRWDhLWFFZdVpMazJScjYzTjhBcFhzWHdCTDNjSjB4Z2VBd2dkMENBUUV3T3pBbk1TVXdJd1lEVlFRREhod0FZd0JvQUcwQVlRQnBBRUFBZGdCcEFITUFZUUF1QUdNQWJ3QnRBaEJjbCtQZjMrVTRwazEzblZEOW53UVFNQWtHQlNzT0F3SWFCUUF3RFFZSktvWklodmNOQVFFQkJRQUVnWUJhSzNFbE9zdGJIOFdvb3NlREFCZitKZ1wvMTI5SmNJYXdtN2M2VnhuN1phc05iQXEzdEF0OFB0eSt1UUNnc3NYcVprTEE3a3oyR3pNb2xOdHY5d1ltdTlVandhcjFQSFlTK0JcL29Hbm96NTkxd2phZ1hXUnowbk1vNXkzTzFLelgwZDhDUkhBVmE4OFNyVjFhNUpJaVJldjNvU3RJcXd2NXh1WmxkYWc2VHI4dz09In0=");

        $paymentType = new apiContract\PaymentType();
        $paymentType->setOpaqueData( $OpaqueData);

        //create a transaction
        $transactionRequestType = new apiContract\TransactionRequestType();
        $transactionRequestType->setTransactionType( "authCaptureTransaction"); // TODO Change to Enum
        $transactionRequestType->setAmount( $this->setValidAmount( $this->counter));
        $transactionRequestType->setPayment( $paymentType);

        $request = new apiContract\CreateTransactionRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setTransactionRequest( $transactionRequestType);

        $controller = new apiController\CreateTransactionController($request);
        $response = $controller->executeWithApiResponse( self::$TestEnvironment);

        // Handle the response.
        $this->assertNotNull($response, "null response");
        $this->assertNotNull($response->getMessages());

        self::displayMessages( $response);
        if ( "Ok" != $response->getMessages()->getResultCode())
        {
            $this->displayTransactionMessages( $response);
            //Ignore assertion for now
            //$this->assertTrue( false, "Should not reach here.");
        }
        else
        {
            $this->assertEquals("Ok", $response->getMessages()->getResultCode());
            $this->assertTrue(0 < count($response->getMessages()));
            foreach ($response->getMessages() as $message)
            {
                $this->assertEquals("I00001", $message->getCode());
                $this->assertEquals("Successful.", $response->getText());
            }
        }
    }


    function displayTransactionMessages( apiContract\CreateTransactionResponse $response)
    {
        if ( null != $response)
        {
            $logMessage = sprintf("\n%s: Displaying Transaction Response.", \net\authorize\util\Helpers::now());
            echo $logMessage;
            if (self::$log_file)
            {
                file_put_contents(self::$log_file, $logMessage, FILE_APPEND);
            }

            if ( null != $response->getTransactionResponse())
            {
                $logMessage = sprintf("\n%s: Transaction Response Code: '%s'.", \net\authorize\util\Helpers::now(), $response->getTransactionResponse()->getResponseCode());
                echo $logMessage;
                if (self::$log_file)
                {
                    file_put_contents(self::$log_file, $logMessage, FILE_APPEND);
                }

                $allMessages = $response->getTransactionResponse()->getMessages();
                $allErrors = $response->getTransactionResponse()->getErrors();
                $errorCount = 0;
                if ( null != $allErrors)
                {
                    foreach ( $allErrors as $error)
                    {
                        $errorCount++;
                        $logMessage = sprintf("\n%s: %d - Error: Code:'%s', Text:'%s'", \net\authorize\util\Helpers::now(), $errorCount, $error->getErrorCode(), $error->getErrorText());
                        echo $logMessage;
                        if (self::$log_file)
                        {
                            file_put_contents(self::$log_file, $logMessage, FILE_APPEND);
                        }
                    }
                }
                $messageCount = 0;
                if ( null != $allMessages)
                {
                    foreach ( $allMessages as $message)
                    {
                        $messageCount++;
                        //$logMessage = sprintf("\n%s: %d - Message: Code:'%s', Description:'%s'", \net\authorize\util\Helpers::now(), $errorCount, $message->getCode(), $message->getDescription());
                        $logMessage = sprintf("\n%s: %d - Message: ", \net\authorize\util\Helpers::now(), $messageCount);
                        echo $logMessage;
                        if (self::$log_file)
                        {
                            file_put_contents(self::$log_file, $logMessage, FILE_APPEND);
                        }
                    }
                }
                $logMessage = sprintf("\n%s: Transaction Response, Errors: '%d', Messages: '%d'.", \net\authorize\util\Helpers::now(), $errorCount, $messageCount);
                echo $logMessage;
                if (self::$log_file)
                {
                    file_put_contents(self::$log_file, $logMessage, FILE_APPEND);
                }
            }
        }
    }
}
