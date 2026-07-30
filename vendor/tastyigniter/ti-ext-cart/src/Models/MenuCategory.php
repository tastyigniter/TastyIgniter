<?php

declare(strict_types=1);

namespace Igniter\Cart\Models;

use Igniter\Flame\Database\Model;

/**
 * MenuCategory Model Class
 *
 * @property int $menu_id
 * @property int $category_id
 * @mixin Model
 */
class MenuCategory extends Model
{
    /**
     * @var string The database table name
     */
    protected $table = 'menu_categories';

    public $incrementing = false;

    protected $casts = [
        'menu_id' => 'integer',
        'category_id' => 'integer',
    ];

    public $relation = [
        'belongsTo' => [
            'menu' => [Menu::class],
            'category' => [Category::class],
        ],
    ];
}
