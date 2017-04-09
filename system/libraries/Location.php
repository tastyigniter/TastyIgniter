<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package Igniter
 * @author Samuel Adepoyigi
 * @copyright (c) 2013 - 2016. Samuel Adepoyigi
 * @copyright (c) 2016 - 2017. TastyIgniter Dev Team
 * @link https://tastyigniter.com
 * @license http://opensource.org/licenses/MIT The MIT License
 * @since File available since Release 1.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Location Class
 *
 * @category       Libraries
 * @package        Igniter\Libraries\Location.php
 * @link           http://docs.tastyigniter.com
 */
class Location
{
	const DELIVERY = 'delivery';
	const COLLECTION = 'collection';

	public $location_id;
	public $location_name;
	public $location_email;
	public $location_telephone;
	public $local_options;
	public $local_info;
	public $order_type;
	public $permalink;
	protected $locationModels;
	protected $tempSessionData;
	protected static $orderTypes = [];

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

		self::$orderTypes = [1 => self::DELIVERY, 2 => self::COLLECTION];
	}

	public function initialize()
	{
		if ($this->validateProperties()) {
			$this->setProperties();
		}

		$this->tempSessionData = null;
	}

	protected function validateProperties()
	{
		$local_info = $this->getSessionData();

		if (is_single_location() OR (!isset($local_info['location_id']) AND $this->CI->config->item('location_order') != '1')) {
			if (!isset($local_info['location_id']) OR $this->CI->config->item('default_location_id') != $local_info['location_id']) {
				$local_info['location_id'] = $this->CI->config->item('default_location_id');
				$this->updateSessionData($local_info);
			}
		}

		if ($local_info) foreach ($local_info as $item => $value) {
			if (property_exists($this, $item) AND $this->$item != $value)
				return TRUE;
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

			if (isset($local['order_type'])) $this->setOrderType($local['order_type']);

			$this->setWorkingSchedule();
			$this->setNearestArea();

			if (!empty($this->CI->permalink) AND $this->CI->config->item('permalink') == '1')
				$this->permalink = $this->CI->permalink->getPermalink('location_id=' . $this->getId());
		} else {
			$this->clearLocal();
		}
	}

	public function getLocal($localInfo)
	{
		$allLocations = $this->getLocations();
		if (!isset($allLocations[$localInfo['location_id']]) OR !is_array($allLocations[$localInfo['location_id']]))
			return null;

		$location = $allLocations[$localInfo['location_id']];
		return array_merge($location, [
			'local_options' => $location['options'],
			'local_info'    => $location,
			'order_type'    => (isset($localInfo['order_type'])) ? $localInfo['order_type'] : self::DELIVERY,
		]);
	}

	public function setWorkingSchedule()
	{
		$this->locationHours()->setWorkingSchedule();
	}

	public function setNearestArea()
	{
		$userPosition = $this->locationGeocode()->findUserPosition();

		$nearestArea = $this->locationDelivery()->setUserPosition($userPosition)->findAndSetNearestArea();

		if ($this->locationDelivery()->hasNearestAreaChanged($nearestArea))
			$this->updateSessionData(['area' => $nearestArea]);
	}

	//
	//	BOOT METHODS
	//

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

	public function setOrderType($orderType = null)
	{
		if (is_numeric($orderType))
			$orderType = self::$orderTypes[$orderType];

		if (!is_string($orderType))
			$orderType = self::DELIVERY;

		$this->order_type = $orderType;
		$this->updateSessionData(['order_type' => $orderType]);
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

	public function updateSessionData($data, $update = TRUE)
	{
		$localInfo = $this->getSessionData();

		$updateData = [];
		foreach (['location_id', 'order_type', 'geocode', 'area'] as $item) {
			if (isset($data[$item])) {
				$updateData[$item] = $data[$item];
			} else if (isset($localInfo[$item])) {
				$updateData[$item] = $localInfo[$item];
			}
		}

		$this->setSessionData($updateData, $update);
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

	//
	//	HELPER METHODS
	//

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

	public function orderType()
	{
		$this->setOrderType($this->order_type);
		$orderTypes = array_flip(self::$orderTypes);
		return $orderTypes[$this->order_type];
	}

	public function getOrderType()
	{
		return $this->order_type;
	}

	public function getOrderTypeName($order_type)
	{
		if (is_numeric($order_type) AND isset(self::$orderTypes[$order_type]))
			$order_type = self::$orderTypes[$order_type];

		return $order_type;
	}

	public function openingTime()
	{
		return $this->workingTime('opening', 'open');
	}

	public function closingTime()
	{
		return $this->workingTime('opening', 'close');
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

	public function futureOrderDays($order_type = 'delivery')
	{
		return (!empty($this->local_options['future_order_days'][$order_type])) ? $this->local_options['future_order_days'][$order_type] : '5';
	}

	public function hasDelivery()
	{
		return (!empty($this->local_info['offer_delivery']) AND $this->local_info['offer_delivery'] == '1') ? TRUE : FALSE;
	}

	public function hasCollection()
	{
		return (!empty($this->local_info['offer_collection']) AND $this->local_info['offer_collection'] == '1') ? TRUE : FALSE;
	}

	public function hasFutureOrder()
	{
		$future_orders = (isset($this->local_options['future_orders'])) ? $this->local_options['future_orders'] : $this->CI->config->item('future_orders');

		return ($this->CI->config->item('future_orders') == '1' AND $future_orders == '1') ? TRUE : FALSE;
	}

	public function hasOrderType($order_type = null)
	{
		return $this->getOrderTypeName($order_type) == self::DELIVERY ? $this->hasDelivery() : $this->hasCollection();
	}

	public function hasSearchQuery()
	{
		return $this->locationGeocode()->hasSearchQuery();
	}

	public function searchQuery($formatted = FALSE)
	{
		$item = ($formatted) ? 'formatted_address' : 'search_query';
		$userPosition = $this->locationGeocode()->findUserPosition();

		return isset($userPosition->$item) ? $userPosition->$item : null;
	}

	public function checkOrderType($order_type = '')
	{
		$order_type = $this->getOrderTypeName($order_type);
		$order_type = !empty($order_type) ? $order_type : $this->getOrderType();

		$has_future_orders = $this->hasFutureOrder();
		$has_order_type = $this->hasOrderType($order_type);
		$working_status = $this->workingStatus($order_type);

		return !(!$has_order_type OR $working_status === 'closed' OR (!$has_future_orders AND $working_status === 'opening'));
	}

	public function payments($split = '')
	{
		$local_payments = (!empty($this->local_options['payments'])) ? $this->local_options['payments'] : null;

		$payments = [];
		foreach (Components::listPaymentGateways() as $code => $payment) {
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

	public function workingType($hourType = '')
	{
		$working_types = [];
		foreach (['opening', 'delivery', 'collection'] as $value) {
			$working_types[$value] = (empty($this->local_options['opening_hours']["{$value}_type"])) ? '0' : $this->local_options['opening_hours']["{$value}_type"];
		}

		return (!empty($type) AND isset($working_types[$type])) ? $working_types[$type] : $working_types;
	}

	public function workingSchedule($type = 'opening')
	{
		$workingSchedule = $this->locationHours()->getWorkingSchedule();
		if (isset($workingSchedule[$type]))
			$workingSchedule = $workingSchedule[$type];

		return $workingSchedule;
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

	public function checkOrderTime($time, $type = self::DELIVERY)
	{
		$status = $this->workingStatus($type, $time);

		return ($status === 'open' OR ($this->hasFutureOrder() AND $status !== 'closed'));
	}

	//
	//	DELIVERY & GEOCODE
	//

	/**
	 * @return Location_delivery
	 */
	public function locationDelivery()
	{
		return $this->CI->location_delivery;
	}

	/**
	 * @return Location_geocode
	 */
	public function locationGeocode()
	{
		return $this->CI->location_geocode;
	}

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

	public function getAreaChargeSummary()
	{
		return $this->locationDelivery()->getNearestAreaChargeSummary();
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

		return (array)$this->locationDelivery()->setUserPosition($currentPosition)->checkCoverage();
	}

	public function checkMinimumOrder($cart_total)
	{
		return ($cart_total >= $this->minimumOrder($cart_total));
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

	/**
	 * @deprecated since v2.1.1 use Location_delivery->findNearestArea() method instead
	 *
	 * @param null $currentPosition
	 *
	 * @return object|null
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
		$this->order_type = '';
		$this->permalink = '';

		$this->CI->session->unset_userdata('local_info');
	}
}

// END Location Class

/* End of file Location.php */
/* Location: ./system/tastyigniter/libraries/Location.php */