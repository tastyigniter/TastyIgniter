<?php namespace Admin\Models;

use DB;
use Igniter\Flame\Permalink\Traits\HasPermalink;
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
            'layout'   => 'Admin\Models\Layouts_model',
        ],
    ];

    public $casts = [
        'navigation' => 'serialize',
    ];

    protected $permalinkable = [
        'permalink_slug' => [
            'source'  => 'title',
        ]
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

    //
    // Helpers
    //

    /**
     * Return all pages
     *
     * @return array
     */
    public function getPages()
    {
        return $this->isEnabled()->get();
    }

    /**
     * Find a single page by page_id
     *
     * @param int $page_id
     *
     * @return array
     */
    public function getPage($page_id)
    {
        return $this->findOrNew($page_id)->toArray();
    }

    /**
     * Create a new or update existing page
     *
     * @param int $page_id
     * @param array $save
     *
     * @return bool|int The $page_id of the affected row, or FALSE on failure
     */
    public function savePage($page_id, $save = [])
    {
        if (empty($save)) return FALSE;

        if (isset($save['title'])) {
            $save['name'] = $save['title'];
        }

        $pageModel = $this->findOrNew($page_id);

        if ($saved = $pageModel->fill($save)->save()) {
            if (!empty($save['permalink'])) {
                $this->permalink->savePermalink('pages', $save['permalink'], 'page_id='.$pageModel->getKey());
            }

            return $pageModel->getKey();
        }
    }

    /**
     * Delete a single or multiple page by page_id
     *
     * @param int $page_id
     *
     * @return int  The number of deleted rows
     */
    public function deletePage($page_id)
    {
        if (is_numeric($page_id)) $page_id = [$page_id];

        if (!empty($page_id) AND ctype_digit(implode('', $page_id))) {
            $affected_rows = $this->whereIn('page_id', $page_id)->delete();

            if ($affected_rows > 0) {
                foreach ($page_id as $id) {
                    $this->permalink->deletePermalink('pages', 'page_id='.$id);
                }

                return $affected_rows;
            }
        }
    }

    /**
     * Create or update the permalink for the saved page
     *
     * @param array|null $options
     * @param null $sessionKey
     *
     * @return bool
     */
    public function save(array $options = null, $sessionKey = null)
    {
        $dirtyAttributes = $this->attributes;
        $this->attributes = array_except($this->attributes, ['permalink_slug']);

        $saved = parent::save($options, $sessionKey);

        if (!isset($dirtyAttributes['permalink_slug']))
            return $saved;

        $permalink = $this->permalink_data()->updateOrCreate([
            'query'      => $this->getKeyName()."=".$this->getKey(),
            'controller' => 'pages',
        ]
//        );
//        $permalink->generateSlug();
        , [
           'slug' => str_slug(isset($dirtyAttributes['permalink_slug']) ? $dirtyAttributes['permalink_slug'] : $this->title)
        ]);

        return $saved;
    }
}