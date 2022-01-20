<?php

namespace Admin\Models;

use Igniter\Flame\Database\Traits\Sortable;
use Igniter\Flame\Location\Models\AbstractArea;

/**
 * Location areas Model Class
 */
class Location_areas_model extends AbstractArea
{
    use Sortable;

    const SORT_ORDER = 'priority';

    protected $fillable = ['area_id', 'type', 'name', 'boundaries', 'conditions', 'is_default', 'priority'];

    public $boundary;

    public function getConditionsAttribute($value)
    {
        // backward compatibility v2.0
        if (!is_array($conditions = json_decode($value, TRUE)))
            $conditions = [];

        foreach ($conditions as $key => &$item) {
            if (isset($item['condition'])) {
                $item['type'] = $item['condition'];
                unset($item['condition']);
            }
        }

        return $conditions;
    }

    protected function afterSave()
    {
        if (!$this->is_default)
            return;

        $this->newQuery()
            ->where('location_id', $this->location_id)
            ->whereKeyNot($this->getKey())
            ->update(['is_default' => 0]);
    }
}
