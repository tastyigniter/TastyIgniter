<?php

declare(strict_types=1);

namespace Igniter\PayRegister\Payments;

use Exception;
use Igniter\Cart\Models\Order;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Main\Classes\MainController;
use Igniter\PayRegister\Classes\AuthorizeNetClient;
use Igniter\PayRegister\Classes\BasePaymentGateway;
use Igniter\PayRegister\Concerns\WithAuthorizedPayment;
use Igniter\PayRegister\Concerns\WithPaymentRefund;
use Igniter\PayRegister\Models\Payment;
use Igniter\PayRegister\Models\PaymentLog;
use net\authorize\api\contract\v1\TransactionResponseType;
use Override;

class AuthorizeNetAim extends BasePaymentGateway
{
    use WithAuthorizedPayment;
    use WithPaymentRefund;

    public static ?string $paymentFormView = 'igniter.payregister::_partials.authorizenetaim.payment_form';

    #[Override]
    public function defineFieldsConfig(): string
    {
        return 'igniter.payregister::/models/authorizenetaim';
    }

    public function getHiddenFields(): array
    {
        return [
            'authorizenetaim_DataValue' => '',
            'authorizenetaim_DataDescriptor' => '',
        ];
    }

    public function getClientKey()
    {
        return $this->model->client_key;
    }

    public function getTransactionKey()
    {
        return $this->model->transaction_key;
    }

    public function getApiLoginID()
    {
        return $this->model->api_login_id;
    }

    public function isTestMode(): bool
    {
        return $this->model->transaction_mode != 'live';
    }

    #[Override]
    public function shouldAuthorizePayment(): bool
    {
        return $this->model->transaction_type === 'auth_only';
    }

    public function getEndPoint(): string
    {
        return $this->isTestMode() ? 'https://jstest.authorize.net' : 'https://js.authorize.net';
    }

    public function getAcceptedCards(): array
    {
        return [
            'visa' => 'lang:igniter.payregister::default.authorize_net_aim.text_visa',
            'mastercard' => 'lang:igniter.payregister::default.authorize_net_aim.text_mastercard',
            'american_express' => 'lang:igniter.payregister::default.authorize_net_aim.text_american_express',
            'jcb' => 'lang:igniter.payregister::default.authorize_net_aim.text_jcb',
            'diners_club' => 'lang:igniter.payregister::default.authorize_net_aim.text_diners_club',
        ];
    }

    /**
     * @param self $host
     * @param MainController $controller
     */
    #[Override]
    public function beforeRenderPaymentForm($host, $controller): void
    {
        $controller->addJs('igniter.payregister::/js/authorizenetaim.js', 'authorizenetaim-js');
    }

    /**
     * @param array $data
     * @param Payment $host
     * @param Order $order
     */
    #[Override]
    public function processPaymentForm($data, $host, $order): void
    {
        $this->validateApplicableFee($order, $host);

        $fields = $this->getPaymentFormFields($order, $data);
        $fields['opaqueDataDescriptor'] = array_get($data, 'authorizenetaim_DataDescriptor');
        $fields['opaqueDataValue'] = array_get($data, 'authorizenetaim_DataValue');

        try {
            $response = $this->createAcceptPayment($fields, $order);
            $responseData = $this->convertResponseToArray($response);

            if ($response->getResponseCode() === '1') {
                if ($this->shouldAuthorizePayment()) {
                    $order->logPaymentAttempt('Payment authorized', 1, $fields, $responseData);
                } else {
                    $order->logPaymentAttempt('Payment successful', 1, $fields, $responseData, true);
                }

                $order->updateOrderStatus($host->order_status, ['notify' => false]);
                $order->markAsPaymentProcessed();
            } else {
                $order->logPaymentAttempt('Payment unsuccessful -> '.$responseData['description'], 0, $fields, $responseData);
            }
        } catch (Exception $ex) {
            $order->logPaymentAttempt('Payment error -> '.$ex->getMessage(), 0, $fields);

            throw new ApplicationException('Sorry, there was an error processing your payment. Please try again later.', $ex->getCode(), $ex);
        }
    }

    #[Override]
    public function processRefundForm($data, $order, $paymentLog): void
    {
        throw_if(
            !is_null($paymentLog->refunded_at) || !is_array($paymentLog->response),
            new ApplicationException('Nothing to refund'),
        );

        throw_if(
            array_get($paymentLog->response, 'status') !== '1',
            new ApplicationException('No successful transaction to refund'),
        );

        $paymentId = array_get($paymentLog->response, 'id');
        $fields = $this->getPaymentRefundFields($order, $data);
        $fields['transactionId'] = $paymentId;
        $fields['card'] = array_get($paymentLog->response, 'card_holder');

        try {
            $response = $this->createRefundPayment($fields, $order);
            $responseData = $this->convertResponseToArray($response);

            $order->logPaymentAttempt(sprintf('Payment %s refund processed -> (%s: %s)',
                $paymentId, array_get($data, 'refund_type'), $responseData['id'],
            ), 1, $fields, $responseData);

            $paymentLog->markAsRefundProcessed();
        } catch (Exception $ex) {
            $order->logPaymentAttempt('Refund failed -> '.$ex->getMessage(), 0, $fields, []);

            throw new ApplicationException('Refund failed, please try again later or contact system administrator', $ex->getCode(), $ex);
        }
    }

