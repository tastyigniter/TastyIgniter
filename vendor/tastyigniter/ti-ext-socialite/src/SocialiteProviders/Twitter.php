<?php

declare(strict_types=1);

namespace Igniter\Socialite\SocialiteProviders;

use Igniter\Admin\Widgets\Form;
use Igniter\Socialite\Classes\BaseProvider;
use Laravel\Socialite\One\TwitterProvider;
use League\OAuth1\Client\Server\Twitter as TwitterServer;
use Override;
use Socialite;

class Twitter extends BaseProvider
{
    protected $provider = TwitterProvider::class;

    #[Override]
    protected function buildProvider($config, $app)
    {
        return new $this->provider(
            $app['request'], new TwitterServer($config)
        );
    }

    #[Override]
    public function extendSettingsForm(Form $form): void
    {
        $form->addFields([
            'setup' => [
                'type' => 'partial',
                'path' => 'igniter.socialite::twitter.info',
                'tab' => 'Twitter',
            ],
            'providers[twitter][status]' => [
                'label' => 'Status',
                'type' => 'switch',
                'default' => true,
                'span' => 'left',
                'tab' => 'Twitter',
            ],
            'providers[twitter][identifier]' => [
                'label' => 'API Key',
                'type' => 'text',
                'tab' => 'Twitter',
            ],

            'providers[twitter][secret]' => [
                'label' => 'API Secret',
                'type' => 'text',
                'tab' => 'Twitter',
            ],
        ], 'primary');
    }

    #[Override]
    public function redirectToProvider()
    {
        return Socialite::driver($this->driver)->redirect();
    }

    #[Override]
    public function handleProviderCallback()
    {
        return Socialite::driver($this->driver)->user();
    }

    #[Override]
    public function shouldConfirmEmail($providerUser): bool
    {
        return !strlen((string)$providerUser->email);
    }
}
