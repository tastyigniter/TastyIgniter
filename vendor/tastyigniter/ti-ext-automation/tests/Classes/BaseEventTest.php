<?php

declare(strict_types=1);

namespace Igniter\Automation\Tests\Classes;

use Igniter\Automation\Classes\BaseEvent;
use Igniter\System\Classes\ExtensionManager;
use Mockery;

it('name and description', function(): void {
    $event = new class extends BaseEvent {};

    expect($event->eventDetails())->toHaveKeys(['name', 'description', 'group']);
});

it('returns empty array when no arguments are provided to makeParamsFromEvent', function(): void {
    $result = BaseEvent::makeParamsFromEvent([]);

    expect($result)->toBe([]);
});

it('sets and retrieves event parameters correctly', function(): void {
    $event = new BaseEvent;
    $params = ['param1' => 'value1', 'param2' => 'value2'];

    $event->setEventParams($params);
    $result = $event->getEventParams();

    expect($result)->toBe($params);
});

it('returns empty array when no event parameters are set', function(): void {
    $result = (new BaseEvent)->getEventParams();

    expect($result)->toBe([]);
});

it('returns the correct event group from eventDetails', function(): void {
    $result = (new BaseEvent)->getEventGroup();

    expect($result)->toBe('groupcode');
});

it('returns the correct event identifier for a namespaced class', function(): void {
    $result = (new BaseEvent)->getEventIdentifier();

    expect($result)->toBe('igniter-automation-baseevent');
});

it('returns nothing when no registered rules found', function(): void {
    $extensionManager = Mockery::mock(ExtensionManager::class);
    $extensionManager->shouldReceive('getRegistrationMethodValues')->with('registerAutomationRules')->andReturn([])->once();
    app()->instance(ExtensionManager::class, $extensionManager);

    BaseEvent::findRulesValues();
});

it('skips invalid event classes and continues processing', function(): void {
    $extensionManager = Mockery::mock(ExtensionManager::class);
    $extensionManager->shouldReceive('getRegistrationMethodValues')->with('registerAutomationRules')->andReturn([
        [
            'events' => [
                'NonExistent\Class\Name',
            ],
        ],
    ])->once();
    app()->instance(ExtensionManager::class, $extensionManager);

    BaseEvent::findRulesValues('events');
});

it('skips invalid event classes', function(): void {
    $extensionManager = Mockery::mock(ExtensionManager::class);
    $extensionManager->shouldReceive('getRegistrationMethodValues')->with('registerAutomationRules')->andReturn([
        [
            'events' => [
                'test_event' => 'NonExistent\Class\Name',
            ],
        ],
    ])->once();
    app()->instance(ExtensionManager::class, $extensionManager);

    BaseEvent::findEvents();
});
