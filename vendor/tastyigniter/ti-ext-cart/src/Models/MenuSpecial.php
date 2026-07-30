<?php

declare(strict_types=1);

namespace Igniter\Cart\Models;

use Carbon\Carbon;
use Igniter\Flame\Database\Factories\HasFactory;
use Igniter\Flame\Database\Model;
use Igniter\System\Models\Concerns\Switchable;

/**
 * MenuSpecial Model Class
 *
 * @property int $special_id
 * @property int $menu_id
 * @property \Illuminate\Support\Carbon|null $start_date
 * @property \Illuminate\Support\Carbon|null $end_date
 * @property float|null $special_price
 * @property bool $special_status
 * @property string $type
 * @property string $validity
 * @property array|null $recurring_every
 * @property mixed|null $recurring_from
 * @property mixed|null $recurring_to
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read mixed $pretty_end_date
 * @mixin Model
 */
class MenuSpecial extends Model
{
    use HasFactory;
    use Switchable;

    public const SWITCHABLE_COLUMN = 'special_status';

    /**
     * @var string The database table name
     */
    protected $table = 'menus_specials';

    protected $primaryKey = 'special_id';

    protected $fillable = [
        'menu_id', 'start_date',
        'end_date', 'special_price', 'type',
        'validity', 'recurring_every',
        'recurring_from', 'recurring_to',
    ];

    protected $casts = [
        'menu_id' => 'integer',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'special_price' => 'float',
        'recurring_from' => 'time',
        'recurring_to' => 'time',
        'recurring_every' => 'array',
    ];

    public static function getRecurringEveryOptions(): array
    {
        return ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    }

    public function getPrettyEndDateAttribute()
    {
        if ($this->isRecurring() || !$this->end_date) {
            return null;
        }

        return $this->end_date->format(lang('igniter::system.php.date_time_format'));
    }

    public function getTypeAttribute($value)
    {
        return empty($value) ? 'F' : $value;
    }

    public function getValidityAttribute($value)
    {
        return empty($value) ? 'forever' : $value;
    }

    public function active()
    {
        if ($this->isDisabled()) {
            return false;
        }

        return $this->isExpired() !== true;
    }

    public function daysRemaining()
    {
        if ($this->validity != 'period' || !$this->end_date->greaterThan(Carbon::now())) {
            return 0;
        }

        return $this->end_date->diffForHumans();
    }

    public function isRecurring(): bool
    {
        return $this->validity == 'recurring';
    }

    public function isExpired()
    {
        $now = Carbon::now();

        switch ($this->validity) {
            case 'period':
                return !$now->between($this->start_date, $this->end_date);
            case 'recurring':
                if (!in_array($now->format('w'), $this->recurring_every ?? [])) {
                    return true;
                }

                $start = $now->copy()->setTimeFromTimeString($this->recurring_from);
                $end = $now->copy()->setTimeFromTimeString($this->recurring_to);

                return !$now->between($start, $end);
            case 'forever':
            default:
                return false;
        }
    }

    public function isFixed(): bool
    {
        return $this->type !== 'P';
    }

    public function getMenuPrice($price)
    {
        if ($this->isFixed()) {
            return $this->special_price;
        }

        return $price - (($price / 100) * round($this->special_price));
    }
}
