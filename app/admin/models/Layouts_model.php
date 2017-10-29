<?php namespace Admin\Models;

use Model;

/**
 * Layouts Model Class
 *
 * @package Admin
 */
class Layouts_model extends Model
{
    /**
     * @var string The database table name
     */
    protected $table = 'layouts';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'layout_id';

    public $relation = [
        'hasMany' => [
            'routes'     => ['Admin\Models\Layout_routes_model', 'delete' => TRUE],
            'components' => ['Admin\Models\Layout_modules_model', 'delete' => TRUE],
        ],
    ];

    public $purgeable = ['routes', 'components'];

    public static function getDropdownOptions()
    {
        return static::dropdown('name');
    }
}