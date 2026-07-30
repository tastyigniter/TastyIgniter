<?php

namespace Square\Tests;

use Core\Types\CallbackCatcher;

use Square\ApiHelper;
use Square\Apis\PaymentsApi;
use Square\Apis\RefundsApi;
use Square\Exceptions;
use Square\Exceptions\ApiException;
use Square\Models\CancelPaymentByIdempotencyKeyRequest;
use Square\Models\CompletePaymentResponse;
use Square\Models\Currency;
use Square\Models\CreatePaymentRequest;
use Square\Models\GetPaymentRefundResponse;
use Square\Models\ListPaymentsResponse;
use Square\Models\ListPaymentRefundsResponse;
use Square\Models\Money;
use Square\Models\RefundPaymentRequest;
use Square\Models\RefundPaymentResponse;

use PHPUnit\Framework\TestCase;

class RefundsTest extends TestCase
{
    /**
     * @var \Square\Apis\RefundsApi Controller instance
     */
    protected static $controller;

    /**
     * @var \Square\Apis\PaymentsApi Controller instance
     */
    protected static $paymentsController;

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
        $client = ClientFactory::create(self::$httpResponse);
        self::$controller = $client->getRefundsApi();
        self::$paymentsController = $client->getPaymentsApi();
    }


    public function testListRefunds()
    {
        // Set callback and perform API call
        $result = null;
        try {
            $result = self::$controller->listPaymentRefunds()->getResult();
        } catch (ApiException $e) {
        }

        // Test response code
        $this->assertEquals(
            200,
            self::$httpResponse->getResponse()->getStatusCode(),
            "Status is not 200"
        );

        $this->assertTrue($result instanceof ListPaymentRefundsResponse);
    }

    public function testRefundPayment()
    {
        // Creat Payment to be refunded
        $amount = 200;
        $currency = Currency::USD;
        $body_sourceId = 'cnon:card-nonce-ok';
        $body_idempotencyKey = uniqid();
        $body_amountMoney = new Money;
        $body_amountMoney->setAmount($amount);
        $body_amountMoney->setCurrency($currency);
        $body = new CreatePaymentRequest(
            $body_sourceId,
            $body_idempotencyKey,
        );

        $body->setAmountMoney($body_amountMoney);
        $body->setAppFeeMoney(new Money);
        $body->getAppFeeMoney()->setAmount(10);
        $body->getAppFeeMoney()->setCurrency(Currency::USD);
        $body->setAutocomplete(true);

        $result = self::$paymentsController->createPayment($body);
        if (!$result->isSuccess()) {
            $errors = serialize($result->getErrors());
            echo "\n Error(s): {$errors}";
        }

        $this->assertTrue($result->isSuccess());

        // Square may need a moment to capture payment before we can issue a Refund
        sleep(1);

        // Create Refund
        $payment_id = $result->getResult()->getPayment()->getId();
        $refundBody_idempotencyKey = uniqid();
        $refundBody_amountMoney = new Money;
        $refundBody_amountMoney->setAmount($amount);
        $refundBody_amountMoney->setCurrency($currency);
        $refundBody_paymentId = $payment_id;
        $refundBody = new RefundPaymentRequest(
            $refundBody_idempotencyKey,
            $refundBody_amountMoney
        );
        $refundBody->setPaymentId($refundBody_paymentId);

        $apiResponse = self::$controller->refundPayment($refundBody);
        if (!$apiResponse->isSuccess()) {
            $errors = serialize($apiResponse->getErrors());
            echo "\n Error(s): {$errors}";
        }

        $this->assertTrue($apiResponse->isSuccess());
        $this->assertTrue($apiResponse->getResult() instanceof RefundPaymentResponse);
        $this->assertEquals($apiResponse->getResult()->getRefund()->getAmountMoney()->getAmount(), $amount);
        $this->assertEquals($apiResponse->getResult()->getRefund()->getAmountMoney()->getCurrency(), $currency);
        $this->assertEquals($apiResponse->getResult()->getRefund()->getPaymentId(), $payment_id);

        return $apiResponse->getResult()->getRefund()->getId();
    }

    /**
     * @depends testRefundPayment
     */
    public function testGetPaymentRefund($paymentId)
    {
        $result = self::$controller->getPaymentRefund($paymentId);

        $this->assertTrue($result->isSuccess());
        $this->assertTrue($result->getResult() instanceof GetPaymentRefundResponse);
    }
}
