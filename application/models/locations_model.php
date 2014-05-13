<?php
class Locations_model extends CI_Model {

    public function record_count($filter = array()) {
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
		if ($filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}
			
		if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->from('locations');
			
			if (!empty($filter['sort_by']) AND !empty($filter['order_by'])) {
				$this->db->order_by($filter['sort_by'], $filter['order_by']);
			} else {
				$this->db->order_by('location_id', 'DESC');
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

	public function getLocationAddress($location_id) {
		
		if ($location_id !== 0) {
			$this->db->from('locations');
			$this->db->join('countries', 'countries.country_id = locations.location_country_id', 'left');
			//$this->db->join('working_hours', 'working_hours.location_id = locations.location_id', 'left');
			
			$this->db->where('location_id', $location_id);
			$query = $this->db->get();
		
			$address_data = array();

			if ($query->num_rows() > 0) {
				$row = $query->row_array();

				$address_data = array(
					'location_id'     	=> $row['location_id'],
					'location_name'    	=> $row['location_name'],
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

			return $address_data;
		}
	}
	
	public function getOpeningHourByDay($location_id = FALSE, $day = FALSE) {
		$datestring = '%H:%i';
		$weekdays = array('Monday' => 0, 'Tuesday' => 1, 'Wednesday' => 2, 'Thursday' => 3, 'Friday' => 4, 'Saturday' => 5, 'Sunday' => 6);
		$hour = array();
		$hour['open'] = '00:00';
		$hour['close'] = '00:00';
	
		$this->db->from('working_hours');
		$this->db->where('location_id', $location_id);
		$this->db->where('weekday', $weekdays[$day]);
			
		$query = $this->db->get();
	
		if ($query->num_rows() > 0) {
			$row = $query->row_array();
			$hour['open']	= $row['opening_time'];
			$hour['close']	= $row['closing_time'];
		}
		
		return $hour;
	}
	
	public function getOpeningHours($location_id = FALSE) {
		$datestring = '%H:%i';
		$weekdays = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
		$hours = array();
		
		$this->db->from('working_hours');
		$this->db->where('location_id', $location_id);
			
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$weekday_num = $row['weekday'];
				
				$open_hr = mdate($datestring, strtotime($row['opening_time']));
				$close_hr = mdate($datestring, strtotime($row['closing_time']));

				$hours[] = array(
					'day'		=> $weekdays[$weekday_num],
					'open'		=> $open_hr,
					'close'		=> $close_hr
				);				
			}
		} else {
			$hours = array(
				array('day' => 'Monday', 'open' => '00:00', 'close' => '00:00'),
				array('day' => 'Tuesday', 'open' => '00:00', 'close' => '00:00'),
				array('day' => 'Wednesday', 'open' => '00:00', 'close' => '00:00'),
				array('day' => 'Thursday', 'open' => '00:00', 'close' => '00:00'),
				array('day' => 'Friday', 'open' => '00:00', 'close' => '00:00'),
				array('day' => 'Saturday', 'open' => '00:00', 'close' => '00:00'),
				array('day' => 'Sunday', 'open' => '00:00', 'close' => '00:00')
			);
		}
			
		return $hours;
	}

	public function getLocalRestaurant($lat = FALSE, $lng = FALSE, $search_query = FALSE) {
		if ($this->config->item('distance_unit') === 'km') {
			$sql  = "SELECT *, ( 6371 * acos( cos( radians(?) ) * cos( radians( location_lat ) ) *";
		} else {
			$sql  = "SELECT *, ( 3959 * acos( cos( radians(?) ) * cos( radians( location_lat ) ) *";
		}
		
		$sql .= "cos( radians( location_lng ) - radians(?) ) + sin( radians(?) ) *";
		$sql .= "sin( radians( location_lat ) ) ) ) AS distance ";
		$sql .= "FROM {$this->db->dbprefix('locations')} WHERE location_status = 1 ";
		$sql .= "ORDER BY distance LIMIT 0 , 20";
		
		if (!empty($lat) && !empty($lng)) {
			$query = $this->db->query($sql, array($lat, $lng, $lat));
		}
	
		$local_info = array();
		
		if ($query->num_rows() > 0) {
			$result = $query->first_row('array');
			
			if (!empty($result['location_radius'])) {
				$search_radius = $result['location_radius'];
			} else {
				$search_radius = (int)$this->config->item('search_radius');
			}
			
			if ($result['distance'] <= $search_radius) {
				$local_info = array(
					'location_id' 		=> $result['location_id'], 
					'location_name' 	=> $result['location_name'],
					'distance' 			=> $result['distance'],
					'search_query' 		=> $search_query
				);
	
				return $local_info;
			}
		}
		
		return FALSE;
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
		
		if (!empty($update['location_radius'])) {
			$this->db->set('location_radius', $update['location_radius']);
		}
		
		if (!empty($update['covered_area'])) {
			$this->db->set('covered_area', $update['covered_area']);
		}
		
		if (!empty($update['email'])) {
			$this->db->set('location_email', $update['email']);
		}
		
		if (!empty($update['telephone'])) {
			$this->db->set('location_telephone', $update['telephone']);
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
		
		if (!empty($update['ready_time'])) {
			$this->db->set('ready_time', $update['ready_time']);
		}
		
		if (!empty($update['delivery_charge'])) {
			$this->db->set('delivery_charge', $update['delivery_charge']);
		}
		
		if (!empty($update['min_delivery_total'])) {
			$this->db->set('min_delivery_total', $update['min_delivery_total']);
		}
		
		if (!empty($update['reserve_interval'])) {
			$this->db->set('reserve_interval', $update['reserve_interval']);
		}
		
		if (!empty($update['reserve_turn'])) {
			$this->db->set('reserve_turn', $update['reserve_turn']);
		}
		
		if ($update['location_status'] === '1') {
			$this->db->set('location_status', $update['location_status']);
		} else {
			$this->db->set('location_status', '0');
		}

		if (!empty($update['location_id'])) {
			$this->db->where('location_id', $update['location_id']);
			$this->db->update('locations'); 
		}
		
		$this->addOpeningHours($update['location_id'], $update['hours']);
		$this->addLocationTables($update['location_id'], $update['tables']);

		if ($this->db->affected_rows() > 0) {
			$query = TRUE;
		}

		return TRUE;
	}

	public function addLocation($add = array()) {

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
		
		if (!empty($add['ready_time'])) {
			$this->db->set('ready_time', $add['ready_time']);
		}
		
		if (!empty($add['delivery_charge'])) {
			$this->db->set('delivery_charge', $add['delivery_charge']);
		}
		
		if (!empty($add['min_delivery_total'])) {
			$this->db->set('min_delivery_total', $add['min_delivery_total']);
		}
		
		if (!empty($add['reserve_interval'])) {
			$this->db->set('reserve_interval', $add['reserve_interval']);
		}
		
		if (!empty($add['reserve_turn'])) {
			$this->db->set('reserve_turn', $add['reserve_turn']);
		}
		
		if ($add['location_status'] === '1') {
			$this->db->set('location_status', $add['location_status']);
		} else {
			$this->db->set('location_status', '0');
		}

		$this->db->insert('locations');
		
		if ($this->db->affected_rows() > 0) {
			$location_id = $this->db->insert_id();			
			
			$this->addOpeningHours($location_id, $add['hours']);
			$this->addLocationTables($location_id, $add['tables']);

			return TRUE;
		}
	}

	public function addOpeningHours($location_id, $hours = array()) {
		$this->db->where('location_id', $location_id);
		$this->db->delete('working_hours');

		if (is_array($hours) AND !empty($hours)) {
			foreach ($hours['open'] as $weekday => $open) {

				foreach ($hours['close'] as $day => $close) {
					if ($weekday === $day) {
						$this->db->set('location_id', $location_id);
						$this->db->set('weekday', $weekday);
						$this->db->set('opening_time', $open);
						$this->db->set('closing_time', $close);
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
/* Location: ./application/models/locations_model.php */