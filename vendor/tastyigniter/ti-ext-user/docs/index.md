---
title: "User"
section: "extensions"
sortOrder: 110
---

## Installation

You can install the extension via composer using the following command:

```bash
composer require tastyigniter/ti-ext-user -W
```

Run the database migrations to create the required tables:
  
```bash
php artisan igniter:up
```

## Getting started

### Registration settings

You can configure the registration settings in the admin area. Navigate to the _Manage > Settings > Customer registration_ admin settings page. Here you can enable/disable customer registration, and where to send registration emails to the customer email and/or location email.

### Managing customers

To manage customers, navigate to the _Customers_ admin page. Here you can view a list of all registered customers, search for customers, view customer details, and manage customer accounts.

### Managing staff members

To manage staff members, navigate to the _Manage > Staff members_ admin page. Here you can view a list of all registered staff members, search for staff members, view staff member details, and manage staff member accounts.

## Usage

This section covers how to integrate the User extension API into your own extension if you need to authenticate customers, register customers, create staff members, reset passwords, impersonate users, and manage permissions. The User extension provides a simple API for managing users and their authentication.

### Authenticating customers

To authenticate a customer, you can use the `\Igniter\User\Actions\LoginCustomer` action class. The action class accepts an array of credentials and a boolean value to indicate if the user should be remembered.

This class mirrors the authentication process used by the default login form. It also dispatches two key events — `igniter.user.beforeAuthenticate` and `igniter.user.login` — which can be used to hook into the login process for custom behavior or integrations.

```php
use Igniter\User\Actions\LoginCustomer;

$credentials = [
    'email' => 'email@domain.tld',
    'password' => 'password',
];

$loginCustomer = new LoginCustomer($credentials, $remember);

$loginCustomer->handle();
```

The `\Igniter\User\Facades\Auth::check` method can be used to check if a user is authenticated.

```php
use Igniter\User\Facades\Auth;

if (Auth::check()) {
    // The user is authenticated
}
```

The `\Igniter\User\Facades\Auth::logout` method can be used to log out a user.

```php
use Igniter\User\Facades\Auth;

Auth::logout();
```

### Authenticating staff members

To authenticate a staff member, you can use the `\Igniter\User\Facades\AdminAuth` class. The `attempt` method accepts an array of credentials and a boolean value to indicate if the user should be remembered.

```php
use Igniter\User\Facades\AdminAuth;

$credentials = [
    'email' => 'admin@domain.tld',
    'password' => 'password',
];

AdminAuth::attempt($credentials, $remember);
```

The `AdminAuth::check` method can be used to check if a staff member is authenticated.

```php
if (AdminAuth::check()) {
    // The staff member is authenticated
}
```

The `AdminAuth::logout` method can be used to log out a staff member.

```php
AdminAuth::logout();
```

### Customer registration

To register a customer, you can use the `\Igniter\User\Actions\CustomerRegister` action class. The action class `handle` method accepts an array of customer data and a boolean value to indicate if the customer should be activated, you may ignore the second parameter to use the default customer group approval settings. The method returns the created customer `Igniter\User\Models\Customer` model.

This class mirrors the registration process used by the default registration form. It also dispatches two key events — `igniter.user.beforeRegister` and `igniter.user.register` — which can be used to hook into the registration process for custom behavior or integrations.

```php
use Igniter\User\Actions\CustomerRegister;

$customerData = [
    'first_name' => 'John',
    'last_name' => 'Doe',
    'email' => 'email@domain.tld',
    'password' => 'password',
];

$registerCustomer = new CustomerRegister();
$customer = $registerCustomer->handle($customerData);

if ($customer->is_activated) {
    // Registration successful
    $customer->mailSendRegistered(['account_login_link' => page_url('account.login')]);
} else {
    // Registration requires email verification
    $customer->mailSendEmailVerification([
        'account_activation_link' => page_url('account.register').'?code='.$customer->getActivationCode(),
    ]);
}
```

