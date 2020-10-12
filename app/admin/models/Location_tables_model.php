<?php

namespace Admin\Models;

use Model;

/**
 * Location tables Model Class
 */
class Location_tables_model extends Model
{
    /**
     * @var string The database table name
     */
    protected $table = 'location_tables';

    protected $primaryKey = 'table_id';

    public $incrementing = FALSE;

    public $casts = [
        'location_id' => 'integer',
        'table_id' => 'integer',
    ];

    public $relation = [
        'belongsTo' => [
            'tables' => ['Admin\Models\Tables_model'],
        ],
    ];
}
