<?php namespace Admin\Models;

use Model;

/**
 * Location tables Model Class
 *
 * @package Admin
 */
class Location_tables_model extends Model
{
    /**
     * @var string The database table name
     */
    protected $table = 'location_tables';

    protected $primaryKey = 'table_id';

    public $incrementing = FALSE;

    public $relation = [
        'belongsTo' => [
            'tables' => ['Admin\Models\Tables_model'],
        ],
    ];
}