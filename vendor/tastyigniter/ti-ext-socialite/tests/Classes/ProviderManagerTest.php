<?php

declare(strict_types=1);

namespace Igniter\Socialite\Tests\Classes;

use Igniter\Flame\Exception\SystemException;
use Igniter\Socialite\Classes\BaseProvider;
use Igniter\Socialite\Classes\ProviderManager;
use Igniter\Socialite\Models\Provider;
use Igniter\Socialite\Tests\Fixtures\TestProvider;
use Igniter\System\Classes\ExtensionManager;
use Igniter\User\Models\Customer;
use Illuminate\Support\Facades\Event;
use Laravel\Socialite\AbstractUser;
use Mockery;
use ReflectionClass;
use Symfony\Component\HttpFoundation\RedirectResponse;

it('returns null when provider is not found', function(): void {
    $providerManager = new ProviderManager;

    expect($providerManager->findProvider('nonexistent'))->toBeNull();
});

it('returns correct provider class name', function(): void {
    $providerManager = new ProviderManager;
    $providerManager->registerProvider(BaseProvider::class, ['code' => 'test']);

    expect($providerManager->resolveProvider('test'))->toBe(BaseProvider::class);
});

it('returns empty list when no providers are registered', function(): void {
    $extensionManager = Mockery::mock(ExtensionManager::class);
    $extensionManager->shouldReceive('getRegistrationMethodValues')->with('registerSocialiteProviders')->andReturn([]);
    app()->instance(ExtensionManager::class, $extensionManager);

    $providerManager = new ProviderManager;

    expect($providerManager->listProviders())->toBe([]);
});

it('returns correct list of provider links', function(): void {
    $provider = Mockery::mock(BaseProvider::class)->makePartial();
    $provider->shouldReceive('isEnabled')->andReturn(true);
    $provider->shouldReceive('makeEntryPointUrl')->with('auth')->andReturn('http://auth.url');

    $providerManager = Mockery::mock(ProviderManager::class)->makePartial();
    $providerManager->shouldReceive('makeProvider')->andReturn($provider);
    $providerManager->registerProvider(BaseProvider::class, ['code' => 'test']);

    expect($providerManager->listProviderLinks()->toArray())->toBe(['test' => 'http://auth.url']);
});

it('returns empty list for disabled provider links', function(): void {
    $provider = Mockery::mock(BaseProvider::class)->makePartial();
    $provider->shouldReceive('isEnabled')->andReturn(false);

    $providerManager = Mockery::mock(ProviderManager::class)->makePartial();
    $providerManager->shouldReceive('makeProvider')->andReturn($provider);
    $providerManager->registerProvider(BaseProvider::class, ['code' => 'test']);

    expect($providerManager->listProviderLinks()->toArray())->toBeEmpty();
});

it('registers providers correctly', function(): void {
    $providerManager = new ProviderManager;
    $providers = [
        BaseProvider::class => ['code' => 'test1', 'description' => 'test-description1', 'label' => 'test-label1'],
    ];

    $providerManager->registerProviders($providers);

    expect($providerManager->listProviders())->toHaveCount(1)
        ->and($providerManager->resolveProvider('test1'))->toBe(BaseProvider::class);
});

it('registers a single provider correctly', function(): void {
    $providerManager = new ProviderManager;
    $providerInfo = ['code' => 'test'];

    $providerManager->registerProvider(BaseProvider::class, $providerInfo);

    expect($providerManager->listProviders())->toHaveCount(1)
        ->and($providerManager->resolveProvider('test'))->toBe(BaseProvider::class);
});

it('registers a single provider correctly when code is missing', function(): void {
    $expectedCode = 'igniter_socialite_classes_baseprovider';
    $providerInfo = [];

    $providerManager = new ProviderManager;
    $providerManager->registerProvider(BaseProvider::class, $providerInfo);

    expect($providerManager->listProviders())->toHaveCount(1)
        ->and($providerManager->resolveProvider($expectedCode))->toBe(BaseProvider::class);
});

it('registers callback correctly', function(): void {
    $providerManager = new ProviderManager;
    $callback = function($manager): void {
        $manager->registerProvider(BaseProvider::class, ['code' => 'test']);
    };

    $providerManager->registerCallback($callback);
    $providerManager->loadProviders();

    expect($providerManager->resolveProvider('test'))->toBe(BaseProvider::class);
});

