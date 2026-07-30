<?php

declare(strict_types=1);

namespace Igniter\Socialite\SocialiteProviders;

use Igniter\Admin\Widgets\Form;
use Igniter\Socialite\Classes\BaseProvider;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\FacebookProvider;
use Override;

class Facebook extends BaseProvider
{
    protected $provider = FacebookProvider::class;

    #[Override]
    public function extendSettingsForm(Form $form): void
    {
        $form->addFields([
            'setup' => [
                'type' => 'partial',
                'path' => 'igniter.socialite::facebook.info',
                'tab' => 'Facebook',
            ],
            'providers[facebook][status]' => [
                'label' => 'Status',
                'type' => 'switch',
                'default' => true,
                'span' => 'left',
                'tab' => 'Facebook',
            ],
            'providers[facebook][client_id]' => [
                'label' => 'App ID',
                'type' => 'text',
                'tab' => 'Facebook',
            ],
            'providers[facebook][client_secret]' => [
                'label' => 'App Secret',
                'type' => 'text',
                'tab' => 'Facebook',
            ],
        ], 'primary');
    }

    #[Override]
    public function redirectToProvider()
    {
        return Socialite::driver($this->driver)->scopes(['email'])->redirect();
    }

    #[Override]
    public function handleProviderCallback()
    {
        return Socialite::driver($this->driver)->user();
    }

    #[Override]
    public function shouldConfirmEmail($providerUser): bool
    {
        return empty($providerUser->email);
    }
}
