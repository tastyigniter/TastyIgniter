<?php

declare(strict_types=1);

namespace Igniter\Cart\Models;

use Igniter\Flame\Database\Model;

/**
 * OrderMenuOptionValue Model
 *
 * @property int $order_option_id
 * @property int $order_id
 * @property string $order_option_name
 * @property float|null $order_option_price
 * @property int $order_menu_id
 * @property int $menu_option_id
 * @property int $menu_option_value_id
 * @property int|null $quantity
 * @property int $free_qty
 * @property-read mixed $order_option_category
 * @mixin Model
 */
class OrderMenuOptionValue extends Model
{
    protected $table = 'order_menu_options';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'order_option_id';

    public $guarded = [];

    public $appends = ['order_option_category'];

    protected $casts = [
        'order_menu_id' => 'integer',
        'menu_option_id' => 'integer',
        'menu_option_value_id' => 'integer',
        'quantity' => 'integer',
        'order_option_price' => 'float',
        'free_qty' => 'integer',
    ];

    public $relation = [
        'belongsTo' => [
            'order' => Order::class,
            'order_menu' => OrderMenu::class,
            'menu_option' => MenuItemOption::class,
            'menu_option_value' => MenuItemOptionValue::class,
        ],
    ];

    public function getOrderOptionCategoryAttribute()
    {
        return $this->menu_option->option_name;
    }
}
