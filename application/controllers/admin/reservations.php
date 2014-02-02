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
	
		if ( !file_exists(APPPATH .'/views/admin/reservations.php')) { //check if file exists in views folder
			show_404(); // Whoops, show 404 error page!
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
		
		if ($this->config->item('config_page_limit')) {
			$filter['limit'] = $this->config->item('config_page_limit');
		}
				
		$data['heading'] 			= 'Reservations';
		$data['sub_menu_add'] 		= 'Add';
		$data['sub_menu_delete'] 	= 'Delete';
		$data['sub_menu_list'] 		= '<li><a href="">Switch to calender view</a></li>';
		$data['text_no_reservations'] = 'There are no reservation(s).';
		
		$data['reservations'] = array();
		$results = $this->Reservations_model->getList($filter);
		foreach ($results as $result) {					
			$data['reservations'][] = array(
				'reservation_id'	=> $result['reservation_id'],
				'first_name'		=> $result['first_name'],
				'last_name'			=> $result['last_name'],
				'location_name'		=> $result['location_name'],
				'guest_num'			=> $result['guest_num'],
				'table_name'		=> $result['table_name'],
				'reserve_date'		=> mdate('%d-%m-%Y', strtotime($result['reserve_date'])),
				'reserve_time'		=> mdate('%H:%i', strtotime($result['reserve_time'])),
				'status_name'		=> $result['status_name'],
				'staff_name'		=> $result['staff_name'],
				'date_added'		=> mdate('%d-%m-%Y', strtotime($result['date_added'])),
				'date_modified'		=> mdate('%d-%m-%Y', strtotime($result['date_modified'])),
				'edit'				=> $this->config->site_url('admin/reservations/edit/' . $result['reservation_id'])
			);
		}
				
		$config['base_url'] 		= $this->config->site_url('admin/reservations');
		$config['total_rows'] 		= $this->Reservations_model->record_count();
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

		$this->load->view('admin/header', $data);
		$this->load->view('admin/reservations', $data);
		$this->load->view('admin/footer');
	}	

	public function edit() {
		
		if ( !file_exists(APPPATH .'/views/admin/reservations_edit.php')) { //check if file exists in views folder
			show_404(); // Whoops, show 404 error page!
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

		if ($this->uri->segment(4)) {
			$reservation_id = (int)$this->uri->segment(4);
		} else {
		    redirect('admin/reservations');
		}
		
		$result = $this->Reservations_model->getAdminReservation($reservation_id);

		if ($result) {
			$data['heading'] 			= 'Reservations';
			$data['sub_menu_update'] 	= 'Update';
			$data['sub_menu_back'] 		= $this->config->site_url('admin/reservations');

			$data['reservation_id'] 	= $result['table_name'] .'-'.$result['reservation_id'];
			$data['location_name'] 		= $result['location_name'];
			$data['location_address_1'] = $result['location_address_1'];
			$data['location_address_2'] = $result['location_address_2'];
			$data['location_city'] 		= $result['location_city'];
			$data['location_postcode'] 	= $result['location_postcode'];
			$data['location_country'] 	= $result['location_country_id'];
			$data['table_name'] 		= $result['table_name'];
			$data['min_capacity'] 		= $result['min_capacity'] .' person(s)';
			$data['max_capacity'] 	= $result['max_capacity'] .' person(s)';
			$data['guest_num'] 			= $result['guest_num'] .' person(s)';
			$data['occasion'] 			= $result['occasion_id'];
			$data['customer_id'] 		= $result['customer_id'];
			$data['first_name'] 		= $result['first_name'];
			$data['last_name'] 			= $result['last_name'];
			$data['email'] 				= $result['email'];
			$data['telephone'] 			= $result['telephone'];
			$data['reserve_time'] 		= mdate('%H:%i', strtotime($result['reserve_time']));
			$data['reserve_date'] 		= mdate('%d-%m-%Y', strtotime($result['reserve_date']));
			$data['date_added'] 		= mdate('%d-%m-%Y', strtotime($result['date_added']));
			$data['date_modified'] 		= mdate('%d-%m-%Y', strtotime($result['date_modified']));
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
			if ($this->input->post() && $this->_updateReservation($reservation_id) === TRUE) {
		
				redirect('admin/reservations');
			}
		}
				
		$this->load->view('admin/header', $data);
		$this->load->view('admin/reservations_edit', $data);
		$this->load->view('admin/footer');
	}
	
	public function _updateReservation($reservation_id) {
			
    	if (!$this->user->hasPermissions('modify', 'admin/reservations')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
			return TRUE;
    	
    	} else if ( ! $this->input->post('delete')) { 
			
			$date_format = '%Y-%m-%d';
			$current_date_time = time();
			
			$this->form_validation->set_rules('status', 'Reservation Status', 'trim|required|integer');
			$this->form_validation->set_rules('assigned_staff', 'Assign Staff', 'trim|integer');

			if ($this->form_validation->run() === TRUE) {
				$update = array();
				
				$update['reservation_id'] = (int)$reservation_id;
				
				$update['status'] = (int)$this->input->post('status');
			
				$update['staff_id'] = (int)$this->input->post('assigned_staff');

				$update['date_modified'] =  mdate($date_format, $current_date_time);
			
				if ($this->Reservations_model->updateReservation($update)) {
			
					$this->session->set_flashdata('alert', '<p class="success">Reservation Updated Sucessfully!</p>');
				} else {

					$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');
				}
		
				return TRUE;
			}
		}
	}

	public function _deleteReservation($reservation_id = FALSE) {
    	if (!$this->user->hasPermissions('modify', 'admin/reservations')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
    	
    	} else { 
		
			if (is_array($this->input->post('delete'))) {

				//sorting the post[quantity] array to rowid and qty.
				foreach ($this->input->post('delete') as $key => $value) {
					$reservation_id = $value;            	
					
					$this->Reservations_model->deleteReservation($reservation_id);
				}			
			
				$this->session->set_flashdata('alert', '<p class="success">Reservation Deleted Sucessfully!</p>');

			}
		}
				
		return TRUE;
	}
}