<?php
namespace net\authorize\api\controller\test;

use net\authorize\api\contract\v1 AS apiContract;
use net\authorize\api\controller AS apiController;

require_once __DIR__ . '/../../../../../autoload.php';
//include if tests/bootstrap.php is not loaded automatically
//require_once __DIR__ . '/../../../../bootstrap.php';

class ApiCoreTestBase extends \PHPUnit_Framework_TestCase
{
    protected $paymentOne = null;
    protected $orderType = null;
    protected $customerDataOne = null;
    protected $customerAddressOne = null;
    protected $payPalOne = null;

    protected $counter = 0;
    protected $counterStr = "0";
    protected $refId = '';

    protected static $LoginName = '';
    protected static $TransactionKey = '';

    protected static $TestEnvironment = \net\authorize\api\constants\ANetEnvironment::SANDBOX;
    protected static $log_file = false;

    public static function setUpBeforeClass()
    {
        if (!defined('AUTHORIZENET_LOG_FILE'))
        {
            define( "AUTHORIZENET_LOG_FILE",  __DIR__ . "/../../../../../log/authorize-net.log");
        }
        self::$LoginName      = (defined('AUTHORIZENET_API_LOGIN_ID')    && ''!=AUTHORIZENET_API_LOGIN_ID)    ? AUTHORIZENET_API_LOGIN_ID    : getenv("api_login_id");
        self::$TransactionKey = (defined('AUTHORIZENET_TRANSACTION_KEY') && ''!=AUTHORIZENET_TRANSACTION_KEY) ? AUTHORIZENET_TRANSACTION_KEY : getenv("transaction_key");
        self::$log_file = (defined('AUTHORIZENET_LOG_FILE') ? AUTHORIZENET_LOG_FILE : false);
    }

    public static function tearDownAfterClass()
    {
    }

    public function __construct()
    {
    }

    protected function setUp()
    {
        $logMessage = sprintf("\n%s: Test '%s' Starting.", \net\authorize\util\Helpers::now(), $this->getName());
        echo $logMessage;
        if (self::$log_file)
        {
            file_put_contents(self::$log_file, $logMessage, FILE_APPEND);
        }

        $this->refId = 'ref' . time();

        $this->counter = rand();
        $this->counterStr = sprintf("%s", $this->counter);

        $driversLicenseOne = new apiContract\DriversLicenseType();
        $driversLicenseOne->setNumber( $this->getRandomString( "DL-" ));
        $driversLicenseOne->setState( "WA");
        $driversLicenseOne->setDateOfBirth( "01/01/1960");

        $customerOne = new apiContract\CustomerType();
        $customerOne->setType("individual"); //TODO: CHANGE TO ENUM
        $customerOne->setId( $this->getRandomString( "Id" ));
        $customerOne->setEmail ( $this->counterStr . ".customerOne@test.anet.net");
        $customerOne->setPhoneNumber("1234567890");
        $customerOne->setFaxNumber("1234567891");
        //$customerOne->setDriversLicense( $driversLicenseOne);
        $customerOne->setTaxId( "911011011");

        $creditCardOne = new apiContract\CreditCardType();
        $creditCardOne->setCardNumber( "4111111111111111" );
        $creditCardOne->setExpirationDate( "2038-12");

        $this->paymentOne = new apiContract\PaymentType();
        $this->paymentOne->setCreditCard( $creditCardOne);

        $this->orderType = new apiContract\OrderType();
        $this->orderType->setInvoiceNumber( $this->getRandomString( "Inv:" ));
        $this->orderType->setDescription( $this->getRandomString( "Description" ));

        $this->customerDataOne = new apiContract\CustomerDataType();
        //$this->customerDataOne->setDriversLicense( $customerOne->getDriversLicense());
        $this->customerDataOne->setEmail( $customerOne->getEmail());
        $this->customerDataOne->setId( $customerOne->getId());
        $this->customerDataOne->setTaxId( $customerOne->getTaxId());
        $this->customerDataOne->setType( $customerOne->getType());

        $this->customerAddressOne = new apiContract\CustomerAddressType();
        $this->customerAddressOne->setFirstName( $this->getRandomString( "FName" ));
        $this->customerAddressOne->setLastName( $this->getRandomString( "LName" ));
        $this->customerAddressOne->setCompany( $this->getRandomString( "Company" ));
        $this->customerAddressOne->setAddress( $this->getRandomString( "StreetAdd" ));
        $this->customerAddressOne->setCity( "Bellevue");
        $this->customerAddressOne->setState( "WA");
        $this->customerAddressOne->setZip( "98004");
        $this->customerAddressOne->setCountry( "USA");
        $this->customerAddressOne->setPhoneNumber( $customerOne->getPhoneNumber());
        $this->customerAddressOne->setFaxNumber( $customerOne->getFaxNumber());

        $this->payPalOne = new apiContract\PayPalType();
        $this->payPalOne->setPaypalLc( "IT" );
        $this->payPalOne->setPaypalPayflowcolor( "FFFFF0");
        $this->payPalOne->setSuccessUrl( $this->getRandomString( "http://success.anet.net"));
        $this->payPalOne->setCancelUrl( $this->getRandomString( "http://cancel.anet.net"));
        //payPalHdrImg = GetRandomString("Hdr"),
        //payerID = GetRandomString("PayerId"),
    }

