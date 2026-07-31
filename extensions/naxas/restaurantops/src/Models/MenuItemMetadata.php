<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Models;

use Igniter\Flame\Database\Model;

final class MenuItemMetadata extends Model
{
    protected $table = 'naxas_restaurant_ops_menu_item_metadata';

    protected $guarded = [];

    protected $casts = [
        'menu_id' => 'integer', 'preparation_minutes' => 'integer', 'kitchen_station_id' => 'integer',
        'storefront_visible' => 'boolean', 'pos_visible' => 'boolean', 'waiter_visible' => 'boolean',
        'show_on_kitchen' => 'boolean', 'version' => 'integer',
    ];
}
