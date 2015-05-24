<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Reserve extends Main_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('customer'); 														// load the customer library
		$this->load->library('location'); // load the location library
		$this->load->model('Reservations_model');
		$this->load->model('Pages_model');
		$this->lang->load('reserve');

		if ($this->config->item('reservation_mode') !== '1') {
			$this->alert->set('alert', $this->lang->line('alert_no_reservation'));
			redirect('home');
		}
	}

	public function index() {
		$this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
		$this->template->setBreadcrumb($this->lang->line('text_heading'), 'reserve');

		$this->template->setTitle($this->lang->line('text_heading'));
		$this->template->setHeading($this->lang->line('text_heading'));
		$data['text_heading'] 				= $this->lang->line('text_heading');
		$data['text_no_table'] 				= $this->lang->line('text_no_table');
		$data['text_reservation_msg'] 		= $this->lang->line('text_reservation_msg');
		$data['text_login_register']		= $this->customer->isLogged() ? sprintf($this->lang->line('text_logout'), site_url('account/logout')) : sprintf($this->lang->line('text_login'), site_url('account/login'));
		$data['entry_first_name'] 			= $this->lang->line('entry_first_name');
		$data['entry_last_name'] 			= $this->lang->line('entry_last_name');
		$data['entry_email'] 				= $this->lang->line('entry_email');
		$data['entry_confirm_email'] 		= $this->lang->line('entry_confirm_email');
		$data['entry_telephone'] 			= $this->lang->line('entry_telephone');
		$data['entry_comments'] 			= $this->lang->line('entry_comments');
		$data['entry_captcha'] 				= $this->lang->line('entry_captcha');

		$data['button_reservation'] 		= $this->lang->line('button_reservation');
		$data['action'] 					= site_url('reserve');
		$data['continue'] 					= site_url('reserve/success');

		$data['occasions'] = array(
			'0' => 'not applicable',
			'1' => 'birthday',
			'2' => 'anniversary',
			'3' => 'general celebration',
			'4' => 'hen party',
			'5' => 'stag party'
		);

		if ($this->input->post('first_name')) {
			$data['first_name'] = $this->input->post('first_name');
		} else if ($this->customer->getFirstName()) {
			$data['first_name'] = $this->customer->getFirstName(); 								// retrieve customer first name from customer library
		} else {
			$data['first_name'] = '';
		}

		if ($this->input->post('last_name')) {
			$data['last_name'] = $this->input->post('last_name');
		} else if ($this->customer->getLastName()) {
			$data['last_name'] = $this->customer->getLastName(); 								// retrieve customer last name from customer library
		} else {
			$data['last_name'] = '';
		}

		if ($this->input->post('email')) {
			$data['email'] = $this->input->post('email');
		} else if ($this->customer->getEmail()) {
			$data['email'] = $this->customer->getEmail(); 										// retrieve customer email address from customer library
		} else {
			$data['email'] = '';
		}

		if ($this->input->post('telephone')) {
			$data['telephone'] = $this->input->post('telephone');
		} else if ($this->customer->getTelephone()) {
			$data['telephone'] = $this->customer->getTelephone(); 								// retrieve customer telephone from customer library
		} else {
			$data['telephone'] = '';
		}

		if ($this->input->post('comment')) {
			$data['comment'] = $this->input->post('comment');
		} else {
			$data['comment'] = '';
		}

        $data['show_reserve'] = FALSE;
        $sess_reservation = $this->session->userdata('reservation');
		if (!empty($sess_reservation) AND $this->input->get('reserve_time')) {
			$data['show_reserve'] = TRUE;
		}

		if ($this->input->post() AND $this->_reserveTable() === TRUE) {
			redirect('reserve/success');
		}

        $data['captcha_image'] = $this->createCaptcha();

        $this->template->setPartials(array('header', 'content_top', 'content_left', 'content_right', 'content_bottom', 'footer'));
		$this->template->render('reserve', $data);
	}

	public function success() {
		$this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
		$this->template->setBreadcrumb($this->lang->line('text_heading'), 'reserve');
		$this->template->setBreadcrumb($this->lang->line('text_heading_success'), 'reserve/success');

		$this->template->setTitle($this->lang->line('text_heading_success'));
		$this->template->setHeading($this->lang->line('text_heading_success'));
		$data['text_heading'] 	= $this->lang->line('text_heading_success');

		$reservation_id = $this->session->tempdata('last_reserve_id');
		$result = $this->Reservations_model->getReservation($reservation_id, $this->customer->getId());

		if ($result) {
			$guest_num = $result['guest_num'] .' person(s)';

			$data['text_success'] 	= sprintf($this->lang->line('text_success'), $result['location_name'], $guest_num, mdate('%l, %F %j, %Y', strtotime($result['reserve_date'])), mdate('%h:%i %a', strtotime($result['reserve_time'])));
			$data['text_greetings'] = sprintf($this->lang->line('text_greetings'), $result['first_name'] .' '. $result['last_name']);
			$data['text_signature'] = sprintf($this->lang->line('text_signature'), $this->config->item('site_name'));
			$this->session->unset_userdata('reservation');
		} else {
			redirect('reserve');
		}

		$this->template->setPartials(array('header', 'content_top', 'content_left', 'content_right', 'content_bottom', 'footer'));
		$this->template->render('reserve_success', $data);
	}

	private function _reserveTable() {

		$date_format = '%Y-%m-%d';
		$time_format = '%h:%i';
		$current_time = time();

		//$this->load->module('main/reservation_module');
		//if ($this->reservation_module->findTable() !== TRUE) {
			//$this->alert->set('alert', $this->lang->line('alert_no_table'));
			//redirect('reserve/table');
		//} else
		if ($this->validateForm() === TRUE) {
			$data = array();

			$reservation = $this->session->userdata('reservation');
			$result = $this->Reservations_model->checkAvailability($reservation);
			if ($result !== 'NO_GUEST_TABLE' AND $result !== 'NO_TABLE_AVAIL') {
				if (!empty($reservation['location'])) {
					$data['location_id'] = (int)$reservation['location'];
				}

				if (!empty($result['tables'])) {
					$data['table_id'] = $result['tables'][0];
				}

				if (!empty($reservation['guest_num'])) {
					$data['guest_num'] = (int)$reservation['guest_num'];
				}

				if (strtotime($reservation['reserve_date']) > strtotime($this->location->currentDate())) {
					$data['reserve_date'] = mdate('%Y-%m-%d', strtotime($reservation['reserve_date']));
					$data['date_added'] = mdate('%Y-%m-%d', $current_time);
					$data['date_modified'] = mdate('%Y-%m-%d', $current_time);
				}

				if (strtotime($reservation['reserve_time'])) {
					$data['reserve_time'] = $reservation['reserve_time'];
				}

				if (!empty($reservation['occasion'])) {
					$data['occasion_id'] = (int)$reservation['occasion'];
				}

				if ($this->customer->getId()) {
					$data['customer_id'] = $this->customer->getId();
				} else {
					$data['customer_id'] = '0';
				}

				$data['first_name'] = $this->input->post('first_name');
				$data['last_name'] 	= $this->input->post('last_name');
				$data['email'] 		= $this->input->post('email');
				$data['telephone'] 	= $this->input->post('telephone');
				$data['comment'] 	= $this->input->post('comment');
				$data['ip_address'] = $this->input->ip_address();
				$data['user_agent'] = $this->input->user_agent();
			}

			if (!empty($data)) {
				$reservation_id = $this->Reservations_model->addReservation($data);
				$this->session->set_tempdata('last_reserve_id', $reservation_id);
				return TRUE;
			}
		}
	}

	private function validateForm() {
		$this->form_validation->set_rules('first_name', 'First Name', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('last_name', 'Last Name', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('email', 'Email Address', 'xss_clean|trim|required|valid_email');
		$this->form_validation->set_rules('confirm_email', 'Confirm Email Address', 'xss_clean|trim|required|valid_email|matches[email]');
		$this->form_validation->set_rules('telephone', 'Telephone', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('comment', 'Comment', 'xss_clean|trim|max_length[520]');
		$this->form_validation->set_rules('captcha', 'Captcha', 'xss_clean|trim|required|callback__validate_captcha');

  		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

    public function _validate_captcha($word) {
		$session_caption = $this->session->tempdata('captcha');

        if (empty($word) OR $word !== $session_caption['word']) {
            $this->form_validation->set_message('_validate_captcha', 'The letters you entered does not match the image.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

	private function createCaptcha() {
        $this->load->helper('captcha');

		$prefs = array(
            'img_path' 		=> './assets/images/thumbs/',
            'img_url' 		=> root_url() . '/assets/images/thumbs/',
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

/* End of file reserve.php */
/* Location: ./main/controllers/reserve.php */