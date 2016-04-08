<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package   TastyIgniter
 * @author    SamPoyigi
 * @copyright TastyIgniter
 * @link      http://tastyigniter.com
 * @license   http://opensource.org/licenses/GPL-3.0 The GNU GENERAL PUBLIC LICENSE
 * @since     File available since Release 1.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Location Class
 *
 * @category       Libraries
 * @package        TastyIgniter\Libraries\Location.php
 * @link           http://docs.tastyigniter.com
 */
class Location {
	private $locations = array();
	private $location_id;
	private $location_name;
	private $location_email;
	private $location_telephone;
	private $local_options;
	private $local_info;
	private $search_query;
	private $user_coords;
	private $area_id;
	private $order_type;
	private $polygons = array();
	private $delivery_areas = array();
	private $delivery_area = array();
	private $working_hours = array();
    private $working_hour = array();
	public $dateFormat = "%d/%m/%Y";
	public $timeFormat = "%H:%i";
	private $current_day;
	private $current_time;
    private $permalink;

	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->database();
		$this->CI->load->helper('date');
		$this->CI->load->model('Locations_model');

		$this->current_day = date('l');
		$this->current_time = time();

	    $this->dateFormat = ($this->CI->config->item('date_format')) ? $this->CI->config->item('date_format') : $this->dateFormat;
	    $this->timeFormat = ($this->CI->config->item('time_format')) ? $this->CI->config->item('time_format') : $this->timeFormat;

