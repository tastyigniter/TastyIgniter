<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Local_module extends Main_Controller {

	public function __construct() {
		parent::__construct(); 																	// calls the constructor
		$this->load->library('location'); 														// load the location library
		$this->load->library('currency'); 														// load the location library
		$this->lang->load('local_module/local_module');

        $referrer_uri = explode('/', str_replace(site_url(), '', $this->agent->referrer()));
        $this->referrer_uri = (!empty($referrer_uri[0]) AND $referrer_uri[0] !== 'local_module') ? $referrer_uri[0] : 'home';
	}

	public function index($ext_data = array()) {
		if ( ! file_exists(EXTPATH .'local_module/views/local_module.php')) { 								//check if file exists in views folder
			show_404(); 																		// Whoops, show 404 error page!
		}

        $this->template->setStyleTag(extension_url('local_module/views/stylesheet.css'), 'local-module-css', '100000');

        $data['local_action']			= site_url('local_module/local_module/search');

        $data['rsegment'] = $rsegment = ($this->uri->rsegment(1) === 'local_module' AND !empty($this->referrer_uri)) ? $this->referrer_uri : $this->uri->rsegment(1);

        $data['local_alert']            = $this->alert->display('local_module');

        $data['info_url'] 				= site_url('local');
        $data['local_info'] 			= $this->location->local(); 										// retrieve local location data
        $data['location_id'] 			= $this->location->getId(); 										// retrieve local location data
        $data['location_name'] 			= $this->location->getName(); 										// retrieve local location data
        $data['location_address'] 		= $this->location->getAddress(); 										// retrieve local location data
        $data['location_image'] 		= $this->location->getImage(); 										// retrieve local location data
        $data['is_opened'] 			    = $this->location->isOpened();
        $data['opening_type'] 			= $this->location->getOpeningType();
        $data['opening_status']		 	= $this->location->openingStatus();
        $data['opening_time']		 	= $this->location->openingTime();
        $data['closing_time'] 			= $this->location->closingTime();
        $data['order_type']             = $this->location->orderType();
        $data['delivery_charge']        = $this->location->deliveryCharge();
        $data['delivery_time'] 		    = $this->location->deliveryTime();
        $data['collection_time'] 	    = $this->location->collectionTime();
        $data['search_query']           = $this->location->searchQuery();
        $data['has_delivery']           = $this->location->hasDelivery();
        $data['has_collection']         = $this->location->hasCollection();

        $data['location_search'] = FALSE;
        if ($rsegment === 'home') {
            $data['location_search'] = TRUE;
        }

        if ($this->config->item('maps_api_key')) {
            $data['map_key'] = '&key='. $this->config->item('maps_api_key');
        } else {
            $data['map_key'] = '';
        }

        if (!$this->location->hasDelivery() AND $this->location->hasCollection()) { 														// checks if cart contents is empty
            $data['text_service_offered'] = $this->lang->line('text_collection_only');
        } else if ($this->location->hasDelivery() AND !$this->location->hasCollection()) {
            $data['text_service_offered'] = $this->lang->line('text_delivery_only');
        } else if ($this->location->hasDelivery() AND $this->location->hasCollection()) {
            $data['text_service_offered'] = $this->lang->line('text_both_types');						// display we are open
        } else {
            $data['text_service_offered'] = $this->lang->line('text_no_types');
        }

        if ($this->location->deliveryCharge() > 0) {
            $data['text_delivery_charge'] = sprintf($this->lang->line('text_delivery_charge'), $this->currency->format($this->location->deliveryCharge()));
        } else {
            $data['text_delivery_charge'] = $this->lang->line('text_free_delivery');
        }

        if ($this->location->minimumOrder() > 0) {
            $data['min_total'] = $this->currency->format($this->location->minimumOrder());
        } else {
            $data['min_total'] = $this->currency->format('0.00');
        }

        $this->load->model('Reviews_model');
        $total_reviews = $this->Reviews_model->getTotalLocationReviews($this->location->getId());
        $data['text_total_review'] = sprintf($this->lang->line('text_total_review'), $total_reviews);

        // pass array $data and load view files
        $this->load->view('local_module/local_module', $data);
    }

    public function order_type() {																	// _updateModule() method to update cart
        $json = array();

        if (!$json) {
            $this->load->library('location');
            $this->load->library('cart');

            if ( ! $this->location->isOpened() AND $this->config->item('future_orders') !== '1') { 													// else if local restaurant is not open
                $json['error'] = $this->lang->line('alert_location_closed');
            } else if ( ! $this->location->isOpened() AND $this->config->item('future_orders') === '1') {
                $json['error'] = $this->lang->line('alert_local_future_order');
            } else {
                $order_type = (is_numeric($this->input->post('order_type'))) ? $this->input->post('order_type') : '1';

                if ($order_type === '1') {
                    if ( ! $this->location->hasDelivery()) {
                        $json['error'] = $this->lang->line('alert_delivery_unavailable');
                    } else if ($this->location->hasSearchQuery() AND $this->location->hasDelivery() AND ! $this->location->checkDeliveryCoverage()) {
                        $json['error'] = $this->lang->line('alert_delivery_coverage');
                    } else if ($this->cart->contents() AND ! $this->location->checkMinimumOrder($this->cart->total())) {                            // checks if cart contents is empty
                        $json['error'] = $this->lang->line('alert_min_delivery_order_total');
                    }

                } else if ($order_type === '2') {
                    if ( ! $this->location->hasCollection()) {
                        $json['error'] = $this->lang->line('alert_collection_unavailable');
                    }
                }

                $this->location->setOrderType($order_type);
            }
        }

        $this->output->set_output(json_encode($json));	// encode the json array and set final out to be sent to jQuery AJAX
    }

    public function search() {
		$this->load->library('user_agent');
		$json = array();

		$result = $this->location->searchRestaurant($this->input->post('search_query'));

		switch ($result) {
			case 'NO_SEARCH_QUERY':
				$json['error'] = $this->lang->line('alert_no_search_query');
				break;
			case 'INVALID_SEARCH_QUERY':
				$json['error'] = $this->lang->line('alert_invalid_search_query');	// display error: enter postcode
				break;
			case 'outside':
				$json['error'] = $this->lang->line('alert_no_found_restaurant');	// display error: no available restaurant
				break;
		}

        $redirect = '';
		if (!isset($json['error'])) {
			$order_type = (is_numeric($this->input->post('order_type'))) ? $this->input->post('order_type') : '1';
			$this->location->setOrderType($order_type);

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