<?php namespace Admin\Models;

use Model;
use Igniter\Flame\Database\Traits\Sortable;

/**
 * Menu_option_values Model Class
 *
 * @package Admin
 */
class Menu_option_values_model extends Model
{
    use Sortable;

    const SORT_ORDER = 'priority';

    /**
     * @var string The database table name
     */
    protected $table = 'option_values';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'option_value_id';

    protected $fillable = ['option_id', 'value', 'price', 'priority'];

    public $relation = [
        'belongsTo' => [
            'options' => ['Admin\Models\Menu_options_model'],
        ],
    ];

    public static function getDropDownOptions()
    {
        return static::dropdown('value');
    }
}