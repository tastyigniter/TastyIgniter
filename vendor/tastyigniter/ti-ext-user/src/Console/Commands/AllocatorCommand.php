<?php

declare(strict_types=1);

namespace Igniter\User\Console\Commands;

use Igniter\User\Jobs\AllocateAssignable;
use Igniter\User\Models\AssignableLog;
use Illuminate\Console\Command;

class AllocatorCommand extends Command
{
    protected $signature = 'igniter:assignable-allocate';

    protected $description = 'Allocate assignables to assignees';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        if (($availableSlotCount = self::countAvailableSlot()) === 0) {
            return;
        }

        AssignableLog::getUnAssignedQueue($availableSlotCount)
            ->lazy()
            ->each(fn($assignableLog) => AllocateAssignable::dispatch($assignableLog));
    }

    public static function addSlot($slot): void
    {
        $slots = (array)params('allocator_slots', []);
        if (!is_array($slot)) {
            $slot = [$slot];
        }

        foreach ($slot as $item) {
            $slots[$item] = true;
        }

        setting()->setPref('allocator_slots', $slots);
    }

    public static function removeSlot(mixed $slot): void
    {
        $slots = (array)params('allocator_slots', []);

        unset($slots[$slot]);

        setting()->setPref('allocator_slots', $slots);
    }

    protected static function countAvailableSlot(): int
    {
        $slotMaxCount = (int)params('allocator_slot_size', 10);
        $slotSize = count((array)params('allocator_slots', []));

        return ($slotSize < $slotMaxCount)
            ? $slotMaxCount - $slotSize : 0;
    }
}