The `CustomerRegister` action class also provides methods to activate the customer account using the activation code. This is useful when the customer clicks on the email verification link.

```php
use Igniter\User\Actions\CustomerRegister;

$registerCustomer = new CustomerRegister();
$customer = $registerCustomer->activate($code);

$customer->sendRegisteredMail(['account_login_link' => page_url('account.login')]);
```

### Creating a staff member

To create a staff member, you can use the `\Igniter\User\Auth\UserProvider::register` method. The `register` method accepts an array of staff member data and a boolean value to indicate if the staff member should be activated. The method returns the created staff member model.

```php
use Igniter\User\Facades\AdminAuth;

$staffData = [
    'name' => 'John Doe',
    'username' => 'johndoe',
    'email' => 'admin@domain.tld',
    'password' => 'password',
];

AdminAuth::getProvider()->register($staffData);
```

### Resetting customer passwords

To reset a customer's password, you can use the `resetPassword` method on the `\Igniter\User\Models\Customer` model. The method returns the reset password code.

```php
use Igniter\User\Models\Customer;

$customer = Customer::where('email', 'email@domain.tld')->first();
$resetCode = $customer->resetPassword();
```

Using the `mailSendResetPasswordRequest` method, you can send a password reset email to the customer.

```php
$customer->mailSendResetPasswordRequest([
    'reset_link' => page_url('account.reset', ['code' => $resetCode]),
]);
```

To complete the password reset process, you can use the `completeResetPassword` method on the `\Igniter\User\Models\Customer` model. The method accepts the reset password code and the new password.

```php
$customer = Customer::where('email', 'email@domain.tld')->first();
$customer->completeResetPassword($resetCode, 'new-password');
```

Using the `mailSendResetPassword` method, you can send a password changed email to the customer.

```php
$customer->mailSendResetPassword([
    'account_login_link' => page_url('account.login'),
]);
```

### Resetting staff member passwords

To reset a staff member's password, you can use the `resetPassword` method on the `\Igniter\User\Models\User` model. The method returns the reset password code.

```php
use Igniter\User\Models\User;

$user = User::where('email', 'admin@domain.tld')->first();
$resetCode = $user->resetPassword();
```

Using the `mailSendResetPasswordRequest` method, you can send a password reset email to the staff member.

```php
$user->mailSendResetPasswordRequest([
    'reset_link' => admin_url('login', ['code' => $resetCode]),
]);
```

To complete the password reset process, you can use the `completeResetPassword` method on the `\Igniter\User\Models\User` model. The method accepts the reset password code and the new password.

```php
$user = User::where('email', 'admin@domain.tld')->first();
$user->completeResetPassword($resetCode, 'new-password');
```

Using the `mailSendResetPassword` method, you can send a password changed email to the staff member.

```php
$user->mailSendResetPassword([
    'login_link' => admin_url('login'),
]);
```

#### Using the `igniter:passwd` command

You can also reset a staff member's password using the `igniter:passwd` Artisan command. The command accepts the staff's email address and the new password.

```bash
php artisan igniter:passwd 'admin@domain.tld' 'password'
```

### Impersonating customers

To impersonate a customer, you can use the `impersonate` method on the `\Igniter\User\Facades\Auth` facade. The method accepts the customer model.

```php
use Igniter\User\Facades\Auth;
use Igniter\User\Models\Customer;

$customer = Customer::find(1);
Auth::impersonate($customer);
```

Using the `stopImpersonate` method, you can stop impersonating the customer.

```php
Auth::stopImpersonate();
```

### Impersonating staff members

To impersonate a staff member, you can use the `impersonate` method on the `\Igniter\User\Facades\AdminAuth` facade. The method accepts the staff member model.

```php
use Igniter\User\Facades\AdminAuth;
use Igniter\User\Models\User;

$user = User::find(1);
AdminAuth::impersonate($user);
```

Using the `stopImpersonate` method, you can stop impersonating the staff member.

```php
AdminAuth::stopImpersonate();
```

