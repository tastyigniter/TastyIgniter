<?php namespace Admin\Models;

use Igniter\Flame\Database\Traits\Validation;
use Model;

/**
 * MenuOptions Model Class
 *
 * @package Admin
 */
class Menu_item_option_values_model extends Model
{
    use Validation;

    /**
     * @var string The database table name
     */
    protected $table = 'menu_option_values';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'menu_option_value_id';

    protected $fillable = ['menu_option_id', 'menu_id', 'option_id', 'option_value_id', 'new_price', 'priority', 'is_default', 'quantity', 'subtract_stock'];

    public $relation = [
        'belongsTo' => [
            'option_value' => ['Admin\Models\Menu_option_values_model'],
            'menu_option'  => ['Admin\Models\Menu_item_options_model'],
        ],
    ];

    public $rules = [
        ['menu_option_id', 'lang:admin::lang.menus.label_option_value_id', 'required|integer'],
        ['option_value_id', 'lang:admin::lang.menus.label_option_value', 'required|integer'],
        ['new_price', 'lang:admin::lang.menus.label_option_price', 'numeric'],
        ['quantity', 'lang:admin::lang.menus.label_option_qty', 'numeric'],
        ['subtract_stock', 'lang:admin::lang.menus.label_option_subtract_stock', 'numeric'],
    ];

    public $appends = ['name', 'price'];

    public function getNameAttribute()
    {
        return $this->option_value ? $this->option_value->value : null;
    }

    public function getPriceAttribute()
    {
        if (!$this->option_value)
            return $this->new_price;

        return (!$this->new_price OR $this->new_price <= 0) ? $this->option_value->price : $this->new_price;
    }

    public function isDefault()
    {
        return $this->is_default == 1;
    }
}