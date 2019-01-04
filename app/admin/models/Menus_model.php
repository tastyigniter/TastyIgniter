<?php namespace Admin\Models;

use Admin\Traits\Locationable;
use Event;
use Igniter\Flame\ActivityLog\Traits\LogsActivity;
use Igniter\Flame\Database\Attach\HasMedia;
use Igniter\Flame\Database\Traits\Purgeable;
use Model;

/**
 * Menus Model Class
 *
 * @package Admin
 */
class Menus_model extends Model
{
    use LogsActivity;
    use Purgeable;
    use Locationable;
    use HasMedia;

    const LOCATIONABLE_RELATION = 'locations';

    protected static $recordEvents = ['created', 'deleted'];

    /**
     * @var string The database table name
     */
    protected $table = 'menus';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'menu_id';

    protected $fillable = ['menu_name', 'menu_description', 'menu_price', 'menu_category_id',
        'stock_qty', 'minimum_qty', 'subtract_stock', 'mealtime_id', 'menu_status', 'menu_priority'];

    public $purgeable = [
        'special', 'menu_options', 'categories', 'locations',
    ];

    public $mediable = ['thumb'];

    public $relation = [
        'hasMany' => [
            'menu_options' => ['Admin\Models\Menu_item_options_model', 'delete' => TRUE],
        ],
        'hasOne' => [
            'special' => ['Admin\Models\Menus_specials_model', 'delete' => TRUE],
        ],
        'belongsTo' => [
            'mealtime' => ['Admin\Models\Mealtimes_model'],
        ],
        'belongsToMany' => [
            'categories' => ['Admin\Models\Categories_model', 'table' => 'menu_categories'],
        ],
        'morphToMany' => [
            'locations' => ['Admin\Models\Locations_model', 'name' => 'locationable'],
        ],
    ];

    public static $allowedSortingColumns = ['menu_priority asc', 'menu_priority desc'];

    //
    // Scopes
    //

    public function scopeWhereHasCategory($query, $categoryId)
    {
        $query->whereHas('categories', function ($q) use ($categoryId) {
            $q->where('categories.category_id', $categoryId);
        });
    }

    public function scopeListFrontEnd($query, $options = [])
    {
        extract(array_merge([
            'page' => 1,
            'pageLimit' => 20,
            'sort' => 'menu_priority asc',
            'group' => null,
            'location' => null,
            'category' => null,
        ], $options));

        if (strlen($location) AND is_numeric($location)) {
            $query->whereHasOrDoesntHaveLocation($location);
        }

        if (strlen($category)) {
            $query->whereHas('categories', function ($q) use ($category) {
                $q->whereSlug($category);
            });
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
                list($sortField, $sortDirection) = $parts;
                $query->orderBy($sortField, $sortDirection);
            }
        }

        if (strlen($group)) {
            $query->whereHas('categories', function ($q) use ($group) {
                $q->groupBy($group);
            });
        }

        return $query->paginate($pageLimit, $page);
    }

    //
    // Events
    //

    public function afterSave()
    {
        $this->restorePurgedValues();

        if (array_key_exists('special', $this->attributes))
            $this->addMenuSpecial((array)$this->attributes['special']);

        if (array_key_exists('categories', $this->attributes)) {
            $this->addMenuCategories((array)$this->attributes['categories']);
        }

        if (array_key_exists('locations', $this->attributes))
            $this->locations()->sync($this->attributes['locations']);

        if (array_key_exists('menu_options', $this->attributes))
            $this->addMenuOption((array)$this->attributes['menu_options']);
    }

    public function beforeDelete()
    {
        $this->addMenuCategories([]);
        $this->locations()->detach();
    }

    //
    // Helpers
    //

    public function getMessageForEvent($eventName)
    {
        return parse_values(['event' => $eventName], lang('admin::lang.menus.activity_event_log'));
    }

    public function hasOptions()
    {
        return count($this->menu_options);
    }

    /**
     * Subtract or add to menu stock quantity
     *
     * @param int $menu_id
     * @param int $quantity
     * @param string $action
     *
     * @return bool TRUE on success, or FALSE on failure
     */
    public function updateStock($quantity = 0, $action = 'subtract')
    {
        $update = FALSE;

        if ($this->subtract_stock AND !empty($quantity)) {
            $stockQty = $this->stock_qty + $quantity;

            if ($action == 'subtract') {
                $stockQty = $this->stock_qty - $quantity;
            }

            $update = $this->update(['stock_qty' => $stockQty]);

            Event::fire('admin.menu.stockUpdated', [$action, $this->stock_qty]);
        }

        return $update;
    }

    /**
     * Create new or update existing menu categories
     *
     * @param array $categoryIds if empty all existing records will be deleted
     *
     * @return bool
     */
    protected function addMenuCategories(array $categoryIds = [])
    {
        if (!$this->exists)
            return FALSE;

        $this->categories()->sync($categoryIds);
    }

    /**
     * Create new or update existing menu options
     *
     * @param array $menuOptions if empty all existing records will be deleted
     *
     * @return bool
     */
    public function addMenuOption(array $menuOptions = [])
    {
        $menuId = $this->getKey();
        if (!is_numeric($menuId))
            return FALSE;

        $idsToKeep = [];
        foreach ($menuOptions as $option) {
            $option['menu_id'] = $menuId;
            $menuOption = $this->menu_options()->firstOrNew([
                'menu_option_id' => array_get($option, 'menu_option_id'),
            ])->fill(array_except($option, ['menu_option_id']));

            $menuOption->saveOrFail();
            $idsToKeep[] = $menuOption->getKey();
        }

        $this->menu_options()->whereNotIn('menu_option_id', $idsToKeep)->delete();

        return count($idsToKeep);
    }

    /**
     * Create new or update existing menu special
     *
     * @param bool $id
     * @param array $menuSpecial
     *
     * @return bool
     */
    protected function addMenuSpecial(array $menuSpecial = [])
    {
        $menuId = $this->getKey();
        if (!is_numeric($menuId) OR !isset($menuSpecial['special_id']))
            return FALSE;

        $menuSpecial['menu_id'] = $menuId;
        $this->special()->updateOrCreate([
            'special_id' => $menuSpecial['special_id'],
        ], array_except($menuSpecial, 'special_id'));
    }
}