<?php

namespace Admin\Traits;

use Admin\Models\Reservations_model;
use Admin\Models\Status_history_model;
use Admin\Models\Statuses_model;

trait LogsStatusHistory
{
    public $formWidgetStatusData = [];

    public static function bootLogsStatusHistory()
    {
        self::extend(function (self $model) {
            $model->relation['belongsTo']['status'] = ['Admin\Models\Statuses_model'];
            $model->relation['morphMany']['status_history'] = [
                'Admin\Models\Status_history_model', 'name' => 'object', 'delete' => true,
            ];

            $model->appends[] = 'status_name';

            $model->addCasts([
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
        if (!$this->exists || !$status)
            return false;

        if (!is_object($status))
            $status = Statuses_model::find($status);

        $this->status()->associate($status);

        if (!$history = Status_history_model::createHistory($status, $this, $statusData))
            return false;

        $this->save();

        $this->reloadRelations();

        if ($history->notify) {
            $mailView = ($this instanceof Reservations_model)
                ? 'admin::_mail.reservation_update' : 'admin::_mail.order_update';

            $this->mailSend($mailView, 'customer');
        }

        $this->fireSystemEvent('admin.statusHistory.added', [$history]);

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

    public function scopeDoesntHaveStatusInHistory($query, $statusId)
    {
        return $query->whereDoesntHave('status_history', function ($q) use ($statusId) {
            return $q->where('status_id', $statusId);
        });
    }
}
