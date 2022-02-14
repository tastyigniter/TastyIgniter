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

    protected static $ingredientOptionsCache;

    /**
     * @var string The database table name
     */
    protected $table = 'menu_option_values';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'option_value_id';

    protected $fillable = ['option_id', 'value', 'price', 'ingredients', 'priority'];

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
            'ingredients' => ['Admin\Models\Ingredients_model', 'name' => 'ingredientable'],
        ],
    ];

    public $sortable = [
        'sortOrderColumn' => 'priority',
        'sortWhenCreating' => TRUE,
    ];

    public static function getDropDownOptions()
    {
        return static::dropdown('value');
    }

    public function getAllergensOptions()
    {
        return $this->getIngredientsOptions();
    }

    public function getIngredientsOptions()
    {
        if (self::$ingredientOptionsCache)
            return self::$ingredientOptionsCache;

        return self::$ingredientOptionsCache = Ingredients_model::dropdown('name')->all();
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
            return FALSE;

        $this->allergens()->sync($allergenIds);
    }
}
