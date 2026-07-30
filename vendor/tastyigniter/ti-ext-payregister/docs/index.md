---
title: "Pay Register"
section: "extensions"
sortOrder: 80
---

## Installation

You can install the extension via composer using the following command:

```bash
composer require tastyigniter/ti-ext-pages -W
```

Run the database migrations to create the required tables:
  
```bash
php artisan igniter:up
```

## Getting started

Go to _Manage > Settings > Configure Payments_ to enable and manage payments. Here you can enable your preferred payment gateways and configure their settings.

You can also enable/disable payments for specific locations by navigating to the _Manage > Locations_ admin page, and click on the _Settings Icon_ next to the location then click the _Checkout settings_ button under the _General_ tab.

## Usage

This section covers how to integrate the Pay Register extension into your own extension if you need to create custom payment gateways, handle payment processing, or manage payment profiles. The Pay Register extension provides a simple API for managing payments, payment gateways, and payment profiles.

### Defining payment gateways

A payment gateway class is responsible for handing the payment method during checkout. It should extend the `Igniter\PayRegister\Classes\BasePaymentGateway` class and implement the `defineFieldsConfig` and `processPaymentForm` methods.

```php
use Igniter\PayRegister\Classes\BasePaymentGateway;

class MyPayment extends BasePaymentGateway
{
    public function defineFieldsConfig(): string|array
    {
        return 'author.extension::/models/mypayment';
    }

    /**
     * Processes payment using checkout form data.
     *
     * @param array $data
     * @param \Igniter\PayRegister\Models\Payment $host
     * @param \Igniter\Cart\Models\Order $order
     *
     * @throws \Igniter\Flame\Exception\ApplicationException
     */
    public function processPaymentForm($data, $host, $order): mixed
    {
        //
    }
}
```

