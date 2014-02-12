<?php
class Locations_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}
	
    public function record_count() {
        return $this->db->count_all('locations');
    }
    
	public function getList($filter = array()) {
		if ($filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}
			
		if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->from('locations');
			
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

				$hours['day'][]		= $weekdays[$weekday_num];
				$hours['open'][]	= $open_hr;
				$hours['close'][]	= $close_hr;
				
				//$hours['day'][] = array('day' => $weekday_num, 'open' => $op_time, 'close' => $cl_time);
			}
		} else {
			$hours['day'] = $weekdays;
			$hours['open'] = array('00:00', '00:00', '00:00', '00:00', '00:00', '00:00', '00:00');
			$hours['close'] = array('00:00', '00:00', '00:00', '00:00', '00:00', '00:00', '00:00');				
		}
			
		return $hours;
	}

	public function getLocalRestaurant($lat = FALSE, $lng = FALSE) {
		$this->session->unset_userdata('local_info');
		
		if ($this->config->item('distance_unit') === 'km') {
			$sql  = "SELECT *, ( 6371 * acos( cos( radians(?) ) * cos( radians( location_lat ) ) *";
		} else {
			$sql  = "SELECT *, ( 3959 * acos( cos( radians(?) ) * cos( radians( location_lat ) ) *";
		}
		
		$sql .= "cos( radians( location_lng ) - radians(?) ) + sin( radians(?) ) * sin( radians( location_lat ) ) ) ) AS distance ";
		$sql .= "FROM locations WHERE location_status = 1 HAVING distance < location_radius ORDER BY distance LIMIT 0 , 20";
		
		if (!empty($lat) && !empty($lng)) {
			$query = $this->db->query($sql, array($lat, $lng, $lat));
		}
	
		$local_info = array();
		
		if ($query->num_rows() > 0) {
			$result = $query->first_row('array');

    		$local_info 	= array(
    			'location_id' 		=> $result['location_id'], 
    			'location_name' 	=> $result['location_name'],
    			'distance' 			=> $result['distance']
    		);
	
			$this->session->set_userdata('local_info', $local_info);
			
			return TRUE;
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
		
		if (!empty($update['address']['radius'])) {
			$this->db->set('location_radius', $update['address']['radius']);
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
		
		if ($update['location_status'] === '1') {
			$this->db->set('location_status', $update['location_status']);
		} else {
			$this->db->set('location_status', '0');
		}

		if (!empty($update['location_id'])) {
			$this->db->where('location_id', $update['location_id']);
			$this->db->update('locations'); 
		}
		
		if ($this->db->affected_rows() > 0) {
			$query = TRUE;
		}

		$this->db->where('location_id', $update['location_id']);
		$this->db->delete('working_hours');

		if (is_array($update['hours']) && !empty($update['hours'])) {
			foreach ($update['hours']['open'] as $weekday => $open) {

				foreach ($update['hours']['close'] as $day => $close) {
					if ($weekday === $day) {
						$this->db->set('location_id', $update['location_id']);
						$this->db->set('weekday', $weekday);
						$this->db->set('opening_time', $open);
						$this->db->set('closing_time', $close);
						$this->db->insert('working_hours');
					}
				}
			}
		}

		if ($this->db->affected_rows() > 0) {
			$query = TRUE;
		}

		$this->db->where('location_id', $update['location_id']);
		$this->db->delete('location_tables');

		if (is_array($update['tables']) && !empty($update['tables'])) {
			foreach ($update['tables'] as $key => $value) {

				$this->db->set('location_id', $update['location_id']);
				$this->db->set('table_id', $value);
				$this->db->insert('location_tables');
			}
		}

		if ($this->db->affected_rows() > 0) {
			$query = TRUE;
		}

		return $query;
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
		
		if (!empty($add['address']['radius'])) {
			$this->db->set('location_radius', $add['address']['radius']);
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
		
		if ($add['location_status'] === '1') {
			$this->db->set('location_status', $add['location_status']);
		} else {
			$this->db->set('location_status', '0');
		}

		$this->db->insert('locations');
		
		if ($this->db->affected_rows() > 0) {
			$location_id = $this->db->insert_id();			

			$this->db->where('location_id', $location_id);
			$this->db->delete('working_hours');

			if (is_array($add['hours']) && !empty($add['hours'])) {
				foreach ($add['hours']['open'] as $weekday => $open) {

					foreach ($add['hours']['close'] as $day => $close) {
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

			$this->db->where('location_id', $location_id);
			$this->db->delete('location_tables');

			if (is_array($add['tables']) && !empty($add['tables'])) {
				foreach ($add['tables'] as $key => $value) {

					$this->db->set('location_id', $location_id);
					$this->db->set('table_id', $value);
					$this->db->insert('location_tables');
				}
			}

			return TRUE;
		}
	}

	public function deleteLocation($location_id) {
		$this->db->where('location_id', $location_id);
		
		$this->db->delete('locations');

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}
}
