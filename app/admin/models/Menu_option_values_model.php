<?php namespace Admin\Models;

use Igniter\Flame\Database\Traits\Sortable;
use Igniter\Flame\Database\Traits\Validation;
use Model;

/**
 * Menu_option_values Model Class
 *
 * @package Admin
 */
class Menu_option_values_model extends Model
{
    use Sortable;
    use Validation;

    /**
     * @var string The database table name
     */
    protected $table = 'option_values';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'option_value_id';

    protected $fillable = ['option_id', 'value', 'price'];

    public $relation = [
        'belongsTo' => [
            'option' => ['Admin\Models\Menu_options_model'],
        ],
    ];

    public $sortable = [
        'sortOrderColumn'  => 'priority',
        'sortWhenCreating' => FALSE,
    ];

    public $rules = [
        ['option_id', 'lang:admin::lang.menu_options.label_option_id', 'required|integer'],
        ['value', 'lang:admin::lang.menu_options.label_option_value', 'required|min:2|max:128'],
        ['price', 'lang:admin::lang.menu_options.label_option_price', 'required|numeric'],
    ];

    public static function getDropDownOptions()
    {
        return static::dropdown('value');
    }
}