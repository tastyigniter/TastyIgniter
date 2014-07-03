<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Local extends MX_Controller {

	public function __construct() {
		parent::__construct(); 																	// calls the constructor
		$this->load->model('Locations_model'); 													// loads the location model
		$this->load->library('location'); 														// load the location library
		$this->load->library('currency'); 														// load the currency library

		$this->load->library('language');
		$this->lang->load('main/local', $this->language->folder());
	}

	public function index() {
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert'); 								// retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		if ($this->session->flashdata('local_alert')) {
			$data['local_alert'] = $this->session->flashdata('local_alert'); 								// retrieve session flashdata variable if available
		} else {
			$data['local_alert'] = '';
		}

		if ($this->session->userdata('user_postcode')) {
			$data['postcode'] = $this->session->userdata('user_postcode'); 						// retrieve session userdata variable if available
		} else {
			$data['postcode'] = '';
		}
		
		// START of retrieving lines from language file to pass to view.
		$this->template->setTitle($this->lang->line('text_heading'));
		$this->template->setHeading($this->lang->line('text_heading'));
		$data['text_heading'] 			= $this->lang->line('text_heading');
		$data['text_local'] 			= sprintf($this->lang->line('text_local'), $this->location->getName());
		$data['text_review'] 			= sprintf($this->lang->line('text_review'), $this->location->getName());
		$data['text_postcode'] 			= ($this->config->item('search_by') === 'postcode') ? $this->lang->line('entry_postcode') : $this->lang->line('entry_address');
		$data['text_find'] 				= $this->lang->line('text_find');
		$data['text_delivery_charge'] 	= $this->lang->line('text_delivery_charge');
		$data['text_reviews'] 			= $this->lang->line('text_reviews');
		$data['text_opening_hours'] 	= $this->lang->line('text_opening_hours');
		$data['text_open'] 				= $this->lang->line('text_open');
		$data['text_distance'] 			= $this->lang->line('text_distance');		
		$data['text_covered_area'] 		= $this->lang->line('text_covered_area');		
		$data['button_view_menu'] 		= $this->lang->line('button_view_menu');
		$data['text_from'] 				= $this->lang->line('text_from');
		$data['text_on'] 				= $this->lang->line('text_on');
		$data['text_avail'] 			= $this->lang->line('text_avail');
		$data['text_empty'] 			= $this->lang->line('text_empty');
		// END of retrieving lines from language file to pass to view.

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

		$data['description'] 			= $this->location->getDescription();
		$data['location_address'] 		= $this->location->getAddress();
		$data['location_name'] 			= $this->location->getName();
		$data['location_telephone'] 	= $this->location->getTelephone();
		$data['distance'] 				= $this->location->distance();
		$data['delivery_charge'] 		= $this->location->getDeliveryCharge();

		$data['local_location'] = $this->location->local(); 									//retrieve local restaurant data from location library
		
		if ($data['local_location']) { 															//if local restaurant data is available
			$data['location_lat'] 		= $data['local_location']['location_lat'];
			$data['location_lng'] 		= $data['local_location']['location_lng'];
		}

		$this->load->library('country');
		$location_address = $this->Locations_model->getLocationAddress($this->location->getId());
		$data['location_address'] = $this->country->addressFormat($location_address);
		
		$data['opening_hours'] = $this->location->getOpeningHours(); 								//retrieve local restaurant opening hours from location library
		
		if ($this->location->isOpened()) { 														// check if local restaurant is open
			$data['text_open_or_close'] = $this->lang->line('text_opened');						// display we are open
		} else {
			$data['text_open_or_close'] = $this->lang->line('text_closed');						// display we are closed
		}
			
		$check_delivery = $this->location->checkDelivery();
		$check_collection = $this->location->checkCollection();
		
		if (!$check_delivery AND !$check_collection) { 														// checks if cart contents is empty  
			$data['text_delivery'] = $this->lang->line('text_no_types');
		} else if (!$check_delivery AND $check_collection) { 														// checks if cart contents is empty  
			$data['text_delivery'] = $this->lang->line('text_collection');
		} else if ($check_delivery AND !$check_collection) {
			$data['text_delivery'] = $this->lang->line('text_delivery');
		} else if ($check_delivery AND $check_collection) {
			$data['text_delivery'] = $this->lang->line('text_both_types');						// display we are open
		}
		
		if ($check_delivery AND !$this->location->checkDeliveryCoverage()) {		
			$data['text_covered'] = $this->lang->line('text_covered_area');		
		}

		$url = '?';
		$filter = array();
		$filter['location_id'] = (int) $this->location->getId();

		if ($this->input->get('page')) {
			$filter['page'] = (int) $this->input->get('page');
		} else {
			$filter['page'] = '';
		}
		
		if ($this->config->item('page_limit')) {
			$filter['limit'] = $this->config->item('page_limit');
		}
		
		$this->load->model('Reviews_model');
		$total_reviews = $this->Reviews_model->getTotalLocationReviews($this->location->getId());
		$data['text_total_review'] = sprintf($this->lang->line('text_total_review'), $total_reviews);

		$ratings = $this->config->item('ratings');
		
		$data['reviews'] = array();
		$results = $this->Reviews_model->getMainList($filter);									// retrieve all customer reviews from getMainList method in Reviews model
		foreach ($results as $result) {					
			$data['reviews'][] = array(															// create array of customer reviews to pass to view
				'author'			=> $result['author'],
				'city'				=> $result['location_city'],
				'quality' 			=> $ratings['ratings'][$result['quality']],
				'delivery' 			=> $ratings['ratings'][$result['delivery']],
				'service' 			=> $ratings['ratings'][$result['service']],
				'date'				=> mdate('%d %M %y', strtotime($result['date_added'])),
				'text'				=> $result['review_text']
			);
		}
		
		$prefs['base_url'] 			= site_url('main/local').$url;
		$prefs['total_rows'] 		= $this->Reviews_model->getMainListCount($filter);
		$prefs['per_page'] 			= $filter['limit'];
		
		$this->load->library('pagination');
		$this->pagination->initialize($prefs);
				
		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		$this->template->regions(array('header', 'content_top', 'content_left', 'content_right', 'footer'));
		if (file_exists(APPPATH .'views/themes/main/'.$this->config->item('main_theme').'local.php')) {
			$this->template->render('themes/main/'.$this->config->item('main_theme'), 'local', $data);
		} else {
			$this->template->render('themes/main/default/', 'local', $data);
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