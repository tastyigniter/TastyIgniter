<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Settings extends Admin_Controller {

    public function __construct() {
		parent::__construct(); //  calls the constructor

        $this->user->restrict('Site.Settings.Manage');

        $this->load->model('Locations_model');
		$this->load->model('Settings_model');
		$this->load->model('Countries_model');
		$this->load->model('Currencies_model');
		$this->load->model('Statuses_model');
		$this->load->model('Categories_model');

        $this->lang->load('settings');
    }

	public function index() {
        $this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading($this->lang->line('text_heading'));
		$this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));

		if ($this->input->post() AND $this->_updateSettings() === TRUE) {
			redirect('settings');
		}

        $post_data = $this->input->post();
		$config_items = $this->config->config;

        foreach ($config_items as $key => $value) {
            if (isset($post_data[$key])) {
                $data[$key] = $post_data[$key];
            } else {
                $data[$key] = $value;
            }
        }

        $this->load->model('Image_tool_model');
        $data['no_photo'] = $this->Image_tool_model->resize('data/no_photo.png');
        if ($this->config->item('site_logo')) {
            $data['logo_val'] = $this->config->item('site_logo');
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
            'state' 		=> (isset($main_address['state'])) ? $main_address['state'] : '',
            'postcode' 		=> (isset($main_address['postcode'])) ? $main_address['postcode'] : '',
            'country_id' 	=> (isset($main_address['country_id'])) ? $main_address['country_id'] : '',
            'location_lat' 	=> (isset($main_address['location_lat'])) ? $main_address['location_lat'] : '',
            'location_lng' 	=> (isset($main_address['location_lng'])) ? $main_address['location_lng'] : '',
        );

		if (!isset($data['auto_lat_lng'])) {
			$data['auto_lat_lng'] = '1';
		}

        if (is_array($data['image_manager'])) {
            $image_manager = $data['image_manager'];
        } else {
            $image_manager = array();
        }

        $data['image_manager'] = array(
            'max_size' 				=> (isset($image_manager['max_size'])) ? $image_manager['max_size'] : '',
            'thumb_height' 			=> (isset($image_manager['thumb_height'])) ? $image_manager['thumb_height'] : '',
            'thumb_width' 			=> (isset($image_manager['thumb_width'])) ? $image_manager['thumb_width'] : '',
            'uploads' 				=> (isset($image_manager['uploads'])) ? $image_manager['uploads'] : '',
            'new_folder' 			=> (isset($image_manager['new_folder'])) ? $image_manager['new_folder'] : '',
            'copy' 					=> (isset($image_manager['copy'])) ? $image_manager['copy'] : '',
            'move' 					=> (isset($image_manager['move'])) ? $image_manager['move'] : '',
            'rename' 				=> (isset($image_manager['rename'])) ? $image_manager['rename'] : '',
            'delete' 				=> (isset($image_manager['delete'])) ? $image_manager['delete'] : '',
            'transliteration' 		=> (isset($image_manager['transliteration'])) ? $image_manager['transliteration'] : '',
            'remember_days' 		=> (isset($image_manager['remember_days'])) ? $image_manager['remember_days'] : '',
            'delete_thumbs'			=> site_url('settings/delete_thumbs'),
        );

        if (!isset($data['auto_update_currency_rates'])) {
            $this->config->set_item('auto_update_currency_rates', '0');
        }

        if (!isset($data['accepted_currencies'])) {
            $this->config->set_item('accepted_currencies', array());
        }

        if (!isset($data['show_stock_warning'])) {
            $this->config->set_item('show_stock_warning', '1');
        }

        if (!isset($data['invoice_prefix'])) {
            $this->config->set_item('invoice_prefix', 'INV-{year}-00');
        }

        if (!isset($data['processing_order_status'])) {
            $this->config->set_item('processing_order_status', array('12', '13', '14'));
        }

        if (empty($data['customer_online_time_out'])) {
            $data['customer_online_time_out'] = '120';
        }

        if (empty($data['cache_time'])) {
            $data['cache_time'] = '0';
        }

        $data['page_limits'] = array('10', '20', '50', '75', '100');

        $data['protocols'] 	= array('mail', 'sendmail', 'smtp');
        $data['thresholds'] = array('Disable', 'Error Only', 'Debug Only', 'Info Only', 'All');

		$timezones = $this->getTimezones();
		foreach ($timezones as $key => $value) {
			$data['timezones'][$key] = $value;
		}

		$data['date_formats'] = array(
			'%j%S %F %Y',
			'%d/%m/%Y',
			'%m/%d/%Y',
			'%Y-%m-%d',
		);

		$data['time_formats'] = array(
			'%h:%i %A',
			'%h:%i %a',
			'%H:%i',
		);

		isset($data['date_format']) OR $data['date_format'] = $data['date_formats'][0];
		isset($data['time_format']) OR $data['time_format'] = $data['time_formats'][0];

		$this->load->model('Locations_model');
		$data['locations'] = array();
		$results = $this->Locations_model->getLocations();
		foreach ($results as $result) {
			$data['locations'][] = array(
				'location_id'	=>	$result['location_id'],
				'location_name'	=>	$result['location_name'],
			);
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
				'currency_name'		=>	$currency['country_name'] . ' - ' . $currency['currency_name'],
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
				'idiom'			=>	$result['idiom'],
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

		$this->template->render('settings', $data);
	}

	public function delete_thumbs() {
		$json = array();

		if (empty($json) AND $this->input->post('delete_thumbs') AND file_exists(IMAGEPATH . 'thumbs')) {
            $this->_delete_thumbs(IMAGEPATH . 'thumbs/*');
			$json['success'] = $this->lang->line('alert_success_thumb_deleted');
        } else {
			$json['error'] = $this->lang->line('alert_error_try_again');
		}


		if ($this->input->is_ajax_request()) {
			$this->output->set_output(json_encode($json));											// encode the json array and set final out to be sent to jQuery AJAX
		} else {
			if (isset($json['error'])) $this->alert->set('danger', $json['error']);
			if (isset($json['success'])) $this->alert->set('success', $json['success']);
			redirect('settings/#image-manager');
		}
	}

	public function send_test_email() {
		$json = array();

		if ( ! $this->input->post('send_test_email')) {
			$json['error'] = $this->lang->line('alert_error_try_again');
		}

		if (empty($json)) {
			$this->load->library('email');                                                        //loading upload library
			$this->email->initialize();

			$this->email->from(strtolower($this->config->item('site_email')), $this->config->item('site_name'));
			$this->email->to(strtolower($this->config->item('site_email')));
			$this->email->subject('This a test email');
			$this->email->message('This is a test email. If you\'ve received this, it means emails are working in TastyIgniter.');

			if ($this->email->send()) {
				$json['success'] = sprintf($this->lang->line('alert_email_sent'), $this->config->item('site_email'));
			} else {
				$json['error'] = $this->email->print_debugger(array('headers'));
            }
		}

		if ($this->input->is_ajax_request()) {
			$this->output->set_output(json_encode($json));											// encode the json array and set final out to be sent to jQuery AJAX
		} else {
			if (isset($json['error'])) $this->alert->set('danger', $json['error']);
			if (isset($json['success'])) $this->alert->set('success', $json['success']);
			redirect('settings/#mail');
		}
	}

	private function _updateSettings() {
        if ($this->validateForm() === TRUE) {
	        $update = array(
		        'site_name'                        => $this->input->post('site_name'),
		        'site_email'                       => $this->input->post('site_email'),
		        'site_logo'                        => $this->input->post('site_logo'),
		        'country_id'                       => $this->input->post('country_id'),
		        'timezone'                         => $this->input->post('timezone'),
		        'date_format'                      => $this->input->post('date_format'),
		        'time_format'                      => $this->input->post('time_format'),
		        'currency_id'                      => $this->input->post('currency_id'),
		        'auto_update_currency_rates'       => $this->input->post('auto_update_currency_rates'),
		        'accepted_currencies'              => $this->input->post('accepted_currencies'),
		        'detect_language'                  => $this->input->post('detect_language'),
		        'language_id'                      => $this->input->post('language_id'),
		        'admin_language_id'                => $this->input->post('admin_language_id'),
		        'customer_group_id'                => $this->input->post('customer_group_id'),
		        'page_limit'                       => $this->input->post('page_limit'),
		        'meta_description'                 => $this->input->post('meta_description'),
		        'meta_keywords'                    => $this->input->post('meta_keywords'),
		        'menus_page_limit'                 => $this->input->post('menus_page_limit'),
		        'show_menu_images'                 => $this->input->post('show_menu_images'),
		        'menu_images_h'                    => $this->input->post('menu_images_h'),
		        'menu_images_w'                    => $this->input->post('menu_images_w'),
		        'special_category_id'              => $this->input->post('special_category_id'),
		        'tax_mode'                         => $this->input->post('tax_mode'),
		        'tax_title'                        => $this->input->post('tax_title'),
		        'tax_percentage'                   => $this->input->post('tax_percentage'),
		        'tax_menu_price'                   => $this->input->post('tax_menu_price'),
		        'tax_delivery_charge'              => $this->input->post('tax_delivery_charge'),
		        'stock_checkout'                   => $this->input->post('stock_checkout'),
		        'show_stock_warning'               => $this->input->post('show_stock_warning'),
		        'registration_terms'               => $this->input->post('registration_terms'),
		        'checkout_terms'                   => $this->input->post('checkout_terms'),
		        'auto_lat_lng'                     => $this->input->post('auto_lat_lng'),
		        'maps_api_key'                     => $this->input->post('maps_api_key'),
		        'distance_unit'                    => $this->input->post('distance_unit'),
		        'future_orders'                    => $this->input->post('future_orders'),
		        'location_order'                   => $this->input->post('location_order'),
		        'allow_reviews'                    => $this->input->post('allow_reviews'),
		        'approve_reviews'                  => $this->input->post('approve_reviews'),
		        'default_order_status'             => $this->input->post('default_order_status'),
		        'processing_order_status'          => $this->input->post('processing_order_status'),
		        'completed_order_status'           => $this->input->post('completed_order_status'),
		        'canceled_order_status'            => $this->input->post('canceled_order_status'),
		        'auto_invoicing'                   => $this->input->post('auto_invoicing'),
		        'invoice_prefix'                   => $this->input->post('invoice_prefix'),
		        'guest_order'                      => $this->input->post('guest_order'),
		        'delivery_time'                    => $this->input->post('delivery_time'),
		        'collection_time'                  => $this->input->post('collection_time'),
		        'reservation_mode'                 => $this->input->post('reservation_mode'),
		        'default_reservation_status'       => $this->input->post('default_reservation_status'),
		        'confirmed_reservation_status'     => $this->input->post('confirmed_reservation_status'),
		        'canceled_reservation_status'      => $this->input->post('canceled_reservation_status'),
		        'reservation_time_interval'        => $this->input->post('reservation_time_interval'),
		        'reservation_stay_time'            => $this->input->post('reservation_stay_time'),
		        'themes_allowed_img'               => $this->input->post('themes_allowed_img'),
		        'themes_allowed_file'              => $this->input->post('themes_allowed_file'),
		        'themes_hidden_files'              => $this->input->post('themes_hidden_files'),
		        'themes_hidden_folders'            => $this->input->post('themes_hidden_folders'),
		        'image_manager'                    => $this->input->post('image_manager'),
		        'registration_email'               => $this->input->post('registration_email'),
		        'order_email'                      => $this->input->post('order_email'),
		        'reservation_email'                => $this->input->post('reservation_email'),
		        'protocol'                         => strtolower($this->input->post('protocol')),
		        'smtp_host'                        => $this->input->post('smtp_host'),
		        'smtp_port'                        => $this->input->post('smtp_port'),
		        'smtp_user'                        => $this->input->post('smtp_user'),
		        'smtp_pass'                        => $this->input->post('smtp_pass'),
		        'customer_online_time_out'         => $this->input->post('customer_online_time_out'),
		        'customer_online_archive_time_out' => $this->input->post('customer_online_archive_time_out'),
		        'permalink'                        => $this->input->post('permalink'),
		        'maintenance_mode'                 => $this->input->post('maintenance_mode'),
		        'maintenance_message'              => $this->input->post('maintenance_message'),
		        'cache_mode'                       => $this->input->post('cache_mode'),
		        'cache_time'                       => $this->input->post('cache_time'),
	        );

			if ($this->Settings_model->updateSettings('config', $update, TRUE)) {
				if ($this->input->post('default_location_id') !== $this->config->item('location_id', 'main_address')) {
					$this->load->model('Locations_model');
					$this->Locations_model->updateDefault($this->Locations_model->getAddress($this->input->post('default_location_id')));
				}

				if ($this->input->post('accepted_currencies')) {
					$this->load->model('Currencies_model');
					$this->Currencies_model->updateAcceptedCurrencies($this->input->post('accepted_currencies'));
				}

				$this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Settings updated '));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), 'updated'));
			}

			return TRUE;
		}
	}

	private function validateForm() {
		$this->form_validation->set_rules('site_name', 'lang:label_site_name', 'xss_clean|trim|required|min_length[2]|max_length[128]');
		$this->form_validation->set_rules('site_email', 'lang:label_site_email', 'xss_clean|trim|required|valid_email');
		$this->form_validation->set_rules('site_logo', 'lang:label_site_logo', 'xss_clean|trim|required');
		$this->form_validation->set_rules('timezone', 'lang:label_timezone', 'xss_clean|trim|required');
		$this->form_validation->set_rules('date_format', 'lang:label_date_format', 'xss_clean|trim|required');
		$this->form_validation->set_rules('time_format', 'lang:label_time_format', 'xss_clean|trim|required');
		$this->form_validation->set_rules('currency_id', 'lang:label_site_currency', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('auto_update_currency_rates', 'lang:label_auto_update_rates', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('accepted_currencies[]', 'lang:label_accepted_currency', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('detect_language', 'lang:label_default_language', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('language_id', 'lang:label_site_language', 'xss_clean|trim|required');
		$this->form_validation->set_rules('admin_language_id', 'lang:label_admin_language', 'xss_clean|trim|required');
		$this->form_validation->set_rules('customer_group_id', 'lang:label_customer_group', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('page_limit', 'lang:label_page_limit', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('meta_description', 'lang:label_meta_description', 'xss_clean|trim');
		$this->form_validation->set_rules('meta_keywords', 'lang:label_meta_keyword', 'xss_clean|trim');
		$this->form_validation->set_rules('menus_page_limit', 'lang:label_menu_page_limit', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('show_menu_images', 'lang:label_show_menu_image', 'xss_clean|trim|required|integer');

		if ($this->input->post('show_menu_images') == '1') {
			$this->form_validation->set_rules('menu_images_h', 'lang:label_menu_image_height', 'xss_clean|trim|required|numeric');
			$this->form_validation->set_rules('menu_images_w', 'lang:label_menu_image_width', 'xss_clean|trim|required|numeric');
		}

		$this->form_validation->set_rules('special_category_id', 'lang:label_special_category', 'xss_clean|trim|numeric');

		$this->form_validation->set_rules('country_id', 'lang:label_country', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('default_location_id', 'lang:label_default_location', 'xss_clean|trim|required|integer');

		$this->form_validation->set_rules('maps_api_key', 'lang:label_maps_api_key', 'xss_clean|trim');
		$this->form_validation->set_rules('distance_unit', 'lang:label_distance_unit', 'xss_clean|trim|required');

		$this->form_validation->set_rules('tax_mode', 'lang:label_tax_mode', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('tax_title', 'lang:label_tax_title', 'xss_clean|trim|max_length[32]');
		$this->form_validation->set_rules('tax_percentage', 'lang:label_tax_percentage', 'xss_clean|trim|numeric');
		$this->form_validation->set_rules('tax_menu_price', 'lang:label_tax_menu_price', 'xss_clean|trim|numeric');
		$this->form_validation->set_rules('tax_delivery_charge', 'lang:label_tax_delivery_charge', 'xss_clean|trim|numeric');

		$this->form_validation->set_rules('allow_reviews', 'lang:label_allow_reviews', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('approve_reviews', 'lang:label_approve_reviews', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('stock_checkout', 'lang:label_stock_checkout', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('show_stock_warning', 'lang:label_show_stock_warning', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('registration_terms', 'lang:label_registration_terms', 'xss_clean|trim|required|numeric');
		$this->form_validation->set_rules('checkout_terms', 'lang:label_checkout_terms', 'xss_clean|trim|required|numeric');

		$this->form_validation->set_rules('default_order_status', 'lang:label_default_order_status', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('processing_order_status[]', 'lang:label_processing_order_status', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('completed_order_status[]', 'lang:label_completed_order_status', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('canceled_order_status', 'lang:label_canceled_order_status', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('delivery_time', 'lang:label_delivery_time', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('collection_time', 'lang:label_collection_time', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('guest_order', 'lang:label_guest_order', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('location_order', 'lang:label_location_order', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('future_orders', 'lang:label_future_order', 'xss_clean|trim|required|numeric');
		$this->form_validation->set_rules('auto_invoicing', 'lang:label_auto_invoicing', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('invoice_prefix', 'lang:label_invoice_prefix', 'xss_clean|trim');

		$this->form_validation->set_rules('reservation_mode', 'lang:label_reservation_mode', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('default_reservation_status', 'lang:label_default_reservation_status', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('confirmed_reservation_status', 'lang:label_confirmed_reservation_status', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('canceled_reservation_status', 'lang:label_canceled_reservation_status', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('reservation_time_interval', 'lang:label_reservation_time_interval', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('reservation_stay_time', 'lang:label_reservation_stay_time', 'xss_clean|trim|required|integer');

		$this->form_validation->set_rules('image_manager[max_size]', 'lang:label_media_max_size', 'xss_clean|trim|required|numeric');
		$this->form_validation->set_rules('image_manager[thumb_height]', 'lang:label_media_thumb_height', 'xss_clean|trim|required|numeric');
		$this->form_validation->set_rules('image_manager[thumb_width]', 'lang:label_media_thumb_width', 'xss_clean|trim|required|numeric');
		$this->form_validation->set_rules('image_manager[uploads]', 'lang:label_media_uploads', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('image_manager[new_folder]', 'lang:label_media_new_folder', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('image_manager[copy]', 'lang:label_media_copy', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('image_manager[move]', 'lang:label_media_move', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('image_manager[rename]', 'lang:label_media_rename', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('image_manager[delete]', 'lang:label_media_delete', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('image_manager[transliteration]', 'lang:label_media_transliteration', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('image_manager[remember_days]', 'lang:label_media_remember_days', 'xss_clean|trim|integer');

		$this->form_validation->set_rules('registration_email[]', 'lang:label_registration_email', 'xss_clean|trim|required|alpha');
		$this->form_validation->set_rules('order_email[]', 'lang:label_order_email', 'xss_clean|trim|required|alpha');
		$this->form_validation->set_rules('reservation_email[]', 'lang:label_reservation_email', 'xss_clean|trim|required|alpha');
		$this->form_validation->set_rules('protocol', 'lang:label_protocol', 'xss_clean|trim|required');
		$this->form_validation->set_rules('smtp_host', 'lang:label_smtp_host', 'xss_clean|trim');
		$this->form_validation->set_rules('smtp_port', 'lang:label_smtp_port', 'xss_clean|trim');
		$this->form_validation->set_rules('smtp_user', 'lang:label_smtp_user', 'xss_clean|trim');
		$this->form_validation->set_rules('smtp_pass', 'lang:label_smtp_pass', 'xss_clean|trim');

		$this->form_validation->set_rules('customer_online_time_out', 'lang:label_customer_online_time_out', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('customer_online_archive_time_out', 'lang:label_customer_online_archive_time_out', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('permalink', 'lang:label_permalink', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('maintenance_mode', 'lang:label_maintenance_mode', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('maintenance_message', 'lang:label_maintenance_message', 'xss_clean|trim');
		$this->form_validation->set_rules('cache_mode', 'lang:label_cache_mode', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('cache_time', 'lang:label_cache_time', 'xss_clean|trim|integer');

		if ($this->form_validation->run() == TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}

	}

	private function getTimezones() {
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

        $timezone_list = array();
		foreach ($temp_timezones as $tz) {
			$sign = ($tz['offset'] > 0) ? '+' : '-';
			$offset = gmdate('H:i', abs($tz['offset']));
			$timezone_list[$tz['identifier']] = $tz['identifier'] .' (UTC ' . $sign . $offset .')';
		}

		return $timezone_list;
	}

	private function _delete_thumbs($thumb_path) {
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