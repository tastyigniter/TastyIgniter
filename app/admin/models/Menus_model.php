<?php namespace Admin\Models;

use Igniter\Flame\ActivityLog\Traits\LogsActivity;
use Igniter\Flame\Database\Traits\Purgeable;
use Main\Models\Image_tool_model;
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

    protected static $recordEvents = ['created', 'deleted'];

    /**
     * @var string The database table name
     */
    protected $table = 'menus';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'menu_id';

    protected $fillable = ['menu_name', 'menu_description', 'menu_price', 'menu_photo', 'menu_category_id',
        'stock_qty', 'minimum_qty', 'subtract_stock', 'mealtime_id', 'menu_status', 'menu_priority'];

    public $purgeable = [
        'special', 'menu_options', 'categories',
    ];

    public $relation = [
        'hasMany'       => [
            'menu_options'       => ['Admin\Models\Menu_item_options_model', 'delete' => TRUE],
            'menu_option_values' => ['Admin\Models\Menu_item_option_values_model'],
        ],
        'hasOne'        => [
            'special' => ['Admin\Models\Menus_specials_model', 'delete' => TRUE],
        ],
        'belongsTo'     => [
            'mealtime' => ['Admin\Models\Mealtimes_model'],
        ],
        'belongsToMany' => [
            'categories' => ['Admin\Models\Categories_model', 'table' => 'menu_categories', 'delete' => TRUE],
        ],
    ];

    public static $allowedSortingColumns = ['menu_priority asc', 'menu_priority desc'];

    //
    // Scopes
    //

    public function scopeListFrontEnd($query, $options = [])
    {
        extract(array_merge([
            'page'      => 1,
            'pageLimit' => 20,
            'sort'      => 'menu_priority asc',
            'group'     => null,
            'category'  => null,
        ], $options));

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

        if (array_key_exists('menu_options', $this->attributes))
            $this->addMenuOption((array)$this->attributes['menu_options']);
    }

    public function beforeDelete()
    {
        $this->addMenuCategories([]);
    }

    //
    // Helpers
    //

    public function getMessageForEvent($eventName)
    {
        return parse_values(['event' => $eventName], lang('admin::menus.activity_event_log'));
    }

    public function getThumb($options = [])
    {
        return Image_tool_model::resize($this->menu_photo, array_merge([
            'width'  => is_numeric(setting('menu_images_w')) ? setting('menu_images_w') : '50',
            'height' => is_numeric(setting('menu_images_h')) ? setting('menu_images_h') : '50',
        ], $options));
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

        if ($this->subtract_stock == '1' AND !empty($quantity)) {
            $stock_qty = $this->stock_qty + $quantity;

            if ($action == 'subtract') {
                $stock_qty = $this->stock_qty - $quantity;
            }

            $update = $this->update(['stock_qty' => $stock_qty]);
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
            if (!isset($option['option_id'])) continue;

            $option['menu_id'] = $menuId;
            $menuOption = $this->menu_options()->updateOrCreate([
                'menu_option_id' => $option['menu_option_id'],
                'option_id'      => $option['option_id'],
            ], array_except($option, ['menu_option_id', 'option_values']));

            $menuOptionValues = $option['option_values'] ?? null;
            if ($menuOption AND is_array($menuOptionValues)) {
                $this->addMenuOptionValues($menuOption->getKey(), $menuOption->option_id, $menuOptionValues);
            }

            $idsToKeep[] = $menuOption->getKey();
        }

        $this->menu_options()->whereNotIn('menu_option_id', $idsToKeep)->delete();
        $this->menu_option_values()->whereNotIn('menu_option_id', $idsToKeep)->delete();
    }

    /**
     * Create new or update existing menu option values
     *
     * @param int $menuOptionId
     * @param int $optionId
     * @param array $optionValues if empty all existing records will be deleted
     *
     * @return bool
     */
    public function addMenuOptionValues($menuOptionId, $optionId, array $optionValues = [])
    {
        $menuId = $this->getKey();
        if (!is_numeric($menuId))
            return FALSE;

        $idsToKeep = [];
        foreach ($optionValues as $value) {
            $menuOptionValueId = $value['menu_option_value_id'];
            if (in_array($menuOptionValueId, $idsToKeep))
                $menuOptionValueId = null;

            $menuOptionValue = $this->menu_option_values()->updateOrCreate([
                'menu_option_value_id' => $menuOptionValueId,
                'menu_option_id'       => $menuOptionId,
            ], array_merge(array_except($value, 'menu_option_value_id'), [
                'menu_id'        => $menuId,
                'option_id'      => $optionId,
                'menu_option_id' => $menuOptionId,
            ]));

            $idsToKeep[] = $menuOptionValue->getKey();
        }

        $this->menu_option_values()
             ->where('menu_option_id', $menuOptionId)
             ->whereNotIn('menu_option_value_id', $idsToKeep)
             ->delete();
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