		!empty($this->locations) OR $this->locations = $this->getLocations();
    }

	public function initialize($local_info = array()) {
		$local_info = empty($local_info) ? $this->CI->session->userdata('local_info') : $local_info;

		if (!isset($local_info['location_id']) AND $this->CI->config->item('location_order') !== '1') {
			$local_info['location_id'] = $this->CI->config->item('default_location_id');
		}

		$is_loaded = TRUE;
		foreach (array('location_id', 'order_type', 'search_query', 'area_id') as $item) {
			if (isset($local_info[$item]) AND $this->$item !== $local_info[$item]) {
				$is_loaded = FALSE;
				break;
			}
		}

		if (!$is_loaded) {
			if (!isset($local_info['location_id']) OR empty($this->locations[$local_info['location_id']])) {
				$this->clearLocal();
			}

			if (is_array($this->locations[$local_info['location_id']])) {
				$location = $this->locations[$local_info['location_id']];

				$this->location_id = $location['location_id'];
				$this->location_name = $location['location_name'];
				$this->location_email = $location['location_email'];
				$this->location_telephone = $location['location_telephone'];
				$this->local_options = (!empty($location['options'])) ? unserialize($location['options']) : array();
				$this->local_info = $location;
				$this->search_query = (empty($local_info['search_query'])) ? '' : $local_info['search_query'];
				$this->area_id = (empty($local_info['area_id'])) ? '' : $local_info['area_id'];
				$this->order_type = (isset($local_info['order_type'])) ? $local_info['order_type'] : '1';

				if (!empty($this->CI->permalink) AND $this->CI->config->item('permalink') === '1') {
					$this->permalink = $this->CI->permalink->getPermalink('location_id=' . $location['location_id']);
				}

				$this->setWorkingHours();
				$this->setDeliveryAreas();

				$this->delivery_area = $this->checkDeliveryArea();
			}
		}
	}

	public function currentDate() {
		return mdate($this->dateFormat, $this->current_time);
	}

	public function currentTime() {
		return $this->current_time;
	}

	public function getId() {
		return $this->location_id;
	}

	public function getName() {
		return $this->location_name;
	}

	public function getEmail() {
		return strtolower($this->location_email);
	}

	public function getTelephone() {
		return $this->location_telephone;
	}

	public function getDescription() {
		return $this->local_info['description'];
	}

	public function getSlug() {
		return $this->permalink['slug'];
	}

	public function getCity() {
		return $this->local_info['location_city'];
	}

	public function getState() {
		return $this->local_info['location_state'];
	}

	public function getImage() {
        $this->CI->load->model('Image_tool_model');
        if (!empty($this->local_info['location_image'])) {
            return $this->CI->Image_tool_model->resize($this->local_info['location_image'], '80', '80');
        }

        return $this->CI->Image_tool_model->resize('data/no_photo.png', '80', '80');
	}

	public function getGallery() {
        return !empty($this->local_options['gallery']) ? $this->local_options['gallery'] : array();
	}

	public function getAreaId() {
        return $this->area_id;
	}

	public function getAddress($format = TRUE) {
		$location_address = array(
			'address_1'      => $this->local_info['location_address_1'],
			'address_2'      => $this->local_info['location_address_2'],
			'city'           => $this->local_info['location_city'],
			'state'          => $this->local_info['location_state'],
			'postcode'       => $this->local_info['location_postcode']
		);

		$this->CI->load->library('country');
		$address = $this->CI->country->addressFormat($location_address);

		if ($format === FALSE) {
			$address = str_replace('<br />', ', ', $address);
		}

		return $address;
	}

	public function getDefaultLocal() {
		$main_address = $this->CI->config->item('main_address');

		if (!empty($main_address) AND is_array($main_address)) {
			if (isset($this->locations[$main_address['location_id']])
				AND is_array($this->locations[$main_address['location_id']])) {

				$location = $this->locations[$main_address['location_id']];

				return $location;
			}
		}
	}

	public function formatAddress($address = array(), $format = TRUE) {
		if (!empty($address) AND is_array($address)) {
			$location_address = array(
				'address_1'      => $address['location_address_1'],
				'address_2'      => $address['location_address_2'],
				'city'           => $address['location_city'],
				'state'          => $address['location_state'],
				'postcode'       => $address['location_postcode']
			);

			$this->CI->load->library('country');
			$address = $this->CI->country->addressFormat($location_address);

			if ($format === FALSE) {
				$address = str_replace('<br />', ', ', $address);
			}
		}

		return $address;
	}

	public function local() {
		return $this->local_info;
	}

	public function isOpened() {
		return ($this->workingStatus('opening') === 'open' AND $this->workingStatus('delivery') === 'open' AND $this->workingStatus('collection') === 'open');
	}

	public function isClosed() {
		return ($this->workingStatus('opening') === 'closed' AND $this->workingStatus('delivery') === 'closed' AND $this->workingStatus('collection') === 'closed');
	}

	/**
	 * @deprecated since 2.0 use workingStatus instead
	 */
	public function openingStatus() {
		return empty($this->working_hour['opening']['status']) ? '0' : $this->working_hour['opening']['status'];
	}

	public function openingTime() {
        return $this->workingTime('opening', 'open');
    }

	public function closingTime() {
		return $this->workingTime('opening', 'close');
	}

	public function hasDelivery() {
    	return (!empty($this->local_info['offer_delivery']) AND $this->local_info['offer_delivery'] === '1') ? TRUE : FALSE;
	}

	public function hasCollection() {
    	return (!empty($this->local_info['offer_collection']) AND $this->local_info['offer_collection'] === '1') ? TRUE : FALSE;
	}

	public function hasSearchQuery() {
		return (empty($this->search_query)) ? FALSE : TRUE;
	}

	public function orderType() {
		return $this->order_type;
	}

	public function searchQuery() {
		return $this->search_query;
	}

	public function deliveryAreas() {
		return $this->delivery_areas;
	}

	public function deliveryCharge() {
    	return (!empty($this->delivery_areas[$this->area_id]['charge'])) ? $this->delivery_areas[$this->area_id]['charge'] : 0;
	}

	public function minimumOrder() {
    	return (!empty($this->delivery_areas[$this->area_id]['min_amount'])) ? $this->delivery_areas[$this->area_id]['min_amount'] : 0;
	}

	public function getReservationInterval() {
    	return (!empty($this->local_info['reservation_time_interval'])) ? $this->local_info['reservation_time_interval'] : $this->CI->config->item('reservation_time_interval');
	}

	public function deliveryTime() {
		return (!empty($this->local_info['delivery_time'])) ? $this->local_info['delivery_time'] : $this->CI->config->item('delivery_time');
	}

	public function collectionTime() {
		return (!empty($this->local_info['collection_time'])) ? $this->local_info['collection_time'] : $this->CI->config->item('collection_time');
	}

	public function lastOrderTime() {
		return (is_numeric($this->local_info['last_order_time']) AND $this->local_info['last_order_time'] > 0) ? mdate($this->timeFormat, strtotime($this->closingTime()) - ($this->local_info['last_order_time'] * 60)) : mdate($this->timeFormat, strtotime($this->closingTime()));
	}

	public function hasFutureOrder() {
		$future_orders = (isset($this->local_options['future_orders'])) ? $this->local_options['future_orders'] : $this->CI->config->item('future_orders');

		return ($this->CI->config->item('future_orders') === '1' AND $future_orders === '1') ? TRUE : FALSE;
	}

	public function futureOrderDays($order_type = 'delivery') {
		return (!empty($this->local_options['future_order_days'][$order_type])) ? $this->local_options['future_order_days'][$order_type] : '5';
	}

	public function payments($split = '') {
		$payments = (!empty($this->local_options['payments'])) ? $this->local_options['payments'] : NULL;

        return ($payments AND $split !== '') ? implode($payments, $split) : $payments;
	}

	public function workingType($type = '') {
		foreach (array('opening', 'delivery', 'collection') as $value) {
			$working_types[$value] = (empty($this->local_options['opening_hours']["{$value}_type"])) ? '0' : $this->local_options['opening_hours']["{$value}_type"];
		}

		return (!empty($type) AND isset($working_types[$type])) ? $working_types[$type] : $working_types;
	}

	public function workingTime($type = 'opening', $hour = 'open', $format = TRUE) {
		$working_time = FALSE;

		if (!empty($this->working_hour[$type]) AND !empty($this->working_hour[$type][$hour])) {
			if ($this->working_hour[$type]['day'] === $this->current_day) {
				$working_time = mdate($this->timeFormat, $this->working_hour[$type][$hour]);
			} else {
				$working_time = mdate('%D ' . $this->timeFormat, $this->working_hour[$type][$hour]);
			}

			$working_time = (!$format) ? strtotime($working_time) : $working_time;
		}

		return $working_time;
	}

	public function workingStatus($type = 'opening', $time = '', $hours = array()) {
		$last_order_time = (is_numeric($this->local_info['last_order_time']) AND $this->local_info['last_order_time'] > 0) ? $this->local_info['last_order_time'] * 60 : 0;
		$working_hour = (isset($this->working_hour[$type])) ? $this->working_hour[$type] : array();
		$time = !empty($time) ? strtotime($time) : $this->current_time;
		$hours = !empty($hours) ? $hours : $working_hour;

		$status = 'closed';

		if ( ! empty($hours) AND $hours['status'] === '1') {
			$open = $hours['open'];
			$close = $hours['close'];

			if ($type === 'delivery' OR $type === 'collection') {
				$close = $close - $last_order_time;
			}

			if ($open > $close) $close = $close + 86400;

			if ($time >= $open AND $time <= $close) $status = 'open';

			if ($time <= $open AND $time <= $close) $status = 'opening';
		}

		return $status;
	}

	public function workingHours($type = '') {
		$working_hours = array();

		if (!empty($type)) {
			$working_hours[$type] = (isset($this->working_hours[$type])) ? $this->working_hours[$type] : $this->working_hours['opening'];
		} else {
			$working_hours = $this->working_hours;
		}

		foreach (array('opening', 'delivery', 'collection') as $value) {
			if (isset($working_hours[$value])) foreach ($working_hours[$value] as $day => &$hour) {
				$hour['description'] = '';
				if ($hour['status'] !== '1') {
					$hour['info'] = 'closed';
				} else if ($hour['status'] === '1' AND $hour['opening_time'] === '00:00:00' AND $hour['closing_time'] === '23:59:00') {
					$hour['info'] = '24_hours';
				}

				$hour['open'] = mdate($this->timeFormat, $hour['open']);
				$hour['close'] = mdate($this->timeFormat, $hour['close']);
			}
		}

		return $working_hours;
	}

	public function orderTimeRange() {
		if ($this->isClosed() OR !$this->checkOrderType()) return NULL;

		if ($this->order_type === '1') {
			$order_type = 'delivery';
			$time_interval = $this->deliveryTime();
		} else {
			$order_type = 'collection';
			$time_interval = $this->collectionTime();
		}

		$days_in_advance = ($this->hasFutureOrder()) ? $this->futureOrderDays($order_type) : '0';
		$start_date = mdate("%d-%m-%Y", strtotime("-1 day", $this->current_time));
		$end_date = mdate("%d-%m-%Y", strtotime("+{$days_in_advance} day", $this->current_time));
		$working_hours = $this->parseWorkingHours($order_type, $start_date, $end_date, $this->working_hours);

		$count = 1;
		foreach ($working_hours as $date => $hour) {
			if ($hour['open'] > $hour['close']) $hour['close'] = $hour['close'] + 86400;

			$start_time = mdate("%d-%m-%Y %H:%i", $hour['open'] + ($time_interval * 60));
			$end_time = mdate("%d-%m-%Y %H:%i", $hour['close'] - ($this->local_info['last_order_time'] * 60));
			$time_ranges = time_range($start_time, $end_time, $time_interval, "%d-%m-%Y %H:%i");
			array_pop($time_ranges);

			foreach ($time_ranges as $time) {
				if (strtotime($time) >= ($this->current_time + ($time_interval * 60))) {
					if ($hour['working_status'] === 'open' AND $count === 1) {
						$order_times['asap'] = $time;
					} else {
						$dt = mdate('%d-%m-%Y', strtotime($time));
						$hr = mdate('%H', strtotime($time));
						$order_times[$dt][$hr][] = mdate('%i', strtotime($time));
					}

					$count++;
				}
			}
		}

		return $order_times;
	}

	public function setLocation($location_id, $update_session = TRUE) {
		if (is_numeric($location_id) AND $location_id !== $this->location_id) {
            $local_info = $this->CI->session->userdata('local_info');

			$local_info['location_id'] = $location_id;
			if ($update_session) $this->CI->session->set_userdata('local_info', $local_info);

			$this->initialize($local_info);
		}
	}

	public function setOrderType($order_type) {
		if (is_numeric($order_type)) {
			$local_info = $this->CI->session->userdata('local_info');

			$local_info['order_type'] = $this->order_type = $order_type;
			$this->CI->session->set_userdata('local_info', $local_info);
		}
	}

	public function setDeliveryArea($area = array()) {
		$area = is_numeric($area) ? array('location_id' => $this->location_id, 'area_id' => $area) : $area;

		if ($area !== 'outside' AND count($area) == 2 AND $area['area_id'] !== $this->area_id) {
			$local_info = $this->CI->session->userdata('local_info');

			$local_info['location_id'] = $area['location_id'];
			$local_info['area_id'] = $this->area_id =$area['area_id'];

			$this->CI->session->set_userdata('local_info', $local_info);
		}
	}

	public function searchRestaurant($search_query = FALSE) {																// method to perform regular expression match on postcode string and return latitude and longitude
		$output = $this->getLatLng($search_query);

		if (is_string($output)) {
			return $output;
		}

		$delivery_area = $this->checkDeliveryArea($output);
		if ($delivery_area !== 'outside' AND count($delivery_area) == 2) {
			$local_info = array('location_id' => $delivery_area['location_id'], 'area_id' => $delivery_area['area_id'], 'search_query' => $output['search_query']);
			$this->CI->session->set_userdata('local_info', $local_info);

			$this->initialize($local_info);
		}

		return $delivery_area;
	}

	public function checkOrderTime($time, $type = 'delivery') {
		$status = $this->workingStatus($type, $time);

		return ($status === 'open' OR ($this->hasFutureOrder() AND $status !== 'closed'));
	}

	public function checkOrderType($order_type = '') {
		$order_type = empty($order_type) ? $this->order_type : $order_type;

		if ($order_type === '1') {
			$has_order_type = $this->hasDelivery();
			$type = 'delivery';
		} else {
			$has_order_type = $this->hasCollection();
			$type = 'collection';
		}

		$working_status = $this->workingStatus($type);
		$has_future_orders = $this->hasFutureOrder();

		return ! ( ! $has_order_type OR $working_status === 'closed' OR ( ! $has_future_orders AND $working_status === 'opening'));
	}

	public function checkMinimumOrder($cart_total) {
		return ($cart_total >= $this->minimumOrder());
	}

	public function checkDistance() {
		$distance = 0;
		$coords = $this->getLatLng($this->search_query);

		if (isset($coords['lat'], $coords['lng'], $this->local_info['location_lat'], $this->local_info['location_lng'])) {
			$degrees = sin(deg2rad($coords['lat'])) * sin(deg2rad($this->local_info['location_lat'])) +
				cos(deg2rad($coords['lat'])) * cos(deg2rad($this->local_info['location_lat'])) * cos(deg2rad($coords['lng'] - $this->local_info['location_lng']));

			$distance = rad2deg(acos($degrees));

			if ($this->CI->config->item('distance_unit') === 'km') {
				return ($distance * 111.13384);
			} else {
				return ($distance * 69.05482);
			}
		}

		return $distance;
	}

    public function checkDeliveryCoverage($search_query = FALSE) {

		$search_query = ($search_query === FALSE) ? $this->search_query : $search_query;

		$coords = $this->getLatLng($search_query);
		$delivery_area = $this->checkDeliveryArea($coords);

		if ($delivery_area !== 'outside' AND count($delivery_area) == 2 AND $delivery_area['location_id'] === $this->location_id) {
			return $delivery_area;
		}

		return FALSE;
	}

	public function checkDeliveryArea($coords = '') {
		$location = $point = '';

		!empty($coords) OR $coords = $this->getLatLng($this->search_query);

		if (is_array($coords) AND count($coords) == 3) {
			$point = $coords['lat'].'|'.$coords['lng'];

			$polygons = $this->getPolygons();
			foreach ($polygons as $location_id => $areas) {
				foreach ($areas as $area_id => $area) {
					if (isset($area['vertices']) AND isset($area['circle']) AND isset($area['type'])) {
						if ($area['type'] == 'shape') {
							$location = ($this->pointInPolygon($point, $area['vertices']) === 'outside') ? '' : $location_id;
						} else if ($area['type'] == 'circle') {
							$location = ($this->pointInCircle($point, $area['circle']) === FALSE) ? '' : $location_id;
						}
					}

					if ($location !== '') {
						$delivery_area = array('location_id' => $location_id, 'area_id' => $area_id);
						break 2;
					}
				}
			}
		}

		return (empty($delivery_area)) ? 'outside' : $delivery_area;
	}

    public function pointInPolygon($point, $vertices = array(), $pointOnVertex = TRUE) {
        // Transform string coordinates into arrays with x and y values
        $point = $this->_coordsStringToArray($point);

		// Check if the point sits exactly on a vertex
		if ($pointOnVertex === TRUE AND $this->_pointOnVertex($point, $vertices) === TRUE) {
			return "vertex";
		}

		// Check if the point is inside the polygon or on the boundary
		$intersections = 0;

		for ($i = 1; $i < count($vertices); $i++) {
			$vertex1 = $vertices[$i-1];
			$vertex2 = $vertices[$i];

			if ($vertex1['y'] == $vertex2['y']
			AND $vertex1['y'] == $point['y']
			AND $point['x'] > min($vertex1['x'], $vertex2['x'])
			AND $point['x'] < max($vertex1['x'], $vertex2['x'])) {
				return "boundary";
			}

			if ($point['y'] > min($vertex1['y'], $vertex2['y'])
			AND $point['y'] <= max($vertex1['y'], $vertex2['y'])
			AND $point['x'] <= max($vertex1['x'], $vertex2['x'])
			AND $vertex1['y'] != $vertex2['y']) {

				$xinters = ($point['y'] - $vertex1['y']) * ($vertex2['x'] - $vertex1['x']) / ($vertex2['y'] - $vertex1['y']) + $vertex1['x'];

				// Check if point is on the polygon boundary (other than horizontal)
				if ($xinters == $point['x']) {
					return "boundary";
				}

				if ($vertex1['x'] == $vertex2['x'] OR $point['x'] <= $xinters) {
					$intersections++;
				}
			}
		}

		// If the number of edges we passed through is odd, then it's in the polygon.
		if ($intersections % 2 != 0) {
			return "inside";
		} else {
			return "outside";
		}
    }

	public function pointInCircle($point, $circle = array()) {
        $point = $this->_coordsStringToArray($point);
        $center = $this->_coordsStringToArray($circle['center']);
		$earth_radius = ($this->CI->config->item('distance_unit') === 'km') ? 6371 : 3959;
		$radius = ($this->CI->config->item('distance_unit') === 'km') ? $circle['radius']/1000 : $circle['radius']/1609.344;

		$dLat = deg2rad($center['y'] - $point['y']);
		$dLon = deg2rad($center['x'] - $point['x']);

		$a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($point['y'])) * cos(deg2rad($center['y'])) * sin($dLon/2) * sin($dLon/2);
		$c = 2 * asin(sqrt($a));
		$distance = $earth_radius * $c;

		return ($distance <= $radius) ? TRUE : FALSE;
	}

    public function _pointOnVertex($point, $vertices) {
        foreach ($vertices as $vertex) {
            if ($point == $vertex) {
                return TRUE;
            }
        }

    }

    public function _coordsStringToArray($coordsString) {
        $coordinates = explode('|', $coordsString);
        return array('y' => $coordinates[0], 'x' => $coordinates[1]);
    }

    public function getPolygons() {
		if (empty($this->polygons)) {
			$polygons = array();

			foreach ($this->locations as $result) {
				$options = (!empty($result['options'])) ? unserialize($result['options']) : array();

				if (!empty($options['delivery_areas']) AND is_array($options['delivery_areas'])) {
					foreach ($options['delivery_areas'] as $key => $area) {
						$vertices = (!empty($area['vertices'])) ? json_decode($area['vertices']) : array();
						$circle = (!empty($area['circle'])) ? json_decode($area['circle']) : array();

						foreach ($vertices as $vertex) {
							$polygons[$result['location_id']][$key]['vertices'][] = array('x' => $vertex->lng, 'y' => $vertex->lat);
						}

						if (isset($circle[0]->center) AND isset($circle[1]->radius)) {
							$polygons[$result['location_id']][$key]['circle'] = array('center' => $circle[0]->center->lat.'|'.$circle[0]->center->lng, 'radius' => $circle[1]->radius);
						}

						$polygons[$result['location_id']][$key]['type'] = $area['type'];
					}
				}
			}

			$this->polygons = $polygons;
    	}

    	return $this->polygons;
    }

	public function getLatLng($search_query = FALSE) {																// method to perform regular expression match on postcode string and return latitude and longitude
		if (empty($search_query)) {
			return "NO_SEARCH_QUERY";
		}

		if (isset($this->user_coords['search_query']) AND $this->user_coords['search_query'] === $search_query) {
			return $this->user_coords;
		}

		$temp_query = $search_query;

		if (is_string($temp_query)) {
			$postcode = strtoupper(str_replace(' ', '', $temp_query));								// strip spaces from postcode string and convert to uppercase

			if (preg_match("/^[A-Z]{1,2}[0-9]{2,3}[A-Z]{2}$/", $postcode) OR
			preg_match("/^[A-Z]{1,2}[0-9]{1}[A-Z]{1}[0-9]{1}[A-Z]{2}$/", $postcode) OR
			preg_match("/^GIR0[A-Z]{2}$/", $postcode)) {
				$temp_query = $postcode;
			} else {
				$temp_query = explode(' ', $temp_query);
			}
		}

        $temp_query = (is_array($temp_query)) ? implode(', ', $temp_query) : $temp_query;

        $url  = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($temp_query) .'&sensor=false'; //encode $postcode string and construct the url query
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
		curl_setopt($ch, CURLOPT_USERAGENT, $this->CI->agent->agent_string());
		$geocode_data = curl_exec($ch);
		curl_close($ch);

		$output = json_decode($geocode_data);											// decode the geocode data

		if ($output) {
            if ($output->status === 'OK') {														// create variable for geocode data status
                $this->user_coords = array(
                    'search_query'	=> $search_query,
                    'lat' 			=> $output->results[0]->geometry->location->lat,
                    'lng' 			=> $output->results[0]->geometry->location->lng
                );

				return $this->user_coords;
		    }

            return "INVALID_SEARCH_QUERY";
        }

		return "FAILED";
    }

	private function getLocations() {
		if (empty($this->locations)) {
			$this->CI->load->model('Locations_model');
			$locations = $this->CI->Locations_model->getLocations();

			foreach ($locations as $result) {
				$this->locations[$result['location_id']] = $result;
			}
		}

		return $this->locations;
	}

	private function getWorkingHours() {
		if (empty($this->working_hours) OR empty($this->working_hours['opening'][0]['location_id']) OR $this->working_hours['opening'][0]['location_id'] !== $this->location_id) {
			$this->CI->load->model('Locations_model');
			$working_hours = $this->CI->Locations_model->getWorkingHours($this->location_id);

			$weekdays = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');

			foreach ($working_hours as $result) {
				$type = !empty($result['type']) ? $result['type'] : 'opening';

				$this->working_hours[$type][$result['weekday']] = array(
					'location_id' => $result['location_id'],
					'day' => $weekdays[$result['weekday']],
					'type' => $type,
					'open' => strtotime("{$weekdays[$result['weekday']]} {$result['opening_time']}"),
					'close' => strtotime("{$weekdays[$result['weekday']]} {$result['closing_time']}"),
					'opening_time' => $result['opening_time'],
					'closing_time' => $result['closing_time'],
					'status' => $result['status']
				);
			}
		}

		return $this->working_hours;
	}

	private function setWorkingHours() {
		$working_hours = $this->getWorkingHours();

		foreach (array('opening', 'delivery', 'collection') as $type) {
			if ($type !== 'opening' AND empty($working_hours[$type]) AND !empty($working_hours['opening'])) {
				$working_hours[$type] = $working_hours['opening'];
			}

			$start_date = mdate("%d-%m-%Y", strtotime("-1 day", $this->current_time));
			$end_date = mdate("%d-%m-%Y", strtotime("+7 day", $this->current_time));
			$this->working_hour[$type] = $this->parseWorkingHours($type, $start_date, $end_date, $working_hours, TRUE);
		}

		$this->working_hours = $working_hours;
	}

	private function parseWorkingHours($type, $start_date, $end_date, $working_hours, $return = FALSE) {
		$result = array();

		while (strtotime($start_date) <= strtotime($end_date)) {
			$day = mdate('%N', strtotime($start_date))-1;

			if (isset($working_hours[$type][$day])) {
				$hour = $working_hours[$type][$day];
				$hour['open'] = strtotime("{$start_date} {$hour['opening_time']}");
				$hour['close'] = strtotime("{$start_date} {$hour['closing_time']}");
				$hour['working_status'] = $this->workingStatus($type, '', $hour);

				if ($hour['working_status'] !== 'closed') {

					if ($return) return $hour;

					$result[$start_date] = $hour;
				}
			}

			$start_date = mdate("%d-%m-%Y", strtotime("+1 day", strtotime($start_date)));
		}

		return $result;
	}

	private function setDeliveryAreas() {
		if (isset($this->local_options['delivery_areas']) AND is_array($this->local_options['delivery_areas'])) {
			foreach ($this->local_options['delivery_areas'] as $area_id => $area) {
				$this->delivery_areas[$area_id] = array(
					'area_id'		=> $area_id,
					'name'			=> $area['name'],
					'type'			=> $area['type'],
					'shape'			=> $area['shape'],
					'circle'		=> $area['circle'],
					'charge'		=> $area['charge'],
					'min_amount'	=> $area['min_amount']
				);
			}
		}
	}

	public function clearLocal() {
		$this->location_id = '';
		$this->location_name = '';
		$this->location_email = '';
		$this->location_telephone = '';
		$this->local_options = array();
		$this->local_info = array();
		$this->search_query = '';
		$this->area_id = '';
		$this->order_type = '';
		$this->polygons = array();
		$this->delivery_areas = array();
		$this->delivery_area = array();
		$this->working_hour = array();
		$this->permalink = '';

		$this->CI->session->unset_userdata('local_info');
	}
}

// END Location Class

/* End of file Location.php */
/* Location: ./system/tastyigniter/libraries/Location.php */