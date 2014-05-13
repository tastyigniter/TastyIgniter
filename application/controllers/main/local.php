<?php

class Local extends MX_Controller {

	public function __construct() {
		parent::__construct(); 																	// calls the constructor
		$this->load->model('Locations_model'); 													// loads the location model
		$this->load->library('location'); 														// load the location library
		$this->load->library('currency'); 														// load the currency library
	}

	public function index() {
		$this->lang->load('main/local');  													// loads home language file
					
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert'); 								// retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		if ($this->session->userdata('user_postcode')) {
			$data['postcode'] = $this->session->userdata('user_postcode'); 						// retrieve session userdata variable if available
		} else {
			$data['postcode'] = '';
		}
		
		// START of retrieving lines from language file to pass to view.
		$data['text_heading'] 			= $this->lang->line('text_heading');
		$data['text_local'] 			= $this->lang->line('text_local');
		$data['text_postcode'] 			= ($this->config->item('search_by') === 'postcode') ? $this->lang->line('entry_postcode') : $this->lang->line('entry_address');
		$data['text_find'] 				= $this->lang->line('text_find');
		$data['text_delivery_charge'] 	= $this->lang->line('text_delivery_charge');
		$data['text_reviews'] 			= $this->lang->line('text_reviews');
		$data['text_opening_hours'] 	= $this->lang->line('text_opening_hours');
		$data['text_open'] 				= $this->lang->line('text_open');
		$data['text_distance'] 			= $this->lang->line('text_distance');		
		$data['text_covered_area'] 		= $this->lang->line('text_covered_area');		
		$data['button_view_menu'] 		= $this->lang->line('button_view_menu');
		// END of retrieving lines from language file to send to view.

		$data['local_action']			= site_url('main/local_module/distance');
		$data['menus_url']				= site_url('main/menus');

		if ($this->config->item('maps_api_key')) {
			$data['map_key'] = '&key='. $this->config->item('maps_api_key');
		} else {
			$data['map_key'] = '';
		}

		$local_info = $this->session->userdata('local_info');
		if ($local_info['search_query']) {
			$data['postcode'] = $local_info['search_query'];
		} else {
			$data['postcode'] = '';
		}

		$data['local_location'] = $this->location->local(); 									//retrieve local restaurant data from location library
		
		if ($data['local_location']) { 															//if local restaurant data is available
			$data['location_name'] 			= $data['local_location']['location_name'];
			$data['location_address_1'] 	= $data['local_location']['location_address_1'];
			$data['location_city'] 			= $data['local_location']['location_city'];
			$data['location_postcode'] 		= $data['local_location']['location_postcode'];
			$data['location_telephone'] 	= $data['local_location']['location_telephone'];
			$data['location_lat'] 			= $data['local_location']['location_lat'];
			$data['location_lng'] 			= $data['local_location']['location_lng'];
			$data['distance'] 				= $this->location->distance(); //format diatance to 2 decimal place
			$data['delivery_charge']		= ($this->location->getDeliveryCharge() > 0) ? $this->currency->format($this->location->getDeliveryCharge()) : $this->lang->line('text_free');
			$data['reviews']				= '2 reviews';
		}
		
		$data['local_telephone'] = $this->location->getTelephone(); 

		$this->load->library('country');
		$location_address = $this->Locations_model->getLocationAddress($this->location->getId());
		$data['location_address'] = $this->country->addressFormat($location_address);
		
		$data['opening_hours'] = $this->location->getOpeningHours(); 								//retrieve local restaurant opening hours from location library
		
		if ($this->location->isOpened()) { 														// check if local restaurant is open
			$data['text_open_or_close'] = $this->lang->line('text_opened');						// display we are open
		} else {
			$data['text_open_or_close'] = $this->lang->line('text_closed');						// display we are closed
		}
			
		if ($this->location->checkDelivery() === 'no') { 														// checks if cart contents is empty  
			$data['text_delivery'] = $this->lang->line('text_delivery_n');						// display we are closed
		} else if ($this->location->checkDelivery() === 'outside') {		
			$data['text_delivery'] = $this->lang->line('text_covered_area');		
		} else {
			$data['text_delivery'] = $this->lang->line('text_delivery_y');						// display we are open
		}

		if ($this->location->checkCollection()) { 														// checks if cart contents is empty  
			$data['text_collection'] = $this->lang->line('text_collection_y');						// display we are open
		} else {
			$data['text_collection'] = $this->lang->line('text_collection_n');						// display we are closed
		}
		
		$this->load->model('Reviews_model');
		$total_reviews = $this->Reviews_model->getTotalLocationReviews($this->location->getId());
		$data['text_total_review'] = sprintf($this->lang->line('text_total_review'), $total_reviews);

		$regions = array('header', 'content_top', 'content_left', 'content_right', 'footer');
		if (file_exists(APPPATH .'views/themes/main/'.$this->config->item('main_theme').'local.php')) {
			$this->template->render('themes/main/'.$this->config->item('main_theme'), 'local', $regions, $data);
		} else {
			$this->template->render('themes/main/default/', 'local', $regions, $data);
		}
	}

	// method to validate location form fields and email location details to store email
	public function _sendContact() {
		
		if ($this->validateForm() === TRUE) {
			$this->load->library('email');														//loading upload library

			//setting email preference
			$this->email->set_protocol($this->config->item('protocol'));
			$this->email->set_mailtype($this->config->item('mailtype'));
			$this->email->set_smtp_host($this->config->item('smtp_host'));
			$this->email->set_smtp_port($this->config->item('smtp_port'));
			$this->email->set_smtp_user($this->config->item('smtp_user'));
			$this->email->set_smtp_pass($this->config->item('smtp_pass'));
			$this->email->set_newline("\r\n");
			$this->email->initialize();

			$subjects = array('1' => 'General enquiry', '2' => 'Comment', '3' => 'Technical Issues');	// array of enquiry subject to pass to view

			$subject	= $subjects[$this->input->post('subject')];								// retreive subject based on subjects key value
			$full_name	= $this->input->post('full_name');
			$email		= $this->input->post('email');
			$telephone	= $this->input->post('telephone');
			$comment	= nl2br($this->input->post('comment'));									// retrieve $_POST comment value to include HTML line breaks <br /> or <br>
			
			// create variable to hold email body message.
			$message 	= sprintf($this->lang->line('text_location_message'), $comment, $full_name, $telephone);

			$this->email->from(strtolower($email), $full_name);
			$this->email->to($this->location->getEmail());

			$this->email->subject($subject);
			
			$this->email->message($message);

			if ($this->email->send()) {															// checks if email was sent sucessfully and return TRUE
				return TRUE;
			}
		}
	}

	public function validateForm() {
		// START of form validation rules
		$this->form_validation->set_rules('subject', 'Subject', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('full_name', 'Full Name', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('email', 'Email Address', 'xss_clean|trim|required|valid_email|max_length[96]');
		$this->form_validation->set_rules('telephone', 'Telephone', 'xss_clean|trim|required|numeric|max_length[20]');
		$this->form_validation->set_rules('comment', 'Comment', 'htmlspecialchars|required|max_length[1028]');
		// END of form validation rules

  		if ($this->form_validation->run() === TRUE) {											// checks if form validation routines ran successfully
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file location.php */
/* Location: ./application/controllers/main/location.php */