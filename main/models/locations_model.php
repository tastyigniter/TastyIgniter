<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Locations_model extends CI_Model {

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

	public function getOpeningHourByDay($location_id = FALSE, $day = FALSE) {
		$datestring = '%H:%i';
		$weekdays = array('Monday' => 0, 'Tuesday' => 1, 'Wednesday' => 2, 'Thursday' => 3, 'Friday' => 4, 'Saturday' => 5, 'Sunday' => 6);
		$hour = array();
		$hour['open'] = '00:00:00';
		$hour['close'] = '00:00:00';

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
}

/* End of file locations_model.php */
/* Location: ./main/models/locations_model.php */