it('creates provider instance correctly', function(): void {
    $providerManager = new ProviderManager;
    $providerInfo = ['code' => 'test'];

    $providerManager->registerProvider(TestProvider::class, $providerInfo);
    $provider = $providerManager->makeProvider(TestProvider::class);

    expect($provider)->toBeInstanceOf(TestProvider::class)
        ->and($provider->getDriver())->toBe('test');
});

it('throws exception when provider class does not exist', function(): void {
    $providerManager = new ProviderManager;
    expect(fn() => $providerManager->makeProvider('NonExistentClass'))->toThrow(SystemException::class);
});

it('adds callback to resolveUserTypeCallbacks array', function(): void {
    $providerManager = new ProviderManager;
    $callback = fn(): string => 'custom_user_type';

    $providerManager->resolveUserType($callback);

    $reflection = new ReflectionClass($providerManager);
    $property = $reflection->getProperty('resolveUserTypeCallbacks');

    $callbacks = $property->getValue($providerManager);

    expect($callbacks)->toContain($callback);
});

it('executes resolveUserType callback correctly', function(): void {
    $providerManager = new ProviderManager;
    $callback = fn(): string => 'custom_user_type';

    $providerManager->resolveUserType($callback);

    $reflection = new ReflectionClass($providerManager);
    $method = $reflection->getMethod('resolveUserTypeCallback');

    $userType = $method->invoke($providerManager);

    expect($userType)->toBe('custom_user_type');
});

it('returns default user type when no callback is provided', function(): void {
    $providerManager = new ProviderManager;
    $reflection = new ReflectionClass($providerManager);
    $method = $reflection->getMethod('resolveUserTypeCallback');

    $userType = $method->invoke($providerManager);

    expect($userType)->toBe('customers');
});

it('runs entry point and redirects to provider', function(): void {
    $provider = Mockery::mock(BaseProvider::class)->makePartial();
    $provider->shouldReceive('redirectToProvider')->andReturn(new RedirectResponse('http://redirect.url'));

    $providerManager = Mockery::mock(ProviderManager::class)->makePartial();
    $providerManager->shouldReceive('makeProvider')->andReturn($provider);
    $providerManager->registerProvider(BaseProvider::class, ['code' => 'test']);

    $response = $providerManager->runEntryPoint('test', 'auth');

    expect($response->getTargetUrl())->toBe('http://redirect.url');
});

it('handles provider callback, creates user and returns redirect response', function(string $providerName): void {
    Event::fake();

    request()->merge(['success' => 'account']);
    $providerUser = Mockery::mock(AbstractUser::class);
    $providerUser->id = 1;
    $providerUser->token = 'token';
    $providerUser->shouldReceive('getEmail')->andReturn('john@example.com');
    $providerUser->shouldReceive('getName')->andReturn('John Doe');
    $providerUser->shouldReceive('offsetGet')->andReturnValues(['John', 'Doe'])->twice();

    $provider = Mockery::mock(BaseProvider::class)->makePartial();
    $provider->shouldReceive('handleProviderCallback')->andReturn($providerUser);
    $provider->shouldReceive('getDriver')->andReturn($providerName);

    $providerManager = Mockery::mock(ProviderManager::class)->makePartial();
    $providerManager->shouldReceive('makeProvider')->andReturn($provider);
    $providerManager->registerProvider(BaseProvider::class, ['code' => 'test']);

    $response = $providerManager->runEntryPoint('test', 'callback');

    expect($response->getTargetUrl())->toBe('http://localhost/account');

    Event::assertDispatched('igniter.socialite.register');
    Event::assertDispatched('igniter.socialite.beforeLogin');
    Event::assertDispatched('igniter.socialite.login');
})->with([
    'google',
    'facebook',
]);

