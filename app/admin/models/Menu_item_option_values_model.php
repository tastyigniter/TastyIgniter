<?php namespace Admin\Models;

use Igniter\Flame\Database\Traits\Sortable;
use Model;

/**
 * MenuOptions Model Class
 *
 * @package Admin
 */
class Menu_item_option_values_model extends Model
{
    use Sortable;

    const SORT_ORDER = 'priority';

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
            'menu'              => ['Admin\Models\Menus_model'],
            'option'            => ['Admin\Models\Menu_options_model'],
            'option_value'      => ['Admin\Models\Menu_option_values_model'],
            'menu_option'       => ['Admin\Models\Menu_item_options_model'],
            'menu_option_value' => ['Admin\Models\Menu_item_option_values_model'],
        ],
    ];
}