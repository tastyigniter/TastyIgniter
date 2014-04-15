<?php
class Reservations_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

    public function record_count($filter = array()) {
		if (!empty($filter['location'])) {
			$this->db->where('location_id', $filter['location']);
		}
	
		if (!empty($filter['reserve_date'])) {
			$this->db->where('reserve_date', mdate('%Y-%m-%d', strtotime($filter['reserve_date'])));
		}
	
 		$this->db->from('reservations');
		return $this->db->count_all_results();
    }
    
	public function getList($filter = array(), $staff_id = FALSE) {
		if ($filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}
			
		if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->from('reservations');
			$this->db->join('tables', 'tables.table_id = reservations.table_id', 'left');
			$this->db->join('locations', 'locations.location_id = reservations.location_id', 'left');
			$this->db->join('statuses', 'statuses.status_id = reservations.status', 'left');
			$this->db->join('staffs', 'staffs.staff_id = reservations.staff_id', 'left');
			$this->db->order_by('reservations.reserve_date', 'DESC');
		
			if (!empty($filter['location'])) {
				$this->db->where('reservations.location_id', $filter['location']);
			}
	
			if ($staff_id !== FALSE) {
				$this->db->where('staff_id', $staff_id);
			}

			if (!empty($filter['reserve_date'])) {
				$this->db->where('reserve_date', mdate('%Y-%m-%d', strtotime($filter['reserve_date'])));
			}
		
			$query = $this->db->get();
			$result = array();
		
			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}
		
			return $result;
		}
	}
	
	public function getReservations() {
		$this->db->from('reservations');
		$this->db->join('tables', 'tables.table_id = reservations.table_id', 'left');
		$this->db->join('locations', 'locations.location_id = reservations.location_id', 'left');
		$this->db->join('statuses', 'statuses.status_id = reservations.status', 'left');
		$this->db->join('staffs', 'staffs.staff_id = reservations.staff_id', 'left');
		$this->db->order_by('reserve_date', 'ASC');

		$query = $this->db->get();
		$result = array();
	
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}
	
		return $result;
	}

	public function getAdminReservation($reservation_id = FALSE) {
		if ($reservation_id !== FALSE) {
			$this->db->select('reservation_id, table_name, location_name, location_address_1, location_address_2, location_city, location_postcode, location_country_id, table_name, min_capacity, max_capacity, guest_num, occasion_id, customer_id, first_name, last_name, telephone, email, reserve_time, reserve_date, reservations.date_added, reservations.date_modified, reservations.status, staffs.staff_id, comment, notify, ip_address, user_agent');
			$this->db->from('reservations');
			$this->db->join('tables', 'tables.table_id = reservations.table_id', 'left');
			$this->db->join('statuses', 'statuses.status_id = reservations.status', 'left');
			$this->db->join('staffs', 'staffs.staff_id = reservations.staff_id', 'left');
			$this->db->join('locations', 'locations.location_id = reservations.location_id', 'left');
		
			$this->db->where('reservation_id', $reservation_id);			
			$query = $this->db->get();
		
			if ($query->num_rows() > 0) {
				return $query->row_array();
			}
		}
	}

	public function getMainReservations($customer_id = FALSE) {
		if ($customer_id !== FALSE) {
			$this->db->from('reservations');
			$this->db->join('statuses', 'statuses.status_id = orders.status_id', 'left');
			$this->db->join('locations', 'locations.location_id = orders.location_id', 'left');
			$this->db->order_by('order_id', 'ASC');

			$query = $this->db->get();
			$result = array();
		
			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}
		
			return $result;
		}
	}
	
	public function getMainReservation($reservation_id) {
		$this->db->from('reservations');
		$this->db->join('locations', 'locations.location_id = reservations.location_id', 'left');
		$this->db->where('reservations.reservation_id', $reservation_id);
		$this->db->where('reservations.status >', '0');
			
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
	}

	public function getTotalLocationGuests($location_id = FALSE, $date = FALSE) {
		$result = 0;

		$this->db->select_sum('reservations.guest_num', 'total_guest');
		$this->db->where('status', (int)$this->config->item('reserve_status'));
		if (!empty($location_id)) {
			$this->db->where('location_id', $location_id);
		}

		if (!empty($date)) {
			$this->db->where('DATE(reserve_date)', $date);
		}
		
		$this->db->group_by('DAY(reserve_date)'); 
		$this->db->from('reservations');
	
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$row = $query->row_array();
			$result = $row['total_guest'];
		}

		return $result;
	}

	public function checkAvailability($data = array()) {		
				
		$reserved_tables = array();

		$guest_tables = $this->getTablesByGuestNum($data['location'], $data['guest_num']);
		
		if ( ! $guest_tables OR empty($guest_tables)) { 
			return 'NO_GUEST_TABLE';
		}
		
		if (!empty($data)) {
			$this->db->from('reservations');
		}
		
		if (isset($data['location'])) {
			$this->db->where('location_id', $data['location']);		
		}
		
		if (is_array($guest_tables)) {
			$this->db->where_in('table_id', $guest_tables);
		}
		
		if (isset($data['reserve_date'])) {
			$this->db->where('reserve_date', mdate('%Y-%m-%d', strtotime($data['reserve_date'])));
		}

		if (isset($data['reserve_time'])) {
			$this->db->where('reserve_time', mdate('%h:%i:%s', strtotime($data['reserve_time'])));
		}
		
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$row = $query->row_array();

			if (in_array($row['table_id'], $guest_tables)) {
				$reserved_tables[] = $row['table_id'];
			}
		}
		
		$available_tables = array_diff($guest_tables, $reserved_tables);

		if ( ! $available_tables OR empty($available_tables)) { 
			return 'NO_TABLE_AVAIL';
		}

		$reservation = array('tables' => $available_tables);

		return $reservation;
	}

	public function getTotalSeats($location_id) {
		$this->db->select_sum('tables.max_capacity', 'total_seats');
		$this->db->where('location_id', $location_id);
		$this->db->from('location_tables');
		$this->db->join('tables', 'tables.table_id = location_tables.table_id', 'left');
		
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$row = $query->row_array();
			return $row['total_seats'];
		}
	}
	
	public function getTablesByGuestNum($location_id, $num) {	
			
		$tables = array();
		
		if (isset($location_id, $num)) {
			$this->db->from('location_tables');
			$this->db->join('tables', 'tables.table_id = location_tables.table_id', 'left');
		
			$this->db->where('location_id', $location_id);
			$this->db->where('min_capacity <=', $num);
			$this->db->where('max_capacity >=', $num);
			$this->db->order_by('max_capacity', 'ASC');		
		
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				foreach ($query->result_array() as $table) {
					$tables[] = $table['table_id'];
				}
			}		
		}

		return $tables;
	}

	public function addReservation($add = array()) {
		if (!empty($add['location_id'])) {
			$this->db->set('location_id', $add['location_id']);
		}

		if (!empty($add['table_id'])) {
			$this->db->set('table_id', $add['table_id']);
		}

		if (!empty($add['customer_id'])) {
			$this->db->set('customer_id', $add['customer_id']);
		}

		if (!empty($add['guest_num'])) {
			$this->db->set('guest_num', $add['guest_num']);
		}

		if (!empty($add['reserve_date'])) {
			$this->db->set('reserve_date', $add['reserve_date']);
		}

		if (!empty($add['reserve_time'])) {
			$this->db->set('reserve_time', $add['reserve_time']);
		}

		if (!empty($add['date_added'])) {
			$this->db->set('date_added', $add['date_added']);
		}

		if (!empty($add['date_modified'])) {
			$this->db->set('date_modified', $add['date_modified']);
		}

		if (!empty($add['occasion_id'])) {
			$this->db->set('occasion_id', $add['occasion_id']);
		}

		if (!empty($add['customer_id'])) {
			$this->db->set('customer_id', $add['customer_id']);
		}

		if (!empty($add['first_name'])) {
			$this->db->set('first_name', $add['first_name']);
		}

		if (!empty($add['last_name'])) {
			$this->db->set('last_name', $add['last_name']);
		}

		if (!empty($add['email'])) {
			$this->db->set('email', $add['email']);
		}

		if (!empty($add['telephone'])) {
			$this->db->set('telephone', $add['telephone']);
		}

		if (!empty($add['comment'])) {
			$this->db->set('comment', $add['comment']);
		}

		if (!empty($add['user_agent'])) {
			$this->db->set('user_agent', $add['user_agent']);
		}

		if (!empty($add['ip_address'])) {
			$this->db->set('ip_address', $add['ip_address']);
		}

		$this->db->insert('reservations');

		if ($this->db->affected_rows() > 0) {
			$reservation_id = $this->db->insert_id();

			$email = array(
				'reservation_id' => $reservation_id,
				'location_id' 	=> $add['location_id'],
				'customer_name' => $add['first_name'] .' '. $add['last_name'],
				'table_id' 		=> $add['table_id'],
				'guest_num' 	=> $add['guest_num'],
				'reserve_date' 	=> $add['reserve_date'],
				'reserve_time' 	=> $add['reserve_time'],
				'email' 		=> $add['email']
			);

			$notify = $this->_sendMail($reservation_id);
			$this->db->set('notify', $notify);
		
			$this->db->set('status', $this->config->item('reserve_status'));
			$this->db->where('reservation_id', $email['reservation_id']);
			$this->db->update('reservations');
					
			$this->load->model('Statuses_model');
			$status = $this->Statuses_model->getStatus($status_id);
			$reserve_history = array(
				'order_id' 		=> $reservation_id, 
				'status_id' 	=> $status_id, 
				'notify' 		=> $notify, 
				'comment' 		=> $status['comment'], 
				'date_added' 	=> mdate('%Y-%m-%d %H:%i:%s', time())
			);
			$this->Statuses_model->addStatusHistory('reserve', $reserve_history);
			
			return $reservation_id;
		}
	}
	
	public function updateReservation($update = array()) {

		if (!empty($update['status'])) {
			$this->db->set('status', $update['status']);
		}
		
		if (!empty($update['staff_id'])) {
			$this->db->set('staff_id', $update['staff_id']);
		}
		
		if (!empty($update['date_modified'])) {
			$this->db->set('date_modified', $update['date_modified']);
		}
		
		if (!empty($update['reservation_id'])) {
			$this->db->where('reservation_id', $update['reservation_id']);
			$this->db->update('reservations');
		}	

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}
	
	public function deleteReservation($reservation_id) {
		$this->db->where('reservation_id', $reservation_id);
			
		return $this->db->delete('reservations');
	}

	public function _sendMail($email) {
		//loading upload library
	   	$this->load->library('email');
		$this->load->model('Customers_model');
		$this->load->model('Locations_model');
		$this->load->model('Tables_model');
		$this->lang->load('main/reserve_table');

		//setting upload preference
		$this->email->set_protocol($this->config->item('protocol'));
		$this->email->set_mailtype($this->config->item('mailtype'));
		$this->email->set_smtp_host($this->config->item('smtp_host'));
		$this->email->set_smtp_port($this->config->item('smtp_port'));
		$this->email->set_smtp_user($this->config->item('smtp_user'));
		$this->email->set_smtp_pass($this->config->item('smtp_pass'));
		$this->email->set_newline("\r\n");
		$this->email->initialize();
		
		$location 		= $this->Locations_model->getLocation($email['location_id']);
		$table 			= $this->Tables_model->getTable($email['table_id']);
		
		if ($this->config->item('reserve_prefix') === '1') {
			$reservation_id = $table['table_name'] .'-'. $email['reservation_id'];
		} else {
			$reservation_id = $email['reservation_id'];
		}

		$customer_name 	= $email['customer_name'];
		$guest_num 		= $email['guest_num'] .' person(s)';
		$reserve_date 	= $email['reserve_date'];
		$reserve_time 	= $email['reserve_time'];
						
		$data['text_success'] = sprintf($this->lang->line('text_success'), $location['location_name'], $guest_num, mdate('%l, %F %j, %Y', strtotime($reserve_date)), $reserve_time);
		$data['text_greetings'] = sprintf($this->lang->line('text_greetings'), $customer_name);
		$data['text_signature'] = sprintf($this->lang->line('text_signature'), $this->config->item('site_name'));
		
		$subject = sprintf($this->lang->line('text_subject'), $reservation_id);
		$message = $this->load->view('main/reservation_email', $data, TRUE);

		$this->email->from($this->config->item('site_email'), $this->config->item('site_name'));

		if ($this->config->item('send_reserve_email') === '1') {
			$this->email->cc($this->location->getEmail());
		}
		
		$this->email->to(strtolower($email['email']));

		$this->email->subject($subject);
		$this->email->message($message);
	   	//$this->email->message( $this->load->view( 'emails/message', $data, true ) );

		if ( ! $this->email->send()) {
			$notify = '0';
		} else {
			$notify = '1';
		}			
		
		return $notify;
	}
}