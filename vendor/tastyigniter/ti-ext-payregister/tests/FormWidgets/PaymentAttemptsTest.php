<?php

declare(strict_types=1);

namespace Igniter\PayRegister\Tests\FormWidgets;

use Igniter\Admin\Classes\FormField;
use Igniter\Admin\FormWidgets\DataTable;
use Igniter\Cart\Http\Controllers\Orders;
use Igniter\Cart\Models\Order;
use Igniter\Flame\Exception\FlashException;
use Igniter\PayRegister\FormWidgets\PaymentAttempts;
use Igniter\PayRegister\Models\Payment;
use Igniter\PayRegister\Models\PaymentLog;
use Igniter\PayRegister\Tests\Payments\Fixtures\TestPaymentWithNoRefund;
use Igniter\PayRegister\Tests\Payments\Fixtures\TestPaymentWithRefund;

beforeEach(function(): void {
    $this->order = Order::factory()->state([
        'order_total' => 100.00,
    ])->create();
    $this->paymentLog = PaymentLog::factory()->for($this->order)->create();
    $this->widget = new PaymentAttempts(
        resolve(Orders::class),
        new FormField('test_field', 'Payment attempts'),
        [
            'model' => $this->order,
            'form' => [
                'fields' => [
                    'payment_log_id' => [
                        'type' => 'hidden',
                    ],
                ],
            ],
            'columns' => ['order_id', 'order_total'],
        ],
    );
});

it('initializes with config', function(): void {
    expect($this->widget->form)->toBe(['fields' => [
        'payment_log_id' => [
            'type' => 'hidden',
        ],
    ]])->and($this->widget->formTitle)->toBe('igniter.payregister::default.text_refund_title');
});

it('prepares vars', function(): void {
    $this->widget->prepareVars();

    expect($this->widget->vars['field'])->toBeInstanceOf(FormField::class)
        ->and($this->widget->vars['dataTableWidget'])->toBeInstanceOf(DataTable::class);
});

it('returns no save data for getSaveValue', function(): void {
    $result = $this->widget->getSaveValue('some_value');

    expect($result)->toBe(FormField::NO_SAVE_DATA);
});

it('throws exception if record not found on load record', function(): void {
    $this->expectException(FlashException::class);
    $this->expectExceptionMessage('Record not found');

    request()->merge(['recordId' => '123']);

    $this->widget->onLoadRecord();
});

it('loads record successfully', function(): void {
    request()->merge(['recordId' => $this->paymentLog->getKey()]);
    $result = $this->widget->onLoadRecord();

    expect($result)->toContain('Refund: £100.00');
});

it('throws exception if no successful payment to refund', function(): void {
    $payment = Payment::factory()->create([
        'class_name' => TestPaymentWithNoRefund::class,
    ]);
    $payment->applyGatewayClass();

    $this->order->payment_method = $payment;

    $this->expectException(FlashException::class);
    $this->expectExceptionMessage('No successful payment to refund');

    request()->merge(['recordId' => $this->paymentLog->getKey()]);
    $this->widget->onSaveRecord();
});

it('saves record successfully', function(): void {
    $payment = Payment::factory()->create([
        'class_name' => TestPaymentWithRefund::class,
    ]);
    $payment->applyGatewayClass();

    $this->order->payment_method = $payment;

    request()->merge(['recordId' => $this->paymentLog->getKey()]);
    $result = $this->widget->onSaveRecord();

    expect($result)->toBeArray()
        ->toHaveKey('#notification')
        ->toHaveKey('~#paymentattempts-test-field');
});
