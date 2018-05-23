<?php namespace Admin\Models;

use Igniter\Flame\Database\Traits\Sortable;
use Model;

/**
 * MenuOptions Model Class
 *
 * @package Admin
 */
class Menu_item_options_model extends Model
{
    use Sortable;

    const SORT_ORDER = 'priority';

    protected static $optionValuesCollection;

    /**
     * @var string The database table name
     */
    protected $table = 'menu_options';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'menu_option_id';

    protected $fillable = ['option_id', 'menu_id', 'required', 'priority', 'default_value_id', 'option_values'];

    public $relation = [
        'hasMany'   => [
            'values'             => ['Admin\Models\Menu_option_values_model', 'foreignKey' => 'option_id', 'otherKey' => 'option_id'],
            'menu_option_values' => ['Admin\Models\Menu_item_option_values_model', 'foreignKey' => 'menu_option_id', 'delete' => TRUE],
        ],
        'belongsTo' => [
            'menu'   => ['Admin\Models\Menus_model'],
            'option' => ['Admin\Models\Menu_options_model'],
        ],
    ];

    public $casts = [
        'option_values' => 'serialize',
    ];

    public $appends = ['option_name', 'display_type'];

    public function getOptionNameAttribute()
    {
        return $this->option->option_name;
    }

    public function getDisplayTypeAttribute()
    {
        return $this->option->display_type;
    }

    public function getOptionValuesAttribute()
    {
        return $this->getOptionValues();
    }

    public function getOptionValues()
    {
        return $this->optionValues()->get();
    }

    public function optionValues()
    {
        return $this->menu_option_values()->with('option_value');
    }

    //
    // Helpers
    //

    public function isRequired()
    {
        return $this->required == 1;
    }

    public function listOptionValues($data, $field)
    {
        if (!empty(self::$optionValuesCollection[$this->option_id]))
            return self::$optionValuesCollection[$this->option_id];

        $result = Menu_option_values_model::select('option_value_id', 'option_id', 'value')
                                         ->where('option_id', $this->option_id)
                                         ->get()
                                         ->pluck('value', 'option_value_id');

        self::$optionValuesCollection[$this->option_id] = $result;

        return self::$optionValuesCollection;
    }
}