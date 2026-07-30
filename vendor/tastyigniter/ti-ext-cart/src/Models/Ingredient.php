<?php

declare(strict_types=1);

namespace Igniter\Cart\Models;

use Igniter\Flame\Database\Attach\HasMedia;
use Igniter\Flame\Database\Attach\Media;
use Igniter\Flame\Database\Factories\HasFactory;
use Igniter\Flame\Database\Model;
use Igniter\System\Models\Concerns\Switchable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

/**
 * Ingredients Model Class
 *
 * @property int $ingredient_id
 * @property string $name
 * @property string $description
 * @property bool $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property bool $is_allergen
 * @property-read mixed $count_menus
 * @property-read Collection<int, Media> $media
 * @property-read int|null $media_count
 * @mixin Model
 */
class Ingredient extends Model
{
    use HasFactory;
    use HasMedia;
    use Switchable;

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
    ];

    public $relation = [
        'morphedByMany' => [
            'menus' => [Menu::class, 'name' => 'ingredientable'],
            'menu_option_values' => [MenuOptionValue::class, 'name' => 'ingredientable'],
        ],
    ];

    public $mediable = ['thumb'];

    public $timestamps = true;

    //
    // Accessors & Mutators
    //

    public function getDescriptionAttribute($value): string
    {
        return strip_tags(html_entity_decode((string)$value, ENT_QUOTES, 'UTF-8'));
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
        return $query->whereHas('menus')->whereIsEnabled();
    }

    public function scopeIsAllergen($query)
    {
        return $query->where('is_allergen', 1);
    }
}
