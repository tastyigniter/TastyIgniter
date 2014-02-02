<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Location {
	private $location_id;
	private $location_email;
	private $local_info;
	private $distance;
	private $opening_hours = array();
	private $opening_time;
	private $closing_time;
	private $opened = FALSE;
	private $datestring = "%Y/%m/%d";
	private $timestring = "%H:%i";
	private $current_day;
	private $current_date;
	private $current_time;
	private $offer_delivery;
	private $offer_collection;
	private $delivery_charge;
	private $min_delivery_total;
	
	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->database();
		$this->CI->load->helper('date');
		$this->CI->load->model('Locations_model');

		$time = now();
		$this->current_day = date('l');
		$this->current_date = mdate($this->datestring, $time);
		$this->current_time = mdate($this->timestring, $time);
		//$this->CI->session->unset_userdata('location_id');
				
		if ($this->CI->session->userdata('local_info')) { 
			$local_info = $this->CI->session->userdata('local_info');
			
			$this->CI->db->where('location_id', $local_info['location_id']);
			$this->CI->db->where('location_name', $local_info['location_name']);
			$query = $this->CI->db->get('locations');
			
			if ($query->num_rows() > 0) {
				$result = $query->row_array();
				
				$this->location_id 			= $result['location_id'];
				$this->location_email 		= $result['location_email'];
				$this->local_info 			= $result;
				$this->distance 			= $local_info['distance'];
				$this->offer_delivery 		= $result['offer_delivery'];
				$this->offer_collection 	= $result['offer_collection'];
				$this->delivery_charge 		= $result['delivery_charge'];
				$this->min_delivery_total 	= $result['min_delivery_total'];

				$this->CI->db->where('location_id', $result['location_id']);
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
	
					$this->opening_hours 		= $opening_hours;
				}
			}		
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

	public function local() {
		return $this->local_info;
	}

	public function distance() {
		if ( ! is_numeric($this->distance)) {
			return FALSE;
		}
		
		$this->distance = number_format($this->distance, 2);
		
		if ($this->CI->config->item('config_distance_unit') === 'km') {
			$this->distance = $this->distance .' Km';
		} else {
			$this->distance = $this->distance .' Miles';
		}
		
		return $this->distance;
	}

	public function openingHours() {
		return $this->opening_hours;	
	}

	public function readyTime() {
		return (isset($this->local_info['ready_time'])) ? $this->local_info['ready_time'] : FALSE;	
	}

	public function openingTime() {
		return $this->opening_time;	
	}

	public function closingTime() {
		return $this->closing_time;	
	}

	public function isOpened() {
		return ($this->opening_time <= $this->current_time && $this->closing_time >= $this->current_time);
	}

	public function checkDeliveryTime($time) {
		$time = mdate($this->timestring, strtotime($time));
    	return $this->opening_time <= $time && $this->closing_time >= $time;    	
	}
	
	public function offerDelivery() {
    	return $this->offer_delivery;    	
	}
	
	public function offerCollection() {
    	return $this->offer_collection;    	
	}
	
	public function checkMinTotal($order_total) {
    	return ($this->min_delivery_total <= $order_total);    	
	}
	
	public function getDeliveryCharge() {
    	return $this->delivery_charge;    	
	}
	
	public function getMinTotal() {
    	return $this->min_delivery_total;    	
	}
	
	public function getHours($start_hour, $end_hour, $interval) {

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

	public function getReserveTimes($reserve_times, $time, $interval, $num) {

		$times = array();
		$time = strtotime($time);
		
		$prev_time = array();
		for ($i = $num; $i >= (1); $i--) {
			$prev = mdate($this->timestring, $time - $interval * 60 * $i);
			
			if (in_array($prev, $reserve_times)) {
				$prev_time[] = $prev;
			}
		}

		$cur_time = array();
		$cur = mdate($this->timestring, $time);
		if (in_array($cur, $reserve_times)) {
			$cur_time[] = $cur;
		}
		
		$next_time = array();
		for ($i = 1; $i <= ($num); $i++) {
			$next = mdate($this->timestring, $time + $interval * 60 * $i);

			if (in_array($next, $reserve_times)) {
				$next_time[] = $next;
			}
		}

		return array_merge($prev_time, $cur_time, $next_time);	
	}

	public function clearLocal() {
		$this->location_id = '';
		$this->local_info = '';
		$this->opening_hours = '';			
		$this->opening_time = '';
		$this->closing_time = '';
		$this->opened = FALSE;			
	}
}