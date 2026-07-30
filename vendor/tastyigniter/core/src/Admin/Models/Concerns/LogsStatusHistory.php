<?php

declare(strict_types=1);

namespace Igniter\Admin\Models\Concerns;

use Igniter\Admin\Models\Status;
use Igniter\Admin\Models\StatusHistory;
use Illuminate\Database\Eloquent\Builder;

trait LogsStatusHistory
{
    public static function bootLogsStatusHistory(): void
    {
        self::extend(function(self $model) {
            $model->relation['belongsTo']['status'] = [Status::class];
            $model->relation['morphMany']['status_history'] = [
                StatusHistory::class, 'name' => 'object', 'delete' => true,
            ];

            $model->appends[] = 'status_name';

            $model->addCasts([
                'status_id' => 'integer',
                'status_updated_at' => 'datetime',
            ]);
        });
    }

    public function getStatusNameAttribute(): ?string
    {
        return $this->status ? $this->status->status_name : null;
    }

    public function getStatusColorAttribute(): ?string
    {
        return $this->status ? $this->status->status_color : null;
    }

    public function getLatestStatusHistory(): ?StatusHistory
    {
        return $this->status_history->first();
    }

    public function addStatusHistory(null|int|string|Status $status, array $statusData = []): StatusHistory|false
    {
        if (!$this->exists || !$status) {
            return false;
        }

        $this->status()->associate($status);

        if (!$history = StatusHistory::createHistory($status, $this, $statusData)) {
            return false;
        }

        $this->saveQuietly();

        $this->fireSystemEvent('admin.statusHistory.added', [$history]);

        return $history;
    }

    public function hasStatus(mixed $statusId = null): bool
    {
        if (is_null($statusId)) {
            return $this->status_history->isNotEmpty();
        }

        return $this->status_history()->whereIn('status_id', (array)$statusId)->exists();
    }

    public function scopeWhereStatus($query, null|int|string|array $statusId = null): Builder
    {
        if (is_null($statusId)) {
            return $query->where('status_id', '>=', 1);
        }

        return $query->whereIn('status_id', (array)$statusId);
    }

    public function scopeWhereHasStatusInHistory($query, string|int $statusId): Builder
    {
        return $query->whereHas('status_history', fn($q) => $q->where('status_id', $statusId));
    }

    public function scopeDoesntHaveStatusInHistory($query, string|int $statusId): Builder
    {
        return $query->whereDoesntHave('status_history', fn($q) => $q->where('status_id', $statusId));
    }
}
