# Migrating from Legacy Authorize.Net Classes

Authorize.Net no longer supports several legacy classes, including AuthorizeNetAIM.php, AuthorizenetSIM.php, and others listed below, as part of PHP-SDK. If you are using any of these, we recommend that you update your code to use the new Authorize.Net API classes.

**For details on the deprecation and replacement of legacy Authorize.Net APIs, visit https://developer.authorize.net/api/upgrade_guide/.**

## Full list of classes that are no longer supported
| Class                | New Feature                                                                                                                                                    | Sample Codes directory/repository                                                 |
|----------------------|----------------------------------------------------------------------------------------------------------------------------------------------------------------|---------------------------------------------------------------------------------------------------------------------------|
| AuthorizeNetAIM.php  | [PaymentTransactions](https://developer.authorize.net/api/reference/index.html#payment-transactions)                                                           | [sample-code-php/PaymentTransactions](https://github.com/AuthorizeNet/sample-code-php/tree/master/PaymentTransactions)    |
| AuthorizeNetARB.php  | [RecurringBilling](https://developer.authorize.net/api/reference/index.html#recurring-billing)                                                                 | [sample-code-php/RecurringBilling](https://github.com/AuthorizeNet/sample-code-php/tree/master/RecurringBilling)          | 
| AuthorizeNetCIM.php  | [CustomerProfiles](https://developer.authorize.net/api/reference/index.html#customer-profiles)                                                                 | [sample-code-php/CustomerProfiles](https://github.com/AuthorizeNet/sample-code-php/tree/master/CustomerProfiles)          |
| Hosted CIM           | [Accept Customer](https://developer.authorize.net/content/developer/en_us/api/reference/features/customer_profiles.html#Using_the_Accept_Customer_Hosted_Form) | Not available                                                                                                                         |
| AuthorizeNetCP.php   | [PaymentTransactions](https://developer.authorize.net/api/reference/index.html#payment-transactions)                                                           | [sample-code-php/PaymentTransactions](https://github.com/AuthorizeNet/sample-code-php/tree/master/PaymentTransactions)    |
| AuthorizeNetDPM.php  | [Accept.JS](https://developer.authorize.net/api/reference/features/acceptjs.html)                                                                              | [Sample Accept Application](https://github.com/AuthorizeNet/accept-sample-app)                                            |
| AuthorizeNetSIM.php  | [Accept Hosted](https://developer.authorize.net/content/developer/en_us/api/reference/features/accept_hosted.html)                                             | Not available                                                                                                                         |
| AuthorizeNetSOAP.php | [PaymentTransactions](https://developer.authorize.net/api/reference/index.html#payment-transactions)                                                           | [sample-code-php/PaymentTransactions](https://github.com/AuthorizeNet/sample-code-php/tree/master/PaymentTransactions)    |
| AuthorizeNetTD.php   | [TransactionReporting](https://developer.authorize.net/api/reference/index.html#transaction-reporting)                                                         | [sample-code-php/TransactionReporting/](https://github.com/AuthorizeNet/sample-code-php/tree/master/TransactionReporting) |

## Example 
#### Old AuthorizeNetAIM example: 
   ```php
define("AUTHORIZENET_API_LOGIN_ID", "YOURLOGIN");
define("AUTHORIZENET_TRANSACTION_KEY", "YOURKEY");
define("AUTHORIZENET_SANDBOX", true);
$sale           = new AuthorizeNetAIM;
$sale->amount   = "5.99";
$sale->card_num = '6011000000000012';
$sale->exp_date = '04/15';
$response = $sale->authorizeAndCapture();
if ($response->approved) {
    $transaction_id = $response->transaction_id;
}
```
#### Corresponding new model code (charge-credit-card):
   ```php
require 'vendor/autoload.php';
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

define("AUTHORIZENET_LOG_FILE", "phplog");
$merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
$merchantAuthentication->setName("YOURLOGIN");
$merchantAuthentication->setTransactionKey("YOURKEY");
// Create the payment data for a credit card
$creditCard = new AnetAPI\CreditCardType();
$creditCard->setCardNumber("6011000000000012");
$creditCard->setExpirationDate("2015-04");
$creditCard->setCardCode("123");

// Add the payment data to a paymentType object
$paymentOne = new AnetAPI\PaymentType();
$paymentOne->setCreditCard($creditCard);

$transactionRequestType = new AnetAPI\TransactionRequestType();
$transactionRequestType->setTransactionType("authCaptureTransaction");
$transactionRequestType->setAmount("5.99");
$transactionRequestType->setPayment($paymentOne);

// Assemble the complete transaction request
$request = new AnetAPI\CreateTransactionRequest();
$request->setMerchantAuthentication($merchantAuthentication);
$request->setTransactionRequest($transactionRequestType);

// Create the controller and get the response
$controller = new AnetController\CreateTransactionController($request);
$response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);

if ($response != null) {
// Check to see if the API request was successfully received and acted upon
if ($response->getMessages()->getResultCode() == "Ok") {
      // Since the API request was successful, look for a transaction response
      // and parse it to display the results of authorizing the card
      $tresponse = $response->getTransactionResponse();
        
      if ($tresponse != null && $tresponse->getMessages() != null) {
      echo " Successfully created transaction with Transaction ID: " . $tresponse->getTransId() . "\n";
      echo " Transaction Response Code: " . $tresponse->getResponseCode() . "\n";
      echo " Message Code: " . $tresponse->getMessages()[0]->getCode() . "\n";
      echo " Auth Code: " . $tresponse->getAuthCode() . "\n";
      echo " Description: " . $tresponse->getMessages()[0]->getDescription() . "\n";
      }
     }
} 
```
