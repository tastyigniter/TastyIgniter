<?php namespace Admin\Models;

use Igniter\Flame\Database\Traits\Purgeable;
use Igniter\Flame\Database\Traits\Validation;
use Model;

/**
 * MenuOptions Model Class
 *
 * @package Admin
 */
class Menu_options_model extends Model
{
    use Purgeable;
    use Validation;

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
            'option_values' => ['Admin\Models\Menu_option_values_model', 'foreignKey' => 'option_id'],
        ],
    ];

    public $rules = [
        ['option_name', 'lang:admin::lang.menu_options.label_option_name', 'required|min:2|max:32'],
        ['display_type', 'lang:admin::lang.menu_options.label_display_type', 'required|alpha'],
    ];

    public $purgeable = ['option_values'];

    public static function getRecordEditorOptions()
    {
        return self::selectRaw('option_id, concat(option_name, " (", display_type, ")") AS display_name')
                   ->dropdown('display_name');
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
     * Create a new or update existing option values
     *
     * @param array $optionValues
     *
     * @return bool
     */
    public function addOptionValues($optionValues = [])
    {
        $optionId = $this->getKey();

        $idsToKeep = [];
        foreach ($optionValues as $value) {
            $optionValue = $this->option_values()->firstOrNew([
                'option_value_id' => array_get($value, 'option_value_id'),
                'option_id' => $optionId,
            ])->fill(array_except($value, ['option_value_id', 'option_id']));

            $optionValue->saveOrFail();
            $idsToKeep[] = $optionValue->getKey();
        }

        $this->option_values()->where('option_id', $optionId)
             ->whereNotIn('option_value_id', $idsToKeep)->delete();

        return count($idsToKeep);
    }
}