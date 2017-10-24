<?php namespace Admin\Models;

use DB;
use Igniter\Flame\Database\Traits\Purgeable;
use Model;
use Igniter\Flame\NestedSet\NestedTree;
use Igniter\Flame\Permalink\Traits\HasPermalink;
use Igniter\Flame\Database\Traits\Sortable;

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
            'source'  => 'name',
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

    /**
     * Scope a query to only include enabled category
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

    /**
     * Return all categories with child and sibling
     *
     * @param int $parent
     *
     * @return array
     */
    public function getCategories($parent = null)
    {
        $query = $this->newQuery();
        $tablePrefix = DB::getTablePrefix();
        $catOneTable = $tablePrefix.'cat1';
        $childTable = $tablePrefix.'child';
        $siblingTable = $tablePrefix.'sibling';

        $query->selectRaw("{$catOneTable}.category_id, {$catOneTable}.name, {$catOneTable}.description, {$catOneTable}.image, ".
            "{$catOneTable}.priority, {$catOneTable}.status, {$childTable}.category_id as child_id, {$siblingTable}.category_id as sibling_id");
        $query->from("categories AS cat1");
        $query->leftJoin("categories AS child", function ($join) {
            $join->on('child.parent_id', '=', 'cat1.category_id');
        });

        $query->leftJoin("categories AS sibling", function ($join) {
            $join->on('sibling.parent_id', '=', 'child.category_id');
        });

        if ($parent === null) {
            $query->where('cat1.parent_id', '>=', '0');
        }
        else if (empty($parent)) {
            $query->where('cat1.parent_id', '0');
        }
        else {
            $query->where('cat1.parent_id', $parent);
        }

        if (APPDIR === MAINDIR) {
            $query->where('cat1.status', '1');
        }

        $result = [];

        foreach ($query->get() as $row) {
            $result[$row['category_id']] = $row;
        }

        return $result;
    }

    /**
     * Find a single category by category_id
     *
     * @param int $category_id
     *
     * @return array
     */
    public function getCategory($category_id)
    {
        if (is_numeric($category_id)) {
            $query = $this->newQuery();

            if (APPDIR === MAINDIR) {
                $query->where('status', '1');
            }

            return $query->find($category_id);
        }
    }

    /**
     * Create a new or update existing menu category
     *
     * @param int $category_id
     * @param array $save
     *
     * @return bool|int The $category_id of the affected row, or FALSE on failure
     */
    public function saveCategory($category_id, $save = [])
    {
        if (empty($save)) return FALSE;

        $categoryModel = $this->findOrNew($category_id);

        $saved = $categoryModel->fill($save)->save();

        return $saved ? $categoryModel->getKey() : $saved;
    }

    /**
     * Delete a single or multiple category by category_id
     *
     * @param string|array $category_id
     *
     * @return int The number of deleted rows
     */
    public function deleteCategory($category_id)
    {
        if (is_numeric($category_id)) $category_id = [$category_id];

        if (!empty($category_id) AND ctype_digit(implode('', $category_id))) {
            return $this->whereIn('category_id', $category_id)->delete();
        }
    }
}