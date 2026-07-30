<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\Classes;

use Igniter\Cart\Classes\OrderTypes;
use Igniter\Cart\OrderTypes\Delivery;
use Igniter\Local\Models\Location as LocationModel;
use Illuminate\Support\Collection;

it('makes order types', function(): void {
    $orderTypes = new OrderTypes;
    $location = new LocationModel;

    $result = $orderTypes->makeOrderTypes($location);

    expect($result)->toBeInstanceOf(Collection::class);
});

it('gets order type', function(): void {
    $orderTypes = new OrderTypes;

    $result = $orderTypes->getOrderType('delivery');

    expect($result)->toBeArray()
        ->toHaveKey('className')
        ->toHaveKey('code')
        ->toHaveKey('name');
});

it('lists order types', function(): void {
    $orderTypes = new OrderTypes;

    $result = $orderTypes->listOrderTypes();

    expect($result)->toBeArray();
});

it('registers order types', function(): void {
    $orderTypes = new OrderTypes;

    $orderTypes->registerOrderTypes([
        Delivery::class => ['code' => 'delivery', 'name' => 'Delivery'],
    ]);

    $result = $orderTypes->listOrderTypes();

    expect($result)->toHaveKey('delivery');
});

it('registers order type', function(): void {
    $orderTypes = new OrderTypes;

    $orderTypes->registerOrderType(Delivery::class, ['code' => 'delivery', 'name' => 'Delivery']);

    $result = $orderTypes->listOrderTypes();

    expect($result)->toHaveKey('delivery');
});

it('registers callback', function(): void {
    $orderTypes = new OrderTypes;

    $orderTypes->registerCallback(function($orderTypes): void {
        $orderTypes->registerOrderType('TestOrderType', ['code' => 'test']);
    });

    $orderType = $orderTypes->getOrderType('test');

    expect($orderType)->toBeArray()
        ->and($orderType['className'])->toBe('TestOrderType')
        ->and($orderType['code'])->toBe('test')
        ->and($orderType['name'])->toBe('test');
});
