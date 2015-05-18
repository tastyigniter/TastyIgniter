<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Locations extends Admin_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		$this->load->library('location'); // load the location library
        $this->load->library('permalink');
		$this->load->library('pagination');
		$this->load->model('Settings_model'); // load the settings model
		$this->load->model('Locations_model'); // load the locations model
		$this->load->model('Tables_model');
		$this->load->model('Countries_model');
		$this->load->model('Extensions_model');
	}

	public function index() {
        $url = '?';
        $filter = array();
        if ($this->input->get('page')) {
            $filter['page'] = (int) $this->input->get('page');
        } else {
            $filter['page'] = '';
        }

        if ($this->config->item('page_limit')) {
            $filter['limit'] = $this->config->item('page_limit');
        }

        if ($this->input->get('filter_search')) {
            $filter['filter_search'] = $data['filter_search'] = $this->input->get('filter_search');
            $url .= 'filter_search='.$filter['filter_search'].'&';
        } else {
            $data['filter_search'] = '';
        }

        if (is_numeric($this->input->get('filter_status'))) {
            $filter['filter_status'] = $data['filter_status'] = $this->input->get('filter_status');
            $url .= 'filter_status='.$filter['filter_status'].'&';
        } else {
            $filter['filter_status'] = $data['filter_status'] = '';
        }

        if ($this->input->get('sort_by')) {
            $filter['sort_by'] = $data['sort_by'] = $this->input->get('sort_by');
        } else {
            $filter['sort_by'] = $data['sort_by'] = 'location_id';
        }

        if ($this->input->get('order_by')) {
            $filter['order_by'] = $data['order_by'] = $this->input->get('order_by');
            $data['order_by_active'] = $this->input->get('order_by') .' active';
        } else {
            $filter['order_by'] = $data['order_by'] = 'DESC';
            $data['order_by_active'] = 'DESC';
        }

        $this->template->setTitle('Locations');
        $this->template->setHeading('Locations');
        $this->template->setButton('+ New', array('class' => 'btn btn-primary', 'href' => page_url() .'/edit'));
        $this->template->setButton('Delete', array('class' => 'btn btn-danger', 'onclick' => '$(\'#list-form\').submit();'));

        $data['text_empty'] 		= 'There are no locations available.';

        $order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'ASC') ? 'DESC' : 'ASC';
        $data['sort_name'] 			= site_url('locations'.$url.'sort_by=location_name&order_by='.$order_by);
        $data['sort_city'] 			= site_url('locations'.$url.'sort_by=location_city&order_by='.$order_by);
        $data['sort_postcode'] 		= site_url('locations'.$url.'sort_by=location_postcode&order_by='.$order_by);
        $data['sort_id'] 			= site_url('locations'.$url.'sort_by=location_id&order_by='.$order_by);

        $data['country_id'] = $this->config->item('country_id');
        $data['default_location_id'] = $this->config->item('default_location_id');

        $data['locations'] = array();
        $results = $this->Locations_model->getList($filter);
        foreach ($results as $result) {
            if ($result['location_id'] !== $this->config->item('default_location_id')) {
                $default = site_url('locations?default=1&location_id='. $result['location_id']);
            } else {
                $default = '1';
            }

            $data['locations'][] = array(
				'location_id'			=> $result['location_id'],
				'location_name'			=> $result['location_name'],
				'location_address_1'	=> $result['location_address_1'],
				'location_city'			=> $result['location_city'],
				'location_postcode'		=> $result['location_postcode'],
				'location_telephone'	=> $result['location_telephone'],
				'location_lat'			=> $result['location_lat'],
				'location_lng'			=> $result['location_lng'],
				'location_status'		=> ($result['location_status'] === '1') ? 'Enabled' : 'Disabled',
				'default'				=> $default,
				'edit' 					=> site_url('locations/edit?id=' . $result['location_id'])
			);
        }

        $data['tables'] = array();
        $tables = $this->Tables_model->getTables();
        if ($tables) {
            foreach ($tables as $table) {
                $data['tables'][] = array(
				'table_id'			=> $table['table_id'],
				'table_name'		=> $table['table_name'],
				'min_capacity'		=> $table['min_capacity'],
				'max_capacity'	=> $table['max_capacity']
			);
            }
        }

        $data['countries'] = array();
        $results = $this->Countries_model->getCountries();
        foreach ($results as $result) {
            $data['countries'][] = array(
				'country_id'	=>	$result['country_id'],
				'name'			=>	$result['country_name'],
			);
        }

        if ($this->input->get('sort_by') AND $this->input->get('order_by')) {
            $url .= 'sort_by='.$filter['sort_by'].'&';
            $url .= 'order_by='.$filter['order_by'].'&';
        }

        $config['base_url'] 		= site_url('locations').$url;
        $config['total_rows'] 		= $this->Locations_model->getCount($filter);
        $config['per_page'] 		= $filter['limit'];

        $this->pagination->initialize($config);

        $data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

        if ($this->input->get('default') === '1' AND $this->input->get('location_id')) {
            $location_id = $this->input->get('location_id');

            if ($this->Locations_model->updateDefault($this->Locations_model->getAddress($location_id))) {
                $this->alert->set('success', 'Location set as default successfully!');
            }

            redirect('locations');
        }

        if ($this->input->post('delete') AND $this->_deleteLocation() === TRUE) {

            redirect('locations');
        }

        $this->template->setPartials(array('header', 'footer'));
        $this->template->render('locations', $data);
    }

	public function edit() {
		$location_info = $this->Locations_model->getLocation((int) $this->input->get('id'));

		if ($location_info) {
			$location_id = $location_info['location_id'];
			$data['action']	= site_url('locations/edit?id='. $location_id);
		} else {
		    $location_id = 0;
			$data['action']	= site_url('locations/edit');
		}

		$title = (isset($location_info['location_name'])) ? $location_info['location_name'] : 'New';
		$this->template->setTitle('Location: '. $title);
		$this->template->setHeading('Location: '. $title);
		$this->template->setButton('Save', array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton('Save & Close', array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setBackButton('btn btn-back', site_url('locations'));

		$data['location_id'] 			= $location_info['location_id'];
		$data['location_name'] 			= $location_info['location_name'];
		$data['location_address_1'] 	= $location_info['location_address_1'];
		$data['location_address_2'] 	= $location_info['location_address_2'];
		$data['location_city'] 			= $location_info['location_city'];
		$data['location_postcode'] 		= $location_info['location_postcode'];
		$data['location_email'] 		= $location_info['location_email'];
		$data['location_telephone'] 	= $location_info['location_telephone'];
		$data['description'] 			= $location_info['description'];
		$data['location_lat'] 			= $location_info['location_lat'];
		$data['location_lng'] 			= $location_info['location_lng'];
		$data['location_status'] 		= $location_info['location_status'];
		$data['last_order_time'] 		= $location_info['last_order_time'];
		$data['offer_delivery'] 		= $location_info['offer_delivery'];
		$data['offer_collection'] 		= $location_info['offer_collection'];
		$data['delivery_time'] 			= $location_info['delivery_time'];
		$data['collection_time'] 		= $location_info['collection_time'];
		$data['reservation_interval'] 	= $location_info['reservation_interval'];
		$data['reservation_turn'] 		= $location_info['reservation_turn'];

		$data['permalink'] = $this->permalink->getPermalink('location_id='.$location_info['location_id']);
        $data['permalink']['url'] = root_url('local').'/';

        if ($location_info['location_country_id']) {
			$data['country_id'] = $location_info['location_country_id'];
		} else if ($this->config->item('country_id')) {
			$data['country_id'] = $this->config->item('country_id');
		}

		$weekdays_abbr = array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');
		$weekdays = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
		$data['weekdays_abbr'] = $weekdays_abbr;
		$data['weekdays'] = $weekdays;

		$options = array();
		if (!empty($location_info['options'])) {
			$options = unserialize($location_info['options']);
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
		} else {
			$data['daily_days'] = array('0', '1', '2', '3', '4', '5', '6');
		}

		if ($this->input->post('daily_hours')) {
			$data['daily_hours'] = $this->input->post('daily_hours');
		} else if (isset($options['opening_hours']['daily_days']) AND is_array($options['opening_hours']['daily_days'])) {
			$daily_hours = $options['opening_hours']['daily_hours'];
			$data['daily_hours']['open'] 	= (empty($daily_hours['open']) OR $daily_hours['open'] === '00:00:00') ? '12:00 AM' : mdate('%h:%i %a', strtotime($daily_hours['open']));
			$data['daily_hours']['close'] 	= (empty($daily_hours['close']) OR $daily_hours['close'] === '00:00:00') ? '11:59 PM' : mdate('%h:%i %a', strtotime($daily_hours['close']));
			//$data['daily_hours']['status'] 	= $daily_hours['status'];
		} else {
			$data['daily_hours'] = array('open' => '12:00 AM', 'close' => '11:59 PM');//, 'status' => '0');
		}

		if ($this->input->post('flexible_hours')) {
			$data['flexible_hours'] = $this->input->post('flexible_hours');
		} else if (isset($options['opening_hours']['flexible_hours']) AND is_array($options['opening_hours']['flexible_hours'])) {
			$data['flexible_hours'] = array();
			foreach ($options['opening_hours']['flexible_hours'] as $flexible_hour) {
				$data['flexible_hours'][] = array(
					'day'		=> $flexible_hour['day'],
					'open'		=> (empty($flexible_hour['open']) OR $flexible_hour['open'] === '00:00:00') ? '12:00 AM' : mdate('%h:%i %a', strtotime($flexible_hour['open'])),
					'close'		=> (empty($flexible_hour['close']) OR $flexible_hour['close'] === '00:00:00') ? '11:59 PM' : mdate('%h:%i %a', strtotime($flexible_hour['close'])),
					'status'	=> $flexible_hour['status']
				);
			}
		} else {
			$data['flexible_hours'] = array(
				array('day' => '0', 'open' => '12:00 AM', 'close' => '11:59 PM', 'status' => '0'),
				array('day' => '1', 'open' => '12:00 AM', 'close' => '11:59 PM', 'status' => '0'),
				array('day' => '2', 'open' => '12:00 AM', 'close' => '11:59 PM', 'status' => '0'),
				array('day' => '3', 'open' => '12:00 AM', 'close' => '11:59 PM', 'status' => '0'),
				array('day' => '4', 'open' => '12:00 AM', 'close' => '11:59 PM', 'status' => '0'),
				array('day' => '5', 'open' => '12:00 AM', 'close' => '11:59 PM', 'status' => '0'),
				array('day' => '6', 'open' => '12:00 AM', 'close' => '11:59 PM', 'status' => '0')
			);
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

		if ($this->input->post('delivery_areas')) {
			$delivery_areas = $this->input->post('delivery_areas');
		} else if (isset($options['delivery_areas']) AND is_array($options['delivery_areas'])) {
			$delivery_areas = $options['delivery_areas'];
		} else {
			$delivery_areas = array();
		}

		$data['delivery_areas'] = array();
		foreach ($delivery_areas as $key => $area) {
			$data['delivery_areas'][] = array(
				'shape'			=> (isset($area['shape'])) ? htmlspecialchars($area['shape']) : '',
				'circle'		=> (isset($area['circle'])) ? htmlspecialchars($area['circle']) : '',
				'vertices'		=> (isset($area['vertices'])) ? htmlspecialchars($area['vertices']) : '',
				'name'			=> (isset($area['name'])) ? $area['name'] : '',
				'type'			=> (isset($area['type'])) ? $area['type'] : 'shape',
				'color'			=> (isset($area_colors[$key-1])) ? $area_colors[$key-1] : '#F16745',
				'charge'		=> (isset($area['charge'])) ? str_replace('.00', '', $area['charge']) : '',
				'min_amount'	=> (isset($area['min_amount'])) ? str_replace('.00', '', $area['min_amount']) : ''
			);
		}

		if ($this->config->item('maps_api_key')) {
			$data['map_key'] = '&key='. $this->config->item('maps_api_key');
		} else {
			$data['map_key'] = '';
		}

		if ($location_info['location_lat'] AND $location_info['location_lng']) {
			$data['has_lat_lng'] = TRUE;
		} else {
			$data['has_lat_lng'] = FALSE;
		}

		$data['tables'] = array();
		$tables = $this->Tables_model->getTables();
		if ($tables) {
			foreach ($tables as $table) {
			$data['tables'][] = array(
				'table_id'			=> $table['table_id'],
				'table_name'		=> $table['table_name'],
				'min_capacity'		=> $table['min_capacity'],
				'max_capacity'		=> $table['max_capacity']
			);
			}
		}

		$data['countries'] = array();
		$results = $this->Countries_model->getCountries();
		foreach ($results as $result) {
			$data['countries'][] = array(
				'country_id'	=>	$result['country_id'],
				'name'			=>	$result['country_name'],
			);
		}

		$data['payment_list'] = array();
		$payments = $this->Extensions_model->getPayments();
		foreach ($payments as $payment) {
			if (!empty($payment['ext_data'])) {
				if ($payment['ext_data']['status'] === '1') {
					$data['payment_list'][] = array(
						'name'		=> $payment['title'],
						'code'		=> $payment['name'],
						'priority'	=> $payment['ext_data']['priority'],
						'status'	=> $payment['ext_data']['status']
					);
				}
			}
		}

		if ($this->input->post() AND $this->_addLocation() === TRUE) {
			if ($this->input->post('save_close') !== '1' AND is_numeric($this->input->post('insert_id'))) {
				redirect('locations/edit?id='. $this->input->post('insert_id'));
			} else {
				redirect('locations');
			}
		}

		if ($this->input->post() AND $this->_updateLocation() === TRUE) {
			if ($this->input->post('save_close') === '1') {
				redirect('locations');
			}

			redirect('locations/edit?id='. $location_id);
		}

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('locations_edit', $data);
	}

	public function _addLocation() {
    	if ( ! is_numeric($this->input->get('id')) AND $this->validateForm() === TRUE) {
			$add = array();

			$add['location_name'] 		= $this->input->post('location_name');
			$add['address'] 			= $this->input->post('address');
			$add['email'] 				= $this->input->post('email');
			$add['telephone'] 			= $this->input->post('telephone');
			$add['description'] 		= $this->input->post('description');
			$add['offer_delivery'] 		= $this->input->post('offer_delivery');
			$add['offer_collection'] 	= $this->input->post('offer_collection');
			$add['delivery_time'] 		= $this->input->post('delivery_time');
			$add['collection_time'] 	= $this->input->post('collection_time');
			$add['last_order_time'] 	= $this->input->post('last_order_time');
			$add['tables'] 				= $this->input->post('tables');
			$add['reservation_interval'] = $this->input->post('reservation_interval');
			$add['reservation_turn'] 	= $this->input->post('reservation_turn');
			$add['location_status'] 	= $this->input->post('location_status');
			$add['permalink'] 			= $this->input->post('permalink');

			$add['options'] = array(
				'opening_hours' 		=> array(
											'opening_type'		=> $this->input->post('opening_type'),
											'daily_days'		=> $this->input->post('daily_days'),
											'daily_hours'		=> $this->input->post('daily_hours'),
											'flexible_hours'	=> $this->input->post('flexible_hours')
										),
				'payments'				=> $this->input->post('payments'),
				'delivery_areas'		=> $this->input->post('delivery_areas')
			);

			if ($_POST['insert_id'] = $this->Locations_model->addLocation($add)) {
				$this->alert->set('success', 'Location added successfully.');
			} else {
				$this->alert->set('warning', 'An error occurred, nothing added.');
			}

			return TRUE;
		}
	}

	public function _updateLocation() {
    	if (is_numeric($this->input->get('id')) AND $this->validateForm() === TRUE) {
			$update = array();

			$update['location_id'] 			= $this->input->get('id');
			$update['location_name'] 		= $this->input->post('location_name');
			$update['address'] 				= $this->input->post('address');
			$update['email'] 				= $this->input->post('email');
			$update['telephone'] 			= $this->input->post('telephone');
			$update['description'] 			= $this->input->post('description');
			$update['offer_delivery'] 		= $this->input->post('offer_delivery');
			$update['offer_collection'] 	= $this->input->post('offer_collection');
			$update['delivery_time'] 		= $this->input->post('delivery_time');
			$update['collection_time'] 		= $this->input->post('collection_time');
			$update['last_order_time'] 		= $this->input->post('last_order_time');
			$update['tables'] 				= $this->input->post('tables');
			$update['reservation_interval'] = $this->input->post('reservation_interval');
			$update['reservation_turn'] 	= $this->input->post('reservation_turn');
			$update['location_status'] 		= $this->input->post('location_status');
			$update['permalink'] 			= $this->input->post('permalink');

			$update['options'] = array(
				'opening_hours' 		=> array(
											'opening_type'		=> $this->input->post('opening_type'),
											'daily_days'		=> $this->input->post('daily_days'),
											'daily_hours'		=> $this->input->post('daily_hours'),
											'flexible_hours'	=> $this->input->post('flexible_hours')
										),
				'payments'				=> $this->input->post('payments'),
				'delivery_areas'		=> $this->input->post('delivery_areas')
			);

			if ($this->Locations_model->updateLocation($update)) {
				$this->alert->set('success', 'Location updated successfully.');

				if ($update['location_id'] === $this->config->item('default_location_id')) {
					$this->Settings_model->addSetting('config', 'main_address', $this->Locations_model->getAddress($update['location_id']), '1');
				}
			} else {
				$this->alert->set('warning', 'An error occurred, nothing updated.');
			}

			return TRUE;
		}
	}

	public function validateForm() {
		$this->form_validation->set_rules('location_name', 'Name', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('address[address_1]', 'Address 1', 'xss_clean|trim|required|min_length[2]|max_length[128]');
		$this->form_validation->set_rules('address[address_2]', 'Address 2', 'xss_clean|trim|max_length[128]');
		$this->form_validation->set_rules('address[city]', 'City', 'xss_clean|trim|required|min_length[2]|max_length[128]');
		$this->form_validation->set_rules('address[postcode]', 'Postcode', 'xss_clean|trim|required|min_length[2]|max_length[10]|callback_get_lat_lag');
		$this->form_validation->set_rules('address[country]', 'Country', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('email', 'Email', 'xss_clean|trim|required|valid_email');
		$this->form_validation->set_rules('telephone', 'Telephone', 'xss_clean|trim|required|min_length[2]|max_length[15]');
		$this->form_validation->set_rules('description', 'Description', 'xss_clean|trim|min_length[2]|max_length[3028]');
		$this->form_validation->set_rules('offer_delivery', 'Offer Delivery', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('offer_collection', 'Offer Collection', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('ready_time', 'Ready Time', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('last_order_time', 'Last Order Time', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('payments[]', 'Payments', 'xss_clean|trim');
		$this->form_validation->set_rules('tables[]', 'Tables', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('reservation_interval', 'Time Interval', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('reservation_turn', 'Turn Time', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('location_status', 'Status', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('permalink[permalink_id]', 'Permalink ID', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('permalink[slug]', 'Permalink Slug', 'xss_clean|trim|alpha_dash|max_length[255]');

		$this->form_validation->set_rules('opening_type', 'Type', 'xss_clean|trim|required|alpha_dash|max_length[10]');
		if ($this->input->post('opening_type') === 'daily' AND $this->input->post('daily_days')) {
			$this->form_validation->set_rules('daily_days[]', 'Days', 'xss_clean|trim|required|integer');
			$this->form_validation->set_rules('daily_hours[open]', 'Open hour', 'xss_clean|trim|required|valid_time|callback_less_time['.$_POST['daily_hours']['close'].']');
			$this->form_validation->set_rules('daily_hours[close]', 'Close hour', 'xss_clean|trim|required|valid_time');
			//$this->form_validation->set_rules('daily_hours[status]', 'Status', 'xss_clean|trim|required|integer');
		}

		if ($this->input->post('opening_type') === 'flexible' AND $this->input->post('flexible_hours')) {
			foreach ($this->input->post('flexible_hours') as $key => $value) {
				$this->form_validation->set_rules('flexible_hours['.$key.'][day]', 'Day', 'xss_clean|trim|required|numeric');
				$this->form_validation->set_rules('flexible_hours['.$key.'][open]', 'Open hour', 'xss_clean|trim|required|valid_time|callback_less_time['.$_POST['flexible_hours'][$key]['close'].']');
				$this->form_validation->set_rules('flexible_hours['.$key.'][close]', 'Close hour', 'xss_clean|trim|required|valid_time');
				$this->form_validation->set_rules('flexible_hours['.$key.'][status]', 'Status', 'xss_clean|trim|required|integer');
			}
		}

		if ($this->input->post('delivery_areas')) {
			foreach ($this->input->post('delivery_areas') as $key => $value) {
				$this->form_validation->set_rules('delivery_areas['.$key.'][shape]', 'Area '.$key.' Shape', 'trim|required');
				$this->form_validation->set_rules('delivery_areas['.$key.'][circle]', 'Area '.$key.' Circle', 'trim|required');
				$this->form_validation->set_rules('delivery_areas['.$key.'][vertices]', 'Area '.$key.' Vertices', 'trim|required');
				$this->form_validation->set_rules('delivery_areas['.$key.'][type]', 'Area '.$key.' Type', 'xss_clean|trim|required');
				$this->form_validation->set_rules('delivery_areas['.$key.'][name]', 'Area '.$key.' Name', 'xss_clean|trim|required');
				$this->form_validation->set_rules('delivery_areas['.$key.'][charge]', 'Area '.$key.' Charge', 'xss_clean|trim|required|numeric');
				$this->form_validation->set_rules('delivery_areas['.$key.'][min_amount]', 'Area '.$key.' Min amount', 'xss_clean|trim|required|numeric');
			}
		}

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function _deleteLocation() {
    	if (is_array($this->input->post('delete'))) {
			foreach ($this->input->post('delete') as $key => $value) {
				$this->Locations_model->deleteLocation($value);
			}

			$this->alert->set('success', 'Location deleted successfully!');
		}

		return TRUE;
	}

	public function get_lat_lag() {
		if (isset($_POST['address']) AND is_array($_POST['address']) AND !empty($_POST['address']['postcode'])) {
			$address_string =  implode(", ", $_POST['address']);
			$address = urlencode($address_string);
			$geocode = @file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='. $address .'&sensor=false&region=GB');
    		$output = json_decode($geocode);
    		$status = $output->status;

    		if ($status === 'OK') {
				$_POST['address']['location_lat'] = $output->results[0]->geometry->location->lat;
				$_POST['address']['location_lng'] = $output->results[0]->geometry->location->lng;
			    return TRUE;
    		} else {
        		$this->form_validation->set_message('get_lat_lag', 'The Address you entered failed Geocoding, please enter a different address!');
        		return FALSE;
    		}
        }
	}

	public function less_time($open, $close) {
		$unix_open = strtotime($open);
		$unix_close = strtotime($close);

		if ($unix_open >= $unix_close) {
			$this->form_validation->set_message('less_time', 'The %s must be less than Close hour.');
			return FALSE;
		}

		return TRUE;
	}
}

/* End of file locations.php */
/* Location: ./admin/controllers/locations.php */