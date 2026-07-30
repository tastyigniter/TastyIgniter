<?php

declare(strict_types=1);

namespace Igniter\User\Tests\AutomationRules\Conditions;

use Igniter\Automation\AutomationException;
use Igniter\User\AutomationRules\Conditions\CustomerAttribute;
use Igniter\User\Models\Customer;
use Mockery;

it('returns correct condition details', function(): void {
    $condition = new CustomerAttribute;

    $result = $condition->conditionDetails();

    expect($result)->toBe([
        'name' => 'Customer attribute',
        'description' => 'Customer attributes',
    ]);
});

it('defines correct model attributes', function(): void {
    $condition = new CustomerAttribute;

    $result = $condition->defineModelAttributes();

    expect($result)->toBe([
        'first_name' => [
            'label' => 'First Name',
        ],
        'last_name' => [
            'label' => 'Last Name',
        ],
        'telephone' => [
            'label' => 'Telephone',
        ],
        'email' => [
            'label' => 'Email address',
        ],
    ]);
});

it('returns true when customer attribute condition is met', function(): void {
    $customer = Mockery::mock(Customer::class);
    $condition = Mockery::mock(CustomerAttribute::class)->makePartial();
    $condition->shouldReceive('evalIsTrue')->with($customer)->andReturn(true);

    $params = ['customer' => $customer];
    $result = $condition->isTrue($params);

    expect($result)->toBeTrue();
});

it('throws exception when customer object is not found in parameters', function(): void {
    $condition = Mockery::mock(CustomerAttribute::class)->makePartial();

    $params = [];
    $exception = null;

    try {
        $condition->isTrue($params);
    } catch (AutomationException $e) {
        $exception = $e;
    }

    expect($exception)->not->toBeNull()
        ->and($exception->getMessage())
        ->toBe('Error evaluating the customer attribute condition: the customer object is not found in the condition parameters.');
});
