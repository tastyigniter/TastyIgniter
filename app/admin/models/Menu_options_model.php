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
    public static function getOptionValues($option_id = null)
    {
        $query = self::orderBy('priority')->from('option_values');

        if ($option_id !== FALSE) {
            $query->where('option_id', $option_id);
        }

        return $query->get();
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
                        'option_values' => self::getOptionValues($row['option_id']),
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

        $this->option_values()->where('option_id', $optionId)
             ->whereNotIn('option_value_id', $idsToKeep)->delete();

        return TRUE;
    }
}