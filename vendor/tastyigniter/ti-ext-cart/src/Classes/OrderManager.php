<?php

declare(strict_types=1);

namespace Igniter\Cart\Classes;

use Igniter\Cart\Cart;
use Igniter\Cart\CartCondition;
use Igniter\Cart\Models\Order;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Flame\Geolite\Facades\Geocoder;
use Igniter\Flame\Geolite\Model\Location as UserLocation;
use Igniter\Local\Classes\CoveredArea;
use Igniter\Local\Classes\Location;
use Igniter\Local\Models\LocationArea;
use Igniter\PayRegister\Models\Payment;
use Igniter\System\Traits\SessionMaker;
use Igniter\User\Facades\Auth;
use Igniter\User\Models\Address;
use Igniter\User\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Request;

class OrderManager
{
    use SessionMaker;

    protected string $sessionKey = 'igniter.checkout.order';

    protected Cart $cart;

    protected Location $location;

    protected ?Customer $customer = null;

    public function __construct()
    {
        $this->cart = resolve(CartManager::class)->getCart();
        $this->location = App::make('location');
        $this->customer = Auth::customer();
    }

    public function setLocation(Location $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function setCustomer(Customer $customer): static
    {
        $this->customer = $customer;

        return $this;
    }

    public function getCustomerId()
    {
        if (!$this->customer instanceof Customer) {
            return null;
        }

        return $this->customer->getKey();
    }

    public function getOrder(): Order
    {
        return $this->loadOrder();
    }

    public function loadOrder(): Order
    {
        $customerId = $this->customer->customer_id ?? null;

        /** @var ?Order $order */
        $order = Order::find($this->getCurrentOrderId());

        // Only users can view their own orders
        if (!$order || $order->customer_id != $customerId) {
            $order = new Order($this->getCustomerAttributes());
        }

        if (!$order->isPaymentProcessed()) {
            $this->applyRequiredAttributes($order);
        }

        if (!$order->exists) {
            DB::transaction(function() use ($order): void {
                $order->save();
                $order->addOrderMenus($this->cart->content()->all());
                $order->addOrderTotals($this->getCartTotals());
            }, 3);

            $this->setCurrentOrderId($order->order_id);
        }

        return $order;
    }

    /**
     * @param Customer|null $customer
     * @return Order|Model|object|null
     */
    public function getOrderByHash($hash, $customer = null)
    {
        $query = Order::whereHash($hash);

        if (!is_null($customer)) {
            $query->where('customer_id', $customer->getKey());
        }

        return $query->first();
    }

    public function getDefaultPayment()
    {
        return $this->getPaymentGateways()->firstWhere('is_default', true)
            ?? $this->getPaymentGateways()->first();
    }

    public function getPayment($code): ?Payment
    {
        return $this->getPaymentGateways()->where('code', $code)->first();
    }

    public function getPaymentGateways()
    {
        return $this->location->current()->listAvailablePayments()->sortBy('priority');
    }

    public function findDeliveryAddress($addressId)
    {
        if (empty($addressId)) {
            return null;
        }

        return Address::find($addressId);
    }

    //
    //
    //

    public function validateCustomer($customer): void
    {
        if (!$this->location->current()->allowGuestOrder() && (!$customer || !$customer->is_activated)) {
            throw new ApplicationException(lang('igniter.cart::default.checkout.alert_customer_not_logged'));
        }
    }

    public function validateDeliveryAddress(array $address): void
    {
        if (!array_get($address, 'country') && isset($address['country_id'])) {
            $address['country'] = app('country')->getCountryNameById($address['country_id']);
        }

        $addressInfo = array_only($address, ['address_1', 'address_2', 'city', 'state', 'postcode', 'country']);
        if (empty($addressInfo)) {
            throw new ApplicationException(lang('igniter.local::default.alert_invalid_search_query'));
        }

        $collection = Geocoder::geocode(implode(' ', $addressInfo));
        if ($collection->isEmpty()) {
            throw new ApplicationException(lang('igniter.local::default.alert_invalid_search_query'));
        }

        /** @var UserLocation $userLocation */
        $userLocation = $collection->first();
        if (!$userLocation->getStreetNumber() || !$userLocation->getStreetName()) {
            throw new ApplicationException(lang('igniter.local::default.alert_missing_street_address'));
        }

        $this->location->updateUserPosition($userLocation);

        if (!($area = $this->location->current()->searchDeliveryArea($userLocation->getCoordinates())) instanceof LocationArea) {
            throw new ApplicationException(lang('igniter.cart::default.checkout.error_covered_area'));
        }

        if (!$this->location->isCurrentAreaId($area->area_id)) {
            $this->location->setCoveredArea(new CoveredArea($area));

            throw new ApplicationException(lang('igniter.cart::default.checkout.alert_delivery_area_changed'));
        }
    }

    /**
     * @param $order \Igniter\Cart\Models\Order
     *
     * @return Order
     */
    public function saveOrder($order, array $data)
    {
        Event::dispatch('igniter.checkout.beforeSaveOrder', [$order, $data]);

        if ($this->customer instanceof Customer) {
            $data['email'] = $this->customer->email;
        }

        if (array_key_exists('address_1', $data)) {
            $address['customer_id'] = $this->getCustomerId();
            $address['address_1'] = array_pull($data, 'address_1');
            $address['address_2'] = array_pull($data, 'address_2');
            $address['city'] = array_pull($data, 'city');
            $address['state'] = array_pull($data, 'state');
            $address['postcode'] = array_pull($data, 'postcode');
            $address['country_id'] = array_pull($data, 'country_id');

            if (empty($addressId = array_get($data, 'address_id'))) {
                $data['address_id'] = $addressId = Address::createOrUpdateFromRequest($address)->getKey();
            }

            // Update customer default address
            if ($this->customer && $this->customer->address_id != $addressId) {
                $this->customer->address_id = $addressId;
                $this->customer->saveQuietly();
            }
        }

        $order->fill($data);
        $this->applyRequiredAttributes($order);

        DB::transaction(function() use ($order): void {
            if ($order->exists) {
                Order::whereKey($order->getKey())->lockForUpdate()->first();
            }

            $order->saveQuietly();
            $order->addOrderMenus($this->cart->content()->all());
            $order->addOrderTotals($this->getCartTotals());
        }, 3);

        Event::dispatch('igniter.checkout.afterSaveOrder', [$order]);

        return $order;
    }

    public function processPayment($order, array $data)
    {
        Event::dispatch('igniter.checkout.beforePayment', [$order, $data]);

        if (!strlen((string)$order->payment) && $order->order_total <= 0) {
            return $this->processPaymentLessForm($order);
        }

        if ($order->order_total > 0 && !strlen((string)$order->payment)) {
            throw new ApplicationException(lang('igniter.cart::default.checkout.error_invalid_payment'));
        }

        $paymentMethod = $this->getPayment($order->payment);
        if (!$paymentMethod || !$paymentMethod->status) {
            throw new ApplicationException(lang('igniter.cart::default.checkout.error_inactive_payment'));
        }

        if (!$paymentMethod->isApplicable($order->order_total, $paymentMethod)) {
            throw new ApplicationException(sprintf(
                lang('igniter.payregister::default.alert_min_order_total'),
                currency_format($paymentMethod->order_total),
                $paymentMethod->name,
            ));
        }

        if ($paymentMethod->hasApplicableFee() && !optional($this->cart->getCondition('paymentFee'))->isApplied()) {
            throw new ApplicationException(sprintf(
                lang('igniter.payregister::default.alert_missing_applicable_fee'),
                $paymentMethod->name,
            ));
        }

        if (array_get($data, 'pay_from_profile') == 1) {
            $result = $paymentMethod->payFromPaymentProfile($order, $data);
        } else {
            $result = $paymentMethod->processPaymentForm($data, $paymentMethod, $order);
        }

        return $result;
    }

    public function applyRequiredAttributes($order): void
    {
        $order->customer_id = $this->customer instanceof Customer ? $this->customer->getKey() : null;
        $order->location_id = $this->location->current()->getKey();
        $order->order_type = $this->location->orderType();

        $this->applyOrderDateTime($order);

        $order->total_items = $this->cart->count();
        $order->cart = $this->cart->content();
        $order->order_total = $this->cart->total();

        $paymentCode = $this->getCurrentPaymentCode();
        $order->payment = $order->order_total > 0 ? $paymentCode : '';

        $this->applyCurrentPaymentFee($order->payment);

        $order->ip_address = Request::getClientIp();
    }

    protected function getCustomerAttributes(): array
    {
        $customer = $this->customer;

        return [
            'first_name' => $customer->first_name ?? '',
            'last_name' => $customer->last_name ?? '',
            'email' => $customer->email ?? '',
            'telephone' => $customer->telephone ?? '',
            'address_id' => $customer->address_id ?? null,
        ];
    }

    public function getCartTotals()
    {
        $itemConditions = [];
        foreach ($this->cart->content() as $cartItem) {
            foreach ($cartItem->conditions ?? [] as $condition) {
                $total = [
                    'code' => $condition->name,
                    'title' => $condition->getLabel(),
                    'value' => is_numeric($value = $condition->getValue()) ? $value : 0,
                    'priority' => $condition->getPriority() ?: 1,
                    'is_summable' => false,
                ];

                if (array_key_exists($condition->name, $itemConditions)) {
                    $itemConditions[$condition->name]['value'] += $total['value'];
                    continue;
                }

                $itemConditions[$condition->name] = $total;
            }
        }

        $totals = $this->cart->conditions()->map(fn(CartCondition $condition): array => [
            'code' => $condition->name,
            'title' => $condition->getLabel(),
            'value' => is_numeric($value = $condition->getValue()) ? $value : 0,
            'priority' => $condition->getPriority() ?: 1,
            'is_summable' => !$condition->isInclusive(),
        ])->merge($itemConditions)->all();

        $totals['subtotal'] = [
            'code' => 'subtotal',
            'title' => lang('igniter.cart::default.text_sub_total'),
            'value' => $this->cart->subtotal(),
            'priority' => 0,
            'is_summable' => false,
        ];

        $totals['total'] = [
            'code' => 'total',
            'title' => lang('igniter.cart::default.text_order_total'),
            'value' => max(0, $this->cart->total()),
            'priority' => 999,
            'is_summable' => false,
        ];

        return $totals;
    }

    /**
     * @param Order $order
     */
    protected function processPaymentLessForm($order): bool
    {
        $order->updateOrderStatus(setting('default_order_status'), ['notify' => false]);
        $order->markAsPaymentProcessed();

        return true;
    }

    public function applyOrderDateTime($order): void
    {
        $orderDateTime = $this->location->orderDateTime();

        if ($isAsapTime = $this->location->orderTimeIsAsap()) {
            $orderDateTime->addMinutes($this->location->orderLeadTime());
        }

        $order->order_time_is_asap = $isAsapTime;
        $order->order_date = $orderDateTime->format('Y-m-d');
        $order->order_time = $orderDateTime->format('H:i');
    }

    //
    // Session
    //

    public function clearOrder(): void
    {
        $this->location->updateScheduleTimeSlot(null);
        $this->cart->destroy($this->getCustomerId());
        $this->resetSession();
    }

    /**
     * Set the current order id.
     */
    public function setCurrentOrderId($orderId): void
    {
        $this->putSession('id', $orderId);
    }

    /**
     * Get the current order id.
     */
    public function getCurrentOrderId(): mixed
    {
        return $this->getSession('id');
    }

    /**
     * Clear the current order id.
     */
    public function clearCurrentOrderId(): void
    {
        $this->forgetSession('id');
    }

    /**
     * Check if the given order id is the current order id.
     */
    public function isCurrentOrderId($orderId): bool
    {
        return $this->getCurrentOrderId() == $orderId;
    }

    public function setCurrentPaymentCode($code): void
    {
        $this->putSession('paymentCode', $code);
    }

    public function getCurrentPaymentCode()
    {
        return $this->getSession('paymentCode') ?: $this->getDefaultPayment()?->code;
    }

    public function applyCurrentPaymentFee($code): ?CartCondition
    {
        $this->setCurrentPaymentCode($code);

        $condition = $this->cart->getCondition('paymentFee');
        if ($condition instanceof CartCondition) {
            $condition->setMetaData(['code' => $code]);
            $this->cart->loadCondition($condition);
        }

        return $condition;
    }
}
