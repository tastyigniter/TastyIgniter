<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Settings extends Admin_Controller
{

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
		if ($this->input->post() AND $this->_updateSettings() === TRUE) {
			$this->redirect();
		}

		$this->template->setTitle($this->lang->line('text_title'));
		$this->template->setHeading($this->lang->line('text_heading'));
		$this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));

		$data = $this->getForm();

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
			$this->output->set_output(json_encode($json));                                            // encode the json array and set final out to be sent to jQuery AJAX
		} else {
			if (isset($json['error'])) $this->alert->set('danger', $json['error']);
			if (isset($json['success'])) $this->alert->set('success', $json['success']);
			$this->redirect('settings/#image-manager');
		}
	}

	public function send_test_email() {
		$json = array();

		if (!$this->input->post('send_test_email')) {
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
			$this->output->set_output(json_encode($json));                                            // encode the json array and set final out to be sent to jQuery AJAX
		} else {
			if (isset($json['error'])) $this->alert->set('danger', $json['error']);
			if (isset($json['success'])) $this->alert->set('success', $json['success']);
			$this->redirect('settings/#mail');
		}
	}

	protected function getForm() {
		$post_data = $this->input->post();

		foreach ($this->config->config as $key => $value) {
			if (isset($post_data[$key])) {
				$data[$key] = $post_data[$key];
			} else {
				$data[$key] = $value;
			}
		}

		$this->load->model('Image_tool_model');
		$data['no_photo'] = $this->Image_tool_model->resize('data/no_photo.png');
		$data['logo_val'] = 'data/no_photo.png';
		$data['site_logo'] = $data['no_photo'];
		$data['logo_name'] = 'no_photo.png';
		if ($this->config->item('site_logo')) {
			$data['logo_val'] = $this->config->item('site_logo');
			$data['site_logo'] = $this->Image_tool_model->resize($data['logo_val']);
			$data['logo_name'] = basename($data['logo_val']);
		}

		if (!isset($data['auto_lat_lng'])) {
			$data['auto_lat_lng'] = '1';
		}

		$image_manager = is_array($data['image_manager']) ? $data['image_manager'] : array();
		$image_manager_defs = array(
			'max_size'        => '', 'thumb_height' => '', 'thumb_width' => '', 'uploads' => '',
			'new_folder'      => '', 'copy' => '', 'move' => '', 'rename' => '', 'delete' => '',
			'transliteration' => '', 'remember_days' => '',
		);

		$data['image_manager'] = array_merge($image_manager_defs, $image_manager, array(
			'delete_thumbs' => $this->pageUrl($this->index_url . '/delete_thumbs'),
		));

		if (!isset($data['auto_update_currency_rates'])) $this->config->set_item('auto_update_currency_rates', '0');

		if (!isset($data['accepted_currencies'])) $this->config->set_item('accepted_currencies', array());

		if (!isset($data['show_stock_warning'])) $this->config->set_item('show_stock_warning', '1');

		if (!isset($data['invoice_prefix'])) $this->config->set_item('invoice_prefix', 'INV-{year}-00');

		if (!isset($data['processing_order_status'])) $this->config->set_item('processing_order_status', array('12', '13', '14'));

		if (empty($data['customer_online_time_out'])) $data['customer_online_time_out'] = '120';

		if (empty($data['cache_time'])) $data['cache_time'] = '0';

		$data['page_limits'] = array('10', '20', '50', '75', '100');

		$data['protocols'] = array('mail', 'sendmail', 'smtp');
		$data['thresholds'] = array('Disable', 'Error Only', 'Debug Only', 'Info Only', 'All');

		$data['timezones'] = $this->getTimezones();

		$data['date_formats'] = array('%j%S %F %Y', '%d/%m/%Y', '%m/%d/%Y', '%Y-%m-%d');
		$data['time_formats'] = array('%h:%i %A', '%h:%i %a', '%H:%i');
		isset($data['date_format']) OR $data['date_format'] = $data['date_formats'][0];
		isset($data['time_format']) OR $data['time_format'] = $data['time_formats'][0];

		$this->load->model('Locations_model');
		$data['locations'] = $this->Locations_model->isEnabled()->dropdown('location_name');
		$data['countries'] = $this->Countries_model->isEnabled()->dropdown('country_name');

		$this->load->model('Languages_model');
		$data['languages'] = $this->Languages_model->isEnabled()->dropdown('name');

		$data['currencies'] = array();
		$currencies = $this->Currencies_model->getCurrencies();
		foreach ($currencies as $currency) {
			$data['currencies'][] = array_merge($currency, array(
				'currency_name' => $currency['country_name'] . ' - ' . $currency['currency_name'],
			));
		}

		$this->load->model('Customer_groups_model');
		$data['customer_groups'] = $this->Customer_groups_model->dropdown('group_name');

		$data['categories'] = $this->Categories_model->isEnabled()->dropdown('name');

		$data['order_statuses'] = $this->Statuses_model->isForOrder()->dropdown('status_name');
		$data['reservation_statuses'] = $this->Statuses_model->isForReservation()->dropdown('status_name');

		$this->load->model('Pages_model');
		$data['pages'] = $this->Pages_model->isEnabled()->dropdown('name');

		return $data;
	}

	protected function _updateSettings() {
		if ($this->validateForm() === TRUE) {
			$data = $this->input->post();
			unset($data['default_location_id']);

			if ($this->Settings_model->updateSettings('config', $data, TRUE)) {
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

	protected function validateForm() {
		$rules[] = array('site_name', 'lang:label_site_name', 'xss_clean|trim|required|min_length[2]|max_length[128]');
		$rules[] = array('site_email', 'lang:label_site_email', 'xss_clean|trim|required|valid_email');
		$rules[] = array('site_logo', 'lang:label_site_logo', 'xss_clean|trim|required');
		$rules[] = array('timezone', 'lang:label_timezone', 'xss_clean|trim|required');
		$rules[] = array('date_format', 'lang:label_date_format', 'xss_clean|trim|required');
		$rules[] = array('time_format', 'lang:label_time_format', 'xss_clean|trim|required');
		$rules[] = array('currency_id', 'lang:label_site_currency', 'xss_clean|trim|required|integer');
		$rules[] = array('auto_update_currency_rates', 'lang:label_auto_update_rates', 'xss_clean|trim|required|integer');
		$rules[] = array('accepted_currencies[]', 'lang:label_accepted_currency', 'xss_clean|trim|required|integer');
		$rules[] = array('detect_language', 'lang:label_default_language', 'xss_clean|trim|required|integer');
		$rules[] = array('language_id', 'lang:label_site_language', 'xss_clean|trim|required');
		$rules[] = array('admin_language_id', 'lang:label_admin_language', 'xss_clean|trim|required');
		$rules[] = array('customer_group_id', 'lang:label_customer_group', 'xss_clean|trim|required|integer');
		$rules[] = array('page_limit', 'lang:label_page_limit', 'xss_clean|trim|required|integer');
		$rules[] = array('meta_description', 'lang:label_meta_description', 'xss_clean|trim');
		$rules[] = array('meta_keywords', 'lang:label_meta_keyword', 'xss_clean|trim');
		$rules[] = array('menus_page_limit', 'lang:label_menu_page_limit', 'xss_clean|trim|required|integer');
		$rules[] = array('show_menu_images', 'lang:label_show_menu_image', 'xss_clean|trim|required|integer');

		if ($this->input->post('show_menu_images') == '1') {
			$rules[] = array('menu_images_h', 'lang:label_menu_image_height', 'xss_clean|trim|required|numeric');
			$rules[] = array('menu_images_w', 'lang:label_menu_image_width', 'xss_clean|trim|required|numeric');
		}

		$rules[] = array('special_category_id', 'lang:label_special_category', 'xss_clean|trim|numeric');

		$rules[] = array('country_id', 'lang:label_country', 'xss_clean|trim|required|integer');
		$rules[] = array('default_location_id', 'lang:label_default_location', 'xss_clean|trim|required|integer');

		$rules[] = array('maps_api_key', 'lang:label_maps_api_key', 'xss_clean|trim|required');
		$rules[] = array('distance_unit', 'lang:label_distance_unit', 'xss_clean|trim|required');

		$rules[] = array('tax_mode', 'lang:label_tax_mode', 'xss_clean|trim|required|integer');
		$rules[] = array('tax_title', 'lang:label_tax_title', 'xss_clean|trim|max_length[32]');
		$rules[] = array('tax_percentage', 'lang:label_tax_percentage', 'xss_clean|trim|numeric');
		$rules[] = array('tax_menu_price', 'lang:label_tax_menu_price', 'xss_clean|trim|numeric');
		$rules[] = array('tax_delivery_charge', 'lang:label_tax_delivery_charge', 'xss_clean|trim|numeric');

		$rules[] = array('allow_reviews', 'lang:label_allow_reviews', 'xss_clean|trim|required|integer');
		$rules[] = array('approve_reviews', 'lang:label_approve_reviews', 'xss_clean|trim|required|integer');
		$rules[] = array('stock_checkout', 'lang:label_stock_checkout', 'xss_clean|trim|required|integer');
		$rules[] = array('show_stock_warning', 'lang:label_show_stock_warning', 'xss_clean|trim|required|integer');
		$rules[] = array('registration_terms', 'lang:label_registration_terms', 'xss_clean|trim|required|numeric');
		$rules[] = array('checkout_terms', 'lang:label_checkout_terms', 'xss_clean|trim|required|numeric');

		$rules[] = array('default_order_status', 'lang:label_default_order_status', 'xss_clean|trim|required|integer');
		$rules[] = array('processing_order_status[]', 'lang:label_processing_order_status', 'xss_clean|trim|required|integer');
		$rules[] = array('completed_order_status[]', 'lang:label_completed_order_status', 'xss_clean|trim|required|integer');
		$rules[] = array('canceled_order_status', 'lang:label_canceled_order_status', 'xss_clean|trim|required|integer');
		$rules[] = array('delivery_time', 'lang:label_delivery_time', 'xss_clean|trim|required|integer');
		$rules[] = array('collection_time', 'lang:label_collection_time', 'xss_clean|trim|required|integer');
		$rules[] = array('guest_order', 'lang:label_guest_order', 'xss_clean|trim|required|integer');
		$rules[] = array('location_order', 'lang:label_location_order', 'xss_clean|trim|required|integer');
		$rules[] = array('future_orders', 'lang:label_future_order', 'xss_clean|trim|required|numeric');
		$rules[] = array('auto_invoicing', 'lang:label_auto_invoicing', 'xss_clean|trim|required|integer');
		$rules[] = array('invoice_prefix', 'lang:label_invoice_prefix', 'xss_clean|trim');

		$rules[] = array('reservation_mode', 'lang:label_reservation_mode', 'xss_clean|trim|required|integer');
		$rules[] = array('default_reservation_status', 'lang:label_default_reservation_status', 'xss_clean|trim|required|integer');
		$rules[] = array('confirmed_reservation_status', 'lang:label_confirmed_reservation_status', 'xss_clean|trim|required|integer');
		$rules[] = array('canceled_reservation_status', 'lang:label_canceled_reservation_status', 'xss_clean|trim|required|integer');
		$rules[] = array('reservation_time_interval', 'lang:label_reservation_time_interval', 'xss_clean|trim|required|integer');
		$rules[] = array('reservation_stay_time', 'lang:label_reservation_stay_time', 'xss_clean|trim|required|integer');

		$rules[] = array('image_manager[max_size]', 'lang:label_media_max_size', 'xss_clean|trim|required|numeric');
		$rules[] = array('image_manager[thumb_height]', 'lang:label_media_thumb_height', 'xss_clean|trim|required|numeric');
		$rules[] = array('image_manager[thumb_width]', 'lang:label_media_thumb_width', 'xss_clean|trim|required|numeric');
		$rules[] = array('image_manager[uploads]', 'lang:label_media_uploads', 'xss_clean|trim|integer');
		$rules[] = array('image_manager[new_folder]', 'lang:label_media_new_folder', 'xss_clean|trim|integer');
		$rules[] = array('image_manager[copy]', 'lang:label_media_copy', 'xss_clean|trim|integer');
		$rules[] = array('image_manager[move]', 'lang:label_media_move', 'xss_clean|trim|integer');
		$rules[] = array('image_manager[rename]', 'lang:label_media_rename', 'xss_clean|trim|integer');
		$rules[] = array('image_manager[delete]', 'lang:label_media_delete', 'xss_clean|trim|integer');
		$rules[] = array('image_manager[transliteration]', 'lang:label_media_transliteration', 'xss_clean|trim|integer');
		$rules[] = array('image_manager[remember_days]', 'lang:label_media_remember_days', 'xss_clean|trim|integer');

		$rules[] = array('registration_email[]', 'lang:label_registration_email', 'xss_clean|trim|required|alpha');
		$rules[] = array('order_email[]', 'lang:label_order_email', 'xss_clean|trim|required|alpha');
		$rules[] = array('reservation_email[]', 'lang:label_reservation_email', 'xss_clean|trim|required|alpha');
		$rules[] = array('protocol', 'lang:label_protocol', 'xss_clean|trim|required');
		$rules[] = array('smtp_host', 'lang:label_smtp_host', 'xss_clean|trim');
		$rules[] = array('smtp_port', 'lang:label_smtp_port', 'xss_clean|trim');
		$rules[] = array('smtp_user', 'lang:label_smtp_user', 'xss_clean|trim');
		$rules[] = array('smtp_pass', 'lang:label_smtp_pass', 'xss_clean|trim');

		$rules[] = array('customer_online_time_out', 'lang:label_customer_online_time_out', 'xss_clean|trim|required|integer');
		$rules[] = array('customer_online_archive_time_out', 'lang:label_customer_online_archive_time_out', 'xss_clean|trim|required|integer');
		$rules[] = array('permalink', 'lang:label_permalink', 'xss_clean|trim|required|integer');
		$rules[] = array('maintenance_mode', 'lang:label_maintenance_mode', 'xss_clean|trim|required|integer');
		$rules[] = array('maintenance_message', 'lang:label_maintenance_message', 'xss_clean|trim');
		$rules[] = array('cache_mode', 'lang:label_cache_mode', 'xss_clean|trim|required|integer');
		$rules[] = array('cache_time', 'lang:label_cache_time', 'xss_clean|trim|integer');

		$this->Settings_model->set_rules($rules);

		return $this->Settings_model->validate();
	}

	protected function getTimezones() {
		$timezone_identifiers = DateTimeZone::listIdentifiers();
		$utc_time = new DateTime('now', new DateTimeZone('UTC'));

		$temp_timezones = array();
		foreach ($timezone_identifiers as $timezone_identifier) {
			$current_timezone = new DateTimeZone($timezone_identifier);

			$temp_timezones[] = array(
				'offset'     => (int)$current_timezone->getOffset($utc_time),
				'identifier' => $timezone_identifier,
			);
		}

		usort($temp_timezones, function ($a, $b) {
			return ($a['offset'] == $b['offset']) ? strcmp($a['identifier'], $b['identifier']) : $a['offset'] - $b['offset'];
		});

		$timezone_list = array();
		foreach ($temp_timezones as $tz) {
			$sign = ($tz['offset'] > 0) ? '+' : '-';
			$offset = gmdate('H:i', abs($tz['offset']));
			$timezone_list[$tz['identifier']] = $tz['identifier'] . ' (UTC ' . $sign . $offset . ')';
		}

		return $timezone_list;
	}

	protected function _delete_thumbs($thumb_path) {
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
					if (!is_dir($path . '/' . $item)) {
						unlink($path . '/' . $item);
					} else {
						$this->_delete_thumbs($path . '/' . $item);
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

/* End of file Settings.php */
/* Location: ./admin/controllers/Settings.php */