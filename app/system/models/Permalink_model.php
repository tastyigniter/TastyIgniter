<?php namespace System\Models;

use Model;

/**
 * Permalink Model Class
 *
 * @package System
 */
class Permalink_model extends Model
{
    /**
     * @var string The database table name
     */
    protected $table = 'permalinks';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'permalink_id';

    protected $fillable = ['permalink_id', 'slug', 'source_name', 'controller', 'query'];

    public $relation = [
        'morphTo' => [
            'source' => [],
        ],
    ];

    public function beforeSave()
    {
        dd($this);
    }

    //
    // Scopes
    //

    public function scopeSelectSlug($query)
    {
        return $query->select('source_id', 'source_name', 'slug', 'query', 'controller');
        //->pluck($attribute, $this->model->getKeyName())
    }

    public function scopePluckSlug($query, $key = null)
    {
        return $query->lists('slug', $key ?: $this->getKeyName());
    }

    /**
     * Query scope for finding "similar" slugs, used to determine uniqueness.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $attribute
     * @param array $config
     * @param string $slug
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFindSimilarSlugs($query, $attribute, array $config, $slug)
    {
        $separator = $config['separator'];

        $query->where('source_name', $attribute);

        return $query->where(function ($q) use ($attribute, $slug, $separator) {
            $q->where('slug', $slug)
              ->orWhere('slug', 'LIKE', $slug.$separator.'%');
        });
    }

    public function scopeFindBySlugKeyName($query, $attribute)
    {
        return $query->where('source_name', $attribute);
    }

    public function scopeApplySource($query, $object)
    {
        return $query->applySourceType($object)
                     ->where('source_id', $object->getKey());
    }

    public function scopeApplySourceType($query, $object)
    {
        return $query->where('source_type', $object->getMorphClass());
    }

    public function scopeWhereQueryAndController($query, $httpQuery, $controller)
    {
        return $query->where('query', $httpQuery)->where('controller', $controller);
    }

    public function scopeWhereSlugAndController($q, $slug, $controller)
    {
        return $q->where('slug', $slug)->where('controller', $controller);
    }

    //
    // Helpers
    //

    public function slug()
    {
        return isset($this->attributes['slug']) ? $this->attributes['slug'] : null;
    }

    public function setConfigValues($slug, $name, $controller)
    {
        $this->slug = $slug;
        $this->source_name = $name;
        $this->controller = $controller;

        $source = $this->source()->first();

        // Set using attributes array so it doesn't collide with the underlying Query Builder
        $this->attributes['query'] = $source->getKeyName().'='.$source->getKey();
    }

    /**
     * Determine if a record exists with the given slug.
     */
    public function otherRecordExistsWithSlug($slug, $controller = 'pages')
    {
        $query = static::where('slug', $slug)
                       ->where('controller', $controller)
                       ->where($this->getKeyName(), '!=', $this->getKey() ?: '0')
                       ->withoutGlobalScopes();

        return (bool)$query->first();
    }

    /**
     * Check is permalink is enabled
     *
     * @return bool TRUE if enabled, or FALSE if disabled
     */
    public function isPermalinkEnabled()
    {
        return (setting('permalink', true)) ? TRUE : FALSE;
    }

    /**
     * Return all permalinks
     *
     * @return array
     */
    public function getPermalinks()
    {
        if (!$this->isPermalinkEnabled()) {
            return [];
        }

        return $this->get();
    }

    /**
     * Find a single permalink by query
     *
     * @param string $query
     *
     * @return array|bool
     */
    public function getPermalink($query)
    {
        if (!$this->isPermalinkEnabled()) return [];

        return $this->firstOrNew('query', $query)->toArray();
    }

//    /**
//     * Create a new or update an existing permalink
//     *
//     * @param string $controller
//     * @param array $permalink
//     * @param string $query
//     *
//     * @return bool|int The $page_id of the affected row, or FALSE on failure
//     */
//    public function savePermalink($controller, $permalink = [], $query = '')
//    {
//        if (!$this->isPermalinkEnabled()) return FALSE;
//
//        if (empty($controller)) return FALSE;
//
//        $permalink_id = !empty($permalink['permalink_id']) ? $permalink['permalink_id'] : null;
//
//        if (!empty($permalink['slug']) AND !empty($query)) {
//            $slug = $this->_checkDuplicate($controller, $permalink);
//
//            if ($permalink_id) {
//                $this->where('permalink_id', $permalink['permalink_id'])->where('query', $query)
//                     ->update(['slug' => $slug, 'controller' => $controller]);
//            }
//            else {
//                $this->whereQueryAndController($query, $controller)->delete();
//
//                $permalink_id = $this->insertGetId(['slug' => $slug, 'controller' => $controller, 'query' => $query]);
//            }
//        }
//
//        return $permalink_id;
//    }
//
//    /**
//     * Makes sure permalink slug does not already exist
//     *
//     * @param string $controller
//     * @param array $permalink
//     * @param string $duplicate
//     *
//     * @return mixed|string
//     */
//    protected function _checkDuplicate($controller, $permalink = [], $duplicate = '0')
//    {
//        if (!empty($controller) AND !empty($permalink['slug'])) {
//
//            $slug = ($duplicate > 0) ? $permalink['slug'].'-'.$duplicate : $permalink['slug'];
//            $slug = str_slug($slug, '-', TRUE);
//
//            $row = $this->whereSlugAndController($slug, $controller)->first();
//
//            if ($row) {
//                if (!empty($permalink['permalink_id']) AND $permalink['permalink_id'] == $row->permalink_id) {
//                    return $slug;
//                }
//
//                $duplicate++;
//                $slug = $this->_checkDuplicate($controller, $permalink, $duplicate);
//            }
//
//            return $slug;
//        }
//    }
//
//    /**
//     * Delete a single or multiple permalink by controller and query
//     *
//     * @param string $controller
//     * @param string $query
//     *
//     * @return int  The number of deleted rows
//     */
//    public function deletePermalink($controller, $query)
//    {
//        if (is_string($controller) AND is_string($query)) {
//            $affected_rows = $this->whereQueryAndController($query, $controller)->delete();
//
//            return ($affected_rows > 0);
//        }
//    }
}