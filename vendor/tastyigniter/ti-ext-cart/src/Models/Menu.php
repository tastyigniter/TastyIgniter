<?php

declare(strict_types=1);

namespace Igniter\Cart\Models;

use Carbon\Carbon;
use Igniter\Cart\Contracts\Buyable;
use Igniter\Cart\Models\Concerns\Stockable;
use Igniter\Flame\Database\Attach\HasMedia;
use Igniter\Flame\Database\Attach\Media;
use Igniter\Flame\Database\Builder;
use Igniter\Flame\Database\Factories\HasFactory;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Database\Traits\Purgeable;
use Igniter\Local\Models\Concerns\Locationable;
use Igniter\Local\Models\Location;
use Igniter\System\Models\Concerns\Switchable;
use Illuminate\Database\Eloquent\Collection;
use Override;

/**
 * Menu Model Class
 *
 * @property int $menu_id
 * @property string $menu_name
 * @property string $menu_description
 * @property float $menu_price
 * @property int $minimum_qty
 * @property bool $menu_status
 * @property int $menu_priority
 * @property array|null $order_restriction
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $menu_price_from
 * @property-read mixed $stock_qty
 * @property-read Collection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read int|null $menu_options_count
 * @property array|Collection<int, Ingredient> $ingredients
 * @property array|Collection<int, MenuItemOption> $menu_options
 * @property array|null|MenuSpecial $special
 * @property array|Collection<int, Location> $locations
 * @method static Builder<static>|Category categories()
 * @method static Builder<static>|Media media()
 * @method static Builder<static>|Ingredient ingredients()
 * @method static Builder<static>|MenuItemOption menu_options()
 * @method static Builder<static>|MenuSpecial special()
 * @method static Builder<static>|Location locations()
 * @method static null|Menu find(int|string $id)
 * @method static Builder<static>|Menu listFrontEnd(array $options = [])
 * @mixin Model
 */
class Menu extends Model implements Buyable
{
    use HasFactory;
    use HasMedia;
    use Locationable;
    use Purgeable;
    use Stockable;
    use Switchable;

    public const string LOCATIONABLE_RELATION = 'locations';

    public const string SWITCHABLE_COLUMN = 'menu_status';

    /**
     * @var string The database table name
     */
    protected $table = 'menus';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'menu_id';

    public $timestamps = true;

    protected $guarded = [];

    protected $casts = [
        'menu_price' => 'float',
        'menu_category_id' => 'integer',
        'minimum_qty' => 'integer',
        'order_restriction' => 'array',
        'menu_priority' => 'integer',
    ];

    public $relation = [
        'hasMany' => [
            'menu_options' => [MenuItemOption::class],
        ],
        'hasOne' => [
            'special' => [MenuSpecial::class],
        ],
        'belongsToMany' => [
            'categories' => [Category::class, 'table' => 'menu_categories'],
            'mealtimes' => [Mealtime::class, 'table' => 'menu_mealtimes'],
        ],
        'morphToMany' => [
            'allergens' => [Ingredient::class, 'name' => 'ingredientable', 'conditions' => 'is_allergen = 1'],
            'ingredients' => [Ingredient::class, 'name' => 'ingredientable'],
            'locations' => [Location::class, 'name' => 'locationable'],
        ],
    ];

    protected $purgeable = ['menu_options', 'special'];

    public $mediable = ['thumb'];

    protected array $queryModifierFilters = [
        'enabled' => ['applySwitchable', 'default' => true],
        'group' => 'applyCategoryGroup',
        'location' => 'applyLocation',
        'category' => 'whereHasCategory',
        'orderType' => 'applyOrderType',
    ];

    protected array $queryModifierSorts = [
        'menu_priority asc', 'menu_priority desc',
        'menu_name asc', 'menu_name desc',
        'menu_id asc', 'menu_id desc',
        'menu_price asc', 'menu_price desc',
    ];

    protected array $queryModifierSearchableFields = ['menu_name', 'menu_description', 'menu_price'];

    public function getMenuPriceFromAttribute()
    {
        if ($this->menu_options->isEmpty()) {
            return $this->menu_price;
        }

        return $this->menu_options->mapWithKeys(
            fn($option) => $option->menu_option_values->keyBy('menu_option_value_id')->all(),
        )->min('price') ?: 0;
    }

