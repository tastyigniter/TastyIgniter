MailChimp API
=============

Super-simple, minimum abstraction MailChimp API v3 wrapper, in PHP.

I hate complex wrappers. This lets you get from the MailChimp API docs to the code as directly as possible.

Requires PHP 5.3 and a pulse. Abstraction is for chimps.

[![Build Status](https://travis-ci.org/drewm/mailchimp-api.svg?branch=master)](https://travis-ci.org/drewm/mailchimp-api)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/drewm/mailchimp-api/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/drewm/mailchimp-api/?branch=master)
[![Packagist](https://img.shields.io/packagist/dt/drewm/mailchimp-api.svg?maxAge=2592000)](https://packagist.org/packages/drewm/mailchimp-api)

Installation
------------

You can install mailchimp-api using Composer:

```
composer require drewm/mailchimp-api
```

You will then need to:
* run ``composer install`` to get these dependencies added to your vendor directory
* add the autoloader to your application with this line: ``require("vendor/autoload.php")``

Alternatively you can just download the `MailChimp.php` file and include it manually:

```php
include('./MailChimp.php'); 
```

If you wish to use the batch request or webhook interfaces, you'll also need to download and include the `Batch.php` or `Webhook.php` files:

```php
include('./Batch.php'); 
include('./Webhook.php'); 
```

These are optional. If you're not using batches or webhooks you can just skip them. You can always come back and add them later.

Examples
--------

Start by `use`-ing the class and creating an instance with your API key

```php
use \DrewM\MailChimp\MailChimp;

$MailChimp = new MailChimp('abc123abc123abc123abc123abc123-us1');
```

Then, list all the mailing lists (with a `get` on the `lists` method)

```php
$result = $MailChimp->get('lists');

print_r($result);
```

Subscribe someone to a list (with a `post` to the `lists/{listID}/members` method):

```php
$list_id = 'b1234346';

$result = $MailChimp->post("lists/$list_id/members", [
				'email_address' => 'davy@example.com',
				'status'        => 'subscribed',
			]);

print_r($result);
```

Update a list member with more information (using `patch` to update):

```php
$list_id = 'b1234346';
$subscriber_hash = MailChimp::subscriberHash('davy@example.com');

$result = $MailChimp->patch("lists/$list_id/members/$subscriber_hash", [
				'merge_fields' => ['FNAME'=>'Davy', 'LNAME'=>'Jones'],
				'interests'    => ['2s3a384h' => true],
			]);

print_r($result);
```

Remove a list member using the `delete` method:

```php
$list_id = 'b1234346';
$subscriber_hash = MailChimp::subscriberHash('davy@example.com');

$MailChimp->delete("lists/$list_id/members/$subscriber_hash");
```

Quickly test for a successful action with the `success()` method:

```php
$list_id = 'b1234346';

$result = $MailChimp->post("lists/$list_id/members", [
				'email_address' => 'davy@example.com',
				'status'        => 'subscribed',
			]);

if ($MailChimp->success()) {
	print_r($result);	
} else {
	echo $MailChimp->getLastError();
}
```

Batch Operations
----------------

The MailChimp [Batch Operations](http://developer.mailchimp.com/documentation/mailchimp/guides/how-to-use-batch-operations/) functionality enables you to complete multiple operations with a single call. A good example is adding thousands of members to a list - you can perform this in one request rather than thousands.

```php
use \DrewM\MailChimp\MailChimp;
use \DrewM\MailChimp\Batch;

$MailChimp = new MailChimp('abc123abc123abc123abc123abc123-us1');
$Batch 	   = $MailChimp->new_batch();
```

You can then make requests on the `Batch` object just as you would normally with the `MailChimp` object. The difference is that you need to set an ID for the operation as the first argument, and also that you won't get a response. The ID is used for finding the result of this request in the combined response from the batch operation.

```php
$Batch->post("op1", "lists/$list_id/members", [
				'email_address' => 'micky@example.com',
				'status'        => 'subscribed',
			]);

$Batch->post("op2", "lists/$list_id/members", [
				'email_address' => 'michael@example.com',
				'status'        => 'subscribed',
			]);

$Batch->post("op3", "lists/$list_id/members", [
				'email_address' => 'peter@example.com',
				'status'        => 'subscribed',
			]);
```

Once you've finished all the requests that should be in the batch, you need to execute it.

```php
$result = $Batch->execute();
```

The result includes a batch ID. At a later point, you can check the status of your batch:

```php
$MailChimp->new_batch($batch_id);
$result = $Batch->check_status();
```

When your batch is finished, you can download the results from the URL given in the response. In the JSON, the result of each operation will be keyed by the ID you used as the first argument for the request.

Webhooks
--------

**Note:** Use of the Webhooks functionality requires at least PHP 5.4.

MailChimp [webhooks](http://kb.mailchimp.com/integrations/other-integrations/how-to-set-up-webhooks) enable your code to be notified of changes to lists and campaigns.

When you set up a webhook you specify a URL on your server for the data to be sent to. This wrapper's Webhook class helps you catch that incoming webhook in a tidy way. It uses a subscription model, with your code subscribing to whichever webhook events it wants to listen for. You provide a callback function that the webhook data is passed to.

To listen for the `unsubscribe` webhook:

```php
use \DrewM\MailChimp\Webhook;

Webhook::subscribe('unsubscribe', function($data){
	print_r($data);
});
```

At first glance the _subscribe/unsubscribe_ looks confusing - your code is subscribing to the MailChimp `unsubscribe` webhook event. The callback function is passed as single argument - an associative array containing the webhook data.

If you'd rather just catch all webhooks and deal with them yourself, you can use:

```php
use \DrewM\MailChimp\Webhook;

$result = Webhook::receive();
print_r($result);
```

There doesn't appear to be any documentation for the content of the webhook data. It's helpful to use something like [ngrok](https://ngrok.com) for tunneling the webhooks to your development machine - you can then use its web interface to inspect what's been sent and to replay incoming webhooks while you debug your code.

Troubleshooting
---------------

To get the last error returned by either the HTTP client or by the API, use `getLastError()`:

```php
echo $MailChimp->getLastError();
```

For further debugging, you can inspect the headers and body of the response:

```php
print_r($MailChimp->getLastResponse());
```

If you suspect you're sending data in the wrong format, you can look at what was sent to MailChimp by the wrapper:

```php
print_r($MailChimp->getLastRequest());
```

If your server's CA root certificates are not up to date you may find that SSL verification fails and you don't get a response. The correction solution for this [is not to disable SSL verification](http://snippets.webaware.com.au/howto/stop-turning-off-curlopt_ssl_verifypeer-and-fix-your-php-config/). The solution is to update your certificates. If you can't do that, there's an option at the top of the class file. Please don't just switch it off without at least attempting to update your certs -- that's lazy and dangerous. You're not a lazy, dangerous developer are you?

If you have **high-level implementation questions about your project** ("How do I add this to WordPress", "I've got a form that takes an email address...") please **take them to somewhere like StackOverflow**. If you think you've found a bug, or would like to discuss a change or improvement, feel free to raise an issue and we'll figure it out between us.

Contributing
------------

This is a fairly simple wrapper, but it has been made much better by contributions from those using it. If you'd like to suggest an improvement, please raise an issue to discuss it before making your pull request.

Pull requests for bugs are more than welcome - please explain the bug you're trying to fix in the message.

There are a small number of PHPUnit unit tests. To get up and running, copy `.env.example` to `.env` and add your API key details. Unit testing against an API is obviously a bit tricky, but I'd welcome any contributions to this. It would be great to have more test coverage.
