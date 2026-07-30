<?php

declare(strict_types=1);

namespace Igniter\Reservation\Models;

use Igniter\Flame\Database\Builder;
use Igniter\Flame\Database\Factories\HasFactory;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Database\Relations\BelongsTo;
use Igniter\Flame\Database\Relations\BelongsToMany;
use Igniter\Flame\Database\Relations\HasOneThrough;
use Igniter\Flame\Database\Traits\NestedTree;
use Igniter\Flame\Database\Traits\Sortable;
use Igniter\Local\Models\Concerns\Locationable;
use Igniter\Local\Models\Location;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Kalnoy\Nestedset\Collection as NestedSetCollection;

/**
 * DiningTable Model Class
 *
 * @property int $id
 * @property int $dining_area_id
 * @property int|null $dining_section_id
 * @property int|null $parent_id
 * @property string $name
 * @property string|null $shape
 * @property int $min_capacity
 * @property int $max_capacity
 * @property int $extra_capacity
 * @property bool $is_combo
 * @property bool $is_enabled
 * @property int|null $nest_left
 * @property int|null $nest_right
 * @property int $priority
 * @property array|null $seat_layout
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read NestedSetCollection<int, DiningTable> $children
 * @property-read int|null $children_count
 * @property-read mixed $section_name
 * @property-read DiningTable|null $parent
 * @property-read Location|null $location
 * @property-read DiningArea|null $dining_area
 * @property-read DiningSection|null $dining_section
 * @property-read Collection<int, Reservation> $reservations
 * @method static Collection<int, DiningTable> descendants()
 * @method static Builder<static>|DiningTable sync($relations, $deleting = true)
 * @method static Builder<static>|DiningTable query()
 * @method static HasOneThrough<static>|DiningTable location()
 * @method static BelongsTo<static>|DiningTable dining_area()
 * @method static BelongsTo<static>|DiningTable dining_section()
 * @method static BelongsToMany<static>|DiningTable reservations()
 * @method static Builder<static>|DiningTable whereIsReservable()
 * @method static Builder<static>|DiningTable whereIsAvailableOn($dateTime, $duration)
 * @method static Builder<static>|DiningTable whereIsAvailableForDate($date)
 * @method static Builder<static>|DiningTable whereIsAvailableAt($locationId)
 * @method static Builder<static>|DiningTable whereCanAccommodate($guestNumber)
 * @method static Builder<static>|DiningTable whereIsRoot()
 * @method static Builder<static>|DiningTable whereHasLocation(int|string|Model $locationId)
 * @method static Builder<static>|DiningTable reservable(array $options)
 * @mixin Model
 */
class DiningTable extends Model
{
    use HasFactory;
    use Locationable;
    use NestedTree;
    use Sortable;

    public const string SORT_ORDER = 'priority';

    public $table = 'dining_tables';

    public $timestamps = true;

    protected $casts = [
        'min_capacity' => 'integer',
        'max_capacity' => 'integer',
        'extra_capacity' => 'integer',
        'priority' => 'integer',
        'is_combo' => 'boolean',
        'is_enabled' => 'boolean',
        'seat_layout' => 'array',
    ];

    /**
     * @var array Relations
     */
    public $relation = [
        'belongsTo' => [
            'dining_area' => [DiningArea::class],
            'dining_section' => [DiningSection::class],
        ],
        'belongsToMany' => [
            'reservations' => [Reservation::class, 'table' => 'reservation_tables', 'otherKey' => 'reservation_id'],
        ],
        'hasOneThrough' => [
            'location' => [
                Location::class,
                'through' => DiningArea::class,
                'foreignKey' => 'id',
                'throughKey' => 'location_id',
                'otherKey' => 'dining_area_id',
                'secondOtherKey' => 'location_id',
            ],
        ],
    ];

    public $attributes = [
        'priority' => 0,
        'extra_capacity' => 0,
    ];

    public function getDiningSectionIdOptions()
    {
        return $this->exists
            ? DiningSection::query()
                ->whereHasLocation($this->dining_area?->location_id)
                ->dropdown('name')
            : [];
    }

    public function getPriorityOptions()
    {
        return collect(range(0, 9))->map(fn($priority): string => lang('igniter.reservation::default.dining_tables.text_priority_'.$priority))->all();
    }

    //
    // Accessors & Mutators
    //

    public function getSectionNameAttribute(): ?string
    {
        return $this->dining_section?->name;
    }

    public function getSummaryAttribute(): string
    {
        return sprintf(
            '%s / %s - %s (%s+)',
            $this->name,
            $this->min_capacity,
            $this->max_capacity,
            $this->extra_capacity,
        );
    }

    //
    // Helpers
    //

    public function sortWhenCreating(): bool
    {
        return false;
    }

    public function toFloorPlanArray($reservation = null)
    {
        $defaults = [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->min_capacity.'-'.$this->max_capacity,
            'capacity' => $this->max_capacity,
            'shape' => $this->shape,
            'seatLayout' => $this->seat_layout,
            'tableColor' => null,
            'seatColor' => null,
            'customerName' => null,
        ];

        if (!is_null($reservation)) {
            $defaults['description'] = $reservation->reservation_datetime->isoFormat(lang('system::lang.moment.time_format'))
                .' - '.$reservation->reservation_end_datetime->isoFormat(lang('system::lang.moment.time_format'));

            $defaults['seatColor'] = $reservation->status->status_color ?? null;
            $defaults['customerName'] = $reservation->customer_name;
        }

        return $defaults;
    }
}
