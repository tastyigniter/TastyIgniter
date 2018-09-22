<?php

namespace System\Models;

use Igniter\Flame\Database\Traits\HasPermalink;
use Model;

/**
 * Pages Model Class
 *
 * @package Admin
 */
class Pages_model extends Model
{
    use HasPermalink;

    const CREATED_AT = 'date_added';

    const UPDATED_AT = 'date_updated';

    /**
     * @var string The database table name
     */
    protected $table = 'pages';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'page_id';

    /**
     * @var array The model table column to convert to dates on insert/update
     */
    public $timestamps = TRUE;

    public $relation = [
        'belongsTo' => [
            'language' => 'System\Models\Languages_model',
        ],
    ];

    public $casts = [
        'navigation' => 'serialize',
    ];

    protected $permalinkable = [
        'permalink_slug' => [
            'source' => 'title',
        ],
    ];

    public static function getDropdownOptions()
    {
        return static::isEnabled()->dropdown('name');
    }

    //
    // Scopes
    //

    /**
     * Scope a query to only include enabled page
     *
     * @param $query
     *
     * @return $this
     */
    public function scopeIsEnabled($query)
    {
        return $query->where('status', 1);
    }
}