<?php

declare(strict_types=1);

namespace Igniter\Admin\Models;

use Igniter\Flame\Database\Builder;
use Igniter\Flame\Database\Factories\HasFactory;
use Igniter\Flame\Database\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * Status Model Class
 *
 * @property int $status_id
 * @property string $status_name
 * @property string|null $status_comment
 * @property bool|null $notify_customer
 * @property string $status_for
 * @property string $status_color
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read string $status_for_name
 * @property Collection<StatusHistory>|StatusHistory|null $status_history
 * @method static Builder<static>|Status applyFilters(array $options = [])
 * @method static Builder<static>|Status applySorts(array $sorts = [])
 * @method static Builder<static>|Status isForOrder()
 * @method static Builder<static>|Status isForReservation()
 * @method static Builder<static>|Status listFrontEnd(array $options = [])
 * @method static Builder<static>|Status newModelQuery()
 * @method static Builder<static>|Status newQuery()
 * @method static Builder<static>|Status query()
 * @mixin \Illuminate\Database\Eloquent\Model
 */
class Status extends Model
{
    use HasFactory;

    /**
     * @var string The database table name
     */
    protected $table = 'statuses';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'status_id';

    protected $casts = [
        'notify_customer' => 'boolean',
    ];

    public $relation = [
        'hasMany' => [
            'status_history' => StatusHistory::class,
        ],
    ];

    public $timestamps = true;

    /**
     * Return status_for attribute as lang text, used by
     *
     * @param $row
     */
    public function getStatusForNameAttribute($value): string
    {
        return ($this->status_for == 'reservation') ? lang('igniter::admin.statuses.text_reservation') : lang('igniter::admin.statuses.text_order');
    }

    public function getStatusForDropdownOptions(): array
    {
        return [
            'order' => lang('igniter::admin.statuses.text_order'),
            'reservation' => lang('igniter::admin.statuses.text_reservation'),
        ];
    }

    public static function getDropdownOptionsForOrder()
    {
        return static::isForOrder()->dropdown('status_name');
    }

    public static function getDropdownOptionsForReservation()
    {
        return static::isForReservation()->dropdown('status_name');
    }

    //
    // Scopes
    //

    /**
     * Scope a query to only include order statuses
     *
     * @return $this
     */
    public function scopeIsForOrder($query)
    {
        return $query->where('status_for', 'order');
    }

    /**
     * Scope a query to only include reservation statuses
     *
     * @return $this
     */
    public function scopeIsForReservation($query)
    {
        return $query->where('status_for', 'reservation');
    }

    //
    // Helpers
    //

    public static function listStatuses()
    {
        return static::all()->keyBy('status_id');
    }
}
