<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\Classes;

use Igniter\Cart\Classes\CheckoutFormField;

it('returns field name with array name prefix', function(): void {
    $field = new CheckoutFormField('testField');
    $field->arrayName = 'testArray';

    $name = $field->getName();

    expect($name)->toEqual('testArray.testField');
});

it('returns field name without array name prefix', function(): void {
    $field = new CheckoutFormField('testField');

    $name = $field->getName();

    expect($name)->toEqual('testField');
});

it('returns field id with array name, prefix and suffix', function(): void {
    $field = new CheckoutFormField('testField');
    $field->arrayName = 'testArray';
    $field->idPrefix = 'checkout';

    $id = $field->getId('suffix');

    expect($id)->toEqual('checkout-testarray-testfield-suffix');
});

it('returns field id with array name and suffix', function(): void {
    $field = new CheckoutFormField('testField');
    $field->arrayName = 'testArray';

    $id = $field->getId('suffix');

    expect($id)->toEqual('-testarray-testfield-suffix');
});

it('returns field id without array name and with suffix', function(): void {
    $field = new CheckoutFormField('testField');

    $id = $field->getId('suffix');

    expect($id)->toEqual('-testfield-suffix');
});

it('returns field id with id prefix', function(): void {
    $field = new CheckoutFormField('testField');
    $field->idPrefix = 'prefix';

    $id = $field->getId();

    expect($id)->toEqual('prefix-testfield');
});
