<?php

namespace Admin\Models;

use Admin\Traits\Locationable;
use Igniter\Flame\Database\Attach\HasMedia;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Database\Traits\HasPermalink;
use Igniter\Flame\Database\Traits\NestedTree;
use Igniter\Flame\Database\Traits\Sortable;
use Illuminate\Support\Facades\DB;

/**
 * Categories Model Class
 */
class Categories_model extends Model
{
    use Sortable;
    use HasPermalink;
    use NestedTree;
    use Locationable;
    use HasMedia;

    const SORT_ORDER = 'priority';

    const LOCATIONABLE_RELATION = 'locations';

    /**
     * @var string The database table name
     */
    protected $table = 'categories';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'category_id';

    protected $guarded = [];

    protected $casts = [
        'parent_id' => 'integer',
        'priority' => 'integer',
        'status' => 'boolean',
        'nest_left' => 'integer',
        'nest_right' => 'integer',
    ];

    public $relation = [
        'belongsTo' => [
            'parent_cat' => ['Admin\Models\Categories_model', 'foreignKey' => 'parent_id', 'otherKey' => 'category_id'],
        ],
        'belongsToMany' => [
            'menus' => ['Admin\Models\Menus_model', 'table' => 'menu_categories'],
        ],
        'morphToMany' => [
            'locations' => ['Admin\Models\Locations_model', 'name' => 'locationable'],
        ],
    ];

    public $permalinkable = [
        'permalink_slug' => [
            'source' => 'name',
        ],
    ];

    public $mediable = ['thumb'];

    public static $allowedSortingColumns = ['priority asc', 'priority desc'];

    public $timestamps = true;

    public static function getDropdownOptions()
    {
        return self::pluck('name', 'category_id');
    }

    //
    // Accessors & Mutators
    //

    public function getDescriptionAttribute($value)
    {
        return strip_tags(html_entity_decode($value, ENT_QUOTES, 'UTF-8'));
    }

    public function getCountMenusAttribute($value)
    {
        return $this->menus()->count();
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

    public function scopeListFrontEnd($query, $options = [])
    {
        extract(array_merge([
            'page' => 1,
            'pageLimit' => 20,
            'enabled' => true,
            'sort' => 'id asc',
            'location' => null,
            'search' => '',
        ], $options));

        $searchableFields = ['name', 'description'];

        if (strlen($location)) {
            $query->whereHasOrDoesntHaveLocation($location);
        }

        if (!is_array($sort)) {
            $sort = [$sort];
        }

        foreach ($sort as $_sort) {
            if (in_array($_sort, self::$allowedSortingColumns)) {
                $parts = explode(' ', $_sort);
                if (count($parts) < 2) {
                    $parts[] = 'desc';
                }
                [$sortField, $sortDirection] = $parts;
                $query->orderBy($sortField, $sortDirection);
            }
        }

        $search = trim($search);
        if (strlen($search)) {
            $query->search($search, $searchableFields);
        }

        if ($enabled) {
            $query->isEnabled();
        }

        $this->fireEvent('model.extendListFrontEndQuery', [$query]);

        return $query->paginate($pageLimit, $page);
    }
}
