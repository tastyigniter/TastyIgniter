<?php

namespace Admin\Traits;

use Admin\Models\Status_history_model;

trait LogsStatusHistory
{
    public $formWidgetStatusData = [];

    public static function bootLogsStatusHistory()
    {
        self::extend(function (self $model) {
            $model->relation['belongsTo']['status'] = ['Admin\Models\Statuses_model'];
            $model->relation['morphMany']['status_history'] = [
                'Admin\Models\Status_history_model', 'name' => 'object',
            ];

            $model->casts = array_merge($model->casts, [
                'status_id' => 'integer',
                'status_updated_at' => 'dateTime',
            ]);
        });
    }

    public function getStatusNameAttribute()
    {
        return $this->status ? $this->status->status_name : null;
    }

    public function getStatusColorAttribute()
    {
        return $this->status ? $this->status->status_color : null;
    }

    public function getLatestStatusHistory()
    {
        return $this->status_history->first();
    }

    public function addStatusHistory($status, array $statusData = [])
    {
        if (!$this->exists OR !$status)
            return FALSE;

        $this->status()->associate($status);

        if (!$history = Status_history_model::createHistory($status, $this, $statusData))
            return FALSE;

        $this->save();

        return $history;
    }

    public function hasStatus($statusId = null)
    {
        if (is_null($statusId))
            return $this->status_history->isNotEmpty();

        return $this->status_history()->where('status_id', $statusId)->exists();
    }

    public function scopeWhereStatus($query, $statusId)
    {
        return $query->where('status_id', $statusId);
    }

    public function scopeWhereHasStatusInHistory($query, $statusId)
    {
        return $query->whereHas('status_history', function ($q) use ($statusId) {
            return $q->where('status_id', $statusId);
        });
    }
}