The `defineFieldsConfig` method should return an array or path to the form definition file for the payment gateway. The form definition file should define the form fields for the [payment settings form](#defining-payment-settings-form-fields).

### Defining payment settings form fields

The payment settings form is used to configure the payment gateway settings. The form fields are defined in a [form definition file](https://tastyigniter.com/docs/extend/forms#form-definition-file).

Here is an example of a payment gateway form definition file:

```php
return [
    'fields' => [
        'api_key' => [
            'label' => 'API Key',
        ],
        'api_secret' => [
            'label' => 'API Secret',
        ],
        'order_fee_type' => [
            'label' => 'lang:igniter.payregister::default.label_order_fee_type',
            'type' => 'radiotoggle',
            'span' => 'right',
            'cssClass' => 'flex-width',
            'default' => 1,
            'options' => [
                1 => 'lang:igniter.cart::default.menus.text_fixed_amount',
                2 => 'lang:igniter.cart::default.menus.text_percentage',
            ],
        ],
        'order_fee' => [
            'label' => 'lang:igniter.payregister::default.label_order_fee',
            'type' => 'currency',
            'span' => 'right',
            'cssClass' => 'flex-width',
            'default' => 0,
            'comment' => 'lang:igniter.payregister::default.help_order_fee',
        ],
        'order_total' => [
            'label' => 'lang:igniter.payregister::default.label_order_total',
            'type' => 'currency',
            'span' => 'left',
            'comment' => 'lang:igniter.payregister::default.help_order_total',
        ],
        'order_status' => [
            'label' => 'lang:igniter.payregister::default.label_order_status',
            'type' => 'select',
            'options' => [\Igniter\Admin\Models\Status::class, 'getDropdownOptionsForOrder'],
            'span' => 'right',
            'comment' => 'lang:igniter.payregister::default.help_order_status',
        ],
    ],
];
```

Each form field defined in the form definition file can be accessed on the payment gateway class using the `$this->model` property. For example, to get the `api_key` field value, you can use `$this->model->api_key`.

### Registering payment gateways

You can register a new payment gateway by creating an extension and implementing the `registerPaymentGateways` method in the [Extension class](https://tastyigniter.com/docs/extend/extensions#extension-class). Here is an example:

```php
public function registerPaymentGateways(): array
{
    return [
        \Author\Extension\Payments\MyPayment::class => [
            'code' => 'mypayment',
            'name' => 'My Payment',
            'description' => 'Description of my payment gateway',
        ]
    ];
}
```

The `registerPaymentGateways` method should return an array of payment gateway classes with the key as the class name and the value as an array of payment gateway definition. The payment gateway definition should include the following keys:

- `code`: A unique code for the payment gateway.
- `name`: The name of the payment gateway.
- `description`: A description of the payment gateway.

### Rendering checkout payment form

You can render the payment form on the checkout page using the `getPaymentFormViewName` method on the `Payment` model to get the payment form view name. Using the `include` blade directive, you can include the payment form view in your checkout page markup section. Pass the `$paymentMethod` payment method and `$order` order variables to the payment form view. Here is an example:

```blade
@php
    $payment = \Igniter\PayRegister\Models\Payment::getDefault();
@endphp

@include($payment->getPaymentFormViewName(), [
    'paymentMethod' => $payment,
    'order' => $order,
])
```

### Injecting asset files into the checkout page

If your payment gateway requires additional assets such as JavaScript or CSS files, you can inject these assets into the checkout page using the `beforeRenderPaymentForm` method on the payment gateway class. The method `beforeRenderPaymentForm` is called before rendering the payment form view, it accepts the host and controller as arguments. You can use the `addCss` and `addJs` methods on the controller to add CSS and JS files to the checkout page. Here is an example:

```php
public function beforeRenderPaymentForm($host, $controller): void
{
    $controller->addCss('path/to/css/file.css');
    $controller->addJs('path/to/js/file.js');
}
```

### Processing checkout payment form

When the customer submits the checkout form with the payment details, the form data is validated and passed to the `processPaymentForm` method on the payment gateway class. The payment gateway class should handle the payment processing logic, update the order status and mark the order as payment processed and return the payment response if necessary.

Here is an example of processing payment form data:

```php
public function processPaymentForm($data, $host, $order): mixed
{
    $this->validateApplicableFee($order, $host);

    $order->updateOrderStatus($this->order_status);
    $order->markAsPaymentProcessed();
}
```

If you have defined the `order_total` and `order_fee` fields, you must validate the applicable fee before processing the payment. The `validateApplicableFee` method checks if the order total is above the minimum order total specified in the payment gateway settings form. If the order total is below the specified minimum order total, an exception is thrown.

> It is recommended to call the `updateOrderStatus` and `markAsPaymentProcessed` method on the order model to update the order status to the order status specified in the payment gateway settings form and mark the order as payment processed.

#### Processing payment on the client side

There are cases where you may want to process the payment on the client side using JavaScript. You can do this by implementing the `completesPaymentOnClient` method on the payment gateway class. The method should return `true` to indicate that the payment processing is done on the client side. Here is an example:

```php
public function completesPaymentOnClient(): bool
{
    return true;
}
```

With this method implemented, the checkout form will be validated and payment handled on the client side, before the checkout form is passed to the `processPaymentForm` method on the server side.

#### Pre-authorizing payment

If you want to pre-authorize the payment to be captured later, you should add the `Igniter\PayRegister\Concerns\WithAuthorizedPayment` trait to the payment gateway class, implement the `shouldAuthorizePayment` method and define the `capture_status` field in the [payment gateway settings form](#defining-payment-settings-form-fields). Here is an example:

```php
use Igniter\PayRegister\Classes\BasePaymentGateway;
use Igniter\PayRegister\Concerns\WithAuthorizedPayment;

class MyPayment extends BasePaymentGateway
{
    use WithAuthorizedPayment;

    public function shouldAuthorizePayment(): bool
    {
        return true;
    }
}
```

In the example above, the `shouldAuthorizePayment` method returns `true` to indicate that the payment should be pre-authorized. The `capture_status` field is used to specify the order status to update the order to when the payment is captured.

#### Capturing pre-authorized payment

If you have pre-authorized a payment, the payment can be captured later by updating the order to the capture status specified in the payment gateway settings. You must implement the logic to capture the payment by overriding the `captureAuthorizedPayment` method on the payment gateway class. Here is an example:

```php
public function captureAuthorizedPayment($order): mixed
{
    $order->updateOrderStatus($this->order_status);
    $order->markAsPaymentProcessed();

    $order->logPaymentAttempt('Payment captured');
}
```

### Logging payment attempts

It is good practice to log payment attempts for auditing purposes. You can log payment attempts using the `logPaymentAttempt` method on the order model. Here is an example logging a successful payment attempt:

```php
public function processPaymentForm($data, $host, $order): mixed
{
    // ...

    $order->logPaymentAttempt('Payment processed successfully');
}
```

The `logPaymentAttempt` method accepts 5 parameters:

- `message`: _(string)_ The message to log.
- `isSuccess`: _(bool)_ Whether the payment attempt was successful. Default is `null`.
- `request`: _(array)_ The payment request. Default is `[]`.
- `response`: _(array)_ The payment response. Default is `[]`.
- `isRefundable`: _(bool)_ Whether the payment attempt is refundable. Default is `false`. See [Processing refunds](#processing-refunds).

### Handling payment errors

If an error occurs during payment processing, you can throw an exception with an error message. The error message will be displayed to the customer on the checkout page. Here is an example:

```php
public function processPaymentForm($data, $host, $order): mixed
{
    try {
        $response = $this->createClient()->createOrder($fields);

        // ...

        $order->logPaymentAttempt('Payment successful', 1, $data, $response->toArray(), true);
    } catch (Exception $ex) {
        $order->logPaymentAttempt('Payment error: '.$ex->getMessage(), 0, $data, $ex->getTrace());

        throw new ApplicationException('An error occurred while processing the payment');
    }
}
```

In the example above, the `createClient` method is used to create an order with the payment gateway. If an exception is thrown during the payment processing, the exception message is logged as a payment error and a more specific exception `ApplicationException` is thrown with an error message.

### Handling payment redirect

If the payment gateway requires a redirect to a third-party site to complete the payment, you can return a redirect response from the `processPaymentForm` method. Here is an example:

```php
public function processPaymentForm($data, $host, $order): mixed
{
    $response = $this->createClient()->createRedirect($fields);

    // ...

    return redirect()->to($response->getRedirectUrl());
}
```

### Handling off-site payment response

To handle the payment response from the payment gateway, you can define the payment return URL and redirect the customer to the payment gateway.

```php
public function registerEntryPoints(): array
{
    return [
        'my_payment_return_url' => 'processReturnUrl',
    ];
}

public function processPaymentForm($data, $host, $order): mixed
{
    $fields['return_url'] = $this->makeEntryPointUrl('my_payment_return_url').'/'.$order->hash

    $response = $this->createClient()->createRedirect($fields);

    return redirect()->to($response->getRedirectUrl());
}
```

The `registerEntryPoints` method returns an array with the key as the payment gateway redirect endpoint and the value as the method to handle the redirect. It is recommended to prefix the `my_payment_return_url` endpoint with the payment gateway code to avoid conflicts with other payment gateways.

The `makeEntryPointUrl` method on the payment gateway class is used to generate the payment gateway return URL. In the example above, the return URL is generated as `http://example.com/ti_payregister/my_payment_return_url`.

After defining the payment return url and [redirecting the customer](#handling-payment-redirect) to the payment gateway, the payment gateway will send a response to the return url after processing the payment. You can handle the payment response in the `processReturnUrl` method on the payment gateway class. Here is an example:

```php
public function processReturnUrl($params): mixed
{
    $orderHash = $params[0] ?? null;
    $redirectUrl = input('redirect');

    $order = $this->createOrderModel()->where('hash', $orderHash)->firstOrFail();

    $order->updateOrderStatus($order->payment_method->order_status);
    $order->markAsPaymentProcessed();

    return redirect()->to($redirectUrl);
}
```

### Handling payment webhook

Some payment gateways require a webhook to notify the store of payment events. You can override the `registerEntryPoints` method in the payment gateway class to register the payment gateway webhook endpoint. The `registerEntryPoints` method returns an array with the key as the payment gateway webhook endpoint and the value as the method to handle the webhook. Here is an example:

```php
public function registerEntryPoints(): array
{
    return [
        'my_payment_webhook_url' => 'processWebhook',
    ];
}
```

> It is recommended to prefix the `my_payment_webhook_url` endpoint with the payment gateway code to avoid conflicts with other payment gateways.

The `processWebhook` method should handle the payment gateway webhook and return the appropriate response code. Here is an example:

```php
public function processWebhook(): mixed
{
    return response('Webhook Handled');
}
```

### Payment profiles

Payment profiles are used to store customer payment information for future transactions. To enable payment profiles for a payment gateway, add the `Igniter\PayRegister\Concerns\WithPaymentProfile` trait to the payment gateway class and implement the `supportsPaymentProfiles` method to return `true`. Here is an example:

```php
use Igniter\PayRegister\Classes\BasePaymentGateway;
use Igniter\PayRegister\Concerns\WithPaymentProfile;

class MyPayment extends BasePaymentGateway
{
    use WithPaymentProfile;

    public function supportsPaymentProfiles(): bool
    {
        return true;
    }
}
```

#### Saving payment profile

When payment profiles are enabled, the customer can save their payment information during checkout by overriding `updatePaymentProfile` method on the payment gateway class.

Here is an example updating the payment profile when processing the checkout payment form. The `getPaymentFormFields` method is used to get the payment parameters to be sent to the payment gateway, and the `create_payment_profile` field is used to determine if the customer wants to save their payment information.

```php
public function processPaymentForm($data, $host, $order): mixed
{
    $fields = $this->getPaymentFormFields($order, $data, true);

    if (array_get($data, 'create_payment_profile', 0) == 1 && $order->customer) {
        $profile = $this->updatePaymentProfile($order->customer, $data);
        $fields['customer'] = array_get($profile->profile_data, 'customer_id');
    }

    $response = $this->createClient()->createOrder($fields);
}
```

To save the payment profile for the customer, override the `updatePaymentProfile` method and return the payment profile model instance. In the example below, the `findPaymentProfile` method is used to find the payment profile for the customer. The `createOrFetchCustomer` method is used to create or fetch the customer payment profile from the payment gateway. The payment profile data is then saved to the payment profile model.

```php
public function updatePaymentProfile($customer, $data): mixed
{
    $profile = $this->model->findPaymentProfile($customer);
    
    // Send a request to the payment gateway to fetch or create a payment profile
    $response = $this->createOrFetchCustomer();
    
    $profile->card_brand = strtolower(array_get($response, 'card.brand'));
    $profile->card_last4 = array_get($response, 'card.last4');
    $profile->setProfileData([
        'customer_id' => array_get($response, 'customer_id'),
    ]);

    return $profile;
}
```

#### Paying with payment profile

When the customer has a [saved payment profile](#saving-payment-profile), they can use the payment profile to pay for their order. You can implement the `payFromPaymentProfile` method on the payment gateway class to handle the payment processing logic using the payment profile. Here is an example:

```php
public function payFromPaymentProfile($order, $profile): mixed
{
    $host = $this->getHostObject();
    $profile = $host->findPaymentProfile($order->customer);

    if (!$profile || !$profile->hasProfileData()) {
        throw new ApplicationException('Payment profile not found');
    }

    $fields = $this->getPaymentFormFields($order);
    $fields['customer'] = array_get($profile->profile_data, 'customer_id');
    $fields['payment_method'] = array_get($profile->profile_data, 'card_id');

    $response = $this->createClient()->createOrder($fields);

    $order->updateOrderStatus($this->order_status);
    $order->markAsPaymentProcessed();

    $order->logPaymentAttempt('Payment processed successfully', 1, $fields, $response->toArray());
}
```

In the example above, the `findPaymentProfile` method is used to find the payment profile for the customer. The payment profile data is then added to the payment parameters and sent to the payment gateway to process the payment.

> It is recommended to call the `updateOrderStatus` and `markAsPaymentProcessed` method on the order model to update the order status to the order status specified in the payment gateway settings form and mark the order as payment processed.

#### Deleting payment profile

To delete a customer's payment profile, you can implement the `deletePaymentProfile` method on the payment gateway class. Set the payment profile data to an empty array to delete the payment profile. Here is an example:

```php
public function deletePaymentProfile($customer): mixed
{
    $profile = $this->model->findPaymentProfile($customer);

    if ($profile) {
        $profile->setProfileData([]);
    }
}
```

### Processing refunds

If your payment gateway supports refunds, you should enable refunds form for payment attempts by setting the `isRefundable` parameter to `true` in the `logPaymentAttempt` method when [logging payment attempts](#logging-payment-attempts). This will display a refund button next to the payment attempt in the [Payment Attempts form widget](#payment-attempts-form-widget).

Add the `Igniter\PayRegister\Concerns\WithPaymentRefund` trait to the payment gateway class and implement the `processRefundForm` method on the payment gateway class to handle the refund processing logic using the refund form data. Here is an example:

```php
use Igniter\PayRegister\Classes\BasePaymentGateway;
use Igniter\PayRegister\Concerns\WithPaymentRefund;

class MyPayment extends BasePaymentGateway
{
    use WithPaymentRefund;

    public function processRefundForm($data, $order, $paymentLog): mixed
    {
        $fields = $this->getPaymentRefundFields($order, $data);
        
        $response = $this->createGateway()->refundPayment($fields);

        $paymentLog->markAsRefundProcessed();
        $order->logPaymentAttempt('Payment refunded', 1, $data, $response->toArray());
    }
}
```

> It is recommended to call the `markAsRefundProcessed` method on the payment log model to mark the refund as processed.

### Payment attempts form widget

The Payment Attempts form widget allows you to view and manage payment attempts for an order. By default, the Payment Attempts form widget is added to the order detail page. Here is an example adding the Payment Attempts form widget to the order detail page:

```php
'paymentAttempts' => [
    'label' => 'Payment Attempts',
    'type' => 'paymentattempts',
    'useAjax' => true,
    'defaultSort' => ['payment_log_id', 'desc'],
    'form' => 'igniter.payregister::/models/paymentlog',
    'columns' => [
        'date_added_since' => [
            'title' => 'lang:igniter.cart::default.orders.column_time_date',
        ],
        'payment_name' => [
            'title' => 'lang:igniter.cart::default.orders.label_payment_method',
        ],
        'message' => [
            'title' => 'lang:igniter.cart::default.orders.column_comment',
        ],
        'is_refundable' => [
            'title' => 'Action',
            'partial' => 'igniter.payregister::_partials/refund_button',
        ],
    ],
],
```

The following options are available for the `paymentattempts` form widget type:

- `form`: _(string)_ The form definition file for the payment log model. Default is `null`.
- `useAjax`: _(bool)_ Whether to use AJAX to load the widget content. Default is `true`.  A `datatable` widget option.
- `defaultSort`: _(array)_ The default sort order for the widget. Default is `null`.  A `datatable` widget option.
- `columns`: _(array)_ The columns to use to display the payment attempts. Default is `null`. A `datatable` widget option.

See the [DataTables widget documentation](https://tastyigniter.com/docs/extend/forms#data-table) for more information on the available options.

### Permissions

The PayRegister extension registers the following permissions:

- `Admin.Payments`: Control who can manage payments in the admin area.

For more on restricting access to the admin area, see the [TastyIgniter Permissions](https://tastyigniter.com/docs/customize/permissions) documentation.

### Events

Here is an example of hooking an event in the `boot` method of an extension class:

```php
use Illuminate\Support\Facades\Event;

public function boot()
{
    Event::listen('payregister.authorizenetaim.extendGateway', function ($gateway, $client) {
        // Do something...
    });
}
```

#### Authorize.Net Events

The `Igniter\PayRegister\Payments\AuthorizeNetAim` Authorize.Net payment gateway class triggers the following events:

| Event | Description | Parameters |
| ----- | ----------- | ---------- |
| `payregister.authorizenetaim.extendGateway` | After the `Igniter\PayRegister\Classes\AuthorizeNetClient` instance is created | The gateway class instance and the `AuthorizeNetClient` instance |
| `payregister.authorizenetaim.extendAcceptRequest` | Extends the `net\authorize\api\contract\v1\CreateTransactionRequest` object used to create the accept payment request | The gateway class instance and the `CreateTransactionRequest` object |
| `payregister.authorizenetaim.extendCaptureRequest` | Extends the `net\authorize\api\contract\v1\CreateTransactionRequest` object used to create the capture payment request | The gateway class instance and the `CreateTransactionRequest` object |
| `payregister.authorizenetaim.extendRefundRequest` | Extends the `net\authorize\api\contract\v1\CreateTransactionRequest` object used to create the refund payment request | The gateway class instance and the `CreateTransactionRequest` object |

#### Mollie Events

The `Igniter\PayRegister\Payments\Mollie` Mollie payment gateway class triggers the following events:

| Event | Description | Parameters |
| ----- | ----------- | ---------- |
| `payregister.mollie.extendGateway` | After the `Mollie\Api\MollieApiClient` instance is created | The gateway class instance and the `MollieApiClient` instance |
| `payregister.mollie.extendFields` |  After the payment gateway parameters are defined  | A reference to the `&$fields` fields array, the `$order` order model instance and the `$data` checkout form data |
| `payregister.mollie.extendRefundFields` |  After the payment gateway parameters are defined  | The `$fields` fields array, the `$order` order model instance and the `$data` checkout form data |

#### PayPal Express Events

The `Igniter\PayRegister\Payments\PayPalExpress` PayPal Express payment gateway class triggers the following events:

| Event | Description | Parameters |
| ----- | ----------- | ---------- |
| `payregister.paypalexpress.extendFields` |  After the payment gateway parameters are defined | A reference to the `&$fields` fields array, the `$order` order model instance and the `$data` checkout form data |
| `payregister.paypalexpress.extendRefundFields` |  After the payment gateway parameters are defined  | The `$fields` fields array, the `$order` order model instance and the `$data` checkout form data |

#### Square Events

The `Igniter\PayRegister\Payments\Square` Square payment gateway class triggers the following events:

| Event | Description | Parameters |
| ----- | ----------- | ---------- |
| `payregister.square.extendGateway` | After the `Square\SquareClient` instance is created | The gateway class instance and the `SquareClient` instance |
| `payregister.square.extendFields` |  After the payment gateway parameters are defined  | A reference to the `&$fields` fields array, the `$order` order model instance and the `$data` checkout form data |

#### Stripe Events

The `Igniter\PayRegister\Payments\Stripe` Stripe payment gateway class triggers the following events:

| Event | Description | Parameters |
| ----- | ----------- | ---------- |
| `payregister.stripe.extendGateway` | After the `Stripe\StripeClient` instance is created | The gateway class instance and the `StripeClient` instance |
| `payregister.stripe.extendFields` |  After the payment intent parameters are defined  | A reference to the `&$fields` fields array, the `$order` order model instance and the `$data` checkout form data |
| `payregister.stripe.extendCaptureFields` |  After the capture payment parameters are defined  | The `$fields` fields array and the `$order` order model instance |
| `payregister.stripe.extendRefundFields` |  After the payment gateway parameters are defined  | The `$fields` fields array, the `$order` order model instance and the `$data` checkout form data |
| `payregister.stripe.extendOptions` |  Define additional options to pass to the payment gateway  | The gateway class instance and the `$options` options array |
| `payregister.stripe.extendJsOptions` |  Define additional options to pass to the Stripe.js library  | The gateway class instance, the `$options` options array and the `$order` order model instance |
