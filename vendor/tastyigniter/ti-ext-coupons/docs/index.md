---
title: "Coupons"
section: "extensions"
sortOrder: 50
---

## Installation

You can install the extension via composer using the following command:

```bash
composer require tastyigniter/ti-ext-coupons -W
```

Run the database migrations to create the required tables:
  
```bash
php artisan igniter:up
```

## Getting started

This extension provides a cart condition that allows you apply coupons to the cart.

To enable the coupon condition, go to _Manage > Settings > Cart Settings_, toggle on the coupon cart condition.

To create a new coupon, navigate to _Marketing > Coupons_ and click the `New Coupon` button. You can configure the coupon details, such as the discount type, amount, and usage restrictions.

Once you have created a coupon, customers can apply it during checkout by entering the coupon code in the cart.

## Usage

This section covers how to integrate the Coupons extension into your own extension if you need to apply your custom coupons to the cart or redeem them on orders. The Coupons extension provides a simple API for managing coupons, applying them to the cart, and redeeming them on orders.

### Applying coupons to the cart

You can apply a coupon to a cart instance by using the `coupon` cart condition. Here is an example of how to apply a coupon to the cart from your frontend component:

```php
use Igniter\Cart\Facades\Cart;

$couponCondition = Cart::getCondition('coupon');

$couponCondition->setMetaData(['code' => $code]);

Cart::loadCondition($couponCondition);
```

And check if the coupon condition is valid and has been applied to the cart totals using the `isValid` method:

```php
if (Cart::getCondition('coupon')->isValid()) {
    // Do something...
}
```

You can also clear the coupon from the cart using the `removeCondition` method:

```php
Cart::removeCondition('coupon');
```

### Redeeming coupons

You may want to programmatically redeem a coupon when a customer completes an order. You can do this by using the `redeemCoupon` method on the order model:

```php
use Igniter\Cart\Models\Order;

// A new pending order is created
$order = Order::create($attributes);

// Log the coupon history using the coupon cart condition
$couponCondition = Cart::conditions()->get('coupon');
$order->logCouponHistory($couponCondition);

// Add a coupon total to the order_totals table, required for the coupon to be redeemed
$order->addOrUpdateOrderTotal([
    'code' => 'coupon',
    'title' => 'Coupon',
    'value' => -10.0,
    'priority' => 100,
    'is_summable' => true,
]);

// Redeem the coupon by setting the status on the coupon history to true
$order->redeemCoupon();
```

### Permissions

The Coupons extension registers the following permission:

- `Admin.Coupons`: Control who can manage coupons in the admin area.

For more on restricting access to the admin area, see the [TastyIgniter Permissions](https://tastyigniter.com/docs/customize/permissions) documentation.

### Events

The Coupons extension triggers the following events:

- `igniter.cart.beforeApplyCoupon`: Triggered before applying a coupon to the cart. Passes the coupon code as argument.
- `couponHistory.beforeAddHistory`: Triggered before adding a coupon history record. Passes the coupon history model, coupon cart condition object, customer model, coupon model as arguments.
- `admin.order.couponRedeemed`: Triggered after a coupon has been redeemed on an order. Passes the coupon history model as argument.

Here is an example of hooking an event in the `boot` method of an extension class:

```php
use Illuminate\Support\Facades\Event;

public function boot()
{
    Event::listen('igniter.cart.beforeApplyCoupon', function ($code) {
        // ...
    });
}
```
