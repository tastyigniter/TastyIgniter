<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Settings extends Admin_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		$this->load->model('Locations_model');
		$this->load->model('Settings_model');
		$this->load->model('Countries_model');
		$this->load->model('Currencies_model');
		$this->load->model('Statuses_model');
		$this->load->model('Categories_model');
	}

	public function index() {
		$this->template->setTitle('Settings');
		$this->template->setHeading('Settings');
		$this->template->setButton('Save', array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));

        $this->template->setStyleTag(root_url('assets/js/fancybox/jquery.fancybox.css'), 'jquery-fancybox-css');
        $this->template->setScriptTag(root_url("assets/js/fancybox/jquery.fancybox.js"), 'jquery-fancybox-js');

        $post_data = $this->input->post();
		$config_items = $this->config->config;

        $data['current_time'] = mdate('%d-%m-%Y %H:%i:%s', time());

        foreach ($config_items as $key => $value) {
            if (isset($post_data[$key])) {
                $data[$key] = $post_data[$key];
            } else {
                $data[$key] = $value;
            }
        }

        $this->load->model('Image_tool_model');
        $data['no_photo'] = $this->Image_tool_model->resize('data/no_photo.png');
        if ($data['site_logo']) {
            $data['logo_val'] = $data['site_logo'];
            $data['site_logo'] = $this->Image_tool_model->resize($data['logo_val']);
            $data['logo_name'] = basename($data['logo_val']);
        } else {
            $data['logo_val'] = 'data/no_photo.png';
            $data['site_logo'] = $this->Image_tool_model->resize('data/no_photo.png');
            $data['logo_name'] = 'no_photo.png';
        }

        if (is_array($data['main_address'])) {
            $main_address = $data['main_address'];
        } else {
            $main_address = array();
        }

        $data['main_address'] = array(
            'location_id' 	=> (isset($main_address['location_id'])) ? $main_address['location_id'] : '',
            'address_1' 	=> (isset($main_address['address_1'])) ? $main_address['address_1'] : '',
            'address_2' 	=> (isset($main_address['address_2'])) ? $main_address['address_2'] : '',
            'city' 			=> (isset($main_address['city'])) ? $main_address['city'] : '',
            'postcode' 		=> (isset($main_address['postcode'])) ? $main_address['postcode'] : '',
            'country_id' 	=> (isset($main_address['country_id'])) ? $main_address['country_id'] : ''
        );

        if (is_array($data['image_manager'])) {
            $image_manager = $data['image_manager'];
        } else {
            $image_manager = array();
        }

        $data['image_manager'] = array(
//            'root_folder' 			=> (isset($image_manager['root_folder'])) ? $image_manager['root_folder'] : '',
            'max_size' 				=> (isset($image_manager['max_size'])) ? $image_manager['max_size'] : '',
            'thumb_height' 			=> (isset($image_manager['thumb_height'])) ? $image_manager['thumb_height'] : '',
            'thumb_width' 			=> (isset($image_manager['thumb_width'])) ? $image_manager['thumb_width'] : '',
            'uploads' 				=> (isset($image_manager['uploads'])) ? $image_manager['uploads'] : '',
            'new_folder' 			=> (isset($image_manager['new_folder'])) ? $image_manager['new_folder'] : '',
            'copy' 					=> (isset($image_manager['copy'])) ? $image_manager['copy'] : '',
            'move' 					=> (isset($image_manager['move'])) ? $image_manager['move'] : '',
            'rename' 				=> (isset($image_manager['rename'])) ? $image_manager['rename'] : '',
            'delete' 				=> (isset($image_manager['delete'])) ? $image_manager['delete'] : '',
//            'allowed_ext' 			=> (isset($image_manager['allowed_ext'])) ? $image_manager['allowed_ext'] : '',
//            'hidden_files' 			=> (isset($image_manager['hidden_files'])) ? $image_manager['hidden_files'] : '',
//            'hidden_folders' 		=> (isset($image_manager['hidden_folders'])) ? $image_manager['hidden_folders'] : '',
            'transliteration' 		=> (isset($image_manager['transliteration'])) ? $image_manager['transliteration'] : '',
            'remember_days' 		=> (isset($image_manager['remember_days'])) ? $image_manager['remember_days'] : '',
            'delete_thumbs'			=> site_url('settings/delete_thumbs'),
        );

        if (empty($data['activity_online_time_out'])) {
            $data['activity_online_time_out'] = '120';
        }

        if (empty($data['cache_time'])) {
            $data['cache_time'] = '0';
        }

        $data['page_limits'] = array('10', '20', '50', '75', '100');

        $data['search_by_array'] = array('postcode' => 'Postcode Only', 'address' => 'Postcode & Address');

        $data['protocols'] 	= array('mail', 'sendmail', 'smtp');
        $data['mailtypes'] 	= array('text', 'html');
        $data['thresholds'] = array('Disable', 'Error Only', 'Debug Only', 'Info Only', 'All');

		$timezones = $this->getTimezones();
		foreach ($timezones as $key => $value) {
			$data['timezones'][$key] = $value;
		}

		$data['countries'] = array();
		$results = $this->Countries_model->getCountries();
		foreach ($results as $result) {
			$data['countries'][] = array(
				'country_id'	=>	$result['country_id'],
				'name'			=>	$result['country_name'],
			);
		}

		$data['currencies'] = array();
		$currencies = $this->Currencies_model->getCurrencies();
		foreach ($currencies as $currency) {
			$data['currencies'][] = array(
				'currency_id'		=>	$currency['currency_id'],
				'currency_name'		=>	$currency['currency_name'],
				'currency_status'	=>	$currency['currency_status']
			);
		}

		$this->load->model('Languages_model');
		$data['languages'] = array();
		$results = $this->Languages_model->getLanguages();
		foreach ($results as $result) {
			$data['languages'][] = array(
				'language_id'	=>	$result['language_id'],
				'name'			=>	$result['name'],
			);
		}

		$this->load->model('Customer_groups_model');
		$data['customer_groups'] = array();
		$results = $this->Customer_groups_model->getCustomerGroups();
		foreach ($results as $result) {
			$data['customer_groups'][] = array(
				'customer_group_id'	=>	$result['customer_group_id'],
				'group_name'		=>	$result['group_name']
			);
		}

		$data['categories'] = array();
		$categories = $this->Categories_model->getCategories();
		foreach ($categories as $category) {
			$data['categories'][] = array(
				'category_id'	=>	$category['category_id'],
				'category_name'	=>	$category['name']
			);
		}

        $data['statuses'] = array();
		$results = $this->Statuses_model->getStatuses();
		foreach ($results as $result) {
			$data['statuses'][] = array(
				'status_id'		=> $result['status_id'],
				'status_name'	=> $result['status_name'],
				'status_for'	=> $result['status_for']
			);
		}

		$this->load->model('Pages_model');
		$data['pages'] = array();
		$results = $this->Pages_model->getPages();
		foreach ($results as $result) {
			$data['pages'][] = array(
				'page_id'		=>	$result['page_id'],
				'name'			=>	$result['name'],
			);
		}

		if ($this->input->post() AND $this->_updateSettings() === TRUE) {
			redirect('settings');
		}

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('settings', $data);
	}

	public function delete_thumbs() {
        if (file_exists(IMAGEPATH . 'thumbs')) {
            $this->_delete_thumbs(IMAGEPATH . 'thumbs/*');
            $this->alert->set('success', 'Thumbs deleted successfully!');
        }

		redirect('settings');
	}

	public function _updateSettings() {
    	if ($this->validateForm() === TRUE) {
			$update = array(
                'site_name' 				=> $this->input->post('site_name'),
				'site_email' 				=> $this->input->post('site_email'),
				'site_logo' 				=> $this->input->post('site_logo'),
				'country_id' 				=> $this->input->post('country_id'),
				'timezone' 					=> $this->input->post('timezone'),
				'currency_id' 				=> $this->input->post('currency_id'),
				'language_id' 				=> $this->input->post('language_id'),
				'customer_group_id' 		=> $this->input->post('customer_group_id'),
				'page_limit' 				=> $this->input->post('page_limit'),
				'meta_description' 			=> $this->input->post('meta_description'),
				'meta_keywords' 			=> $this->input->post('meta_keywords'),
				'menus_page_limit' 			=> $this->input->post('menus_page_limit'),
				'show_menu_images' 			=> $this->input->post('show_menu_images'),
				'menu_images_h' 			=> $this->input->post('menu_images_h'),
				'menu_images_w' 			=> $this->input->post('menu_images_w'),
				'special_category_id' 		=> $this->input->post('special_category_id'),
				'registration_terms' 		=> $this->input->post('registration_terms'),
				'checkout_terms' 			=> $this->input->post('checkout_terms'),
				'registration_email'		=> $this->input->post('registration_email'),
				'customer_order_email'		=> $this->input->post('customer_order_email'),
				'customer_reserve_email'	=> $this->input->post('customer_reserve_email'),
				'main_address'				=> $this->input->post('main_address'),
				'maps_api_key'				=> $this->input->post('maps_api_key'),
				'search_by'					=> $this->input->post('search_by'),
				'distance_unit'				=> $this->input->post('distance_unit'),
				'future_orders' 			=> $this->input->post('future_orders'),
				'location_order'			=> $this->input->post('location_order'),
				'location_order_email'		=> $this->input->post('location_order_email'),
				'location_reserve_email'	=> $this->input->post('location_reserve_email'),
				'approve_reviews'			=> $this->input->post('approve_reviews'),
				'order_status_new'			=> $this->input->post('order_status_new'),
				'order_status_complete'		=> $this->input->post('order_status_complete'),
				'order_status_cancel'		=> $this->input->post('order_status_cancel'),
				'guest_order'				=> $this->input->post('guest_order'),
				'delivery_time'				=> $this->input->post('delivery_time'),
				'collection_time'			=> $this->input->post('collection_time'),
				'reservation_mode'			=> $this->input->post('reservation_mode'),
				'reservation_status'		=> $this->input->post('reservation_status'),
				'reservation_interval'		=> $this->input->post('reservation_interval'),
				'reservation_turn'			=> $this->input->post('reservation_turn'),
				'themes_allowed_img'		=> $this->input->post('themes_allowed_img'),
				'themes_allowed_file'		=> $this->input->post('themes_allowed_file'),
				'themes_hidden_files'		=> $this->input->post('themes_hidden_files'),
				'themes_hidden_folders'		=> $this->input->post('themes_hidden_folders'),
				'image_manager'				=> $this->input->post('image_manager'),
				'protocol'	 				=> strtolower($this->input->post('protocol')),
				'mailtype' 					=> strtolower($this->input->post('mailtype')),
				'smtp_host' 				=> $this->input->post('smtp_host'),
				'smtp_port' 				=> $this->input->post('smtp_port'),
				'smtp_user' 				=> $this->input->post('smtp_user'),
				'smtp_pass' 				=> $this->input->post('smtp_pass'),
				'activity_online_time_out' 	=> $this->input->post('activity_online_time_out'),
				'activity_archive_time_out' => $this->input->post('activity_archive_time_out'),
				'permalink' 				=> $this->input->post('permalink'),
				'maintenance_mode' 			=> $this->input->post('maintenance_mode'),
				'maintenance_message' 		=> $this->input->post('maintenance_message'),
				'cache_mode' 				=> $this->input->post('cache_mode'),
				'cache_time' 				=> $this->input->post('cache_time')
			);


			if (!empty($update['main_address']) AND is_array($update['main_address'])) {
				$this->load->model('Locations_model');
				$this->Locations_model->updateDefault($update['main_address']);
			}

			if ($this->Settings_model->updateSettings('config', $update)) {
				$this->alert->set('success', 'Settings updated successfully.');
			} else {
				$this->alert->set('warning', 'An error occurred, nothing updated.');
			}

			return TRUE;
		}
	}

	public function validateForm() {
		$this->form_validation->set_rules('site_name', 'Restaurant Name', 'xss_clean|trim|required|min_length[2]|max_length[128]');
		$this->form_validation->set_rules('site_email', 'Restaurant Email', 'xss_clean|trim|required|valid_email');
		$this->form_validation->set_rules('site_logo', 'Site Logo', 'xss_clean|trim|required');
		$this->form_validation->set_rules('country_id', 'Restaurant Country', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('timezone', 'Timezones', 'xss_clean|trim|required');
		$this->form_validation->set_rules('currency_id', 'Restaurant Currency', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('language_id', 'Default Language', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('customer_group_id', 'Customer Group', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('page_limit', 'Items Per Page', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('meta_description', 'Meta Description', 'xss_clean|trim');
		$this->form_validation->set_rules('meta_keywords', 'Meta Keywords', 'xss_clean|trim');
		$this->form_validation->set_rules('menus_page_limit', 'Menus Per Page', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('show_menu_images', 'Show Menu Images', 'xss_clean|trim|required|integer');

		if ($this->input->post('show_menu_images') == '1') {
			$this->form_validation->set_rules('menu_images_h', 'Menu Images Height', 'xss_clean|trim|required|numeric');
			$this->form_validation->set_rules('menu_images_w', 'Menu Images Width', 'xss_clean|trim|required|numeric');
		}

		$this->form_validation->set_rules('special_category_id', 'Specials Category', 'xss_clean|trim|numeric');
		$this->form_validation->set_rules('registration_terms', 'Registration Terms', 'xss_clean|trim|required|numeric');
		$this->form_validation->set_rules('checkout_terms', 'Checkout Terms', 'xss_clean|trim|required|numeric');
		$this->form_validation->set_rules('registration_email', 'Registration Email', 'xss_clean|trim|required|numeric');
		$this->form_validation->set_rules('customer_order_email', 'Customer Order Email', 'xss_clean|trim|required|numeric');
		$this->form_validation->set_rules('customer_reserve_email', 'Customer Reservation Email', 'xss_clean|trim|required|numeric');

		$this->form_validation->set_rules('main_address[address_1]', 'Address 1', 'xss_clean|trim|required|min_length[2]|max_length[128]');
		$this->form_validation->set_rules('main_address[address_2]', 'Address 2', 'xss_clean|trim|max_length[128]');
		$this->form_validation->set_rules('main_address[city]', 'City', 'xss_clean|trim|required|min_length[2]|max_length[128]');
		$this->form_validation->set_rules('main_address[postcode]', 'Postcode', 'xss_clean|trim|required|min_length[2]|max_length[10]|callback_get_lat_lag');
		$this->form_validation->set_rules('main_address[country_id]', 'Country', 'xss_clean|trim|required|integer');

		$this->form_validation->set_rules('maps_api_key', 'Google Maps API Key', 'xss_clean|trim');
		$this->form_validation->set_rules('search_by', 'Search By', 'xss_clean|trim|required|alpha');
		$this->form_validation->set_rules('distance_unit', 'Distance Unit', 'xss_clean|trim|required');
		$this->form_validation->set_rules('future_orders', 'Future Orders', 'xss_clean|trim|required|numeric');
		$this->form_validation->set_rules('location_order', 'Allow Order', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('location_order_email', 'Send Order Email', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('location_reserve_email', 'Send Reservation Email', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('approve_reviews', 'Approve Reviews', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('order_status_new', 'New Order Status', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('order_status_complete', 'Complete Order Status', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('order_status_cancel', 'Cancellation Order Status', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('guest_order', 'Guest Order', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('delivery_time', 'Delivery Time', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('collection_time', 'Collection Time', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('reservation_mode', 'Reservation Mode', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('reservation_status', 'Reservation Status', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('reservation_interval', 'Reservation Interval', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('reservation_turn', 'Reservations Turn', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('themes_allowed_img', 'Themes Allowed Images', 'xss_clean|trim');
		$this->form_validation->set_rules('themes_allowed_file', 'Themes Allowed Files', 'xss_clean|trim');
		$this->form_validation->set_rules('themes_hidden_files', 'Themes Hidden Files', 'xss_clean|trim');
		$this->form_validation->set_rules('themes_hidden_folders', 'Themes Hidden Folders', 'xss_clean|trim');
//		$this->form_validation->set_rules('image_manager[root_folder]', 'Root Folder', 'xss_clean|trim|required|callback_validate_path');
		$this->form_validation->set_rules('image_manager[max_size]', 'Maximum File Size', 'xss_clean|trim|required|numeric');
		$this->form_validation->set_rules('image_manager[thumb_height]', 'Thumbnail Height', 'xss_clean|trim|required|numeric');
		$this->form_validation->set_rules('image_manager[thumb_width]', 'Thumbnail Width', 'xss_clean|trim|required|numeric');
		$this->form_validation->set_rules('image_manager[uploads]', 'Uploads', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('image_manager[new_folder]', 'New Folder', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('image_manager[copy]', 'Copy', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('image_manager[move]', 'Move', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('image_manager[rename]', 'Rename', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('image_manager[delete]', 'Delete', 'xss_clean|trim|integer');
//		$this->form_validation->set_rules('image_manager[allowed_ext]', 'Allowed Extension', 'xss_clean|trim|required');
//		$this->form_validation->set_rules('image_manager[hidden_files]', 'Hidden Files', 'xss_clean|trim');
//		$this->form_validation->set_rules('image_manager[hidden_folders]', 'Hidden Folders', 'xss_clean|trim');
		$this->form_validation->set_rules('image_manager[transliteration]', 'Transliteration', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('image_manager[remember_days]', 'Remember Last Folder', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('protocol', 'Mail Protocol', 'xss_clean|trim|required');
		$this->form_validation->set_rules('mailtype', 'Mail Type Format', 'xss_clean|trim|required');
		$this->form_validation->set_rules('smtp_host', 'SMTP Host', 'xss_clean|trim');
		$this->form_validation->set_rules('smtp_port', 'SMTP Port', 'xss_clean|trim');
		$this->form_validation->set_rules('smtp_user', 'SMTP Username', 'xss_clean|trim');
		$this->form_validation->set_rules('smtp_pass', 'SMTP Password', 'xss_clean|trim');
		$this->form_validation->set_rules('activity_online_time_out', 'Activity Online Timeout', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('activity_archive_time_out', 'Activity Archive Timeout', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('permalink', 'Permalink', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('maintenance_mode', 'Maintenance Mode', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('maintenance_message', 'Maintenance Message', 'xss_clean|trim');
		$this->form_validation->set_rules('cache_mode', 'Cache Mode', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('cache_time', 'Cache Time', 'xss_clean|trim|integer');

		if ($this->form_validation->run() == TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}

	}

	public function getTimezones() {
		$timezone_identifiers = DateTimeZone::listIdentifiers();
		$utc_time = new DateTime('now', new DateTimeZone('UTC'));

		$temp_timezones = array();
		foreach ($timezone_identifiers as $timezone_identifier) {
			$current_timezone = new DateTimeZone($timezone_identifier);

			$temp_timezones[] = array(
				'offset' => (int)$current_timezone->getOffset($utc_time),
				'identifier' => $timezone_identifier
			);
		}

		usort($temp_timezones, function($a, $b) {
			return ($a['offset'] == $b['offset']) ? strcmp($a['identifier'], $b['identifier']) : $a['offset'] - $b['offset'];
		});

		$timezoneList = array();
		foreach ($temp_timezones as $tz) {
			$sign = ($tz['offset'] > 0) ? '+' : '-';
			$offset = gmdate('H:i', abs($tz['offset']));
			$timezone_list[$tz['identifier']] = $tz['identifier'] .' (UTC ' . $sign . $offset .')';
		}

		return $timezone_list;
	}

	public function get_lat_lag() {
		if (isset($_POST['main_address']) AND is_array($_POST['main_address']) AND !empty($_POST['main_address']['postcode'])) {
			$address_string =  implode(", ", $_POST['main_address']);
			$address = urlencode($address_string);
			$geocode = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='. $address .'&sensor=false&region=GB');
    		$output = json_decode($geocode);
    		$status = $output->status;

    		if ($status === 'OK') {
				$_POST['main_address']['location_lat'] = $output->results[0]->geometry->location->lat;
				$_POST['main_address']['location_lng'] = $output->results[0]->geometry->location->lng;
			    return TRUE;
    		} else {
        		$this->form_validation->set_message('get_lat_lag', 'The Address you entered failed Geocoding, please enter a different address!');
        		return FALSE;
    		}
        }
	}

	public function validate_path($str) {
		if (strpos($str, '/') !== FALSE OR strpos($str, './') !== FALSE) {
			$this->form_validation->set_message('validate_path', 'Root Folder must have NO SLASH!');
			return FALSE;
		}

		return TRUE;
	}

	public function _delete_thumbs($thumb_path) {
		foreach (glob($thumb_path) as $path) {

			if (file_exists($path) AND is_file($path) AND basename($path) === "index.html") {
				continue;
			}

			if (file_exists($path) AND is_file($path)) {
				unlink($path);
				continue;
			}

			foreach (scandir($path) as $item) {
				if ($item != '.' AND $item != '..') {
					if ( ! is_dir($path .'/'. $item)) {
						unlink($path .'/'. $item);
					} else {
						$this->_delete_thumbs($path .'/'. $item);
					}
				}
			}

			if (is_dir($path)) {
				rmdir($path);
				continue;
			}
		}
	}
}

/* End of file settings.php */
/* Location: ./admin/controllers/settings.php */