    #[Override]
    public function captureAuthorizedPayment(Order $order)
    {
        throw_unless(
            $paymentLog = $order->payment_logs()->firstWhere('is_success', true),
            new ApplicationException('No successful transaction to capture'),
        );

        /** @var PaymentLog $paymentLog */
        throw_unless(
            $paymentId = array_get($paymentLog->response, 'id'),
            new ApplicationException('Missing payment ID in successful transaction response'),
        );

        $client = $this->createClient();

        $request = $client->createTransactionRequest([
            'transactionId' => $paymentId,
            'refId' => $order->hash,
            'transactionType' => 'priorAuthCaptureTransaction',
        ]);

        $this->fireSystemEvent('payregister.authorizenetaim.extendCaptureRequest', [$request], false);

        $response = $client->createTransaction($request);
        $responseData = $this->convertResponseToArray($response);

        if ($response->getResponseCode() == '1') {
            $order->logPaymentAttempt('Payment successful', 1, [], $responseData, true);
        } else {
            $order->logPaymentAttempt('Payment failed', 0, [], $responseData);
        }

        return $response;
    }

    #[Override]
    public function cancelAuthorizedPayment(Order $order)
    {
        throw_unless(
            $paymentLog = $order->payment_logs()->firstWhere('is_success', true),
            new ApplicationException('No successful transaction to capture'),
        );

        /** @var PaymentLog $paymentLog */
        throw_unless(
            $paymentId = array_get($paymentLog->response, 'id'),
            new ApplicationException('Missing payment ID in successful transaction response'),
        );

        $client = $this->createClient();
        $request = $client->createTransactionRequest([
            'transactionId' => $paymentId,
            'refId' => $order->hash,
            'transactionType' => 'voidTransaction',
        ]);

        $this->fireSystemEvent('payregister.authorizenetaim.extendCancelRequest', [$request], false);

        $response = $client->createTransaction($request);
        $responseData = $this->convertResponseToArray($response);

        if ($response->getResponseCode() == '1') {
            $order->logPaymentAttempt('Payment canceled successfully', 1, [], $responseData, true);
        } else {
            $order->logPaymentAttempt('Canceling payment failed', 0, [], $responseData);
        }

        return $response;
    }

    //
    //
    //

    protected function createClient()
    {
        $client = resolve(AuthorizeNetClient::class);
        $client->setTestMode($this->isTestMode());

        $merchantAuthentication = $client->authentication();
        $merchantAuthentication->setName($this->getApiLoginID());
        $merchantAuthentication->setTransactionKey($this->getTransactionKey());

        $this->fireSystemEvent('payregister.authorizenetaim.extendGateway', [$client]);

        return $client;
    }

    protected function getPaymentFormFields($order, $data = []): array
    {
        return [
            'refId' => $order->order_id,
            'amount' => number_format($order->order_total, 2, '.', ''),
            'currency' => currency()->getUserCurrency(),
        ];
    }

    protected function getPaymentRefundFields($order, $data): array
    {
        $refundAmount = array_get($data, 'refund_type') == 'full'
            ? $order->order_total : array_get($data, 'refund_amount');

        throw_if($refundAmount > $order->order_total, new ApplicationException(
            'Refund amount should be be less than or equal to the order total',
        ));

        return [
            'refId' => $order->getKey(),
            'amount' => number_format($refundAmount, 2, '.', ''),
        ];
    }

    protected function createAcceptPayment(mixed $fields, Order $order)
    {
        $client = $this->createClient();

        $fields['transactionType'] = $this->shouldAuthorizePayment() ? 'authOnlyTransaction' : 'authCaptureTransaction';
        $request = $client->createTransactionRequest($fields);

        $this->fireSystemEvent('payregister.authorizenetaim.extendAcceptRequest', [$request], false);

        return $client->createTransaction($request);
    }

    protected function createRefundPayment(mixed $fields, Order $order)
    {
        $client = $this->createClient();

        $request = $client->createTransactionRequest([
            'refId' => $fields['refId'],
            'cardNumber' => $fields['card'],
            'expirationDate' => 'XXXX',
            'transactionType' => 'refundTransaction',
            'amount' => $fields['amount'],
            'transactionId' => $fields['transactionId'],
        ]);

        $this->fireSystemEvent('payregister.authorizenetaim.extendRefundRequest', [$request], false);

        return $client->createTransaction($request);
    }

    protected function convertResponseToArray(TransactionResponseType $response): array
    {
        return [
            'id' => $response->getTransId(),
            'status' => $response->getResponseCode(),
            'code' => $response->getMessages()[0]->getCode(),
            'description' => $response->getMessages()[0]->getDescription(),
            'card_holder' => $response->getAccountNumber(),
            'card_type' => $response->getAccountType(),
            'auth_code' => $response->getAuthCode(),
        ];
    }
}
