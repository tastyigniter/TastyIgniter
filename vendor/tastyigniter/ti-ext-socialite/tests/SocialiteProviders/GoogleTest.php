<?php

declare(strict_types=1);

namespace Igniter\Socialite\Tests\SocialiteProviders;

use Igniter\Admin\Widgets\Form;
use Igniter\Socialite\SocialiteProviders\Google;
use Laravel\Socialite\AbstractUser;
use Laravel\Socialite\Facades\Socialite;
use Mockery;

it('extends settings form with Google fields', function(): void {
    $form = new class extends Form
    {
        public function __construct() {}

        public function addFields(array $fields, string $addToArea = ''): void
        {
            expect($fields)->toHaveKeys([
                'setup',
                'providers[google][status]',
                'providers[google][app_name]',
                'providers[google][client_id]',
                'providers[google][client_secret]',
            ]);
        }
    };

    (new Google('google'))->extendSettingsForm($form);
});

it('redirects to Google provider', function(): void {
    Socialite::shouldReceive('extend')->andReturnSelf();
    Socialite::shouldReceive('driver')->with('google')->andReturnSelf();
    Socialite::shouldReceive('redirect')->andReturn('redirect_response');

    $response = (new Google('google'))->redirectToProvider();

    expect($response)->toBe('redirect_response');
});

it('handles Google provider callback and returns user', function(): void {
    Socialite::shouldReceive('extend')->andReturnSelf();
    Socialite::shouldReceive('driver')->with('google')->andReturnSelf();
    Socialite::shouldReceive('user')->andReturn('user_instance');

    $user = (new Google('google'))->handleProviderCallback();

    expect($user)->toBe('user_instance');
});

it('confirms email if google provider user has no email', function(): void {
    $providerUser = Mockery::mock(AbstractUser::class);
    $providerUser->email = '';

    $shouldConfirm = (new Google('google'))->shouldConfirmEmail($providerUser);

    expect($shouldConfirm)->toBeTrue();
});

it('does not confirm email if google provider user has email', function(): void {
    $providerUser = Mockery::mock(AbstractUser::class);
    $providerUser->email = 'user@example.com';

    $shouldConfirm = (new Google('google'))->shouldConfirmEmail($providerUser);

    expect($shouldConfirm)->toBeFalse();
});
