<?php namespace Admin\Models;

use Igniter\Flame\Database\Traits\Sortable;
use Model;

/**
 * MenuOptions Model Class
 *
 * @package Admin
 */
class Menu_item_options_model extends Model
{
    use Sortable;

    const SORT_ORDER = 'priority';

    protected static $valuesCollection;

    /**
     * @var string The database table name
     */
    protected $table = 'menu_options';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'menu_option_id';

    protected $fillable = ['option_id', 'menu_id', 'required', 'priority', 'default_value_id', 'option_values'];

    public $relation = [
        'hasMany'   => [
            'values'             => ['Admin\Models\Menu_option_values_model', 'foreignKey' => 'option_id', 'otherKey' => 'option_id'],
            'menu_option_values' => ['Admin\Models\Menu_item_option_values_model', 'foreignKey' => 'menu_option_id', 'delete' => TRUE],
        ],
        'belongsTo' => [
            'menu'   => ['Admin\Models\Menus_model'],
            'option' => ['Admin\Models\Menu_options_model'],
        ],
    ];

    public $casts = [
        'option_values' => 'serialize',
    ];

    //
    // Helpers
    //

    public function listOptionValues($form, $field)
    {
        if (!self::$valuesCollection)
            self::$valuesCollection = Menu_option_values_model::select('option_value_id', 'option_id', 'value')
                                                              ->where('option_id', $this->option_id)->get();

        return self::$valuesCollection->pluck('value', 'option_value_id');
    }

    /**
     * Create a new or update existing menu options
     *
     * @param bool $menu_id
     * @param array $menu_options
     *
     * @return bool
     */
    public function addMenuOption($menu_id, $menu_options = [])
    {
        if (!is_numeric($menu_id) OR !count($menu_options))
            return FALSE;

        $idsToKeep = [];
        foreach ($menu_options as $option) {
            if (!isset($option['option_id'])) continue;

            $menuOption = $this->firstOrNew([
                'menu_option_id' => $option['menu_option_id'],
                'menu_id'        => $menu_id,
                'option_id'      => $option['option_id'],
            ])->fill(array_merge($option, [
                'option_values' => isset($option['menu_option_values']) ? serialize($option['menu_option_values']) : [],
            ]));

            if ($menuOption->save() AND isset($option['menu_option_values'])) {
                Menu_item_option_values_model::addMenuOptionValues(
                    $menuOption->getKey(), $menu_id, $option['option_id'], $option['menu_option_values']
                );
            }

            $idsToKeep[] = $menuOption->getKey();
        }

        $this->where('menu_id', $menu_id)->whereNotIn('menu_option_id', $idsToKeep)->delete();

        return TRUE;
    }

    /**
     * Delete a single or multiple menu option by menu_id
     *
     * @param string|array $menu_id
     *
     * @return int The number of deleted rows
     */
    public function deleteMenuOption($menu_id)
    {
        if (is_numeric($menu_id)) $menu_id = [$menu_id];

        if (!empty($menu_id) AND ctype_digit(implode('', $menu_id))) {
            return $this->newQuery->whereIn('menu_id', $menu_id)->delete();
        }
    }
}