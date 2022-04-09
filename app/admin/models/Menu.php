<?php

namespace Admin\Models;

use Admin\Traits\Locationable;
use Admin\Traits\Stockable;
use Carbon\Carbon;
use Igniter\Flame\Database\Attach\HasMedia;
use Igniter\Flame\Database\Factories\HasFactory;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Database\Traits\Purgeable;

/**
 * Menu Model Class
 */
class Menu extends Model
{
    use Purgeable;
    use Locationable;
    use HasMedia;
    use Stockable;
    use HasFactory;

    const LOCATIONABLE_RELATION = 'locations';

    /**
     * @var string The database table name
     */
    protected $table = 'menus';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'menu_id';

    protected $guarded = [];

    protected $casts = [
        'menu_price' => 'float',
        'menu_category_id' => 'integer',
        'minimum_qty' => 'integer',
        'order_restriction' => 'array',
        'menu_status' => 'boolean',
        'menu_priority' => 'integer',
    ];

    protected $appends = ['menu_options'];

    public $relation = [
        'hasMany' => [
            'menu_option_values' => [\Admin\Models\MenuItemOptionValue::class, 'delete' => TRUE],
        ],
        'hasOne' => [
            'special' => [\Admin\Models\MenuSpecial::class, 'delete' => TRUE],
        ],
        'belongsToMany' => [
            'categories' => [\Admin\Models\Category::class, 'table' => 'menu_categories'],
            'mealtimes' => [\Admin\Models\Mealtime::class, 'table' => 'menu_mealtimes'],
        ],
        'morphToMany' => [
            'ingredients' => [\Admin\Models\Ingredient::class, 'name' => 'ingredientable'],
            'locations' => [\Admin\Models\Location::class, 'name' => 'locationable'],
        ],
    ];

    protected $purgeable = ['menu_option_values', 'special'];

    public $mediable = ['thumb'];

    public static $allowedSortingColumns = ['menu_priority asc', 'menu_priority desc'];

    public $timestamps = TRUE;

    public function getMenuOptionsAttribute($value)
    {
        if (isset($this->relations['menu_options']))
            return $this->relations['menu_options'];

        return $this->relations['menu_options'] = $this->getOptions();
    }

    //
    // Scopes
    //
    public function scopeWhereHasAllergen($query, $allergenId)
    {
        $query->whereHas('allergens', function ($q) use ($allergenId) {
            $q->where('allergen_id', $allergenId);
            $q->where('is_allergen', 1);
        });
    }

    public function scopeWhereHasCategory($query, $categoryId)
    {
        $query->whereHas('categories', function ($q) use ($categoryId) {
            $q->where('categories.category_id', $categoryId);
        });
    }

    public function scopeWhereHasIngredient($query, $ingredientId)
    {
        $query->whereHas('ingredients', function ($q) use ($ingredientId) {
            $q->where('ingredient_id', $ingredientId);
        });
    }

    public function scopeWhereHasMealtime($query, $mealtimeId)
    {
        $query->whereHas('mealtimes', function ($q) use ($mealtimeId) {
            $q->where('mealtimes.mealtime_id', $mealtimeId);
        });
    }

    public function scopeListFrontEnd($query, $options = [])
    {
        extract(array_merge([
            'page' => 1,
            'pageLimit' => 20,
            'enabled' => TRUE,
            'sort' => 'menu_priority asc',
            'group' => null,
            'location' => null,
            'category' => null,
            'search' => '',
            'orderType' => null,
        ], $options));

        $searchableFields = ['menu_name', 'menu_description'];

        if (strlen($location) && is_numeric($location)) {
            $query->whereHasOrDoesntHaveLocation($location);
            $query->with(['categories' => function ($q) use ($location) {
                $q->whereHasOrDoesntHaveLocation($location);
                $q->isEnabled();
            }]);
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
                [$sortField, $sortDirection] = $parts;
                $query->orderBy($sortField, $sortDirection);
            }
        }

        $search = trim($search);
        if (strlen($search)) {
            $query->search($search, $searchableFields);
        }

        if (strlen($group)) {
            $query->whereHas('categories', function ($q) use ($group) {
                $q->groupBy($group);
            });
        }

        if ($enabled) {
            $query->isEnabled();
        }

        if ($orderType) {
            $query->where(function ($query) use ($orderType) {
                $query->whereNull('order_restriction')
                    ->orWhere('order_restriction', 'like', '%"'.$orderType.'"%');
            });
        }

        $this->fireEvent('model.extendListFrontEndQuery', [$query]);

