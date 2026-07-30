<?php

declare(strict_types=1);

namespace Igniter\User\Jobs;

use Exception;
use Igniter\Cart\Models\Order;
use Igniter\Flame\Exception\SystemException;
use Igniter\Reservation\Models\Reservation;
use Igniter\User\Console\Commands\AllocatorCommand;
use Igniter\User\Models\AssignableLog;
use Igniter\User\Models\Concerns\Assignable;
use Igniter\User\Models\UserGroup;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AllocateAssignable implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * @var AssignableLog
     */
    public $assignableLog;

    /**
     * @var int
     */
    public $tries = 3;

    public function __construct(AssignableLog $assignableLog)
    {
        $this->assignableLog = $assignableLog->withoutRelations();
    }

    public function handle(): void
    {
        $lastAttempt = $this->attempts() >= $this->tries;

        try {
            if ($this->assignableLog->assignee_id) {
                return;
            }

            if ((!$this->assignableLog->assignable instanceof Order && !$this->assignableLog->assignable instanceof Reservation)
                || !in_array(Assignable::class, class_uses_recursive($this->assignableLog->assignable::class))
            ) {
                return;
            }

            if (!$this->assignableLog->assignee_group instanceof UserGroup) {
                return;
            }

            AllocatorCommand::addSlot($this->assignableLog->getKey());

            if (!$assignee = $this->assignableLog->assignee_group->findAvailableAssignee()) {
                throw new SystemException(lang('igniter.user::default.user_groups.alert_no_available_assignee'));
            }

            $this->assignableLog->assignable->assignTo($assignee);

            AllocatorCommand::removeSlot($this->assignableLog->getKey());

            return;
        } catch (Exception) {
            if (!$lastAttempt) {
                $waitInSeconds = $this->waitInSecondsAfterAttempt($this->attempts());

                $this->release($waitInSeconds);
            }
        }

        if ($lastAttempt) {
            $this->delete();
        }
    }

    protected function waitInSecondsAfterAttempt(int $attempt): int
    {
        return $attempt >= 3 ? 1000 : 10 ** $attempt;
    }
}
