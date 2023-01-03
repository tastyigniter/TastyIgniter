<?php

namespace Admin\Models;

use Igniter\Flame\Database\Model;
use Igniter\Flame\Database\Traits\Validation;

/**
 * MenuOptions Model Class
 */
class Menu_item_option_values_model extends Model
{
    use Validation;

    protected static $optionValuesCollection;

    /**
     * @var string The database table name
     */
    protected $table = 'menu_item_option_values';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'menu_option_value_id';

    protected $fillable = ['menu_option_id', 'menu_id', 'option_id', 'option_value_id', 'new_price', 'priority', 'is_default'];

    public $appends = ['name', 'price'];

    protected $casts = [
        'menu_option_value_id' => 'integer',
        'menu_option_id' => 'integer',
        'option_value_id' => 'integer',
        'new_price' => 'float',
        'priority' => 'integer',
        'is_default' => 'boolean',
    ];

    public $relation = [
        'belongsTo' => [
            'option_value' => ['Admin\Models\Menu_option_values_model'],
            'menu_option' => ['Admin\Models\Menu_item_options_model'],
        ],
    ];

    public $rules = [
        ['menu_option_id', 'admin::lang.column_id', 'required|integer'],
        ['option_value_id', 'admin::lang.menus.label_option_value', 'required|integer'],
        ['new_price', 'admin::lang.menus.label_option_price', 'numeric|min:0'],
    ];

    public $timestamps = true;

    public function getOptionValueIdOptions()
    {
        if (!$optionId = optional($this->menu_option)->option_id)
            return [];

        if (!empty(self::$optionValuesCollection[$optionId]))
            return self::$optionValuesCollection[$optionId];

        $result = Menu_option_values_model::where('option_id', $optionId)->dropdown('value');

        self::$optionValuesCollection[$optionId] = $result;

        return $result;
    }

    public function getNameAttribute()
    {
        return $this->option_value ? $this->option_value->value : null;
    }

    public function getPriceAttribute()
    {
        if (is_null($this->new_price) && $this->option_value)
            return $this->option_value->price;

        return $this->new_price;
    }

    public function isDefault()
    {
        return $this->is_default == 1;
    }

    /**
     * Subtract or add to menu option item stock quantity
     *
     * @param int $quantity
     * @param bool $subtract
     * @return bool TRUE on success, or FALSE on failure
     */
    public function updateStock($quantity = 0, $subtract = true)
    {
        traceLog('Menu_item_option_values_model::updateStock() has been deprecated, use Stocks_model::updateStock() instead.');
    }
}
