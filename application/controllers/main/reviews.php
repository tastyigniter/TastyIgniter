<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reviews extends MX_Controller {

	public function __construct() {
		parent::__construct(); 																	//  calls the constructor
		$this->load->library('customer'); 														// load the customer library
		$this->load->model('Reviews_model');													// loads messages model
	}

	public function index() {
		$this->lang->load('main/reviews');  														// loads language file
		
		if (!file_exists(APPPATH .'views/main/reviews.php')) {
			show_404();
		}
			
		if (!$this->customer->isLogged()) {  													// if customer is not logged in redirect to account login page
  			redirect('account/login');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  								// retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		// START of retrieving lines from language file to pass to view.
		$data['text_heading'] 			= $this->lang->line('text_heading');
		$data['text_view'] 				= $this->lang->line('text_view');
		$data['text_empty'] 			= $this->lang->line('text_empty');
		$data['column_order_id'] 		= $this->lang->line('column_order_id');
		$data['column_restaurant'] 		= $this->lang->line('column_restaurant');
		$data['column_rating'] 			= $this->lang->line('column_rating');
		$data['column_date'] 			= $this->lang->line('column_date');
		$data['column_action'] 			= $this->lang->line('column_action');
		$data['button_back'] 			= $this->lang->line('button_back');
		// END of retrieving lines from language file to pass to view.

		$data['back'] 					= $this->config->site_url('account');

		$data['ratings'] = $this->config->item('ratings');
		
		$data['reviews'] = array();
		$results = $this->Reviews_model->getMainReviews($this->customer->getId());							// retrieve all customer messages from getMainInbox method in Messages model
		foreach ($results as $result) {					
			$data['reviews'][] = array(														// create array of customer messages to pass to view
				'order_id'			=> $result['order_id'],
				'location_name'		=> $result['location_name'],
				'quality' 			=> $result['quality'],
				'delivery' 			=> $result['delivery'],
				'service' 			=> $result['service'],
				'date'				=> mdate('%H:%i - %d %M %y', strtotime($result['date_added'])),
				'view' 				=> $this->config->site_url('account/reviews/view?order_id='. $result['order_id'] .'&location_id='. $result['location_id'] .'&review_id='. $result['review_id'])
			);
		}

		$regions = array('main/header', 'main/content_left', 'main/footer');
		$this->template->regions($regions);
		$this->template->load('main/reviews', $data);
	}

	public function view() {
		$this->lang->load('main/reviews');  														// loads language file

		if (!file_exists(APPPATH .'views/main/review_view.php')) {
			show_404();
		}
			
		if (!$this->customer->isLogged()) {  													// if customer is not logged in redirect to account login page
  			redirect('account/login');
		}

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  								// retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		if ($this->uri->segment(4)) {															// check if customer_id is set in uri string
			$review_id = (int)$this->uri->segment(4);
		} else {
  			redirect('account/reviews');
		}

		// START of retrieving lines from language file to pass to view.
		$data['text_heading'] 			= $this->lang->line('text_view_heading');
		$data['column_date'] 			= $this->lang->line('column_date');
		$data['column_time'] 			= $this->lang->line('column_time');
		$data['column_subject'] 		= $this->lang->line('column_subject');
		$data['button_back'] 			= $this->lang->line('button_back');
		// END of retrieving lines from language file to pass to view.

		$data['back'] 					= $this->config->site_url('account/reviews');

		$result = $this->Reviews_model->getMainReview($review_id, $this->customer->getId());								// retrieve specific customer message based on message id to be passed to view
		$data['location_name'] 		= $result['location_name'];
		$data['rating_name'] 		= $result['rating_name'];
		$data['date'] 				= mdate('%H:%i - %d %M %y', strtotime($result['date_added']));
		$data['review_text'] 		= $result['review_text'];
		
		$regions = array('main/header', 'main/content_left', 'main/footer');
		$this->template->regions($regions);
		$this->template->load('main/review_view', $data);
	}

	public function add() {
		$this->lang->load('main/reviews');  														// loads language file
	
		if ( !file_exists(APPPATH .'/views/main/review_add.php')) { 						//check if file exists in views folder
			show_404(); // Whoops, show 404 error page!
		}

		if (!$this->customer->isLogged()) {  													// if customer is not logged in redirect to account login page
  			redirect('account/login');
		}
		
		$order_id = $this->input->get('order_id');
		$location_id = $this->input->get('location_id');

		$data['action']	= $this->config->site_url('account/reviews/add?order_id='. $order_id .'&location_id='. $location_id);
		
		if ( ! $this->Reviews_model->checkCustomerReview($this->customer->getId(), $location_id, $order_id)) {
			$data['error'] = '<p class="error">Sorry. Either you\'ve already rated this order, or an error has occurred.</p>';
		} else {
			$data['error'] = '';
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  								// retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		// START of retrieving lines from language file to pass to view.
		$data['text_heading'] 			= $this->lang->line('text_review_heading');
		$data['text_write_review'] 		= $this->lang->line('text_write_review');
		$data['entry_customer_name'] 	= $this->lang->line('entry_customer_name');
		$data['entry_restaurant'] 		= $this->lang->line('entry_restaurant');
		$data['entry_quality'] 			= $this->lang->line('entry_quality');
		$data['entry_delivery'] 		= $this->lang->line('entry_delivery');
		$data['entry_service'] 			= $this->lang->line('entry_service');
		$data['entry_review'] 			= $this->lang->line('entry_review');
		$data['button_back'] 			= $this->lang->line('button_back');
		$data['button_review'] 			= $this->lang->line('button_review');
		// END of retrieving lines from language file to send to view.

		$data['back'] 					= $this->config->site_url('account/reviews');

		$data['customer_id'] = $this->customer->getId();									// retriveve customer id from customer library
		$data['customer_name'] = $this->customer->getFirstName() .' '. $this->customer->getLastName(); // retrieve and concatenate customer's first and last name from customer library

		$this->load->model('Locations_model');	    
		$result = $this->Locations_model->getLocation($location_id);

		$data['location_id'] 			= $result['location_id'];
		$data['restaurant_name'] 		= $result['location_name'];
		
		//create array of ratings data to pass to view
		$data['ratings'] = $this->config->item('ratings');
		
		if ($this->input->post() AND $this->_addReview() === TRUE) {
			redirect('account/reviews');
		}	

		$regions = array('main/header', 'main/content_left', 'main/footer');
		$this->template->regions($regions);
		$this->template->load('main/review_add', $data);
	}

	public function _addReview() {
		//validate category value
		$this->form_validation->set_rules('quality', 'Quality Rating', 'trim|required|integer');
		$this->form_validation->set_rules('delivery', 'Delivery Rating', 'trim|required|integer');
		$this->form_validation->set_rules('service', 'Service Rating', 'trim|required|integer');
		$this->form_validation->set_rules('review_text', 'Rating Text', 'trim|required|min_length[2]|max_length[1028]');

		if ($this->form_validation->run() === TRUE) {
			$add = array();
			$add['order_id'] 			= (int) $this->input->get('order_id');
			$add['location_id'] 		= (int) $this->input->get('location_id');
			$add['customer_id'] 		= $this->input->post('customer_id');
			$add['author'] 				= $this->customer->getFirstName() .' '. $this->customer->getLastName();
			$add['quality'] 			= $this->input->post('quality');
			$add['delivery'] 			= $this->input->post('delivery');
			$add['service'] 			= $this->input->post('service');
			$add['review_text'] 		= $this->input->post('review_text');

			if ($this->config->item('approve_reviews') === '1') {			
				$add['review_status'] = '0';
			} else {
				$add['review_status'] = '1';
			}
			
			if ($this->Reviews_model->addReview($add)) {	
				$this->session->set_flashdata('alert', '<p class="success">Review Sent Sucessfully!</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="warning">An error has occured, please try again!</p>');
			}
			
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file reviews.php */
/* Location: ./application/controllers/main/reviews.php */