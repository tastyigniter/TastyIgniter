<?php

namespace Admin\Models;

use Igniter\Flame\Database\Attach\HasMedia;
use Igniter\Flame\Database\Factories\HasFactory;
use Igniter\Flame\Database\Model;
use Illuminate\Support\Facades\DB;

/**
 * Ingredients Model Class
 */
class Ingredient extends Model
{
    use HasMedia;
    use HasFactory;

    /**
     * @var string The database table name
     */
    protected $table = 'ingredients';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'ingredient_id';

    protected $guarded = [];

    protected $casts = [
        'is_allergen' => 'boolean',
        'status' => 'boolean',
    ];

    public $relation = [
        'morphedByMany' => [
            'menus' => [\Admin\Models\Menu::class, 'name' => 'ingredientable'],
            'menu_option_values' => [\Admin\Models\MenuOptionValue::class, 'name' => 'ingredientable'],
        ],
    ];

    public $mediable = ['thumb'];

    public $timestamps = TRUE;

    //
    // Accessors & Mutators
    //

    public function getDescriptionAttribute($value)
    {
        return strip_tags(html_entity_decode($value, ENT_QUOTES, 'UTF-8'));
    }

    public function getCountMenusAttribute($value)
    {
        return $this->menus()->count();
    }

    //
    // Scopes
    //

    public function scopeWhereHasMenus($query)
    {
        return $query->whereExists(function ($q) {
            $prefix = DB::getTablePrefix();
            $q->select(DB::raw(1))
                ->from('ingredientables')
                ->join('menus', 'menus.menu_id', '=', 'ingredientables.ingredientable_id')
                ->where('ingredientables.allergenable_type', 'menus')
                ->whereNotNull('menus.menu_status')
                ->where('menus.menu_status', '=', 1);
        });
    }

    public function scopeIsAllergen($query)
    {
        return $query->where('is_allergen', 1);
    }

    public function scopeIsEnabled($query)
    {
        return $query->where('status', 1);
    }
}
