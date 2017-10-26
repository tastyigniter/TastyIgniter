<?php namespace Admin\Models;

use Igniter\Flame\Database\Traits\Purgeable;
use Model;

/**
 * MenuOptions Model Class
 *
 * @package Admin
 */
class Menu_options_model extends Model
{
    use Purgeable;

    /**
     * @var string The database table name
     */
    protected $table = 'options';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'option_id';

    protected $guarded = [];

    protected $fillable = ['option_id', 'option_name', 'display_type'];

    public $relation = [
        'hasMany' => [
            'menu_options'  => ['Admin\Models\Menu_item_options_model', 'key' => 'option_id'],
            'option_values' => ['Admin\Models\Menu_option_values_model', 'foreignKey' => 'option_id'],
        ],
    ];

    public $purgeable = ['option_values'];

    public static function listOptions()
    {
        return self::selectRaw('option_id, concat(option_name, " (", display_type, ")") AS display_name')
                   ->pluck('display_name', 'option_id')->all();
    }

    //
    // Events
    //

    public function afterSave()
    {
        $this->restorePurgedValues();

        if (array_key_exists('option_values', $this->attributes))
            $this->addOptionValues($this->attributes['option_values']);
    }

    /**
     * Filter database records
     *
     * @param array $filter an associative array of field/value pairs
     *
     * @return $this
     */
    public function scopeFilter($query, $filter = [])
    {
        if (isset($filter['filter_search']) AND is_string($filter['filter_search'])) {
            $query->search($filter['filter_search'], ['option_name']);
        }

        if (!empty($filter['filter_display_type'])) {
            $query->where('display_type', $filter['filter_display_type']);
        }

        return $query;
    }

    //
    // Helpers
    //

    /**
     * Return all option values by option_id
     *
     * @param int $option_id
     *
     * @return array
     */
    public function getOptionValues($option_id = null)
    {
        $query = $this->orderBy('priority')->from('option_values');

        if ($option_id !== FALSE) {
            $query->where('option_id', $option_id);
        }

        return $query->get();
    }

    /**
     * Find a single option by option_id
     *
     * @param $option_id
     *
     * @return mixed
     */
    public function getOption($option_id)
    {
        return $this->findOrNew($option_id)->toArray();
    }

    /**
     * Return all menu options by menu_id
     *
     * @param int $menu_id
     *
     * @return array
     */
    public function getMenuOptions($menu_id = null)
    {
        $results = [];

        $tablePrefixed = $this->getTablePrefix('menu_options');

        $query = $this->selectRaw("*, {$tablePrefixed}.menu_id, {$tablePrefixed}.option_id")
                      ->leftJoin('options', 'options.option_id', '=', 'menu_options.option_id');

        if (is_numeric($menu_id)) {
            $query->where('menu_id', $menu_id);
        }

        if ($result = $query->orderBy('options.priority')->from('menu_options')->get()) {
            foreach ($result as $row) {
                $results[] = array_merge($row, [
                    'option_values' => $this->getMenuOptionValues($row['menu_option_id'], $row['option_id']),
                ]);
            }
        }

        return $results;
    }

    /**
     * Return all menu option values by menu_option_id and option_id
     *
     * @param int $menu_option_id
     * @param int $option_id
     *
     * @return array
     */
    public function getMenuOptionValues($menu_option_id = null, $option_id = null)
    {
        $result = [];

        if (is_numeric($menu_option_id) AND is_numeric($option_id)) {
            $valuePrefixed = $this->getTablePrefix('menu_option_values');
            $optionPrefixed = $this->getTablePrefix('option_values');

            $result = $this->selectRaw("*, {$valuePrefixed}.option_id, {$optionPrefixed}.option_value_id")
                           ->leftJoin('option_values', 'option_values.option_value_id', '=', 'menu_option_values.option_value_id')
                           ->where('menu_option_values.menu_option_id', $menu_option_id)
                           ->where('menu_option_values.option_id', $option_id)
                           ->orderBy('option_values.priority')->from('menu_option_values')->get();
        }

        return $result;
    }

    /**
     * List all options matching the filter,
     * to fill select auto-complete options
     *
     * @param array $filter
     *
     * @return array
     */
    public static function getAutoComplete($filter = [])
    {
        if (is_array($filter) AND !empty($filter)) {
            $query = self::query();

            if (!empty($filter['option_name'])) {
                $query->like('option_name', $filter['option_name']);
            }

            $result = [];
            if ($rows = $query->get()) {
                foreach ($rows as $row) {
                    $result[] = array_merge($row, [
                        'option_values' => $this->getOptionValues($row['option_id']),
                    ]);
                }
            }

            return $result;
        }
    }

    /**
     * Create a new or update existing option values
     *
     * @param bool $option_id
     * @param array $option_values
     *
     * @return bool
     */
    public function addOptionValues($optionValues = [])
    {
        $optionId = $this->getKey();

        $idsToKeep = [];
        foreach ($optionValues as $value) {
            $optionValue = $this->option_values()->firstOrNew([
                'option_value_id' => $value['option_value_id'],
                'option_id'       => $optionId,
            ])->fill(array_merge($value, [
                'option_id' => $optionId,
            ]));

            $optionValue->save();
            $idsToKeep[] = $optionValue->getKey();
        }

        $this->newQuery()->where('option_id', $optionId)
             ->whereNotIn('option_value_id', $idsToKeep)->delete();

        return TRUE;
    }

    /**
     * Create a new or update existing options
     *
     * @param int $option_id
     * @param array $save
     *
     * @return bool|int The $option_id of the affected row, or FALSE on failure
     */
    public function saveOption($option_id, $save = [])
    {
        if (empty($save)) return FALSE;

        $menuOptionModel = $this->findOrNew($option_id);

        if ($saved = $menuOptionModel->fill($save)->save()) {
            $save['option_values'] = isset($save['option_values']) ? $save['option_values'] : [];
            $this->addOptionValues($menuOptionModel->getKey(), $save['option_values']);
        }

        return $saved ? $menuOptionModel->getKey() : $saved;
    }

    /**
     * Delete a single or multiple option by option_id
     *
     * @param string|array $option_id
     *
     * @return int The number of deleted rows
     */
    public function deleteOption($option_id)
    {
        if (is_numeric($option_id)) $option_id = [$option_id];

        if (!empty($option_id) AND ctype_digit(implode('', $option_id))) {

            return $this->newQuery()
                        ->whereIn('option_id', $option_id)->delete();
        }
    }
}