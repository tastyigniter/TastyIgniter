<?php

declare(strict_types=1);

namespace Igniter\Cart\Models;

use Igniter\Cart\Models\Concerns\Stockable;
use Igniter\Flame\Database\Factories\HasFactory;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Database\Traits\Sortable;
use Igniter\Flame\Database\Traits\Validation;

/**
 * MenuOptionValue Model Class
 *
 * @property int $option_value_id
 * @property int $option_id
 * @property string $name
 * @property float|null $price
 * @property int $priority
 * @property int|null $menu_option_value_id
 * @property int|null $menu_option_id
 * @property float|null $override_price
 * @property bool|null $is_default
 * @property bool|null $is_enabled
 * @property int $free_quantity
 * @property string|null $display_type
 * @property-read mixed $stock_qty
 * @mixin Model
 */
class MenuOptionValue extends Model
{
    use HasFactory;
    use Sortable;
    use Stockable;
    use Validation;

    protected static $ingredientOptionsCache;

    /**
     * @var string The database table name
     */
    protected $table = 'menu_option_values';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'option_value_id';

    protected $fillable = ['option_id', 'name', 'price', 'ingredients', 'priority'];

    protected $casts = [
        'option_value_id' => 'integer',
        'option_id' => 'integer',
        'price' => 'float',
        'priority' => 'integer',
    ];

    public $relation = [
        'belongsTo' => [
            'option' => [MenuOption::class],
        ],
        'morphToMany' => [
            'ingredients' => [Ingredient::class, 'name' => 'ingredientable'],
        ],
    ];

    public $sortable = [
        'sortOrderColumn' => 'priority',
        'sortWhenCreating' => true,
    ];

    public $rules = [
        ['option_id', 'igniter.cart::default.menu_options.label_option_id', 'required|integer'],
        ['name', 'igniter.cart::default.menu_options.label_option_name', 'required|string|min:2|max:255'],
        ['price', 'igniter.cart::default.menu_options.label_option_price', 'required|numeric|min:0'],
        ['ingredients.*', 'igniter.cart::default.menus.label_ingredients', 'integer'],
    ];

    public static function getDropDownOptions()
    {
        return static::dropdown('name');
    }

    public function getAllergensOptions()
    {
        return $this->getIngredientsOptions();
    }

    public function getIngredientsOptions()
    {
        if (self::$ingredientOptionsCache) {
            return self::$ingredientOptionsCache;
        }

        return self::$ingredientOptionsCache = Ingredient::dropdown('name')->all();
    }

    public function getStockableName()
    {
        return $this->name;
    }

    public function getStockableLocations()
    {
        return $this->option?->locations;
    }

    //
    // Events
    //
    /**
     * Create new or update existing menu allergens
     *
     * @param array $allergenIds if empty all existing records will be deleted
     */
    public function addMenuAllergens(array $allergenIds = []): void
    {
        $this->ingredients()->sync($allergenIds);
    }
}