it('handles provider callback, retrieves user and returns redirect response', function(): void {
    Event::fake();

    $customer = Customer::factory()->create(['email' => 'john@example.com']);

    request()->merge(['success' => 'account']);
    $providerUser = Mockery::mock(AbstractUser::class);
    $providerUser->id = 1;
    $providerUser->token = 'token';
    $providerUser->shouldReceive('getEmail')->andReturn($customer->email);
    $providerUser->shouldReceive('getName')->andReturn('John Doe');

    $provider = Mockery::mock(BaseProvider::class)->makePartial();
    $provider->shouldReceive('handleProviderCallback')->andReturn($providerUser);
    $provider->shouldReceive('getDriver')->andReturn('test');

    $providerManager = Mockery::mock(ProviderManager::class)->makePartial();
    $providerManager->shouldReceive('makeProvider')->andReturn($provider);
    $providerManager->registerProvider(BaseProvider::class, ['code' => 'test']);

    $response = $providerManager->runEntryPoint('test', 'callback');

    expect($response->getTargetUrl())->toBe('http://localhost/account');

    Event::assertDispatched('igniter.socialite.beforeLogin');
    Event::assertDispatched('igniter.socialite.login');
});

it('throws exception provider class handleProviderCallback fails', function(): void {
    Event::fake();

    $customer = Customer::factory()->create(['email' => 'john@example.com']);

    request()->merge(['success' => 'account']);
    $providerUser = Mockery::mock(AbstractUser::class);
    $providerUser->id = 1;
    $providerUser->token = 'token';
    $providerUser->shouldReceive('getEmail')->andReturn($customer->email);
    $providerUser->shouldReceive('getName')->andReturn('John Doe');

    $provider = Mockery::mock(BaseProvider::class)->makePartial();
    $provider->shouldReceive('handleProviderCallback')->andThrow(new SystemException('Provider error'));
    $provider->shouldReceive('getDriver')->andReturn('test');

    $providerManager = Mockery::mock(ProviderManager::class)->makePartial();
    $providerManager->shouldReceive('makeProvider')->andReturn($provider);
    $providerManager->registerProvider(BaseProvider::class, ['code' => 'test']);

    $providerManager->runEntryPoint('test', 'callback');

    expect(flash()->messages()->first())->level->toBe('danger')
        ->message->toContain('Provider error');
});

it('throws exception when unknown socialite provider is used', function(): void {
    $providerManager = new ProviderManager;
    $providerManager->registerProvider(BaseProvider::class, ['code' => 'test']);

    $providerManager->runEntryPoint('unknown', 'auth');

    expect(flash()->messages()->first())->level->toBe('danger')
        ->message->toBe('Unknown socialite provider: .');
});

it('bails when provider user is not in session', function(): void {
    $providerManager = new ProviderManager;

    $response = $providerManager->completeCallback();

    expect($response)->toBeNull();
});

it('bails when provider user is not found', function(): void {
    $providerManager = new ProviderManager;
    session()->put('igniter_socialite_provider', (object)['id' => -1, 'user' => []]);

    $response = $providerManager->completeCallback();

    expect($response)->toBeNull();
});

it('bails when completeCallback event halts flow', function(): void {
    Event::listen('igniter.socialite.completeCallback', fn(): true => true);

    $provider = Provider::create([
        'code' => 'test',
        'name' => 'Test Provider',
        'class_name' => BaseProvider::class,
    ]);

    $providerManager = new ProviderManager;
    session()->put('igniter_socialite_provider', (object)['id' => $provider->id, 'user' => []]);

    $response = $providerManager->completeCallback();

    expect($response)->toBeNull();
});

it('bails when beforeLogin event halts flow', function(): void {
    Event::listen('igniter.socialite.beforeLogin', fn(): RedirectResponse => new RedirectResponse('http://redirect.url'));

    $providerUser = Mockery::mock(AbstractUser::class);
    $providerUser->shouldReceive('getEmail')->andReturn('john@example.com');
    $providerUser->shouldReceive('getName')->andReturn('John Doe');

    $provider = Provider::create([
        'code' => 'test',
        'name' => 'Test Provider',
        'class_name' => BaseProvider::class,
    ]);

    $providerManager = new ProviderManager;
    session()->put('igniter_socialite_provider', (object)['id' => $provider->id, 'user' => $providerUser]);

    $response = $providerManager->completeCallback();

    expect($response->getTargetUrl())->toBe('http://redirect.url');
});
