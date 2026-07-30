<?php

declare(strict_types=1);

namespace Igniter\PayRegister\Tests\Subscribers;

use Igniter\Admin\Widgets\Form;
use Igniter\Cart\Models\Order;
use Igniter\PayRegister\Subscribers\FormFieldsSubscriber;
use Illuminate\Contracts\Events\Dispatcher;
use Mockery;

beforeEach(function(): void {
    $this->subscriber = new FormFieldsSubscriber;
    $this->form = new class extends Form
    {
        public function __construct() {}
    };
    $this->order = Mockery::mock(Order::class)->makePartial();
});

it('subscribes to admin.form.extendFieldsBefore event', function(): void {
    $events = $this->subscriber->subscribe(Mockery::mock(Dispatcher::class));

    expect($events)->toHaveKey('admin.form.extendFieldsBefore')
        ->and($events['admin.form.extendFieldsBefore'])->toBe('handle');
});

it('adds payment logs field to form if model is Order', function(): void {
    $this->form->model = $this->order;
    $this->form->tabs = ['fields' => []];

    $this->subscriber->handle($this->form);

    expect($this->form->tabs['fields'])->toHaveKey('payment_logs')
        ->and($this->form->tabs['fields']['payment_logs']['tab'])->toBe('lang:igniter.payregister::default.text_payment_logs')
        ->and($this->form->tabs['fields']['payment_logs']['type'])->toBe('paymentattempts');
});

it('does not add payment logs field to form if model is not Order', function(): void {
    $this->form->model = Mockery::mock('NonOrderModel');
    $this->form->tabs = ['fields' => []];

    $this->subscriber->handle($this->form);

    expect($this->form->tabs['fields'])->not->toHaveKey('payment_logs');
});
