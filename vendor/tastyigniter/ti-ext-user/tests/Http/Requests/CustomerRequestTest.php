<?php

declare(strict_types=1);

namespace Igniter\User\Tests\Http\Requests;

use Igniter\User\Http\Requests\CustomerRequest;
use Illuminate\Routing\Route;

it('returns correct attribute labels for customer', function(): void {
    $attributes = (new CustomerRequest)->attributes();

    expect($attributes['first_name'])->toBe(lang('igniter.user::default.customers.label_first_name'))
        ->and($attributes['last_name'])->toBe(lang('igniter.user::default.customers.label_last_name'))
        ->and($attributes['email'])->toBe(lang('igniter::admin.label_email'))
        ->and($attributes['telephone'])->toBe(lang('igniter.user::default.customers.label_telephone'))
        ->and($attributes['newsletter'])->toBe(lang('igniter.user::default.customers.label_newsletter'))
        ->and($attributes['customer_group_id'])->toBe(lang('igniter.user::default.customers.label_customer_group'))
        ->and($attributes['status'])->toBe(lang('igniter::admin.label_status'))
        ->and($attributes['addresses.*.address_1'])->toBe(lang('igniter.user::default.customers.label_address_1'))
        ->and($attributes['addresses.*.city'])->toBe(lang('igniter.user::default.customers.label_city'))
        ->and($attributes['addresses.*.state'])->toBe(lang('igniter.user::default.customers.label_state'))
        ->and($attributes['addresses.*.postcode'])->toBe(lang('igniter.user::default.customers.label_postcode'))
        ->and($attributes['addresses.*.country_id'])->toBe(lang('igniter.user::default.customers.label_country'))
        ->and($attributes['password'])->toBe(lang('igniter.user::default.customers.label_password'))
        ->and($attributes['confirm_password'])->toBe(lang('igniter.user::default.customers.label_confirm_password'));
});

it('validates rules correctly for customer', function(): void {
    $customerRequest = new CustomerRequest;
    $customerRequest->setMethod('post');
    $customerRequest->merge([
        'send_invite' => false,
        'password' => 'password',
        'password_confirm' => 'password',
    ]);
    $rules = $customerRequest->rules();

    expect($rules['first_name'])->toBe(['required', 'string', 'between:1,48'])
        ->and($rules['last_name'])->toBe(['required', 'string', 'between:1,48'])
        ->and($rules['email'])->toContain('required', 'email:filter', 'max:96')
        ->and($rules['email'][3]->__toString())->toBe('unique:customers,NULL,NULL,customer_id')
        ->and($rules['send_invite'])->toBe(['present', 'boolean'])
        ->and($rules['password'])->toBe(['nullable', 'required_if_declined:send_invite', 'string', 'min:8', 'max:40', 'same:password_confirm'])
        ->and($rules['telephone'])->toBe(['nullable', 'string'])
        ->and($rules['newsletter'])->toBe(['nullable', 'required', 'boolean'])
        ->and($rules['customer_group_id'])->toBe(['required', 'integer'])
        ->and($rules['status'])->toBe(['required', 'boolean'])
        ->and($rules['addresses.*.address_id'])->toBe(['nullable', 'integer'])
        ->and($rules['addresses.*.address_1'])->toBe(['required', 'string', 'min:3', 'max:255'])
        ->and($rules['addresses.*.address_2'])->toBe(['nullable', 'string'])
        ->and($rules['addresses.*.city'])->toBe(['nullable', 'string', 'min:2', 'max:255'])
        ->and($rules['addresses.*.state'])->toBe(['nullable', 'string', 'max:255'])
        ->and($rules['addresses.*.postcode'])->toBe(['nullable', 'string']);
});

it('returns customer route parameter from getRecordId', function(): void {
    $customerRequest = new class extends CustomerRequest
    {
        public function exposeGetRecordId(): int|string|null
        {
            return $this->getRecordId();
        }
    };

    $route = new Route(['PUT'], '/api/customers/{customer}', []);
    $route->bind($customerRequest);
    $route->setParameter('customer', 42);

    $customerRequest->setRouteResolver(fn(): Route => $route);

    $recordId = $customerRequest->exposeGetRecordId();

    expect($recordId)->toBe(42);
});

it('falls back to parent getRecordId when customer route parameter is absent', function(): void {
    $customerRequest = new class extends CustomerRequest
    {
        public function exposeGetRecordId(): int|string|null
        {
            return $this->getRecordId();
        }
    };

    $route = new Route(['PUT'], '/admin/customers/{slug}', []);
    $route->bind($customerRequest);
    $route->setParameter('slug', 'customers/5');

    $customerRequest->setRouteResolver(fn(): Route => $route);

    $recordId = $customerRequest->exposeGetRecordId();

    expect($recordId)->toBe('5');
});

it('unique email rule ignores the customer being updated', function(): void {
    $customerRequest = new CustomerRequest;
    $customerRequest->setMethod('patch');

    $route = new Route(['PATCH'], '/api/customers/{customer}', []);
    $route->bind($customerRequest);
    $route->setParameter('customer', 7);

    $customerRequest->setRouteResolver(fn(): Route => $route);

    $rules = $customerRequest->rules();

    expect($rules['email'][3]->__toString())->toBe('unique:customers,NULL,"7",customer_id');
});

it('has correct validation rules when request is patch', function(): void {
    $customerRequest = new CustomerRequest;
    $customerRequest->setMethod('patch');

    expect($customerRequest->rules())
        ->not->toHaveKey('send_invite')
        ->toHaveKey('password', ['exclude_without:password_confirm', 'nullable', 'string', 'min:8', 'max:40', 'same:password_confirm']);
});
