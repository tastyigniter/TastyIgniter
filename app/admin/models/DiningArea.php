<?php

namespace Admin\Models;

use Admin\Traits\Locationable;
use Igniter\Flame\Database\Traits\Purgeable;
use Igniter\Flame\Exception\ApplicationException;
use Illuminate\Support\Collection;

class DiningArea extends \Igniter\Flame\Database\Model
{
    use Purgeable;
    use Locationable;

    public $table = 'dining_areas';

    public $timestamps = true;

    /**
     * @var array Relations
     */
    public $relation = [
        'hasMany' => [
            'dining_sections' => [DiningSection::class, 'foreignKey' => 'location_id', 'otherKey' => 'location_id'],
            'dining_tables' => [DiningTable::class],
            'dining_table_solos' => [DiningTable::class, 'scope' => 'whereIsNotCombo'],
            'dining_table_combos' => [DiningTable::class, 'scope' => 'whereIsCombo'],
            'available_tables' => [DiningTable::class, 'scope' => 'whereIsRoot'],
        ],
        'belongsTo' => [
            'location' => [Locations_model::class],
        ],
    ];

    protected $purgeable = ['dining_table_solos', 'dining_table_combos', 'dining_table_layout'];

    public static function getDropdownOptions()
    {
        return static::dropdown('name');
    }

    public function getTablesForFloorPlan()
    {
        return $this->available_tables;
    }

    //
    // Events
    //

    protected function afterSave()
    {
        $this->restorePurgedValues();

        if (array_key_exists('dining_table_layout', $this->attributes))
            $this->updateTableLayouts((array)$this->attributes['dining_table_layout']);
    }

    //
    // Accessors & Mutators
    //

    public function getDiningTableCountAttribute($value)
    {
        return $this->available_tables->count();
    }

    public function scopeWhereIsActive($query)
    {
        return $query->whereIsRoot()->where('is_active', 1);
    }

    //
    // Helpers
    //

    public function createCombo(Collection $tables)
    {
        $firstTable = $tables->first();
        $tableNames = $tables->pluck('name')->join('/');

        if ($tables->whereNotNull('parent_id')->isNotEmpty())
            throw new ApplicationException(lang('admin::lang.dining_areas.alert_table_already_combined'));

        if ($tables->pluck('dining_section_id')->unique()->count() > 1)
            throw new ApplicationException(lang('admin::lang.dining_areas.alert_table_combo_section_mismatch'));

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

        $tables->each(function ($table) use ($comboTable) {
            $table->parent()->associate($comboTable)->save();
        });

        return $comboTable;
    }

    protected function updateTableLayouts(array $layouts)
    {
        collect($layouts)->each(function ($layout, $tableId) {
            $diningTable = $this->dining_tables()->find($tableId);

            $diningTable->seat_layout = $layout;
            $diningTable->saveOrFail();
        });
    }
}
