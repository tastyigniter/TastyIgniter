<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Reservations extends MX_Controller {

	public function __construct() {
		parent::__construct(); 																	//  calls the constructor
		$this->load->library('customer'); 														// load the customer library
		$this->load->library('currency'); 														// load the currency library
		$this->load->library('language');
		$this->load->model('Reservations_model');														// load orders model
		$this->lang->load('main/reservations', $this->language->folder());
	
		if ($this->config->item('reservation_mode') !== '1') {
			$this->session->set_flashdata('alert', $this->lang->line('alert_no_reservation'));
			redirect('main/account');
		}
	}

	public function index() {
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  								// retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}
		
		if (!$this->customer->isLogged()) {  													// if customer is not logged in redirect to account login page
  			redirect('main/login');
		}

		$url = '?';
		$filter = array();
		$filter['customer_id'] = (int) $this->customer->getId();

		if ($this->input->get('page')) {
			$filter['page'] = (int) $this->input->get('page');
		} else {
			$filter['page'] = '';
		}
		
		if ($this->config->item('page_limit')) {
			$filter['limit'] = $this->config->item('page_limit');
		}

		// START of retrieving lines from language file to pass to view.
		$this->template->setTitle($this->lang->line('text_heading'));
		$this->template->setHeading($this->lang->line('text_heading'));
		$data['text_heading'] 			= $this->lang->line('text_heading');
		$data['text_empty'] 			= $this->lang->line('text_empty');
		$data['text_leave_review'] 		= $this->lang->line('text_leave_review');
		$data['column_id'] 				= $this->lang->line('column_id');
		$data['column_status'] 			= $this->lang->line('column_status');
		$data['column_location'] 		= $this->lang->line('column_location');
		$data['column_date'] 			= $this->lang->line('column_date');
		$data['column_table'] 			= $this->lang->line('column_table');
		$data['column_guest'] 			= $this->lang->line('column_guest');
		$data['button_back'] 			= $this->lang->line('button_back');
		$data['button_reserve'] 		= $this->lang->line('button_reserve');
		// END of retrieving lines from language file to pass to view.

		$data['back'] 					= site_url('main/account');
		$data['new_reserve_url'] 		= site_url('main/reserve_table');

		$data['reservations'] = array();
		$results = $this->Reservations_model->getMainList($filter);								// retrieve customer reservations based on customer id from getMainReservations method in Reservations model
		foreach ($results as $result) {
			$data['reservations'][] = array(													// create array of customer reservations to pass to view
				'reservation_id' 		=> $result['reservation_id'],
				'location_name' 		=> $result['location_name'],
				'status_name' 			=> $result['status_name'],
				'reserve_date' 			=> mdate('%d %M %y', strtotime($result['reserve_date'])),
				'reserve_time'			=> mdate('%H:%i', strtotime($result['reserve_time'])),
				'guest_num'				=> $result['guest_num'],
				'table_name' 			=> $result['table_name'],
				'view' 					=> site_url('main/reservations/view/' . $result['reservation_id']),
				'leave_review' 			=> site_url('main/reviews/add/'. $result['reservation_id'] .'/'. $result['location_id'])
			);
		}
		
		$prefs['base_url'] 			= site_url('main/reservations').$url;
		$prefs['total_rows'] 		= $this->Reservations_model->getMainListCount($filter);
		$prefs['per_page'] 			= $filter['limit'];
		
		$this->load->library('pagination');
		$this->pagination->initialize($prefs);
				
		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);
		
		$this->template->regions(array('header', 'content_top', 'content_left', 'content_right', 'footer'));
		if (file_exists(APPPATH .'views/themes/main/'.$this->config->item('main_theme').'reservations.php')) {
			$this->template->render('themes/main/'.$this->config->item('main_theme'), 'reservations', $data);
		} else {
			$this->template->render('themes/main/default/', 'reservations', $data);
		}
	}
	
	public function view() {
		$this->load->library('country');
		$this->load->model('Customers_model');														// load customers model
		$this->load->model('Locations_model');														// load locations model

		if (!$this->customer->isLogged()) {  													// if customer is not logged in redirect to account login page
  			redirect('main/login');
		}

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  								// retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		if ($this->uri->segment(4)) {															// check if customer_id is set in uri string
			$reservation_id = (int)$this->uri->segment(4);
		} else {
  			redirect('main/reservations');
		}

		$result = $this->Reservations_model->getMainReservation($reservation_id, $this->customer->getId());

		// START of retrieving lines from language file to pass to view.
		$this->template->setTitle($this->lang->line('text_view_heading'));
		$this->template->setHeading($this->lang->line('text_view_heading'));
		$data['text_heading'] 			= $this->lang->line('text_view_heading');
		$data['column_id'] 				= $this->lang->line('column_id');
		$data['column_location'] 		= $this->lang->line('column_location');
		$data['column_status'] 			= $this->lang->line('column_status');
		$data['column_date'] 			= $this->lang->line('column_date');
		$data['column_guest'] 			= $this->lang->line('column_guest');
		$data['column_table'] 			= $this->lang->line('column_table');
		$data['column_occasion'] 		= $this->lang->line('column_occasion');
		$data['column_name'] 			= $this->lang->line('column_name');
		$data['column_email'] 			= $this->lang->line('column_email');
		$data['column_telephone'] 		= $this->lang->line('column_telephone');
		$data['column_comment'] 		= $this->lang->line('column_comment');
		$data['button_back'] 			= $this->lang->line('button_back');
		// END of retrieving lines from language file to pass to view.
		
		$data['back_url'] 				= site_url('main/reservations');

		$data['occasions'] = array(
			'0' => 'not applicable',
			'1' => 'birthday',
			'2' => 'anniversary',
			'3' => 'general celebration',
			'4' => 'hen party',
			'5' => 'stag party'
		);

		if ($result) {
			$data['reservation_id'] 	= $result['reservation_id'];
			$data['guest_num'] 			= $result['guest_num'] .' person(s)';
			$data['reserve_date'] 		= mdate('%d %M %y', strtotime($result['reserve_date']));
			$data['reserve_time'] 		= mdate('%H:%i', strtotime($result['reserve_time']));
			$data['occasion_id'] 		= $result['occasion_id'];
			$data['status_name'] 		= $result['status_name'];
			$data['table_name'] 		= $result['table_name'];

			$data['first_name'] 		= $result['first_name'];
			$data['last_name'] 			= $result['last_name'];
			$data['email'] 				= $result['email'];
			$data['telephone'] 			= $result['telephone'];
			$data['comment'] 			= $result['comment'];
				
			$location_address = $this->Locations_model->getLocationAddress($result['location_id']);
			$data['location_name'] = $location_address['location_name'];
			$data['location_address'] = $this->country->addressFormat($location_address);
		} else {
			redirect('main/reservations');
		}	

		$this->template->regions(array('header', 'content_top', 'content_left', 'content_right', 'footer'));
		if (file_exists(APPPATH .'views/themes/main/'.$this->config->item('main_theme').'reservations_view.php')) {
			$this->template->render('themes/main/'.$this->config->item('main_theme'), 'reservations_view', $data);
		} else {
			$this->template->render('themes/main/default/', 'reservations_view', $data);
		}
	}
}

/* End of file reservations.php */
/* Location: ./application/controllers/reservations.php */