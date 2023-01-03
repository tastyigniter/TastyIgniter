<?php

namespace Admin\Models;

use Admin\Traits\Stockable;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Database\Traits\Sortable;

/**
 * Menu_option_values Model Class
 */
class Menu_option_values_model extends Model
{
    use Sortable;
    use Stockable;

    /**
     * @var string The database table name
     */
    protected $table = 'menu_option_values';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'option_value_id';

    protected $fillable = ['option_id', 'value', 'price', 'allergens', 'priority'];

    protected $casts = [
        'option_value_id' => 'integer',
        'option_id' => 'integer',
        'price' => 'float',
        'priority' => 'integer',
    ];

    public $relation = [
        'belongsTo' => [
            'option' => ['Admin\Models\Menu_options_model'],
        ],
        'morphToMany' => [
            'allergens' => ['Admin\Models\Allergens_model', 'name' => 'allergenable'],
        ],
    ];

    public $sortable = [
        'sortOrderColumn' => 'priority',
        'sortWhenCreating' => true,
    ];

    public static function getDropDownOptions()
    {
        return static::dropdown('value');
    }

    public function getAllergensOptions()
    {
        if (self::$allergensOptionsCache)
            return self::$allergensOptionsCache;

        return self::$allergensOptionsCache = Allergens_model::dropdown('name')->all();
    }

    public function getStockableName()
    {
        return $this->value;
    }

    public function getStockableLocations()
    {
        return optional($this->option)->locations;
    }

    //
    // Events
    //

    protected function beforeDelete()
    {
        $this->allergens()->detach();
    }

    /**
     * Create new or update existing menu allergens
     *
     * @param array $allergenIds if empty all existing records will be deleted
     *
     * @return bool
     */
    public function addMenuAllergens(array $allergenIds = [])
    {
        if (!$this->exists)
            return false;

        $this->allergens()->sync($allergenIds);
    }
}
