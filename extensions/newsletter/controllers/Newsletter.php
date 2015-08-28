<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Newsletter extends Main_Controller {

	public function __construct() {
		parent::__construct(); 																	// calls the constructor
		$this->load->model('Menus_model'); 														// load the menus model
		$this->load->model('Categories_model'); 														// load the menus model
		$this->lang->load('newsletter/newsletter');
	}

	public function index() {
		if ( ! file_exists(EXTPATH .'newsletter/views/newsletter.php')) { 		//check if file exists in views folder
			show_404(); 																		// Whoops, show 404 error page!
		}

		$data['newsletter_alert']       = $this->alert->display('newsletter_alert');

		$data['subscribe_url'] 			= extension_url('newsletter/subscribe');

		// pass array $data and load view files
		return $this->load->view('newsletter/newsletter', $data, TRUE);
	}

	public function subscribe() {
		$this->load->library('user_agent');
		$json = array();

		$referrer_uri = explode('/', str_replace(site_url(), '', $this->agent->referrer()));
		$referrer_uri = (!empty($referrer_uri[0]) AND $referrer_uri[0] !== 'newsletter') ? $referrer_uri[0] : 'home';

        $this->alert->set('custom', 'test', 'newsletter_alert');

		$result = $this->location->searchRestaurant($this->input->post('subscribe_email'));

        $redirect = $referrer_uri;

//		switch ($result) {
//			case 'NO_SEARCH_QUERY':
//				$json['error'] = $this->lang->line('alert_no_search_query');
//				break;
//			case 'INVALID_SEARCH_QUERY':
//				$json['error'] = $this->lang->line('alert_invalid_search_query');	// display error: enter postcode
//				break;
//			case 'outside':
//				$json['error'] = $this->lang->line('alert_no_found_restaurant');	// display error: no available restaurant
//				break;
//		}
//
//		$redirect = '';
//		if (!isset($json['error'])) {
//			$order_type = (is_numeric($this->input->post('order_type'))) ? $this->input->post('order_type') : '1';
//			$this->location->setOrderType($order_type);
//
//			$redirect = $json['redirect'] = site_url('local?location_id='.$this->location->getId());
//		}
//
//		if ($redirect === '') {
//			$redirect = $this->referrer_uri;
//		}
//
//		if ($this->input->is_ajax_request()) {
//			$this->output->set_output(json_encode($json));											// encode the json array and set final out to be sent to jQuery AJAX
//		} else {
//			if (isset($json['error'])) $this->alert->set('custom', $json['error'], 'local_module');
			redirect($redirect);
//		}
	}
}

/* End of file newsletter.php */
/* Location: ./extensions/newsletter/controllers/newsletter.php */