<?php

namespace Admin\Models;

use Admin\Classes\GeoPosition;
use Model;

/**
 * Location areas Model Class
 *
 * @package Admin
 */
class Location_areas_model extends Model
{
    const VERTEX = "vertex";

    const BOUNDARY = "boundary";

    const INSIDE = "inside";

    const OUTSIDE = "outside";

    /**
     * @var string The database table name
     */
    protected $table = 'location_areas';

    protected $primaryKey = 'area_id';

    protected $fillable = ['area_id', 'type', 'name', 'boundaries', 'conditions'];

    public $relation = [
        'belongsTo' => [
            'location' => ['Admin\Models\Locations_model'],
        ],
    ];

    public $casts = [
        'boundaries' => 'serialize',
        'conditions' => 'serialize',
    ];

    protected static $chargeSummaryText = [
        'all'          => '%s on all orders',
        'above'        => '%s above %s',
        'below'        => '%s below %s',
        'free'         => 'Free Delivery',
        'no_condition' => 'not available %s %s',
        'no_total'     => 'No Min. Order Amount',
        'prefix'       => 'Delivery charge: %s',
    ];

    public $positionBoundary;

    public function getVerticesAttribute()
    {
        return isset($this->boundaries['vertices']) ?
            json_decode($this->boundaries['vertices']) : null;
    }

    public function getCircleAttribute()
    {
        return isset($this->boundaries['circle']) ?
            json_decode($this->boundaries['circle']) : null;
    }

    public function listConditions()
    {
        $conditions = $this->conditions;
        foreach ($conditions as &$condition) {
            $condition['label'] = self::getConditionSummaryText($condition['type']);
        }

        return $conditions;
    }

    public function setPositionBoundary(GeoPosition $position)
    {
        if (!isset($this->type))
            return null;

        $positionBoundary = ($this->type == 'polygon')
            ? $this->pointInVertices($position) : $this->pointInCircle($position);

        $this->positionBoundary = $positionBoundary;
    }

    // Check if the point is inside the polygon or on the boundary
    public function pointInVertices($position)
    {
        $vertices = $this->vertices;

        // Check if the point sits exactly on a vertex
        if ($this->isPointOnVertex($position, $vertices) === TRUE)
            return static::VERTEX;

        $intersections = 0;
        for ($i = 1; $i < count($vertices); $i++) {
            $vertex1 = $vertices[$i - 1];
            $vertex2 = $vertices[$i];

            if ($this->isPointOnBoundary($position, $vertex1, $vertex2)) return static::BOUNDARY;

            $boundary = $this->isPointInBoundary($position, $vertex1, $vertex2);

            if ($boundary === TRUE) return static::BOUNDARY;

            if ($boundary === 1) $intersections++;
        }

        // If the number of edges we passed through is odd, then it's in the polygon.
        return ($intersections % 2 != 0) ? static::INSIDE : static::OUTSIDE;
    }

    public function pointInCircle($position)
    {
        $distanceUnit = setting('distance_unit');
        $earthRadius = ($distanceUnit === 'km') ? 6371 : 3959;
        $radius = ($distanceUnit === 'km') ? $this->circle->radius / 1000 : $this->circle->radius / 1609.344;

        $dLat = deg2rad($this->circle->lat - $position->latitude);
        $dLon = deg2rad($this->circle->lng - $position->longitude);

        $a = sin($dLat / 2) * sin($dLat / 2)
            + cos(deg2rad($position->latitude)) * cos(deg2rad($this->circle->lat))
            * sin($dLon / 2) * sin($dLon / 2);

        $distance = $earthRadius * (2 * asin(sqrt($a)));

        return ($distance <= $radius) ? static::INSIDE : static::OUTSIDE;
    }

    public static function getConditionSummaryText($item = null)
    {
        if (!is_null($item))
            return isset(self::$chargeSummaryText[$item]) ? self::$chargeSummaryText[$item] : null;

        return self::$chargeSummaryText;
    }

    protected function isPointInBoundary($position, $vertex1, $vertex2)
    {
        if ($position->latitude > min($vertex1->lat, $vertex2->lat)
            AND $position->latitude <= max($vertex1->lat, $vertex2->lat)
            AND $position->longitude <= max($vertex1->lng, $vertex2->lng)
            AND $vertex1->lat != $vertex2->lat
        ) {
            $xinters = ($position->latitude - $vertex1->lat)
                * ($vertex2->lng - $vertex1->lng) / ($vertex2->lat - $vertex1->lat) + $vertex1->lng;

            // Check if point is on the polygon boundary (other than horizontal)
            if ($xinters == $position->longitude) {
                return TRUE;
            }

            // Check if point is in the polygon boundary
            if ($vertex1->lng == $vertex2->lng OR $position->longitude <= $xinters) {
                return 1;
            }
        }

        return FALSE;
    }

    protected function isPointOnVertex($position, $vertices)
    {
        foreach ($vertices as $vertex) {
            if ($position->latitude == $vertex->lat AND $position->longitude == $vertex->lng) {
                return TRUE;
            }
        }

        return FALSE;
    }

    protected function isPointOnBoundary($position, $vertex1, $vertex2)
    {
        return ($vertex1->lat == $vertex2->lat AND $vertex1->lat == $position->latitude
            AND $position->longitude > min($vertex1->lng, $vertex2->lng)
            AND $position->longitude < max($vertex1->lng, $vertex2->lng));
    }
}