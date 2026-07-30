<?php

declare(strict_types=1);

namespace Igniter\PayRegister\Payments;

use Exception;
use Igniter\Cart\Models\Order;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Main\Classes\MainController;
use Igniter\PayRegister\Classes\BasePaymentGateway;
use Igniter\PayRegister\Concerns\WithPaymentProfile;
use Igniter\PayRegister\Concerns\WithPaymentRefund;
use Igniter\PayRegister\Models\Payment;
use Igniter\PayRegister\Models\PaymentProfile;
use Igniter\User\Models\Customer;
use Override;
use Square\Environment;
use Square\Http\ApiResponse;
use Square\Models\Card;
use Square\Models\CreateCardRequest;
use Square\Models\CreateCustomerRequest;
use Square\Models\CreatePaymentRequest;
use Square\Models\Money;
use Square\Models\RefundPaymentRequest;
use Square\SquareClient;
use Square\SquareClientBuilder;

class Square extends BasePaymentGateway
{
    use WithPaymentProfile;
    use WithPaymentRefund;

    public static ?string $paymentFormView = 'igniter.payregister::_partials.square.payment_form';

    #[Override]
    public function defineFieldsConfig(): string
    {
        return 'igniter.payregister::/models/square';
    }

    public function getHiddenFields(): array
    {
        return [
            'square_card_nonce' => '',
            'square_card_token' => '',
        ];
    }

    public function isTestMode(): bool
    {
        return $this->model->transaction_mode != 'live';
    }

    public function getAppId()
    {
        return $this->isTestMode() ? $this->model->test_app_id : $this->model->live_app_id;
    }

    public function getAccessToken()
    {
        return $this->isTestMode() ? $this->model->test_access_token : $this->model->live_access_token;
    }

    public function getLocationId()
    {
        return $this->isTestMode() ? $this->model->test_location_id : $this->model->live_location_id;
    }

    /**
     * @param self $host
     * @param MainController $controller
     */
    #[Override]
    public function beforeRenderPaymentForm($host, $controller): void
    {
        $endpoint = $this->isTestMode() ? 'sandbox.' : '';
        $controller->addJs('https://'.$endpoint.'web.squarecdn.com/v1/square.js', 'square-js');
        $controller->addJs('igniter.payregister::/js/process.square.js', 'process-square-js');
    }

    #[Override]
    public function completesPaymentOnClient(): bool
    {
        return true;
    }

    protected function createPayment(array $fields, $order, $host): ApiResponse
    {
        $client = $this->createClient();
        $paymentsApi = $client->getPaymentsApi();

        $idempotencyKey = str_random();

        $amountMoney = new Money;
        $amountMoney->setAmount((int)($fields['amount'] * 100));
        $amountMoney->setCurrency($fields['currency']);

        $body = new CreatePaymentRequest($fields['sourceId'], $idempotencyKey);
        $body->setAmountMoney($amountMoney);

        if (isset($fields['tip'])) {
            $tipMoney = new Money;
            $tipMoney->setAmount((int)($fields['tip'] * 100));
            $tipMoney->setCurrency($fields['currency']);
            $body->setTipMoney($tipMoney);
        }

        $body->setAutocomplete(true);
        if (isset($fields['customerReference'])) {
            $body->setCustomerId($fields['customerReference']);
        }

        if (isset($fields['token'])) {
            $body->setVerificationToken($fields['token']);
        }

        $body->setLocationId($this->getLocationId());
        $body->setReferenceId($fields['referenceId']);
        $body->setNote($order->customer_name);

        $this->fireSystemEvent('payregister.square.extendCreatePaymentRequest', [$body, $paymentsApi]);

        return $paymentsApi->createPayment($body);
    }

    /**
     * Processes payment using passed data.
     *
     * @param array $data
     * @param Payment $host
     * @param Order $order
     *
     * @throws ApplicationException
     */
    #[Override]
    public function processPaymentForm($data, $host, $order): void
    {
        $this->validateApplicableFee($order, $host);

        $fields = $this->getPaymentFormFields($order, $data);

        if (array_get($data, 'create_payment_profile', 0) == 1 && $order->customer) {
            $profile = $this->updatePaymentProfile($order->customer, $data);
            $fields['sourceId'] = array_get($profile->profile_data, 'card_id');
            $fields['customerReference'] = array_get($profile->profile_data, 'customer_id');
        } else {
            $fields['sourceId'] = array_get($data, 'square_card_nonce');
            $fields['token'] = array_get($data, 'square_card_token');
        }

        try {
            $response = $this->createPayment($fields, $order, $host);

            if ($this->handlePaymentResponse($response, $order, $host, $fields, true)) {
                return;
            }
        } catch (Exception $ex) {
            $order->logPaymentAttempt('Payment error -> '.$ex->getMessage(), 0, $fields, []);
        }

        throw new ApplicationException('Sorry, there was an error processing your payment. Please try again later');
    }

    //
    // Payment Profiles
    //

