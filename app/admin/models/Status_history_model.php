<?php namespace Admin\Models;

use Event;
use Model;

/**
 * Status History Model Class
 *
 * @package Admin
 */
class Status_history_model extends Model
{
    const UPDATED_AT = null;

    const CREATED_AT = 'date_added';

    /**
     * @var string The database table name
     */
    protected $table = 'status_history';

    protected $primaryKey = 'status_history_id';

    protected $guarded = [];

    protected $appends = ['staff_name', 'assignee_name', 'status_name', 'notified'];

    public $timestamps = TRUE;

    public $casts = [
        'object_id' => 'integer',
        'staff_id' => 'integer',
        'assignee_id' => 'integer',
        'status_id' => 'integer',
        'notify' => 'boolean',
    ];

    public $relation = [
        'belongsTo' => [
            'staff' => 'Admin\Models\Staffs_model',
            'assignee' => 'Admin\Models\Staffs_model',
            'status' => ['Admin\Models\Statuses_model', 'status_id'],
        ],
        'morphTo' => [
            'object' => [],
        ],
    ];

    public static function alreadyExists($model, $statusId)
    {
        return self::where('object_id', $model->getKey())
                   ->where('object_type', $model->getMorphClass())
                   ->where('status_id', $statusId)->exists();
    }

    public function getStaffNameAttribute($value)
    {
        return ($this->staff AND $this->staff->exists) ? $this->staff->staff_name : $value;
    }

    public function getAssigneeNameAttribute($value)
    {
        return ($this->assignee AND $this->assignee->exists) ? $this->assignee->staff_name : $value;
    }

    public function getStatusNameAttribute($value)
    {
        return ($this->status AND $this->status->exists) ? $this->status->status_name : $value;
    }

    public function getNotifiedAttribute()
    {
        return $this->notify == 1 ? lang('admin::lang.text_yes') : lang('admin::lang.text_no');
    }

    public static function addStatusHistory(Model $status, Model $object, $options = [])
    {
        $statusId = $status->getKey();
        $previousStatus = $object->getOriginal('status_id');

        $model = new static;
        $model->status_id = $statusId;
        $model->object_id = $object->getKey();
        $model->object_type = $object->getMorphClass();
        $model->status_for = $object instanceof Orders_model ? 'order' : 'reserve';
        $model->staff_id = array_get($options, 'staff_id');
        $model->assignee_id = array_get($options, 'assignee_id', $object->assignee_id);
        $model->comment = array_get($options, 'comment', $status->comment);

        if (Event::fire('admin.statusHistory.beforeAddStatus', [$model, $object, $statusId, $previousStatus], TRUE) === FALSE)
            return FALSE;

        if ($model->fireEvent('statusHistory.beforeAddStatus', [$model, $object, $statusId, $previousStatus], TRUE) === FALSE)
            return FALSE;

        $model->save();

        $object::withoutEvents(function () use ($object, $statusId) {
            $object->status_id = $statusId;
            $object->save();
        });

        if (array_get($options, 'notify', $status->notify_customer)) {
            $statusFor = $model->status_for == 'reserve' ? 'reservation' : $model->status_for;
            $object->mailSend('admin::_mail.'.$statusFor.'_update', 'customer');

            $model->notify = TRUE;
            $model->timestamps = FALSE;
            $model->save();
        }

        return $model;
    }
}