<?php

namespace Admin\Models;

use Admin\Traits\Locationable;
use Igniter\Flame\Database\Traits\Validation;

class DiningSection extends \Igniter\Flame\Database\Model
{
    use Validation;
    use Locationable;

    public $table = 'dining_sections';

    public $timestamps = true;

    /**
     * @var array Relations
     */
    public $relation = [
        'belongsTo' => [
            'location' => [Locations_model::class],
        ],
        'hasMany' => [
            'dining_areas' => [DiningArea::class, 'foreignKey' => 'location_id', 'otherKey' => 'location_id'],
        ],
    ];

    public $rules = [
        'location_id' => ['required', 'integer'],
        'name' => ['required', 'string'],
        'priority' => ['required', 'integer'],
        'description' => ['string'],
        'color' => ['nullable', 'string'],
    ];

    public function getRecordEditorOptions()
    {
        return self::dropdown('name');
    }

    public function getPriorityOptions()
    {
        return collect(range(0, 9))->map(function ($priority) {
            return lang('admin::lang.dining_tables.text_priority_'.$priority);
        })->all();
    }

    public function scopeWhereIsReservable($query)
    {
        return $query->where('is_enabled', 1);
    }
}
