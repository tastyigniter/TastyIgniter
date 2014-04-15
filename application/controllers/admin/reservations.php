<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Reservations extends CI_Controller {

	private $error = array();

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		$this->load->library('pagination');
		$this->load->model('Reservations_model');
		$this->load->model('Statuses_model');
	}

	public function index() {
	
		if (!file_exists(APPPATH .'views/admin/reservations.php')) {
			show_404();
		}
			
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}
		
    	if (!$this->user->hasPermissions('access', 'admin/reservations')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else { 
			$data['alert'] = '';
		}

		$filter = array();
		if ($this->input->get('page')) {
			$filter['page'] = (int) $this->input->get('page');
		} else {
			$filter['page'] = 1;
		}
		
		if ($this->config->item('page_limit')) {
			$filter['limit'] = $this->config->item('page_limit');
		}
				
		if ($this->input->get('location')) {
			$filter['location'] = $this->input->get('location');
		}
		
		if ($this->input->get('reserve_date')) {
			$filter['reserve_date'] = $this->input->get('reserve_date');
		}
		
		$data['heading'] 				= 'Reservations';
		$data['sub_menu_delete'] 		= 'Delete';
		$data['sub_menu_list'] 			= '<a class="calendar_switch" title="Switch to calender view" href="'.site_url('admin/reservations/calendar') .'"></a><a class="list_switch active" title="Switch to list view" href="'.site_url('admin/reservations') .'"></a>';
		$data['text_empty'] 			= 'There are no reservations available.';
		
		$data['reservations'] = array();
		$results = $this->Reservations_model->getList($filter);
		foreach ($results as $result) {					
			$current_date = mdate('%d-%m-%Y', time());
			$reserve_date = mdate('%d-%m-%Y', strtotime($result['reserve_date']));
			
			if ($current_date === $reserve_date) {
				$reserve_date = 'Today';
			} else {
				$reserve_date = mdate('%d %M %y', strtotime($reserve_date));
			}
			
			$data['reservations'][] = array(
				'reservation_id'	=> $result['reservation_id'],
				'location_name'		=> $result['location_name'],
				'first_name'		=> $result['first_name'],
				'last_name'			=> $result['last_name'],
				'guest_num'			=> $result['guest_num'],
				'table_name'		=> $result['table_name'],
				'status_name'		=> $result['status_name'],
				'staff_name'		=> $result['staff_name'],
				'reserve_date'		=> $reserve_date,
				'reserve_time'		=> mdate('%H:%i', strtotime($result['reserve_time'])),
				'edit'				=> $this->config->site_url('admin/reservations/edit?id=' . $result['reservation_id'])
			);
		}
				
		$config['base_url'] 		= $this->config->site_url('admin/reservations');
		$config['total_rows'] 		= $this->Reservations_model->record_count($filter);
		$config['per_page'] 		= $filter['limit'];
		$config['num_links'] 		= round($config['total_rows'] / $config['per_page']);
		
		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		if ($this->input->post('delete') && $this->_deleteReservation() === TRUE) {
			
			redirect('admin/reservations');
		}	

		$regions = array(
			'admin/header',
			'admin/footer'
		);
		
		$this->template->regions($regions);
		$this->template->load('admin/reservations', $data);
	}	

	public function calendar() {
		$this->load->library('calendar');
		$this->load->model('Locations_model');
		$this->load->model('Tables_model');

		if (!file_exists(APPPATH .'views/admin/reservations_calendar.php')) {
			show_404();
		}
			
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}
		
    	if (!$this->user->hasPermissions('access', 'admin/reservations')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else { 
			$data['alert'] = '';
		}

		if (is_numeric($this->input->get('year'))) {
			$data['year'] = $this->input->get('year');
		} else {
		    $data['year'] = date('Y');
		}
		
		if (is_numeric($this->input->get('month'))) {
			$data['month'] = $this->input->get('month');
		} else {
		    $data['month'] = date('m');
		}
		
		if (is_numeric($this->input->get('location'))) {
			$data['location_id'] = $this->input->get('location');
		} else {
		    $data['location_id'] = '';
		}
		
		$data['heading'] 				= 'Reservations - Calendar';
		$data['sub_menu_list'] 			= '<a class="calendar_switch active" title="Switch to calender view" href="'.site_url('admin/reservations/calendar') .'"></a> <a class="list_switch" title="Switch to list view" href="'.site_url('admin/reservations') .'"></a>';
		$data['action']					= $this->config->site_url('admin/reservations/edit?id=');
		
		$data['days'] = $this->calendar->get_total_days($data['month'], $data['year']);
		$data['months'] = array('01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December');
		$data['years'] = array('2011', '2012', '2013', '2014', '2015', '2016', '2017');
		
		$total_tables = $this->Tables_model->getTotalSeatsByLocation($data['location_id']);
		
		$calendar_data = array();
		for ($i = 1; $i <= $data['days']; $i++) {
			$date = $data['year'] . '-' . $data['month'] . '-' . $i;
			$reserve_date = mdate('%Y-%m-%d', strtotime($date));
			$total_guests = $this->Reservations_model->getTotalLocationGuests($data['location_id'], $reserve_date);					

			if ($total_guests >= $total_tables) {
				$calendar_data[$i]  = 'booked';
			} else if ($total_guests > 0 AND $total_guests < $total_tables) {
				$calendar_data[$i]  = 'half_booked';
			} else {
				$calendar_data[$i]  = 'no_booking';
			}
		}

		$data['calendar'] = $this->calendar->generate($data['year'], $data['month'], $calendar_data);

		$data['locations'] = array();
		$results = $this->Locations_model->getLocations();
		foreach ($results as $result) {					
			$data['locations'][] = array(
				'location_id'	=>	$result['location_id'],
				'location_name'	=>	$result['location_name'],
			);
		}

		$regions = array(
			'admin/header',
			'admin/footer'
		);
		
		$this->template->regions($regions);
		$this->template->load('admin/reservations_calendar', $data);
	}
	
	public function edit() {
		
		$data['text_empty'] 		= 'There are no status history for this order.';
		if (!file_exists(APPPATH .'views/admin/reservations_edit.php')) {
			show_404();
		}
			
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/reservations')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else { 
			$data['alert'] = '';
		}		

		if (is_numeric($this->input->get('id'))) {
			$reservation_id = $this->input->get('id');
			$data['action']	= $this->config->site_url('admin/reservations/edit?id='. $reservation_id);
		} else {
		    $reservation_id = 0;
			//$data['action']	= $this->config->site_url('admin/reservations/edit');
			redirect('admin/reservations');
		}
		
		$result = $this->Reservations_model->getAdminReservation($reservation_id);

		$data['heading'] 			= 'Reservation - '. $result['table_name'] .'-'.$result['reservation_id'];
		$data['sub_menu_save'] 		= 'Save';
		$data['sub_menu_back'] 		= $this->config->site_url('admin/reservations');
		$data['text_empty'] 		= 'There are no status history for this reservation.';

		$data['reservation_id'] 	= $result['table_name'] .'-'.$result['reservation_id'];
		$data['location_name'] 		= $result['location_name'];
		$data['location_address_1'] = $result['location_address_1'];
		$data['location_address_2'] = $result['location_address_2'];
		$data['location_city'] 		= $result['location_city'];
		$data['location_postcode'] 	= $result['location_postcode'];
		$data['location_country'] 	= $result['location_country_id'];
		$data['table_name'] 		= $result['table_name'];
		$data['min_capacity'] 		= $result['min_capacity'] .' person(s)';
		$data['max_capacity'] 		= $result['max_capacity'] .' person(s)';
		$data['guest_num'] 			= $result['guest_num'] .' person(s)';
		$data['occasion'] 			= $result['occasion_id'];
		$data['customer_id'] 		= $result['customer_id'];
		$data['first_name'] 		= $result['first_name'];
		$data['last_name'] 			= $result['last_name'];
		$data['email'] 				= $result['email'];
		$data['telephone'] 			= $result['telephone'];
		$data['reserve_time'] 		= mdate('%H:%i', strtotime($result['reserve_time']));
		$data['reserve_date'] 		= mdate('%d %M %y', strtotime($result['reserve_date']));
		$data['date_added'] 		= mdate('%d %M %y', strtotime($result['date_added']));
		$data['date_modified'] 		= mdate('%d %M %y', strtotime($result['date_modified']));
		$data['status_id'] 			= $result['status'];
		$data['staff_id'] 			= $result['staff_id'];
		$data['comment'] 			= $result['comment'];
		$data['notify'] 			= $result['notify'];
		$data['ip_address'] 		= $result['ip_address'];
		$data['user_agent'] 		= $result['user_agent'];
		
		$data['occasions'] = array(
			'0' => 'not applicable',
			'1' => 'birthday',
			'2' => 'anniversary',
			'3' => 'general celebration',
			'4' => 'hen party',
			'5' => 'stag party'
		);

		$data['statuses'] = array();
		$statuses = $this->Statuses_model->getStatuses('reserve');
		foreach ($statuses as $status) {
			$data['statuses'][] = array(
				'status_id'	=> $status['status_id'],
				'status_name'	=> $status['status_name']
			);
		}

		$data['status_history'] = array();
		$status_history = $this->Statuses_model->getStatusHistories('reserve', $reservation_id);
		foreach ($status_history as $history) {
			$data['status_history'][] = array(
				'history_id'	=> $history['status_history_id'],
				'date_time'		=> mdate('%d %M %y - %H:%i', strtotime($history['date_added'])),
				'staff_name'	=> $history['staff_name'],
				'assigned_id'	=> $history['assigned_id'],
				'status_name'	=> $history['status_name'],
				'notify'		=> $history['notify'],
				'comment'		=> $history['comment']
			);
		}

		$this->load->model('Staffs_model');
		$data['staffs'] = array();
		$staffs = $this->Staffs_model->getStaffs();
		foreach ($staffs as $staff) {
			$data['staffs'][] = array(
				'staff_id'		=> $staff['staff_id'],
				'staff_name'	=> $staff['staff_name']
			);
		}

		// check if POST add_food, validate fields and add Food to model
		if ($this->input->post() && $this->_updateReservation($data['status_id']) === TRUE) {
	
			redirect('admin/reservations');
		}
				
		$regions = array(
			'admin/header',
			'admin/footer'
		);
		
		$this->template->regions($regions);
		$this->template->load('admin/reservations_edit', $data);
	}
	
	public function _updateReservation($status_id = 0) {
    	if (!$this->user->hasPermissions('modify', 'admin/reservations')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have the right permission to edit!</p>');
			return TRUE;
    	} else if ( ! $this->input->post('delete') AND $this->validateForm() === TRUE) { 
			$update = array();
			$history = array();
			$current_time = time();
			
			$update['reservation_id'] 	= (int)$this->input->get('id');
			$update['status'] 			= (int)$this->input->post('status');
			$update['staff_id'] 		= (int)$this->input->post('assigned_staff');
			$update['date_modified'] 	=  mdate('%Y-%m-%d', $current_time);
		
			if ($status_id !== $this->input->post('status')) {
				$status = $this->Statuses_model->getStatus($this->input->post('status'));
				$history['staff_id']	= $this->user->getStaffId();
				$history['assigned_id']	= (int)$this->input->post('assigned_staff');
				$history['order_id'] 	= (int)$this->input->get('id');
				$history['status_id']	= (int)$this->input->post('status');
				$history['notify']		= (int)$this->input->post('notify');
				$history['comment']		= $status['status_comment'];
				$history['date_added']	= mdate('%Y-%m-%d %H:%i:%s', $current_time);
				
				$this->Statuses_model->addStatusHistory('reserve', $history);
			}

			if ($this->Reservations_model->updateReservation($update)) {
				$this->session->set_flashdata('alert', '<p class="success">Reservation Updated Sucessfully!</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');
			}
	
			return TRUE;
		}
	}

	public function _deleteReservation($reservation_id = FALSE) {
    	if (!$this->user->hasPermissions('modify', 'admin/reservations')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have the right permission to edit!</p>');
    	
    	} else { 
			if (is_array($this->input->post('delete'))) {
				foreach ($this->input->post('delete') as $key => $value) {
					$reservation_id = $value;            	
					$this->Reservations_model->deleteReservation($reservation_id);
				}			
			
				$this->session->set_flashdata('alert', '<p class="success">Reservation Deleted Sucessfully!</p>');
			}
		}
				
		return TRUE;
	}

	public function validateForm() {
		$this->form_validation->set_rules('status', 'Reservation Status', 'trim|required|integer');
		$this->form_validation->set_rules('assigned_staff', 'Assign Staff', 'trim|integer');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}		
	}
}