    public function getMinimumQtyAttribute($value): int
    {
        return (int)($value ?: 1);
    }

    public static function getDropdownOptions()
    {
        return self::whereIsEnabled()->pluck('menu_name', 'menu_id');
    }

    public static function onboardingIsComplete(): bool
    {
        return self::whereIsEnabled()->count() > 0;
    }

    //
    // Helpers
    //

    public function hasOptions(): bool
    {
        return (bool)$this->menu_options_count;
    }

    /**
     * Create new or update existing menu allergens
     *
     * @param array $allergenIds if empty all existing records will be deleted
     */
    public function addMenuAllergens(array $allergenIds = []): void
    {
        $this->addMenuIngredients($allergenIds);
    }

    /**
     * Create new or update existing menu categories
     *
     * @param array $categoryIds if empty all existing records will be deleted
     */
    public function addMenuCategories(array $categoryIds = []): void
    {
        $this->categories()->sync($categoryIds);
    }

    /**
     * Create new or update existing menu ingredients
     *
     * @param array $ingredientIds if empty all existing records will be deleted
     */
    public function addMenuIngredients(array $ingredientIds = []): void
    {
        $this->ingredients()->sync($ingredientIds);
    }

    /**
     * Create new or update existing menu mealtimes
     *
     * @param array $mealtimeIds if empty all existing records will be deleted
     */
    public function addMenuMealtimes(array $mealtimeIds = []): void
    {
        $this->mealtimes()->sync($mealtimeIds);
    }

    /**
     * Create new or update existing menu options
     *
     * @param array $menuOptions if empty all existing records will be deleted
     */
    public function addMenuOption(array $menuOptions = []): int
    {
        $menuId = $this->getKey();
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
     */
    public function addMenuSpecial(array $menuSpecial = []): void
    {
        $menuId = $this->getKey();
        $menuSpecial['menu_id'] = $menuId;
        $this->special()->updateOrCreate([
            'special_id' => $menuSpecial['special_id'] ?? null,
        ], array_except($menuSpecial, 'special_id'));
    }

    /**
     * Is menu item available on a given datetime
     *
     * @param string|Carbon $datetime
     */
    public function isAvailable($datetime = null): bool
    {
        if (is_null($datetime)) {
            $datetime = Carbon::now();
        }

        if (!$datetime instanceof Carbon) {
            $datetime = Carbon::parse($datetime);
        }

        if ($this->mealtimes->contains(fn($mealtime): bool => $mealtime->isEnabled() && !$mealtime->isAvailable($datetime))) {
            return false;
        }

        if ($this->ingredients->contains(fn($ingredient): bool => !$ingredient->isEnabled())) {
            return false;
        }

        return $this->fireSystemEvent('admin.menu.isAvailable', [$datetime, true]) !== false;
    }

    public static function findBy($menuId, $location = null)
    {
        return self::query()
            ->with([
                'menu_options.menu_option_values.option_value',
            ])
            ->whereIsEnabled()->whereKey($menuId)->first();
    }

    #[Override]
    public function getMorphClass(): string
    {
        return 'menus';
    }

    public function isSpecial()
    {
        return $this->special?->active() ?? false;
    }

    public function checkMinQuantity($quantity = 0): bool
    {
        return $quantity >= $this->minimum_qty;
    }

    public function hasOrderTypeRestriction($orderType)
    {
        if (empty($this->order_restriction)) {
            return false;
        }

        return !in_array($orderType, $this->order_restriction);
    }

    /**
     * Get the identifier of the Buyable item.
     */
    #[Override]
    public function getBuyableIdentifier(): int
    {
        return $this->getKey();
    }

    /**
     * Get the description or title of the Buyable item.
     *
     * @return string
     */
    #[Override]
    public function getBuyableName()
    {
        return $this->menu_name;
    }

    /**
     * Get the price of the Buyable item.
     *
     * @return float
     */
    #[Override]
    public function getBuyablePrice()
    {
        return $this->isSpecial()
            ? $this->special->getMenuPrice($this->menu_price)
            : $this->menu_price;
    }
}
