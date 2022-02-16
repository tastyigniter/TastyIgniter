<?php

namespace Admin\Models;

use Igniter\Flame\Database\Model;

/**
 * Menu categories Model Class
 */
class Menu_Category extends Model
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
            'menu' => ['Admin\Models\Menu'],
            'category' => ['Admin\Models\Category'],
        ],
    ];
}
