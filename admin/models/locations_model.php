<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Locations_model extends CI_Model {

    public function getCount($filter = array()) {
		if (!empty($filter['filter_search'])) {
			$this->db->like('location_name', $filter['filter_search']);
			$this->db->or_like('location_city', $filter['filter_search']);
			$this->db->or_like('location_postcode', $filter['filter_search']);
		}

		if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
			$this->db->where('location_status', $filter['filter_status']);
		}

		$this->db->from('locations');
		return $this->db->count_all_results();
    }

	public function getList($filter = array()) {
		if (!empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

		if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->from('locations');

			if (!empty($filter['sort_by']) AND !empty($filter['order_by'])) {
				$this->db->order_by($filter['sort_by'], $filter['order_by']);
			}

			if (!empty($filter['filter_search'])) {
				$this->db->like('location_name', $filter['filter_search']);
				$this->db->or_like('location_city', $filter['filter_search']);
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

		if ($location_id !== 0) {
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
					'location_id'    => $row['location_id'],
					'location_name'  => $row['location_name'],
					'address_1'      => $row['location_address_1'],
					'address_2'      => $row['location_address_2'],
					'city'           => $row['location_city'],
					'state'          => $row['location_state'],
					'postcode'       => $row['location_postcode'],
					'country_id'     => $row['location_country_id'],
					'country'        => $row['country_name'],
					'iso_code_2'     => $row['iso_code_2'],
					'iso_code_3'     => $row['iso_code_3'],
					'format'     	 => $row['format']
				);
			}
		}

		return $address_data;
	}

	public function updateDefault($address = array()) {
		$query = FALSE;

		if (empty($address) AND !is_array($address)) {
			return $query;
		}

		if (!empty($address['address_1'])) {
			$this->db->set('location_address_1', $address['address_1']);
		}

		if (!empty($address['address_2'])) {
			$this->db->set('location_address_2', $address['address_2']);
		}

		if (!empty($address['city'])) {
			$this->db->set('location_city', $address['city']);
		}

		if (!empty($address['postcode'])) {
			$this->db->set('location_postcode', $address['postcode']);
		}

		if (!empty($address['country_id'])) {
			$this->db->set('location_country_id', $address['country_id']);
		}

		if (!empty($address['location_lat'])) {
			$this->db->set('location_lat', $address['location_lat']);
		}

		if (!empty($address['location_lng'])) {
			$this->db->set('location_lng', $address['location_lng']);
		}

		$this->db->set('location_status', '1');

		$location_id = 0;
		if (!empty($address['location_id']) AND is_numeric($address['location_id'])) {
			$location_id = (int) $address['location_id'];
			$this->db->where('location_id', $location_id);
			$query = $this->db->update('locations');
		} else {
			if ($this->db->insert('locations')) {
				$location_id = (int) $this->db->insert_id();
			}
		}

		$this->Settings_model->addSetting('config', 'main_address', $this->getAddress($location_id), '1');
		$this->Settings_model->addSetting('prefs', 'default_location_id', $location_id, '0');
		return $query;
	}

	public function updateLocation($update = array()) {
		$query = FALSE;

		if (!empty($update['location_name'])) {
			$this->db->set('location_name', $update['location_name']);
		}

		if (!empty($update['address']['address_1'])) {
			$this->db->set('location_address_1', $update['address']['address_1']);
		}

		if (!empty($update['address']['address_2'])) {
			$this->db->set('location_address_2', $update['address']['address_2']);
		}

		if (!empty($update['address']['city'])) {
			$this->db->set('location_city', $update['address']['city']);
		}

		if (!empty($update['address']['postcode'])) {
			$this->db->set('location_postcode', $update['address']['postcode']);
		}

		if (!empty($update['address']['country'])) {
			$this->db->set('location_country_id', $update['address']['country']);
		}

		if (!empty($update['address']['location_lat'])) {
			$this->db->set('location_lat', $update['address']['location_lat']);
		}

		if (!empty($update['address']['location_lng'])) {
			$this->db->set('location_lng', $update['address']['location_lng']);
		}

		if (!empty($update['email'])) {
			$this->db->set('location_email', $update['email']);
		}

		if (!empty($update['telephone'])) {
			$this->db->set('location_telephone', $update['telephone']);
		}

		if (isset($update['description'])) {
			$this->db->set('description', $update['description']);
		}

		if ($update['offer_delivery'] === '1') {
			$this->db->set('offer_delivery', $update['offer_delivery']);
		} else {
			$this->db->set('offer_delivery', '0');
		}

		if ($update['offer_collection'] === '1') {
			$this->db->set('offer_collection', $update['offer_collection']);
		} else {
			$this->db->set('offer_collection', '0');
		}

		if (!empty($update['delivery_time'])) {
			$this->db->set('delivery_time', $update['delivery_time']);
		} else {
			$this->db->set('delivery_time', '0');
		}

		if (!empty($update['collection_time'])) {
			$this->db->set('collection_time', $update['collection_time']);
		} else {
			$this->db->set('collection_time', '0');
		}

		if (!empty($update['last_order_time'])) {
			$this->db->set('last_order_time', $update['last_order_time']);
		} else {
			$this->db->set('last_order_time', '0');
		}

		if (!empty($update['reservation_interval'])) {
			$this->db->set('reservation_interval', $update['reservation_interval']);
		} else {
			$this->db->set('reservation_interval', '0');
		}

		if (!empty($update['reservation_turn'])) {
			$this->db->set('reservation_turn', $update['reservation_turn']);
		} else {
			$this->db->set('reservation_turn', '0');
		}

		if (!empty($update['options'])) {
			$this->db->set('options', serialize($update['options']));
		}

		if ($update['location_status'] === '1') {
			$this->db->set('location_status', $update['location_status']);
		} else {
			$this->db->set('location_status', '0');
		}

		if (!empty($update['location_id'])) {
			$this->db->where('location_id', $update['location_id']);

			if ($query = $this->db->update('locations')) {
				$this->load->model('Notifications_model');
				$this->Notifications_model->addNotification(array('action' => 'updated', 'object' => 'location', 'object_id' => $update['location_id'], 'actor_id' => $this->user->getStaffId()));

				$this->addOpeningHours($update['location_id'], $update['options']['opening_hours']);
				$this->addLocationTables($update['location_id'], $update['tables']);

			}

			if (!empty($update['permalink'])) {
				$this->load->model('Permalinks_model');
				$this->Permalinks_model->updatePermalink(array('controller' => 'local', 'permalink' => $update['permalink'], 'query' => 'location_id='.$update['location_id']));
			}
		}

		return $query;
	}

	public function addLocation($add = array()) {
		$query = FALSE;

		if (!empty($add['location_name'])) {
			$this->db->set('location_name', $add['location_name']);
		}

		if (!empty($add['address']['address_1'])) {
			$this->db->set('location_address_1', $add['address']['address_1']);
		}

		if (!empty($add['address']['address_2'])) {
			$this->db->set('location_address_2', $add['address']['address_2']);
		}

		if (!empty($add['address']['city'])) {
			$this->db->set('location_city', $add['address']['city']);
		}

		if (!empty($add['address']['postcode'])) {
			$this->db->set('location_postcode', $add['address']['postcode']);
		}

		if (!empty($add['address']['country'])) {
			$this->db->set('location_country_id', $add['address']['country']);
		}

		if (!empty($add['address']['location_lat'])) {
			$this->db->set('location_lat', $add['address']['location_lat']);
		}

		if (!empty($add['address']['location_lng'])) {
			$this->db->set('location_lng', $add['address']['location_lng']);
		}

		if (!empty($add['email'])) {
			$this->db->set('location_email', $add['email']);
		}

		if (!empty($add['telephone'])) {
			$this->db->set('location_telephone', $add['telephone']);
		}

		if (isset($add['description'])) {
			$this->db->set('description', $add['description']);
		}

		if ($add['offer_delivery'] === '1') {
			$this->db->set('offer_delivery', $add['offer_delivery']);
		} else {
			$this->db->set('offer_delivery', '0');
		}

		if ($add['offer_collection'] === '1') {
			$this->db->set('offer_collection', $add['offer_collection']);
		} else {
			$this->db->set('offer_collection', '0');
		}

		if (!empty($add['delivery_time'])) {
			$this->db->set('delivery_time', $add['delivery_time']);
		} else {
			$this->db->set('delivery_time', '0');
		}

		if (!empty($add['collection_time'])) {
			$this->db->set('collection_time', $add['collection_time']);
		} else {
			$this->db->set('collection_time', '0');
		}

		if (!empty($add['last_order_time'])) {
			$this->db->set('last_order_time', $add['last_order_time']);
		} else {
			$this->db->set('last_order_time', '0');
		}

		if (!empty($add['reservation_interval'])) {
			$this->db->set('reservation_interval', $add['reservation_interval']);
		} else {
			$this->db->set('reservation_interval', '0');
		}

		if (!empty($add['reservation_turn'])) {
			$this->db->set('reservation_turn', $add['reservation_turn']);
		} else {
			$this->db->set('reservation_turn', '0');
		}

		if (!empty($add['options'])) {
			$this->db->set('options', serialize($add['options']));
		}

		if ($add['location_status'] === '1') {
			$this->db->set('location_status', $add['location_status']);
		} else {
			$this->db->set('location_status', '0');
		}

		if (!empty($add)) {
			if ($this->db->insert('locations')) {
				$location_id = $this->db->insert_id();

				$this->load->model('Notifications_model');
				$this->Notifications_model->addNotification(array('action' => 'added', 'object' => 'location', 'object_id' => $location_id, 'actor_id' => $this->user->getStaffId()));

				$this->addOpeningHours($location_id, $add['options']['opening_hours']);
				$this->addLocationTables($location_id, $add['tables']);


				if (!empty($add['permalink'])) {
					$this->load->model('Permalinks_model');
					$this->Permalinks_model->addPermalink(array('controller' => 'local', 'permalink' => $add['permalink'], 'query' => 'location_id='.$location_id));
				}

				$query = $location_id;
			}
		}

		return $query;
	}

	public function addOpeningHours($location_id, $data = array()) {
		$this->db->where('location_id', $location_id);
		$this->db->delete('working_hours');

		$hours = array();

		if (!empty($data['opening_type']) AND !empty($data['daily_days']) AND !empty($data['flexible_hours'])) {
			if ($data['opening_type'] === '24_7') {
				for ($day = 0; $day <= 6; $day++) {
					$hours[] = array('day' => $day, 'open' => '00:00', 'close' => '23:59', 'status' => '0');
				}
			} else if ($data['opening_type'] === 'daily') {
				for ($day = 0; $day <= 6; $day++) {
					if (in_array($day, $data['daily_days'])) {
						$hours[] = array('day' => $day, 'open' => $data['daily_hours']['open'], 'close' => $data['daily_hours']['close'], 'status' => '0');
					} else {
						$hours[] = array('day' => $day, 'open' => $data['daily_hours']['open'], 'close' => $data['daily_hours']['close'], 'status' => '1');
					}
				}
			} else if ($data['opening_type'] === 'flexible') {
				$hours = $data['flexible_hours'];
			}

			if (!empty($hours) AND is_array($hours)) {
				foreach ($hours as $hour) {
					$this->db->set('location_id', $location_id);
					$this->db->set('weekday', $hour['day']);
					$this->db->set('opening_time', mdate('%H:%i', strtotime($hour['open'])));
					$this->db->set('closing_time', mdate('%H:%i', strtotime($hour['close'])));
					$this->db->set('status', $hour['status']);
					$this->db->insert('working_hours');
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

		if (is_array($tables) && !empty($tables)) {
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
		if (is_numeric($location_id)) {
			$this->db->where('location_id', $location_id);
			$this->db->delete('locations');

			$this->db->where('location_id', $location_id);
			$this->db->delete('location_tables');

			$this->db->where('location_id', $location_id);
			$this->db->delete('working_hours');

			if ($this->db->affected_rows() > 0) {
				return TRUE;
			}
		}
	}

	public function validateLocation($location_id) {
		if (!empty($location_id)) {
			$this->db->from('locations');
			$this->db->where('location_id', $location_id);

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				return TRUE;
			}
		}

		return FALSE;
	}
}

/* End of file locations_model.php */
/* Location: ./admin/models/locations_model.php */