### Authorising access to admin pages

To authorise access to admin pages, you can use the `hasPermission` method on the `\Igniter\User\Models\User` model. The method accepts the permission code.

```php
use Igniter\User\Models\User;

$user = User::find(1);
if ($user->hasPermission('Admin.Orders')) {
    // User has permission to access the admin orders page
}
```

You can also use the `hasAnyPermission` method to check if a user has any of the specified permissions.

```php
if ($user->hasAnyPermission(['Admin.Orders', 'Admin.Reservations'])) {
    // User has permission to access the admin orders or reservations page
}
```

Use the `requiredPermissions` property on [admin controller classes](https://tastyigniter.com/docs/extend/controllers) to specify the permissions required to access the controller actions.

```php
class Orders extends \Admin\Classes\AdminController
{
    public $requiredPermissions = ['Admin.Orders'];
}
```

### Automation Events

When setting up automation rules through the Admin Panel, you can use the following events registered by this extension:

#### Customer Registered Event

An automation event class used to capture the `igniter.user.register` system event when a customer registers. The event class is also used to prepare the customer parameters for automation rules. The following parameters are available:

- `customer`: The customer `Igniter\User\Models\Customer` model instance.
- `data`: The customer registration form data as an array.

### Automation Conditions

When setting up automation rules through the Admin Panel, you can use the following automation conditions registered by this extension:

#### Customer Attribute Condition

A condition class used to check if an customer attribute match the specified value or rule. The following attributes are available:

- `first_name`: The customer's first name.
- `last_name`: The customer's last name.
- `telephone`: The customer's telephone number.
- `email`: The customer's email address.

### Mail templates

The User extension registers the following mail templates:

- `igniter.user::mail.registration` - Registration mail sent to customers.
- `igniter.user::mail.registration_alert` - Registration alert mail sent to staff members.
- `igniter.user::mail.activation` - Email verification mail sent to customers.
- `igniter.user::mail.invite` - Invitation mail sent to staff members.
- `igniter.user::mail.invite_customer` - Invitation mail sent to customers.
- `igniter.user::mail.password_reset` - Password reset mail sent to customers.
- `igniter.user::mail.password_reset_request` - Password reset request mail sent to customers.
- `igniter.user::mail.admin_password_reset_request` - Password reset request mail sent to staff members.
- `igniter.user::mail.admin_password_reset` - Password reset mail sent to staff members.

### Permissions

The User extension registers the following permissions:

- `Admin.Customers` - Control who can manage customers in the admin area.
- `Admin.CustomerGroups` - Control who can manage customer groups in the admin area.
- `Admin.DeleteCustomers` - Control who can delete customers in the admin area.
- `Admin.ImpersonateCustomers` - Control who can impersonate customers in the admin area.
- `Admin.Staffs` - Control who can manage staff members in the admin area.
- `Admin.StaffGroups` - Control who can manage staff groups in the admin area.
- `Admin.DeleteStaffs` - Control who can delete staff members in the admin area.
- `Admin.Impersonate` - Control who can impersonate staff members in the admin area.

For more on restricting access to the admin area, see the [TastyIgniter Permissions](https://tastyigniter.com/docs/customize/permissions) documentation.

### Events

This extension will fire some global events that can be useful for interacting with other extensions.

| Event | Description | Parameters |
| ----- | ----------- | ---------- |
| `igniter.user.beforeAuthenticate` | Before the user is attempting to authenticate    |      `[ $component, $credentials ]`    |
| `igniter.user.login` | The user has logged in successfully  |         `[ $component ]`    |
| `igniter.user.beforeRegister` | Before the user is attempting to register  |        `[ &$postData ]`  |
| `igniter.user.register` | The user has registered successfully |        `[ $customer, $postData ]`    |
| `igniter.user.logout` | The user has logged out successfully  |        `[ $customer ]` |

Here is an example of hooking an event in the `boot` method of an extension class:

```php
Event::listen('igniter.user.logout', function($customer) {
    // ...
});
```
