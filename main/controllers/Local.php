<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Local extends Main_Controller {

	public function __construct() {
		parent::__construct(); 																	// calls the constructor

        $this->load->model('Locations_model');
        $this->load->model('Pages_model');
        $this->load->model('Reviews_model');

        $this->load->library('location'); 														// load the location library
        $this->load->library('currency'); 														// load the currency library

        $this->lang->load('local');
	}

	public function index() {
		if (!($location = $this->Locations_model->getLocation($this->input->get('location_id')))) {
            redirect('local/all');
        }

        $this->location->setLocation($location['location_id']);

		$this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
		$this->template->setBreadcrumb($this->lang->line('text_heading'), 'local/all');
		$this->template->setBreadcrumb($location['location_name']);

        $text_heading = sprintf($this->lang->line('text_local_heading'), $location['location_name']);
        $this->template->setTitle($text_heading);
        $this->template->setScriptTag('js/jquery.mixitup.js', 'jquery-mixitup-css', '100330');

        $filter = array();

        if ($this->input->get('page')) {
            $filter['page'] = (int) $this->input->get('page');
        } else {
            $filter['page'] = '';
        }

        if ($this->config->item('menus_page_limit')) {
            $filter['limit'] = $this->config->item('menus_page_limit');
        }

        $filter['sort_by'] = 'menus.menu_id';
        $filter['order_by'] = 'ASC';
        $filter['filter_status'] = '1';
        $filter['filter_category'] = (int) $this->input->get('category_id'); 									// retrieve 3rd uri segment else set FALSE if unavailable.

        $this->load->module('menus');
        $data['menu_list'] = $this->menus->getList($filter);

        $data['menu_total']	= $this->Menus_model->getCount();
        if (is_numeric($data['menu_total']) AND $data['menu_total'] < 150) {
            $filter['category_id'] = 0;
        }

        $data['local_info'] = $this->info();

        $data['local_reviews'] = $this->reviews();

		$this->template->render('local', $data);
	}

    public function info($data = array()) {

        if ($this->config->item('maps_api_key')) {
            $map_key = '&key=' . $this->config->item('maps_api_key');
        } else {
            $map_key = '';
        }

        $this->template->setScriptTag('https://maps.googleapis.com/maps/api/js?v=3' . $map_key .'&sensor=false&region=GB', 'google-maps-js', '104330');

        $opening_hours = $this->location->openingHours();                                //retrieve local restaurant opening hours from location library
        $data['opening_hours'] = array();
        foreach ($opening_hours as $hour) {
            if ($hour['status'] !== '1') {
                $time = $this->lang->line('text_closed');
            } else if ($hour['open'] === '00:00' AND $hour['close'] === '23:59') {
                $time = $this->lang->line('text_24h');
            } else {
                $time = $hour['open'] . ' - ' . $hour['close'];
            }

            $data['opening_hours'][] = array(
                'day'  => $hour['day'],
                'time' => $time
            );
        }

        $data['opening_type']       = $this->location->getOpeningType();
        $data['has_delivery']       = $this->location->hasDelivery();
        $data['has_collection']     = $this->location->hasCollection();
        $data['delivery_time']      = $this->location->deliveryTime();
        $data['collection_time']    = $this->location->collectionTime();
        $data['last_order_time']    = $this->location->lastOrderTime();
        $data['local_description']  = $this->location->getDescription();
        $data['map_address']        = $this->location->getAddress();                                        // retrieve local location data
        $data['location_telephone'] = $this->location->getTelephone();                                        // retrieve local location data

        $local_payments = $this->location->payments();
        $payments = $this->extension->getAvailablePayments(FALSE);

        $payment_list = '';
        foreach ($payments as $code => $payment) {
            if ( empty($local_payments) OR in_array($code, $local_payments)) {
                $payment_list .= $payment['name'] . ', ';
            }
        }

        $data['payments'] = trim($payment_list, ', ').'.';

        $data['delivery_areas'] = array();
        $delivery_areas = $this->location->deliveryAreas();
        foreach ($delivery_areas as $area_id => $area) {
            $data['delivery_areas'][] = array(
                'area_id'       => $area['area_id'],
                'name'          => $area['name'],
                'charge'        => ($area['charge'] > 0) ? $this->currency->format($area['charge']) : $this->lang->line('text_free_delivery'),
                'min_amount'    => ($area['min_amount'] > 0) ? $this->currency->format($area['min_amount']) : $this->currency->format('0.00')
            );
        }

        $data['location_lat'] = $data['location_lng'] = '';
        if ($local_info = $this->location->local()) {                                                            //if local restaurant data is available
            $data['location_lat'] = $local_info['location_lat'];
            $data['location_lng'] = $local_info['location_lng'];
        }

        return $data;
    }

    public function reviews($data = array()) {
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

        $filter['filter_status'] = '1';

        $ratings = $this->config->item('ratings');
        $data['ratings'] = $ratings['ratings'];

        $data['reviews'] = array();
        $results = $this->Reviews_model->getList($filter);                                    // retrieve all customer reviews from getMainList method in Reviews model
        foreach ($results as $result) {
            $data['reviews'][] = array(                                                            // create array of customer reviews to pass to view
                'author'   => $result['author'],
                'city'     => $result['location_city'],
                'quality'  => $result['quality'],
                'delivery' => $result['delivery'],
                'service'  => $result['service'],
                'date'     => mdate('%d %M %y', strtotime($result['date_added'])),
                'text'     => $result['review_text']
            );
        }

        $prefs['base_url'] = site_url('local' . $url);
        $prefs['total_rows'] = $this->Reviews_model->getCount($filter);
        $prefs['per_page'] = $filter['limit'];

        $this->load->library('pagination');
        $this->pagination->initialize($prefs);

        $data['pagination'] = array(
            'info'  => $this->pagination->create_infos(),
            'links' => $this->pagination->create_links()
        );

        return $data;
    }

    public function all() {
		$this->load->library('country');
        $this->load->model('Image_tool_model');

        $locations = $this->Locations_model->getLocations();

		$this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
		$this->template->setBreadcrumb($this->lang->line('text_heading'), 'local/all');

		$this->template->setTitle($this->lang->line('text_heading'));
		$this->template->setHeading($this->lang->line('text_heading'));

		$current_time = mdate('%H:%i', time());
        $review_totals = $this->Reviews_model->getTotalsbyId();                                    // retrieve all customer reviews from getMainList method in Reviews model

		$data['locations'] = array();
		if ($locations) {
			foreach ($locations as $location) {															// loop through menus array
                $location_image = (!empty($location['location_image'])) ? $this->Image_tool_model->resize($location['location_image'], '80', '80') : '';

				if ($location['offer_delivery'] !== '1' AND $location['offer_collection'] === '1') { 														// checks if cart contents is empty
					$offers = $this->lang->line('text_only_collection_is_available');
				} else if ($location['offer_delivery'] === '1' AND $location['offer_collection'] !== '1') {
					$offers = $this->lang->line('text_only_delivery_is_available');
				} else if ($location['offer_delivery'] === '1' AND $location['offer_collection'] === '1') {
					$offers = $this->lang->line('text_offers_both_types');						// display we are open
				} else {
					$offers = $this->lang->line('text_offers_no_types');
				}

				$hour = $this->location->openingHours($location['location_id'], date('l'));
				$opening_time = (!isset($hour['open'])) ? '00:00' : mdate('%H:%i', strtotime($hour['open']));
				$closing_time = (!isset($hour['close'])) ? '00:00' : mdate('%H:%i', strtotime($hour['close']));
				$opening_status = (!isset($hour['status'])) ? '' : $hour['status'];

                if ($opening_status === '1' AND ($opening_time <= $current_time AND $closing_time >= $current_time)) {
					$open_or_closed = $this->lang->line('text_is_opened');
				} else if ($opening_status !== '1') {
					$open_or_closed = $this->lang->line('text_is_temp_closed');
				} else {
					$open_or_closed = $this->lang->line('text_is_closed');
				}

                $delivery_time = (!empty($location['delivery_time'])) ? $location['delivery_time'] : $this->config->item('delivery_time');
                $collection_time = (!empty($location['collection_time'])) ? $location['collection_time'] : $this->config->item('collection_time');
                $last_order_time = (is_numeric($location['last_order_time']) AND $location['last_order_time'] > 0) ? mdate($current_time, strtotime($opening_time) - ($location['last_order_time'] * 60)) : $closing_time;

                $address = $this->country->addressFormat(array(
					'address_1'      => $location['location_address_1'],
					'address_2'      => $location['location_address_2'],
					'city'           => $location['location_city'],
					'state'          => $location['location_state'],
					'postcode'       => $location['location_postcode']
				));

                $review_totals = isset($review_totals[$location['location_id']]) ? $review_totals[$location['location_id']] : 0;
                $total_reviews = sprintf($this->lang->line('text_total_review'), $review_totals);

                $data['locations'][] = array( 															// create array of menu data to be sent to view
					'location_id'			=> $location['location_id'],
					'location_name' 		=> $location['location_name'],
                    'description' 			=> (strlen($location['description']) > 120) ? substr($location['description'], 0, 120) .'...' : $location['description'],
                    'address'				=> $address,
                    'total_reviews'			=> $total_reviews,
                    'location_image' 		=> $location_image,
                    'open_or_closed'		=> $open_or_closed,
                    'opening_status'		=> $opening_status,
                    'opening_time'			=> mdate('%h:%i %a', strtotime($opening_time)),
                    'closing_time'			=> mdate('%h:%i %a', strtotime($closing_time)),
                    'offers'				=> $offers,
                    'min_total' 			=> (isset($location['min_total']) AND $location['min_total'] > 0) ? $this->currency->format($location['min_total']) : 'None',
                    'delivery_charge' 		=> (isset($location['delivery_charge']) AND $location['delivery_charge'] > 0) ? sprintf($this->lang->line('text_delivery_charge'), $this->currency->format($location['delivery_charge'])) : $this->lang->line('text_free_delivery'),
                    'delivery_time' 		=> ($delivery_time === '0') ? $this->lang->line('text_asap') : $delivery_time .' '. $this->lang->line('text_minutes'),
                    'collection_time' 		=> ($collection_time === '0') ? $this->lang->line('text_asap') : $collection_time .' '. $this->lang->line('text_minutes'),
                    'last_order_time'		=> $last_order_time,
                    'href'					=> site_url('local?location_id='. $location['location_id'])
				);
			}
		}

		$this->template->render('local_all', $data);
	}
}

/* End of file local.php */
/* Location: ./main/controllers/local.php */