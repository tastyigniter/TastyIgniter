<?php

declare(strict_types=1);

namespace Igniter\Reservation\Models;

use Igniter\Flame\Database\Builder;
use Igniter\Flame\Database\Factories\HasFactory;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Database\Relations\BelongsTo;
use Igniter\Flame\Database\Relations\HasMany;
use Igniter\Local\Models\Concerns\Locationable;
use Igniter\Local\Models\Location;
use Illuminate\Support\Collection;

/**
 * DiningSection Model Class
 *
 * @property int $id
 * @property int $location_id
 * @property string $name
 * @property string|null $description
 * @property string|null $color
 * @property int $priority
 * @property int $is_enabled
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read Location $location
 * @property-read Collection<int, DiningArea> $dining_areas
 * @method static Builder<static>|DiningSection query()
 * @method static Builder<static>|DiningSection dropdown(string $column, string $key = null)
 * @method static BelongsTo<static>|DiningSection location()
 * @method static HasMany<static>|DiningSection dining_areas()
 * @method static Builder<static>|DiningSection whereHasLocation(int|string|Model $locationId)
 * @method static Builder<static>|DiningSection whereIsReservable()
 * @mixin Model
 */
class DiningSection extends Model
{
    use HasFactory;
    use Locationable;

    public $table = 'dining_sections';

    /**
     * @var array Relations
     */
    public $relation = [
        'belongsTo' => [
            'location' => [Location::class],
        ],
        'hasMany' => [
            'dining_areas' => [DiningArea::class, 'foreignKey' => 'location_id', 'otherKey' => 'location_id'],
        ],
    ];

    public function getRecordEditorOptions(DiningArea $diningArea)
    {
        return self::query()
            ->whereHasLocation($diningArea->location_id)
            ->dropdown('name');
    }

    public function getPriorityOptions()
    {
        return collect(range(0, 9))->map(fn($priority): string => lang('igniter.reservation::default.dining_tables.text_priority_'.$priority))->all();
    }

    public function scopeWhereIsReservable($query)
    {
        return $query->where('is_enabled', 1);
    }
}
