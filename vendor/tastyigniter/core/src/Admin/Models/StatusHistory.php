<?php

declare(strict_types=1);

namespace Igniter\Admin\Models;

use Carbon\Carbon;
use Igniter\Cart\Models\Order;
use Igniter\Flame\Database\Builder;
use Igniter\Flame\Database\Factories\HasFactory;
use Igniter\Flame\Database\Model;
use Igniter\User\Models\User;

/**
 * Status History Model Class
 *
 * @property int $status_history_id
 * @property int $object_id
 * @property string $object_type
 * @property int|null $user_id
 * @property int $status_id
 * @property bool|null $notify
 * @property string|null $comment
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read string|null $date_added_since
 * @property-read string $notified
 * @property-read mixed $staff_name
 * @property-read mixed $status_name
 * @property-read Status|null $status
 * @property-read User|null $user
 * @method static Builder<static>|StatusHistory applyFilters(array $options = [])
 * @method static Builder<static>|StatusHistory applyRelated($model)
 * @method static Builder<static>|StatusHistory applySorts(array $sorts = [])
 * @method static Builder<static>|StatusHistory listFrontEnd(array $options = [])
 * @method static Builder<static>|StatusHistory newModelQuery()
 * @method static Builder<static>|StatusHistory newQuery()
 * @method static Builder<static>|StatusHistory query()
 * @method static Builder<static>|StatusHistory whereStatusIsLatest($statusId)
 * @mixin \Illuminate\Database\Eloquent\Model
 */
class StatusHistory extends Model
{
    use HasFactory;

    /**
     * @var string The database table name
     */
    protected $table = 'status_history';

    protected $primaryKey = 'status_history_id';

    protected $guarded = [];

    protected $appends = ['staff_name', 'status_name', 'notified', 'date_added_since'];

    public $timestamps = true;

    protected $casts = [
        'object_id' => 'integer',
        'user_id' => 'integer',
        'status_id' => 'integer',
        'notify' => 'boolean',
    ];

    public $relation = [
        'belongsTo' => [
            'user' => User::class,
            'status' => [Status::class, 'status_id'],
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
        return $this->user->staff_name ?? $value;
    }

    public function getDateAddedSinceAttribute($value): ?string
    {
        return $this->created_at ? time_elapsed($this->created_at) : null;
    }

    public function getStatusNameAttribute($value)
    {
        return ($this->status && $this->status->exists) ? $this->status->status_name : $value;
    }

    public function getNotifiedAttribute(): string
    {
        return $this->notify == 1 ? lang('igniter::admin.text_yes') : lang('igniter::admin.text_no');
    }

    /**
     * @param Status|mixed $status
     * @param Model|mixed $object
     * @param array $options
     */
    public static function createHistory($status, $object, $options = []): false|self
    {
        if (!$status instanceof Status) {
            $status = Status::find($status);
        }

        $statusId = $status->getKey();
        $previousStatus = $object->getOriginal('status_id');

        $model = new self;
        $model->status_id = $statusId;
        $model->object_id = $object->getKey();
        $model->object_type = $object->getMorphClass();
        $model->user_id = array_get($options, 'staff_id', array_get($options, 'user_id'));
        $model->comment = array_get($options, 'comment', $status->status_comment);
        $model->notify = array_get($options, 'notify', $status->notify_customer);

        if ($model->fireSystemEvent('admin.statusHistory.beforeAddStatus', [$object, $statusId, $previousStatus]) === false) {
            return false;
        }

        $model->save();

        // Update using query to prevent model events from firing
        $object->newQuery()->where($object->getKeyName(), $object->getKey())->update([
            'status_id' => $statusId,
            'status_updated_at' => Carbon::now(),
        ]);

        return $model;
    }

    public function isForOrder(): bool
    {
        return $this->object_type === (new Order)->getMorphClass();
    }

    //
    //
    //

    public function scopeApplyRelated($query, $model)
    {
        return $query->where('object_type', $model->getMorphClass())
            ->where('object_id', $model->getKey());
    }

    public function scopeWhereStatusIsLatest($query, $statusId)
    {
        return $query->where('status_id', $statusId)->orderBy('created_at', 'desc');
    }
}
