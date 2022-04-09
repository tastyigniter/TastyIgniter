<?php

namespace Admin\Models;

use Igniter\Flame\Database\Model;

/**
 * MenuCategory Model Class
 */
class MenuCategory extends Model
{
    /**
     * @var string The database table name
     */
    protected $table = 'menu_categories';

    /**
     * @var string The database table primary key
     */
    public $incrementing = FALSE;

    protected $casts = [
        'menu_id' => 'integer',
        'category_id' => 'integer',
    ];

    public $relation = [
        'belongsTo' => [
            'menu' => [\Admin\Models\Menu::class],
            'category' => [\Admin\Models\Category::class],
        ],
    ];
}
