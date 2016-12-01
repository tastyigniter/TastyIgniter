<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package       TastyIgniter
 * @author        SamPoyigi
 * @copyright (c) 2013 - 2016. TastyIgniter
 * @link          http://tastyigniter.com
 * @license       http://opensource.org/licenses/GPL-3.0 The GNU GENERAL PUBLIC LICENSE
 * @since         File available since Release 1.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Location Delivery Class
 *
 * @category       Libraries
 * @package        TastyIgniter\Libraries\Location_delivery.php
 * @link           http://docs.tastyigniter.com
 */
class Location_delivery
{
	static $areaColors = [];
	static $chargeSummaryText = [
		'all'          => '%s on all orders',
		'above'        => '%s above %s',
		'below'        => '%s below %s',
		'free'         => 'Free Delivery',
		'no_condition' => 'not available %s %s',
		'no_total'     => 'No Min. Order Amount',
		'prefix'       => 'Delivery charge: %s',
	];

	public $allAreas = [];
	public $nearestArea = null;
	public $userPosition = null;
	public $cartTotal = null;
	public $areaChanged = null;

	public function __construct()
	{
		$this->CI =& get_instance();

		self::$areaColors = ['#F16745', '#FFC65D', '#7BC8A4', '#4CC3D9', '#93648D', '#404040', '#F16745', '#FFC65D', '#7BC8A4', '#4CC3D9', '#93648D', '#404040', '#F16745', '#FFC65D', '#7BC8A4', '#4CC3D9', '#93648D', '#404040', '#F16745', '#FFC65D'];
		$this->userPosition = $this->locationGeocode()->getDefaultPosition();
		$this->nearestArea = $this->getDefaultAreaBoundary();
	}

	public static function getChargeSummaryText($item = null)
	{
		if (!is_null($item))
			return isset(self::$chargeSummaryText[$item]) ? self::$chargeSummaryText[$item] : null;

		return self::$chargeSummaryText;
	}

	public static function setChargeSummaryText(array $chargeSummaryText)
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

	public function findAndSetNearestArea()
	{
		if (!$area = $this->findNearestArea())
			$area = $this->getDefaultNearestArea();

		$this->setNearestArea($area);

		return $area;
	}

	public function findNearestArea()
	{
		$nearestArea = null;
		$nearestAreaBoundary = $this->getDefaultAreaBoundary();

		$userPosition = $this->getUserPosition();
		if (is_null($userPositionPoint = $this->getUserPositionPoint($userPosition)))
			return $nearestArea;

		$nearestArea = $this->getNearestArea();
		if (!$this->hasNearestAreaChanged($nearestArea))
			return $nearestArea;

		foreach ($this->getAllBoundaries() as $locationId => $deliveryArea) {
			foreach ($deliveryArea as $areaId => $boundaries) {
				$positionBoundary = $this->locationGeocode()->findPositionInBoundaries($userPositionPoint, $boundaries);
				if ($positionBoundary != 'outside') {
					$nearestAreaBoundary->location_id = $locationId;
					$nearestAreaBoundary->area_id = $areaId;
					$nearestAreaBoundary->position = $positionBoundary;
					$nearestAreaBoundary->point = $userPositionPoint;
					break 2;
				}
			}
		}

		return $nearestAreaBoundary;
	}

	public function checkCoverage()
	{
		$coverage = null;
		$locationId = $this->getLocation()->getId();

		$nearestArea = $this->findNearestArea();

		if (empty($nearestArea->location_id) OR empty($nearestArea->position))
			return $coverage;

		if ($nearestArea->position != 'outside' AND $nearestArea->location_id == $locationId)
			return $nearestArea;

		return $coverage;
	}

	public function calculateDistanceToLocation()
	{
		$userPosition = $this->getUserPosition();
		$userPositionPoint = $this->getUserPositionPoint($userPosition);

		$localPositionPoint = $this->getLocalPosition();

		return $this->locationGeocode()->calculateDistance($userPositionPoint, $localPositionPoint);
	}

