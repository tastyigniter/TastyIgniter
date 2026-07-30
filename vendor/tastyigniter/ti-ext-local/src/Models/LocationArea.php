<?php

declare(strict_types=1);

namespace Igniter\Local\Models;

use Igniter\Flame\Database\Factories\HasFactory;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Database\Traits\Sortable;
use Igniter\Flame\Geolite\Contracts\CircleInterface;
use Igniter\Flame\Geolite\Contracts\CoordinatesInterface;
use Igniter\Flame\Geolite\Contracts\LocationInterface;
use Igniter\Flame\Geolite\Contracts\PolygonInterface;
use Igniter\Flame\Geolite\Facades\Geocoder;
use Igniter\Flame\Geolite\Facades\Geolite;
use Igniter\Local\Contracts\AreaInterface;
use Igniter\System\Models\Concerns\Defaultable;
use Illuminate\Database\Eloquent\Builder;
use Override;

/**
 * LocationArea Model Class
 *
 * @property int $area_id
 * @property int $location_id
 * @property string $name
 * @property string $type
 * @property array $boundaries
 * @property array $conditions
 * @property string|null $color
 * @property bool $is_default
 * @property int $priority
 * @property-read mixed $circle
 * @property-read mixed $vertices
 * @property-read null|Location $location
 * @method null|Location location()
 * @mixin Model
 */
class LocationArea extends Model implements AreaInterface
{
    use Defaultable;
    use HasFactory;
    use Sortable;

    public const string VERTEX = 'vertex';

    public const string BOUNDARY = 'boundary';

    public const string INSIDE = 'inside';

    public const string OUTSIDE = 'outside';

    public const string SORT_ORDER = 'priority';

    /**
     * @var string The database table name
     */
    protected $table = 'location_areas';

    protected $primaryKey = 'area_id';

    public $relation = [
        'belongsTo' => [
            'location' => [Location::class],
        ],
    ];

    protected $casts = [
        'boundaries' => 'array',
        'conditions' => 'array',
    ];

    protected $appends = ['vertices', 'circle'];

    public static $areaColors = [
        '#F16745', '#FFC65D', '#7BC8A4', '#4CC3D9', '#93648D', '#404040',
        '#F16745', '#FFC65D', '#7BC8A4', '#4CC3D9', '#93648D', '#404040',
        '#F16745', '#FFC65D', '#7BC8A4', '#4CC3D9', '#93648D', '#404040',
        '#F16745', '#FFC65D',
    ];

    protected $fillable = ['area_id', 'type', 'name', 'boundaries', 'conditions', 'priority'];

    public $boundary;

    public function defaultable(): Builder
    {
        return static::query()->where('location_id', $this->location_id);
    }

    //
    // Accessors & Mutators
    //

    public function getVerticesAttribute()
    {
        return isset($this->boundaries['vertices']) ?
            json_decode((string)$this->boundaries['vertices'], false) : [];
    }

    public function getCircleAttribute()
    {
        return isset($this->boundaries['circle']) ?
            json_decode((string)$this->boundaries['circle'], false) : null;
    }

    public function getColorAttribute($value)
    {
        if ((string)$value === '') {
            $value = array_random(self::$areaColors);
        }

        return $value;
    }

    //
    // Helpers
    //
    public function getPolygon(): PolygonInterface
    {
        $vertices = array_map(fn($coordinates) => Geolite::coordinates($coordinates->lat, $coordinates->lng), $this->vertices);

        return Geolite::polygon($vertices);
    }

    public function getCircle(): CircleInterface
    {
        $coordinate = Geolite::coordinates(
            $this->circle->lat,
            $this->circle->lng,
        );

        return Geolite::circle($coordinate, $this->circle->radius);
    }

    public function isAddressBoundary(): bool
    {
        return $this->type === 'address';
    }

    public function isPolygonBoundary(): bool
    {
        return $this->type === 'polygon';
    }

    #[Override]
    public function getLocationId()
    {
        return $this->location_id;
    }

    #[Override]
    public function checkBoundary(CoordinatesInterface $coordinate): bool
    {
        if ($this->isAddressBoundary()) {
            $position = Geocoder::reverse(
                $coordinate->getLatitude(), $coordinate->getLongitude(),
            )->first();

            if ($position) {
                return $this->matchAddressComponents($position);
            }
        }

        return $this->isPolygonBoundary()
            ? $this->pointInVertices($coordinate)
            : $this->pointInCircle($coordinate);
    }

    // Check if the point is inside the polygon or on the boundary
    #[Override]
    public function pointInVertices(CoordinatesInterface $coordinate): bool
    {
        if (!$this->vertices) {
            return false;
        }

        return $this->getPolygon()->pointInPolygon($coordinate);
    }

    #[Override]
    public function pointInCircle(CoordinatesInterface $coordinate): bool
    {
        if (!$this->circle) {
            return false;
        }

        $circle = $this->getCircle();

        $circle->distanceUnit(setting('distance_unit'));

        return $circle->pointInRadius($coordinate);
    }

    #[Override]
    public function matchAddressComponents(LocationInterface $position): bool
    {
        $components = (array)array_get($this->boundaries, 'components');

        $groupedComponents = collect($components)->groupBy('type')->all();

        return Geolite::addressMatch($groupedComponents)->matches($position);
    }
}
