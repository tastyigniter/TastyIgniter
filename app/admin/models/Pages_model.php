<?php namespace Admin\Models;

use DB;
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

    protected $fillable = ['language_id', 'name', 'title', 'heading', 'content', 'meta_description',
        'meta_keywords', 'layout_id', 'navigation', 'date_added', 'date_updated', 'status'];

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

    /**
     * Filter database records
     *
     * @param $query
     * @param array $filter an associative array of field/value pairs
     *
     * @return $this
     */
    public function scopeFilter($query, $filter = [])
    {
        $languagesTable = DB::getTablePrefix().'languages';
        $pagesTable = DB::getTablePrefix().'pages';

        $query->selectRaw("*, {$languagesTable}.name AS language_name, {$pagesTable}.name AS name, {$pagesTable}.status AS status");
        $query->join('languages', 'languages.language_id', '=', 'pages.language_id', 'left');

        if (isset($filter['filter_search']) AND is_string($filter['filter_search'])) {
            $query->search($filter['filter_search'], [$pagesTable.'.name']);
        }

        if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
            $query->where('pages.status', $filter['filter_status']);
        }

        return $query;
    }

    public function getContentAttribute($value)
    {
        return html_entity_decode($value);
    }
}