	public function checkChargeCondition($by = 'delivery')
	{
		$by = $by == 'delivery' ? 'amount' : 'total';
		$charge = null;
		if (!$nearestAreaCharge = $this->getNearestAreaCharge())
			return $charge;

		$conditions = array_column($nearestAreaCharge, 'condition');
		$minTotals = array_column($nearestAreaCharge, 'total');

		// use lowest minimum total when ONLY 'above' condition exist
		if (in_array('above', $conditions) AND !in_array('below', $conditions) AND !in_array('all', $conditions)) {
			if ($by == 'total') return min($minTotals);
		}

		// no minimum total when ONLY 'below' condition exist
		if (empty($charge) AND in_array('below', $conditions) AND !in_array('below', $conditions) AND !in_array('all', $conditions)) {
			array_multisort($minTotals, SORT_DESC, $nearestAreaCharge);
			if ($by == 'total') return 0;
		}

		// return delivery/minimum total from all 'below' conditions when charge total is greater than/equals cart total
		if (empty($charge) AND in_array('below', $conditions)) {
			array_multisort($minTotals, SORT_ASC, $nearestAreaCharge);
			$charge = $this->checkCartTotal($nearestAreaCharge, 'below');
		}

		// return delivery/minimum total from all 'above' conditions when charge total is less than/equals cart total
		if (empty($charge) AND in_array('above', $conditions)) {
			array_multisort($minTotals, SORT_DESC, $nearestAreaCharge);
			$charge = $this->checkCartTotal($nearestAreaCharge, 'above');
		}

		// when all condition exist use the first matching charge
		if (empty($charge) AND in_array('all', $conditions)) {
			array_multisort($minTotals, SORT_DESC, $nearestAreaCharge);
			$charge = $this->checkCartTotal($nearestAreaCharge, 'all');
		}

		// no minimum total is the found charge condition is 'below'
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
				} else if ($condition == 'above') {
					if ((float)$charge['total'] <= $cartTotal)
						return $charge;
				}
			}
		}

		return $returnCharge;
	}

	public function getNearestAreaCharge()
	{
		$nearestArea = $this->getNearestAreaArray();
		if (!isset($nearestArea['charge']))
			return null;

		return $nearestArea['charge'];
	}

	public function getNearestAreaChargeSummary()
	{
		$nearestArea = $this->getNearestAreaArray();
		if (!isset($nearestArea['full_summary']))
			return null;

		return $nearestArea['full_summary'];
	}

	public function getAreas()
	{
		$allAreas = $this->getAllAreas();
		$locationId = $this->getLocation()->getId();

		return (isset($allAreas[$locationId]) AND is_array($allAreas[$locationId])) ?
			$allAreas[$locationId] : [];
	}

	public function getBoundaries()
	{
		$allBoundaries = $this->getAllBoundaries();
		$locationId = $this->getLocation()->getId();

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
			array_push($summaries, sprintf($this->getChargeSummaryText('no_condition'), 'below',
				$this->CI->currency->format(min($minTotals))
			));
		}

		$prefix = FALSE;
		if (in_array('below', $conditions) AND !in_array('above', $conditions) AND !in_array('all', $conditions)) {
			array_unshift($summaries, sprintf($this->getChargeSummaryText('above'), $this->getChargeSummaryText('free'),
				$this->CI->currency->format(max($minTotals))
			));
		} else {
			if (!in_array('0', $deliveryAmounts)) $prefix = TRUE;
		}

		$fullSummary = implode(', ', $summaries);

		if ($prefix)
			$fullSummary = sprintf($this->getChargeSummaryText('prefix'), $fullSummary);

		return ucfirst(strtolower($fullSummary));
	}

	public function createChargeSummary($charge)
	{
		if (!isset($this->CI->currency))
			$this->CI->load->library('currency');

		$summary = null;

		$delivery = ($charge['amount'] > 0) ? $this->CI->currency->format($charge['amount']) : $this->getChargeSummaryText('free');
		$total = ($charge['total'] > 0) ? $this->CI->currency->format($charge['total']) : $this->getChargeSummaryText('no_total');

		if ($charge['condition'] == 'all') {
			$summary = sprintf($this->getChargeSummaryText('all'), $delivery);
		} else if ($charge['condition'] == 'above') {
			$summary = sprintf($this->getChargeSummaryText('above'), $delivery, $total);
		} else if ($charge['condition'] == 'below') {
			$summary = sprintf($this->getChargeSummaryText('below'), $delivery, $total);
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
			$polygons['circle'] = ['center' => $center->lat . '|' . $center->lng, 'radius' => $circle[1]->radius];
		}

		$polygons['type'] = $deliveryArea['type'];

		return $polygons;
	}

	/**
	 * @return Location null
	 */
	protected function getLocation()
	{
		return $this->CI->location;
	}

	/**
	 * @return \Location_geocode
	 */
	protected function locationGeocode()
	{
		if (isset($this->CI->location_geocode))
			return $this->CI->location_geocode;

		$this->CI->load->library('location_geocode');

		return $this->CI->location_geocode;
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

	// Transform string coordinates into arrays with x and y values
	public function getUserPositionPoint($userPosition)
	{
		if (!is_string($userPosition) AND $userPosition->status == 'OK')
			return ['y' => $userPosition->lat, 'x' => $userPosition->lng];

		return null;
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

		$nearestArea->location_id = $this->getLocation()->getId();
		$nearestArea->area_id = ($deliveryAreas = $this->getAreas()) ? key($deliveryAreas) : 1;
		$nearestArea->position = 'inside';
		$nearestArea->point = $this->getLocalPosition();

		return $nearestArea;
	}

	public function getLocalPosition()
	{
		$position = [];

		$localInfo = $this->getLocation()->local();

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

	public function getNearestAreaArray()
	{
		$areaId = $this->getNearestAreaId();
		$locationAreas = $this->getAreas();

		return (isset($locationAreas[$areaId])) ? $locationAreas[$areaId] : null;
	}

	public function getNearestArea()
	{
		return $this->nearestArea;
	}

	public function getNearestAreaId()
	{
		return $this->nearestArea->area_id;
	}

	public function getSessionNearestArea()
	{
		$localInfo = empty($localInfo) ? $this->getLocation()->getSessionData() : $localInfo;

		return isset($localInfo['area']) ? $localInfo['area'] : $this->getDefaultAreaBoundary();
	}

	public function setNearestArea($nearestArea)
	{
		$this->nearestArea = $nearestArea;
	}

	public function hasNearestAreaChanged($nearestArea = null)
	{
		$nearestArea = is_null($nearestArea) ? $this->getNearestArea() : $nearestArea;

		$locationId = $this->getLocation()->getId();
		$sessionArea = $this->getSessionNearestArea();
		if (!empty($nearestArea->point) AND !empty($sessionArea->point)) {
			if ($sessionArea->location_id == $locationId AND $sessionArea->point == $nearestArea->point)
				return FALSE;
		}

		return TRUE;
	}

	protected function getByLocationAreas()
	{
		$allAreas = [];

		foreach ($this->getByLocationsId() as $locationId => $location) {
			if (isset($location['options']['delivery_areas']))
				$allAreas[$locationId] = $location['options']['delivery_areas'];
		}

		return $allAreas;
	}

	protected function getByLocationsId()
	{
		$locationModels = $this->getLocation()->getLocationModels();

		return !is_null($locationModels) ? $locationModels->keyBy('location_id')->all() : [];
	}
}
