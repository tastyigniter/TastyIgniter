<?php

declare(strict_types=1);

namespace Igniter\Socialite\Tests;

use Igniter\Admin\Widgets\Form;
use Igniter\Socialite\Classes\ProviderManager;
use Igniter\Socialite\Extension;
use Igniter\Socialite\Models\Settings;
use Igniter\Socialite\SocialiteProviders\Facebook;
use Igniter\Socialite\SocialiteProviders\Google;
use Igniter\Socialite\SocialiteProviders\Twitter;
use Igniter\System\Http\Controllers\Extensions;
use Illuminate\Support\Facades\Event;
use Mockery;

it('registers settings with correct configuration', function(): void {
    $extension = new Extension(app());
    $settings = $extension->registerSettings();

    expect($settings)->toHaveKey('settings')
        ->and($settings['settings']['model'])->toBe(Settings::class)
        ->and($settings['settings']['priority'])->toBe(700)
        ->and($settings['settings']['permissions'])->toContain('Igniter.Socialite.Manage');
});

it('registers permissions with correct configuration', function(): void {
    $extension = new Extension(app());
    $permissions = $extension->registerPermissions();

    expect($permissions)->toHaveKey('Igniter.Socialite.Manage')
        ->and($permissions['Igniter.Socialite.Manage']['label'])->toBe('igniter.socialite::default.help_permission')
        ->and($permissions['Igniter.Socialite.Manage']['group'])->toBe('igniter::admin.permissions.name');
});

it('registers socialite providers correctly', function(): void {
    $extension = new Extension(app());
    $providers = $extension->registerSocialiteProviders();

    expect($providers)
        ->toHaveKey(Facebook::class)
        ->toHaveKey(Google::class)
        ->toHaveKey(Twitter::class)
        ->and($providers[Facebook::class]['code'])->toBe('facebook')
        ->and($providers[Facebook::class]['description'])->toBe('Log in with Facebook')
        ->and($providers[Google::class]['code'])->toBe('google')
        ->and($providers[Google::class]['description'])->toBe('Log in with Google')
        ->and($providers[Twitter::class]['code'])->toBe('twitter')
        ->and($providers[Twitter::class]['description'])->toBe('Log in with Twitter');
});

it('extends settings form field correctly', function(): void {
    $form = new class extends Form
    {
        public function __construct() {}

        public function getController(): Extensions
        {
            return new Extensions;
        }

        public function addFields(array $fields, string $addToArea = ''): void
        {
            expect($fields)->toHaveKeys([
                'setup',
                'providers[facebook][status]',
                'providers[facebook][client_id]',
                'providers[facebook][client_secret]',
            ]);
        }
    };
    $form->model = new Settings;

    $providerManager = Mockery::mock(ProviderManager::class);
    $providerManager->shouldReceive('listProviders')->andReturn([
        Facebook::class => [
            'code' => 'facebook',
            'label' => 'Facebook',
            'description' => 'Log in with Facebook',
        ],
    ]);
    $providerManager->shouldReceive('makeProvider')->andReturn(new Facebook);
    app()->instance(ProviderManager::class, $providerManager);

    (new Extension(app()))->boot();

    Event::dispatch('admin.form.extendFields', [$form]);
});
