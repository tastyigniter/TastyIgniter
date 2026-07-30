<?php

declare(strict_types=1);

namespace Igniter\PayRegister\Payments;

use Exception;
use Igniter\Cart\Models\Order;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Main\Classes\MainController;
use Igniter\PayRegister\Classes\BasePaymentGateway;
use Igniter\PayRegister\Concerns\WithAuthorizedPayment;
use Igniter\PayRegister\Concerns\WithPaymentProfile;
use Igniter\PayRegister\Concerns\WithPaymentRefund;
use Igniter\PayRegister\Jobs\ProcessStripeWebhookJob;
use Igniter\PayRegister\Models\Payment;
use Igniter\PayRegister\Models\PaymentLog;
use Igniter\PayRegister\Models\PaymentProfile;
use Igniter\System\Traits\SessionMaker;
use Igniter\User\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Redirect;
use Override;
use Stripe\Checkout\Session;
use Stripe\PaymentIntent;
use Stripe\StripeClient;
use Stripe\Webhook;

class Stripe extends BasePaymentGateway
{
    use SessionMaker;
    use WithAuthorizedPayment;
    use WithPaymentProfile;
    use WithPaymentRefund;

    protected $intentSessionKey = 'ti_payregister_stripe_intent';

    public static ?string $paymentFormView = 'igniter.payregister::_partials.stripe.payment_form';

    #[Override]
    public function defineFieldsConfig(): string
    {
        return 'igniter.payregister::/models/stripe';
    }

    #[Override]
    public function registerEntryPoints(): array
    {
        return [
            'stripe_webhook' => 'processWebhookUrl',
            'stripe_return_url' => 'processReturnUrl',
            'stripe_cancel_url' => 'processCancelUrl',
        ];
    }

    public function getHiddenFields(): array
    {
        return [
            'stripe_payment_method' => '',
            'stripe_idempotency_key' => uniqid('', true),
        ];
    }

    public function isTestMode(): bool
    {
        return $this->model->transaction_mode != 'live';
    }

    public function isOffsiteMode(): bool
    {
        return (bool)$this->model->offsite_enabled;
    }

    public function getPublishableKey()
    {
        return $this->isTestMode() ? $this->model->test_publishable_key : $this->model->live_publishable_key;
    }

    public function getSecretKey()
    {
        return $this->isTestMode() ? $this->model->test_secret_key : $this->model->live_secret_key;
    }

    public function getWebhookSecret()
    {
        return $this->isTestMode() ? $this->model->test_webhook_secret : $this->model->live_webhook_secret;
    }

    /**
     * @param self $host
     * @param MainController $controller
     */
    #[Override]
    public function beforeRenderPaymentForm($host, $controller): void
    {
        if (!$this->isOffsiteMode()) {
            $controller->addJs('https://js.stripe.com/basil/stripe.js', 'stripe-js');
        }

        $controller->addJs('igniter.payregister::/js/process.stripe.js', 'process-stripe-js');
    }

    #[Override]
    public function completesPaymentOnClient(): bool
    {
        return !$this->isOffsiteMode();
    }

    #[Override]
    public function shouldAuthorizePayment(): bool
    {
        return $this->model->transaction_type === 'auth_only';
    }

    public function getStripeJsOptions($order)
    {
        $options = [
            'locale' => $this->model->locale_code ?? app()->getLocale(),
        ];

        $eventResult = $this->fireSystemEvent('payregister.stripe.extendJsOptions', [$options, $order], false);
        if (is_array($eventResult)) {
            $options = array_merge($options, ...array_filter($eventResult));
        }

        return $options;
    }

    public function getStripeOptions()
    {
        $options = [];

        $eventResult = $this->fireSystemEvent('payregister.stripe.extendOptions', [$options], false);
        if (is_array($eventResult)) {
            $options = array_merge($options, ...array_filter($eventResult));
        }

        return $options;
    }

