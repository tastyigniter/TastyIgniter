<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Location {
	private $location_id;
	private $location_email;
	private $location_telephone;
	private $local_info;
	private $search_query;
	private $distance;
	private $opening_hours = array();
	private $opening_time = '00:00';
	private $closing_time = '00:00';
	private $opened = FALSE;
	private $datestring = "%Y/%m/%d";
	private $timestring = "%H:%i";
	private $current_day;
	private $current_date;
	private $current_time;
	
	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->database();
		$this->CI->load->helper('date');
		$this->CI->load->model('Locations_model');

		$time = now();
		$this->current_day = date('l');
		$this->current_date = mdate($this->datestring, $time);
		$this->current_time = mdate($this->timestring, $time);
		
		$local_info = $this->CI->session->userdata('local_info');
		if (is_array($local_info) AND !empty($local_info)) {
			$this->initialize($local_info);
		}
	}

	public function initialize($local_info) {
		if ($local_info['location_id'] AND $local_info['location_name'] AND $local_info['distance'] AND $local_info['search_query']) { 
			
			//$this->CI->db->select('location_id, location_name');
			$this->CI->db->where('location_id', $local_info['location_id']);
			$this->CI->db->where('location_name', $local_info['location_name']);
			$query = $this->CI->db->get('locations');
			
			if ($query->num_rows() > 0) {
				$result = $query->row_array();
				
				$this->location_id 			= $result['location_id'];
				$this->location_email 		= $result['location_email'];
				$this->location_telephone 	= $result['location_telephone'];
				$this->local_info 			= $result;
				$this->distance 			= $local_info['distance'];
				$this->search_query 		= $local_info['search_query'];
			
				$this->_setOpeningHours();	
			} else {
				$this->clearLocal();
			}
		}
	}
	
	public function _setOpeningHours() {
		$this->CI->db->where('location_id', $this->location_id);
		$query = $this->CI->db->get('working_hours');

		$opening_hours = array();
		if ($query->num_rows() > 0) {
			$weekdays = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');

			foreach ($query->result_array() as $row) {
				$weekday = $weekdays[$row['weekday']];
				$op_time = mdate($this->timestring, strtotime($row['opening_time']));
				$cl_time = mdate($this->timestring, strtotime($row['closing_time']));
				$opening_hours[] = array('day' => $weekday, 'open' => $op_time, 'close' => $cl_time);

				if ($this->current_day === $weekday) {
					$this->opening_time = $op_time;
					$this->closing_time = $cl_time;
				}
			}

			$this->opening_hours = $opening_hours;
		}
	}
		
	public function currentDate() {
		return $this->current_date;	
	}

	public function currentTime() {
		return $this->current_time;	
	}

	public function getId() {
		return $this->location_id;
	}

	public function getEmail() {
		return strtolower($this->location_email);
	}

	public function getTelephone() {
		return $this->location_telephone;
	}

	public function local() {
		return $this->local_info;
	}

	public function distance() {
		if ( ! is_numeric($this->distance)) {
			return FALSE;
		}
		
		$this->distance = number_format($this->distance, 2);
		
		if ($this->CI->config->item('distance_unit') === 'km') {
			$this->distance = $this->distance .' km';
		} else {
			$this->distance = $this->distance .' mi';
		}
		
		return $this->distance;
	}

	public function getOpeningHours() {
		return $this->opening_hours;	
	}

	public function openingTime() {
		return $this->opening_time;	
	}

	public function closingTime() {
		return $this->closing_time;	
	}

	public function isOpened() {
		return (($this->opening_time <= $this->current_time AND $this->closing_time >= $this->current_time) OR ($this->opening_time === '00:00' OR $this->closing_time === '00:00'));
	}

	public function checkDeliveryTime($time) {
		$time = mdate($this->timestring, strtotime($time));
    	return (($this->opening_time <= $time AND $this->closing_time >= $time) OR ($this->opening_time === '00:00' OR $this->closing_time === '00:00'));    	
	}
	
	public function readyTime() {
		return (isset($this->local_info['ready_time'])) ? $this->local_info['ready_time'] : $this->CI->config->item('ready_time');	
	}

	public function lastOrderTime() {
		return (isset($this->local_info['last_order_time']) AND $this->local_info['last_order_time'] !== '00:00:00') ? $this->local_info['last_order_time'] : $this->closing_time;	
	}

	public function checkDelivery($search_query = FALSE, $check_setting = FALSE) {
		if ($search_query === FALSE) {
			$search_query = $this->search_query;
		}
		
		$check;
		$is_covered = $this->_checkCoveredArea($search_query, $check_setting);		
		
		if (empty($this->local_info['offer_delivery'])) {
			$check = 'no';
		} else if ($is_covered === 'outside') {
			$check = 'outside';
		} else if ($this->local_info['offer_delivery'] === '1') {
			$check = 'yes';
		}

    	return $check;    	
	}
	
	public function checkCollection() {
    	return (isset($this->local_info['offer_collection'])) ? $this->local_info['offer_collection'] : FALSE;    	
	}
	
	public function getDeliveryCharge() {
    	return (isset($this->local_info['delivery_charge'])) ? $this->local_info['delivery_charge'] : FALSE;    	
	}
	
	public function checkMinTotal($cart_total) {
    	return (isset($this->local_info['min_delivery_total'])) ? ($this->local_info['min_delivery_total'] <= $cart_total) : TRUE;    	
	}
	
	public function getMinTotal() {
    	return (isset($this->local_info['min_delivery_total'])) ? $this->local_info['min_delivery_total'] : FALSE;    	
	}
	
	public function getReserveInterval() {
    	return (isset($this->local_info['reserve_interval'])) ? $this->local_info['reserve_interval'] : $this->CI->config->item('reserve_interval');    	
	}
	
	public function generateHours($start_hour, $end_hour, $interval) {

		$hours = array();
		$start_formatted = strtotime($start_hour);
		$end_formatted = strtotime($end_hour);
		$interval = $interval * 60;
		
		if ($start_formatted < $end_formatted) {

			for ($i = ($start_formatted + $interval); $i < ($end_formatted); $i += $interval) {
				$hr24 = mdate($this->timestring, $i);
				$hours[] = $hr24;
			}
  		}
  		
  		return $hours;
	}

	public function getLatLng($search_query = FALSE, $check_setting = FALSE) {																// method to perform regular expression match on postcode string and return latitude and longitude
		if (empty($search_query)) {
			return "NO_SEARCH_QUERY";
		}
		
		if (is_string($search_query)) {
			$postcode = strtoupper(str_replace(' ', '', $search_query));								// strip spaces from postcode string and convert to uppercase
		
			if (preg_match("/^[A-Z]{1,2}[0-9]{2,3}[A-Z]{2}$/", $postcode) OR 
			preg_match("/^[A-Z]{1,2}[0-9]{1}[A-Z]{1}[0-9]{1}[A-Z]{2}$/", $postcode) OR 
			preg_match("/^GIR0[A-Z]{2}$/", $postcode)) {
				$search_query = $postcode;
				$is_postcode = TRUE;
			} else {
				$search_query = explode(' ', $search_query);
				$is_postcode = FALSE;
			}
		}
		
		if (is_array($search_query)) {
			$address_string =  implode(', ', $search_query);
			$search_query = $address_string;
		}
		
		if ($check_setting === TRUE) {
			$search_by = $this->CI->config->item('search_by');
			if ($search_by === 'postcode' AND $is_postcode === FALSE) {
				return "INVALID_POSTCODE";			
			}
		}
		
		$url  = 'http://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($search_query) .'&sensor=false&region=GB'; //encode $postcode string and construct the url query
		$geocode_data = @file_get_contents($url);
		$output = json_decode($geocode_data);											// decode the geocode data

		if ($output) {
			if ($output->status === 'OK') {														// create variable for geocode data status
				return array( 
					'search_query'	=> $search_query,
					'lat' 			=> $output->results[0]->geometry->location->lat,
					'lng' 			=> $output->results[0]->geometry->location->lng
				);
			} else {
				return "FAILED";
			}
		}
	}

	public function _checkCoveredArea($search_query, $check_setting) {
		$is_covered = '';
		$polygon = array();

		$coords = $this->getLatLng($search_query, $check_setting);
		if (is_array($coords)) {
			$point = $coords['lat'].'|'.$coords['lng'];
			
			$covered_area = (isset($this->local_info['covered_area'])) ? unserialize($this->local_info['covered_area']) : array('pathArray'=>'');
			$path = (!empty($covered_area['pathArray'])) ? json_decode($covered_area['pathArray']) : FALSE;
			
			if (!empty($path)) {
				foreach ($path as $key => $value) {
					$value = get_object_vars($value);
					$polygon[] = $value['lat'].'|'.$value['lng'];
				}
	
				$is_covered = $this->pointInPolygon($point, $polygon);
			}
		}
		
		return $is_covered;
	}
	
    public function pointInPolygon($point, $polygon, $pointOnVertex = TRUE) {
 		$this->pointOnVertex = TRUE;
       
        // Transform string coordinates into arrays with x and y values
        $point = $this->_pointStringToCoordinates($point);

        $vertices = array(); 
        foreach ($polygon as $vertex) {
            $vertices[] = $this->_pointStringToCoordinates($vertex); 
        }
 
        // Check if the point sits exactly on a vertex
        if ($this->pointOnVertex === TRUE AND $this->_pointOnVertex($point, $vertices) === TRUE) {
            return "vertex";
        }
 
        // Check if the point is inside the polygon or on the boundary
        $intersections = 0; 
        $vertices_count = count($vertices);
 
        for ($i=1; $i < $vertices_count; $i++) {
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
               
                if ($xinters == $point['x']) { // Check if point is on the polygon boundary (other than horizontal)
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
 
    public function _pointOnVertex($point, $vertices) {
        foreach($vertices as $vertex) {
            if ($point == $vertex) {
                return TRUE;
            }
        }
 
    }
 
    public function _pointStringToCoordinates($pointString) {
        $coordinates = explode('|', $pointString);
        return array('y' => $coordinates[0], 'x' => $coordinates[1]);
    }
	
	public function clearLocal() {
		$this->location_id = '';
		$this->location_email = '';
		$this->local_info = '';
		$this->search_query = '';
		$this->distance = '';
		$this->opening_hours = '';			
		$this->opening_time = '';
		$this->closing_time = '';
		$this->opened = FALSE;			
		$this->current_day = '';
		$this->current_date = '';
		$this->current_time = '';
	}
}

// END Location Class

/* End of file Location.php */
/* Location: ./application/libraries/Location.php */