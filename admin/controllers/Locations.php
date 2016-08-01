<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Locations extends Admin_Controller
{

	public $list_filters = array(
		'filter_search' => '',
		'filter_status' => '',
		'sort_by'       => 'location_id',
		'order_by'      => 'DESC',
	);

	public $sort_columns = array('location_name', 'location_city', 'location_state', 'location_postcode', 'location_id');

	public function __construct() {
		parent::__construct(); //  calls the constructor

		$this->user->restrict('Admin.Locations');

		$this->load->model('Settings_model'); // load the settings model
		$this->load->model('Locations_model'); // load the locations model
		$this->load->model('Tables_model');
		$this->load->model('Countries_model');
		$this->load->model('Extensions_model');

		$this->load->library('permalink');

		$this->lang->load('locations');
	}

	public function index() {
		if ($this->input->get('default') === '1' AND $this->input->get('location_id')) {
			if ($this->Locations_model->updateDefault($this->Locations_model->getAddress($this->input->get('location_id')))) {
				$this->alert->set('success', sprintf($this->lang->line('alert_success'), $this->lang->line('alert_set_default')));
			}

			$this->redirect();
		}

		if ($this->input->post('delete') AND $this->_deleteLocation() === TRUE) {
			$this->redirect();
		}

		$this->template->setTitle($this->lang->line('text_title'));
		$this->template->setHeading($this->lang->line('text_heading'));

		$this->template->setButton($this->lang->line('button_new'), array('class' => 'btn btn-primary', 'href' => page_url() . '/edit'));
		$this->template->setButton($this->lang->line('button_delete'), array('class' => 'btn btn-danger', 'onclick' => 'confirmDelete();'));;
		$this->template->setButton($this->lang->line('button_icon_filter'), array('class' => 'btn btn-default btn-filter pull-right', 'data-toggle' => 'button'));

		$data = $this->getList();

		$this->template->render('locations', $data);
	}

	public function edit() {
		if ($this->input->post() AND $location_id = $this->_saveLocation()) {
			$this->redirect($location_id);
		}

		$location_info = $this->Locations_model->getLocation((int)$this->input->get('id'));

		$title = (isset($location_info['location_name'])) ? $location_info['location_name'] : $this->lang->line('text_new');
		$this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $title));
		$this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $title));
		$this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('locations')));

		$this->template->setStyleTag(assets_url('js/datepicker/bootstrap-timepicker.css'), 'bootstrap-timepicker-css');
		$this->template->setScriptTag(assets_url("js/datepicker/bootstrap-timepicker.js"), 'bootstrap-timepicker-js');
		$this->template->setScriptTag(assets_url("js/jquery-sortable.js"), 'jquery-sortable-js');

		$data = $this->getForm($location_info);

		$this->template->render('locations_edit', $data);
	}

	protected function getList() {
		$data = array_merge($this->list_filters, $this->sort_columns);
		$data['order_by_active'] = $this->list_filters['order_by'] . ' active';

		$data['country_id'] = $this->config->item('country_id');
		$data['default_location_id'] = $this->config->item('default_location_id');

		$data['locations'] = array();
		$results = $this->Locations_model->paginate($this->list_filters, $this->index_url);
		foreach ($results->list as $result) {
			$default = ($result['location_id'] !== $this->config->item('default_location_id')) ? $this->pageUrl($this->index_url . '?default=1&location_id=' . $result['location_id']) : '1';
			$data['locations'][] = array_merge($result, array(
				'default' => $default,
				'edit'    => $this->pageUrl($this->edit_url, array('id' => $result['location_id'])),
			));
		}

		$data['pagination'] = $results->pagination;

		return $data;
	}

	protected function getForm($location_info = array()) {
		$data = $location_info;

		$location_id = 0;
		$data['_action'] = $this->pageUrl($this->create_url);
		if (!empty($location_info['location_id'])) {
			$location_id = $location_info['location_id'];
			$data['_action'] = $this->pageUrl($this->edit_url, array('id' => $location_id));
		}

		$data['map_key'] = ($this->config->item('maps_api_key')) ? '&key=' . $this->config->item('maps_api_key') : '';

		$this->template->setScriptTag('https://maps.googleapis.com/maps/api/js?v=3' . $data['map_key'] . '&sensor=false&region=GB&libraries=geometry', 'google-maps-js', '104330');

		$data['location_id'] = $location_info['location_id'];
		$data['location_name'] = $location_info['location_name'];
		$data['location_address_1'] = $location_info['location_address_1'];
		$data['location_address_2'] = $location_info['location_address_2'];
		$data['location_city'] = $location_info['location_city'];
		$data['location_state'] = $location_info['location_state'];
		$data['location_postcode'] = $location_info['location_postcode'];
		$data['location_email'] = !empty($location_info['location_email']) ? $location_info['location_email'] : $this->config->item('site_email');
		$data['location_telephone'] = $location_info['location_telephone'];
		$data['description'] = $location_info['description'];
		$data['location_lat'] = $location_info['location_lat'];
		$data['location_lng'] = $location_info['location_lng'];
		$data['location_status'] = isset($location_info['location_status']) ? $location_info['location_status'] : '1';
		$data['offer_delivery'] = $location_info['offer_delivery'];
		$data['offer_collection'] = $location_info['offer_collection'];
		$data['delivery_time'] = isset($location_info['delivery_time']) ? $location_info['delivery_time'] : '0';
		$data['collection_time'] = isset($location_info['collection_time']) ? $location_info['collection_time'] : '0';
		$data['last_order_time'] = isset($location_info['last_order_time']) ? $location_info['last_order_time'] : '0';
		$data['reservation_time_interval'] = $location_info['reservation_time_interval'];
		$data['reservation_stay_time'] = $location_info['reservation_stay_time'];

		$data['permalink'] = $this->permalink->getPermalink('location_id=' . $location_info['location_id']);
		$data['permalink']['url'] = root_url('local') . '/';

		$this->load->model('Image_tool_model');
		$data['no_location_image'] = $this->Image_tool_model->resize('data/no_photo.png');
		if ($this->input->post('location_image')) {
			$data['location_image'] = $this->input->post('location_image');
			$data['location_image_name'] = basename($this->input->post('location_image'));
			$data['location_image_url'] = $this->Image_tool_model->resize($this->input->post('location_image'));
		} else if (!empty($location_info['location_image'])) {
			$data['location_image'] = $location_info['location_image'];
			$data['location_image_name'] = basename($location_info['location_image']);
			$data['location_image_url'] = $this->Image_tool_model->resize($location_info['location_image']);
		} else {
			$data['location_image'] = '';
			$data['location_image_name'] = '';
			$data['location_image_url'] = $this->Image_tool_model->resize('data/no_photo.png');
		}

		if ($location_info['location_country_id']) {
			$data['country_id'] = $location_info['location_country_id'];
		} else if ($this->config->item('country_id')) {
			$data['country_id'] = $this->config->item('country_id');
		}

		$data['weekdays_abbr'] = $weekdays_abbr = array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');
		$data['weekdays'] = $weekdays = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');

		$options = array();
		if (!empty($location_info['options'])) {
			$options = unserialize($location_info['options']);
		}

		if ($location_info['location_lat'] AND $location_info['location_lng']) {
			$data['has_lat_lng'] = TRUE;
		} else {
			$data['has_lat_lng'] = FALSE;
		}

		if ($this->input->post('auto_lat_lng')) {
			$data['auto_lat_lng'] = $this->input->post('auto_lat_lng');
		} else if (isset($options['auto_lat_lng'])) {
			$data['auto_lat_lng'] = $options['auto_lat_lng'];
		} else {
			$data['auto_lat_lng'] = '1';
		}

		if ($this->input->post('opening_type')) {
			$data['opening_type'] = $this->input->post('opening_type');
		} else if (isset($options['opening_hours']['opening_type'])) {
			$data['opening_type'] = $options['opening_hours']['opening_type'];
		} else {
			$data['opening_type'] = '24_7';
		}

		if ($this->input->post('daily_days')) {
			$data['daily_days'] = $this->input->post('daily_days');
		} else if (isset($options['opening_hours']['daily_days']) AND is_array($options['opening_hours']['daily_days'])) {
			$data['daily_days'] = $options['opening_hours']['daily_days'];
		} else if (!$this->input->post('daily_days') AND $data['opening_type'] === 'daily' AND !isset($options['opening_hours']['daily_days'])) {
			$data['daily_days'] = array();
		} else {
			$data['daily_days'] = array('0', '1', '2', '3', '4', '5', '6');
		}

		if ($this->input->post('daily_hours')) {
			$data['daily_hours'] = $this->input->post('daily_hours');
		} else if (isset($options['opening_hours']['daily_hours']) AND is_array($options['opening_hours']['daily_hours'])) {
			$daily_hours = $options['opening_hours']['daily_hours'];
			$data['daily_hours']['open'] = (empty($daily_hours['open']) OR $daily_hours['open'] === '00:00:00') ? '12:00 AM' : mdate('%h:%i %a', strtotime($daily_hours['open']));
			$data['daily_hours']['close'] = (empty($daily_hours['close']) OR $daily_hours['close'] === '00:00:00') ? '11:59 PM' : mdate('%h:%i %a', strtotime($daily_hours['close']));
		} else {
			$data['daily_hours'] = array('open' => '12:00 AM', 'close' => '11:59 PM');
		}

		if ($this->input->post('flexible_hours')) {
			$data['flexible_hours'] = $this->input->post('flexible_hours');
		} else if (isset($options['opening_hours']['flexible_hours']) AND is_array($options['opening_hours']['flexible_hours'])) {
			$data['flexible_hours'] = array();
			foreach ($options['opening_hours']['flexible_hours'] as $flexible_hour) {
				$data['flexible_hours'][] = array(
					'day'    => $flexible_hour['day'],
					'open'   => (empty($flexible_hour['open']) OR $flexible_hour['open'] === '00:00:00') ? '12:00 AM' : mdate('%h:%i %a', strtotime($flexible_hour['open'])),
					'close'  => (empty($flexible_hour['close']) OR $flexible_hour['close'] === '00:00:00') ? '11:59 PM' : mdate('%h:%i %a', strtotime($flexible_hour['close'])),
					'status' => $flexible_hour['status'],
				);
			}
		} else {
			$data['flexible_hours'] = array(
				array('day' => '0', 'open' => '12:00 AM', 'close' => '11:59 PM', 'status' => '1'),
				array('day' => '1', 'open' => '12:00 AM', 'close' => '11:59 PM', 'status' => '1'),
				array('day' => '2', 'open' => '12:00 AM', 'close' => '11:59 PM', 'status' => '1'),
				array('day' => '3', 'open' => '12:00 AM', 'close' => '11:59 PM', 'status' => '1'),
				array('day' => '4', 'open' => '12:00 AM', 'close' => '11:59 PM', 'status' => '1'),
				array('day' => '5', 'open' => '12:00 AM', 'close' => '11:59 PM', 'status' => '1'),
				array('day' => '6', 'open' => '12:00 AM', 'close' => '11:59 PM', 'status' => '1'),
			);
		}

		if ($this->input->post('delivery_type')) {
			$data['delivery_type'] = $this->input->post('delivery_type');
		} else if (isset($options['opening_hours']['delivery_type'])) {
			$data['delivery_type'] = $options['opening_hours']['delivery_type'];
		} else {
			$data['delivery_type'] = '0';
		}

		if ($this->input->post('delivery_days')) {
			$data['delivery_days'] = $this->input->post('delivery_days');
		} else if (isset($options['opening_hours']['delivery_days']) AND is_array($options['opening_hours']['delivery_days'])) {
			$data['delivery_days'] = $options['opening_hours']['delivery_days'];
		} else if (!$this->input->post('delivery_days') AND $data['delivery_type'] === '1' AND !isset($options['opening_hours']['delivery_days'])) {
			$data['delivery_days'] = array();
		} else {
			$data['delivery_days'] = array('0', '1', '2', '3', '4', '5', '6');
		}

		if ($this->input->post('delivery_hours')) {
			$data['delivery_hours'] = $this->input->post('delivery_hours');
		} else if (isset($options['opening_hours']['delivery_hours']) AND is_array($options['opening_hours']['delivery_hours'])) {
			$delivery_hours = $options['opening_hours']['delivery_hours'];
			$data['delivery_hours']['open'] = (empty($delivery_hours['open']) OR $delivery_hours['open'] === '00:00:00') ? '12:00 AM' : mdate('%h:%i %a', strtotime($delivery_hours['open']));
			$data['delivery_hours']['close'] = (empty($delivery_hours['close']) OR $delivery_hours['close'] === '00:00:00') ? '11:59 PM' : mdate('%h:%i %a', strtotime($delivery_hours['close']));
		} else {
			$data['delivery_hours'] = array('open' => '12:00 AM', 'close' => '11:59 PM');
		}

		if ($this->input->post('collection_type')) {
			$data['collection_type'] = $this->input->post('collection_type');
		} else if (isset($options['opening_hours']['collection_type'])) {
			$data['collection_type'] = $options['opening_hours']['collection_type'];
		} else {
			$data['collection_type'] = '0';
		}

		if ($this->input->post('collection_days')) {
			$data['collection_days'] = $this->input->post('collection_days');
		} else if (isset($options['opening_hours']['collection_days']) AND is_array($options['opening_hours']['collection_days'])) {
			$data['collection_days'] = $options['opening_hours']['collection_days'];
		} else if (!$this->input->post('collection_days') AND $data['collection_type'] === '1' AND !isset($options['opening_hours']['collection_days'])) {
			$data['collection_days'] = array();
		} else {
			$data['collection_days'] = array('0', '1', '2', '3', '4', '5', '6');
		}

		if ($this->input->post('collection_hours')) {
			$data['collection_hours'] = $this->input->post('collection_hours');
		} else if (isset($options['opening_hours']['collection_hours']) AND is_array($options['opening_hours']['collection_hours'])) {
			$collection_hours = $options['opening_hours']['collection_hours'];
			$data['collection_hours']['open'] = (empty($collection_hours['open']) OR $collection_hours['open'] === '00:00:00') ? '12:00 AM' : mdate('%h:%i %a', strtotime($collection_hours['open']));
			$data['collection_hours']['close'] = (empty($collection_hours['close']) OR $collection_hours['close'] === '00:00:00') ? '11:59 PM' : mdate('%h:%i %a', strtotime($collection_hours['close']));
		} else {
			$data['collection_hours'] = array('open' => '12:00 AM', 'close' => '11:59 PM');
		}

		if ($this->input->post('future_orders')) {
			$data['future_orders'] = $this->input->post('future_orders');
		} else if (isset($options['future_orders'])) {
			$data['future_orders'] = $options['future_orders'];
		} else {
			$data['future_orders'] = $this->config->item('future_orders');
		}

		if ($this->input->post('future_order_days')) {
			$data['future_order_days'] = $this->input->post('future_order_days');
		} else if (isset($options['future_order_days'])) {
			$data['future_order_days'] = $options['future_order_days'];
		} else {
			$data['future_order_days'] = array('delivery' => '5', 'collection' => '5');
		}

		if ($this->input->post('payments')) {
			$data['payments'] = $this->input->post('payments');
		} else if (isset($options['payments'])) {
			$data['payments'] = $options['payments'];
		} else {
			$data['payments'] = array();
		}

		if ($this->input->post('tables')) {
			$data['location_tables'] = $this->input->post('tables');
		} else {
			$data['location_tables'] = $this->Tables_model->getTablesByLocation($location_id);
		}

		$area_colors = array('#F16745', '#FFC65D', '#7BC8A4', '#4CC3D9', '#93648D', '#404040', '#F16745', '#FFC65D', '#7BC8A4', '#4CC3D9', '#93648D', '#404040', '#F16745', '#FFC65D', '#7BC8A4', '#4CC3D9', '#93648D', '#404040', '#F16745', '#FFC65D');
		$data['area_colors'] = json_encode($area_colors);
		$data['delivery_charge_conditions'] = array(
			'all'   => $this->lang->line('text_all_orders'),
			'above' => $this->lang->line('text_above_order_total'),
		);

		if ($this->input->post('delivery_areas')) {
			$delivery_areas = $this->input->post('delivery_areas');
		} else if (isset($options['delivery_areas']) AND is_array($options['delivery_areas'])) {
			$delivery_areas = $options['delivery_areas'];
		} else {
			$delivery_areas = array();
		}

		$data['delivery_areas'] = array();
		foreach ($delivery_areas as $key => $area) {

			// backward compatibility
			if (isset($area['charge']) AND is_string($area['charge'])) {
				$area['charge'] = array(array(
					'amount'    => $area['charge'],
					'condition' => 'above',
					'total'     => (isset($area['min_amount'])) ? $area['min_amount'] : '',
				));
			}

			$data['delivery_areas'][] = array(
				'shape'    => (isset($area['shape'])) ? htmlspecialchars($area['shape']) : '',
				'circle'   => (isset($area['circle'])) ? htmlspecialchars($area['circle']) : '',
				'vertices' => (isset($area['vertices'])) ? htmlspecialchars($area['vertices']) : '',
				'name'     => (isset($area['name'])) ? $area['name'] : '',
				'type'     => (isset($area['type'])) ? $area['type'] : 'shape',
				'color'    => (isset($area_colors[$key - 1])) ? $area_colors[$key - 1] : '#F16745',
				'charge'   => (empty($area['charge'])) ? array(array('amount' => '', 'condition' => '', 'total' => '')) : $area['charge'],
			);
		}

		if ($this->input->post('gallery')) {
			$gallery = $this->input->post('gallery');
		} else if (isset($options['gallery']) AND is_array($options['gallery'])) {
			$gallery = $options['gallery'];
		} else {
			$gallery = array();
		}

		$data['gallery'] = array(
			'title'       => !empty($gallery) ? $gallery['title'] : '',
			'description' => !empty($gallery) ? $gallery['description'] : '',
		);

		if (!empty($gallery)) {
			if (isset($gallery['images']) AND is_array($gallery['images'])) {
				foreach ($gallery['images'] as $key => $image) {
					$data['gallery']['images'][$key] = array(
						'name'     => $image['name'],
						'path'     => $image['path'],
						'thumb'    => $this->Image_tool_model->resize($image['path'], 120, 120),
						'alt_text' => $image['alt_text'],
						'status'   => $image['status'],
					);
				}
			}
		}

		$data['tables'] = $this->Tables_model->getTables();

		$data['countries'] = $this->Countries_model->isEnabled()->dropdown('country_name');

		$data['payment_list'] = array();
		$payments = $this->Extensions_model->getPayments();
		foreach ($payments as $payment) {
			if (!empty($payment['ext_data'])) {
				if ($payment['ext_data']['status'] === '1') {
					$data['payment_list'][] = array(
						'name'     => $payment['title'],
						'code'     => $payment['name'],
						'priority' => $payment['ext_data']['priority'],
						'status'   => $payment['ext_data']['status'],
						'edit'     => $this->pageUrl("extensions/edit/payment/{$payment['name']}"),
					);
				}
			}
		}

		return $data;
	}

	protected function _saveLocation() {
		if ($this->validateForm() === TRUE) {
			$save_type = (!is_numeric($this->input->get('id'))) ? $this->lang->line('text_added') : $this->lang->line('text_updated');
			if ($location_id = $this->Locations_model->saveLocation($this->input->get('id'), $this->input->post())) {
				log_activity($this->user->getStaffId(), $save_type, 'locations', get_activity_message('activity_custom',
					array('{staff}', '{action}', '{context}', '{link}', '{item}'),
					array($this->user->getStaffName(), $save_type, 'location', $this->pageUrl($this->edit_url, array('id' => $location_id)), $this->input->post('location_name'))
				));

				$this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Location ' . $save_type));
			} else {
				$this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
			}

			return $location_id;
		}
	}

	protected function _deleteLocation() {
		if ($this->input->post('delete')) {
			$deleted_rows = $this->Locations_model->deleteLocation($this->input->post('delete'));
			if ($deleted_rows > 0) {
				$prefix = ($deleted_rows > 1) ? '[' . $deleted_rows . '] Locations' : 'Location';
				$this->alert->set('success', sprintf($this->lang->line('alert_success'), $prefix . ' ' . $this->lang->line('text_deleted')));
			} else {
				$this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_deleted')));
			}

			return TRUE;
		}
	}

	protected function validateForm() {
		$rules[] = array('location_name', 'lang:label_name', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$rules[] = array('email', 'lang:label_email', 'xss_clean|trim|required|valid_email');
		$rules[] = array('telephone', 'lang:label_telephone', 'xss_clean|trim|required|min_length[2]|max_length[15]');
		$rules[] = array('address[address_1]', 'lang:label_address_1', 'xss_clean|trim|required|min_length[2]|max_length[128]');
		$rules[] = array('address[address_2]', 'lang:label_address_2', 'xss_clean|trim|max_length[128]');
		$rules[] = array('address[city]', 'lang:label_city', 'xss_clean|trim|required|min_length[2]|max_length[128]');
		$rules[] = array('address[state]', 'lang:label_state', 'xss_clean|trim|max_length[128]');
		$rules[] = array('address[postcode]', 'lang:label_postcode', 'xss_clean|trim|min_length[2]|max_length[10]');
		$rules[] = array('address[country]', 'lang:label_country', 'xss_clean|trim|required|integer');

		$rules[] = array('auto_lat_lng', 'lang:label_auto_lat_lng', 'xss_clean|trim|required|integer');
		if ($this->input->post('auto_lat_lng') === '1') {
			$rules[] = array('auto_lat_lng', 'lang:label_auto_lat_lng', 'get_lat_lng[address]');
		} else {
			$rules[] = array('address[location_lat]', 'lang:label_latitude', 'xss_clean|trim|required|numeric');
			$rules[] = array('address[location_lng]', 'lang:label_longitude', 'xss_clean|trim|required|numeric');
		}

		$rules[] = array('description', 'lang:label_description', 'xss_clean|trim|min_length[2]|max_length[3028]');
		$rules[] = array('offer_delivery', 'lang:label_offer_delivery', 'xss_clean|trim|required|integer');
		$rules[] = array('offer_collection', 'lang:label_offer_collection', 'xss_clean|trim|required|integer');
		$rules[] = array('delivery_time', 'lang:label_delivery_time', 'xss_clean|trim|integer');
		$rules[] = array('collection_time', 'lang:label_collection_time', 'xss_clean|trim|integer');
		$rules[] = array('last_order_time', 'lang:label_last_order_time', 'xss_clean|trim|integer');
		$rules[] = array('future_orders', 'lang:label_future_orders', 'xss_clean|trim|required|integer');
		$rules[] = array('future_order_days[]', 'lang:label_future_order_days', 'xss_clean|trim|required|integer');
		$rules[] = array('payments[]', 'lang:label_payments', 'xss_clean|trim');
		$rules[] = array('tables[]', 'lang:label_tables', 'xss_clean|trim|integer');
		$rules[] = array('reservation_time_interval', 'lang:label_interval', 'xss_clean|trim|integer');
		$rules[] = array('reservation_stay_time', 'lang:label_turn_time', 'xss_clean|trim|integer');
		$rules[] = array('location_status', 'lang:label_status', 'xss_clean|trim|required|integer');
		$rules[] = array('permalink[permalink_id]', 'lang:label_permalink_id', 'xss_clean|trim|integer');
		$rules[] = array('permalink[slug]', 'lang:label_permalink_slug', 'xss_clean|trim|alpha_dash|max_length[255]');
		$rules[] = array('location_image', 'lang:label_image', 'xss_clean|trim');

		$rules[] = array('opening_type', 'lang:label_opening_type', 'xss_clean|trim|required|alpha_dash|max_length[10]');
		if ($this->input->post('opening_type') === 'daily' AND $this->input->post('daily_days')) {
			$rules[] = array('daily_days[]', 'lang:label_opening_days', 'xss_clean|trim|required|integer');
			$rules[] = array('daily_hours[open]', 'lang:label_open_hour', 'xss_clean|trim|required|valid_time');
			$rules[] = array('daily_hours[close]', 'lang:label_close_hour', 'xss_clean|trim|required|valid_time');
		}

		if ($this->input->post('opening_type') === 'flexible' AND $this->input->post('flexible_hours')) {
			foreach ($this->input->post('flexible_hours') as $key => $value) {
				$rules[] = array('flexible_hours[' . $key . '][day]', 'lang:label_opening_days', 'xss_clean|trim|required|numeric');
				$rules[] = array('flexible_hours[' . $key . '][open]', 'lang:label_open_hour', 'xss_clean|trim|required|valid_time');
				$rules[] = array('flexible_hours[' . $key . '][close]', 'lang:label_close_hour', 'xss_clean|trim|required|valid_time');
				$rules[] = array('flexible_hours[' . $key . '][status]', 'lang:label_opening_status', 'xss_clean|trim|required|integer');
			}
		}

		if ($this->input->post('delivery_areas')) {
			foreach ($this->input->post('delivery_areas') as $key => $value) {
				$rules[] = array('delivery_areas[' . $key . '][shape]', '[' . $key . '] ' . $this->lang->line('label_area_shape'), 'trim|required');
				$rules[] = array('delivery_areas[' . $key . '][circle]', '[' . $key . '] ' . $this->lang->line('label_area_circle'), 'trim|required');
				$rules[] = array('delivery_areas[' . $key . '][vertices]', '[' . $key . '] ' . $this->lang->line('label_area_vertices'), 'trim|required');
				$rules[] = array('delivery_areas[' . $key . '][type]', '[' . $key . '] ' . $this->lang->line('label_area_type'), 'xss_clean|trim|required');
				$rules[] = array('delivery_areas[' . $key . '][name]', '[' . $key . '] ' . $this->lang->line('label_area_name'), 'xss_clean|trim|required');

				if ($this->input->post('delivery_areas[' . $key . '][charge]')) {
					foreach ($this->input->post('delivery_areas[' . $key . '][charge]') as $k => $v) {
						$rules[] = array('delivery_areas[' . $key . '][charge][' . $k . '][amount]', '[' . $key . '] ' . $this->lang->line('label_area_charge'), 'xss_clean|trim|required|numeric');
						$rules[] = array('delivery_areas[' . $key . '][charge][' . $k . '][condition]', '[' . $key . '] ' . $this->lang->line('label_charge_condition'), 'xss_clean|trim|required|alpha_dash');
						$rules[] = array('delivery_areas[' . $key . '][charge][' . $k . '][total]', '[' . $key . '] ' . $this->lang->line('label_area_min_amount'), 'xss_clean|trim|numeric');

						if ($this->input->post('delivery_areas[' . $key . '][charge][' . $k . '][condition]') !== 'all') {
							$rules[] = array('delivery_areas[' . $key . '][charge][' . $k . '][total]', '[' . $key . '] ' . $this->lang->line('label_area_min_amount'), 'required');
						}
					}
				}
			}
		}

		$rules[] = array('gallery[title]', 'lang:label_gallery_title', 'xss_clean|trim|max_length[128]');
		$rules[] = array('gallery[description]', 'lang:label_gallery_description', 'xss_clean|trim|max_length[255]');
		if ($this->input->post('gallery')) {
			foreach ($this->input->post('gallery') as $key => $value) {
				if ($key === 'images') foreach ($value as $key => $image) {
					$rules[] = array('gallery[images][' . $key . '][name]', 'lang:label_gallery_image_name', 'xss_clean|trim|required');
					$rules[] = array('gallery[images][' . $key . '][path]', 'lang:label_gallery_image_thumbnail', 'xss_clean|trim|required');
					$rules[] = array('gallery[images][' . $key . '][alt_text]', 'lang:label_gallery_image_alt', 'xss_clean|trim');
					$rules[] = array('gallery[images][' . $key . '][status]', 'lang:label_gallery_image_status', 'xss_clean|trim|required|integer');
				}
			}
		}

		return $this->Locations_model->set_rules($rules)->validate();
	}
}

/* End of file Locations.php */
/* Location: ./admin/controllers/Locations.php */