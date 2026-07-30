<?php

declare(strict_types=1);

namespace Igniter\Socialite\Tests\SocialiteProviders;

use Igniter\Admin\Widgets\Form;
use Igniter\Socialite\SocialiteProviders\Facebook;
use Laravel\Socialite\AbstractUser;
use Laravel\Socialite\Facades\Socialite;
use Mockery;

it('extends settings form with Facebook fields', function(): void {
    $form = new class extends Form
    {
        public function __construct() {}

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

    (new Facebook)->extendSettingsForm($form);
});

it('redirects to Facebook provider with email scope', function(): void {
    Socialite::shouldReceive('extend')->andReturnSelf();
    Socialite::shouldReceive('driver')->with('facebook')->andReturnSelf();
    Socialite::shouldReceive('scopes')->with(['email'])->andReturnSelf();
    Socialite::shouldReceive('redirect')->andReturn('redirect_response');

    $response = (new Facebook('facebook'))->redirectToProvider();

    expect($response)->toBe('redirect_response');
});

it('handles Facebook provider callback and returns user', function(): void {
    Socialite::shouldReceive('extend')->andReturnSelf();
    Socialite::shouldReceive('driver')->with('facebook')->andReturnSelf();
    Socialite::shouldReceive('user')->andReturn('user_instance');

    $user = (new Facebook('facebook'))->handleProviderCallback();

    expect($user)->toBe('user_instance');
});

it('confirms email if facebook provider user has no email', function(): void {
    $providerUser = Mockery::mock(AbstractUser::class);
    $providerUser->email = '';

    $shouldConfirm = (new Facebook('facebook'))->shouldConfirmEmail($providerUser);

    expect($shouldConfirm)->toBeTrue();
});

it('does not confirm email if facebook provider user has email', function(): void {
    $providerUser = Mockery::mock(AbstractUser::class);
    $providerUser->email = 'user@example.com';

    $shouldConfirm = (new Facebook('facebook'))->shouldConfirmEmail($providerUser);

    expect($shouldConfirm)->toBeFalse();
});
