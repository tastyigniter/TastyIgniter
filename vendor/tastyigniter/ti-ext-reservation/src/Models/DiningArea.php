<?php

declare(strict_types=1);

namespace Igniter\Reservation\Models;

use Igniter\Flame\Database\Builder;
use Igniter\Flame\Database\Factories\HasFactory;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Database\Relations\BelongsTo;
use Igniter\Flame\Database\Relations\HasMany;
use Igniter\Flame\Exception\FlashException;
use Igniter\Local\Models\Concerns\Locationable;
use Igniter\Local\Models\Location;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * DiningArea Model Class
 *
 * @property int $id
 * @property int $location_id
 * @property string $name
 * @property string|null $description
 * @property array|null $floor_plan
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read mixed $dining_table_count
 * @property-read Location $location
 * @property-read Collection<int, DiningSection> $dining_sections
 * @property-read Collection<int, DiningTable> $dining_tables
 * @property-read Collection<int, DiningTable> $dining_table_solos
 * @property-read Collection<int, DiningTable> $dining_table_combos
 * @property-read Collection<int, DiningTable> $available_tables
 * @method static Builder<static>|DiningArea query()
 * @method static Builder<static>|DiningArea dropdown(string $column, string $key = null)
 * @method static BelongsTo<static>|DiningArea location()
 * @method static HasMany<static>|DiningArea dining_sections()
 * @method static HasMany<static>|DiningArea dining_tables()
 * @method static HasMany<static>|DiningArea dining_table_solos()
 * @method static HasMany<static>|DiningArea dining_table_combos()
 * @method static HasMany<static>|DiningArea available_tables()
 * @mixin Model
 */
class DiningArea extends Model
{
    use HasFactory;
    use Locationable;

    public $table = 'dining_areas';

    public $timestamps = true;

    protected $casts = [
        'floor_plan' => 'array',
    ];

    /**
     * @var array Relations
     */
    public $relation = [
        'hasMany' => [
            'dining_sections' => [DiningSection::class, 'foreignKey' => 'location_id', 'otherKey' => 'location_id'],
            'dining_tables' => [DiningTable::class, 'delete' => true],
            'dining_table_solos' => [DiningTable::class, 'scope' => 'whereIsNotCombo'],
            'dining_table_combos' => [DiningTable::class, 'scope' => 'whereIsCombo'],
            'available_tables' => [DiningTable::class, 'scope' => 'whereIsRoot'],
        ],
        'belongsTo' => [
            'location' => [Location::class],
        ],
    ];

    public static function getDropdownOptions()
    {
        return static::dropdown('name');
    }

    public function getTablesForFloorPlan()
    {
        return $this->available_tables->map(fn(DiningTable $diningTable, int $key) => $diningTable->toFloorPlanArray());
    }

    public function getDiningTablesWithReservation($reservations)
    {
        return $this->available_tables
            ->map(function(DiningTable $diningTable) use ($reservations) {
                $reservation = $reservations->first(fn(Reservation $reservation): bool => $reservation->tables->where('id', $diningTable->id)->count() > 0);

                return $diningTable->toFloorPlanArray($reservation);
            });
    }

    //
    // Events
    //

    //
    // Accessors & Mutators
    //

    public function getDiningTableCountAttribute($value): int
    {
        return $this->available_tables->count();
    }

    //
    // Helpers
    //

    public function duplicate()
    {
        /** @var DiningTable $newDiningArea */
        $newDiningArea = $this->replicate();
        $newDiningArea->name .= ' (copy)';
        $newDiningArea->save();

        $this->dining_tables
            ->filter(fn(DiningTable $table): bool => !$table->is_combo)
            ->each(function(DiningTable $table) use ($newDiningArea): void {
                /** @var DiningTable $newTable */
                $newTable = $table->replicate();
                $newTable->dining_area_id = $newDiningArea->getKey();
                $newTable->save();
            });

        return $newDiningArea;
    }

    public function createCombo(Collection $tables)
    {
        /** @var DiningTable $firstTable */
        $firstTable = $tables->first();
        $tableNames = $tables->pluck('name')->join('/');

        if ($tables->filter(fn(DiningTable $table): bool => $table->parent !== null)->isNotEmpty()) {
            throw new FlashException(lang('igniter.reservation::default.dining_areas.alert_table_already_combined'));
        }

        if ($tables->pluck('dining_section_id')->unique()->count() > 1) {
            throw new FlashException(lang('igniter.reservation::default.dining_areas.alert_table_combo_section_mismatch'));
        }

        /** @var DiningTable $comboTable */
        $comboTable = $this->dining_tables()->create([
            'name' => $tableNames,
            'shape' => $firstTable->shape,
            'dining_area_id' => $firstTable->dining_area_id,
            'dining_section_id' => $firstTable->dining_section_id,
            'min_capacity' => $tables->sum('min_capacity'),
            'max_capacity' => $tables->sum('max_capacity'),
            'is_combo' => true,
            'is_enabled' => true,
        ]);

        $tables->each(function($table) use ($comboTable): void {
            $table->parent()->associate($comboTable)->saveQuietly();
        });

        $comboTable->fixBrokenTreeQuietly();

        return $comboTable;
    }
}
