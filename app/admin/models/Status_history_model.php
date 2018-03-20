<?php namespace Admin\Models;

use Model;

/**
 * Status History Model Class
 *
 * @package Admin
 */
class Status_history_model extends Model
{
    const CREATED_AT = 'date_added';

    /**
     * @var string The database table name
     */
    protected $table = 'status_history';

    protected $primaryKey = 'status_history_id';

    public $relation = [
        'belongsTo' => [
            'staff'    => 'Admin\Models\Staffs_model',
            'assignee' => 'Admin\Models\Staffs_model',
            'status'   => ['Admin\Models\Statuses_model', 'status_id'],
        ],
        'morphTo'   => [
            'object' => [],
        ],
    ];

    protected $fillable = ['status_id', 'notify', 'status_for', 'comment'];

    protected $appends = ['staff_name', 'assignee_name', 'status_name', 'notified'];

    public $timestamps = TRUE;

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
        return $this->notify == 1 ? lang('admin::default.text_yes') : lang('admin::default.text_no');
    }
}