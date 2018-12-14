<?php namespace Admin\Models;

use Igniter\Flame\Database\Traits\Purgeable;
use Igniter\Flame\Database\Traits\Validation;
use Model;

/**
 * MenuOptions Model Class
 *
 * @package Admin
 */
class Menu_item_options_model extends Model
{
    use Purgeable;
    use Validation;

    protected static $optionValuesCollection;

    /**
     * @var string The database table name
     */
    protected $table = 'menu_options';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'menu_option_id';

    protected $fillable = ['option_id', 'menu_id', 'required', 'priority'];

    public $relation = [
        'hasMany' => [
            'option_values' => ['Admin\Models\Menu_option_values_model', 'foreignKey' => 'option_id', 'otherKey' => 'option_id'],
            'menu_option_values' => [
                'Admin\Models\Menu_item_option_values_model',
                'foreignKey' => 'menu_option_id',
                'delete' => TRUE,
            ],
        ],
        'belongsTo' => [
            'menu' => ['Admin\Models\Menus_model'],
            'option' => ['Admin\Models\Menu_options_model'],
        ],
    ];

    public $appends = ['option_name', 'display_type'];

    public $rules = [
        ['menu_id', 'lang:admin::lang.menus.label_option', 'required|integer'],
        ['option_id', 'lang:admin::lang.menus.label_option_id', 'required|integer'],
        ['priority', 'lang:admin::lang.menus.label_option', 'integer'],
        ['required', 'lang:admin::lang.menus.label_option_required', 'integer'],
    ];

    public $purgeable = ['menu_option_values'];

    public $with = ['option'];

    public function getOptionNameAttribute()
    {
        return $this->option ? $this->option->option_name : null;
    }

    public function getDisplayTypeAttribute()
    {
        return $this->option ? $this->option->display_type : null;
    }

    public function getOptionValueIdOptions()
    {
        if (!empty(self::$optionValuesCollection[$this->option_id]))
            return self::$optionValuesCollection[$this->option_id];

        $result = $this->option_values()->dropdown('value');

        self::$optionValuesCollection[$this->option_id] = $result;

        return $result;
    }

    //
    // Events
    //

    public function afterSave()
    {
        $this->restorePurgedValues();

        if (array_key_exists('menu_option_values', $this->attributes))
            $this->addMenuOptionValues($this->attributes['menu_option_values']);
    }

    //
    // Helpers
    //

    public function isRequired()
    {
        return $this->required == 1;
    }

    /**
     * Create new or update existing menu option values
     *
     * @param int $menuOptionId
     * @param int $optionId
     * @param array $optionValues if empty all existing records will be deleted
     *
     * @return bool
     */
    public function addMenuOptionValues(array $optionValues = [])
    {
        $menuOptionId = $this->getKey();
        if (!is_numeric($menuOptionId))
            return FALSE;

        $idsToKeep = [];
        foreach ($optionValues as $value) {
            $menuOptionValue = $this->menu_option_values()->firstOrNew([
                'menu_option_value_id' => array_get($value, 'menu_option_value_id'),
                'menu_option_id' => $menuOptionId,
            ])->fill(array_except($value, ['menu_option_value_id', 'menu_option_id']));

            $menuOptionValue->saveOrFail();
            $idsToKeep[] = $menuOptionValue->getKey();
        }

        $this->menu_option_values()
             ->where('menu_option_id', $menuOptionId)
             ->whereNotIn('menu_option_value_id', $idsToKeep)
             ->delete();

        return count($idsToKeep);
    }
}