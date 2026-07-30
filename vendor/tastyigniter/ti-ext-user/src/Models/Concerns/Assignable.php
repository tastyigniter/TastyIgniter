<?php

declare(strict_types=1);

namespace Igniter\User\Models\Concerns;

use Igniter\Flame\Exception\FlashException;
use Igniter\User\Facades\AdminAuth;
use Igniter\User\Models\AssignableLog;
use Igniter\User\Models\User;
use Igniter\User\Models\UserGroup;
use Illuminate\Database\Eloquent\Builder;

trait Assignable
{
    public static function bootAssignable(): void
    {
        static::extend(function(self $model): void {
            $model->relation['belongsTo']['assignee'] = [User::class];
            $model->relation['belongsTo']['assignee_group'] = [UserGroup::class];
            $model->relation['morphMany']['assignable_logs'] = [
                AssignableLog::class, 'name' => 'assignable', 'delete' => true,
            ];

            $model->addCasts([
                'assignee_id' => 'integer',
                'assignee_group_id' => 'integer',
                'assignee_updated_at' => 'datetime',
            ]);
        });
    }

    //
    //
    //
    /**
     * @param User $assignee
     * @return bool
     */
    public function assignTo($assignee, ?User $user = null)
    {
        throw_if(is_null($this->assignee_group), new FlashException('Assignee group is not set'));

        return $this->updateAssignTo($this->assignee_group, $assignee, $user);
    }

    /**
     * @param UserGroup $group
     * @return bool
     */
    public function assignToGroup($group, ?User $user = null)
    {
        return $this->updateAssignTo($group, null, $user);
    }

    public function updateAssignTo(?UserGroup $group = null, ?User $assignee = null, ?User $user = null)
    {
        if (is_null($group)) {
            $group = $this->assignee_group;
        }

        if (is_null($group) && !is_null($assignee)) {
            $group = $assignee->groups()->first();
        }

        $oldGroup = $this->assignee_group;
        is_null($group)
            ? $this->assignee_group()->dissociate()
            : $this->assignee_group()->associate($group);

        $oldAssignee = $this->assignee;
        is_null($assignee)
            ? $this->assignee()->dissociate()
            : $this->assignee()->associate($assignee);

        $this->fireSystemEvent('admin.assignable.beforeAssignTo', [$group, $assignee, $oldAssignee, $oldGroup]);

        $this->saveQuietly();

        $log = AssignableLog::createLog($this, $user);

        $this->fireSystemEvent('admin.assignable.assigned', [$log]);

        return $log;
    }

    public function cannotAssignToStaff($user)
    {
        return $this->assignable_logs()
            ->where('user_id', $user->getKey())
            ->where('assignee_group_id', $this->assignee_group_id)
            ->exists();

    }

    public function hasAssignTo(): bool
    {
        return !is_null($this->assignee);
    }

    public function hasAssignToGroup(): bool
    {
        return !is_null($this->assignee_group);
    }

    public function listGroupAssignees()
    {
        if (!$this->assignee_group instanceof UserGroup) {
            return [];
        }

        return $this->assignee_group->listAssignees();
    }

    //
    // Scopes
    //

    /**
     * @param \Igniter\Flame\Database\Query\Builder $query
     * @return mixed
     */
    public function scopeFilterAssignedTo($query, $assignedTo = null)
    {
        if ($assignedTo == 1) {
            return $query->whereNull('assignee_id');
        }

        $staffId = optional(AdminAuth::staff())->getKey();
        if ($assignedTo == 2) {
            return $query->where('assignee_id', $staffId);
        }

        return $query->where('assignee_id', '!=', $staffId);
    }

    /**
     * @param \Igniter\Flame\Database\Query\Builder $query
     * @return mixed
     */
    public function scopeWhereUnAssigned($query)
    {
        return $query->whereNotNull('assignee_group_id')->whereNull('assignee_id');
    }

    /**
     * @param \Igniter\Flame\Database\Query\Builder $query
     * @return mixed
     */
    public function scopeWhereAssignTo($query, $assigneeId)
    {
        return $query->where('assignee_id', $assigneeId);
    }

    /**
     * @param \Igniter\Flame\Database\Query\Builder $query
     * @return mixed
     */
    public function scopeWhereAssignToGroup($query, $assigneeGroupId)
    {
        return $query->where('assignee_group_id', $assigneeGroupId);
    }

    /**
     * @param \Igniter\Flame\Database\Query\Builder $query
     * @return mixed
     */
    public function scopeWhereInAssignToGroup($query, array $assigneeGroupIds)
    {
        return $query->whereIn('assignee_group_id', $assigneeGroupIds);
    }

    /**
     * @param \Igniter\Flame\Database\Query\Builder $query
     * @return mixed
     */
    public function scopeWhereHasAutoAssignGroup($query)
    {
        return $query->whereHas('assignee_group', function(Builder $query): void {
            $query->where('auto_assign', 1);
        });
    }
}
