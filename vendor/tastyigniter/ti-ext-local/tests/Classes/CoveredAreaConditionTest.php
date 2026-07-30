<?php

declare(strict_types=1);

namespace Igniter\Local\Tests\Classes;

use Igniter\Local\Classes\CoveredAreaCondition;

it('constructs correctly', function(): void {
    $condition = new CoveredAreaCondition([
        'type' => 'above',
        'amount' => 10,
        'total' => 100,
        'priority' => 1,
    ]);

    expect($condition->type)->toBe('above')
        ->and($condition->amount)->toBe(10.0)
        ->and($condition->total)->toBe(100.0)
        ->and($condition->priority)->toBe(1);
});

it('gets label correctly', function(): void {
    $condition = new CoveredAreaCondition([
        'type' => 'above',
        'amount' => 10,
        'total' => 100,
        'priority' => 1,
    ]);

    expect($condition->getLabel())->toBe('£10.00 above £100.00');
});

it('gets charge correctly', function(): void {
    $condition = new CoveredAreaCondition([
        'type' => 'above',
        'amount' => 10,
        'total' => 100,
        'priority' => 1,
    ]);

    expect($condition->getCharge())->toBe(10.0);
});

it('gets minimum total correctly', function(): void {
    $condition = new CoveredAreaCondition([
        'type' => 'above',
        'amount' => 10,
        'total' => 100,
        'priority' => 1,
    ]);

    expect($condition->getMinTotal())->toBe(100.0);
});

it('validates correctly', function(): void {
    $condition = new CoveredAreaCondition([
        'type' => 'above',
        'amount' => 10,
        'total' => 100,
        'priority' => 1,
    ]);

    expect($condition->isValid(150))->toBeTrue()
        ->and($condition->isValid(50))->toBeFalse();
});

it('validates when no matching type', function(): void {
    $condition = new CoveredAreaCondition([
        'type' => 'invalid',
        'amount' => 10,
        'total' => 100,
        'priority' => 1,
    ]);

    expect($condition->isValid(150))->toBeTrue();
});
