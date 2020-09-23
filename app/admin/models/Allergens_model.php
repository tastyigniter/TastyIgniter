<?php

namespace Admin\Models;

use DB;
use Igniter\Flame\Database\Attach\HasMedia;
use Model;

/**
 * Allergens Model Class
 */
class Allergens_model extends Model
{
    use HasMedia;

    /**
     * @var string The database table name
     */
    protected $table = 'allergens';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'allergen_id';

    protected $guarded = [];

    public $casts = [
        'status' => 'boolean',
    ];

    public $relation = [
        'morphedByMany' => [
            'menus' => ['Admin\Models\Menus_model', 'name' => 'allergenable'],
            'menu_option_values' => ['Admin\Models\Menu_option_values_model', 'name' => 'allergenable'],
        ],
    ];

    public $mediable = ['thumb'];

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
              ->from('menu_allergens')
              ->join('menus', 'menus.menu_id', '=', 'menu_allergens.menu_id')
              ->whereNotNull('menus.menu_status')
              ->where('menus.menu_status', '=', 1)
              ->whereRaw($prefix.'allergens.allergen_id = '.$prefix.'menu_allergens.allergen_id');
        });
    }

    public function scopeIsEnabled($query)
    {
        return $query->where('status', 1);
    }
}
