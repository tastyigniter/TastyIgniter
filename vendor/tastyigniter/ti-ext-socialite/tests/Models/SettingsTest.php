<?php

declare(strict_types=1);

namespace Igniter\Socialite\Tests\Models;

use Exception;
use Igniter\Socialite\Classes\ProviderManager;
use Igniter\Socialite\Models\Settings;
use Igniter\System\Actions\SettingsModel;
use Mockery;

it('returns provider instance when valid provider is given', function(): void {
    $providerManager = Mockery::mock(ProviderManager::class);
    $providerManager->shouldReceive('resolveProvider')->with('valid_provider')->andReturn('ValidProviderClass');
    $providerManager->shouldReceive('makeProvider')->with('ValidProviderClass')->andReturn('provider_instance');
    app()->instance(ProviderManager::class, $providerManager);

    $settings = new Settings;
    $provider = $settings->getProvider('valid_provider');

    expect($provider)->toBe('provider_instance');
});

it('throws exception when invalid provider is given', function(): void {
    $providerManager = Mockery::mock(ProviderManager::class);
    $providerManager->shouldReceive('resolveProvider')->with('invalid_provider')->andThrow(new Exception('Provider not found'));
    app()->instance(ProviderManager::class, $providerManager);

    $settings = new Settings;

    expect(fn() => $settings->getProvider('invalid_provider'))->toThrow(Exception::class, 'Provider not found');
});

it('configures provider model correctly', function(): void {
    $settings = new Settings;

    expect($settings->implement)->toBe([SettingsModel::class])
        ->and($settings->settingsCode)->toBe('igniter_socialite_settings')
        ->and($settings->settingsFieldsConfig)->toBe('settings');
});
