<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\Classes;

use Igniter\Cart\Classes\CheckoutForm;
use Igniter\Flame\Database\Model;

it('initializes with default config', function(): void {
    $checkoutForm = new CheckoutForm;

    expect($checkoutForm->config)->toBeArray()
        ->and($checkoutForm->config)->toBeEmpty();
});

it('fills config from provided array', function(): void {
    $config = [
        'fields' => [],
        'model' => new class extends Model {},
    ];
    $checkoutForm = new CheckoutForm($config);

    $checkoutForm->initialize();

    expect($checkoutForm->config['fields'])->toBeArray()
        ->and($checkoutForm->config['model'])->toBeInstanceOf(Model::class);
});

it('returns validation rules with prefixed keys', function(): void {
    $config = ['rules' => ['name' => 'required']];
    $checkoutForm = new CheckoutForm($config);

    $checkoutForm->initialize();

    $rules = $checkoutForm->validationRules();

    expect($rules)->toHaveKey('fields.name')
        ->and($rules['fields.name'])->toEqual('required');
});

it('returns validation messages with prefixed keys', function(): void {
    $config = ['messages' => ['name.required' => 'Name is required']];
    $checkoutForm = new CheckoutForm($config);

    $checkoutForm->initialize();

    $messages = $checkoutForm->validationMessages();

    expect($messages)->toHaveKey('fields.name.required')
        ->and($messages['fields.name.required'])->toEqual('Name is required');
});

it('returns validation attributes with prefixed keys', function(): void {
    $config = ['fields' => ['name' => ['label' => 'Name']]];
    $checkoutForm = new CheckoutForm($config);

    $checkoutForm->initialize();

    $attributes = $checkoutForm->validationAttributes();

    expect($attributes)->toHaveKey('fields.name')
        ->and($attributes['fields.name'])->toEqual('Name');
});

it('defines form fields correctly', function(): void {
    $config = [
        'fields' => [
            'name' => ['label' => 'Name', 'type' => 'text'],
            'country' => ['label' => 'Country', 'type' => 'select', 'options' => ['country' => 'Country']],
        ],
    ];
    $checkoutForm = new CheckoutForm($config);

    $checkoutForm->initialize();

    $allFields = $checkoutForm->getFields();

    expect($allFields)->toHaveKey('name')
        ->and($allFields['name']->label)->toEqual('Name')
        ->and($allFields['name']->type)->toEqual('text')
        ->and($allFields['country']->options())->toEqual(['country' => 'Country']);
});

it('does not define form fields when already defined', function(): void {
    $config = [
        'fields' => [
            'name' => ['label' => 'Name', 'type' => 'text'],
        ],
    ];
    $checkoutForm = new CheckoutForm($config);
    $checkoutForm->initialize();

    $allFields = $checkoutForm->getFields();

    expect($allFields)->toHaveKey('name')
        ->and($allFields['name']->label)->toEqual('Name');

    $checkoutForm->config['fields']['name']['label'] = 'Full Name';
    $checkoutForm->initialize();
    $allFields = $checkoutForm->getFields();

    expect($allFields)->toHaveKey('name')
        ->and($allFields['name']->label)->toEqual('Name');
});
