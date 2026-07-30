<?php

declare(strict_types=1);

namespace Igniter\Socialite;

use Igniter\Admin\Widgets\Form;
use Igniter\Socialite\Classes\ProviderManager;
use Igniter\Socialite\Models\Settings;
use Igniter\Socialite\SocialiteProviders\Facebook;
use Igniter\Socialite\SocialiteProviders\Google;
use Igniter\Socialite\SocialiteProviders\Twitter;
use Igniter\System\Classes\BaseExtension;
use Igniter\System\Http\Controllers\Extensions;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Event;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\SocialiteServiceProvider;
use Override;

/**
 * Socialite Extension Information File
 */
class Extension extends BaseExtension
{
    #[Override]
    public function register(): void
    {
        $this->app->singleton(ProviderManager::class);

        $this->app->register(SocialiteServiceProvider::class);
        AliasLoader::getInstance()->alias('Socialite', Socialite::class);
    }

    #[Override]
    public function boot(): void
    {
        $this->extendSettingsFormField();
    }

    #[Override]
    public function registerSettings(): array
    {
        return [
            'settings' => [
                'label' => 'Configure Social Login Providers',
                'description' => 'Configure social login providers with API credentials.',
                'icon' => 'fa fa-share-nodes',
                'model' => Settings::class,
                'priority' => 700,
                'permissions' => ['Igniter.Socialite.Manage'],
            ],
        ];
    }

    #[Override]
    public function registerPermissions(): array
    {
        return [
            'Igniter.Socialite.Manage' => [
                'label' => 'igniter.socialite::default.help_permission',
                'group' => 'igniter::admin.permissions.name',
            ],
        ];
    }

    public function registerSocialiteProviders(): array
    {
        return [
            Facebook::class => [
                'code' => 'facebook',
                'label' => 'Facebook',
                'description' => 'Log in with Facebook',
            ],
            Google::class => [
                'code' => 'google',
                'label' => 'Google',
                'description' => 'Log in with Google',
            ],
            Twitter::class => [
                'code' => 'twitter',
                'label' => 'Twitter',
                'description' => 'Log in with Twitter',
            ],
        ];
    }

    protected function extendSettingsFormField()
    {
        Event::listen('admin.form.extendFields', function(Form $form): void {
            if (
                $form->getController() instanceof Extensions
                && $form->model instanceof Settings
            ) {
                $manager = resolve(ProviderManager::class);
                foreach ($manager->listProviders() as $class => $details) {
                    $provider = $manager->makeProvider($class, $details);
                    $provider->extendSettingsForm($form);
                }
            }
        });
    }
}
