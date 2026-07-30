<?php

declare(strict_types=1);

namespace Igniter\User\Tests\Http\Controllers;

use Igniter\Flame\Exception\FlashException;
use Igniter\Local\Models\Location;
use Igniter\System\Models\Country;
use Igniter\User\Auth\UserProvider;
use Igniter\User\Facades\AdminAuth;
use Igniter\User\Http\Controllers\Login;
use Igniter\User\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Route;
use Illuminate\Validation\ValidationException;

beforeEach(function(): void {
    $this->route = new Route('GET', 'login', ['as' => 'igniter.admin.login']);
    $this->route->parameters = ['slug' => ''];
});

it('loads initial setup page if no user exists', function(): void {
    withoutAdminUsers();

    AdminAuth::shouldReceive('isLogged')->andReturnFalse();
    AdminAuth::shouldReceive('isImpersonator')->andReturnFalse();
    request()->setRouteResolver(fn() => $this->route);

    $response = (new Login)->index();

    expect($response)->toBeString()
        ->and($response)->toContain(lang('igniter.user::default.login.text_initial_setup_title'));
});

it('creates super admin account and updates default location details successfully', function(): void {
    withoutAdminUsers();

    request()->request->add([
        'name' => 'Test Admin',
        'email' => 'test@example.com',
        'password' => 'Pa$$w0rd!',
        'password_confirm' => 'Pa$$w0rd!',
        'restaurant_name' => 'Test Restaurant',
        'restaurant_email' => 'test@restaurant.com',
        'telephone' => '1234567890',
        'address_1' => '123 Test St',
        'city' => 'Test City',
        'state' => 'Test State',
        'postcode' => '12345',
        'country_id' => '111',
    ]);
    AdminAuth::shouldReceive('getProvider')->once()->andReturn($userProvider = mock(UserProvider::class));
    $userProvider->shouldReceive('register')->once();

    $response = (new Login)->onCompleteSetup();

    Country::clearDefaultModel();
    $defaultLocation = Location::getDefault();
    expect($response->getTargetUrl())->toBe('http://localhost/admin/login')
        ->and($defaultLocation)->not->toBeNull()
        ->and($defaultLocation->location_name)->toBe('Test Restaurant')
        ->and($defaultLocation->location_email)->toBe('test@restaurant.com')
        ->and($defaultLocation->location_telephone)->toBe('1234567890')
        ->and($defaultLocation->location_address_1)->toBe('123 Test St')
        ->and($defaultLocation->location_city)->toBe('Test City')
        ->and($defaultLocation->location_state)->toBe('Test State')
        ->and($defaultLocation->location_postcode)->toBe('12345')
        ->and($defaultLocation->location_country_id)->toBe(111)
        ->and(Country::getDefaultKey())->toBe(111);
});

it('throws exception if user exists when completing initial setup', function(): void {
    User::factory()->create();

    request()->request->add([
        'name' => 'Test Admin',
        'email' => 'test@example.com',
        'password' => 'Pa$$w0rd!',
        'password_confirm' => 'Pa$$w0rd!',
        'restaurant_name' => 'Test Restaurant',
        'restaurant_email' => 'test@restaurant.com',
        'telephone' => '',
        'address_1' => '123 Test St',
        'city' => '',
        'state' => '',
        'postcode' => '12345',
        'country_id' => '111',
    ]);

    expect(fn(): RedirectResponse => (new Login)->onCompleteSetup())
        ->toThrow(FlashException::class, lang('igniter.user::default.login.alert_super_admin_already_exists'));
});

it('throws exception if validation fails when completing initial setup', function(): void {
    request()->request->add([
        'name' => 'Test Admin',
    ]);

    AdminAuth::shouldReceive('getProvider')->never();

    (new Login)->onCompleteSetup();
});

it('loads login page if not logged in', function(): void {
    $this->route->action = [];
    request()->setRouteResolver(fn() => $this->route);

    $response = (new Login)->index();

    expect($response)->toBeInstanceOf(RedirectResponse::class);
});

it('redirects to dashboard if already logged in', function(): void {
    AdminAuth::shouldReceive('isLogged')->andReturnTrue();
    AdminAuth::shouldReceive('isImpersonator')->andReturnFalse();
    AdminAuth::shouldReceive('check')->andReturnTrue();
    request()->setRouteResolver(fn() => $this->route);

    $response = (new Login)->index();

    expect($response)->toBeInstanceOf(RedirectResponse::class)
        ->and((new Login)->checkUser())->toBeTrue();
});

