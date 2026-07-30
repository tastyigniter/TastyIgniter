<?php

declare(strict_types=1);

namespace Igniter\PayRegister\Tests;

use Igniter\PayRegister\Classes\PaymentGateways;
use Igniter\PayRegister\Extension;
use Igniter\PayRegister\FormWidgets\PaymentAttempts;
use Igniter\PayRegister\Listeners\UpdatePaymentIntentSessionOnCheckout;
use Igniter\PayRegister\Models\Observers\PaymentObserver;
use Igniter\PayRegister\Models\Payment;
use Igniter\PayRegister\Payments\AuthorizeNetAim;
use Igniter\PayRegister\Payments\Cod;
use Igniter\PayRegister\Payments\Mollie;
use Igniter\PayRegister\Payments\PaypalExpress;
use Igniter\PayRegister\Payments\Square;
use Igniter\PayRegister\Payments\Stripe;
use Igniter\PayRegister\Subscribers\FormFieldsSubscriber;
use Illuminate\Support\Facades\Event;
use Mockery;

beforeEach(function(): void {
    $this->extension = new Extension(app());
});

it('registers payment gateways', function(): void {
    $gateways = $this->extension->registerPaymentGateways();
    expect($gateways)->toHaveKey(Cod::class)
        ->and($gateways[Cod::class]['code'])->toBe('cod')
        ->and($gateways[Cod::class]['name'])->toBe('lang:igniter.payregister::default.cod.text_payment_title')
        ->and($gateways[Cod::class]['description'])->toBe('lang:igniter.payregister::default.cod.text_payment_desc')
        ->and($gateways)->toHaveKey(PaypalExpress::class)
        ->and($gateways[PaypalExpress::class]['code'])->toBe('paypalexpress')
        ->and($gateways[PaypalExpress::class]['name'])->toBe('lang:igniter.payregister::default.paypal.text_payment_title')
        ->and($gateways[PaypalExpress::class]['description'])->toBe('lang:igniter.payregister::default.paypal.text_payment_desc')
        ->and($gateways)->toHaveKey(AuthorizeNetAim::class)
        ->and($gateways[AuthorizeNetAim::class]['code'])->toBe('authorizenetaim')
        ->and($gateways[AuthorizeNetAim::class]['name'])->toBe('lang:igniter.payregister::default.authorize_net_aim.text_payment_title')
        ->and($gateways[AuthorizeNetAim::class]['description'])->toBe('lang:igniter.payregister::default.authorize_net_aim.text_payment_desc')
        ->and($gateways)->toHaveKey(Stripe::class)
        ->and($gateways[Stripe::class]['code'])->toBe('stripe')
        ->and($gateways[Stripe::class]['name'])->toBe('lang:igniter.payregister::default.stripe.text_payment_title')
        ->and($gateways[Stripe::class]['description'])->toBe('lang:igniter.payregister::default.stripe.text_payment_desc')
        ->and($gateways)->toHaveKey(Mollie::class)
        ->and($gateways[Mollie::class]['code'])->toBe('mollie')
        ->and($gateways[Mollie::class]['name'])->toBe('lang:igniter.payregister::default.mollie.text_payment_title')
        ->and($gateways[Mollie::class]['description'])->toBe('lang:igniter.payregister::default.mollie.text_payment_desc')
        ->and($gateways)->toHaveKey(Square::class)
        ->and($gateways[Square::class]['code'])->toBe('square')
        ->and($gateways[Square::class]['name'])->toBe('lang:igniter.payregister::default.square.text_payment_title')
        ->and($gateways[Square::class]['description'])->toBe('lang:igniter.payregister::default.square.text_payment_desc');
});

it('registers form widgets', function(): void {
    $widgets = $this->extension->registerFormWidgets();

    expect($widgets)->toHaveKey(PaymentAttempts::class)
        ->and($widgets[PaymentAttempts::class]['code'])->toBe('paymentattempts');
});

it('registers settings', function(): void {
    $settings = $this->extension->registerSettings();

    expect($settings)->toHaveKey('settings')
        ->and($settings['settings']['label'])->toBe(lang('igniter.payregister::default.text_side_menu'));
});

it('registers permissions', function(): void {
    $permissions = $this->extension->registerPermissions();

    expect($permissions)->toHaveKey('Admin.Payments')
        ->and($permissions['Admin.Payments']['label'])->toBe('igniter.payregister::default.help_permission');
});

it('registers onboarding steps', function(): void {
    $steps = $this->extension->registerOnboardingSteps();

    expect($steps)->toHaveKey('igniter.payregister::payments')
        ->and($steps['igniter.payregister::payments']['label'])->toBe('igniter.payregister::default.onboarding_payments');
});

it('subscribes to events', function(): void {
    $extension = new class(app()) extends Extension
    {
        public function subscribers(): array
        {
            return $this->subscribe;
        }
    };

    expect($extension->subscribers())->toContain(FormFieldsSubscriber::class);
});

it('listens to events', function(): void {
    $extension = new class(app()) extends Extension
    {
        public function listeners(): array
        {
            return $this->listen;
        }
    };

    $listeners = $extension->listeners();

    expect($listeners)->toHaveKey('igniter.checkout.afterSaveOrder')
        ->and($listeners['igniter.checkout.afterSaveOrder'])->toContain(UpdatePaymentIntentSessionOnCheckout::class);
});

it('registers observers', function(): void {
    $extension = new class(app()) extends Extension
    {
        public function observers(): array
        {
            return $this->observers;
        }
    };

    $observers = $extension->observers();

    expect($observers)->toHaveKey(Payment::class)
        ->and($observers[Payment::class])->toBe(PaymentObserver::class);
});

it('registers singletons', function(): void {
    expect($this->extension->singletons)->toContain(PaymentGateways::class);
});

it('syncs payments on theme activation', function(): void {
    Event::shouldReceive('listen')->with('main.theme.activated', Mockery::on(function($callback): true {
        $callback();

        return true;
    }))->once();

    $this->extension->boot();
});
