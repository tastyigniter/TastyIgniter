<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reviews extends MX_Controller {

	public function __construct() {
		parent::__construct(); 																	//  calls the constructor
		$this->load->library('customer'); 														// load the customer library
		$this->load->model('Reviews_model');													// loads messages model
	}

	public function index() {
		$this->lang->load('main/reviews');  														// loads language file
		
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

		$data['back'] 					= site_url('main/account');

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
				'view' 				=> site_url('main/reviews/view/'. $result['review_id'] .'/'. $result['order_id'] .'/'. $result['location_id'])
			);
		}

		$regions = array('header', 'content_top', 'content_left', 'content_right', 'footer');
		if (file_exists(APPPATH .'views/themes/main/'.$this->config->item('main_theme').'reviews.php')) {
			$this->template->render('themes/main/'.$this->config->item('main_theme'), 'reviews', $regions, $data);
		} else {
			$this->template->render('themes/main/default/', 'reviews', $regions, $data);
		}
	}

	public function view() {
		$this->lang->load('main/reviews');  														// loads language file

		if (!$this->customer->isLogged()) {  													// if customer is not logged in redirect to account login page
  			redirect('account/login');
		}

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  								// retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		$review_id = (int)$this->uri->segment(4);
		$order_id = (int)$this->uri->segment(5);
		$location_id = (int)$this->uri->segment(6);

		$result = $this->Reviews_model->getCustomerReview($this->customer->getId(), $review_id, $order_id, $location_id);								// retrieve specific customer message based on message id to be passed to view
		if ( ! $result) {																		// check if customer_id is set in uri string
  			redirect('account/reviews');
		}

		// START of retrieving lines from language file to pass to view.
		$data['text_heading'] 			= $this->lang->line('text_view_review');
		$data['column_date'] 			= $this->lang->line('column_date');
		$data['column_time'] 			= $this->lang->line('column_time');
		$data['column_subject'] 		= $this->lang->line('column_subject');
		$data['button_back'] 			= $this->lang->line('button_back');
		// END of retrieving lines from language file to pass to view.

		$data['back'] 					= site_url('main/reviews');

		$ratings = $this->config->item('ratings');

		$data['location_name'] 			= $result['location_name'];
		$data['order_id'] 				= $result['order_id'];
		$data['author'] 				= $result['author'];
		$data['quality_rating'] 		= $ratings[$result['quality']];
		$data['delivery_rating'] 		= $ratings[$result['delivery']];
		$data['service_rating'] 		= $ratings[$result['service']];
		$data['date'] 					= mdate('%H:%i - %d %M %y', strtotime($result['date_added']));
		$data['review_text'] 			= $result['review_text'];
		
		$regions = array('header', 'content_top', 'content_left', 'content_right', 'footer');
		if (file_exists(APPPATH .'views/themes/main/'.$this->config->item('main_theme').'review_view.php')) {
			$this->template->render('themes/main/'.$this->config->item('main_theme'), 'review_view', $regions, $data);
		} else {
			$this->template->render('themes/main/default/', 'review_view', $regions, $data);
		}
	}

	public function add() {
		$this->lang->load('main/reviews');  														// loads language file
	
		if (!$this->customer->isLogged()) {  													// if customer is not logged in redirect to account login page
  			redirect('account/login');
		}
		
		$order_id = $this->uri->segment(4);
		$location_id = $this->uri->segment(5);

		$data['action']	= site_url('main/reviews/add/'. $order_id .'/'. $location_id);
		
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
		$data['text_heading'] 			= $this->lang->line('text_write_review');
		$data['entry_customer_name'] 	= $this->lang->line('entry_customer_name');
		$data['entry_restaurant'] 		= $this->lang->line('entry_restaurant');
		$data['entry_quality'] 			= $this->lang->line('entry_quality');
		$data['entry_delivery'] 		= $this->lang->line('entry_delivery');
		$data['entry_service'] 			= $this->lang->line('entry_service');
		$data['entry_review'] 			= $this->lang->line('entry_review');
		$data['button_back'] 			= $this->lang->line('button_back');
		$data['button_review'] 			= $this->lang->line('button_review');
		// END of retrieving lines from language file to send to view.

		$data['back'] 					= site_url('main/reviews');

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

		$regions = array('header', 'content_top', 'content_left', 'content_right', 'footer');
		if (file_exists(APPPATH .'views/themes/main/'.$this->config->item('main_theme').'review_add.php')) {
			$this->template->render('themes/main/'.$this->config->item('main_theme'), 'review_add', $regions, $data);
		} else {
			$this->template->render('themes/main/default/', 'review_add', $regions, $data);
		}
	}

	public function _addReview() {
			$add = array();
		if ($this->validateForm() === TRUE) {
			$add['order_id'] 			= (int)$this->uri->segment(4);
			$add['location_id'] 		= (int)$this->uri->segment(5);
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

	public function validateForm() {
		$this->form_validation->set_rules('quality', 'Quality Rating', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('delivery', 'Delivery Rating', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('service', 'Service Rating', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('review_text', 'Rating Text', 'xss_clean|trim|required|min_length[2]|max_length[1028]');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file reviews.php */
/* Location: ./application/controllers/main/reviews.php */