<?php

namespace Admin\Models;

use Igniter\Flame\Database\Model;

/**
 * Location tables Model Class
 * @deprecated remove before v4. Added for backward compatibility, see Locationable
 */
class Location_tables_model extends Model
{
    /**
     * @var string The database table name
     */
    protected $table = 'location_tables';

    protected $primaryKey = 'table_id';

    public $incrementing = false;

    protected $casts = [
        'location_id' => 'integer',
        'table_id' => 'integer',
    ];

    public $relation = [
        'belongsTo' => [
            'tables' => ['Admin\Models\Tables_model'],
        ],
    ];
}