    /**
     * {@inheritdoc}
     */
    #[Override]
    public function supportsPaymentProfiles(): bool
    {
        return true;
    }

    #[Override]
    public function updatePaymentProfile(Customer $customer, array $data = []): PaymentProfile
    {
        return $this->handleUpdatePaymentProfile($customer, $data);
    }

    #[Override]
    public function deletePaymentProfile(Customer $customer, PaymentProfile $profile)
    {
        return $this->handleDeletePaymentProfile($customer, $profile);
    }

    #[Override]
    public function payFromPaymentProfile(Order $order, array $data = []): void
    {
        $host = $this->getHostObject();
        $profile = $host->findPaymentProfile($order->customer);

        if (!$profile || !$profile->hasProfileData()) {
            throw new ApplicationException('Payment profile not found');
        }

        $fields = $this->getPaymentFormFields($order, $data);
        $fields['sourceId'] = array_get($profile->profile_data, 'card_id');
        $fields['customerReference'] = array_get($profile->profile_data, 'customer_id');

        try {
            $response = $this->createPayment($fields, $order, $host);

            if ($this->handlePaymentResponse($response, $order, $host, $fields, true)) {
                return;
            }
        } catch (Exception $ex) {
            $order->logPaymentAttempt('Payment error -> '.$ex->getMessage(), 0, $fields, []);
        }

        throw new ApplicationException('Sorry, there was an error processing your payment. Please try again later');
    }

    protected function createOrFetchCustomer($profileData, $customer)
    {
        $response = false;
        $client = $this->createClient();
        $customersApi = $client->getCustomersApi();

        $newCustomerRequired = !array_get($profileData, 'customer_id');

        if (!$newCustomerRequired) {
            $response = $customersApi->retrieveCustomer(array_get($profileData, 'customer_id'));

            if (!$response->isSuccess()) {
                $newCustomerRequired = true;
            }
        }

        if ($newCustomerRequired) {
            $body = new CreateCustomerRequest;
            $body->setGivenName($customer->first_name);
            $body->setFamilyName($customer->last_name);
            $body->setEmailAddress($customer->email);

            $body->setReferenceId('SqCustRef#'.$customer->customer_id);

            $response = $customersApi->createCustomer($body);

            if (!$response->isSuccess()) {
                $errors = $response->getErrors();
                $errors = $errors[0]->getDetail();

                throw new ApplicationException('Square Customer Create Error: '.$errors);
            }
        }

        return $response->getResult();
    }

    protected function createOrFetchCard(?string $customerId, ?string $referenceId, $profileData, array $data)
    {
        $cardId = array_get($profileData, 'card_id');
        $nonce = array_get($data, 'square_card_nonce');

        $response = false;
        $client = $this->createClient();
        $cardsApi = $client->getCardsApi();

        $newCardRequired = !$cardId;

        if (!$newCardRequired) {
            $response = $cardsApi->retrieveCard($cardId);

            if (!$response->isSuccess()) {
                $newCardRequired = true;
            }
        }

        if ($newCardRequired) {
            $body_card = new Card;

            $body_card->setCardholderName($data['first_name'].' '.$data['last_name']);
            $body_card->setCustomerId($customerId);
            $body_card->setReferenceId($referenceId);

            $body = new CreateCardRequest(str_random(), $nonce, $body_card);

            $response = $cardsApi->createCard($body);

            if (!$response->isSuccess()) {
                $errors = $response->getErrors();
                $errors = $errors[0]->getDetail();

                throw new ApplicationException('Square Create Payment Card Error: '.$errors);
            }
        }

        return $response->getResult();
    }

    protected function updatePaymentProfileData(PaymentProfile $profile, array $profileData, Card $cardData): PaymentProfile
    {
        $profile->card_brand = strtolower((string)$cardData->getCardBrand());
        $profile->card_last4 = $cardData->getLast4();
        $profile->setProfileData($profileData);

        return $profile;
    }

    protected function deletePaymentProfileData(PaymentProfile $profile): PaymentProfile
    {
        $profile->setProfileData([]);

        return $profile;
    }

    //
    //
    //

    #[Override]
    public function processRefundForm($data, $order, $paymentLog): void
    {
        if (!is_null($paymentLog->refunded_at)) {
            throw new ApplicationException('Nothing to refund, payment already refunded');
        }

        if (!is_array($paymentLog->response) || array_get($paymentLog->response, 'payment.status') !== 'COMPLETED') {
            throw new ApplicationException('No charge to refund');
        }

        $paymentChargeId = array_get($paymentLog->response, 'payment.id');
        $fields = $this->getPaymentRefundFields($order, $data);

        try {
            $idempotencyKey = str_random();
            $amountMoney = new Money;
            $amountMoney->setAmount($fields['amount']);
            $amountMoney->setCurrency($fields['currency']);

            $body = new RefundPaymentRequest($idempotencyKey, $amountMoney);
            $body->setPaymentId($paymentChargeId);
            $body->setReason($fields['reason']);

            $client = $this->createClient();
            $response = $client->getRefundsApi()->refundPayment($body);

            if (!$response->isSuccess()) {
                throw new Exception('Refund failed');
            }

            $message = sprintf('Payment %s refunded successfully -> (%s: %s)',
                $paymentChargeId,
                array_get($data, 'refund_type'),
                array_get($response->getResult(), 'id'),
            );

            $order->logPaymentAttempt($message, 1, $fields, $response->getResult());
            $paymentLog->markAsRefundProcessed();
        } catch (Exception $e) {
            logger()->error($e);
            $order->logPaymentAttempt('Refund failed -> '.$e->getMessage(), 0, $fields, []);
        }
    }

