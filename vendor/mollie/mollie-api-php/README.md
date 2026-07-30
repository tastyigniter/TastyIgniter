<p align="center">
  <img src="https://github.com/mollie/mollie-api-php/assets/7265703/140510a5-ede5-41bf-9d77-0d09b906e8f4" width="128" height="128"/>
</p>

<h1 align="center">Mollie API client for PHP</h1>

![mollie-api-php-header](https://github.com/mollie/mollie-api-php/assets/7265703/e79b7770-fe00-4dfe-bb8b-3d5ed221e329)

Accepting [iDEAL](https://www.mollie.com/payments/ideal/), [Apple Pay](https://www.mollie.com/payments/apple-pay), [Bancontact](https://www.mollie.com/payments/bancontact/), [SOFORT Banking](https://www.mollie.com/payments/sofort/), [Creditcard](https://www.mollie.com/payments/credit-card/), [SEPA Bank transfer](https://www.mollie.com/payments/bank-transfer/), [SEPA Direct debit](https://www.mollie.com/payments/direct-debit/), [PayPal](https://www.mollie.com/payments/paypal/), [Belfius Direct Net](https://www.mollie.com/payments/belfius/), [KBC/CBC](https://www.mollie.com/payments/kbc-cbc/), [paysafecard](https://www.mollie.com/payments/paysafecard/), [ING Home'Pay](https://www.mollie.com/payments/ing-homepay/), [Giropay](https://www.mollie.com/payments/giropay/), [EPS](https://www.mollie.com/payments/eps/), [Przelewy24](https://www.mollie.com/payments/przelewy24/), [Postepay](https://www.mollie.com/en/payments/postepay), [In3](https://www.mollie.com/payments/in3/), [Klarna](https://www.mollie.com/payments/klarna-pay-later/) ([Pay now](https://www.mollie.com/payments/klarna-pay-now/), [Pay later](https://www.mollie.com/payments/klarna-pay-later/), [Slice it](https://www.mollie.com/payments/klarna-slice-it/), [Pay in 3](https://www.mollie.com/payments/klarna-pay-in-3/)), [Giftcard](https://www.mollie.com/payments/gift-cards/) and [Voucher](https://www.mollie.com/en/payments/meal-eco-gift-vouchers) online payments without fixed monthly costs or any punishing registration procedures. Just use the Mollie API to receive payments directly on your website or easily refund transactions to your customers.

[![Build Status](https://github.com/mollie/mollie-api-php/workflows/tests/badge.svg)](https://github.com/mollie/mollie-api-php/actions)
[![Latest Stable Version](https://poser.pugx.org/mollie/mollie-api-php/v/stable)](https://packagist.org/packages/mollie/mollie-api-php)
[![Total Downloads](https://poser.pugx.org/mollie/mollie-api-php/downloads)](https://packagist.org/packages/mollie/mollie-api-php)

## Requirements ##
To use the Mollie API client, the following things are required:

+ Get yourself a free [Mollie account](https://www.mollie.com/signup). No sign up costs.
+ Now you're ready to use the Mollie API client in test mode.
+ Follow [a few steps](https://www.mollie.com/dashboard/?modal=onboarding) to enable payment methods in live mode, and let us handle the rest.
+ PHP >= 7.2
+ Up-to-date OpenSSL (or other SSL/TLS toolkit)

For leveraging [Mollie Connect](https://docs.mollie.com/oauth/overview) (advanced use cases only), we recommend also installing our [OAuth2 client](https://github.com/mollie/oauth2-mollie-php).

## Installation ##
### Using Composer ###

The easiest way to install the Mollie API client is by using [Composer](http://getcomposer.org/doc/00-intro.md). You can require it with the following command:

```bash
composer require mollie/mollie-api-php
```

To work with the most recent API version, ensure that you are using a version of this API client that is equal to or greater than 2.0.0. If you prefer to continue using the v1 API, make sure your client version is below 2.0.0. For guidance on transitioning from v1 to v2, please refer to the [migration notes](https://docs.mollie.com/docs/migrating-from-v1-to-v2).

### Manual Installation ###
If you're not familiar with using composer we've added a ZIP file to the releases containing the API client and all the packages normally installed by composer.
Download the ``mollie-api-php.zip`` from the [releases page](https://github.com/mollie/mollie-api-php/releases).

Include the ``vendor/autoload.php`` as shown in [Initialize example](https://github.com/mollie/mollie-api-php/blob/master/examples/initialize.php).

## Usage ##

Initializing the Mollie API client, and setting your API key.

```php
$mollie = new \Mollie\Api\MollieApiClient();
$mollie->setApiKey("test_dHar4XY7LxsDOtmnkVtjNVWXLSlXsM");
```

With the `MollieApiClient` you can now access any of the following endpoints by selecting them as a property of the client:

| API | Resource | Code             | Link to Endpoint file                                                            |
| -----------------------  | -----------------------  | --------------------------  | --------------------------------------------------------------------------  |
| **[Balances API](https://docs.mollie.com/reference/v2/balances-api/overview)**       | Balance | `$mollie->balances`        | [BalanceEndpoint](https://github.com/mollie/mollie-api-php/blob/master/src/Endpoints/BalanceEndpoint.php)            |
| | Balance Report | `$mollie->balanceReports`  | [BalanceReportEndpoint](https://github.com/mollie/mollie-api-php/blob/master/src/Endpoints/BalanceReportEndpoint.php) |
| | Balance Transaction | `$mollie->balanceTransactions` | [BalanceTransactionEndpoint](https://github.com/mollie/mollie-api-php/blob/master/src/Endpoints/BalanceTransactionEndpoint.php) |
| **[Chargebacks API](https://docs.mollie.com/reference/v2/chargebacks-api/overview)** | Chargeback |`$mollie->chargebacks` | [ChargebackEndpoint](https://github.com/mollie/mollie-api-php/blob/master/src/Endpoints/ChargebackEndpoint.php) |
| | Payment Chargeback | `$mollie->paymentChargebacks` | [PaymentChargebackEndpoint](https://github.com/mollie/mollie-api-php/blob/master/src/Endpoints/PaymentChargebackEndpoint.php) |
| **[Clients API](https://docs.mollie.com/reference/v2/clients-api/overview)** | Client | `$mollie->clients` | [ClientEndpoint](https://github.com/mollie/mollie-api-php/blob/master/src/Endpoints/ClientEndpoint.php) |
| **[Client Links API](https://docs.mollie.com/reference/v2/client-links-api/overview)** | Client Link | `$mollie->clientLinks` | [ClientLinkEndpoint](https://github.com/mollie/mollie-api-php/blob/master/src/Endpoints/ClientLinkEndpoint.php) |
| **[Customers API](https://docs.mollie.com/reference/v2/customers-api/overview)** | Customer | `$mollie->customers` | [CustomerEndpoint](https://github.com/mollie/mollie-api-php/blob/master/src/Endpoints/CustomerEndpoint.php) |
| | Customer Payment | `$mollie->customerPayments` | [CustomerPaymentsEndpoint](https://github.com/mollie/mollie-api-php/blob/master/src/Endpoints/CustomerPaymentsEndpoint.php) |
| **[Invoices API](https://docs.mollie.com/reference/v2/invoices-api/overview)** | Invoice | `$mollie->invoices` | [InvoiceEndpoint](https://github.com/mollie/mollie-api-php/blob/master/src/Endpoints/InvoiceEndpoint.php) |
| **[Mandates API](https://github.com/mollie/mollie-api-php/blob/master/src/Endpoints/MandateEndpoint.php)** | Mandate | `$mollie->mandates` | [MandateEndpoint](https://github.com/mollie/mollie-api-php/blob/master/src/Endpoints/MandateEndpoint.php) |
| **[Methods API](https://docs.mollie.com/reference/v2/methods-api/overview)** | Payment Method | `$mollie->methods` | [MethodEndpoint](https://github.com/mollie/mollie-api-php/blob/master/src/Endpoints/MethodEndpoint.php) |
| **[Onboarding API](https://docs.mollie.com/reference/v2/onboarding-api/overview)** | Onboarding |`$mollie->onboarding` | [OnboardingEndpoint](https://github.com/mollie/mollie-api-php/blob/master/src/Endpoints/OnboardingEndpoint.php) |
| **[Orders API](https://docs.mollie.com/reference/v2/orders-api/overview)** | Order | `$mollie->orders` | [OrderEndpoint](https://github.com/mollie/mollie-api-php/blob/master/src/Endpoints/OrderEndpoint.php) |
| | Order Line | `$mollie->orderLines` | [OrderLineEndpoint](https://github.com/mollie/mollie-api-php/blob/master/src/Endpoints/OrderLineEndpoint.php) |
| | Order Payment | `$mollie->orderPayments` | [OrderPaymentEndpoint](https://github.com/mollie/mollie-api-php/blob/master/src/Endpoints/OrderPaymentEndpoint.php) |
| **[Organizations API](https://docs.mollie.com/reference/v2/organizations-api/overview)** | Organization | `$mollie->organizations` | [OrganizationEndpoint](https://github.com/mollie/mollie-api-php/blob/master/src/Endpoints/OrganizationEndpoint.php) |
| | Organization Partner | `$mollie->organizationPartners` | [OrganizationPartnerEndpoint](https://github.com/mollie/mollie-api-php/blob/master/src/Endpoints/OrganizationPartnerEndpoint.php) |
| **[Captures API](https://docs.mollie.com/reference/v2/captures-api/overview)** | Payment Captures | `$mollie->organizations` | [PaymentCaptureEndpoint](https://github.com/mollie/mollie-api-php/blob/master/src/Endpoints/PaymentCaptureEndpoint.php) |
| **[Payments API](https://docs.mollie.com/reference/v2/payments-api/overview)** | Payment | `$mollie->payments` | [PaymentEndpoint](https://github.com/mollie/mollie-api-php/blob/master/src/Endpoints/PaymentEndpoint.php) |
| | Payment Route | `$mollie->paymentRoutes` | [PaymentRouteEndpoint](https://github.com/mollie/mollie-api-php/blob/master/src/Endpoints/PaymentRouteEndpoint.php) |
| **[Payment links API](https://docs.mollie.com/reference/v2/payment-links-api/overview)** | Payment Link | `$mollie->paymentLinks` | [PaymentLinkEndpoint](https://github.com/mollie/mollie-api-php/blob/master/src/Endpoints/PaymentLinkEndpoint.php) |
| **[Permissions API](https://docs.mollie.com/reference/v2/permissions-api/overview)** | Permission | `$mollie->permissions` | [PermissionEndpoint](https://github.com/mollie/mollie-api-php/blob/master/src/Endpoints/PermissionEndpoint.php) |
| **[Profile API](https://docs.mollie.com/reference/v2/profiles-api/overview)** | Profile | `$mollie->profiles` | [ProfileEndpoint](https://github.com/mollie/mollie-api-php/blob/master/src/Endpoints/ProfileEndpoint.php) |
| | Profile Method | `$mollie->profileMethods` | [ProfileMethodEndpoint](https://github.com/mollie/mollie-api-php/blob/master/src/Endpoints/ProfileMethodEndpoint.php) |
| **[Refund API](https://docs.mollie.com/reference/v2/refunds-api/overview)** | Refund | `$mollie->refunds` | [RefundEndpoint](https://github.com/mollie/mollie-api-php/blob/master/src/Endpoints/RefundEndpoint.php) |
| | Order Refund | `$mollie->orderRefunds` | [OrderRefundEndpoint](https://github.com/mollie/mollie-api-php/blob/master/src/Endpoints/OrderRefundEndpoint.php) |
| | Payment Refund | `$mollie->paymentRefunds` | [PaymentRefundEndpoint](https://github.com/mollie/mollie-api-php/blob/master/src/Endpoints/PaymentRefundEndpoint.php) |
| **[Settlements API](https://docs.mollie.com/reference/v2/settlements-api/overview)** | Settlement | `$mollie->settlements` | [SettlementsEndpoint](https://github.com/mollie/mollie-api-php/blob/master/src/Endpoints/SettlementsEndpoint.php) |
| | Settlement Capture | `$mollie->settlementCaptures` | [SettlementCaptureEndpoint](https://github.com/mollie/mollie-api-php/blob/master/src/Endpoints/SettlementCaptureEndpoint.php) |
| | Settlement Chargeback | `$mollie->settlementChargebacks` | [SettlementChargebackEndpoint](https://github.com/mollie/mollie-api-php/blob/master/src/Endpoints/SettlementChargebackEndpoint.php) |
| | Settlement Payment | `$mollie->settlementPayments` | [SettlementPaymentEndpoint](https://github.com/mollie/mollie-api-php/blob/master/src/Endpoints/SettlementPaymentEndpoint.php) |
| | Settlement Refund | `$mollie->settlementRefunds` | [SettlementRefundEndpoint](https://github.com/mollie/mollie-api-php/blob/master/src/Endpoints/SettlementRefundEndpoint.php) |
| **[Shipments API](https://docs.mollie.com/reference/v2/shipments-api/overview)** | Shipment | `$mollie->shipments` | [ShipmentEndpoint](https://github.com/mollie/mollie-api-php/blob/master/src/Endpoints/ShipmentEndpoint.php) |
| **[Subscriptions API](https://docs.mollie.com/reference/v2/subscriptions-api/overview)** | Subscription | `$mollie->subscriptions` | [SubscriptionEndpoint](https://github.com/mollie/mollie-api-php/blob/master/src/Endpoints/SubscriptionEndpoint.php) |
| **[Terminal API](https://docs.mollie.com/reference/v2/terminals-api/overview)** | Terminal | `$mollie->terminals` | [TerminalEndpoint](https://github.com/mollie/mollie-api-php/blob/master/src/Endpoints/TerminalEndpoint.php) |
| **[Wallets API](https://docs.mollie.com/reference/v2/wallets-api/overview)** | Wallet | `$mollie->wallets` | [WalletEndpoint](https://github.com/mollie/mollie-api-php/blob/master/src/Endpoints/WalletEndpoint.php) |

Find our full documentation online on [docs.mollie.com](https://docs.mollie.com).

### Orders ###
#### Creating Orders ####
**[Create Order reference](https://docs.mollie.com/reference/v2/orders-api/create-order)**

```php
$order = $mollie->orders->create([
    "amount" => [
        "value" => "1027.99",
        "currency" => "EUR",
    ],
    "billingAddress" => [
        "streetAndNumber" => "Keizersgracht 313",
        "postalCode" => "1016 EE",
        "city" => "Amsterdam",
        "country" => "nl",
        "givenName" => "Luke",
        "familyName" => "Skywalker",
        "email" => "luke@skywalker.com",
    ],
    "shippingAddress" => [
        "streetAndNumber" => "Keizersgracht 313",
        "postalCode" => "1016 EE",
        "city" => "Amsterdam",
        "country" => "nl",
        "givenName" => "Luke",
        "familyName" => "Skywalker",
        "email" => "luke@skywalker.com",
    ],
    "metadata" => [
        "some" => "data",
    ],
    "consumerDateOfBirth" => "1958-01-31",
    "locale" => "en_US",
    "orderNumber" => "1234",
    "redirectUrl" => "https://your_domain.com/return?some_other_info=foo",
    "webhookUrl" => "https://your_domain.com/webhook",
    "method" => "ideal",
    "lines" => [
        [
            "sku" => "5702016116977",
            "name" => "LEGO 42083 Bugatti Chiron",
            "productUrl" => "https://shop.lego.com/nl-NL/Bugatti-Chiron-42083",
            "imageUrl" => 'https://sh-s7-live-s.legocdn.com/is/image//LEGO/42083_alt1?$main$',
            "quantity" => 2,
            "vatRate" => "21.00",
            "unitPrice" => [
                "currency" => "EUR",
                "value" => "399.00",
            ],
            "totalAmount" => [
                "currency" => "EUR",
                "value" => "698.00",
            ],
            "discountAmount" => [
                "currency" => "EUR",
                "value" => "100.00",
            ],
            "vatAmount" => [
                "currency" => "EUR",
                "value" => "121.14",
            ],
        ],
        // more order line items
    ],
]);
```

_After creation, the order id is available in the `$order->id` property. You should store this id with your order._

After storing the order id you can send the customer off to complete the order payment using `$order->getCheckoutUrl()`.

```php
header("Location: " . $order->getCheckoutUrl(), true, 303);
```

_This header location should always be a GET, thus we enforce 303 http response code_

For an order create example, see [Example - New Order](https://github.com/mollie/mollie-api-php/blob/master/examples/orders/create-order.php).

#### Updating Orders ####
**[Update Order Documentation](https://docs.mollie.com/reference/v2/orders-api/update-order)**

```php
$order = $mollie->orders->get("ord_kEn1PlbGa");
$order->billingAddress->organizationName = "Mollie B.V.";
$order->billingAddress->streetAndNumber = "Keizersgracht 126";
$order->billingAddress->city = "Amsterdam";
$order->billingAddress->region = "Noord-Holland";
$order->billingAddress->postalCode = "1234AB";
$order->billingAddress->country = "NL";
$order->billingAddress->title = "Dhr";
$order->billingAddress->givenName = "Piet";
$order->billingAddress->familyName = "Mondriaan";
$order->billingAddress->email = "piet@mondriaan.com";
$order->billingAddress->phone = "+31208202070";
$order->update();
```

#### Refunding Orders ####
##### Complete #####
```php
$order = $mollie->orders->get('ord_8wmqcHMN4U');
$refund = $order->refundAll();

echo 'Refund ' . $refund->id . ' was created for order ' . $order->id;
```

##### Partially #####
When executing a partial refund you have to list all order line items that should be refunded.

```php
$order = $mollie->orders->get('ord_8wmqcHMN4U');
$refund = $order->refund([
    'lines' => [
        [
            'id' => 'odl_dgtxyl',
            'quantity' => 1,
        ],
    ],
    "description" => "Required quantity not in stock, refunding one photo book.",
]);
```

#### Cancel Orders ####
**[Cancel Order Documentation](https://docs.mollie.com/reference/v2/orders-api/cancel-order)**

_When canceling an order it is crucial to check if the order is cancelable before executing the cancel action. For more information see the [possible order statuses](https://docs.mollie.com/orders/status-changes#possible-statuses-for-orders)._

```php
$order = $mollie->orders->get("ord_pbjz8x");

if ($order->isCancelable) {
    $canceledOrder = $order->cancel();
    echo "Your order " . $order->id . " has been canceled.";
} else {
    echo "Unable to cancel your order " . $order->id . ".";
}
```

#### Order webhook ####
When the order status changes, the `webhookUrl` you specified during order creation will be called. You can use the `id` from the POST parameters to check the status and take appropriate actions. For more details, refer to [Example - Webhook](https://github.com/mollie/mollie-api-php/blob/master/examples/orders/webhook.php).

### Payments ###
#### Payment Reception Process ####
**[Payment Reception Process documentation](https://docs.mollie.com/payments/accepting-payments#working-with-the-payments-api)**

To ensure a successful payment reception, you should follow these steps:

1. Utilize the Mollie API client to initiate a payment. Specify the desired amount, currency, description, and optionally, a payment method. It's crucial to define a unique redirect URL where the customer should be directed after completing the payment.

2. Immediately upon payment completion, our platform will initiate an asynchronous request to the configured webhook. This enables you to retrieve payment details, ensuring you know precisely when to commence processing the customer's order.

3. The customer is redirected to the URL from step (1) and should be pleased to find that the order has been paid and is now in the processing stage.


#### Creating Payments ####
**[Create Payment Documentation](https://docs.mollie.com/reference/v2/payments-api/create-payment)**

```php
$payment = $mollie->payments->create([
    "amount" => [
        "currency" => "EUR",
        "value" => "10.00"
    ],
    "description" => "My first API payment",
    "redirectUrl" => "https://webshop.example.org/order/12345/",
    "webhookUrl"  => "https://webshop.example.org/mollie-webhook/",
]);
```
_After creation, the payment id is available in the `$payment->id` property. You should store this id with your order._

After storing the payment id you can send the customer to the checkout using `$payment->getCheckoutUrl()`.

```php
header("Location: " . $payment->getCheckoutUrl(), true, 303);
```

_This header location should always be a GET, thus we enforce 303 http response code_

For a payment create example, see [Example - New Payment](https://github.com/mollie/mollie-api-php/blob/master/examples/payments/create-payment.php).

##### Multicurrency #####
Since API v2.0 it is now possible to create non-EUR payments for your customers.
A full list of available currencies can be found [in our documentation](https://docs.mollie.com/guides/multicurrency).

```php
$payment = $mollie->payments->create([
    "amount" => [
        "currency" => "USD",
        "value" => "10.00"
    ],
    //...
]);
```
_After creation, the `settlementAmount` will contain the EUR amount that will be settled on your account._

##### Create fully integrated iDEAL payments #####
To fully integrate iDEAL payments on your website, follow these additional steps:

1. Retrieve the list of issuers (banks) that support iDEAL.

```php
$method = $mollie->methods->get(\Mollie\Api\Types\PaymentMethod::IDEAL, ["include" => "issuers"]);
```

Use the `$method->issuers` list to let the customer pick their preferred issuer.

_`$method->issuers` will be a list of objects. Use the property `$id` of this object in the
 API call, and the property `$name` for displaying the issuer to your customer._

2. Create a payment with the selected issuer:

```php
$payment = $mollie->payments->create([
    "amount" => [
        "currency" => "EUR",
        "value" => "10.00"
    ],
    "description" => "My first API payment",
    "redirectUrl" => "https://webshop.example.org/order/12345/",
    "webhookUrl"  => "https://webshop.example.org/mollie-webhook/",
    "method"      => \Mollie\Api\Types\PaymentMethod::IDEAL,
    "issuer"      => $selectedIssuerId, // e.g. "ideal_INGBNL2A"
]);
```

_The `_links` property of the `$payment` object will contain an object `checkout` with a `href` property, which is a URL that points directly to the online banking environment of the selected issuer.
A short way of retrieving this URL can be achieved by using the `$payment->getCheckoutUrl()`._

For a more in-depth example, see [Example - iDEAL payment](https://github.com/mollie/mollie-api-php/blob/master/examples/payments/create-ideal-payment.php).

#### Retrieving Payments ####
**[Retrieve Payment Documentation](https://docs.mollie.com/reference/v2/payments-api/get-payment)**

We can use the `$payment->id` to retrieve a payment and check if the payment `isPaid`.

```php
$payment = $mollie->payments->get($payment->id);

if ($payment->isPaid())
{
    echo "Payment received.";
}
```

Or retrieve a collection of payments.

```php
$payments = $mollie->payments->page();
```

For an extensive example of listing payments with the details and status, see [Example - List Payments](https://github.com/mollie/mollie-api-php/blob/master/examples/payments/list-payments.php).

#### Refunding payments ####
**[Refund Payment Documentation](https://docs.mollie.com/reference/v2/refunds-api/create-payment-refund)**

Our API provides support for refunding payments. It's important to note that there is no confirmation step, and all refunds are immediate and final. Refunds are available for all payment methods except for paysafecard and gift cards.

```php
$payment = $mollie->payments->get($payment->id);

// Refund € 2 of this payment
$refund = $payment->refund([
    "amount" => [
        "currency" => "EUR",
        "value" => "2.00"
    ]
]);
```

#### Payment webhook ####
When the payment status changes, the `webhookUrl` you specified during payment creation will be called. You can use the `id` from the POST parameters to check the status and take appropriate actions. For more details, refer to [Example - Webhook](https://github.com/mollie/mollie-api-php/blob/master/examples/payments/webhook.php).

For a working example, see [Example - Refund payment](https://github.com/mollie/mollie-api-php/blob/master/examples/payments/refund-payment.php).

### Enabling debug mode ###

When troubleshooting, it can be highly beneficial to have access to the submitted request within the `ApiException`. To safeguard against inadvertently exposing sensitive request data in your local application logs, the debugging feature is initially turned off.

To enable debugging and inspect the request:

```php
/** @var $mollie \Mollie\Api\MollieApiClient */
$mollie->enableDebugging();

try {
    $mollie->payments->get('tr_12345678');
} catch (\Mollie\Api\Exceptions\ApiException $exception) {
    $request = $exception->getRequest();
}
```

If you are recording instances of `ApiException`, the request details will be included in the logs. It is vital to ensure that no sensitive information is retained within these logs and to perform cleanup after debugging is complete.

To disable debugging again:

```php
/** @var $mollie \Mollie\Api\MollieApiClient */
$mollie->disableDebugging();
```

Please note that debugging is only available when using the default Guzzle http adapter (`Guzzle6And7MollieHttpAdapter`).

## API documentation ##
For an in-depth understanding of our API, please explore the [Mollie Developer Portal](https://www.mollie.com/developers). Our API documentation is available in English.

## Contributing to Our API Client ##
Would you like to contribute to improving our API client? We welcome [pull requests](https://github.com/mollie/mollie-api-php/pulls?utf8=%E2%9C%93&q=is%3Apr). But, if you're interested in contributing to a technology-focused organization, Mollie is actively recruiting developers and system engineers. Discover our current [job openings](https://jobs.mollie.com/) or [reach out](mailto:personeel@mollie.com).

## License ##
[BSD (Berkeley Software Distribution) License](https://opensource.org/licenses/bsd-license.php).
Copyright (c) 2013-2018, Mollie B.V.

## Support ##
Contact: [www.mollie.com](https://www.mollie.com) — info@mollie.com — +31 20 820 20 70
