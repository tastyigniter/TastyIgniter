<?php

declare(strict_types=1);

namespace Igniter\Cart\Models;

use Igniter\Flame\Database\Factories\HasFactory;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Database\Traits\Validation;
use Illuminate\Support\Carbon;

/**
 * MenuItemOptionValue Model Class
 *
 * @property int $menu_option_value_id
 * @property int $menu_option_id
 * @property int $option_value_id
 * @property float|null $override_price
 * @property int $priority
 * @property bool|null $is_default
 * @property int $free_quantity
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read null|MenuOptionValue $option_value
 * @property-read null|MenuItemOption $menu_option
 * @property-read mixed $name
 * @property-read mixed $price
 * @mixin Model
 */
class MenuItemOptionValue extends Model
{
    use HasFactory;
    use Validation;

    protected static $optionValuesCollection;

    /**
     * @var string The database table name
     */
    protected $table = 'menu_item_option_values';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'menu_option_value_id';

    protected $fillable = ['menu_option_id', 'option_value_id', 'override_price', 'priority', 'is_default', 'free_quantity'];

    public $appends = ['name', 'price'];

    protected $casts = [
        'menu_option_value_id' => 'integer',
        'menu_option_id' => 'integer',
        'option_value_id' => 'integer',
        'override_price' => 'float',
        'priority' => 'integer',
        'is_default' => 'boolean',
        'free_quantity' => 'integer',
    ];

    public $relation = [
        'belongsTo' => [
            'menu' => [Menu::class],
            'option_value' => [MenuOptionValue::class],
            'menu_option' => [MenuItemOption::class],
        ],
    ];

    protected $with = ['option_value'];

    public $rules = [
        ['menu_option_id', 'igniter.cart::default.menu_options.label_option_value_id', 'required|integer'],
        ['option_value_id', 'igniter.cart::default.menu_options.label_option_value', 'required|integer'],
        ['override_price', 'igniter.cart::default.menu_options.label_option_price', 'nullable|numeric|min:0'],
        ['free_quantity', 'igniter.cart::default.menu_options.label_value_free_quantity', 'integer|min:0'],
    ];

    public $timestamps = true;

    public function getNameAttribute()
    {
        return $this->option_value->name ?? null;
    }

    public function getPriceAttribute()
    {
        if ($this->override_price) {
            return $this->override_price;
        }

        return $this->option_value->price ?? null;
    }

    public function isDefault(): bool
    {
        return $this->is_default == 1;
    }

    /**
     * Free quantities are not applicable to single-select (radio/select)
     * option values, and limited to 1 for checkbox option values, regardless
     * of what is stored.
     */
    public function getFreeQuantityAttribute($value): int
    {
        $displayType = $this->menu_option?->option?->display_type;

        return match (true) {
            in_array($displayType, ['select', 'radio']) => 0,
            $displayType === 'checkbox' => min((int) $value, 1),
            default => (int) $value,
        };
    }
}
