<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Local_module extends Base_Component
{

	public function __construct() {
		parent::__construct();                                                                    // calls the constructor
		$this->load->library('user_agent');                                                        // load the user agent library
		$this->load->library('location');                                                        // load the location library

		$this->load->library('currency');                                                        // load the location library
		$this->lang->load('local_module/local_module');

		$referrer_uri = explode('/', str_replace(site_url(), '', $this->agent->referrer()));
		$this->referrer_uri = (!empty($referrer_uri[0]) AND $referrer_uri[0] !== 'local_module') ? $referrer_uri[0] : '';
	}

	public function index() {
		$this->location->initialize();

		if ($this->setting('status') != '1') {
			return;
		}

		$this->assets->setStyleTag(extension_url('local_module/assets/stylesheet.css'), 'local-module-css', '100000');

		$data['location_search_mode'] = 'multi';
		if ($this->setting('location_search_mode') === 'single') {
			if ($this->setting('use_location')) {
				$use_location = $this->setting('use_location');
			} else if ($this->input->get('location_id')) {
				$use_location = $this->input->get('location_id');
			} else {
				$use_location = $this->config->item('default_location_id');
			}

			$data['location_search_mode'] = 'single';
			if (!empty($use_location) AND is_numeric($use_location)) {
				$this->location->setLocation($use_location);
				$data['single_location_url'] = restaurant_url('menus?location_id=' . $use_location);
			} else {
				$data['single_location_url'] = restaurant_url('local/all');
			}
		}

		$data['local_action'] = site_url('local_module/local_module/search');

		$data['rsegment'] = $rsegment = ($this->uri->rsegment(1) === 'local_module' AND !empty($this->referrer_uri)) ? $this->referrer_uri : $this->uri->rsegment(1);

		$this->load->library('cart');                                                            // load the cart library
		$cart_total = $this->cart->total();

		$data['info_url'] = site_url('local');
		$data['local_info'] = $this->location->local();                                        // retrieve local location data
		$data['location_id'] = $this->location->getId();                                        // retrieve local location data
		$data['location_name'] = $this->location->getName();                                        // retrieve local location data
		$data['location_address'] = $this->location->getAddress();                                        // retrieve local location data
		$data['location_image'] = $this->location->getImage();                                        // retrieve local location data
		$data['is_opened'] = $this->location->isOpened();
		$data['opening_type'] = $this->location->workingType('opening');
		$data['opening_status'] = $this->location->workingStatus('opening');
		$data['delivery_status'] = $this->location->workingStatus('delivery');
		$data['collection_status'] = $this->location->workingStatus('collection');
		$data['opening_time'] = $this->location->workingTime('opening', 'open');
		$data['closing_time'] = $this->location->workingTime('opening', 'close');
		$data['order_type'] = $this->location->orderType();
		$data['delivery_charge'] = $this->location->deliveryCharge($cart_total);
		$data['delivery_coverage'] = $this->location->checkDeliveryCoverage();
		$data['search_query'] = $this->location->searchQuery();
		$data['has_search_query'] = $this->location->hasSearchQuery();
		$data['has_delivery'] = $this->location->hasDelivery();
		$data['has_collection'] = $this->location->hasCollection();
		$data['location_order'] = $this->config->item('location_order');

		$data['location_search'] = FALSE;
		if ($rsegment === 'home') {
			$data['location_search'] = TRUE;
		}

		if ($this->config->item('maps_api_key')) {
			$data['map_key'] = '&key=' . $this->config->item('maps_api_key');
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

		$this->location->locationDelivery()->setChargeSummaryText(array(
			'all'   => $this->lang->line('text_condition_all_orders'),
			'above' => $this->lang->line('text_condition_above_total'),
			'below' => $this->lang->line('text_condition_below_total'),
			'free' => $this->lang->line('text_free_delivery'),
			'min_total' => $this->lang->line('text_no_min_total'),
			'prefix' => $this->lang->line('text_delivery_charge'),
		));

		$data['text_delivery_condition'] = $this->location->getAreaChargeSummary();

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
			$redirect = $json['redirect'] = restaurant_url();
		}

		if ($redirect === '') {
			$redirect = $this->referrer_uri;
		}

		if ($this->input->is_ajax_request()) {
			$this->output->set_output(json_encode($json));                                            // encode the json array and set final out to be sent to jQuery AJAX
		} else {
			if (isset($json['error'])) $this->alert->set('custom', $json['error'], 'local_module');
			$this->redirect($redirect);
		}
	}
}

/* End of file Local_module.php */
/* Location: ./extensions/local_module/components/Local_module.php */