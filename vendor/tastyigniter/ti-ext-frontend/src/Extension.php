<?php

declare(strict_types=1);

namespace Igniter\Frontend;

use DrewM\MailChimp\MailChimp;
use Igniter\Frontend\Classes\ReCaptcha;
use Igniter\Frontend\Models\CaptchaSettings;
use Igniter\Frontend\Models\MailchimpSettings;
use Igniter\System\Classes\BaseExtension;
use Illuminate\Support\Facades\Validator;
use Override;

class Extension extends BaseExtension
{
    #[Override]
    public function boot(): void
    {
        $this->addCaptchaValidationRule();
    }

    #[Override]
    public function register(): void
    {
        $this->registerReCaptcha();

        $this->app->singleton(MailChimp::class, fn(): MailChimp => new MailChimp(MailchimpSettings::getApiKey()));
    }

    #[Override]
    public function registerNavigation(): array
    {
        return [
            'design' => [
                'child' => [
                    'sliders' => [
                        'priority' => 30,
                        'class' => 'sliders',
                        'href' => admin_url('igniter/frontend/sliders'),
                        'title' => lang('igniter.frontend::default.text_side_menu'),
                        'permission' => ['Igniter.FrontEnd.ManageBanners', 'Igniter.FrontEnd.ManageSlideshow'],
                    ],
                ],
            ],
        ];
    }

    #[Override]
    public function registerPermissions(): array
    {
        return [
            'Igniter.FrontEnd.ManageSettings' => [
                'description' => 'Configure google recaptcha and mailchimp settings',
                'group' => 'igniter::admin.permissions.name',
            ],
            'Igniter.FrontEnd.ManageBanners' => [
                'description' => 'Create, modify and delete front-end banners',
                'group' => 'igniter::admin.permissions.name',
            ],
            'Igniter.FrontEnd.ManageSlideshow' => [
                'group' => 'igniter::admin.permissions.name',
                'description' => 'Create, modify and delete front-end sliders',
            ],
        ];
    }

    #[Override]
    public function registerSettings(): array
    {
        return [
            'captchasettings' => [
                'label' => 'reCaptcha Settings',
                'description' => 'Manage google reCAPTCHA settings.',
                'icon' => 'fa fa-robot',
                'model' => CaptchaSettings::class,
                'permissions' => ['Igniter.FrontEnd.ManageSettings'],
            ],
            'mailchimpsettings' => [
                'label' => 'Mailchimp Settings',
                'description' => 'Manage Mailchimp API settings.',
                'icon' => 'fab fa-mailchimp',
                'model' => MailchimpSettings::class,
                'permissions' => ['Igniter.FrontEnd.ManageSettings'],
            ],
        ];
    }

    #[Override]
    public function registerMailTemplates(): array
    {
        return [
            'igniter.frontend::mail.contact' => 'Contact form email to admin',
        ];
    }

    protected function registerReCaptcha()
    {
        $this->app->singleton('recaptcha', fn($app): ReCaptcha => new ReCaptcha(CaptchaSettings::getApiSecretKey(), CaptchaSettings::getVersion()));
    }

    /**
     * Extends Validator to include a recaptcha type
     */
    protected function addCaptchaValidationRule()
    {
        Validator::extendImplicit('recaptcha', fn($attribute, $value, $parameters, $validator) => app('recaptcha')->verifyResponse($value), lang('igniter.frontend::default.captcha.error_recaptcha'));
    }
}
