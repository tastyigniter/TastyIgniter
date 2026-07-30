<?php

declare(strict_types=1);

namespace Igniter\Cart\Models;

use Igniter\Flame\Database\Factories\HasFactory;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Database\Traits\Purgeable;
use Igniter\Local\Facades\Location;
use Igniter\Local\Models\Concerns\Locationable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

/**
 * MenuOption Model Class
 *
 * @property int $option_id
 * @property string $option_name
 * @property string $display_type
 * @property int $priority
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, MenuOptionValue> $option_values
 * @mixin Model
 */
class MenuOption extends Model
{
    use HasFactory;
    use Locationable;
    use Purgeable;

    const LOCATIONABLE_RELATION = 'locations';

    /**
     * @var string The database table name
     */
    protected $table = 'menu_options';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'option_id';

    protected $fillable = ['option_id', 'option_name', 'display_type'];

    protected $casts = [
        'option_id' => 'integer',
        'priority' => 'integer',
    ];

    public $relation = [
        'hasMany' => [
            'menu_options' => [MenuItemOption::class, 'foreignKey' => 'option_id', 'delete' => true],
            'option_values' => [MenuOptionValue::class, 'foreignKey' => 'option_id', 'delete' => true],
        ],
        'hasManyThrough' => [
            'menu_option_values' => [
                MenuItemOptionValue::class,
                'through' => MenuItemOption::class,
                'throughKey' => 'menu_option_id',
                'foreignKey' => 'option_id',
            ],
        ],
        'morphToMany' => [
            'locations' => [\Igniter\Local\Models\Location::class, 'name' => 'locationable'],
        ],
    ];

    protected $purgeable = ['values'];

    public $timestamps = true;

    public static function getRecordEditorOptions()
    {
        $query = self::selectRaw('option_id, concat(option_name, " (", display_type, ")") AS display_name');

        if (!empty($ids = Location::currentOrAssigned())) {
            $query->whereHasOrDoesntHaveLocation($ids);
        }

        return $query->orderBy('option_name')->dropdown('display_name');
    }

    public static function getDisplayTypeOptions(): array
    {
        return [
            'radio' => 'lang:igniter.cart::default.menu_options.text_radio',
            'checkbox' => 'lang:igniter.cart::default.menu_options.text_checkbox',
            'select' => 'lang:igniter.cart::default.menu_options.text_select',
            'quantity' => 'lang:igniter.cart::default.menu_options.text_quantity',
        ];
    }

    //
    // Helpers
    //

    public function isSelectDisplayType(): bool
    {
        return $this->display_type === 'select';
    }

    /**
     * Return all option values by option_id
     */
    public static function getOptionValues($optionId = null)
    {
        $query = MenuOptionValue::orderBy('priority');

        if ($optionId) {
            $query->where('option_id', $optionId);
        }

        return $query->get();
    }

    /**
     * Create a new or update existing option values
     *
     * @param array $optionValues
     */
    public function addOptionValues($optionValues = []): int
    {
        $optionId = $this->getKey();

        $idsToKeep = [];
        foreach ($optionValues as $value) {
            if (!array_key_exists('ingredients', $value)) {
                $value['ingredients'] = [];
            }

            $optionValue = $this->option_values()->firstOrNew([
                'option_value_id' => array_get($value, 'option_value_id'),
                'option_id' => $optionId,
            ])->fill(array_except($value, ['option_value_id', 'option_id']));

            $optionValue->saveOrFail();
            $idsToKeep[] = $optionValue->getKey();
        }

        $this->option_values()->where('option_id', $optionId)
            ->whereNotIn('option_value_id', $idsToKeep)->delete();

        $this->menu_option_values()
            ->whereNotIn('option_value_id', $idsToKeep)->delete();

        return count($idsToKeep);
    }

    public function attachRecordTo($menu): void
    {
        $this->attachToMenu($menu);
    }

    public function attachToMenu($menu): void
    {
        $menuItemOption = $menu->menu_options()->create([
            'option_id' => $this->getKey(),
        ]);

        $this->option_values()->get()->each(function($optionValue) use ($menuItemOption): void {
            $menuItemOption->menu_option_values()->create([
                'option_value_id' => $optionValue->option_value_id,
                'priority' => $optionValue->priority,
            ]);
        });
    }
}
