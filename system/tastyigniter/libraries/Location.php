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
 * Location Class
 *
 * @category       Libraries
 * @package        TastyIgniter\Libraries\Location.php
 * @link           http://docs.tastyigniter.com
 */
class Location
{
//	protected $CI = NULL;
	const DELIVERY = 'delivery';
	const COLLECTION = 'collection';

	public $location_id;
	public $location_name;
	public $location_email;
	public $location_telephone;
	public $local_options;
	public $local_info;
	public $geocode;
	public $area_id;
	public $order_type;
	public $polygons = [];
	public $delivery_areas = [];
	public $working_hours = [];
	public $working_hour = [];
	public $permalink;
	protected $locationModels;
	protected $tempSessionData;

	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->database();
		$this->CI->load->helper('date');
		$this->CI->load->library('country');
		$this->CI->load->library('location_hours');
		$this->CI->load->library('location_delivery');
		$this->CI->load->library('location_geocode');
		$this->CI->load->model('Locations_model');
	}

	public function initialize()
	{
		if ($this->validateProperties()) {
			$this->setProperties();
		}

		$this->tempSessionData = null;
	}

	public function getSessionData()
	{
		if (!empty($this->tempSessionData))
			return $this->tempSessionData;

		return $this->CI->session->userdata('local_info');
	}

	public function setSessionData($localInfo, $update = TRUE)
	{
		if ($update) {
			$this->CI->session->set_userdata('local_info', $localInfo);
		} else {
			$this->tempSessionData = $localInfo;
		}

		return $this;
	}

	public function updateSessionData($data, $update = TRUE)
	{
		$localInfo = $this->getSessionData();

		$updateData = [];
		foreach (['location_id', 'geocode', 'search_query', 'area', 'order_type'] as $item) {
			if ($item == 'search_query' AND isset($data[$item]) AND isset($localInfo['geocode'])) {
				$localInfo['geocode']->search_query = $data[$item];
				$updateData['geocode'] = $localInfo['geocode'];
			} else if (isset($data[$item])) {
				$updateData[$item] = $data[$item];
			} else if (isset($localInfo[$item])) {
				$updateData[$item] = $localInfo[$item];
			}
		}

		$this->setSessionData($updateData, $update);
	}

	protected function validateProperties()
	{
		$local_info = $this->getSessionData();

		if (is_single_location() OR (!isset($local_info['location_id']) AND $this->CI->config->item('location_order') != '1')) {
			$local_info['location_id'] = $this->CI->config->item('default_location_id');
			$this->updateSessionData($local_info);
		}

		foreach (['location_id', 'order_type', 'geocode', 'area_id'] as $item) {
			if (isset($local_info[$item]) AND $this->$item != $local_info[$item])
				return $local_info;
		}

		return FALSE;
	}

	protected function setProperties()
	{
		$local_info = $this->getSessionData();

		if ($local = $this->getLocal($local_info)) {
			foreach ($local as $key => $value) {
				if (property_exists($this, $key))
					$this->$key = $value;
			}

			if (!empty($this->CI->permalink) AND $this->CI->config->item('permalink') == '1')
				$this->permalink = $this->CI->permalink->getPermalink('location_id=' . $this->getId());

			$this->setWorkingSchedule();
			$this->setNearestArea();
		} else {
			$this->clearLocal();
		}
	}

	public function currentDate()
	{
		$dateFormat = $this->locationHours()->getDateFormat();

		return mdate($dateFormat, $this->currentTime());
	}

	public function currentTime()
	{
		return $this->locationHours()->getCurrentTime();
	}

	public function getId()
	{
		return $this->location_id;
	}

	public function getName()
	{
		return $this->location_name;
	}

	public function getEmail()
	{
		return strtolower($this->location_email);
	}

	public function getTelephone()
	{
		return $this->location_telephone;
	}

	public function getDescription()
	{
		return $this->local_info['description'];
	}

	public function getSlug()
	{
		return $this->permalink['slug'];
	}

	public function getCity()
	{
		return $this->local_info['location_city'];
	}

	public function getState()
	{
		return $this->local_info['location_state'];
	}

	public function getImage()
	{
		$image_url = null;
		$this->CI->load->model('Image_tool_model');
		if (!empty($this->local_info['location_image'])) {
			$image_url = $this->CI->Image_tool_model->resize($this->local_info['location_image'], '80', '80');
		}

		return $image_url;
	}

	public function getGallery()
	{
		return !empty($this->local_options['gallery']) ? $this->local_options['gallery'] : [];
	}

	public function getAreaId()
	{
		return $this->locationDelivery()->getNearestAreaId();
	}

	public function getAddress($format = TRUE)
	{
		return $this->formatAddress($this->local_info, $format);
	}

	public function getDefaultLocal()
	{
		$main_address = $this->CI->config->item('main_address');

		if (!isset($this->getLocations()[$main_address['location_id']])
			OR !is_array($this->getLocations()[$main_address['location_id']])
		)
			return null;

		return $this->getLocations()[$main_address['location_id']];
	}

	public function formatAddress($address = [], $format = TRUE)
	{
		if (!empty($address) AND is_array($address)) {
			$location_address = [
				'address_1' => isset($address['location_address_1']) ? $address['location_address_1'] : $address['address_1'],
				'address_2' => isset($address['location_address_2']) ? $address['location_address_2'] : $address['address_2'],
				'city'      => isset($address['location_city']) ? $address['location_city'] : $address['city'],
				'state'     => isset($address['location_state']) ? $address['location_state'] : $address['state'],
				'postcode'  => isset($address['location_postcode']) ? $address['location_postcode'] : $address['postcode'],
			];

			$address = $this->CI->country->addressFormat($location_address);

			if ($format === FALSE) {
				$address = str_replace('<br />', ', ', $address);
			}
		}

		return $address;
	}

	public function local()
	{
		return $this->local_info;
	}

	public function isOpened()
	{
		return ($this->workingStatus('opening') === 'open' AND $this->workingStatus('delivery') === 'open' AND $this->workingStatus('collection') === 'open');
	}

	public function isClosed()
	{
		return ($this->workingStatus('opening') === 'closed' AND $this->workingStatus('delivery') === 'closed' AND $this->workingStatus('collection') === 'closed');
	}

	public function openingTime()
	{
		return $this->workingTime('opening', 'open');
	}

	public function closingTime()
	{
		return $this->workingTime('opening', 'close');
	}

	public function hasDelivery()
	{
		return (!empty($this->local_info['offer_delivery']) AND $this->local_info['offer_delivery'] == '1') ? TRUE : FALSE;
	}

	public function hasCollection()
	{
		return (!empty($this->local_info['offer_collection']) AND $this->local_info['offer_collection'] == '1') ? TRUE : FALSE;
	}

	public function hasOrderType($order_type = null)
	{
		return $this->getOrderType($order_type) == self::DELIVERY ? $this->hasDelivery() : $this->hasCollection();
	}

	public function hasSearchQuery()
	{
		return $this->locationGeocode()->hasSearchQuery();
	}

	public function orderType()
	{
		return $this->order_type;
	}

	public function searchQuery($formatted = FALSE)
	{
		$item = ($formatted) ? 'formatted_address' : 'search_query';
		$userPosition = $this->locationGeocode()->findUserPosition();

		return isset($userPosition->$item) ? $userPosition->$item : null;
	}

	//
	//	DELIVERY
	//

	public function deliveryAreas()
	{
		return $this->locationDelivery()->getAreas();
	}

	public function deliveryCharge($cart_total = '0')
	{
		return $this->locationDelivery()->setCartTotal($cart_total)->getChargeDeliveryAmount();
	}

	public function minimumOrder($cart_total = '0')
	{
		return $this->locationDelivery()->setCartTotal($cart_total)->getChargeMinOrderTotal();
	}

	/**
	 * @deprecated since v2.1.1 use Location_delivery->checkChargeCondition() method instead
	 *
	 * @return array|mixed|null
	 */
	public function deliveryCondition($sort_by = 'amounts', $cart_total = FALSE)
	{
		return $this->locationDelivery()->setCartTotal($cart_total)->checkChargeCondition($sort_by);
	}

	public function getAreaChargeSummary()
	{
		return $this->locationDelivery()->getNearestAreaChargeSummary();
	}

	public function getReservationInterval()
	{
		return (!empty($this->local_info['reservation_time_interval'])) ? $this->local_info['reservation_time_interval'] : $this->CI->config->item('reservation_time_interval');
	}

	public function deliveryTime()
	{
		return (!empty($this->local_info['delivery_time'])) ? $this->local_info['delivery_time'] : $this->CI->config->item('delivery_time');
	}

	public function collectionTime()
	{
		return (!empty($this->local_info['collection_time'])) ? $this->local_info['collection_time'] : $this->CI->config->item('collection_time');
	}

	public function lastOrderTime()
	{
		$timeFormat = $this->locationHours()->getTimeFormat();

		return (is_numeric($this->local_info['last_order_time']) AND $this->local_info['last_order_time'] > 0) ? mdate($timeFormat, strtotime($this->closingTime()) - ($this->local_info['last_order_time'] * 60)) : mdate($timeFormat, strtotime($this->closingTime()));
	}

	public function hasFutureOrder()
	{
		$future_orders = (isset($this->local_options['future_orders'])) ? $this->local_options['future_orders'] : $this->CI->config->item('future_orders');

		return ($this->CI->config->item('future_orders') == '1' AND $future_orders == '1') ? TRUE : FALSE;
	}

	public function futureOrderDays($order_type = 'delivery')
	{
		return (!empty($this->local_options['future_order_days'][$order_type])) ? $this->local_options['future_order_days'][$order_type] : '5';
	}

	public function payments($split = '')
	{
		$local_payments = (!empty($this->local_options['payments'])) ? $this->local_options['payments'] : null;

		$payments = [];
		foreach (Components::list_payment_gateways() as $code => $payment) {
			if (!empty($local_payments) AND !in_array($code, $local_payments)) continue;

			$settings = $this->CI->Extensions_model->getSettings($code);
			$payments[$code] = array_merge($payment, [
				'name'        => isset($payment['name']) ? $this->CI->lang->line($payment['name']) : '',
				'description' => isset($payment['description']) ? $this->CI->lang->line($payment['description']) : '',
				'priority'    => !empty($settings['priority']) ? $settings['priority'] : '0',
				'status'      => empty($settings['status']) ? '0' : '1',
			]);
		}

		sort_array($payments);

		return ($payments AND $split !== '') ? implode(array_column($payments, 'name'), $split) : $payments;
	}

	//
	//	HOURS
	//

	/**
	 * @return Location_hours
	 */
	public function locationHours()
	{
		return $this->CI->location_hours;
	}

	public function setWorkingSchedule()
	{
		$this->locationHours()->setWorkingSchedule();
	}

	public function workingType($type = '')
	{
		foreach (['opening', 'delivery', 'collection'] as $value) {
			$working_types[$value] = (empty($this->local_options['opening_hours']["{$value}_type"])) ? '0' : $this->local_options['opening_hours']["{$value}_type"];
		}

		return (!empty($type) AND isset($working_types[$type])) ? $working_types[$type] : $working_types;
	}

	public function workingTime($type = 'opening', $hour = 'open', $format = TRUE)
	{
		return $this->locationHours()->setWorkingType($type)->getWorkingTime($hour, $format);
	}

	public function workingStatus($type = 'opening', $time = null, $hours = [])
	{
		return $this->locationHours()->setWorkingType($type)->checkStatus($time, $hours);
	}

	/**
	 * @deprecated since v2.1.1 use Location_hours->getHours() method instead
	 * @return array|mixed
	 */
	public function workingHours()
	{
		return $this->locationHours()->getHours();
	}

	public function orderTimeRange()
	{
		if ($this->isClosed() OR !$this->checkOrderType()) return null;

		$orderType = $this->getOrderType();
		$days_in_advance = ($this->hasFutureOrder()) ? $this->futureOrderDays($orderType) : '0';

		$startDate = mdate("%d-%m-%Y", strtotime("-1 day", $this->currentTime()));
		$endDate = mdate("%d-%m-%Y", strtotime("+{$days_in_advance} day", $this->currentTime()));

		return $this->locationHours()->setWorkingType($orderType)->getOrderSchedule($startDate, $endDate);
	}

	public function setLocation($location_id, $update_session = TRUE)
	{
		if (is_numeric($location_id) AND $location_id != $this->location_id) {

			$this->updateSessionData(['location_id' => $location_id], $update_session);

			$this->initialize();
		}
	}

	public function setDeliveryArea($area = [])
	{
		if (is_array($area) AND isset($area['boundary']) AND $area['boundary'] != 'outside') {
			$this->updateSessionData($area);
			$this->initialize();
		}
	}

	public function setOrderType($order_type)
	{
		if (is_numeric($order_type)) {
			$this->updateSessionData(['order_type' => $order_type]);
		}
	}

	public function getOrderType($order_type = null)
	{
		$order_type = empty($order_type) ? $this->order_type : $order_type;

		return $order_type == '1' ? self::DELIVERY : self::COLLECTION;
	}

	//
	//	SEARCH AREAS
	//

	/**
	 * @return Location_delivery
	 */
	public function locationDelivery()
	{
		return $this->CI->location_delivery;
	}

	public function setNearestArea($search_query = null)
	{
		$userPosition = $this->locationGeocode()->setSearchQuery($search_query)->findUserPosition();

		$nearestArea = $this->locationDelivery()->setUserPosition($userPosition)->findAndSetNearestArea();

		$sessionArea = $this->locationDelivery()->getSessionNearestArea();
		if (!$this->locationDelivery()->validateSessionNearestArea($sessionArea, $userPosition))
			$this->updateSessionData(['area' => $nearestArea]);
	}

	public function searchRestaurant($search_query = FALSE)
	{
		$userPosition = $this->locationGeocode()->setSearchQuery($search_query)->findUserPosition();

		if (is_string($userPosition))
			return $userPosition;

		$nearestArea = $this->locationDelivery()->setUserPosition($userPosition)->findNearestArea();
		if (empty($nearestArea->position) OR $nearestArea->position == 'outside')
			return 'outside';

		$this->updateSessionData([
			'location_id' => $nearestArea->location_id,
			'geocode'     => $userPosition,
			'area'        => $nearestArea,
		]);

		$this->initialize();

		return (array)$nearestArea;
	}

	public function checkOrderTime($time, $type = self::DELIVERY)
	{
		$status = $this->workingStatus($type, $time);

		return ($status === 'open' OR ($this->hasFutureOrder() AND $status !== 'closed'));
	}

	public function checkOrderType($order_type = '')
	{
		$order_type = $this->getOrderType($order_type);

		$has_future_orders = $this->hasFutureOrder();
		$has_order_type = $this->hasOrderType($order_type);
		$working_status = $this->workingStatus($order_type);

		return !(!$has_order_type OR $working_status === 'closed' OR (!$has_future_orders AND $working_status === 'opening'));
	}

	public function checkMinimumOrder($cart_total)
	{
		return ($cart_total >= $this->minimumOrder($cart_total));
	}

	//
	//	GEOCODE
	//

	/**
	 * @return Location_geocode
	 */
	public function locationGeocode()
	{
		return $this->CI->location_geocode;
	}

	public function checkDistance($decimalPoint = null)
	{
		$currentPosition = $this->locationGeocode()->findUserPosition();

		$distance = $this->locationDelivery()->setUserPosition($currentPosition)
						 ->calculateDistanceToLocation();

		return round($distance, $decimalPoint);
	}

	public function checkDeliveryCoverage($search_query = null)
	{
		$currentPosition = $this->locationGeocode()->setSearchQuery($search_query)->findUserPosition();

		return $this->locationDelivery()->setUserPosition($currentPosition)->checkCoverage();
	}

	/**
	 * @deprecated since v2.1.1 use Location_delivery->findNearestArea() method instead
	 *
	 * @param null $currentPosition
	 *
	 * @return array|null
	 */
	public function checkDeliveryArea($currentPosition = null)
	{
		return $this->locationDelivery()->setUserPosition($currentPosition)->findNearestArea();
	}

	/**
	 * @deprecated since v2.1.1 use Location_geocode->pointInVertices() method instead
	 *
	 * @param $point
	 * @param array $vertices
	 *
	 * @return string
	 */
	public function pointInPolygon($point, $vertices = [])
	{
		return $this->locationGeocode()->pointInVertices($point, $vertices);
	}

	/**
	 * @deprecated since v2.1.1 use Location_geocode->pointInCircle() method instead
	 *
	 * @param $point
	 * @param array $circle
	 *
	 * @return string
	 */
	public function pointInCircle($point, $circle = [])
	{
		return $this->locationGeocode()->pointInCircle($point, $circle);
	}

	/**
	 * @deprecated since v2.1.1 use Location_geocode->findUserPosition() method instead
	 *
	 * @param bool $search_query
	 *
	 * @return \stdClass|string
	 */
	public function getLatLng($search_query = FALSE)
	{
		return $this->locationGeocode()->setSearchQuery($search_query)->findUserPosition();
	}

	public function getLocal($localInfo)
	{
		if (!isset($this->getLocations()[$localInfo['location_id']])
			OR !is_array($this->getLocations()[$localInfo['location_id']])
		)
			return null;

		$location = $this->getLocations()[$localInfo['location_id']];
		$geocode = !empty($localInfo['geocode']) ? $localInfo['geocode'] : null;

		return array_merge($location, [
			'local_options' => $location['options'],
			'local_info'    => $location,
			'geocode'       => $geocode,
			'order_type'    => (isset($localInfo['order_type'])) ? $localInfo['order_type'] : '1',
		]);
	}

	public function getLocations()
	{
		if (empty($this->locationModels)) {
			$this->CI->load->model('Locations_model');
			$this->locationModels = $this->CI->Locations_model->isEnabled()->get();
		}

		$locations = [];
		if (!$this->locationModels->isEmpty()) {
			foreach ($this->locationModels->toArray() as $result) {
				$locations[$result['location_id']] = $result;
			}
		}

		return $locations;
	}

	public function getLocationModels()
	{
		if (empty($this->locationModels))
			$this->getLocations();

		return $this->locationModels;
	}

	public function clearLocal()
	{
		$this->location_id = '';
		$this->location_name = '';
		$this->location_email = '';
		$this->location_telephone = '';
		$this->local_options = [];
		$this->local_info = [];
		$this->geocode = [];
		$this->order_type = '';
		$this->permalink = '';

		$this->CI->session->unset_userdata('local_info');
	}
}

// END Location Class

/* End of file Location.php */
/* Location: ./system/tastyigniter/libraries/Location.php */