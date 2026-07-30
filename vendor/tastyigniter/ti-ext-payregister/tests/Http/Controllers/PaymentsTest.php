<?php

declare(strict_types=1);

namespace Igniter\PayRegister\Tests\Http\Controllers;

use Igniter\Admin\Classes\ListColumn;
use Igniter\PayRegister\Classes\PaymentGateways;
use Igniter\PayRegister\Http\Controllers\Payments;
use Igniter\PayRegister\Models\Payment;
use Igniter\PayRegister\Tests\Payments\Fixtures\TestPayment;
use Mockery;
use stdClass;

it('loads payments page', function(): void {
    actingAsSuperUser()
        ->get(route('igniter.payregister.payments'))
        ->assertOk();
});

it('loads create payment page', function(): void {
    actingAsSuperUser()
        ->get(route('igniter.payregister.payments', ['slug' => 'create']))
        ->assertOk();
});

it('loads edit payment page', function(): void {
    $payment = Payment::factory()->create();

    actingAsSuperUser()
        ->get(route('igniter.payregister.payments', ['slug' => 'edit/'.$payment->code]))
        ->assertOk();
});

it('sets icon class to fa-star if record is default', function(): void {
    $payment = Payment::factory()->create([
        'is_default' => 1,
    ]);
    $column = new ListColumn('default', 'Default');
    $column->type = 'button';
    $column->columnName = 'default';

    (new Payments)->listOverrideColumnValue($payment, $column);

    expect($column->iconCssClass)->toBe('fa fa-star');
});

it('sets icon class to fa-star-o if record is not default', function(): void {
    $payment = Payment::factory()->create([
        'is_default' => 0,
    ]);
    $column = new ListColumn('default', 'Default');
    $column->type = 'button';
    $column->columnName = 'default';

    (new Payments)->listOverrideColumnValue($payment, $column);

    expect($column->iconCssClass)->toBe('fa fa-star-o');
});

it('applies gateway class if model does not exist', function(): void {
    $model = Mockery::mock();
    $model->exists = false;
    $model->shouldReceive('applyGatewayClass');

    $extendedModel = (new Payments)->formExtendModel($model);

    expect($extendedModel)->toBe($model);
});

it('does not apply gateway class if model exists', function(): void {
    $model = Mockery::mock(Payment::class);
    $model->exists = true;
    $model->shouldNotReceive('applyGatewayClass');

    $extendedModel = (new Payments)->formExtendModel($model);

    expect($extendedModel)->toBe($model);
});

it('extends form fields before create context', function(): void {
    $model = Mockery::mock(Payment::class);
    $model->shouldReceive('getConfigFields')->andReturn(['field1' => ['label' => 'Field1']]);
    $model->exists = true;

    $form = new stdClass;
    $form->model = $model;
    $form->context = 'create';
    $form->tabs = ['fields' => ['field2' => ['label' => 'Field2']]];

    (new Payments)->formExtendFieldsBefore($form);

    expect($form->tabs['fields'])->toBe(['field2' => ['label' => 'Field2'], 'field1' => ['label' => 'Field1']]);
});

it('extends form fields before non-create context', function(): void {
    $model = Mockery::mock(Payment::class);
    $model->shouldReceive('getConfigFields')->andReturn(['field1' => ['label' => 'Field1']]);
    $model->exists = true;

    $form = new stdClass;
    $form->model = $model;
    $form->context = 'edit';
    $form->tabs = ['fields' => ['field2' => ['label' => 'Field2']]];

    (new Payments)->formExtendFieldsBefore($form);

    expect($form->tabs['fields'])->toBe(['field2' => ['label' => 'Field2'], 'field1' => ['label' => 'Field1']])
        ->and($form->fields['code']['disabled'])->toBeTrue();
});

it('sets a default payment', function(): void {
    $payment = Payment::factory()->create();

    actingAsSuperUser()
        ->post(route('igniter.payregister.payments'), [
            'default' => $payment->code,
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onSetDefault',
        ]);

    expect(Payment::getDefault()->code)->toBe($payment->code);
});

it('creates payment', function(): void {
    $paymentGateways = Mockery::mock(PaymentGateways::class);
    $paymentGateways->shouldReceive('findGateway')->andReturn([
        'class' => TestPayment::class,
    ]);
    app()->instance(PaymentGateways::class, $paymentGateways);

    actingAsSuperUser()
        ->post(route('igniter.payregister.payments', ['slug' => 'create']), [
            'Payment' => [
                'name' => 'Created Payment',
                'code' => 'test_code',
                'payment' => 'created_payment',
                'description' => 'Created Payment Description',
                'class_name' => TestPayment::class,
                'is_default' => 1,
                'priority' => 1,
                'status' => 1,
            ],
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onSave',
        ]);

    expect(Payment::where('name', 'Created Payment')->exists())->toBeTrue();
});

it('updates payment', function(): void {
    $payment = Payment::factory()->create();

    actingAsSuperUser()
        ->post(route('igniter.payregister.payments', ['slug' => 'edit/'.$payment->code]), [
            'Payment' => [
                'name' => 'Updated Payment',
                'code' => 'updated_payment',
                'description' => 'Updated Payment Description',
                'class_name' => TestPayment::class,
                'priority' => 1,
                'is_default' => 1,
                'status' => 1,
                'test_field' => 'test_value',
            ],
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onSave',
        ]);

    expect(Payment::where('name', 'Updated Payment')->exists())->toBeTrue();
});

it('deletes payment', function(): void {
    $payment = Payment::factory()->create();

    actingAsSuperUser()
        ->post(route('igniter.payregister.payments', ['slug' => 'edit/'.$payment->code]), [], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onDelete',
        ]);

    expect(Payment::where('code', $payment->code)->exists())->toBeFalse();
});
