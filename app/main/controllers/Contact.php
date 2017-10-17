<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Contact extends Main_Controller {

	public function __construct() {
		parent::__construct(); 																	// calls the constructor

        $this->load->model('Pages_model');

        $this->load->library('location'); 														// load the location library
        $this->load->library('currency'); 														// load the currency library

		$this->lang->load('contact');
	}

	public function index() {

        if ($this->config->item('maps_api_key')) {
            $map_key = '&key=' . $this->config->item('maps_api_key');
        } else {
            $map_key = '';
        }

        $this->template->setScriptTag('https://maps.googleapis.com/maps/api/js?v=3' . $map_key .'&sensor=false&region=GB', 'google-maps-js', '104330');

        $this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
		$this->template->setBreadcrumb($this->lang->line('text_heading'), 'contact');

		$this->template->setTitle($this->lang->line('text_heading'));

		$data['_action'] 				= site_url('contact');

		if ($default_local = $this->location->getDefaultLocal()) {
			$data['default_local'] 		= $default_local;										//if local restaurant data is available
			$data['location_address'] 	= $this->location->formatAddress($default_local);
			$data['location_name'] 		= $default_local['location_name'];
			$data['location_telephone'] = $default_local['location_telephone'];
			$data['location_lat'] 		= $default_local['location_lat'];
			$data['location_lng'] 		= $default_local['location_lng'];
		}

		if ($this->config->item('maps_api_key')) {
			$data['map_key'] = '&key='. $this->config->item('maps_api_key');
		} else {
			$data['map_key'] = '';
		}

		$data['subjects'] = array('1' => 'General enquiry', '2' => 'Comment', '3' => 'Technical Issues');	// array of enquiry subject to pass to view

        if ($this->input->post() AND $this->_sendContact() === TRUE) {							// checks if $_POST data is set and if contact form validation was successful

            $this->alert->set('alert', $this->lang->line('alert_contact_sent'));		// display success message and redirect to account login page

            redirect('contact');																// redirect to contact page
        }

        $data['captcha_image'] = $this->createCaptcha();

		$this->template->render('contact', $data);
	}

	private function _sendContact() {

		if ($this->validateForm() === TRUE) {
			$this->load->library('email');														//loading upload library

			$this->email->initialize();

			$full_name	= $this->input->post('full_name');
			$email		= $this->input->post('email');
			$subjects 	= array('1' => 'General enquiry', '2' => 'Comment', '3' => 'Technical Issues');

			$mail_data['full_name'] 			= $this->input->post('full_name');
			$mail_data['contact_topic'] 		= $subjects[$this->input->post('subject')];
			$mail_data['contact_telephone'] 	= $this->input->post('telephone');
			$mail_data['contact_message'] 		= nl2br($this->input->post('comment'));

			$this->load->model('Mail_templates_model');
			$mail_template = $this->Mail_templates_model->getTemplateData($this->config->item('mail_template_id'), 'contact');

			$this->email->from(strtolower($email), ucwords($full_name));
			$this->email->to(strtolower($this->config->item('site_email')));
			$this->email->subject($mail_template['subject'], $mail_data);
			$this->email->message($mail_template['body'], $mail_data);

			if ($this->email->send()) {
                return TRUE;
            } else {
                log_message('debug', $this->email->print_debugger(array('headers')));
            }
        }
	}

	private function validateForm() {
		// START of form validation rules
		$this->form_validation->set_rules('subject', 'lang:label_subject', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('full_name', 'lang:label_full_name', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('email', 'lang:label_email', 'xss_clean|trim|required|valid_email|max_length[96]');
		$this->form_validation->set_rules('telephone', 'lang:label_telephone', 'xss_clean|trim|required|numeric|max_length[20]');
		$this->form_validation->set_rules('comment', 'lang:label_comment', 'htmlspecialchars|required|max_length[1028]');
		$this->form_validation->set_rules('captcha', 'lang:label_captcha', 'xss_clean|trim|required|callback__validate_captcha');
		// END of form validation rules

  		if ($this->form_validation->run() === TRUE) {											// checks if form validation routines ran successfully
			return TRUE;
		} else {
			return FALSE;
		}
	}

    public function _validate_captcha($word) {
		$session_caption = $this->session->tempdata('captcha');

        if (strtolower($word) !== strtolower($session_caption['word'])) {
            $this->form_validation->set_message('_validate_captcha', $this->lang->line('error_captcha'));
            return FALSE;
        } else {
            return TRUE;
        }
    }

	private function createCaptcha() {
        $this->load->helper('captcha');
        $captcha = create_captcha();
        $this->session->set_tempdata('captcha', array('word' => $captcha['word'], 'image' => $captcha['image']), '300'); //set data to session for compare

        return $captcha['image'];
    }
}

/* End of file contact.php */
/* Location: ./main/controllers/contact.php */