<?php

namespace Admin\Traits;

use Admin\Models\Status_history_model;
use Exception;
use Igniter\Flame\Database\Model;

trait LogsStatusHistory
{
    protected static $recordEvents = ['updated', 'deleted'];

    protected static $logAttributes = ['status_id', 'assignee_id'];

    public static function bootLogsStatusHistory()
    {
        self::extend(function (Model $model) {
            $model->append(['status_name', 'status_color']);
        });

        static::saving(function (Model $model) {
            $model->addStatusHistoryFromAttributes();
        });
    }

    public function getStatusNameAttribute()
    {
        return $this->getRelatedStatusModel()->status_name;
    }

    public function getStatusColorAttribute()
    {
        return $this->getRelatedStatusModel()->status_color;
    }

    public function getRelatedStatusModel()
    {
        if (!$this->hasRelation('status')) {
            throw new Exception(sprintf(
                "Model '%s' does not contain a relation definition for 'status'.", $this
            ));
        }

        if (!$this->status)
            return $this->makeRelation('status');

        return $this->status;
    }

    public function addStatusHistory($status, array $statusData = [])
    {
        if (!$this->exists OR !$status)
            return;

        return Status_history_model::addStatusHistory($status, $this, $statusData);
    }

    /**
     * Add order status to status history
     *
     * @param array $statusData
     *
     * @return mixed
     */
    protected function addStatusHistoryFromAttributes()
    {
        $status = $this->status;
        $statusData = $this->statusData;
        unset($this->statusData);

        if (!$statusData OR !is_array($statusData))
            return;

        if ($this->statusHistoryAlreadyExists($statusData))
            return;

        return $this->addStatusHistory($status, $statusData);
    }

    protected function statusHistoryAlreadyExists($statusData)
    {
        $newStatusId = $statusData['status_id'];
        $previousStatusId = $this->getOriginal('status_id');

        if ($previousStatusId != $newStatusId)
            return FALSE;

        $alreadyExists = Status_history_model::alreadyExists($this, $newStatusId);
        if (!$alreadyExists)
            return FALSE;

        if ($alreadyExists->comment != $statusData['comment'])
            return FALSE;

        if ($alreadyExists->notify != $statusData['notify'])
            return FALSE;

        return TRUE;
    }
}