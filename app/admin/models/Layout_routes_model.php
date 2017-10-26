<?php namespace Admin\Models;

use Model;

/**
 * Layout routes Model Class
 * @package Admin
 */
class Layout_routes_model extends Model
{
    /**
     * @var string The database table name
     */
    protected $table = 'layout_routes';

    protected $primaryKey = 'layout_route_id';

    protected $fillable = ['layout_id', 'uri_route'];

    public $relation = [
        'belongsTo' => [
            'layout' => ['Admin\Models\Layouts_model', 'foreignKey' => 'layout_id'],
        ],
    ];

    public static function findBySegments($segments)
    {
        $query = self::with([
            'layout.components',
        ])->whereIn('uri_route', $segments);

        $query->orderByRaw('FIELD(uri_route, "'.implode('", "', $segments).'")');

        return $query->first();
    }
}