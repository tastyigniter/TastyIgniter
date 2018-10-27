<?php namespace Admin\Models;

use Admin\Traits\Locationable;
use DB;
use Igniter\Flame\Database\Attach\HasMedia;
use Igniter\Flame\Database\Traits\HasPermalink;
use Igniter\Flame\Database\Traits\NestedTree;
use Igniter\Flame\Database\Traits\Sortable;
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

    protected $fillable = ['name', 'description', 'parent_id', 'priority', 'image', 'status'];

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
}