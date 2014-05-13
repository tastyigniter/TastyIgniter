<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Reservations extends CI_Controller {

	private $error = array();

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		$this->load->library('pagination');
		$this->load->library('calendar');
		$this->load->model('Reservations_model');
		$this->load->model('Locations_model');
		$this->load->model('Statuses_model');
		$this->load->model('Tables_model');
	}

	public function index() {

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

		$url = '?';
		$filter = array();
		if ($this->input->get('page')) {
			$filter['page'] = (int) $this->input->get('page');
		} else {
			$filter['page'] = '';
		}
		
		if ($this->config->item('page_limit')) {
			$filter['limit'] = $this->config->item('page_limit');
		}
				
		if (is_numeric($this->input->get('show_calendar'))) {
			$filter['show_calendar'] = $this->input->get('show_calendar');
			$data['show_calendar'] = $filter['show_calendar'];
			$url .= 'show_calendar='.$filter['show_calendar'].'&';
		} else {
			$data['show_calendar'] = '';
		}
		
		if ($this->input->get('filter_search')) {
			$filter['filter_search'] = $this->input->get('filter_search');
			$data['filter_search'] = $filter['filter_search'];
			$url .= 'filter_search='.$filter['filter_search'].'&';
		} else {
			$data['filter_search'] = '';
		}
		
		if (is_numeric($this->input->get('filter_status'))) {
			$filter['filter_status'] = $this->input->get('filter_status');
			$data['filter_status'] = $filter['filter_status'];
			$url .= 'filter_status='.$filter['filter_status'].'&';
		} else {
			$filter['filter_status'] = '';
			$data['filter_status'] = '';
		}
		
		if ($this->input->get('filter_date')) {
			$filter['filter_date'] = $this->input->get('filter_date');
			$data['filter_date'] = $filter['filter_date'];
			$url .= 'filter_date='.$filter['filter_date'].'&';
		} else if ($this->input->get('filter_year') AND $this->input->get('filter_month') OR $this->input->get('filter_day')) {
			$filter['filter_year'] = $this->input->get('filter_year');
			$filter['filter_month'] = $this->input->get('filter_month');
			$filter['filter_day'] = $this->input->get('filter_day');
		    $data['filter_year'] = $filter['filter_year'];
		    $data['filter_month'] = $filter['filter_month'];
		    $data['filter_day'] = $filter['filter_day'];
		} else {
			$filter['filter_date'] = '';
			$data['filter_date'] = '';
		    $filter['filter_year'] = $filter['filter_month'] = $filter['filter_day'] = '';
		    $data['filter_year'] = $data['filter_month'] = $data['filter_day'] = '';
		}
		
		if (is_numeric($this->input->get('filter_location'))) {
			$filter['filter_location'] = $this->input->get('filter_location');
			$data['filter_location'] = $filter['filter_location'];
			$url .= 'filter_location='.$filter['filter_location'].'&';
		} else {
			$filter['filter_location'] = '';
			$data['filter_location'] = '';
		}
		
		if ($this->input->get('sort_by')) {
			$filter['sort_by'] = $this->input->get('sort_by');
			$data['sort_by'] = $filter['sort_by'];
		} else {
			$filter['sort_by'] = '';
			$data['sort_by'] = '';
		}
		
		if ($this->input->get('order_by')) {
			$filter['order_by'] = $this->input->get('order_by');
			$data['order_by_active'] = strtolower($this->input->get('order_by')) .' active';
			$data['order_by'] = strtolower($this->input->get('order_by'));
		} else {
			$filter['order_by'] = '';
			$data['order_by_active'] = '';
			$data['order_by'] = 'desc';
		}
		
		$data['heading'] 				= 'Reservations';
		$data['button_delete'] 			= 'Delete';
		$data['text_empty'] 			= 'There are no reservations available.';
		
		$order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'DESC') ? 'ASC' : 'DESC';
		$data['sort_id'] 			= site_url('admin/reservations'.$url.'sort_by=reservation_id&order_by='.$order_by);
		$data['sort_location'] 		= site_url('admin/reservations'.$url.'sort_by=location_name&order_by='.$order_by);
		$data['sort_customer'] 		= site_url('admin/reservations'.$url.'sort_by=first_name&order_by='.$order_by);
		$data['sort_guest'] 		= site_url('admin/reservations'.$url.'sort_by=guest_num&order_by='.$order_by);
		$data['sort_table'] 		= site_url('admin/reservations'.$url.'sort_by=table_name&order_by='.$order_by);
		$data['sort_status']		= site_url('admin/reservations'.$url.'sort_by=status_name&order_by='.$order_by);
		$data['sort_staff'] 		= site_url('admin/reservations'.$url.'sort_by=staff_name&order_by='.$order_by);
		$data['sort_date'] 			= site_url('admin/reservations'.$url.'sort_by=reserve_date&order_by='.$order_by);
		
		if ($this->input->get('show_calendar') === '1') {
			$data['button_list'] = '<a class="calendar_switch active" title="Switch to calender view" href="'.site_url('admin/reservations/') .'"><i class="icon-calendar"></i></a>';
			$day = ($filter['filter_day'] === '') ? date('d', time()) : $filter['filter_day'];
			$month = ($filter['filter_month'] === '') ? date('m', time()) : $filter['filter_month'];
			$year = ($filter['filter_year'] === '') ? date('Y', time()) :  $filter['filter_year'];
			$data['days'] = $this->calendar->get_total_days($month, $year);
			$data['months'] = array('01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December');
			$data['years'] = array('2011', '2012', '2013', '2014', '2015', '2016', '2017');
		
			$total_tables = $this->Reservations_model->getTotalCapacityByLocation($filter['filter_location']);
		
			$calendar_data = array();
			for ($i = 1; $i <= $data['days']; $i++) {
				$date = $year . '-' . $month . '-' . $i;
				$reserve_date = mdate('%Y-%m-%d', strtotime($date));
				$total_guests = $this->Reservations_model->getTotalGuestsByLocation($filter['filter_location'], $reserve_date);					
				$state  = '';
				if ($total_guests < 1) {
					$state  = 'no_booking';
				} else if ($total_guests > 0 AND $total_guests < $total_tables) {
					$state  = 'half_booked';
				} else if ($total_guests >= $total_tables) {
					$state  = 'booked';
				}
			
				$fmt_day = (strlen($i) == 1) ? '0'.$i : $i;
				if ($fmt_day == $day) {
					$calendar_data[$i]  = $state.' selected';
				} else {
					$calendar_data[$i]  = $state;
				}
			}

			$data['calendar'] = $this->calendar->generate($year, $month, $calendar_data, site_url('admin/reservations'), $url);
		} else {
			$data['button_list'] = '<a class="calendar_switch" title="Switch to calender view" href="'.site_url('admin/reservations?show_calendar=1') .'"><i class="icon-calendar"></i></a>';
			$data['calendar'] = '';
		}
		
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
				'edit'				=> site_url('admin/reservations/edit?id=' . $result['reservation_id'])
			);
		}
				
		$data['locations'] = array();
		$results = $this->Locations_model->getLocations();
		foreach ($results as $result) {					
			$data['locations'][] = array(
				'location_id'	=>	$result['location_id'],
				'location_name'	=>	$result['location_name'],
			);
		}

		$data['statuses'] = array();
		$statuses = $this->Statuses_model->getStatuses('reserve');
		foreach ($statuses as $status) {
			$data['statuses'][] = array(
				'status_id'	=> $status['status_id'],
				'status_name'	=> $status['status_name']
			);
		}

		$data['reserve_dates'] = array();
		$reserve_dates = $this->Reservations_model->getReservationDates();
		foreach ($reserve_dates as $reserve_date) {
			$month_year = '';
			$month_year = $reserve_date['year'].'-'.$reserve_date['month'];
			$data['reserve_dates'][$month_year] = mdate('%F %Y', strtotime($reserve_date['reserve_date']));
		}

		if (!empty($filter['sort_by']) AND !empty($filter['order_by'])) {
			$url .= 'sort_by='.$filter['sort_by'].'&';
			$url .= 'order_by='.$filter['order_by'].'&';
		}
		
		$config['base_url'] 		= site_url('admin/reservations').$url;
		$config['total_rows'] 		= $this->Reservations_model->record_count($filter);
		$config['per_page'] 		= $filter['limit'];
		
		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		if ($this->input->post('delete') && $this->_deleteReservation() === TRUE) {
			redirect('admin/reservations');
		}	

		$regions = array('header', 'footer');
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'reservations.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'reservations', $regions, $data);
		} else {
			$this->template->render('themes/admin/default/', 'reservations', $regions, $data);
		}
	}	

	public function edit() {

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
			$data['action']	= site_url('admin/reservations/edit?id='. $reservation_id);
		} else {
		    $reservation_id = 0;
			//$data['action']	= site_url('admin/reservations/edit');
			redirect('admin/reservations');
		}
		
		$result = $this->Reservations_model->getAdminReservation($reservation_id);

		$data['heading'] 			= 'Reservation - '. $result['table_name'] .'-'.$result['reservation_id'];
		$data['button_save'] 		= 'Save';
		$data['button_save_close'] 	= 'Save & Close';
		$data['sub_menu_back'] 		= site_url('admin/reservations');
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

		if ($this->input->post() && $this->_updateReservation($data['status_id'], $data['staff_id']) === TRUE) {
			if ($this->input->post('save_close') === '1') {
				redirect('admin/reservations');
			}
			
			redirect('admin/reservations/edit?id='. $reservation_id);
		}
				
		$regions = array('header', 'footer');
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'reservations_edit.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'reservations_edit', $regions, $data);
		} else {
			$this->template->render('themes/admin/default/', 'reservations_edit', $regions, $data);
		}
	}
	
	public function _updateReservation($status_id = 0, $staff_id = 0) {
    	if (!$this->user->hasPermissions('modify', 'admin/reservations')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to update!</p>');
			return TRUE;
    	} else if ( ! $this->input->post('delete') AND $this->validateForm() === TRUE) { 
			$update = array();
			$history = array();
			$current_time = time();
			
			$update['reservation_id'] 	= (int)$this->input->get('id');
			$update['status'] 			= (int)$this->input->post('status');
			$update['staff_id'] 		= (int)$this->input->post('assigned_staff');
			$update['date_modified'] 	=  mdate('%Y-%m-%d', $current_time);
		
			if (($status_id !== $this->input->post('status')) OR ($staff_id !== $this->input->post('assigned_staff'))) {
				$history['staff_id']	= $this->user->getStaffId();
				$history['assigned_id']	= (int)$this->input->post('assigned_staff');
				$history['order_id'] 	= (int)$this->input->get('id');
				$history['status_id']	= (int)$this->input->post('status');
				$history['notify']		= (int)$this->input->post('notify');
				$history['comment']		= $this->input->post('status_comment');
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
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to delete!</p>');
    	
    	} else { 
			if (is_array($this->input->post('delete'))) {
				foreach ($this->input->post('delete') as $key => $value) {
					$reservation_id = $value;            	
					//$this->Reservations_model->deleteReservation($reservation_id);
				}			
			
				$this->session->set_flashdata('alert', '<p class="success">Reservation Deleted Sucessfully!</p>');
			}
		}
				
		return TRUE;
	}

	public function validateForm() {
		$this->form_validation->set_rules('status', 'Reservation Status', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('assigned_staff', 'Assign Staff', 'xss_clean|trim|integer');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}		
	}
}

/* End of file reservations.php */
/* Location: ./application/controllers/admin/reservations.php */