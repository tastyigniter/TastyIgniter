<?php

declare(strict_types=1);

namespace Igniter\Cart\Models;

use Igniter\Flame\Database\Attach\HasMedia;
use Igniter\Flame\Database\Attach\Media;
use Igniter\Flame\Database\Factories\HasFactory;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Database\Traits\HasPermalink;
use Igniter\Flame\Database\Traits\NestedTree;
use Igniter\Flame\Database\Traits\Sortable;
use Igniter\Local\Models\Concerns\Locationable;
use Igniter\Local\Models\Location;
use Igniter\System\Models\Concerns\Switchable;
use Illuminate\Support\Carbon;
use Kalnoy\Nestedset\Collection;

/**
 * Category Model Class
 *
 * @property int $category_id
 * @property string $name
 * @property string|null $description
 * @property int|null $parent_id
 * @property int $priority
 * @property bool $status
 * @property int|null $nest_left
 * @property int|null $nest_right
 * @property string|null $permalink_slug
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Category> $children
 * @property-read Collection<int, Menu> $menus
 * @property-read int|null $children_count
 * @property-read mixed $count_menus
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read Category|null $parent
 * @mixin Model
 */
class Category extends Model
{
    use HasFactory;
    use HasMedia;
    use HasPermalink;
    use Locationable;
    use NestedTree;
    use Sortable;
    use Switchable;

    public const string SORT_ORDER = 'priority';

    public const string LOCATIONABLE_RELATION = 'locations';

    /**
     * @var string The database table name
     */
    protected $table = 'categories';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'category_id';

    public $timestamps = true;

    protected $guarded = [];

    protected $casts = [
        'parent_id' => 'integer',
        'priority' => 'integer',
        'nest_left' => 'integer',
        'nest_right' => 'integer',
    ];

    public $relation = [
        'belongsTo' => [
            'parent_cat' => [Category::class, 'foreignKey' => 'parent_id', 'otherKey' => 'category_id'],
        ],
        'belongsToMany' => [
            'menus' => [Menu::class, 'table' => 'menu_categories'],
        ],
        'morphToMany' => [
            'locations' => [Location::class, 'name' => 'locationable'],
        ],
    ];

    public $permalinkable = [
        'permalink_slug' => [
            'source' => 'name',
        ],
    ];

    public $mediable = ['thumb'];

    protected array $queryModifierFilters = [
        'enabled' => ['applySwitchable', 'default' => true],
        'location' => 'whereHasOrDoesntHaveLocation',
    ];

    protected array $queryModifierSorts = ['priority asc', 'priority desc'];

    protected array $queryModifierSearchableFields = ['name', 'description'];

    public static function getDropdownOptions()
    {
        return self::whereIsEnabled()->pluck('name', 'category_id');
    }

    //
    // Accessors & Mutators
    //

    public function getDescriptionAttribute($value): string
    {
        return strip_tags(html_entity_decode((string)$value, ENT_QUOTES, 'UTF-8'));
    }

    public function getCountMenusAttribute($value): int
    {
        return $this->menus->where('menu_status', 1)->count();
    }
}
