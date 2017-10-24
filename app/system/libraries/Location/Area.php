<?php namespace Igniter\Libraries\Location;

use Exception;
use Igniter\Classes\GeoPosition;
use Admin\Models\Location_areas_model;
use Igniter\Flame\Traits\EventEmitter;
use Illuminate\Support\Collection;

/**
 * Location Area Class
 *
 * @package System
 */
class Area
{
    use EventEmitter;

    protected $location;

    protected $geocode;

    public $searchQuery = null;

    protected static $areaColors = [
        '#F16745', '#FFC65D', '#7BC8A4', '#4CC3D9', '#93648D', '#404040',
        '#F16745', '#FFC65D', '#7BC8A4', '#4CC3D9', '#93648D', '#404040',
        '#F16745', '#FFC65D', '#7BC8A4', '#4CC3D9', '#93648D', '#404040',
        '#F16745', '#FFC65D'
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

    public $areas = [];
    public $allAreas = [];

    public $nearestArea = null;

    public $userPosition = null;

    public $localPosition = null;

    public $cartTotal = null;

    public $areaChanged = null;

    public function __construct($location)
    {
        $this->location = $location;
        $this->geocode = Geocode::instance();

//		$this->userPosition = $this->locationGeocode()->getDefaultPosition();
//		$this->nearestArea = $this->getDefaultAreaBoundary();
    }

    public function initialize()
    {
        $this->areas = $this->loadAreas();

        // Lookup the nearest location area based on the user position
        $area = $this->findNearestArea();

        $this->setNearestArea($area);
//        dd($this->areas);

//        $userPosition = $this->findUserPosition();
//        $this->setUserPosition($userPosition);

//        $nearestArea = $this->area->setUserPosition($userPosition)->findAndSetNearestArea();
//        if (!$area = $this->findNearestArea())
//            $area = $this->getDefaultNearestArea();
//        $this->setUserPosition($userPosition)->findAndSetNearestArea();
    }

    public function setNearestArea($nearestArea)
    {
        $this->nearestArea = $nearestArea;

        // @todo: trigger event when area changes
    }

    /**
     * @return Location_areas_model
     */
    public function getNearestArea()
    {
        return $this->nearestArea;
    }

    public function nearestAreaChanged($nearestArea = null)
    {
        $sessionArea = $this->getSessionNearestArea();

        $nearestArea = is_null($nearestArea) ? $this->getNearestArea() : $nearestArea;

        if (!isset($sessionArea->location_id) OR !isset($nearestArea->point) OR !isset($sessionArea->point))
            return FALSE;

        $locationId = $this->location()->getId();

        return ($locationId != $sessionArea->location_id AND $sessionArea->point != $nearestArea->point);
    }

    public function getNearestAreaArray()
    {
        $areaId = $this->getNearestAreaId();
        $locationAreas = $this->getAreas();

        return (isset($locationAreas[$areaId])) ? $locationAreas[$areaId] : null;
    }

    public function getNearestAreaId()
    {
        return isset($this->nearestArea->area_id) ? $this->nearestArea->area_id : null;
    }

    public function getSessionNearestArea()
    {
//        return $this->location()->getSessionData('area', $this->getDefaultAreaBoundary());
    }

    public function userPosition()
    {
        if (is_null($this->userPosition))
            $this->userPosition = $this->makeUserPosition();

        return $this->userPosition;
//        $searchQuery = $this->getSearchQuery();
//
//        if (empty($searchQuery))
//            return "NO_SEARCH_QUERY";
//
//        $sessionPosition = $this->getSessionPosition();
//        if (!empty($sessionPosition->search_query) AND $sessionPosition->search_query == $searchQuery)
//            return $sessionPosition;
//
//        $geocodePosition = $this->geocodePosition($searchQuery);
//
//        if (empty($geocodePosition->status))
//            return "FAILED";
//
//        if ($geocodePosition->status === 'OK')
//            return $geocodePosition;
//
//        return "INVALID_SEARCH_QUERY";
    }

    public function localPosition()
    {
        if (is_null($this->localPosition))
            $this->localPosition = $this->makeLocalPosition();

//        $localInfo = $this->location()->local();

//        if (isset($localInfo['location_lat']))
//            $position['y'] = $localInfo['location_lat'];
//
//        if (isset($localInfo['location_lng']))
//            $position['x'] = $localInfo['location_lng'];
//
        return $this->localPosition;
    }

    protected function makeUserPosition()
    {
        $searchQuery = $this->location()->getParam('search_query');

        return $this->geocode()->geocodePosition($searchQuery);
    }

    protected function makeLocalPosition()
    {
        $position = $this->geocode()->newPosition();
        $position->latitude = $this->location()->location_lat;
        $position->longitude = $this->location()->location_lng;

        return $position;
    }

//    public function findAndSetNearestArea()
//    {
//        if (!$area = $this->findNearestArea())
//            $area = $this->getDefaultNearestArea();
//
//        $this->setNearestArea($area);
//
//        return $area;
//    }

    public function findNearestArea()
    {
        $userPosition = $this->userPosition();

        // Find the nearest restaurant based on closest in distance
        if (!$restaurant = $this->searchRestaurant($userPosition))
            return null;

        // Retrieve location areas
        $areas = $this->loadAreas($restaurant);

        return  $this->findPositionInAreas($areas, $userPosition);

//        $nearestArea = null;
//        $nearestAreaBoundary = $this->getDefaultAreaBoundary();
//
//        $userPosition = $this->getUserPosition();
//        if (is_null($userPositionPoint = $this->getUserPositionPoint($userPosition)))
//            return $nearestArea;
//
//        $nearestArea = $this->getNearestArea();
//        if (!$this->hasNearestAreaChanged($nearestArea))
//            return $nearestArea;
//
//        foreach ($this->getAllBoundaries() as $locationId => $deliveryArea) {
//            foreach ($deliveryArea as $areaId => $boundaries) {
//                $positionBoundary = $this->locationGeocode()->findPositionInBoundaries($userPositionPoint, $boundaries);
//                if ($positionBoundary != 'outside') {
//                    $nearestAreaBoundary->location_id = $locationId;
//                    $nearestAreaBoundary->area_id = $areaId;
//                    $nearestAreaBoundary->position = $positionBoundary;
//                    $nearestAreaBoundary->point = $userPositionPoint;
//                    break 2;
//                }
//            }
//        }
//
//        return $nearestAreaBoundary;
    }

    public function findPositionInAreas(Collection $areas, $position)
    {
        $areas->each(function(Location_areas_model $areaModel) use ($position) {
            $areaModel->setPositionBoundary($position);
        });

        $filtered = $areas->filter(function(Location_areas_model $areaModel) {
            return $areaModel->positionBoundary != 'outside';
        });

        return $filtered->first();
    }

    public function getSearchQuery()
    {
//        if (is_null($this->searchQuery))
//            return $this->getSessionPosition()->search_query;

        return $this->searchQuery;
    }

    public function setSearchQuery($searchQuery)
    {
        $this->searchQuery = $searchQuery;

        return $this;
    }

    public function hasSearchQuery()
    {
        $sessionPosition = null; //$this->getSessionPosition();

        return (empty($sessionPosition->search_query)) ? FALSE : TRUE;
    }

    public static function getConditionSummaryText($item = null)
    {
        if (!is_null($item))
            return isset(self::$chargeSummaryText[$item]) ? self::$chargeSummaryText[$item] : null;

        return self::$chargeSummaryText;
    }

    public static function overrideConditionSummaryText(array $chargeSummaryText)
    {
        self::$chargeSummaryText = array_merge(self::$chargeSummaryText, $chargeSummaryText);
    }

    public function getChargeDeliveryAmount()
    {
        return $this->checkChargeCondition('delivery');
    }

    public function getChargeMinOrderTotal()
    {
        return $this->checkChargeCondition('min_total');
    }

    public function checkCoverage()
    {
//        $coverage = null;

        if (!$nearestArea = $this->findNearestArea())
            return null;

//        if (empty($nearestArea->location_id) OR empty($nearestArea->position))
//            return $coverage;

        if ($this->location()->getId() != $nearestArea->location_id)
            return null;

        if ($nearestArea->positionBoundary != 'outside')
            return $nearestArea;

        return $nearestArea->positionBoundary;
    }

    public function calculateDistanceFromUserPosition()
    {
        return $this->geocode()->calculateDistance($this->userPosition(), $this->localPosition());
    }

    public function checkChargeCondition($by = 'delivery')
    {
        $by = ($by == 'delivery') ? 'amount' : 'total';
        $charge = null;
        if (!$nearestAreaCharge = $this->getNearestAreaChargeConditions())
            return $charge;

        $conditions = array_column($nearestAreaCharge, 'condition');
        $minTotals = array_column($nearestAreaCharge, 'total');

        // Use lowest minimum total when ONLY 'above' condition exist
        if (in_array('above', $conditions) AND !in_array('below', $conditions) AND !in_array('all', $conditions)) {
            if ($by == 'total') return min($minTotals);
        }

        // No minimum total when ONLY 'below' condition exist
        if (empty($charge) AND in_array('below', $conditions) AND !in_array('below', $conditions) AND !in_array('all', $conditions)) {
            array_multisort($minTotals, SORT_DESC, $nearestAreaCharge);
            if ($by == 'total') return 0;
        }

        // Return delivery/minimum total from all 'below' conditions when charge total is greater than/equals cart total
        if (empty($charge) AND in_array('below', $conditions)) {
            array_multisort($minTotals, SORT_ASC, $nearestAreaCharge);
            $charge = $this->checkCartTotal($nearestAreaCharge, 'below');
        }

        // Return delivery/minimum total from all 'above' conditions when charge total is less than/equals cart total
        if (empty($charge) AND in_array('above', $conditions)) {
            array_multisort($minTotals, SORT_DESC, $nearestAreaCharge);
            $charge = $this->checkCartTotal($nearestAreaCharge, 'above');
        }

        // When all condition exist use the first matching charge
        if (empty($charge) AND in_array('all', $conditions)) {
            array_multisort($minTotals, SORT_DESC, $nearestAreaCharge);
            $charge = $this->checkCartTotal($nearestAreaCharge, 'all');
        }

        // No minimum total when the found charge condition is 'below'
        if ($by == 'total' AND $charge['condition'] == 'below') return 0;

        return isset($charge[$by]) ? $charge[$by] : $charge;
    }

    public function checkCartTotal($nearestAreaCharge, $condition)
    {
        $returnCharge = null;
        $cartTotal = $this->getCartTotal();
        foreach ($nearestAreaCharge as $charge) {
            if ($charge['condition'] == $condition) {
                if ($condition == 'all')
                    return $charge;

                if ($condition == 'below') {
                    if ((float)$charge['total'] >= $cartTotal)
                        return $charge;
                }
                else if ($condition == 'above') {
                    if ((float)$charge['total'] <= $cartTotal)
                        return $charge;
                }
            }
        }

        return $returnCharge;
    }

    public function getNearestAreaChargeConditions()
    {
        if (!$nearestArea = $this->getNearestArea())
            return null;

        return $nearestArea->conditions;
    }

    public function getNearestAreaChargeSummary()
    {
        if (!$nearestArea = $this->getNearestArea())
            return null;

        return $nearestArea->charge_summary;
    }

    public function getAreas()
    {
        return $this->areas;
    }

    public function getBoundaries()
    {
        $allBoundaries = $this->getAllBoundaries();
        $locationId = $this->location()->getId();

        return (isset($allBoundaries[$locationId]) AND is_array($allBoundaries[$locationId])) ?
            $allBoundaries[$locationId] : [];
    }

    public function getAllAreas()
    {
        $this->setOrCreateAllAreas();

        return $this->allAreas;
    }

    public function getAllBoundaries()
    {
        $boundaries = [];

        foreach ($this->getAllAreas() as $locationId => $deliveryAreas) {
            foreach ($deliveryAreas as $areaId => $deliveryArea) {
                $boundaries[$locationId][$areaId] = isset($deliveryArea['polygon']) ? $deliveryArea['polygon'] : [];
            }
        }

        return $boundaries;
    }

    public function setOrCreateAllAreas($allAreas = null)
    {
        $allAreas = empty($allAreas) ? $this->allAreas : $allAreas;

        if (empty($allAreas))
            $allAreas = $this->createAllAreas();

        $this->allAreas = $allAreas;

        return $this;
    }

    public function createAllAreas()
    {
        $areas = [];

        foreach ($this->getByLocationAreas() as $locationId => $deliveryAreas) {
            foreach ($deliveryAreas as $areaId => $deliveryArea) {
                $deliveryArea['color'] = $this->getAreaColor($areaId);
                $deliveryArea['charge'] = $this->createCharges($deliveryArea);
                $deliveryArea['polygon'] = $this->createPolygons($deliveryArea);
                $deliveryArea['full_summary'] = $this->createChargeFullSummary($deliveryArea);

                $areas[$locationId][$areaId] = array_merge(['area_id' => $areaId], $deliveryArea);
            }
        }

        return $areas;
    }

    public function createCharges($deliveryArea)
    {
        // backward compatibility, remove later
        if (isset($deliveryArea['charge']) AND is_string($deliveryArea['charge'])) {
            $deliveryArea['charge'] = [1 => [
                'amount'    => $deliveryArea['charge'],
                'condition' => isset($deliveryArea['condition']) ? $deliveryArea['condition'] : 'above',
                'total'     => (isset($deliveryArea['min_amount'])) ? $deliveryArea['min_amount'] : '0',
            ]];
        }

        $deliveryCharges = [];
        foreach ($deliveryArea['charge'] as $key => $charge) {
            $charge['amount'] = isset($charge['amount']) ? $charge['amount'] : '0';
            $charge['total'] = isset($charge['total']) ? $charge['total'] : '0';
            $charge['condition'] = ($charge['total'] <= 0) ? 'all' : $charge['condition'];
            $charge['rule'] = "{$charge['amount']}|{$charge['condition']}|{$charge['total']}";
            $charge['summary'] = $this->createChargeSummary($charge);

            $deliveryCharges[$key] = $charge;
        }

        return $deliveryCharges;
    }

    public function createChargeFullSummary($deliveryArea)
    {
        $nearestAreaCharge = $deliveryArea['charge'];
        $minTotals = array_column($nearestAreaCharge, 'total');
        $deliveryAmounts = array_column($nearestAreaCharge, 'amount');
        $conditions = array_column($nearestAreaCharge, 'condition');

        if (in_array('0', $deliveryAmounts)) array_multisort($deliveryAmounts, SORT_ASC, $nearestAreaCharge);

        $summaries = array_column($nearestAreaCharge, 'summary');

        if (in_array('above', $conditions) AND !in_array('below', $conditions) AND !in_array('all', $conditions)) {
            array_push($summaries, sprintf($this->getConditionSummaryText('no_condition'), 'below',
                $this->currency->format(min($minTotals))
            ));
        }

        $prefix = FALSE;
        if (in_array('below', $conditions) AND !in_array('above', $conditions) AND !in_array('all', $conditions)) {
            array_unshift($summaries, sprintf($this->getConditionSummaryText('above'), $this->getConditionSummaryText('free'),
                $this->currency->format(max($minTotals))
            ));
        }
        else {
            if (!in_array('0', $deliveryAmounts)) $prefix = TRUE;
        }

        $fullSummary = implode(', ', $summaries);

        if ($prefix)
            $fullSummary = sprintf($this->getConditionSummaryText('prefix'), $fullSummary);

        return ucfirst(strtolower($fullSummary));
    }

    public function createChargeSummary($charge)
    {
        $summary = null;

        $delivery = ($charge['amount'] > 0) ? $this->currency->format($charge['amount']) : $this->getConditionSummaryText('free');
        $total = ($charge['total'] > 0) ? $this->currency->format($charge['total']) : $this->getConditionSummaryText('no_total');

        if ($charge['condition'] == 'all') {
            $summary = sprintf($this->getConditionSummaryText('all'), $delivery);
        }
        else if ($charge['condition'] == 'above') {
            $summary = sprintf($this->getConditionSummaryText('above'), $delivery, $total);
        }
        else if ($charge['condition'] == 'below') {
            $summary = sprintf($this->getConditionSummaryText('below'), $delivery, $total);
        }

        return strtolower(trim(trim($summary, ',')));
    }

    public function createPolygons($deliveryArea)
    {
        $polygons = [];

        $vertices = (!empty($deliveryArea['vertices'])) ? json_decode($deliveryArea['vertices']) : [];
        $circle = (!empty($deliveryArea['circle'])) ? json_decode($deliveryArea['circle']) : [];

        foreach ($vertices as $vertex) {
            $polygons['vertices'][] = ['x' => $vertex->lng, 'y' => $vertex->lat];
        }

        if (isset($circle[0]->center) AND isset($circle[1]->radius)) {
            $center = $circle[0]->center;
            $polygons['circle'] = ['center' => $center->lat.'|'.$center->lng, 'radius' => $circle[1]->radius];
        }

        $polygons['type'] = $deliveryArea['type'];

        return $polygons;
    }

    /**
     * @return Location
     */
    protected function location()
    {
        return $this->location;
    }

    /**
     * @return \Igniter\Libraries\Location\Geocode
     */
    public function geocode()
    {
        return $this->geocode;
    }

    /**
     * @return \Igniter\Libraries\Location\Geocode
     */
    protected function locationGeocode()
    {
//		if (isset($this->location_geocode))
//			return $this->location_geocode;
//
//		$this->load->library('location_geocode');

        return $this->location()->geocode();
    }

    public function getAreaColor($areaId)
    {
        return isset(self::$areaColors[$areaId - 1]) ? self::$areaColors[$areaId - 1] : '#F16745';
    }

    public function getCartTotal()
    {
        return $this->cartTotal;
    }

    public function setCartTotal($cartTotal)
    {
        $this->cartTotal = $cartTotal;

        return $this;
    }

    public function getDefaultAreaBoundary()
    {
        $boundary = new \stdClass;
        $boundary->point = $boundary->position = $boundary->location_id = $boundary->area_id = null;

        return $boundary;
    }

    public function getDefaultNearestArea()
    {
        $nearestArea = $this->getDefaultAreaBoundary();

        $nearestArea->location_id = $this->location()->getId();
        $nearestArea->area_id = ($deliveryAreas = $this->getAreas()) ? key($deliveryAreas) : 1;
        $nearestArea->position = 'outside';
        $nearestArea->point = $this->getLocalPosition();

        return $nearestArea;
    }

    public function getLocalPosition()
    {
        $position = [];

        $localInfo = $this->location()->local();

        if (isset($localInfo['location_lat']))
            $position['y'] = $localInfo['location_lat'];

        if (isset($localInfo['location_lng']))
            $position['x'] = $localInfo['location_lng'];

        return $position;
    }

    public function getUserPosition()
    {
        return $this->userPosition;
    }

    public function setUserPosition($userPosition)
    {
        $this->userPosition = $userPosition;

        return $this;
    }

    /**
     * Transform string coordinates into arrays with x and y values
     *
     * @param $userPosition
     *
     * @return array|null
     */
    public function getUserPositionPoint($userPosition)
    {
        if (isset($userPosition->status) AND $userPosition->status == 'OK')
            return ['y' => $userPosition->lat, 'x' => $userPosition->lng];

        return null;
    }

    protected function searchRestaurant(GeoPosition $userPosition)
    {
        return $this->location()
                    ->getModel()
                    ->getLocalRestaurant($userPosition->latitude, $userPosition->longitude);
    }

    /**
     * @param null $model
     *
     * @return Collection
     * @throws \Exception
     */
    protected function loadAreas($model = null)
    {
        if (is_null($model) AND !$model = $this->location()->getModel())
            throw new Exception("No model found");

        $relationName = 'delivery_areas';
        if (!$model->hasRelation('delivery_areas'))
            throw new Exception(sprintf("Model '%s' does not contain a definition for '%s'.",
                get_class($this->model),
                $relationName
            ));

        return $model->{$relationName};
    }

//    protected function getByLocationAreas()
//    {
//        $allAreas = [];
//
//        foreach ($this->getByLocationsId() as $locationId => $location) {
//            if (isset($location['options']['delivery_areas']))
//                $allAreas[$locationId] = $location['options']['delivery_areas'];
//        }
//
//        return $allAreas;
//    }
//
//    protected function getByLocationsId()
//    {
//        $locationModels = $this->location()->getLocalModelCache();
//
//        return !is_null($locationModels) ? $locationModels->keyBy('location_id')->all() : [];
//    }
}
