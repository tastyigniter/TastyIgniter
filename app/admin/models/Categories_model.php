<?php namespace Admin\Models;

use DB;
use Igniter\Flame\Database\Traits\Sortable;
use Igniter\Flame\Permalink\Traits\HasPermalink;
use Model;

/**
 * Categories Model Class
 *
 * @package Admin
 */
class Categories_model extends Model
{
    use Sortable;
    use HasPermalink;

//    use NestedTree;

    const SORT_ORDER = 'priority';

    /**
     * @var string The database table name
     */
    protected $table = 'categories';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'category_id';

    protected $fillable = ['name', 'description', 'parent_id', 'priority', 'image', 'status'];

    public $relation = [
        'belongsTo'     => [
            'parent_cat' => ['Admin\Models\Categories_model', 'foreignKey' => 'parent_id', 'otherKey' => 'category_id'],
        ],
        'belongsToMany' => [
            'menus' => ['Admin\Models\Menus_model', 'table' => 'menu_categories'],
        ],
    ];

    public $permalinkable = [
        'permalink_slug' => [
            'source' => 'name',
//            'controller' => 'menus',
        ],
    ];

//    protected $with = ['permalink_data'];

    public static function getDropdownOptions()
    {
        return self::dropdown('name');
    }

    //
    // Accessors & Mutators
    //

    public function getDescriptionAttribute($value)
    {
        return strip_tags(html_entity_decode($value, ENT_QUOTES, 'UTF-8'));
    }

    //
    // Scopes
    //

    public function scopeWhereHasMenus($query)
    {
        return $query->whereExists(function ($q) {
            $prefix = DB::getTablePrefix();
            $q->select(DB::raw(1))
              ->from('menu_categories')
              ->join('menus', 'menus.menu_id', '=', 'menu_categories.menu_id')
              ->whereNotNull('menus.menu_status')
              ->where('menus.menu_status', '=', 1)
              ->whereRaw($prefix.'categories.category_id = '.$prefix.'menu_categories.category_id');
        });
    }

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
        if (isset($filter['filter_search']) AND is_string($filter['filter_search'])) {
            $query->search($filter['filter_search'], ['name']);
        }

        if (is_numeric($filter['filter_status'])) {
            $query->where('menu_status', $filter['filter_status']);
        }

        return $query;
    }

    //
    // Helpers
    //

    public function getThumb($options = [])
    {
        extract(array_merge([
            'width'  => 800,
            'height' => 65,
        ], $options));

        return Image_tool_model::resize($this->image, $width, $height);
    }
}