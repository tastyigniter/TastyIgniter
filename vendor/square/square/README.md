# Square PHP SDK

[![Build](https://github.com/square/square-php-sdk/actions/workflows/php.yml/badge.svg)](https://github.com/square/square-php-sdk/actions/workflows/php.yml)
[![PHP version](https://badge.fury.io/ph/square%2Fsquare.svg)](https://badge.fury.io/ph/square%2Fsquare)
[![Apache-2 license](https://img.shields.io/badge/license-Apache2-brightgreen.svg)](https://www.apache.org/licenses/LICENSE-2.0)

Use this library to integrate Square payments into your app and grow your business with Square APIs including Catalog, Customers, Employees, Inventory, Labor, Locations, and Orders.

* [Requirements](#requirements)
* [Installation](#installation)
* [Quickstart](#quickstart)
* [Usage](#usage)
* [Tests](#tests)
* [SDK Reference](#sdk-reference)
* [Deprecated APIs](#deprecated-apis)


## Requirements

Use of the Square PHP SDK requires:

* PHP 7.4 through PHP 8.1

## Installation

For more information, see [Set Up Your Square SDK for a PHP Project](https://developer.squareup.com/docs/sdks/php/setup-project).

## Quickstart

For more information, see [Square PHP SDK Quickstart](https://developer.squareup.com/docs/sdks/php/quick-start).

## Usage
For more information, see [Using the Square PHP SDK](https://developer.squareup.com/docs/sdks/php/using-php-sdk).

## Tests

First, clone the repo locally and `cd` into the directory.

```sh
git clone https://github.com/square/square-php-sdk.git
cd square-php-sdk
```

Next, make sure you've downloaded Composer, following the instructions [here](https://getcomposer.org/download/)
and then run the following command from the root of the repository:

```sh
composer install
```

Before running the tests, find a sandbox token in your [Developer Dashboard] and set environment variables:

```sh
export SQUARE_ACCESS_TOKEN=mytoken
export SQUARE_ENVIRONMENT=sandbox
```

Run the tests:

```sh
composer run test
```

All environment variables:
* `SQUARE_TIMEOUT` - number
* `SQUARE_NUMBER_OF_RETRIES` - number
* `SQUARE_MAXIMUM_RETRY_WAIT_TIME` - number
* `SQUARE_SQUARE_VERSION` - string
* `SQUARE_USER_AGENT_DETAIL` - string
* `SQUARE_CUSTOM_URL` - string
* `SQUARE_ACCESS_TOKEN` - string
* `SQUARE_ENVIRONMENT` - string - one of production, sandbox, custom

## SDK Reference

### Payments
* [Payments]
* [Refunds]
* [Disputes]
* [Checkout]
* [Apple Pay]
* [Cards]
* [Payouts]

### Terminal
* [Terminal]

### Orders
* [Orders]

### Subscriptions
* [Subscriptions]

### Invoices
* [Invoices]

### Items
* [Catalog]
* [Inventory]

### Customers
* [Customers]
* [Customer Custom Attributes]
* [Customer Groups]
* [Customer Segments]

### Loyalty
* [Loyalty]

### Gift Cards
* [Gift Cards]
* [Gift Card Activities]

### Bookings
* [Bookings]

### Business
* [Merchants]
* [Locations]
* [Devices]
* [Cash Drawers]
* [Vendors]

### Team
* [Team]
* [Labor]

### Financials
* [Bank Accounts]

### Online
* [Sites]
* [Snippets]

### Authorization
* [Mobile Authorization]
* [OAuth]

### Webhook Subscriptions
* [Webhook Subscriptions]
## Deprecated APIs

The following Square APIs are [deprecated](https://developer.squareup.com/docs/build-basics/api-lifecycle):

* [Employees] - replaced by the [Team] API. For more information, see [Migrate from the Employees API](https://developer.squareup.com/docs/team/migrate-from-v2-employees).
 
* [Transactions] - replaced by the [Orders] and [Payments] APIs.  For more information, see [Migrate from the Transactions API](https://developer.squareup.com/docs/payments-api/migrate-from-transactions-api).


[//]: # "Link anchor definitions"
[Square Logo]: https://docs.connect.squareup.com/images/github/github-square-logo.svg
[Developer Dashboard]: https://developer.squareup.com/apps
[Square API]: https://squareup.com/developers
[sign up for a developer account]: https://squareup.com/signup?v=developers
[Client]: doc/client.md
[Devices]: doc/apis/devices.md
[Disputes]: doc/apis/disputes.md
[Terminal]: doc/apis/terminal.md
[Cash Drawers]: doc/apis/cash-drawers.md
[Vendors]: doc/apis/vendors.md
[Customer Groups]: doc/apis/customer-groups.md
[Customer Custom Attributes]: doc/apis/customer-custom-attributes.md
[Customer Segments]: doc/apis/customer-segments.md
[Bank Accounts]: doc/apis/bank-accounts.md
[Payments]: doc/apis/payments.md
[Checkout]: doc/apis/checkout.md
[Catalog]: doc/apis/catalog.md
[Customers]: doc/apis/customers.md
[Inventory]: doc/apis/inventory.md
[Labor]: doc/apis/labor.md
[Loyalty]: doc/apis/loyalty.md
[Bookings]: doc/apis/bookings.md
[Locations]: doc/apis/locations.md
[Merchants]: doc/apis/merchants.md
[Orders]: doc/apis/orders.md
[Invoices]: doc/apis/invoices.md
[Apple Pay]: doc/apis/apple-pay.md
[Refunds]: doc/apis/refunds.md
[Subscriptions]: doc/apis/subscriptions.md
[Mobile Authorization]: doc/apis/mobile-authorization.md
[OAuth]: doc/apis/o-auth.md
[Team]: doc/apis/team.md
[Sites]: doc/apis/sites.md
[Snippets]: doc/apis/snippets.md
[Cards]: doc/apis/cards.md
[Payouts]: doc/apis/payouts.md
[Gift Cards]: doc/apis/gift-cards.md
[Gift Card Activities]: doc/apis/gift-card-activities.md
[Employees]: doc/apis/employees.md
[Transactions]: doc/apis/transactions.md
[Webhook Subscriptions]: doc/api/webhook-subscriptions.md
