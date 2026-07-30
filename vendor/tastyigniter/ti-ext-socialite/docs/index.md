---
title: "Socialite"
section: "extensions"
sortOrder: 100
---

## Installation

You can install the extension via composer using the following command:

```bash
composer require tastyigniter/ti-ext-socialite -W
```

Run the database migrations to create the required tables:
  
```bash
php artisan igniter:up
```

## Getting started

To enable each social network that you would like to use, you need to configure the required settings in the admin area. Navigate to _Manage > Settings > Configure Social Login Providers_. Follow the instructions given below for each social network you would like to use.

## Usage

This section covers how to integrate the Socialite extension into your own extension if you need to create social login providers, render social login links, handle provider redirects, and handle provider callbacks. The Socialite extension provides a simple API for managing social login providers.

### Defining providers

A socialite provider class is responsible for building the settings form, setting the required configuration values,
redirecting and handling callbacks from the provider. The provider class should extend the `Igniter\Socialite\Classes\BaseProvider` class and implement the following methods: `extendSettingsForm`, `redirectToProvider`, `handleProviderCallback`.

```php
use Igniter\Admin\Widgets\Form;
use Igniter\Socialite\Classes\BaseProvider;
use Laravel\Socialite\Two\FacebookProvider;
use Laravel\Socialite\Facades\Socialite;

class Facebook extends BaseProvider
{
    protected $provider = FacebookProvider::class;

    public function extendSettingsForm(Form $form)
    {
        $form->addFields([
            ...
        ], 'primary');
    }

    public function redirectToProvider()
    {
        return Socialite::driver($this->driver)->scopes(['email'])->redirect();
    }

    public function handleProviderCallback()
    {
        return Socialite::driver($this->driver)->user();
    }
}
```

### Defining provider settings form fields

The `extendSettingsForm` method is used to define the settings form fields for the provider. The method receives a `Form` object as an argument, which can be used to add fields to the form.

```php
public function extendSettingsForm(Form $form)
{
    $form->addFields([
        'providers[facebook][setup]' => [
            'type' => 'partial',
            'path' => 'igniter.socialite::facebook.info',
            'tab' => 'Facebook',
        ],
        'providers[facebook][status]' => [
            'label' => 'Status',
            'type' => 'switch',
            'default' => true,
            'span' => 'left',
            'tab' => 'Facebook',
        ],
        'providers[facebook][client_id]' => [
            'label' => 'App ID',
            'type' => 'text',
            'tab' => 'Facebook',
        ],
        'providers[facebook][client_secret]' => [
            'label' => 'App Secret',
            'type' => 'text',
            'tab' => 'Facebook',
        ],
    ], 'primary');
}
```

Each field in the settings form should have a unique key and should be added to the `providers` array with the provider name as the key.

### Registering providers

To register a socialite provider, you need to define a `registerSocialiteProviders` method on your extension class. The method should return an array of  provider classes as keys and their configuration as values.

```php
public function registerSocialiteProviders()
{
    return [
        \Igniter\Socialite\SocialiteProviders\Facebook::class => [
            'code' => 'facebook',
            'label' => 'Facebook',
            'description' => 'Log in with Facebook',
        ],
    ];
}
```

In this example, the `Facebook` provider will be registered with the alias `facebook`. The `label` and `description` keys are used to display the provider in the settings form.

### Rendering social login links

To render social login links on your login page, you can use the `listProviderLinks` method on the `Igniter\Socialite\Classes\ProviderManager` class. The method returns an array of socialite providers with their respective login URLs.

```php
use Igniter\Socialite\Classes\ProviderManager;

$providerLinks = resolve(ProviderManager::class)->listProviderLinks();
```

You can then loop through the provider links and render the login links on your blade view.

```blade
@foreach($providerLinks as $code => $url)
    <a href="{{ $url."?success={$successPage}&error={$errorPage}" }}"><i class="fab fa-{{ $code }}"></i></a>
@endforeach
```

### Handling provider redirects

To redirect the user to the provider login page, you can override the `redirectToProvider` method on the provider class. The method should return the redirect response from the socialite driver.

```php
public function redirectToProvider()
{
    return Socialite::driver($this->driver)->redirect();
}
```

### Handling provider callbacks

To handle the callback from the provider, you can override the `handleProviderCallback` method on the provider class. The method should return the user details from the socialite driver.

```php
public function handleProviderCallback()
{
    return Socialite::driver($this->driver)->user();
}
```

The `name` and `email` fields returned by the provider are automatically used to register a new user if one does not already exist. The user is then logged in and redirected to their account page.

### Confirming user email address

You may want to confirm the user's email address before creating a new user account. Or you may want to allow the user specify their email address if it is not provided by the socialite provider. You can do this by overriding the `shouldConfirmEmail` method on the `Igniter\Socialite\Classes\ProviderManager` class and returning `true`. The method receives the provider user instance as an argument.

```php
public function shouldConfirmEmail($providerUser)
{
    return true;
}
```

When the `shouldConfirmEmail` method returns `true`, the user will be redirected to the email confirmation page after logging in with a socialite provider. The user can then confirm their email address or specify a new email address.

### The email confirmation page

The email confirmation page is used to confirm the user's email address or specify a new email address. The page should contain a form with an email field and a submit button. After validating the email address, you can use the `setProviderData` method on the `Igniter\Socialite\Classes\ProviderManager` class to set the email address on the provider user instance, then call the `completeCallback` method to complete the login process.

Here is an example of how to render the email confirmation form in your blade view:

```blade
<form method="post" wire:submit="onConfirmEmail">
    @csrf
    <input type="email" name="email" required>
    <button type="submit">Confirm Email</button>
</form>
```

Here is an example of how to handle the email confirmation form submission in your component class:

```php
use Igniter\Socialite\Classes\ProviderManager;

public function onConfirmEmail()
{
    // Validate the email address

    $email = request()->input('email');

    $manager = resolve(ProviderManager::class);

    $providerData = $manager->getProviderData();
    $providerData->user->email = $validated['email'];
    $manager->setProviderData($providerData);

    return $manager->completeCallback();
}
```

### Permissions

This extension requires the following permissions:

- `Igniter.Socialite.Manage` - Control who can manage socialite providers

## Events

The Local extension provides the following events:

| Event | Description | Parameters |
| ----- | ----------- | ---------- |
| `igniter.socialite.beforeRedirect` |    Before redirecting to the socialite provider.    |  The provider class instance   |
| `igniter.socialite.completeCallback` |    After the socialite provider callback is complete, just before creating the user account.    |  The provider class instance and the provider model instance   |
| `igniter.socialite.beforeLogin` |    Before logging in the user. Used to override the login process.    |  The provider class instance and the user `Igniter\User\Models\User` model instance   |
| `igniter.socialite.login` |    After the user has logged in successfully.    |  The user `Igniter\User\Models\User` model instance   |
| `igniter.socialite.register` |    Before registering the user. Used to override the registration process.    |  The provider class instance and the provider `Igniter\Socialite\Models\Provider` model instance   |

Here is an example of hooking an event in the `boot` method of an extension class:

```php
use Illuminate\Support\Facades\Event;

public function boot()
{
    Event::listen('igniter.socialite.login', function ($user) {
        // ...
    });
}
```
