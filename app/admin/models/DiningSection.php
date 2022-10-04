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
        'hasMany' => [
            'dining_areas' => [DiningArea::class, 'foreignKey' => 'location_id', 'otherKey' => 'location_id'],
        ],
    ];

    public $rules = [
        'location_id' => ['required', 'integer'],
        'name' => ['required', 'string'],
        'description' => ['string'],
        'color' => ['nullable', 'string'],
    ];

    public function getRecordEditorOptions()
    {
        return self::dropdown('name');
    }

    public function scopeWhereIsReservable($query)
    {
        return $query->whereIsRoot()->where('is_enabled', 1);
    }
}
