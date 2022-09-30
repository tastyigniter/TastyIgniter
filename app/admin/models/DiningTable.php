<?php

namespace Admin\Models;

use Admin\Traits\Locationable;
use Igniter\Flame\Database\Traits\NestedTree;
use Igniter\Flame\Database\Traits\Sortable;
use Igniter\Flame\Database\Traits\Validation;

class DiningTable extends \Igniter\Flame\Database\Model
{
    use Sortable;
    use NestedTree;
    use Validation;
    use Locationable;

    const SORT_ORDER = 'priority';

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

    protected $guarded = [];

    /**
     * @var array Relations
     */
    public $relation = [
        'belongsTo' => [
            'dining_area' => [DiningArea::class],
            'dining_section' => [DiningSection::class],
        ],
        'belongsToMany' => [
            'reservations' => [Reservations_model::class, 'table' => 'reservation_tables', 'otherKey' => 'reservation_id'],
        ],
        'hasOneThrough' => [
            'location' => [
                Locations_model::class,
                'through' => DiningArea::class,
                'foreignKey' => 'id',
                'throughKey' => 'location_id',
                'otherKey' => 'dining_area_id',
                'secondOtherKey' => 'location_id',
            ],
        ],
    ];

    public $rules = [
        'name' => ['sometimes', 'required', 'string', 'between:2,255'],
        'type' => ['sometimes', 'in:rectangle,round'],
        'min_capacity' => ['sometimes', 'required', 'integer', 'min:1', 'lte:max_capacity'],
        'max_capacity' => ['sometimes', 'required', 'integer', 'min:1', 'gte:min_capacity'],
        'extra_capacity' => ['sometimes', 'required', 'integer'],
        'priority' => ['sometimes', 'required', 'integer'],
        'is_enabled' => ['sometimes', 'required', 'boolean'],
        'dining_area_id' => ['sometimes', 'required', 'integer'],
        'dining_section_id' => ['integer'],
    ];

    public function getDiningSectionIdOptions()
    {
        return $this->exists ? $this->dining_area->dining_sections()->dropdown('name') : [];
    }

    //
    // Events
    //

    public function beforeSave()
    {
        if (!$this->getRgt() || !$this->getLft())
            $this->fixTree();
    }

    //
    // Scopes
    //

    public function scopeReservable($query, $options)
    {
        $query->whereIsReservable();

        if (strlen($dateTime = array_get($options, 'dateTime')))
            $query->whereIsAvailableOn($dateTime);

        if (strlen($date = array_get($options, 'date')))
            $query->whereIsAvailableForDate($date);

        if (strlen($locationId = array_get($options, 'locationId')))
            $query->whereIsAvailableAt($locationId);

        if (strlen($guestNum = array_get($options, 'guestNum')))
            $query->whereCanAccommodate($guestNum);

        $query
            ->orderBy('dining_sections.priority')
            ->orderBy('dining_tables.priority');

        return $query;
    }

    public function scopeWhereIsReservable($query)
    {
        return $query
            ->whereIsRoot()
            ->where('dining_tables.is_enabled', 1)
            ->leftJoin('dining_sections', function ($join) {
                $join->on('dining_sections.id', '=', 'dining_tables.dining_section_id')
                    ->where('dining_sections.is_enabled', 1);
            });
    }

    public function scopeWhereIsCombo($query)
    {
        return $query->where('is_combo', 1);
    }

    public function scopeWhereIsNotCombo($query)
    {
        return $query->where('is_combo', '!=', 1);
    }

    public function scopeWhereIsAvailableAt($query, $locationId)
    {
        return $query->join('dining_areas', function ($join) use ($locationId) {
            $join->on('dining_areas.id', '=', 'dining_tables.dining_area_id')
                ->where('dining_areas.location_id', $locationId)
                ->where('dining_areas.is_active', 1);
        });
    }

    public function scopeWhereIsAvailableForDate($query, $date)
    {
        return $query->whereDoesntHave('reservations', function ($query) use ($date) {
            $query->where('reserve_date', $date)
                ->whereNotIn('status_id', [0, setting('canceled_reservation_status')]);
        });
    }

    public function scopeWhereIsAvailableOn($query, $dateTime)
    {
        return $query->whereDoesntHave('reservations', function ($query) use ($dateTime) {
            $query->whereBetweenStayTime($dateTime)
                ->whereNotIn('status_id', [0, setting('canceled_reservation_status')]);
        });
    }

    public function scopeWhereCanAccommodate($query, $guestNumber)
    {
        return $query
            ->where('min_capacity', '<=', $guestNumber)
            ->where('max_capacity', '>=', $guestNumber);
    }

    //
    // Accessors & Mutators
    //

    public function getNameAttribute($value)
    {
        if (!$this->is_combo || !$this->exists)
            return $value;

        return optional($this->children)->pluck('name')->join('/');
    }

    public function getSectionNameAttribute()
    {
        return optional($this->dining_section)->name;
    }

    //
    // Helpers
    //

    public function sortWhenCreating()
    {
        return false;
    }
}
