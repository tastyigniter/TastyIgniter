<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Local_module extends Ext_Controller {

	public function __construct() {
		parent::__construct(); 																	// calls the constructor
		$this->load->library('location'); 														// load the location library
		$this->load->library('currency'); 														// load the location library
		$this->lang->load('local_module/local_module');
	}

	public function index($ext_data = array()) {
		if ( ! file_exists(EXTPATH .'local_module/views/local_module.php')) { 								//check if file exists in views folder
			show_404(); 																		// Whoops, show 404 error page!
		}

		$data['local_page'] = ($this->uri->rsegment(1) === 'local' AND $this->uri->rsegment(2) === 'locations') ? TRUE : FALSE;

		if ($this->session->flashdata('local_alert')) {
			$data['local_alert'] = $this->session->flashdata('local_alert');  								// retrieve session flashdata variable if available
		} else {
			$data['local_alert'] = '';
		}

        // START of retrieving lines from language file to pass to view.
		$data['text_heading'] 			= $this->lang->line('text_heading');
		$data['text_local'] 			= $this->lang->line('text_local');
		$data['text_postcode'] 			= ($this->config->item('search_by') === 'postcode') ? $this->lang->line('entry_postcode') : $this->lang->line('entry_address');
		$data['text_delivery_charge'] 	= $this->lang->line('text_delivery_charge');
		$data['text_min_total'] 		= $this->lang->line('text_min_total');
		$data['text_avail'] 			= $this->lang->line('text_avail');
		$data['text_more_info'] 		= $this->lang->line('text_more_info');
		$data['text_reviews'] 			= $this->lang->line('text_reviews');
		$data['text_goto_menus'] 		= $this->lang->line('text_goto_menus');
		$data['text_open24_7'] 			= $this->lang->line('text_open24_7');

		$data['button_view_map'] 		= $this->lang->line('button_view_map');
		$data['button_change_location'] = $this->lang->line('button_change_location');
		// END of retrieving lines from language file to send to view.

		$data['info_url'] 				= site_url('local');
		$data['local_info'] 			= $this->location->local(); 										// retrieve local location data
		$data['location_name'] 			= $this->location->getName(); 										// retrieve local location data
		$data['location_address'] 		= $this->location->getAddress(FALSE); 										// retrieve local location data
		$data['opening_type'] 			= $this->location->getOpeningType();
		$data['opening_status']		 	= $this->location->openingStatus();
		$data['opening_time']		 	= $this->location->openingTime();
		$data['closing_time'] 			= $this->location->closingTime();

		if ($this->config->item('maps_api_key')) {
			$data['map_key'] = '&key='. $this->config->item('maps_api_key');
		} else {
			$data['map_key'] = '';
		}

		$local_info = $this->session->userdata('local_info');
		if (isset($local_info['search_query'])) {
			$data['postcode'] = $local_info['search_query'];
		} else {
			$data['postcode'] = '';
		}

		if ($this->location->isOpened()) { 														// checks if local location is open
			$data['text_open_or_close'] = $this->lang->line('text_opened');						// display we are open
		} else {
			$data['text_open_or_close'] = $this->lang->line('text_closed');						// display we are closed
		}

		$check_delivery = $this->location->hasDelivery();
		$check_collection = $this->location->hasCollection();

		if (!$check_delivery AND $check_collection) { 														// checks if cart contents is empty
			$data['text_delivery'] = $this->lang->line('text_collection');
		} else if ($check_delivery AND !$check_collection) {
			$data['text_delivery'] = $this->lang->line('text_delivery');
		} else if ($check_delivery AND $check_collection) {
			$data['text_delivery'] = $this->lang->line('text_both_types');						// display we are open
		} else {
			$data['text_delivery'] = $this->lang->line('text_no_types');
		}

		$this->load->model('Reviews_model');
		$total_reviews = $this->Reviews_model->getTotalLocationReviews($this->location->getId());
		$data['text_total_review'] = sprintf($this->lang->line('text_total_review'), site_url('local/reviews'), $total_reviews);

		$data['module_position'] = isset($ext_data['module_position']) ? $ext_data['module_position'] : '';

		// pass array $data and load view files
		$this->load->view('local_module/local_module', $data);
	}

	public function search() {
		$this->load->library('user_agent');
		$json = array();

		$result = $this->location->searchRestaurant($this->input->post('postcode'));

		switch ($result) {
			case 'FAILED':
				$json['error'] = $this->lang->line('error_failed');				// display error: invalid postcode
				break;
			case 'NO_SEARCH_QUERY':
				$json['error'] = $this->lang->line('error_no_postcode');
				break;
			case 'ENTER_POSTCODE':
				$json['error'] = $this->lang->line('error_enter_postcode');	// display error: enter postcode
				break;
			case 'outside':
				$json['error'] = $this->lang->line('error_no_restaurant');	// display error: no available restaurant
				break;
		}

		if (!isset($json['error'])) {
			$order_type = (is_numeric($this->input->post('order_type'))) ? $this->input->post('order_type') : '1';
			$this->location->setOrderType($order_type);
		}

		if ($this->agent->referrer() == site_url() OR $this->agent->referrer() == site_url('home')) {
			$redirect = site_url('menus');
		} else {
			$redirect = $this->agent->referrer();
		}

		if ($this->input->is_ajax_request()) {
			$this->output->set_output(json_encode($json));											// encode the json array and set final out to be sent to jQuery AJAX
		} else {
			if (isset($json['error'])) $this->alert->set('custom', $json['error']);
			redirect($redirect);
		}
	}
}

/* End of file local_module.php */
/* Location: ./extensions/local_module/controllers/local_module.php */