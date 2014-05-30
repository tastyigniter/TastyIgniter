<?php

class Contact extends MX_Controller {

	public function __construct() {
		parent::__construct(); 																	// calls the constructor
		$this->load->model('Locations_model'); 													// loads the location model
		$this->load->library('location'); 														// load the location library
		$this->load->library('currency'); 														// load the currency library

		$this->load->library('language');
		$this->lang->load('main/contact', $this->language->folder());
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
		$data['text_local'] 			= $this->lang->line('text_local');
		$data['text_postcode'] 			= $this->lang->line('text_postcode');
		$data['text_find'] 				= $this->lang->line('text_find');
		$data['text_reviews'] 			= $this->lang->line('text_reviews');
		$data['text_opening_hours'] 	= $this->lang->line('text_opening_hours');
		$data['text_open'] 				= $this->lang->line('text_open');
		$data['entry_subject'] 			= $this->lang->line('entry_subject');
		$data['entry_full_name'] 		= $this->lang->line('entry_full_name');
		$data['entry_email'] 			= $this->lang->line('entry_email');
		$data['entry_telephone'] 		= $this->lang->line('entry_telephone');
		$data['entry_comment'] 			= $this->lang->line('entry_comment');
		$data['button_send'] 			= $this->lang->line('button_send');
		// END of retrieving lines from language file to send to view.

		$data['local_action'] 			= site_url('main/local_module/distance');
		$data['action'] 				= site_url('main/contact');
		
		$data['local_location'] = $this->location->local(); 									//retrieve local location data from location library
		
		if ($data['local_location']) { 															//if local location data is available
			$data['location_name'] 			= $data['local_location']['location_name'];
			$data['location_address_1'] 	= $data['local_location']['location_address_1'];
			$data['location_city'] 			= $data['local_location']['location_city'];
			$data['location_postcode'] 		= $data['local_location']['location_postcode'];
			$data['location_telephone'] 	= $data['local_location']['location_telephone'];
			//$data['distance'] 			= number_format($this->location->distance(),2) .' '. $this->lang->line('text_miles'); //format diatance to 2 decimal place
		}
		
		$data['opening_hours'] = $this->location->getOpeningHours(); 								//retrieve local location opening hours from location library
		
		if ($this->location->isOpened()) { 														// check if local location is open
			$data['text_open_or_close'] = $this->lang->line('text_opened');						// display we are open
		} else {
			$data['text_open_or_close'] = $this->lang->line('text_closed');						// display we are closed
		}
		
		$data['subjects'] = array('1' => 'General enquiry', '2' => 'Comment', '3' => 'Technical Issues');	// array of enquiry subject to pass to view
			
		if ($this->input->post() && $this->_sendContact() === TRUE) {							// checks if $_POST data is set and if contact form validation was successful

			$this->session->set_flashdata('alert', $this->lang->line('text_contact_sent'));		// display success message and redirect to account login page
		
			redirect('contact');																// redirect to contact page
		}
		
		$this->template->regions(array('header', 'content_top', 'content_left', 'content_right', 'footer'));
		if (file_exists(APPPATH .'views/themes/main/'.$this->config->item('main_theme').'contact.php')) {
			$this->template->render('themes/main/'.$this->config->item('main_theme'), 'contact', $data);
		} else {
			$this->template->render('themes/main/default/', 'contact', $data);
		}
	}

	// method to validate contact form fields and email contact details to store email
	public function _sendContact() {
		
		if ($this->validateForm() === TRUE) {
			$this->load->library('email');														//loading upload library

			$this->email->set_protocol($this->config->item('protocol'));
			$this->email->set_mailtype($this->config->item('mailtype'));
			$this->email->set_smtp_host($this->config->item('smtp_host'));
			$this->email->set_smtp_port($this->config->item('smtp_port'));
			$this->email->set_smtp_user($this->config->item('smtp_user'));
			$this->email->set_smtp_pass($this->config->item('smtp_pass'));
			$this->email->set_newline("\r\n");
			$this->email->initialize();

			$full_name	= $this->input->post('full_name');
			$email		= $this->input->post('email');
			$subjects 	= array('1' => 'General enquiry', '2' => 'Comment', '3' => 'Technical Issues');
			
			$mail_data['contact_topic'] 		= $subjects[$this->input->post('subject')];
			$mail_data['full_name'] 			= $this->input->post('full_name');
			$mail_data['contact_telephone'] 	= $this->input->post('telephone');
			$mail_data['contact_message'] 		= nl2br($this->input->post('comment'));
			$mail_data['site_name'] 			= $this->config->item('site_name');
			$mail_data['signature'] 			= $this->config->item('site_name');
						
			$this->load->library('mail_template'); 
			$message = $this->mail_template->parseTemplate('contact', $mail_data);

			$this->email->from(strtolower($email), $full_name);
			$this->email->to($this->location->getEmail());
			$this->email->subject($this->mail_template->getSubject());
			$this->email->message($message);

			if ($this->email->send()) {
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

/* End of file contact.php */
/* Location: ./application/controllers/main/contact.php */