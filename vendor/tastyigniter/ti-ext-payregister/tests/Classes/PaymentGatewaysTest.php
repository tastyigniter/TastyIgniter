<?php

declare(strict_types=1);

namespace Igniter\PayRegister\Tests\Classes;

use Igniter\Flame\Support\Facades\File;
use Igniter\Main\Classes\Theme;
use Igniter\Main\Classes\ThemeManager;
use Igniter\PayRegister\Classes\PaymentGateways;
use Igniter\PayRegister\Models\Payment;
use Igniter\PayRegister\Tests\Payments\Fixtures\TestPayment;
use Igniter\System\Classes\ExtensionManager;
use Illuminate\View\Factory;
use Mockery;

beforeEach(function(): void {
    $this->paymentGateways = new PaymentGateways;
});

it('returns null if gateway not found', function(): void {
    $result = $this->paymentGateways->findGateway('nonexistent');

    expect($result)->toBeNull();
});

it('returns gateway details if gateway found', function(): void {
    $gateway = ['code' => 'test_gateway', 'class' => TestPayment::class];
    $this->paymentGateways->registerGateways('test_owner', [$gateway['class'] => $gateway]);

    $result = $this->paymentGateways->findGateway('test_gateway');

    expect($result['code'])->toBe($gateway['code'])
        ->and($result['class'])->toBe($gateway['class'])
        ->and($result['owner'])->toBe('test_owner')
        ->and($result['object'])->toBeInstanceOf(TestPayment::class);
});

it('returns list of gateway objects', function(): void {
    $gateway = ['code' => 'test_gateway', 'class' => TestPayment::class];
    $this->paymentGateways->registerGateways('test_owner', [$gateway['class'] => $gateway]);

    $result = $this->paymentGateways->listGatewayObjects();

    expect($result)->toHaveKey('test_gateway')
        ->and($result['test_gateway'])->toBeInstanceOf(TestPayment::class);
});

it('loads gateways from extensions', function(): void {
    $extensionManager = Mockery::mock(ExtensionManager::class);
    $extensionManager->shouldReceive('getExtensions')->andReturn([
        'test_extension' => new class
        {
            public function registerPaymentGateways(): array
            {
                return [
                    TestPayment::class => [
                        'code' => 'test_gateway',
                    ],
                ];
            }
        },
        'test_extension2' => new class {},
        'test_extension3' => new class
        {
            public function registerPaymentGateways(): string
            {
                return 'is-not-array';
            }
        },
    ]);
    app()->instance(ExtensionManager::class, $extensionManager);

    $this->paymentGateways->registerCallback(function($gateway): void {
        $gateway->registerGateways('test_owner2', [
            TestPayment::class => [
                'code' => 'test_gateway2',
            ],
        ]);
    });

    $this->paymentGateways->listGateways();

    $result = $this->paymentGateways->findGateway('test_gateway');

    expect($result)->toBeArray()
        ->and($result['code'])->toBe('test_gateway');
});

it('executes entry point and returns response', function(): void {
    Payment::factory()->create([
        'code' => 'test_code',
        'class_name' => TestPayment::class,
    ]);

    $result = PaymentGateways::runEntryPoint('test_endpoint', 'test/uri');

    expect($result)->toBe('test_endpoint');
});

it('returns 403 response if entry point not found', function(): void {
    $result = PaymentGateways::runEntryPoint('invalid_code', 'test/uri');

    expect($result->getStatusCode())->toBe(403);
});

it('creates partials returns null when no active theme', function(): void {
    $themeManager = mock(ThemeManager::class);
    $themeManager->shouldReceive('getActiveTheme')->andReturnNull();
    app()->instance(ThemeManager::class, $themeManager);

    $result = PaymentGateways::createPartials();

    expect($result)->toBeNull();
});

it('creates partials for enabled payment methods', function(): void {
    $themeManager = mock(ThemeManager::class);
    $theme = mock(Theme::class);
    $themeManager->shouldReceive('getActiveTheme')->andReturn($theme);
    $theme->shouldReceive('listPartials')->andReturn(collect([]));
    $theme->shouldReceive('getPath')->andReturn('/path/to/theme');
    app()->instance(ThemeManager::class, $themeManager);

    Payment::where('status', 1)->update(['status' => 0]);
    Payment::factory()->create([
        'code' => 'test',
        'status' => 1,
        'class_name' => TestPayment::class,
    ]);
    Payment::factory()->create([
        'code' => 'test2',
        'status' => 1,
        'class_name' => 'NonExistentPayment',
    ]);

    File::shouldReceive('normalizePath')->andReturn('');
    File::shouldReceive('symbolizePath')->andReturn('');
    File::shouldReceive('isFile')->andReturn(true);
    File::shouldReceive('getRequire')->andReturn(['fields' => []]);
    File::shouldReceive('isLocalPath')->andReturn(false);
    File::shouldReceive('isDirectory')->andReturn(false);
    File::shouldReceive('makeDirectory')->andReturn(true);
    File::shouldReceive('put')->once()->with(
        '/path/to/theme/_partials/payregister/testpayment.blade.php',
        'Test content',
    )->andReturn(true);

    $factory = Mockery::mock(Factory::class);
    $factory->shouldReceive('getFinder->find')->andReturn('Test content');
    app()->instance('view', $factory);

    PaymentGateways::createPartials();
});