    protected function tearDown()
    {
        $logMessage = sprintf("\n%s: Test '%s' Completed.\n", \net\authorize\util\Helpers::now(), $this->getName());
        echo $logMessage;
        if (self::$log_file)
        {
            file_put_contents(self::$log_file, $logMessage, FILE_APPEND);
        }
    }

    protected function getRandomString( $title)
    {
        return sprintf( "%s%s", $title, $this->counterStr);
    }

    protected function setValidAmount( $number)
    {
        $amount = $number;
        if ( self::MaxTransactionAmount < $amount)
        {
            $amount = rand(1, self::MaxTransactionAmount); //generate between 1 and MaxTransactionAmount, inclusive
        }
        return $amount;
    }

    /**
     * @param apiContract\ANetApiResponseType $response
     */
    protected static function displayMessages( apiContract\ANetApiResponseType $response)
    {
        if ( null != $response)
        {
            $logMessage = sprintf("\n%s: Controller Response is not null, iterating messages.", \net\authorize\util\Helpers::now());
            echo $logMessage;
            if (self::$log_file)
            {
                file_put_contents(self::$log_file, $logMessage, FILE_APPEND);
            }
            $msgCount = 0;
            $allMessages = $response->getMessages();
            if ( null != $allMessages )
            {
                $logMessage = sprintf("\n%s: Controller ResultCode: '%s'.", \net\authorize\util\Helpers::now(), $allMessages->getResultCode());
                echo $logMessage;
                if (self::$log_file)
                {
                    file_put_contents(self::$log_file, $logMessage, FILE_APPEND);
                }
                if (null != $allMessages->getMessage())
                {
                    foreach ($allMessages->getMessage() as $message)
                    {
                        $msgCount++;
                        $logMessage = sprintf("\n%d - Message, Code: '%s', Text: '%s'", $msgCount, $message->getCode(), $message->getText());
                        echo $logMessage;
                        if (self::$log_file)
                        {
                            file_put_contents(self::$log_file, $logMessage, FILE_APPEND);
                        }
                    }
                }
            }
            $logMessage = sprintf("\n%s: Controller Response contains '%d' messages.", \net\authorize\util\Helpers::now(), $msgCount);
            echo $logMessage;
            if (self::$log_file)
            {
                file_put_contents(self::$log_file, $logMessage, FILE_APPEND);
            }
        }
        else
        {
            $logMessage = sprintf("\n%s: Response is null.", \net\authorize\util\Helpers::now());
            echo $logMessage;
            if (self::$log_file)
            {
                file_put_contents(self::$log_file, $logMessage, FILE_APPEND);
            }
        }
    }

    const MaxTransactionAmount = 10000; //214747;
}
