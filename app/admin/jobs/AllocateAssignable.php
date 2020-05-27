<?php

namespace Admin\Jobs;

use Admin\Classes\Allocator;
use Admin\Models\Assignable_logs_model;
use Admin\Models\Staff_groups_model;
use Admin\Traits\Assignable;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AllocateAssignable implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var \Admin\Models\Assignable_logs_model
     */
    public $assignableLog;

    /**
     * @var int
     */
    public $tries = 3;

    public function __construct(Assignable_logs_model $assignableLog)
    {
        $this->assignableLog = $assignableLog->withoutRelations();
    }

    public function handle()
    {
        $lastAttempt = $this->attempts() >= $this->tries;

        try {
            if ($this->assignableLog->assignee_id)
                return TRUE;

            if (!in_array(Assignable::class, class_uses_recursive(get_class($this->assignableLog->assignable))))
                return TRUE;

            if (!$this->assignableLog->assignee_group instanceof Staff_groups_model)
                return TRUE;

            Allocator::addSlot($this->assignableLog->getKey());

            if (!$assignee = $this->assignableLog->assignee_group->findAvailableAssignee())
                throw new Exception('No available assignee');

            $this->assignableLog->assignable->assignTo($assignee);

            Allocator::removeSlot($this->assignableLog->getKey());

            return;
        }
        catch (Exception $exception) {
            if (!$lastAttempt) {
                $waitInSeconds = $this->waitInSecondsAfterAttempt($this->attempts());

                $this->release($waitInSeconds);
            }
        }

        if ($lastAttempt) {
            $this->delete();
        }
    }

    protected function waitInSecondsAfterAttempt(int $attempt)
    {
        if ($attempt > 3) {
            return 1000;
        }

        return 10 ** $attempt;
    }
}
