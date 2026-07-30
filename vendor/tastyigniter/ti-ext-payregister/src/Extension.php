<?php

declare(strict_types=1);

namespace Igniter\PayRegister;

use Igniter\PayRegister\Classes\AuthorizeNetClient;
use Igniter\PayRegister\Classes\PaymentGateways;
use Igniter\PayRegister\Classes\PayPalClient;
use Igniter\PayRegister\FormWidgets\PaymentAttempts;
use Igniter\PayRegister\Listeners\CaptureAuthorizedPayment;
use Igniter\PayRegister\Listeners\UpdatePaymentIntentSessionOnCheckout;
use Igniter\PayRegister\Models\Observers\PaymentObserver;
use Igniter\PayRegister\Models\Observers\PaymentProfileObserver;
use Igniter\PayRegister\Models\Payment;
use Igniter\PayRegister\Models\PaymentLog;
use Igniter\PayRegister\Models\PaymentProfile;
use Igniter\PayRegister\Payments\AuthorizeNetAim;
use Igniter\PayRegister\Payments\Cod;
use Igniter\PayRegister\Payments\Mollie;
use Igniter\PayRegister\Payments\PaypalExpress;
use Igniter\PayRegister\Payments\Square;
use Igniter\PayRegister\Payments\Stripe;
use Igniter\PayRegister\Subscribers\FormFieldsSubscriber;
use Igniter\System\Classes\BaseExtension;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Event;
use Mollie\Api\MollieApiClient;
use Override;
use Square\SquareClientBuilder;

class Extension extends BaseExtension
{
    protected $subscribe = [
        FormFieldsSubscriber::class,
    ];

    protected $listen = [
        'igniter.checkout.afterSaveOrder' => [
            UpdatePaymentIntentSessionOnCheckout::class,
        ],
        'admin.statusHistory.added' => [
            CaptureAuthorizedPayment::class,
        ],
    ];

    protected $observers = [
        Payment::class => PaymentObserver::class,
        PaymentProfile::class => PaymentProfileObserver::class,
    ];

    public array $singletons = [
        AuthorizeNetClient::class,
        MollieApiClient::class,
        PaymentGateways::class,
        PayPalClient::class,
        SquareClientBuilder::class,
    ];

    #[Override]
    public function registerPaymentGateways(): array
    {
        return [
            Cod::class => [
                'code' => 'cod',
                'name' => 'lang:igniter.payregister::default.cod.text_payment_title',
                'description' => 'lang:igniter.payregister::default.cod.text_payment_desc',
            ],
            PaypalExpress::class => [
                'code' => 'paypalexpress',
                'name' => 'lang:igniter.payregister::default.paypal.text_payment_title',
                'description' => 'lang:igniter.payregister::default.paypal.text_payment_desc',
            ],
            AuthorizeNetAim::class => [
                'code' => 'authorizenetaim',
                'name' => 'lang:igniter.payregister::default.authorize_net_aim.text_payment_title',
                'description' => 'lang:igniter.payregister::default.authorize_net_aim.text_payment_desc',
            ],
            Stripe::class => [
                'code' => 'stripe',
                'name' => 'lang:igniter.payregister::default.stripe.text_payment_title',
                'description' => 'lang:igniter.payregister::default.stripe.text_payment_desc',
            ],
            Mollie::class => [
                'code' => 'mollie',
                'name' => 'lang:igniter.payregister::default.mollie.text_payment_title',
                'description' => 'lang:igniter.payregister::default.mollie.text_payment_desc',
            ],
            Square::class => [
                'code' => 'square',
                'name' => 'lang:igniter.payregister::default.square.text_payment_title',
                'description' => 'lang:igniter.payregister::default.square.text_payment_desc',
            ],
        ];
    }

    #[Override]
    public function registerFormWidgets(): array
    {
        return [
            PaymentAttempts::class => [
                'label' => 'Payment Attempts',
                'code' => 'paymentattempts',
            ],
        ];
    }

    #[Override]
    public function registerSettings(): array
    {
        return [
            'settings' => [
                'label' => lang('igniter.payregister::default.text_side_menu'),
                'description' => 'Manage payment gateways and settings',
                'icon' => 'fa fa-credit-card',
                'priority' => -1,
                'permissions' => ['Admin.Payments'],
                'url' => admin_url('payments'),
            ],
        ];
    }

    #[Override]
    public function registerPermissions(): array
    {
        return [
            'Admin.Payments' => [
                'label' => 'igniter.payregister::default.help_permission',
                'group' => 'igniter.payregister::default.text_permission_group',
            ],
        ];
    }

    public function registerOnboardingSteps(): array
    {
        return [
            'igniter.payregister::payments' => [
                'label' => 'igniter.payregister::default.onboarding_payments',
                'description' => 'igniter.payregister::default.help_onboarding_payments',
                'icon' => 'fa-credit-card',
                'url' => admin_url('payments'),
                'priority' => 35,
                'complete' => Payment::onboardingIsComplete(...),
            ],
        ];
    }

    #[Override]
    public function boot(): void
    {
        Event::listen('main.theme.activated', function(): void {
            Payment::syncAll();
        });

        Relation::enforceMorphMap([
            'payment_logs' => PaymentLog::class,
            'payments' => Payment::class,
        ]);

        VerifyCsrfToken::except([
            'ti_payregister/*',
        ]);
    }
}