    public function createOrFetchIntent($order)
    {
        try {
            if ($order->isPaymentProcessed()) {
                return null;
            }

            $this->validateApplicableFee($order, $this->getHostObject());

            $response = $this->updatePaymentIntentSession($order);

            if (!$response || in_array($response->status, ['requires_capture', 'succeeded'])) {
                $fields = $this->getPaymentFormFields($order);
                $stripeOptions = $this->getStripeOptions();
                $response = $this->createGateway()->paymentIntents->create(
                    array_only($fields, ['amount', 'currency', 'metadata', 'capture_method', 'setup_future_usage', 'customer']), $stripeOptions,
                );

                $this->putSession($this->intentSessionKey, $response->id);
            }

            return $response->client_secret;
        } catch (Exception $ex) {
            logger()->error($ex);
            $order->logPaymentAttempt('Creating checkout session failed: '.$ex->getMessage(), 0, [], []);
            flash()->warning($ex->getMessage())->important()->now();
        }

        return null;
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
    public function processPaymentForm($data, $host, $order)
    {
        $this->validateApplicableFee($order, $host);

        try {
            if ($this->isOffsiteMode()) {
                return $this->processOffsitePayment($order, $data);
            }

            if (!$intentId = $this->getSession($this->intentSessionKey)) {
                throw new Exception('Missing payment intent identifier in session.');
            }

            // Avoid logging payment and updating the order status more than once
            // For cases where the webhook is triggered before the user is redirected
            if ($order->isPaymentProcessed()) {
                return true;
            }

            $gateway = $this->createGateway();
            $stripeOptions = $this->getStripeOptions();
            $paymentIntent = $gateway->paymentIntents->retrieve($intentId, [
                'expand' => ['payment_method'],
            ], $stripeOptions);

            // At this stage the PaymentIntent status should either
            // be succeeded or requires_capture, we will only update
            // the customer profile data
            if (!in_array($paymentIntent->status, ['requires_capture', 'succeeded'])) {
                return true;
            }

            if (array_get($data, 'create_payment_profile', 0) == 1 && $order->customer) {
                $this->updatePaymentProfile($order->customer, [
                    'card_id' => $paymentIntent->payment_method->id,
                    'card' => array_only($paymentIntent->payment_method->card->toArray(), [
                        'brand',
                        'country',
                        'display_brand',
                        'exp_month',
                        'exp_year',
                        'last4',
                        'three_d_secure_usage',
                    ]),
                ]);
            }

            if ($paymentIntent->status === 'requires_capture') {
                $order->logPaymentAttempt('Payment authorized', 1, $data, $paymentIntent->toArray());
            } else {
                $order->logPaymentAttempt('Payment successful', 1, $data, $paymentIntent->toArray(), true);
            }

            $order->updateOrderStatus($host->order_status, ['notify' => false]);
            $order->markAsPaymentProcessed();

            $this->forgetSession($this->intentSessionKey);

            return true;
        } catch (Exception $ex) {
            logger()->error($ex);
            $order->logPaymentAttempt('Payment error: '.$ex->getMessage(), 0, $data);

            throw new ApplicationException('Sorry, there was an error processing your payment. Please try again later.', $ex->getCode(), $ex);
        }
    }

    #[Override]
    public function captureAuthorizedPayment(Order $order, $data = [])
    {
        throw_unless(
            $paymentLog = $order->payment_logs()->firstWhere('is_success', true),
            new ApplicationException('No successful authorized payment to capture'),
        );

        /** @var PaymentLog $paymentLog */
        throw_unless(
            $paymentIntentId = array_get($paymentLog->response, 'id'),
            new ApplicationException('Missing payment intent ID in successful authorized payment response'),
        );

        throw_if(
            $order->payment !== $this->getHostObject()->code,
            new ApplicationException(sprintf('Invalid payment class for order: %s', $order->order_id)),
        );

        try {
            $response = $this->createGateway()->paymentIntents->capture(
                $paymentIntentId,
                $this->getPaymentCaptureFields($order, $data),
                $this->getStripeOptions(),
            );

            if ($response->status == 'succeeded') {
                $order->logPaymentAttempt('Payment successful', 1, $data, $response, true);
            } else {
                $order->logPaymentAttempt('Payment capture failed', 0, $data, $response);
            }

            return $response;
        } catch (Exception $ex) {
            logger()->error($ex);
            $order->logPaymentAttempt('Payment capture failed: '.$ex->getMessage(), 0, $data);
        }

        return null;
    }

    #[Override]
    public function cancelAuthorizedPayment(Order $order, $data = [])
    {
        throw_unless(
            $paymentLog = $order->payment_logs()->firstWhere('is_success', true),
            new ApplicationException('No successful authorized payment to cancel'),
        );

        /** @var PaymentLog $paymentLog */
        throw_unless(
            $paymentIntentId = array_get($paymentLog->response, 'id'),
            new ApplicationException('Missing payment intent ID in successful authorized payment response'),
        );

        throw_if(
            $order->payment !== $this->getHostObject()->code,
            new ApplicationException(sprintf('Invalid payment class for order: %s', $order->order_id)),
        );

        try {
            $eventResult = $this->fireSystemEvent('payregister.stripe.extendCancelFields', [$data, $order], false);
            if (is_array($eventResult) && array_filter($eventResult)) {
                $data = array_merge($data, ...$eventResult);
            }

            $response = $this->createGateway()->paymentIntents->cancel(
                $paymentIntentId, $data, $this->getStripeOptions(),
            );

            if ($response->status == 'canceled') {
                $order->logPaymentAttempt('Payment canceled successfully', 1, $data, $response);
            } else {
                $order->logPaymentAttempt('Canceling payment failed', 0, $data, $response);
            }

            return $response;
        } catch (Exception $ex) {
            logger()->error($ex);
            $order->logPaymentAttempt('Payment canceled failed: '.$ex->getMessage(), 0, $data);
        }

        return null;
    }

    public function updatePaymentIntentSession($order)
    {
        try {
            if ($intentId = $this->getSession($this->intentSessionKey)) {
                $gateway = $this->createGateway();
                $stripeOptions = $this->getStripeOptions();
                $paymentIntent = $gateway->paymentIntents->retrieve($intentId, [], $stripeOptions);

                // We can not update the amount of a PaymentIntent with one of the following statuses
                if (in_array($paymentIntent->status, ['requires_capture', 'succeeded'])) {
                    return $paymentIntent;
                }

                $fields = $this->getPaymentFormFields($order, [], true);

                return $gateway->paymentIntents->update($paymentIntent->id, array_except($fields, [
                    'capture_method', 'setup_future_usage', 'customer',
                ]), $stripeOptions);
            }
        } catch (Exception $ex) {
            logger()->error($ex);
            $order->logPaymentAttempt('Updating checkout session failed: '.$ex->getMessage(), 1, [], array_slice($ex->getTrace(), 20));
            flash()->warning($ex->getMessage())->important()->now();

            return false;
        }

        return null;
    }

    //
    // Payment Profiles
    //

    #[Override]
    public function supportsPaymentProfiles(): bool
    {
        return true;
    }

    #[Override]
    public function updatePaymentProfile(Customer $customer, array $data = []): PaymentProfile
    {
        if (!$profile = $this->model->findPaymentProfile($customer)) {
            $profile = $this->model->initPaymentProfile($customer);
        }

        $profileData = array_merge((array)$profile->profile_data, $data);

        $profile->card_brand = strtolower((string)array_get($data, 'card.brand'));
        $profile->card_last4 = array_get($data, 'card.last4');
        $profile->setProfileData($profileData);

        return $profile;
    }

    #[Override]
    public function deletePaymentProfile(Customer $customer, PaymentProfile $profile): void
    {
        rescue(function() use ($profile): void {
            if (isset($profile->profile_data['customer_id'])) {
                $this->createGateway()->customers->delete($profile->profile_data['customer_id'], [], $this->getStripeOptions());
            }
        });
    }

    #[Override]
    public function payFromPaymentProfile(Order $order, array $data = []): void
    {
        $host = $this->getHostObject();
        if (!$order->customer || !$this->paymentProfileExists($order->customer)) {
            throw new ApplicationException('Payment profile not found or customer not logged in');
        }

        $gateway = $this->createGateway();
        $stripeOptions = $this->getStripeOptions();

        try {
            $fields = $this->getPaymentFormFields($order);
            $fields['off_session'] = true;
            $fields['confirm'] = true;

            $intent = $gateway->paymentIntents->create(
                array_except($fields, ['setup_future_usage']),
                $stripeOptions,
            );

            if ($intent->status !== 'succeeded') {
                throw new Exception('Status '.$intent->status);
            }

            $order->logPaymentAttempt('Payment successful', 1, $fields, $intent, true);
            $order->updateOrderStatus($host->order_status, ['notify' => false]);
            $order->markAsPaymentProcessed();
        } catch (Exception $e) {
            logger()->error($e);
            $order->logPaymentAttempt('Payment error: '.$e->getMessage(), 0, $data, $intent ?? []);

            throw new ApplicationException('Sorry, there was an error processing your payment. Please try again later.', $e->getCode(), $e);
        }
    }

    #[Override]
    public function paymentProfileExists(Customer $customer): ?bool
    {
        $profile = $this->model->findPaymentProfile($customer);

        return $profile && array_get((array)$profile->profile_data, 'card_id');
    }

    protected function createOrFetchProfileData($customer): array
    {
        if (!$profile = $this->model->findPaymentProfile($customer)) {
            $profile = $this->model->initPaymentProfile($customer);
        }

        $profileData = (array)$profile->profile_data;
        $customerId = array_get($profileData, 'customer_id');

        $newCustomerRequired = !$customerId;
        if (!$newCustomerRequired) {
            try {
                $response = $this->createGateway()->customers->retrieve($customerId, [], $this->getStripeOptions());

                if (property_exists($response, 'deleted') && $response->deleted !== null) {
                    $newCustomerRequired = true;
                }
            } catch (Exception) {
                $profile->setProfileData($profileData = []);
                $newCustomerRequired = true;
            }
        }

        try {
            if ($newCustomerRequired) {
                $response = $this->createGateway()->customers->create([
                    'name' => $customer->full_name,
                    'email' => $customer->email,
                ], $this->getStripeOptions());

                $profileData['customer_id'] = $response->id;
                $profile->setProfileData($profileData);
            }
        } catch (Exception $ex) {
            throw new ApplicationException($ex->getMessage(), $ex->getCode(), $ex);
        }

        return $profileData;
    }

    //
    // Checkout session
    //

    public function processReturnUrl(array $params): RedirectResponse
    {
        $hash = $params[0] ?? null;
        $redirectPage = input('redirect') ?: 'checkout.checkout';
        $cancelPage = input('cancel') ?: 'checkout.checkout';

        $order = $this->createOrderModel()->whereHash($hash)->first();

        try {
            throw_unless($order, new ApplicationException('No order found'));

            $paymentMethod = $order->payment_method;
            if (!$paymentMethod || $paymentMethod->getGatewayClass() != static::class) {
                throw new ApplicationException('No valid payment method found');
            }

            if (!$order->isPaymentProcessed()) {
                $order->logPaymentAttempt('Payment successful', 1, [], $paymentMethod, false);
                $order->updateOrderStatus($paymentMethod->order_status, ['notify' => false]);
                $order->markAsPaymentProcessed();
            }

            return Redirect::to(page_url($redirectPage, [
                'id' => $order->getKey(),
                'hash' => $order->hash,
            ]));
        } catch (Exception $ex) {
            $order?->logPaymentAttempt('Payment error -> '.$ex->getMessage(), 0, [], []);
            flash()->warning($ex->getMessage())->important();
        }

        return Redirect::to(page_url($cancelPage));
    }

    public function processCancelUrl(array $params): RedirectResponse
    {
        $hash = $params[0] ?? null;
        $redirectPage = input('redirect') ?: 'checkout.checkout';

        throw_unless(
            $order = $this->createOrderModel()->whereHash($hash)->first(),
            new ApplicationException('No order found'),
        );

        $paymentMethod = $order->payment_method;
        if (!$paymentMethod || $paymentMethod->getGatewayClass() != static::class) {
            throw new ApplicationException('No valid payment method found');
        }

        $order->logPaymentAttempt('Payment canceled by customer', 0, [], request()->input());

        return Redirect::to(page_url($redirectPage));
    }

    protected function processOffsitePayment(Order $order, array $data)
    {
        $gateway = $this->createGateway();
        $stripeOptions = $this->getStripeOptions();

        $fields = $this->getPaymentCheckoutSessionFields($order, $data);

        $checkoutSession = $gateway->checkout->sessions->create($fields, $stripeOptions);

        return Redirect::to($checkoutSession->url);
    }

    protected function getPaymentCheckoutSessionFields($order, $data = []): array
    {
        $cancelUrl = $this->makeEntryPointUrl('stripe_cancel_url').'/'.$order->hash;
        $successUrl = $this->makeEntryPointUrl('stripe_return_url').'/'.$order->hash;
        $successUrl .= '?redirect='.array_get($data, 'successPage').'&cancel='.array_get($data, 'cancelPage');

        $fields = [
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => currency()->getUserCurrency(),
                        'unit_amount_decimal' => number_format($order->order_total, 2, '.', '') * 100,
                        'product_data' => [
                            'name' => 'Meals',
                        ],
                    ],
                    'quantity' => 1,
                ],
            ],
            'cancel_url' => $cancelUrl.'?redirect='.array_get($data, 'cancelPage'),
            'success_url' => $successUrl,
            'mode' => 'payment',
            'metadata' => [
                'order_id' => $order->order_id,
            ],
            'payment_intent_data' => [
                'capture_method' => $this->shouldAuthorizePayment() ? 'manual' : 'automatic',
            ],
        ];

        if ($order->customer && ($profileData = $this->createOrFetchProfileData($order->customer))) {
            $fields['customer'] = array_get($profileData, 'customer_id');
        } else {
            $fields['customer_email'] = array_get($data, 'email');
        }

        $this->fireSystemEvent('payregister.stripe.extendCheckoutSessionFields', [&$fields, $order, $data]);

        return $fields;
    }

    //
    //
    //

    #[Override]
    public function processRefundForm($data, $order, $paymentLog): void
    {
        if (!is_null($paymentLog->refunded_at)) {
            throw new ApplicationException('Nothing to refund, payment has already been refunded');
        }

        if (!is_array($paymentLog->response)
            || array_get($paymentLog->response, 'status') !== 'succeeded'
            || array_get($paymentLog->response, 'object') !== 'payment_intent'
        ) {
            throw new ApplicationException('No charge to refund');
        }

        $paymentChargeId = array_get($paymentLog->response, 'id');
        $fields = $this->getPaymentRefundFields($order, $data);

        try {
            $gateway = $this->createGateway();
            $response = $gateway->refunds->create(array_merge($fields, [
                'payment_intent' => $paymentChargeId,
            ]), $this->getStripeOptions());

            if ($response->status === 'failed') {
                throw new Exception('Refund failed');
            }

            $message = sprintf('Payment intent %s refunded successfully -> (%s: %s)',
                $paymentChargeId,
                array_get($data, 'refund_type'),
                array_get($response->toArray(), 'id'),
            );

            $order->logPaymentAttempt($message, 1, $fields, $response->toArray());
            $paymentLog->markAsRefundProcessed();
        } catch (Exception $e) {
            logger()->error($e);
            $order->logPaymentAttempt('Refund failed -> '.$e->getMessage(), 0, $fields, []);
        }
    }

    protected function getPaymentFormFields($order, $data = [], $updatingIntent = false): array
    {
        $fields = [
            'amount' => number_format($order->order_total, 2, '', ''),
            'currency' => currency()->getUserCurrency(),
            'capture_method' => $this->shouldAuthorizePayment() ? 'manual' : 'automatic',
            'metadata' => [
                'order_id' => $order->order_id,
            ],
        ];

        if ($this->supportsPaymentProfiles() && $order->customer) {
            $fields['setup_future_usage'] = 'off_session';

            if ($profileData = $this->createOrFetchProfileData($order->customer)) {
                $fields['customer'] = array_get($profileData, 'customer_id');
                if ($paymentId = array_get($profileData, 'card_id')) {
                    $fields['payment_method'] = $paymentId;
                }
            }
        }

        $this->fireSystemEvent('payregister.stripe.extendFields', [&$fields, $order, $data, $updatingIntent]);

        return $fields;
    }

    protected function getPaymentCaptureFields($order, $fields = [])
    {
        $eventResult = $this->fireSystemEvent('payregister.stripe.extendCaptureFields', [$fields, $order], false);
        if (is_array($eventResult) && array_filter($eventResult)) {
            $fields = array_merge($fields, ...$eventResult);
        }

        return $fields;
    }

    protected function getPaymentRefundFields($order, $data)
    {
        $refundAmount = array_get($data, 'refund_type') !== 'full'
            ? array_get($data, 'refund_amount') : $order->order_total;

        throw_if(!$refundAmount || $refundAmount > $order->order_total, new ApplicationException(
            'Refund amount should be be less than or equal to the order total',
        ));

        $fields = [
            'amount' => number_format($refundAmount, 2, '', ''),
        ];

        $eventResult = $this->fireSystemEvent('payregister.stripe.extendRefundFields', [$fields, $order, $data], false);
        if (is_array($eventResult) && array_filter($eventResult)) {
            $fields = array_merge($fields, ...$eventResult);
        }

        return $fields;
    }

    protected function createGateway(): StripeClient
    {
        \Stripe\Stripe::setAppInfo(
            'TastyIgniter Stripe',
            '1.0.0',
            'https://tastyigniter.com/marketplace/item/igniter-payregister',
            'pp_partner_JZyCCGR3cOwj9S', // Used by Stripe to identify this integration
        );

        $stripeClient = new StripeClient([
            'api_key' => $this->getSecretKey(),
        ]);

        $this->fireSystemEvent('payregister.stripe.extendGateway', [$stripeClient]);

        return $stripeClient;
    }

    public function verifyPaymentIntentForOrder(Order $order, string $intentId): ?PaymentIntent
    {
        try {
            $paymentIntent = $this->createGateway()->paymentIntents->retrieve(
                $intentId,
                [],
                $this->getStripeOptions(),
            );
        } catch (Exception $ex) {
            logger()->error($ex);

            return null;
        }

        if ((string)array_get($paymentIntent->metadata->toArray(), 'order_id') !== (string)$order->order_id) {
            return null;
        }

        if (!in_array($paymentIntent->status, ['requires_capture', 'succeeded'], true)) {
            return null;
        }

        if ($paymentIntent->amount !== (int)number_format($order->order_total, 2, '', '')) {
            return null;
        }

        return $paymentIntent;
    }

    public function verifyCheckoutSessionForOrder(Order $order, string $sessionId): ?Session
    {
        try {
            $session = $this->createGateway()->checkout->sessions->retrieve(
                $sessionId,
                ['expand' => ['payment_intent']],
                $this->getStripeOptions(),
            );
        } catch (Exception $ex) {
            logger()->error($ex);

            return null;
        }

        if ((string)array_get($session->metadata->toArray(), 'order_id') !== (string)$order->order_id) {
            return null;
        }

        if ($session->status !== 'complete') {
            return null;
        }

        if ($session->amount_total !== (int)number_format($order->order_total, 2, '', '')) {
            return null;
        }

        $paymentIntent = $session->payment_intent;

        if ($paymentIntent && !in_array($paymentIntent->status, ['requires_capture', 'succeeded'], true)) {
            return null;
        }

        if ($paymentIntent->amount !== (int)number_format($order->order_total, 2, '', '')) {
            return null;
        }

        return $session;
    }

    //
    // Webhook
    //

    public function processWebhookUrl()
    {
        if (strtolower(request()->method()) !== 'post') {
            return response()->json('Request method must be POST', 400);
        }

        try {
            $payload = $this->getWebhookPayload();
        } catch (Exception $ex) {
            return response()->json('Failed to parse webhook payload: '.$ex->getMessage(), 400);
        }

        if (!isset($payload['type']) || !strlen((string)($eventType = $payload['type']))) {
            return response()->json('Missing webhook event name', 400);
        }

        Event::dispatch('payregister.stripe.webhook.handle', [$this->model, $eventType, $payload]);

        $webhookJob = new ProcessStripeWebhookJob($this->model, $eventType, $payload);

        if (method_exists($webhookJob, $webhookJob->getMethod())) {
            // Delay the job to ensure the webhook is processed after the checkout request is completed
            dispatch($webhookJob)->delay(now()->addMinute());
        }

        return response()->json('Webhook Handled');
    }

    protected function getWebhookPayload(): array
    {
        if (!$webhookSecret = $this->getWebhookSecret()) {
            throw new Exception('Webhook secret is not configured. Webhooks cannot be processed securely.');
        }

        $event = Webhook::constructEvent(
            request()->getContent(),
            request()->header('stripe-signature'),
            $webhookSecret,
        );

        return $event->toArray();
    }
}
