<?php

declare(strict_types=1);

namespace Igniter\Cart\Models;

use Carbon\CarbonImmutable;
use Igniter\Flame\Database\Factories\HasFactory;
use Igniter\Flame\Database\Model;
use Igniter\Local\Models\Concerns\Locationable;
use Igniter\Local\Models\Location;
use Igniter\System\Models\Concerns\Switchable;
use Illuminate\Support\Carbon;

/**
 * Mealtime Model Class
 *
 * @property int $mealtime_id
 * @property string $mealtime_name
 * @property string|null $start_time
 * @property string|null $end_time
 * @property string $validity
 * @property Carbon|null $start_at
 * @property Carbon|null $end_at
 * @property array|null $recurring_every
 * @property string|null $recurring_from
 * @property string|null $recurring_to
 * @property bool $mealtime_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @mixin Model
 */
class Mealtime extends Model
{
    use HasFactory;
    use Locationable;
    use Switchable;

    public const string LOCATIONABLE_RELATION = 'locations';

    public const string SWITCHABLE_COLUMN = 'mealtime_status';

    /**
     * @var string The database table name
     */
    protected $table = 'mealtimes';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'mealtime_id';

    protected $casts = [
        'start_time' => 'time',
        'end_time' => 'time',
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'recurring_every' => 'array',
        'recurring_from' => 'time',
        'recurring_to' => 'time',
        'mealtime_status' => 'boolean',
    ];

    public $relation = [
        'morphToMany' => [
            'locations' => [Location::class, 'name' => 'locationable'],
        ],
    ];

    public $timestamps = true;

    public function getRecurringEveryOptions(): array
    {
        return ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    }

    public static function getDropdownOptions()
    {
        return self::whereIsEnabled()->dropdown('mealtime_name');
    }

    public function isAvailable($dateTime = null): bool
    {
        $dateTime = is_null($dateTime)
            ? CarbonImmutable::now()
            : CarbonImmutable::parse($dateTime);

        switch ($this->validity ?? 'daily') {
            case 'period':
                return $dateTime->between($this->start_at, $this->end_at);
            case 'recurring':
                if (!in_array($dateTime->format('w'), $this->recurring_every)) {
                    return false;
                }

                $start = $dateTime->setTimeFromTimeString($this->recurring_from);
                $end = $dateTime->setTimeFromTimeString($this->recurring_to);

                if ($start->gt($end)) {
                    $end = $end->addDay();
                }

                return $dateTime->between($start, $end);
            default: // daily
                return $dateTime->between(
                    $dateTime->setTimeFromTimeString($this->start_time),
                    $dateTime->setTimeFromTimeString($this->end_time),
                );
        }
    }

    public function isAvailableNow(): bool
    {
        return $this->isAvailable();
    }

    public function getDescriptionAttribute(): string
    {
        switch ($this->validity ?? 'daily') {
            case 'period':
                return sprintf(
                    lang('igniter.cart::default.mealtimes.text_period_mealtime'),
                    $this->start_at->isoFormat(lang('system::lang.moment.date_time_format')),
                    $this->end_at->isoFormat(lang('system::lang.moment.date_time_format')),
                );
            case 'recurring':
                $startAt = now()->setTimeFromTimeString($this->recurring_from);
                $endAt = now()->setTimeFromTimeString($this->recurring_to);

                return sprintf(
                    lang('igniter.cart::default.mealtimes.text_recurring_mealtime'),
                    implode(', ', array_only($this->getRecurringEveryOptions(), $this->recurring_every)),
                    $startAt->isoFormat(lang('system::lang.moment.time_format')),
                    $endAt->isoFormat(lang('system::lang.moment.time_format')),
                );
            default: // daily
                return sprintf(
                    lang('igniter.cart::default.mealtimes.text_daily_mealtime'),
                    now()->setTimeFromTimeString($this->start_time)->isoFormat(lang('system::lang.moment.time_format')),
                    now()->setTimeFromTimeString($this->end_time)->isoFormat(lang('system::lang.moment.time_format')),
                );
        }
    }
}
