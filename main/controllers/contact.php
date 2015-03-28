<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Contact extends Main_Controller {

	public function __construct() {
		parent::__construct(); 																	// calls the constructor
		$this->load->library('location'); 														// load the location library
		$this->load->library('currency'); 														// load the currency library
		$this->load->model('Pages_model');

		$this->lang->load('contact');
	}

	public function index() {
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

		$this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
		$this->template->setBreadcrumb($this->lang->line('text_heading'), 'contact');

		// START of retrieving lines from language file to pass to view.
		$this->template->setTitle($this->lang->line('text_heading'));
		//$this->template->setHeading($this->lang->line('text_heading'));
		$data['text_heading'] 			= $this->lang->line('text_heading');
		$data['text_summary'] 			= $this->lang->line('text_summary');
		$data['text_find_us'] 			= $this->lang->line('text_find_us');
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
		$data['entry_captcha'] 				= $this->lang->line('entry_captcha');
		$data['button_send'] 			= $this->lang->line('button_send');
		// END of retrieving lines from language file to send to view.

		$data['local_action'] 			= site_url('local_module/main/local_module/search');
		$data['action'] 				= site_url('contact');

		$main_local 	= $this->location->getMainLocal();
		if ($main_local) {
			$data['main_local'] 		= $main_local;										//if local restaurant data is available
			$data['location_address'] 	= $this->location->getFormatAddress($main_local, FALSE);
			$data['location_name'] 		= $main_local['location_name'];
			$data['location_telephone'] = $main_local['location_telephone'];
			$data['location_lat'] 		= $main_local['location_lat'];
			$data['location_lng'] 		= $main_local['location_lng'];
		}

		if ($this->config->item('maps_api_key')) {
			$data['map_key'] = '&key='. $this->config->item('maps_api_key');
		} else {
			$data['map_key'] = '';
		}

		$data['opening_hours'] 			= $this->location->openingHours(); 								//retrieve local location opening hours from location library

		if ($this->location->isOpened()) { 														// check if local location is open
			$data['text_open_or_close'] = $this->lang->line('text_opened');						// display we are open
		} else {
			$data['text_open_or_close'] = $this->lang->line('text_closed');						// display we are closed
		}

		$data['subjects'] = array('1' => 'General enquiry', '2' => 'Comment', '3' => 'Technical Issues');	// array of enquiry subject to pass to view

		$data['captcha_image'] = $this->createCaptcha();

		if ($this->input->post() && $this->_sendContact() === TRUE) {							// checks if $_POST data is set and if contact form validation was successful

			$this->alert->set('alert', $this->lang->line('alert_contact_sent'));		// display success message and redirect to account login page

			redirect('contact');																// redirect to contact page
		}

		$this->template->setPartials(array('header', 'content_top', 'content_left', 'content_right', 'content_bottom', 'footer'));
		$this->template->render('contact', $data);
	}

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
		$this->form_validation->set_rules('captcha', 'Captcha', 'xss_clean|trim|required|callback_validate_captcha');
		// END of form validation rules

  		if ($this->form_validation->run() === TRUE) {											// checks if form validation routines ran successfully
			return TRUE;
		} else {
			return FALSE;
		}
	}

    public function validate_captcha($word) {
		$session_caption = $this->session->tempdata('captcha');

        if (empty($word) OR $word !== $session_caption['word']) {
            $this->form_validation->set_message('validate_captcha', 'The letters you entered does not match the image.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

	public function createCaptcha() {
        $this->load->helper('captcha');

		$prefs = array(
            'img_path' 		=> './assets/images/captcha/',
            'img_url' 		=> root_url() . '/assets/images/captcha/',
			'font_path'     => './system/fonts/texb.ttf',
			'img_width'     => '150',
			'img_height'    => 30,
			'expiration'    => 300,
			'word_length'   => 8,
			'pool'          => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',

			// White background and border, black text and white grid
			'colors'        => array(
				'background' 	=> array(255, 255, 255),
				'border' 		=> array(255, 255, 255),
				'text' 			=> array(0, 0, 0),
				'grid' 			=> array(255, 255, 255)
			)
		);

        $captcha = create_captcha($prefs);
        $this->session->set_tempdata('captcha', array('word' => $captcha['word'], 'image' => $captcha['time'].'.jpg')); //set data to session for compare
        return $captcha['image'];
    }
}

/* End of file contact.php */
/* Location: ./main/controllers//contact.php */