<?php

namespace Admin\Models;

use Igniter\Flame\Database\Model;

/**
 * Menu categories Model Class
 */
class Menu_categories_model extends Model
{
    /**
     * @var string The database table name
     */
    protected $table = 'menu_categories';

    /**
     * @var string The database table primary key
     */
    public $incrementing = false;

    protected $casts = [
        'menu_id' => 'integer',
        'category_id' => 'integer',
    ];

    public $relation = [
        'belongsTo' => [
            'menu' => ['Admin\Models\Menus_model'],
            'category' => ['Admin\Models\Categories_model'],
        ],
    ];
}
