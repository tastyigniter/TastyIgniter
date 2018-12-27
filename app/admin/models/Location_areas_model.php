<?php

namespace Admin\Models;

use Igniter\Flame\Location\Models\AbstractArea;

/**
 * Location areas Model Class
 *
 * @package Admin
 */
class Location_areas_model extends AbstractArea
{
    protected $fillable = ['area_id', 'type', 'name', 'boundaries', 'conditions', 'is_default'];

    public $boundary;

    public function getConditionsAttribute($value)
    {
        // backward compatibility v2.0
        if (!is_array($conditions = unserialize($value)))
            $conditions = [];

        foreach ($conditions as $key => &$item) {
            if (isset($item['condition'])) {
                $item['type'] = $item['condition'];
                unset($item['condition']);
            }
        }

        return $conditions;
    }

    public function afterSave()
    {
        if (!$this->is_default)
            return;

        $this->newQuery()->whereKeyNot($this->getKey())->update(['is_default' => 0]);
    }

    //
    // Helpers
    //
}