        return $query->paginate($pageLimit, $page);
    }

    public function scopeIsEnabled($query)
    {
        return $query->where('menu_status', 1);
    }

    //
    // Events
    //

    protected function afterSave()
    {
        $this->restorePurgedValues();

        if (array_key_exists('menu_option_values', $this->attributes))
            $this->addMenuOptionValues((array)$this->attributes['menu_option_values']);

        if (array_key_exists('special', $this->attributes))
            $this->addMenuSpecial((array)$this->attributes['special']);
    }

    protected function beforeDelete()
    {
        $this->categories()->detach();
        $this->mealtimes()->detach();
        $this->ingredients()->detach();
        $this->locations()->detach();
    }

    //
    // Helpers
    //

    public function hasOptions()
    {
        return count($this->menu_options);
    }

    public function getOptions()
    {
        $optionIds = $this->menu_option_values->pluck('option_id')->unique();

        $options = MenuOption::whereIn('option_id', $optionIds)->get();

        return $this->menu_option_values
            ->groupBy('option_id')
            ->map(function ($optionValues, $optionId) use ($options) {
                $option = $options->firstWhere('option_id', $optionId);

                $option->menu_option_values = $optionValues;

                return $option;
            })
            ->sortBy('priority');
    }

    /**
     * Subtract or add to menu stock quantity
     *
     * @param int $quantity
     * @param bool $subtract
     * @return bool TRUE on success, or FALSE on failure
     */
    public function updateStock($quantity = 0, $subtract = TRUE)
    {
        traceLog('Menu::updateStock() has been deprecated, use Stock::updateStock() instead.');
    }

    /**
     * Create new or update existing menu allergens
     *
     * @param array $allergenIds if empty all existing records will be deleted
     *
     * @return bool
     */
    public function addMenuAllergens(array $allergenIds = [])
    {
        $this->addMenuIngredients($allergenIds);
    }

    /**
     * Create new or update existing menu categories
     *
     * @param array $categoryIds if empty all existing records will be deleted
     *
     * @return bool
     */
    public function addMenuCategories(array $categoryIds = [])
    {
        if (!$this->exists)
            return FALSE;

        $this->categories()->sync($categoryIds);
    }

    /**
     * Create new or update existing menu ingredients
     *
     * @param array $ingredientIds if empty all existing records will be deleted
     *
     * @return bool
     */
    public function addMenuIngredients(array $ingredientIds = [])
    {
        if (!$this->exists)
            return FALSE;

        $this->ingredients()->sync($ingredientIds);
    }

    /**
     * Create new or update existing menu mealtimes
     *
     * @param array $mealtimeIds if empty all existing records will be deleted
     *
     * @return bool
     */
    public function addMenuMealtimes(array $mealtimeIds = [])
    {
        if (!$this->exists)
            return FALSE;

        $this->mealtimes()->sync($mealtimeIds);
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
        traceLog('Deprecated Menu::addMenuOption function. Use addMenuOptionValues() instead.');
    }

    /**
     * Create new or update existing menu option values
     *
     * @param array $menuOptionValues if empty all existing records will be deleted
     *
     * @return bool
     */
    public function addMenuOptionValues(array $menuOptionValues = [])
    {
        $menuId = $this->getKey();
        if (!is_numeric($menuId))
            return FALSE;

        $idsToKeep = [];
        foreach ($menuOptionValues as $optionId => $optionValues) {
            foreach ($optionValues as $optionValue) {
                $optionValue['menu_id'] = $menuId;
                $optionValue['option_id'] = $optionId;

                $menuOptionValue = $this->menu_option_values()->firstOrNew([
                    'menu_option_value_id' => array_get($optionValue, 'menu_option_value_id'),
                ])->fill(array_except($optionValue, ['menu_option_value_id']));

                $menuOptionValue->saveOrFail();
                $idsToKeep[] = $menuOptionValue->getKey();
            }

            $this->menu_option_values()
                ->where('option_id', $optionId)
                ->whereNotIn('menu_option_value_id', $idsToKeep)->delete();
        }

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
    public function addMenuSpecial(array $menuSpecial = [])
    {
        $menuId = $this->getKey();
        if (!is_numeric($menuId))
            return FALSE;

        $menuSpecial['menu_id'] = $menuId;
        $this->special()->updateOrCreate([
            'special_id' => $menuSpecial['special_id'] ?? null,
        ], array_except($menuSpecial, 'special_id'));
    }

    /**
     * Is menu item available on a given datetime
     *
     * @param string | \Carbon\Carbon $datetime
     *
     * @return bool
     */
    public function isAvailable($datetime = null)
    {
        if (is_null($datetime))
            $datetime = Carbon::now();

        if (!$datetime instanceof Carbon) {
            $datetime = Carbon::parse($datetime);
        }

        $isAvailable = TRUE;

        if (count($this->mealtimes) > 0) {
            $isAvailable = FALSE;
            foreach ($this->mealtimes as $mealtime) {
                if ($mealtime->mealtime_status) {
                    $isAvailable = $isAvailable || $mealtime->isAvailable($datetime);
                }
            }
        }

        if (count($this->ingredients) > 0) {
            foreach ($this->ingredients as $ingredient) {
                if (!$ingredient->status) {
                    $isAvailable = FALSE;
                }
            }
        }

        if (is_bool($eventResults = $this->fireSystemEvent('admin.menu.isAvailable', [$datetime, $isAvailable], TRUE)))
            $isAvailable = $eventResults;

        return $isAvailable;
    }
}
