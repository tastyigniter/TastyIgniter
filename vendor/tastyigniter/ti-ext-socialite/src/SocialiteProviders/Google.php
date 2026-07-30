<?php

declare(strict_types=1);

namespace Igniter\Socialite\SocialiteProviders;

use Igniter\Admin\Widgets\Form;
use Igniter\Socialite\Classes\BaseProvider;
use Laravel\Socialite\Two\GoogleProvider;
use Override;
use Socialite;

class Google extends BaseProvider
{
    protected $provider = GoogleProvider::class;

    #[Override]
    public function extendSettingsForm(Form $form): void
    {
        $form->addFields([
            'setup' => [
                'type' => 'partial',
                'path' => 'igniter.socialite::google.info',
                'tab' => 'Google',
            ],
            'providers[google][status]' => [
                'label' => 'Status',
                'type' => 'switch',
                'default' => true,
                'span' => 'left',
                'tab' => 'Google',
            ],
            'providers[google][app_name]' => [
                'label' => 'Application Name',
                'type' => 'text',
                'default' => 'Social Login',
                'comment' => 'This appears on the Google login screen. Usually your site name.',
                'tab' => 'Google',
            ],
            'providers[google][client_id]' => [
                'label' => 'Client ID',
                'type' => 'text',
                'tab' => 'Google',
            ],
            'providers[google][client_secret]' => [
                'label' => 'Client Secret',
                'type' => 'text',
                'tab' => 'Google',
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
