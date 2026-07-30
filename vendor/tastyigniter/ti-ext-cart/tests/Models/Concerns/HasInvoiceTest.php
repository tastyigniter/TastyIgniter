<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\Models\Concerns;

use Carbon\Carbon;
use Igniter\Cart\Models\Order;

it('generates invoice correctly', function(): void {
    $order = Order::factory()->create();

    expect($order->hasInvoice())->toBeFalse();

    $order->generateInvoice();

    expect($order->hasInvoice())->toBeTrue()
        ->and($order->invoice_number)->toBe($order->invoice_prefix.$order->order_id);
});

it('gets invoice number correctly', function(): void {
    $order = Order::factory()->create([
        'invoice_prefix' => 'INV-2022-',
        'order_id' => 1,
    ]);

    expect($order->invoice_number)->toBe('INV-2022-1');
});

it('returns null for invoice number when prefix is not set', function(): void {
    $order = Order::factory()->create([
        'invoice_prefix' => '',
    ]);

    expect($order->invoice_number)->toBeNull();
});

it('generates invoice prefix correctly', function(): void {
    $order = Order::factory()->create([
        'invoice_date' => Carbon::create(2022),
    ]);

    $prefix = $order->generateInvoicePrefix();

    expect($prefix)->toBe('INV-2022-00');
});

it('generates invoice on order save', function(): void {
    $order = Order::factory()->createQuietly([
        'processed' => 1,
        'status_id' => 1,
        'invoice_prefix' => 'INV-2022-',
    ]);

    expect($order->hasInvoice())->toBeFalse();

    $order->status_id = 2;
    $order->save();
    $order->generateInvoice();

    expect($order->hasInvoice())->toBeTrue();
});
