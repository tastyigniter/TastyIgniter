<?php

namespace Admin\Classes;

use Admin\Jobs\AllocateAssignable;
use Admin\Models\Assignable_logs_model;

class Allocator
{
    public static function allocate()
    {
        if (!$availableSlotCount = self::countAvailableSlot())
            return;

        $queue = Assignable_logs_model::getUnAssignedQueue($availableSlotCount);

        $queue->each(function ($assignableLog) {
            AllocateAssignable::dispatch($assignableLog);
        });
    }

    public static function addSlot($slot)
    {
        $slots = (array)params('allocator_slots', []);
        if (!is_array($slot))
            $slot = [$slot];

        foreach ($slot as $item) {
            $slots[$item] = TRUE;
        }

        params()->set('allocator_slots', $slots);
        params()->save();
    }

    public static function removeSlot($slot)
    {
        $slots = (array)params('allocator_slots', []);

        unset($slots[$slot]);

        params()->set('allocator_slots', $slots);
        params()->save();
    }

    protected static function countAvailableSlot()
    {
        $slotMaxCount = (int)params('allocator_slot_size', 10);
        $slotSize = count((array)params('allocator_slots', []));

        return ($slotSize < $slotMaxCount)
            ? $slotMaxCount - $slotSize : 0;
    }
}