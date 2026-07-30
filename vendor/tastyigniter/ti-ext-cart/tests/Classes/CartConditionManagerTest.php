<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\Classes;

use Igniter\Cart\Classes\CartConditionManager;
use Igniter\Cart\Tests\Classes\Fixtures\TestCartCondition;
use LogicException;

it('makes condition', function(): void {
    $manager = new CartConditionManager;
    $manager->registerCondition(TestCartCondition::class, [
        'name' => 'testCartCondition',
        'label' => 'Test Cart Condition',
    ]);

    $condition = $manager->makeCondition(TestCartCondition::class, ['label' => 'Override Test Cart Condition']);

    expect($condition)->toBeInstanceOf(TestCartCondition::class)
        ->and($condition->getLabel())->toBe('Override Test Cart Condition');
});

it('throws exception for unregistered condition', function(): void {
    $manager = new CartConditionManager;

    expect(fn() => $manager->makeCondition('NonExistentClass'))->toThrow(LogicException::class);
});

it('throws exception when class does not exist', function(): void {
    $manager = new CartConditionManager;
    $manager->registerCondition('NonExistentClass', ['name' => 'testCondition']);

    expect(fn() => $manager->makeCondition('NonExistentClass'))
        ->toThrow(LogicException::class, "The Cart Condition class 'NonExistentClass' does not exist");
});

it('lists registered conditions', function(): void {
    $manager = new CartConditionManager;
    $manager->registerCondition(TestCartCondition::class, [
        'name' => 'testCartCondition',
        'label' => 'Test Cart Condition',
    ]);

    $conditions = $manager->listRegisteredConditions();

    expect($conditions)->toBeArray()
        ->and($conditions)->toHaveKey(TestCartCondition::class);
});

it('loads registered conditions', function(): void {
    $manager = new CartConditionManager;
    $manager->registerCallback(function($manager): void {
        $manager->registerCondition(TestCartCondition::class, [
            'name' => 'testCartCondition',
            'label' => 'Test Cart Condition',
        ]);
    });

    $conditions = $manager->listRegisteredConditions();

    expect($conditions)->toBeArray()
        ->and($conditions)->toHaveKey(TestCartCondition::class)
        ->and($conditions[TestCartCondition::class]['label'])->toBe('Test Cart Condition');
});

it('registers conditions', function(): void {
    $manager = new CartConditionManager;
    $manager->registerConditions([
        TestCartCondition::class => [
            'name' => 'testCartCondition',
            'label' => 'Test Cart Condition',
        ],
    ]);

    $conditions = $manager->listRegisteredConditions();

    expect($conditions)->toBeArray()
        ->and($conditions)->toHaveKey(TestCartCondition::class);
});
