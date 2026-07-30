<?php

declare(strict_types=1);

namespace Igniter\User\Tests\Console\Commands;

use Igniter\System\Models\Settings;
use Igniter\User\Console\Commands\AllocatorCommand;

it('does not dispatch jobs when no available slots', function(): void {
    Settings::set('allocator_slots', ['slot1' => true, 'slot2' => true], 'prefs');
    Settings::set('allocator_slot_size', 2, 'prefs');

    (new AllocatorCommand)->handle();
    expect(true)->toBeTrue();
});

it('dispatches jobs when there are available slots', function(): void {
    Settings::set('allocator_slots', ['slot1' => true, 'slot2' => true], 'prefs');
    Settings::set('allocator_slot_size', 10, 'prefs');

    (new AllocatorCommand)->handle();

    expect(true)->toBeTrue();
});

it('adds a single slot', function(): void {
    Settings::set('allocator_slots', [], 'prefs');

    AllocatorCommand::addSlot('slot1');

    $slots = Settings::get('allocator_slots', null, 'prefs');
    expect($slots)->toHaveKey('slot1');
});

it('adds multiple slots', function(): void {
    Settings::set('allocator_slots', [], 'prefs');

    AllocatorCommand::addSlot(['slot1', 'slot2']);

    $slots = Settings::get('allocator_slots', null, 'prefs');
    expect($slots)->toHaveKeys(['slot1', 'slot2']);
});

it('removes a slot', function(): void {
    Settings::set('allocator_slots', ['slot1' => true, 'slot2' => true], 'prefs');

    AllocatorCommand::removeSlot('slot1');

    $slots = Settings::get('allocator_slots', null, 'prefs');
    expect($slots)->not->toHaveKey('slot1')
        ->and($slots)->toHaveKey('slot2');
});
