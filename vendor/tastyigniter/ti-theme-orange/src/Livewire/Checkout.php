<?php

declare(strict_types=1);

namespace Igniter\Orange\Livewire;

use Exception;
use Igniter\Cart\Classes\CartManager;
use Igniter\Cart\Classes\CheckoutForm;
use Igniter\Cart\Classes\OrderManager;
use Igniter\Cart\Models\Order;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Flame\Support\Facades\File;
use Igniter\Flame\Traits\EventEmitter;
use Igniter\Local\Facades\Location;
use Igniter\Local\Models\Location as LocationModel;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Main\Traits\UsesPage;
use Igniter\Orange\Actions\EnsureUniqueProcess;
use Igniter\System\Facades\Assets;
use Igniter\User\Facades\Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Event;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;
use Livewire\Livewire;
use Throwable;

/**
 * Checkout component
 *
 * @property-read Collection $paymentGateways
 */
final class Checkout extends Component
{
    use ConfigurableComponent;
    use EventEmitter;
    use UsesPage;

    public const string STEP_DETAILS = 'details';

    public const string STEP_PAY = 'pay';

    /** Whether to use a two-page checkout */
    public bool $isTwoPageCheckout = false;

    /** Whether to display the telephone form field */
    public bool $hideTelephoneField = false;

    /** Whether to display the comment form field */
    public bool $hideCommentField = false;

    /** Whether to display the delivery comment form field */
    public bool $hideDeliveryCommentField = false;

    /** Whether the telephone field should be required */
    public bool $telephoneIsRequired = true;

    /** The permalink slug for the agree checkout terms page */
    public string $agreeTermsSlug = 'terms-and-conditions';

    /** The checkout page */
    public string $menusPage = 'local.menus';

    /** The checkout page */
    public string $checkoutPage = 'checkout.checkout';

    /** Page to redirect to when checkout is successful */
    public string $successPage = 'checkout.success';

    #[Url(as: 'step')]
    public string $checkoutStep = 'details';

    public array $fields = [];

    protected CheckoutForm $checkoutForm;

    protected CartManager $cartManager;

    protected OrderManager $orderManager;

    protected ?Order $order = null;

    public static function componentMeta(): array
    {
        return [
            'code' => 'igniter-orange::checkout',
            'name' => 'igniter.orange::default.component_checkout_title',
            'description' => 'igniter.orange::default.component_checkout_desc',
        ];
    }

