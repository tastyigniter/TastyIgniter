<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Local extends Main_Controller {

	public function __construct() {
		parent::__construct(); 																	// calls the constructor
		$this->load->library('location'); 														// load the location library
		$this->load->library('currency'); 														// load the currency library
		$this->load->model('Pages_model');
		$this->load->model('Reviews_model');

		$this->lang->load('local');
	}

	public function index() {
		$location_id = (int) $this->input->get('location_id'); 									// retrieve 3rd uri segment else set FALSE if unavailable.

		$locations = $this->location->getLocations();	 										// retrieve menus array based on category_id if available
		if (isset($locations[$location_id]) AND $this->input->get('location_id')) {
			$this->location->setLocation($location_id);
			redirect('menus');
		}

		if ( ! $this->location->local()) {
			redirect('menus');
		}

		if ($this->session->userdata('user_postcode')) {
			$data['postcode'] = $this->session->userdata('user_postcode'); 						// retrieve session userdata variable if available
		} else {
			$data['postcode'] = '';
		}

		$this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
		$this->template->setBreadcrumb($this->lang->line('text_heading'), 'local');

		// START of retrieving lines from language file to pass to view.
		$this->template->setTitle($this->lang->line('text_heading'));
		$this->template->setHeading($this->lang->line('text_heading'));
		$data['text_heading'] 			= $this->lang->line('text_heading');
		$data['text_local'] 			= sprintf($this->lang->line('text_local'), $this->location->getName());
		$data['text_opening_hours'] 	= $this->lang->line('text_opening_hours');
		$data['text_delivery_areas'] 	= $this->lang->line('text_delivery_areas');
		$data['text_open'] 				= $this->lang->line('text_open');
		$data['text_open24_7'] 			= $this->lang->line('text_open24_7');
		$data['text_delivery_time'] 	= $this->lang->line('text_delivery_time');
		$data['text_collection_time'] 	= $this->lang->line('text_collection_time');
		$data['text_delivery'] 			= $this->lang->line('text_delivery');
		$data['text_collection'] 		= $this->lang->line('text_collection');
		$data['text_delivery_only'] 	= $this->lang->line('text_delivery_only');
		$data['text_collection_only'] 	= $this->lang->line('text_collection_only');
		$data['text_no_types'] 			= $this->lang->line('text_no_types');
		$data['text_delivery_charge'] 	= $this->lang->line('text_delivery_charge');
		$data['text_last_order_time'] 	= $this->lang->line('text_last_order_time');
		$data['text_payments'] 			= $this->lang->line('text_payments');
		$data['text_min_total'] 		= $this->lang->line('text_min_total');
		$data['button_view_menu'] 		= $this->lang->line('button_view_menu');
		// END of retrieving lines from language file to pass to view.

		$data['local_location'] 		= $this->location->local(); 									//retrieve local restaurant data from location library
		$data['menus_url']				= site_url('menus');
		$data['map_address'] 			= $this->location->getAddress();
		$data['location_telephone'] 	= $this->location->getTelephone();
		$data['description'] 			= $this->location->getDescription();
		$data['opening_time'] 			= $this->location->openingTime();
		$data['closing_time'] 			= $this->location->closingTime();
		$data['opening_type'] 			= $this->location->getOpeningType();

		$opening_hours = $this->location->openingHours(); 								//retrieve local restaurant opening hours from location library
		$data['opening_hours'] = array();
		foreach ($opening_hours as $hour) {
			if ($hour['status'] === '1') {
				$time = $this->lang->line('text_close');
			} else if ($hour['open'] === '00:00' AND $hour['close'] === '23:59') {
				$time = $this->lang->line('text_24h');
			} else {
				$time = $hour['open'].' - '. $hour['close'];
			}

			$data['opening_hours'][] = array(
				'day'		=> $hour['day'],
				'time'		=> $time
			);
		}

		$data['order_type'] = $this->location->orderType();
		$data['has_delivery'] = $this->location->hasDelivery();
		$data['has_collection'] = $this->location->hasCollection();

		$delivery_areas = $this->location->deliveryAreas();
		foreach ($delivery_areas as $area_id => $area) {
			$data['delivery_areas'][] = array(
				'area_id'		=> $area['area_id'],
				'name'			=> $area['name'],
				'charge'		=> ($area['charge'] > 0) ? $this->currency->format($area['charge']) : $this->lang->line('text_free_delivery'),
				'min_amount'	=> ($area['min_amount'] > 0) ? $this->currency->format($area['min_amount']) : $this->currency->format('0.00')
			);
		}

		$data['delivery_time'] 		= $this->location->deliveryTime();
		$data['collection_time'] 	= $this->location->collectionTime();
		$data['last_order_time'] 	= $this->location->lastOrderTime();
		$data['payments'] 			= $this->location->paymentsList();

		if ($data['local_location']) { 															//if local restaurant data is available
			$data['location_lat'] 		= $data['local_location']['location_lat'];
			$data['location_lng'] 		= $data['local_location']['location_lng'];
		}

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

		$this->template->setPartials(array('header', 'content_top', 'content_left', 'content_right', 'content_bottom', 'footer'));
		$this->template->render('local', $data);
	}

	public function locations() {
		$this->load->library('country');

		$this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
		$this->template->setBreadcrumb($this->lang->line('text_locations_heading'), 'local/locations');

		$this->template->setTitle($this->lang->line('text_locations_heading'));
		$this->template->setHeading($this->lang->line('text_locations_heading'));
		$data['text_heading'] 			= $this->lang->line('text_locations_heading');
		$data['text_empty'] 			= $this->lang->line('text_empty');
		$data['text_avail'] 			= $this->lang->line('text_avail');
		$data['text_min_total'] 		= $this->lang->line('text_min_total');
		$data['text_24h'] 				= $this->lang->line('text_24h');
		$data['text_delivery_time'] 	= $this->lang->line('text_delivery_time');
		$data['text_collection_time'] 	= $this->lang->line('text_collection_time');

		$data['button_view_menu'] 		= $this->lang->line('button_view_menu');
		$data['local_location'] 		= FALSE; 									//retrieve local restaurant data from location library

		$current_time = mdate('%H:%i', time());

		$data['locations'] = array();
		$locations = $this->location->getLocations();	 										// retrieve menus array based on category_id if available
		$opening_hours = $this->location->getLocations();	 										// retrieve menus array based on category_id if available
		if ($locations) {
			foreach ($locations as $location) {															// loop through menus array
				$hour = $opening_time = $closing_time = '';
				$total_reviews = sprintf($this->lang->line('text_total_review'), site_url('local/reviews'), 1);

				if ($location['offer_delivery'] !== '1' AND $location['offer_collection'] === '1') { 														// checks if cart contents is empty
					$offers = $this->lang->line('text_collection');
				} else if ($location['offer_delivery'] === '1' AND $location['offer_collection'] !== '1') {
					$offers = $this->lang->line('text_delivery');
				} else if ($location['offer_delivery'] === '1' AND $location['offer_collection'] === '1') {
					$offers = $this->lang->line('text_both_types');						// display we are open
				} else {
					$offers = $this->lang->line('text_no_types');
				}

				$hour = $this->location->openingHours($location['location_id'], date('l'));
				$opening_time = (!isset($hour['open'])) ? '00:00' : mdate('%H:%i', strtotime($hour['open']));
				$closing_time = (!isset($hour['close'])) ? '00:00' : mdate('%H:%i', strtotime($hour['close']));
				$opening_status = $hour['close'];

				if (($opening_time <= $current_time AND $closing_time >= $current_time) OR ($opening_time === '00:00' OR $closing_time === '00:00')) {
					$open_or_closed = $this->lang->line('text_opened');
				} else {
					$open_or_closed = $this->lang->line('text_closed');
				}

				$location_address = array(
					'address_1'      => $location['location_address_1'],
					'address_2'      => $location['location_address_2'],
					'city'           => $location['location_city'],
					'state'          => $location['location_state'],
					'postcode'       => $location['location_postcode']
				);
				$address = $this->country->addressFormat($location_address);

				$data['locations'][] = array( 															// create array of menu data to be sent to view
					'location_id'			=> $location['location_id'],
					'location_name' 		=> $location['location_name'],
					'description' 			=> (strlen($location['description']) > 120) ? substr($location['description'], 0, 120) .'...' : $location['description'],
					'address'				=> str_replace('<br />', ', ', $address),
					'total_reviews'			=> $total_reviews,
					'open_or_closed'		=> $open_or_closed,
					'opening_type'			=> '24_7',
					'opening_status'		=> $opening_status,
					'opening_time'			=> $opening_time,
					'closing_time'			=> $closing_time,
					'offers'				=> $offers,
					'min_total' 			=> (isset($location['min_total']) AND $location['min_total'] > 0) ? $this->currency->format($location['min_total']) : 'None',
					'delivery_charge' 		=> (isset($location['delivery_charge']) AND $location['delivery_charge'] > 0) ? sprintf($this->lang->line('text_delivery_charge'), $this->currency->format($location['delivery_charge'])) : $this->lang->line('text_free_delivery'),
					'delivery_time' 		=> ($location['delivery_time'] === '0') ? $this->lang->line('text_asap') : $location['delivery_time'] . $this->lang->line('text_minutes'),
					'collection_time' 		=> ($location['collection_time'] === '0') ? $this->lang->line('text_asap') : $location['collection_time'] . $this->lang->line('text_minutes'),
					'href'					=> site_url('local?location_id='. $location['location_id'])
				);
			}
		}

		$this->template->setPartials(array('header', 'content_top', 'content_left', 'content_right', 'content_bottom', 'footer'));
		$this->template->render('local', $data);
	}

	public function reviews() {
		if ( ! $this->location->local()) {
			redirect('menus');
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

		$this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
		$this->template->setBreadcrumb($this->lang->line('text_heading'), 'local');
		$this->template->setBreadcrumb($this->lang->line('text_reviews_heading'), 'local/reviews');

		// START of retrieving lines from language file to pass to view.
		$this->template->setTitle($this->lang->line('text_reviews_heading'));
		$this->template->setHeading($this->lang->line('text_reviews_heading'));
		$data['text_heading'] 			= $this->lang->line('text_reviews_heading');
		$data['text_empty'] 			= $this->lang->line('text_empty');
		$data['text_review'] 			= sprintf($this->lang->line('text_review'), $this->location->getName());
		$data['text_from'] 				= $this->lang->line('text_from');
		$data['text_on'] 				= $this->lang->line('text_on');
		$data['local_location'] 		= $this->location->local(); 									//retrieve local restaurant data from location library

		$total_reviews = $this->Reviews_model->getTotalLocationReviews($this->location->getId());
		$data['text_total_review'] = sprintf($this->lang->line('text_total_review'), site_url('local/reviews'), $total_reviews);

		$ratings = $this->config->item('ratings');
		$data['ratings'] = $ratings['ratings'];

		$data['reviews'] = array();
		$results = $this->Reviews_model->getList($filter);									// retrieve all customer reviews from getMainList method in Reviews model
		foreach ($results as $result) {
			$data['reviews'][] = array(															// create array of customer reviews to pass to view
				'author'			=> $result['author'],
				'city'				=> $result['location_city'],
				'quality' 			=> $result['quality'],
				'delivery' 			=> $result['delivery'],
				'service' 			=> $result['service'],
				'date'				=> mdate('%d %M %y', strtotime($result['date_added'])),
				'text'				=> $result['review_text']
			);
		}

		$prefs['base_url'] 			= site_url('local').$url;
		$prefs['total_rows'] 		= $this->Reviews_model->getCount($filter);
		$prefs['per_page'] 			= $filter['limit'];

		$this->load->library('pagination');
		$this->pagination->initialize($prefs);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);


		$this->template->setPartials(array('header', 'content_top', 'content_left', 'content_right', 'content_bottom', 'footer'));
		$this->template->render('local_reviews', $data);
	}
}

/* End of file location.php */
/* Location: ./main/controllers//location.php */