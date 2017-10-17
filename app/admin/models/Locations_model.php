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
 */
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Locations Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Locations_model.php
 * @link           http://docs.tastyigniter.com
 */
class Locations_model extends TI_Model {

	public function getCount($filter = array()) {
		if ( ! empty($filter['filter_search'])) {
			$this->db->like('location_name', $filter['filter_search']);
			$this->db->or_like('location_city', $filter['filter_search']);
			$this->db->or_like('location_state', $filter['filter_search']);
			$this->db->or_like('location_postcode', $filter['filter_search']);
		}

		if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
			$this->db->where('location_status', $filter['filter_status']);
		}

		$this->db->from('locations');

		return $this->db->count_all_results();
	}

	public function getList($filter = array()) {
		if ( ! empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

		if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->from('locations');

			if ( ! empty($filter['sort_by']) AND ! empty($filter['order_by'])) {
				$this->db->order_by($filter['sort_by'], $filter['order_by']);
			}

			if ( ! empty($filter['filter_search'])) {
				$this->db->like('location_name', $filter['filter_search']);
				$this->db->or_like('location_city', $filter['filter_search']);
				$this->db->or_like('location_state', $filter['filter_search']);
				$this->db->or_like('location_postcode', $filter['filter_search']);
			}

			if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
				$this->db->where('location_status', $filter['filter_status']);
			}

			$query = $this->db->get();
			$result = array();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}

			return $result;
		}
	}

	public function getLocations() {
		$this->db->from('locations');

		$this->db->where('location_status', '1');

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getLocation($location_id) {

		if (is_numeric($location_id)) {
			$this->db->from('locations');
			$this->db->join('countries', 'countries.country_id = locations.location_country_id', 'left');
			//$this->db->join('working_hours', 'working_hours.location_id = locations.location_id', 'left');

			$this->db->where('location_id', $location_id);
			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				return $query->row_array();
			}
		}
	}

	public function getWorkingHours($location_id = FALSE) {
		$result = array();

		$this->db->from('working_hours');

		if (is_numeric($location_id)) {
			$this->db->where('location_id', $location_id);
		}

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getAddress($location_id) {
		$address_data = array();

		if ($location_id !== 0) {
			$this->db->from('locations');
			$this->db->join('countries', 'countries.country_id = locations.location_country_id', 'left');

			$this->db->where('location_id', $location_id);
			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				$row = $query->row_array();

				$address_data = array(
					'location_id'   => $row['location_id'],
					'location_name' => $row['location_name'],
					'address_1'     => $row['location_address_1'],
					'address_2'     => $row['location_address_2'],
					'city'          => $row['location_city'],
					'state'         => $row['location_state'],
					'postcode'      => $row['location_postcode'],
					'country_id'    => $row['location_country_id'],
					'country'       => $row['country_name'],
					'iso_code_2'    => $row['iso_code_2'],
					'iso_code_3'    => $row['iso_code_3'],
					'location_lat'  => $row['location_lat'],
					'location_lng'  => $row['location_lng'],
					'format'        => $row['format'],
				);
			}
		}

		return $address_data;
	}

	public function getOpeningHourByDay($location_id = FALSE, $day = FALSE) {
		$weekdays = array('Monday' => 0, 'Tuesday' => 1, 'Wednesday' => 2, 'Thursday' => 3, 'Friday' => 4, 'Saturday' => 5, 'Sunday' => 6);

		$day = ( ! isset($weekdays[$day])) ? date('l', strtotime($day)) : $day;

		$hour = array('open' => '00:00:00', 'close' => '00:00:00', 'status' => '0');

		$this->db->from('working_hours');
		$this->db->where('location_id', $location_id);
		$this->db->where('weekday', $weekdays[$day]);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$row = $query->row_array();
			$hour['open'] = $row['opening_time'];
			$hour['close'] = $row['closing_time'];
			$hour['status'] = $row['status'];
		}

		return $hour;
	}

	public function getLocalRestaurant($lat = FALSE, $lng = FALSE, $search_query = FALSE) {
		if ($this->config->item('distance_unit') === 'km') {
			$sql = "SELECT *, ( 6371 * acos( cos( radians(?) ) * cos( radians( location_lat ) ) *";
		} else {
			$sql = "SELECT *, ( 3959 * acos( cos( radians(?) ) * cos( radians( location_lat ) ) *";
		}

		$sql .= "cos( radians( location_lng ) - radians(?) ) + sin( radians(?) ) *";
		$sql .= "sin( radians( location_lat ) ) ) ) AS distance ";
		$sql .= "FROM {$this->db->dbprefix('locations')} WHERE location_status = 1 ";
		$sql .= "ORDER BY distance LIMIT 0 , 20";

		if ( ! empty($lat) && ! empty($lng)) {
			$query = $this->db->query($sql, array($lat, $lng, $lat));
		}

		$local_info = array();

		if ($query->num_rows() > 0) {
			$result = $query->first_row('array');

			if ( ! empty($result['location_radius'])) {
				$search_radius = $result['location_radius'];
			} else {
				$search_radius = (int) $this->config->item('search_radius');
			}

			if ($result['distance'] <= $search_radius) {
				$local_info = array(
					'location_id'   => $result['location_id'],
					'location_name' => $result['location_name'],
					'distance'      => $result['distance'],
					'search_query'  => $search_query,
				);

				return $local_info;
			}
		}

		return FALSE;
	}

	public function updateDefault($address = array()) {
		$query = FALSE;

		if (empty($address) AND ! is_array($address)) {
			return $query;
		}

		if (isset($address['address_1'])) {
			$this->db->set('location_address_1', $address['address_1']);
		}

		if (isset($address['address_2'])) {
			$this->db->set('location_address_2', $address['address_2']);
		}

		if (isset($address['city'])) {
			$this->db->set('location_city', $address['city']);
		}

		if (isset($address['state'])) {
			$this->db->set('location_state', $address['state']);
		}

		if (isset($address['postcode'])) {
			$this->db->set('location_postcode', $address['postcode']);
		}

		if (isset($address['country_id'])) {
			$this->db->set('location_country_id', $address['country_id']);
		}

		if (isset($address['location_lat'])) {
			$this->db->set('location_lat', $address['location_lat']);
		}

		if (isset($address['location_lng'])) {
			$this->db->set('location_lng', $address['location_lng']);
		}

		$this->db->set('location_status', '1');

		$location_id = (isset($address['location_id']) AND is_numeric($address['location_id'])) ? (int) $address['location_id'] : $this->config->item('default_location_id');

		if (is_numeric($location_id)) {
			$this->db->where('location_id', $location_id);
			$query = $this->db->update('locations');
		} else {
			if ($query = $this->db->insert('locations')) {
				$location_id = (int) $this->db->insert_id();
			}
		}

		if (is_numeric($location_id) AND $default_address = $this->getAddress($location_id)) {
			$this->Settings_model->addSetting('prefs', 'main_address', $default_address, '1');
			$this->Settings_model->addSetting('prefs', 'default_location_id', $location_id, '0');
		}

		return $query;
	}

	public function saveLocation($location_id, $save = array()) {
		if (empty($save)) return FALSE;

		if (isset($save['location_name'])) {
			$this->db->set('location_name', $save['location_name']);
		}

		if (isset($save['address']['address_1'])) {
			$this->db->set('location_address_1', $save['address']['address_1']);
		}

		if (isset($save['address']['address_2'])) {
			$this->db->set('location_address_2', $save['address']['address_2']);
		}

		if (isset($save['address']['city'])) {
			$this->db->set('location_city', $save['address']['city']);
		}

		if (isset($save['address']['state'])) {
			$this->db->set('location_state', $save['address']['state']);
		}

		if (isset($save['address']['postcode'])) {
			$this->db->set('location_postcode', $save['address']['postcode']);
		}

		if (isset($save['address']['country'])) {
			$this->db->set('location_country_id', $save['address']['country']);
		}

		if (isset($save['address']['location_lat'])) {
			$this->db->set('location_lat', $save['address']['location_lat']);
		}

		if (isset($save['address']['location_lng'])) {
			$this->db->set('location_lng', $save['address']['location_lng']);
		}

		if (isset($save['email'])) {
			$this->db->set('location_email', $save['email']);
		}

		if (isset($save['telephone'])) {
			$this->db->set('location_telephone', $save['telephone']);
		}

		if (isset($save['description'])) {
			$this->db->set('description', $save['description']);
		}

		if (isset($save['location_image'])) {
			$this->db->set('location_image', $save['location_image']);
		}

		if ($save['offer_delivery'] === '1') {
			$this->db->set('offer_delivery', $save['offer_delivery']);
		} else {
			$this->db->set('offer_delivery', '0');
		}

		if ($save['offer_collection'] === '1') {
			$this->db->set('offer_collection', $save['offer_collection']);
		} else {
			$this->db->set('offer_collection', '0');
		}

		if (isset($save['delivery_time'])) {
			$this->db->set('delivery_time', $save['delivery_time']);
		} else {
			$this->db->set('delivery_time', '0');
		}

		if (isset($save['collection_time'])) {
			$this->db->set('collection_time', $save['collection_time']);
		} else {
			$this->db->set('collection_time', '0');
		}

		if (isset($save['last_order_time'])) {
			$this->db->set('last_order_time', $save['last_order_time']);
		} else {
			$this->db->set('last_order_time', '0');
		}

		if (isset($save['reservation_time_interval'])) {
			$this->db->set('reservation_time_interval', $save['reservation_time_interval']);
		} else {
			$this->db->set('reservation_time_interval', '0');
		}

		if (isset($save['reservation_stay_time'])) {
			$this->db->set('reservation_stay_time', $save['reservation_stay_time']);
		} else {
			$this->db->set('reservation_stay_time', '0');
		}

		$options = array();
		if (isset($save['auto_lat_lng'])) {
			$options['auto_lat_lng'] = $save['auto_lat_lng'];
		}

		if (isset($save['opening_type'])) {
			$options['opening_hours']['opening_type'] = $save['opening_type'];
		}

		if (isset($save['daily_days'])) {
			$options['opening_hours']['daily_days'] = $save['daily_days'];
		}

		if (isset($save['daily_hours'])) {
			$options['opening_hours']['daily_hours'] = $save['daily_hours'];
		}

		if (isset($save['flexible_hours'])) {
			$options['opening_hours']['flexible_hours'] = $save['flexible_hours'];
		}

		if (isset($save['delivery_type'])) {
			$options['opening_hours']['delivery_type'] = $save['delivery_type'];
		}

		if (isset($save['delivery_days'])) {
			$options['opening_hours']['delivery_days'] = $save['delivery_days'];
		}

		if (isset($save['delivery_hours'])) {
			$options['opening_hours']['delivery_hours'] = $save['delivery_hours'];
		}

		if (isset($save['collection_type'])) {
			$options['opening_hours']['collection_type'] = $save['collection_type'];
		}

		if (isset($save['collection_days'])) {
			$options['opening_hours']['collection_days'] = $save['collection_days'];
		}

		if (isset($save['collection_hours'])) {
			$options['opening_hours']['collection_hours'] = $save['collection_hours'];
		}

		if (isset($save['future_orders'])) {
			$options['future_orders'] = $save['future_orders'];
		}

		if (isset($save['future_order_days'])) {
			$options['future_order_days'] = $save['future_order_days'];
		}

		if (isset($save['payments'])) {
			$options['payments'] = $save['payments'];
		}

		if (isset($save['delivery_areas'])) {
			$options['delivery_areas'] = $save['delivery_areas'];
		}

		if (isset($save['gallery'])) {
			$options['gallery'] = $save['gallery'];
		}

		$this->db->set('options', serialize($options));

		if ($save['location_status'] === '1') {
			$this->db->set('location_status', $save['location_status']);
		} else {
			$this->db->set('location_status', '0');
		}

		if (is_numeric($location_id)) {
			$this->db->where('location_id', $location_id);
			$query = $this->db->update('locations');
		} else {
			$query = $this->db->insert('locations');
			$location_id = $this->db->insert_id();
		}

		if ($query === TRUE AND is_numeric($location_id)) {
			if ($location_id === $this->config->item('default_location_id')) {
				$this->Settings_model->addSetting('prefs', 'main_address', $this->getAddress($location_id), '1');
			}

			if ( ! empty($options['opening_hours'])) {
				$this->addOpeningHours($location_id, $options['opening_hours']);
			}

			if ( ! empty($save['tables'])) {
				$this->addLocationTables($location_id, $save['tables']);
			}

			if ( ! empty($save['permalink'])) {
				$this->permalink->savePermalink('local', $save['permalink'], 'location_id=' . $location_id);
			}

			return $location_id;
		}
	}

	public function addOpeningHours($location_id, $data = array()) {
		$this->db->where('location_id', $location_id);
		$this->db->delete('working_hours');

		$hours = array();

		if ( ! empty($data['opening_type'])) {
			if ($data['opening_type'] === '24_7') {
				for ($day = 0; $day <= 6; $day ++) {
					$hours['opening'][] = array('day' => $day, 'open' => '00:00', 'close' => '23:59', 'status' => '1');
				}
			} else if ($data['opening_type'] === 'daily') {
				for ($day = 0; $day <= 6; $day ++) {
					if ( ! empty($data['daily_days']) AND in_array($day, $data['daily_days'])) {
						$hours['opening'][] = array('day' => $day, 'open' => $data['daily_hours']['open'], 'close' => $data['daily_hours']['close'], 'status' => '1');
					} else {
						$hours['opening'][] = array('day' => $day, 'open' => $data['daily_hours']['open'], 'close' => $data['daily_hours']['close'], 'status' => '0');
					}
				}
			} else if ($data['opening_type'] === 'flexible' AND ! empty($data['flexible_hours'])) {
				$hours['opening'] = $data['flexible_hours'];
			}

			$hours['delivery'] = empty($data['delivery_type']) ? $hours['opening'] : $this->_createWorkingHours('delivery', $data);
			$hours['collection'] = empty($data['collection_type']) ? $hours['opening'] : $this->_createWorkingHours('collection', $data);

			if (is_numeric($location_id) AND ! empty($hours) AND is_array($hours)) {
				foreach ($hours as $type => $hr) {
					foreach ($hr as $hour) {
						$this->db->set('location_id', $location_id);
						$this->db->set('weekday', $hour['day']);
						$this->db->set('type', $type);
						$this->db->set('opening_time', mdate('%H:%i', strtotime($hour['open'])));
						$this->db->set('closing_time', mdate('%H:%i', strtotime($hour['close'])));
						$this->db->set('status', $hour['status']);
						$this->db->insert('working_hours');
					}
				}
			}
		}

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}

	public function addLocationTables($location_id, $tables = array()) {
		$this->db->where('location_id', $location_id);
		$this->db->delete('location_tables');

		if (is_array($tables) && ! empty($tables)) {
			foreach ($tables as $key => $value) {

				$this->db->set('location_id', $location_id);
				$this->db->set('table_id', $value);
				$this->db->insert('location_tables');
			}
		}

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}

	public function deleteLocation($location_id) {
		if (is_numeric($location_id)) $location_id = array($location_id);

		if ( ! empty($location_id) AND ctype_digit(implode('', $location_id))) {
			$this->db->where_in('location_id', $location_id);
			$this->db->delete('locations');

			if (($affected_rows = $this->db->affected_rows()) > 0) {
				$this->db->where_in('location_id', $location_id);
				$this->db->delete('location_tables');

				$this->db->where_in('location_id', $location_id);
				$this->db->delete('working_hours');

				foreach ($location_id as $id) {
					$this->permalink->deletePermalink('local', 'location_id=' . $id);
				}

				return $affected_rows;
			}
		}
	}

	public function validateLocation($location_id) {
		if ( ! empty($location_id)) {
			$this->db->from('locations');
			$this->db->where('location_id', $location_id);

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				return TRUE;
			}
		}

		return FALSE;
	}

	private function _createWorkingHours($type, $data) {
		$days = (empty($data["{$type}_days"])) ? array() : $data["{$type}_days"];
		$hours = (empty($data["{$type}_hours"])) ? array('open' => '00:00', 'close' => '23:59') : $data["{$type}_hours"];

		$working_hours = array();

		for ($day = 0; $day <= 6; $day ++) {
			$status = in_array($day, $days) ? '1' : '0';
			$working_hours[] = array('day' => $day, 'open' => $hours['open'], 'close' => $hours['close'], 'status' => $status);
		}

		return $working_hours;
	}
}

/* End of file locations_model.php */
/* Location: ./system/tastyigniter/models/locations_model.php */