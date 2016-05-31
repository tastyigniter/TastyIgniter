<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Local_module extends Main_Controller {

	public function __construct() {
		parent::__construct(); 																	// calls the constructor
		$this->load->library('location'); 														// load the location library
		$this->location->initialize();

		$this->load->library('currency'); 														// load the location library
		$this->lang->load('local_module/local_module');

		$referrer_uri = explode('/', str_replace(site_url(), '', $this->agent->referrer()));
		$this->referrer_uri = (!empty($referrer_uri[0]) AND $referrer_uri[0] !== 'local_module') ? $referrer_uri[0] : 'home';
	}

	public function index($module = array()) {
		if ( ! file_exists(EXTPATH .'local_module/views/local_module.php')) { 								//check if file exists in views folder
			show_404(); 																		// Whoops, show 404 error page!
		}

		$ext_data = (!empty($module['data']) AND is_array($module['data'])) ? $module['data'] : array();

		if (empty($module['status']) OR (isset($ext_data['status']) AND $ext_data['status'] !== '1')) {
			return;
		}

		$this->template->setStyleTag(extension_url('local_module/views/stylesheet.css'), 'local-module-css', '100000');

		$data['location_search_mode'] = 'multi';
		if (isset($ext_data['location_search_mode']) AND $ext_data['location_search_mode'] === 'single') {
			$data['location_search_mode'] = 'single';

			if (!empty($ext_data['use_location'])) {
				$use_location = $ext_data['use_location'];
			} else {
				$use_location = $this->config->item('default_location_id');
			}

			if (!empty($use_location) AND is_numeric($use_location)) {
				$this->location->setLocation($use_location);
				$data['single_location_url'] = site_url('local?location_id=' . $use_location);
			} else {
				$data['single_location_url'] = site_url('local/all');
			}
		}

		$data['local_action']			= site_url('local_module/local_module/search');

		$data['rsegment'] = $rsegment = ($this->uri->rsegment(1) === 'local_module' AND !empty($this->referrer_uri)) ? $this->referrer_uri : $this->uri->rsegment(1);

		$this->load->library('cart'); 															// load the cart library
		$cart_total = $this->cart->total();

		$data['info_url'] 				= site_url('local');
		$data['local_info'] 			= $this->location->local(); 										// retrieve local location data
		$data['location_id'] 			= $this->location->getId(); 										// retrieve local location data
		$data['location_name'] 			= $this->location->getName(); 										// retrieve local location data
		$data['location_address'] 		= $this->location->getAddress(); 										// retrieve local location data
		$data['location_image'] 		= $this->location->getImage(); 										// retrieve local location data
		$data['is_opened'] 			    = $this->location->isOpened();
		$data['opening_type'] 			= $this->location->workingType('opening');
		$data['opening_status']		 	= $this->location->workingStatus('opening');
		$data['delivery_status']		= $this->location->workingStatus('delivery');
		$data['collection_status']		= $this->location->workingStatus('collection');
		$data['opening_time']		 	= $this->location->workingTime('opening', 'open');
		$data['closing_time'] 			= $this->location->workingTime('opening', 'close');
		$data['order_type']             = $this->location->orderType();
		$data['delivery_charge']        = $this->location->deliveryCharge($cart_total);
		$data['delivery_coverage']      = $this->location->checkDeliveryCoverage();
		$data['search_query']           = $this->location->searchQuery();
		$data['has_search_query']       = $this->location->hasSearchQuery();
		$data['has_delivery']           = $this->location->hasDelivery();
		$data['has_collection']         = $this->location->hasCollection();
		$data['location_order']         = $this->config->item('location_order');

		$data['location_search'] = FALSE;
		if ($rsegment === 'home') {
			$data['location_search'] = TRUE;
		}

		if ($this->config->item('maps_api_key')) {
			$data['map_key'] = '&key='. $this->config->item('maps_api_key');
		} else {
			$data['map_key'] = '';
		}

		$data['delivery_time'] = $this->location->deliveryTime();
		if ($data['delivery_status'] === 'closed') {
			$data['delivery_time'] = 'closed';
		} else if ($data['delivery_status'] === 'opening') {
			$data['delivery_time'] = $this->location->workingTime('delivery', 'open');
		}

		$data['collection_time'] = $this->location->collectionTime();
		if ($data['collection_status'] === 'closed') {
			$data['collection_time'] = 'closed';
		} else if ($data['collection_status'] === 'opening') {
			$data['collection_time'] = $this->location->workingTime('collection', 'open');
		}

		$conditions = array(
			'all'   => $this->lang->line('text_condition_all_orders'),
			'above' => $this->lang->line('text_condition_above_total'),
			'below' => $this->lang->line('text_condition_below_total'),
		);

		$count = 1;
		$data['text_delivery_condition'] = '';
		$delivery_condition = $this->location->deliveryCondition();
		foreach ($delivery_condition as $condition) {
			$condition = explode('|', $condition);

			$delivery = (isset($condition[0]) AND $condition[0] > 0) ? $this->currency->format($condition[0]) : $this->lang->line('text_free_delivery');
			$con = (isset($condition[1])) ? $condition[1] : 'above';
			$total = (isset($condition[2]) AND $condition[2] > 0) ? $this->currency->format($condition[2]) : $this->lang->line('text_no_min_total');

			if ($count === 1 AND isset($condition[0]) AND $condition[0] > 0) {
				$data['text_delivery_condition'] .= sprintf($this->lang->line('text_delivery_charge'), '');
			}

			if ($con === 'all') {
				$data['text_delivery_condition'] .= sprintf($conditions['all'], $delivery);
			} else if ($con === 'above') {
				$data['text_delivery_condition'] .= sprintf($conditions[$con], $delivery, $total) . ', ';
			} else if ($con === 'below') {
				$data['text_delivery_condition'] .= sprintf($conditions[$con], $total) . ', ';
			}

			$count++;
		}

		$data['text_delivery_condition'] = trim($data['text_delivery_condition'], ', ');

		if ($this->location->deliveryCharge($cart_total) > 0) {
			$data['text_delivery_charge'] = sprintf($this->lang->line('text_delivery_charge'), $this->currency->format($this->location->deliveryCharge($cart_total)));
		} else {
			$data['text_delivery_charge'] = $this->lang->line('text_free_delivery');
		}

		if ($this->location->minimumOrder($cart_total) > 0) {
			$data['min_total'] = $this->location->minimumOrder($cart_total);
		} else {
			$data['min_total'] = '0.00';
		}

		$this->load->model('Reviews_model');
		$total_reviews = $this->Reviews_model->getTotalLocationReviews($this->location->getId());
		$data['text_total_review'] = sprintf($this->lang->line('text_total_review'), $total_reviews);

		$data['local_alert'] = $this->alert->display('local_module');

		// pass array $data and load view files
		$this->load->view('local_module/local_module', $data);
	}

	public function search() {
		$this->load->library('user_agent');
		$json = array();

		$result = $this->location->searchRestaurant($this->input->post('search_query'));

		switch ($result) {
			case 'FAILED':
				$json['error'] = $this->lang->line('alert_unknown_error');
				break;
			case 'NO_SEARCH_QUERY':
				$json['error'] = $this->lang->line('alert_no_search_query');
				break;
			case 'INVALID_SEARCH_QUERY':
				$json['error'] = $this->lang->line('alert_invalid_search_query');    // display error: enter postcode
				break;
			case 'outside':
				$json['error'] = $this->lang->line('alert_no_found_restaurant');    // display error: no available restaurant
				break;
		}

		$redirect = '';
		if (!isset($json['error'])) {
			$redirect = $json['redirect'] = site_url('local?location_id='.$this->location->getId());
		}

		if ($redirect === '') {
			$redirect = $this->referrer_uri;
		}

		if ($this->input->is_ajax_request()) {
			$this->output->set_output(json_encode($json));											// encode the json array and set final out to be sent to jQuery AJAX
		} else {
			if (isset($json['error'])) $this->alert->set('custom', $json['error'], 'local_module');
			redirect($redirect);
		}
	}
}

/* End of file local_module.php */
/* Location: ./extensions/local_module/controllers/local_module.php */