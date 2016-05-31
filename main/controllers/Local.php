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
		$this->template->setScriptTag('js/jquery.mixitup.js', 'jquery-mixitup-js', '100330');

		$filter = array();

		if ($this->input->get('page')) {
			$filter['page'] = (int) $this->input->get('page');
		} else {
			$filter['page'] = '';
		}

		if ($this->config->item('menus_page_limit')) {
			$filter['limit'] = $this->config->item('menus_page_limit');
		}

		$filter['sort_by'] = 'menus.menu_priority';
		$filter['order_by'] = 'ASC';
		$filter['filter_status'] = '1';
		$filter['filter_category'] = (int) $this->input->get('category_id'); 									// retrieve 3rd uri segment else set FALSE if unavailable.

		$this->load->module('menus');
		$data['menu_list'] = $this->menus->getList($filter);

		$data['menu_total']	= $this->Menus_model->getCount();
		if (is_numeric($data['menu_total']) AND $data['menu_total'] < 150) {
			$filter['category_id'] = 0;
		}

		$data['location_name'] = $this->location->getName();

		$data['local_info'] = $this->info();

		$data['local_reviews'] = $this->reviews();

		$data['local_gallery'] = $this->gallery();

		$this->template->render('local', $data);
	}

	public function info($data = array()) {

		$time_format = ($this->config->item('time_format')) ? $this->config->item('time_format') : '%h:%i %a';

		if ($this->config->item('maps_api_key')) {
			$map_key = '&key=' . $this->config->item('maps_api_key');
		} else {
			$map_key = '';
		}

		$this->template->setScriptTag('https://maps.googleapis.com/maps/api/js?v=3' . $map_key .'&sensor=false&region=GB&libraries=geometry', 'google-maps-js', '104330');

		$data['has_delivery']       = $this->location->hasDelivery();
		$data['has_collection']     = $this->location->hasCollection();
		$data['opening_status']		= $this->location->workingStatus('opening');
		$data['delivery_status']	= $this->location->workingStatus('delivery');
		$data['collection_status']	= $this->location->workingStatus('collection');
		$data['last_order_time']    = mdate($time_format, strtotime($this->location->lastOrderTime()));
		$data['local_description']  = $this->location->getDescription();
		$data['map_address']        = $this->location->getAddress();                                        // retrieve local location data
		$data['location_telephone'] = $this->location->getTelephone();                                        // retrieve local location data

		$data['working_hours'] 		= $this->location->workingHours();                                //retrieve local restaurant opening hours from location library
		$data['working_type']      = $this->location->workingType();

		if (!$this->location->hasDelivery() OR empty($data['working_type']['delivery'])) {
			unset($data['working_hours']['delivery']);
		}

		if (!$this->location->hasCollection() OR empty($data['working_type']['collection'])) {
			unset($data['working_hours']['collection']);
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

		$local_payments = $this->location->payments();
		$payments = $this->extension->getAvailablePayments(FALSE);

		$payment_list = '';
		foreach ($payments as $code => $payment) {
			if ( empty($local_payments) OR in_array($code, $local_payments)) {
				$payment_list[] = $payment['name'];
			}
		}

		$data['payments'] = implode(', ', $payment_list);

		$area_colors = array('#F16745', '#FFC65D', '#7BC8A4', '#4CC3D9', '#93648D', '#404040', '#F16745', '#FFC65D', '#7BC8A4', '#4CC3D9', '#93648D', '#404040', '#F16745', '#FFC65D', '#7BC8A4', '#4CC3D9', '#93648D', '#404040', '#F16745', '#FFC65D');
		$data['area_colors'] = $area_colors;

		$conditions = array(
			'all'   => $this->lang->line('text_delivery_all_orders'),
			'above' => $this->lang->line('text_delivery_above_total'),
			'below' => $this->lang->line('text_delivery_below_total'),
		);

		$data['delivery_areas'] = array();
		$delivery_areas = $this->location->deliveryAreas();
		foreach ($delivery_areas as $area_id => $area) {
			if (isset($area['charge']) AND is_string($area['charge'])) {
				$area['charge'] = array(array(
					'amount' => $area['charge'],
					'condition' => 'above',
					'total' => (isset($area['min_amount'])) ? $area['min_amount'] : '0',
				));
			}

			$text_condition = '';
			foreach ($area['condition'] as $condition) {
				$condition = explode('|', $condition);

				$delivery = (isset($condition[0]) AND $condition[0] > 0) ? $this->currency->format($condition[0]) : $this->lang->line('text_free_delivery');
				$con = (isset($condition[1])) ? $condition[1] : 'above';
				$total = (isset($condition[2]) AND $condition[2] > 0) ? $this->currency->format($condition[2]) : $this->lang->line('text_no_min_total');

				if ($con === 'all') {
					$text_condition .= sprintf($conditions['all'], $delivery);
				} else if ($con === 'above') {
					$text_condition .= sprintf($conditions[$con], $delivery, $total) . ', ';
				} else if ($con === 'below') {
					$text_condition .= sprintf($conditions[$con], $total) . ', ';
				}
			}

			$data['delivery_areas'][] = array(
				'area_id'       => $area['area_id'],
				'name'          => $area['name'],
				'type'			=> $area['type'],
				'color'			=> $area_colors[(int) $area_id - 1],
				'shape'			=> $area['shape'],
				'circle'		=> $area['circle'],
				'condition'     => trim($text_condition, ', '),
			);
		}

		$data['location_lat'] = $data['location_lng'] = '';
		if ($local_info = $this->location->local()) {                                                            //if local restaurant data is available
			$data['location_lat'] = $local_info['location_lat'];
			$data['location_lng'] = $local_info['location_lng'];
		}

		return $data;
	}

	public function gallery($data = array()) {
		$gallery = $this->location->getGallery();

		if (empty($gallery) OR empty($gallery['images'])) {
			return $data;
		}

		$this->template->setScriptTag('js/jquery.bsPhotoGallery.js', 'jquery-bsPhotoGallery-js', '99330');

		$data['title'] = isset($gallery['title']) ? $gallery['title'] : '';
		$data['description'] = isset($gallery['description']) ? $gallery['description'] : '';

		foreach ($gallery['images'] as $key => $image) {
			if (isset($image['status']) AND $image['status'] !== '1') {
				$data['images'][$key] = array(
					'name'     => isset($image['name']) ? $image['name'] : '',
					'path'     => isset($image['path']) ? $image['path'] : '',
					'thumb'    => isset($image['path']) ? $this->Image_tool_model->resize($image['path']) : '',
					'alt_text' => isset($image['alt_text']) ? $image['alt_text'] : '',
					'status'   => $image['status'],
				);
			}
		}

		return $data;
	}

	public function reviews($data = array()) {
		$date_format = ($this->config->item('date_format')) ? $this->config->item('date_format') : '%d %M %y';

		$url = '&';
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
				'date'     => mdate($date_format, strtotime($result['date_added'])),
				'text'     => $result['review_text']
			);
		}

		$prefs['base_url'] = site_url('local?location_id='.$this->location->getId() . $url);
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
		$this->load->library('pagination');
		$this->load->library('cart'); 															// load the cart library
		$this->load->model('Image_tool_model');

		$url = '?';
		$filter = array();
		if ($this->input->get('page')) {
			$filter['page'] = (int) $this->input->get('page');
		} else {
			$filter['page'] = '';
		}

		if ($this->config->item('menus_page_limit')) {
			$filter['limit'] = $this->config->item('menus_page_limit');
		}

		$filter['filter_status'] = '1';
		$filter['order_by'] = 'ASC';

		if ($this->input->get('search')) {
			$filter['filter_search'] = $this->input->get('search');
			$url .= 'search='.$filter['filter_search'].'&';
		}

		if ($this->input->get('sort_by')) {
			$sort_by = $this->input->get('sort_by');

			if ($sort_by === 'newest') {
				$filter['sort_by'] = 'location_id';
				$filter['order_by'] = 'DESC';
			} else if ($sort_by === 'name') {
				$filter['sort_by'] = 'location_name';
			}

			$url .= 'sort_by=' . $sort_by . '&';
		}

		$this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
		$this->template->setBreadcrumb($this->lang->line('text_heading'), 'local/all');

		$this->template->setTitle($this->lang->line('text_heading'));
		$this->template->setHeading($this->lang->line('text_heading'));

		$review_totals = $this->Reviews_model->getTotalsbyId();                                    // retrieve all customer reviews from getMainList method in Reviews model

		$data['locations'] = array();
		$locations = $this->Locations_model->getList($filter);
		if ($locations) {
			foreach ($locations as $location) {
				$this->location->setLocation($location['location_id'], FALSE);

				$opening_status = $this->location->workingStatus('opening');
				$delivery_status = $this->location->workingStatus('delivery');
				$collection_status = $this->location->workingStatus('collection');

				$delivery_time = $this->location->deliveryTime();
				if ($delivery_status === 'closed') {
					$delivery_time = 'closed';
				} else if ($delivery_status === 'opening') {
					$delivery_time = $this->location->workingTime('delivery', 'open');
				}

				$collection_time = $this->location->collectionTime();
				if ($collection_status === 'closed') {
					$collection_time = 'closed';
				} else if ($collection_status === 'opening') {
					$collection_time = $this->location->workingTime('collection', 'open');
				}

				$review_totals = isset($review_totals[$location['location_id']]) ? $review_totals[$location['location_id']] : 0;

				$data['locations'][] = array(                                                            // create array of menu data to be sent to view
					'location_id'       => $location['location_id'],
					'location_name'     => $location['location_name'],
					'description'       => (strlen($location['description']) > 120) ? substr($location['description'], 0, 120) . '...' : $location['description'],
					'address'           => $this->location->getAddress(TRUE),
					'total_reviews'     => $review_totals,
					'location_image'    => $this->location->getImage(),
					'is_opened'         => $this->location->isOpened(),
					'is_closed'         => $this->location->isClosed(),
					'opening_status'    => $opening_status,
					'delivery_status'   => $delivery_status,
					'collection_status' => $collection_status,
					'delivery_time'     => $delivery_time,
					'collection_time'   => $collection_time,
					'opening_time'      => $this->location->openingTime(),
					'closing_time'      => $this->location->closingTime(),
					'min_total'         => $this->location->minimumOrder($this->cart->total()),
					'delivery_charge'   => $this->location->deliveryCharge($this->cart->total()),
					'has_delivery'      => $this->location->hasDelivery(),
					'has_collection'    => $this->location->hasCollection(),
					'last_order_time'   => $this->location->lastOrderTime(),
					'distance'   		=> round($this->location->checkDistance()),
					'distance_unit'   	=> $this->config->item('distance_unit') === 'km' ? $this->lang->line('text_kilometers') : $this->lang->line('text_miles'),
					'href'              => site_url('local?location_id=' . $location['location_id']),
				);
			}
		}

		if (!empty($sort_by) AND $sort_by === 'distance') {
			$data['locations'] = sort_array($data['locations'], 'distance');
		} else if (!empty($sort_by) AND $sort_by === 'rating') {
			$data['locations'] = sort_array($data['locations'], 'total_reviews');
		}

		$config['base_url'] 		= site_url('local/all'.$url);
		$config['total_rows'] 		= $this->Locations_model->getCount($filter);
		$config['per_page'] 		= $filter['limit'];

		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		$this->location->initialize();

		$data['locations_filter'] = $this->filter($url);

		$this->template->render('local_all', $data);
	}

	public function filter() {
		$url = '';

		$data['search'] = '';
		if ($this->input->get('search')) {
			$data['search'] = $this->input->get('search');
			$url .= 'search='.$this->input->get('search').'&';
		}

		$filters['distance']['name'] = lang('text_filter_distance');
		$filters['distance']['href'] = site_url('local/all?'.$url.'sort_by=distance');

		$filters['newest']['name'] = lang('text_filter_newest');
		$filters['newest']['href'] = site_url('local/all?'.$url.'sort_by=newest');

		$filters['rating']['name'] = lang('text_filter_rating');
		$filters['rating']['href'] = site_url('local/all?'.$url.'sort_by=rating');

		$filters['name']['name'] = lang('text_filter_name');
		$filters['name']['href'] = site_url('local/all?'.$url.'sort_by=name');

		$data['sort_by'] = '';
		if ($this->input->get('sort_by')) {
			$data['sort_by'] = $this->input->get('sort_by');
			$url .= 'sort_by=' . $data['sort_by'];
		}

		$data['filters'] = $filters;

		$url = (!empty($url)) ? '?'.$url : '';
		$data['search_action'] = site_url('local/all'.$url);

		return $data;
	}
}

/* End of file local.php */
/* Location: ./main/controllers/local.php */