it('renders login view if not logged in and on login route', function(): void {
    request()->setRouteResolver(fn() => $this->route);
    AdminAuth::shouldReceive('isLogged')->andReturnFalse();
    AdminAuth::shouldReceive('isImpersonator')->andReturnFalse();

    $response = (new Login)->index();

    expect($response)->toBeString();
});

it('renders reset password view', function(): void {
    AdminAuth::shouldReceive('isLogged')->andReturnFalse();
    AdminAuth::shouldReceive('isImpersonator')->andReturnFalse();

    $response = (new Login)->reset();

    expect($response)->toBeString();
});

it('redirects reset password to dashboard if already logged in', function(): void {
    AdminAuth::shouldReceive('isLogged')->andReturnTrue();

    $response = (new Login)->reset();

    expect($response)->toBeInstanceOf(RedirectResponse::class);
});

it('resets password successfully', function(): void {
    $user = User::factory()->create();
    request()->request->set('email', $user->email);
    AdminAuth::shouldReceive('isLogged')->andReturnFalse();

    $response = (new Login)->onRequestResetPassword();

    expect($response->getTargetUrl())->toBe('http://localhost/admin/login')
        ->and(flash()->messages()->first())->level->toBe('success')
        ->message->toBe(lang('igniter.user::default.login.alert_email_sent'));
});

it('fails to reset password with invalid code', function(): void {
    AdminAuth::shouldReceive('isLogged')->andReturnFalse();
    AdminAuth::shouldReceive('isImpersonator')->andReturnFalse();
    request()->merge(['code' => 'invalid_code']);

    $response = (new Login)->reset();

    expect($response->getTargetUrl())->toBe('http://localhost/admin/login')
        ->and(flash()->messages()->first())->level->toBe('danger')
        ->message->toBe(lang('igniter.user::default.login.alert_failed_reset'));
});

it('logs in successfully with valid credentials', function(): void {
    $data = ['email' => 'test@example.com', 'password' => 'password'];
    request()->request->add($data);
    AdminAuth::shouldReceive('check')->andReturnFalse();
    AdminAuth::shouldReceive('attempt')->with($data, true)->andReturnTrue();

    $response = (new Login)->onLogin();

    expect($response->getTargetUrl())->toBe('http://localhost/admin/dashboard');
});

it('logs in successfully with valid credentials and redirects to custom url', function(): void {
    $data = ['email' => 'test@example.com', 'password' => 'password'];
    request()->request->add($data);
    request()->merge(['redirect' => 'orders']);
    AdminAuth::shouldReceive('check')->andReturnFalse();
    AdminAuth::shouldReceive('attempt')->with($data, true)->andReturnTrue();

    $response = (new Login)->onLogin();

    expect($response->getTargetUrl())->toBe('http://localhost/admin/orders');
});

it('fails to log in with invalid credentials', function(): void {
    $data = ['email' => 'test@example.com', 'password' => 'wrong_password'];
    request()->request->add($data);
    AdminAuth::shouldReceive('check')->andReturnFalse();
    AdminAuth::shouldReceive('attempt')->with($data, true)->andReturnFalse();

    $this->expectException(ValidationException::class);

    (new Login)->onLogin();
});

it('resets password successfully with valid code', function(): void {
    User::factory()->create([
        'reset_code' => 'valid_code',
        'reset_time' => now()->subMinutes(5),
    ]);
    $data = ['code' => 'valid_code', 'password' => 'Pa$$w0rd!!!', 'password_confirm' => 'Pa$$w0rd!!!'];
    request()->request->add($data);

    $response = (new Login)->onResetPassword();

    expect($response->getTargetUrl())->toBe('http://localhost/admin/login')
        ->and(flash()->messages()->first())->level->toBe('success')
        ->message->toBe(lang('igniter.user::default.login.alert_success_reset'));
});

it('resets password fails if code does not match', function(): void {
    User::factory()->create([
        'reset_code' => 'valid_code',
        'reset_time' => now()->subMinutes(5),
    ]);
    $data = ['code' => 'invalid_code', 'password' => 'Pa$$w0rd!!!', 'password_confirm' => 'Pa$$w0rd!!!'];
    request()->request->add($data);

    $this->expectException(ValidationException::class);

    (new Login)->onResetPassword();
});
