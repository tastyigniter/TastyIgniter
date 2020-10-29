<?php

namespace Admin\Models;

use Igniter\Flame\Database\Traits\Purgeable;
use Igniter\Flame\Database\Traits\Sortable;
use Igniter\Flame\Database\Traits\Validation;
use Model;

/**
 * Menu_option_values Model Class
 */
class Menu_option_values_model extends Model
{
    use Purgeable;
    use Sortable;
    use Validation;

    /**
     * @var string The database table name
     */
    protected $table = 'menu_option_values';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'option_value_id';

    protected $fillable = ['option_id', 'value', 'price', 'allergens'];

    public $casts = [
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

    protected $purgeable = ['allergens'];

    public $sortable = [
        'sortOrderColumn' => 'priority',
        'sortWhenCreating' => FALSE,
    ];

    public $rules = [
        ['option_id', 'lang:admin::lang.menu_options.label_option_id', 'required|integer'],
        ['value', 'lang:admin::lang.menu_options.label_option_value', 'required|min:2|max:128'],
        ['price', 'lang:admin::lang.menu_options.label_option_price', 'required|numeric|min:0'],
    ];

    public static function getDropDownOptions()
    {
        return static::dropdown('value');
    }

    //
    // Events
    //
    protected function afterSave()
    {
        $this->restorePurgedValues();

        if (array_key_exists('allergens', $this->attributes))
            $this->addMenuAllergens((array)$this->attributes['allergens']);
    }

    protected function beforeDelete()
    {
        $this->addMenuAllergens([]);
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