    protected function getPaymentRefundFields($order, $data)
    {
        $refundAmount = array_get($data, 'refund_type') !== 'full'
            ? array_get($data, 'refund_amount') : $order->order_total;

        throw_if($refundAmount > $order->order_total, new ApplicationException(
            'Refund amount should be be less than or equal to the order total',
        ));

        $fields = [
            'amount' => (int)(number_format($refundAmount, 2, '', '') * 100),
            'currency' => currency()->getUserCurrency(),
            'reason' => array_get($data, 'refund_reason'),
        ];

        $eventResult = $this->fireSystemEvent('payregister.square.extendRefundFields', [$fields, $order, $data], false);
        if (is_array($eventResult) && array_filter($eventResult)) {
            $fields = array_merge($fields, ...$eventResult);
        }

        return $fields;
    }

    //
    //
    //
    /**
     * @return SquareClient
     */
    protected function createClient()
    {
        $clientBuilder = resolve(SquareClientBuilder::class);
        $clientBuilder->accessToken($this->getAccessToken());
        $clientBuilder->environment($this->isTestMode() ? Environment::SANDBOX : Environment::PRODUCTION);

        $client = $clientBuilder->build();

        $this->fireSystemEvent('payregister.square.extendGateway', [$client]);

        return $client;
    }

    protected function getPaymentFormFields($order, $data = []): array
    {
        // just for Square - record tips as separate amount
        $orderAmount = $order->order_total;
        $tipAmount = 0;
        foreach ($order->getOrderTotals() as $ot) {
            if ($ot->code == 'tip') {
                $tipAmount = $ot->value;
                $orderAmount -= $tipAmount;
            }
        }

        $fields = [
            'idempotencyKey' => uniqid(),
            'amount' => (int)(number_format($orderAmount, 2, '.', '') * 100),
            'currency' => currency()->getUserCurrency(),
            'note' => 'Payment for Order '.$order->order_id,
            'referenceId' => (string)$order->order_id,
        ];

        if ($tipAmount) {
            $fields['tip'] = (int)(number_format($tipAmount, 2, '.', '') * 100);
        }

        $this->fireSystemEvent('payregister.square.extendFields', [&$fields, $order, $data]);

        return $fields;
    }

    protected function handlePaymentResponse(ApiResponse $response, Order $order, Payment $host, array $fields, bool $isRefundable = false): bool
    {
        if ($response->isSuccess()) {
            $order->logPaymentAttempt('Payment successful', 1, $fields, $response->getResult(), $isRefundable);
            $order->updateOrderStatus($host->order_status, ['notify' => false]);
            $order->markAsPaymentProcessed();

            return true;
        }

        $errors = $response->getErrors();
        $errors = $errors[0]->getDetail();

        $order->logPaymentAttempt('Payment error -> '.$errors, 0, $fields, $response->getResult());

        return false;
    }

    protected function handleUpdatePaymentProfile($customer, array $data)
    {
        $profile = $this->getHostObject()->findPaymentProfile($customer);
        $profileData = (array)$profile?->profile_data;

        $response = $this->createOrFetchCustomer($profileData, $customer);

        $customerId = $response->getCustomer()->getId();
        $referenceId = $response->getCustomer()->getReferenceId();

        $response = $this->createOrFetchCard($customerId, $referenceId, $profileData, $data);

        $cardData = $response->getCard();
        $cardId = $response->getCard()->getId();

        if (!$profile) {
            $profile = $this->getHostObject()->initPaymentProfile($customer);
        }

        $this->updatePaymentProfileData($profile, [
            'customer_id' => $customerId,
            'card_id' => $cardId,
        ], $cardData);

        return $profile;
    }

    protected function handleDeletePaymentProfile($customer, PaymentProfile $profile)
    {
        $cardId = $profile['profile_data']['card_id'];
        $client = $this->createClient();
        $cardsApi = $client->getCardsApi();

        $response = $cardsApi->disableCard($cardId);

        if (!$response->isSuccess()) {
            $errors = $response->getErrors();
            $errors = $errors[0]->getDetail();

            throw new ApplicationException('Square Delete Payment Card Error: '.$errors);
        }

        $this->deletePaymentProfileData($profile);
    }
}