    public function defineProperties(): array
    {
        return [
            'isTwoPageCheckout' => [
                'label' => 'Use two-page checkout.',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
            'hideTelephoneField' => [
                'label' => 'Display the telephone checkout field.',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
            'hideCommentField' => [
                'label' => 'Display the comment checkout field',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
            'hideDeliveryCommentField' => [
                'label' => 'Display the delivery comment checkout field',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
            'telephoneIsRequired' => [
                'label' => 'Require telephone number for checkout',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
            'agreeTermsSlug' => [
                'label' => 'Static page for the checkout terms and conditions',
                'type' => 'select',
                'options' => self::getStaticPageOptions(...),
                'comment' => 'If set, require customers to agree to terms before checkout',
                'validationRule' => 'sometimes|alpha_dash',
            ],
            'menusPage' => [
                'label' => 'Page to redirect to when checkout is unavailable.',
                'type' => 'select',
                'options' => self::getThemePageOptions(...),
                'validationRule' => 'required|regex:/^[a-z0-9\-_\.]+$/i',
            ],
            'checkoutPage' => [
                'label' => 'Page to redirect to when checkout fails',
                'type' => 'select',
                'options' => self::getThemePageOptions(...),
                'validationRule' => 'required|regex:/^[a-z0-9\-_\.]+$/i',
            ],
            'successPage' => [
                'label' => 'Page to redirect to when checkout is successful',
                'type' => 'select',
                'options' => self::getThemePageOptions(...),
                'validationRule' => 'required|regex:/^[a-z0-9\-_\.]+$/i',
            ],
        ];
    }

    public function render(): View
    {
        return view('igniter-orange::livewire.checkout', [
            'customer' => Auth::customer(),
            'order' => $order = $this->getOrder(),
            'locationCurrent' => Location::current(),
            'locationOrderType' => Location::getOrderTypes()->get($order->order_type),
        ]);
    }

    public function mount()
    {
        if (!is_null($order = $this->isOrderMarkedAsProcessed())) {
            return $this->redirect($order->getUrl($this->successPage));
        }

        if (!is_null($this->checkCheckoutSecurity())) {
            return $this->redirect(restaurant_url($this->menusPage));
        }

        Assets::addJs('igniter-orange::/js/checkout.js', 'checkout-js');

        foreach ($this->paymentGateways as $paymentGateway) {
            $paymentGateway->beforeRenderPaymentForm($paymentGateway, controller());
        }

        foreach ($this->checkoutForm->getFields() as $field) {
            $this->fields[$field->fieldName] = $field->value;
        }

        $this->prepareDeliveryAddress();

        return null;
    }

    public function boot(): void
    {
        $this->orderManager = resolve(OrderManager::class);
        $this->cartManager = resolve(CartManager::class);
        $this->initForm();
    }

    #[Computed]
    public function cartTotal(): string
    {
        return currency_format($this->cartManager->getCart()->total());
    }

    #[Computed]
    public function formTabFields(string $tab): array
    {
        return array_get($this->checkoutForm->getTab('primary'), $tab, []);
    }

    #[Computed]
    public function paymentGateways()
    {
        return number_format($this->getOrder()->order_total, 2) > 0
            ? $this->orderManager->getPaymentGateways()
            : collect();
    }

    #[On('checkout::validate')]
    public function onValidate()
    {
        if ($this->checkCheckoutSecurity()) {
            return $this->redirect(restaurant_url($this->menusPage));
        }

        if (!is_null($order = $this->isOrderMarkedAsProcessed())) {
            return $this->redirect($order->getUrl($this->successPage));
        }

        $order = $this->getOrder();

        $this->prepareDeliveryAddress();

        $data = $this->validateCheckout($order);

        $this->orderManager->saveOrder($order, $data);

        $this->dispatch('checkout::validated');

        return null;
    }

    #[On('checkout::confirm')]
    public function onConfirm()
    {
        if ($this->checkCheckoutSecurity()) {
            return $this->redirect(restaurant_url($this->menusPage));
        }

        if (!is_null($order = $this->isOrderMarkedAsProcessed())) {
            return $this->redirect($order->getUrl($this->successPage));
        }

        $order = $this->getOrder();

        $this->prepareDeliveryAddress();

        $data = $this->validateCheckout($order);

        $data['cancelPage'] = $this->checkoutPage;
        $data['successPage'] = $this->successPage;

        try {
            $lockKey = 'checkout::confirm-'.$order->order_date.$order->order_time.'-'.$order->order_type;
            resolve(EnsureUniqueProcess::class)->attemptWithLock($lockKey, function() use ($data, $order): void {
                $this->orderManager->saveOrder($order, $data);
            });

            if ($this->isInitialCheckoutStep()) {
                return $this->redirect(Livewire::originalUrl().'?step='.self::STEP_PAY);
            }

            if (($redirect = $this->orderManager->processPayment($order, $data)) === false) {
                return null;
            }

            if ($redirect instanceof RedirectResponse || $redirect instanceof Redirector) {
                return $redirect;
            }

            return $this->redirect($order->getUrl($this->successPage));
        } catch (Exception $ex) {
            $errorFieldName = $this->isInitialCheckoutStep() ? 'fields.comment' : 'fields.payment';

            throw ValidationException::withMessages([$errorFieldName => $ex->getMessage()]);
        }
    }

    #[On('checkout::choose-payment')]
    public function onChoosePayment($code): void
    {
        throw_unless($code, ValidationException::withMessages([
            'fields.payment' => lang('igniter.cart::default.checkout.error_invalid_payment'),
        ]));

        throw_unless($payment = $this->orderManager->getPayment($code), ValidationException::withMessages([
            'fields.payment' => lang('igniter.cart::default.checkout.error_invalid_payment'),
        ]));

        $this->fields['payment'] = $code;
        $this->checkoutForm->getField('payment')->value = $code;
        $this->orderManager->applyCurrentPaymentFee($payment->code);

        if ($this->order->payment !== $code) {
            $this->order->updateQuietly(['payment' => $code]);
        }

        $this->order = null;
    }

    #[On('checkout::delete-payment-profile')]
    public function onDeletePaymentProfile($code)
    {
        $customer = Auth::customer();
        $payment = $this->orderManager->getPayment($code);

        throw_if(!$payment, ValidationException::withMessages([
            'fields.payment' => lang('igniter.cart::default.checkout.error_invalid_payment'),
        ]));

        throw_if(!$payment->paymentProfileExists($customer), ValidationException::withMessages([
            'fields.payment' => lang('igniter.cart::default.checkout.error_payment_profile_not_found'),
        ]));

        $payment->deletePaymentProfile($customer);

        return redirect()->back();
    }

    protected function getOrder(): Order
    {
        if (!is_null($this->order)) {
            return $this->order;
        }

        return $this->order = $this->orderManager->loadOrder();
    }

    protected function checkCheckoutSecurity(): ?bool
    {
        try {
            $this->cartManager->validateContents();

            $this->orderManager->validateCustomer(Auth::getUser());

            $this->cartManager->validateLocation();

            $this->cartManager->validateOrderTime();

            if ($this->cartManager->cartTotalIsBelowMinimumOrder()) {
                throw new ApplicationException(sprintf(lang('igniter.cart::default.alert_min_order_total'),
                    currency_format(resolve('location')->minimumOrderTotal())));
            }

            if ($this->cartManager->deliveryChargeIsUnavailable()) {
                return true;
            }

            Event::dispatch('igniter.orange.checkCheckoutSecurity');

            return null;
        } catch (Exception $ex) {
            flash()->warning($ex->getMessage())->now();

            return true;
        }
    }

    protected function validateCheckout(Order $order)
    {
        $rules = $this->checkoutForm->validationRules();
        $messages = $this->checkoutForm->validationMessages();
        $attributes = $this->checkoutForm->validationAttributes();

        if (!$this->agreeTermsSlug || $this->isInitialCheckoutStep()) {
            $rules = array_except($rules, ['fields.termsAgreed']);
        }

        $this->withValidator(function($validator) use ($order): void {
            $validator->after(function($validator) use ($order): void {
                if ($order->isDeliveryType() && Location::requiresUserPosition()) {
                    rescue(function(): void {
                        $this->orderManager->validateDeliveryAddress(array_only($this->fields, [
                            'address_1', 'city', 'state', 'postcode', 'country',
                        ]));
                    }, function(Throwable $ex) use ($validator): void {
                        $validator->errors()->add('delivery_address', $ex->getMessage());
                    });
                }

                if ($this->fields['payment'] && !$this->orderManager->getPayment($this->fields['payment'])) {
                    $validator->errors()->add('payment', lang('igniter.cart::default.checkout.error_invalid_payment'));
                }
            });
        });

        $data = $this->validate($rules, $messages, $attributes);
        $data = array_merge(
            $this->fields,
            array_pull($data, 'fields.payment_fields', []),
            array_pull($data, 'fields', []),
            $data,
        );

        $this->orderManager->applyCurrentPaymentFee($this->fields['payment']);

        Event::dispatch('igniter.orange.validateCheckout', [$data, $order]);

        return $data;
    }

    protected function isOrderMarkedAsProcessed(): ?Order
    {
        $order = $this->getOrder();

        return $order->isPaymentProcessed() ? $order : null;
    }

    protected function prepareDeliveryAddress(): void
    {
        if (!$this->getOrder()->isDeliveryType()) {
            return;
        }

        $userPosition = Location::userPosition();
        if ($userPosition && $userPosition->isValid()) {
            $this->fields['address_1'] = $userPosition->getStreetNumber().' '.$userPosition->getStreetName();
            $this->fields['city'] = $userPosition->getSubLocality();
            $this->fields['state'] = $userPosition->getLocality();
            $this->fields['postcode'] = $userPosition->getPostalCode();
            $this->fields['country_id'] = array_get(countries('country_id', 'iso_code_2'),
                $userPosition->getCountryCode(), LocationModel::getDefaultKey());
        }
    }

    protected function isInitialCheckoutStep(): bool
    {
        return $this->isTwoPageCheckout && $this->checkoutStep !== self::STEP_PAY;
    }

    protected function formExtendFieldsBefore(CheckoutForm $checkoutForm): void
    {
        if ($this->agreeTermsSlug !== '' && $this->agreeTermsSlug !== '0') {
            $checkoutForm->fields['termsAgreed']['placeholder'] = sprintf(
                lang('igniter.cart::default.checkout.label_terms'), url($this->agreeTermsSlug),
            );
        } else {
            unset($checkoutForm->fields['termsAgreed'], $this->fields['termsAgreed']);
        }

        if ($this->hideTelephoneField) {
            unset($checkoutForm->fields['telephone'], $this->fields['telephone']);
        }

        if ($this->hideCommentField) {
            unset($checkoutForm->fields['comment'], $this->fields['comment']);
        }

        if ($this->hideDeliveryCommentField) {
            unset($checkoutForm->fields['delivery_comment'], $this->fields['delivery_comment']);
        }
    }

    protected function formExtendFields(CheckoutForm $checkoutForm, array $fields): void {}

    protected function initForm(): void
    {
        $config = File::getRequire(
            File::symbolizePath('igniter-orange::/models/checkoutfields.php'),
        );

        $config['model'] = $this->getOrder();
        $this->checkoutForm = resolve(CheckoutForm::class, ['config' => $config]);

        $this->checkoutForm->bindEvent('form.extendFieldsBefore', function(): void {
            $this->formExtendFieldsBefore($this->checkoutForm);
        });

        $this->checkoutForm->bindEvent('form.extendFields', function(array $fields): void {
            $this->formExtendFields($this->checkoutForm, $fields);
        });

        $this->checkoutForm->initialize();
    }
}
