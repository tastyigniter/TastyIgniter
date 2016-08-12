<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Mail_templates extends Admin_Controller
{

	public function __construct() {
		parent::__construct();

		$this->user->restrict('Admin.MailTemplates');

		$this->load->model('Mail_templates_model');
		$this->load->model('Settings_model');

		$this->lang->load('mail_templates');
	}

	public function index() {
		if ($this->input->get('default') === '1' AND $this->input->get('template_id')) {
			$template_id = $this->input->get('template_id');

			if ($this->Settings_model->addSetting('prefs', 'mail_template_id', $template_id, '0')) {
				$this->alert->set('success', $this->lang->line('alert_set_default'));
			}

			$this->redirect();
		}

		if ($this->input->post('delete') AND $this->_deleteTemplate() === TRUE) {
			$this->redirect();
		}

		$this->template->setTitle($this->lang->line('text_title'));
		$this->template->setHeading($this->lang->line('text_heading'));

		$this->template->setButton($this->lang->line('button_new'), array('class' => 'btn btn-primary', 'href' => page_url() . '/edit'));
		$this->template->setButton($this->lang->line('button_delete'), array('class' => 'btn btn-danger', 'onclick' => 'confirmDelete();'));;

		$data = $this->getList();

		$this->template->render('mail_templates', $data);
	}

	public function edit() {
		if ($this->input->post() AND $template_id = $this->_saveTemplate()) {
			$this->redirect($template_id);
		}

		$template_info = $this->Mail_templates_model->getTemplate((int)$this->input->get('id'));

		$title = (isset($template_info['name'])) ? $template_info['name'] : $this->lang->line('text_new');
		$this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $title));
		$this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $title));

		$this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('mail_templates')));

		$this->template->setStyleTag(assets_url('js/summernote/summernote.css'), 'summernote-css');
		$this->template->setScriptTag(assets_url('js/summernote/summernote.min.js'), 'summernote-js');

		$data = $this->getForm($template_info);

		$this->template->render('mail_templates_edit', $data);
	}

	public function variables() {
		$this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $this->lang->line('text_variables')));
		$this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $this->lang->line('text_variables')));

		$data = $this->getVariables();

		$this->output->enable_profiler(FALSE);
		$this->template->render('mail_templates_variables', $data);
	}

	public function getList() {
		$data['templates'] = array();
		$results = $this->Mail_templates_model->paginate();
		foreach ($results->list as $result) {
			$default = ($result['template_id'] !== $this->config->item('mail_template_id')) ? $this->pageUrl($this->index_url . '?default=1&template_id=' . $result['template_id']) : '1';
			$data['templates'][] = array_merge($result, array(
				'date_added'   => mdate('%d %M %y - %H:%i', strtotime($result['date_added'])),
				'date_updated' => mdate('%d %M %y - %H:%i', strtotime($result['date_updated'])),
				'default'      => $default,
				'edit'         => $this->pageUrl($this->edit_url, array('id' => $result['template_id'])),
			));
		}

		$data['pagination'] = $results->pagination;

		return $data;
	}

	public function getForm($template_info = array()) {
		$data = $template_info;

		$template_id = 0;
		$data['_action'] = $this->pageUrl($this->create_url);
		if (!empty($template_info['template_id'])) {
			$template_id = $template_info['template_id'];
			$data['_action'] = $this->pageUrl($this->edit_url, array('id' => $template_id));
		}

		if ($template_id === '11') {
			$this->alert->set('info', $this->lang->line('alert_caution_edit'));
		}

		$data['template_id'] = $template_id;
		$data['name'] = $template_info['name'];
		$data['status'] = $template_info['status'];

		$titles = array(
			'registration'         => $this->lang->line('text_registration'),
			'registration_alert'   => $this->lang->line('text_registration_alert'),
			'password_reset'       => $this->lang->line('text_password_reset'),
			'password_reset_alert' => $this->lang->line('text_password_reset_alert'),
			'order'                => $this->lang->line('text_order'),
			'order_alert'          => $this->lang->line('text_order_alert'),
			'order_update'         => $this->lang->line('text_order_update'),
			'reservation'          => $this->lang->line('text_reservation'),
			'reservation_alert'    => $this->lang->line('text_reservation_alert'),
			'reservation_update'   => $this->lang->line('text_reservation_update'),
			'internal'             => $this->lang->line('text_internal'),
			'contact'              => $this->lang->line('text_contact'),
		);

		$data['template_data'] = array();
		$template_data = $this->Mail_templates_model->getAllTemplateData($template_id);
		foreach ($titles as $key => $value) {
			foreach ($template_data as $tpl_data) {
				if ($key === $tpl_data['code']) {
					$data['template_data'][] = array_merge($tpl_data, array(
						'title'        => $value,
						'body'         => html_entity_decode($tpl_data['body']),
						'date_added'   => mdate('%d %M %y - %H:%i', strtotime($tpl_data['date_added'])),
						'date_updated' => mdate('%d %M %y - %H:%i', strtotime($tpl_data['date_updated'])),
					));
				}
			}
		}

		$data['templates'] = $this->Mail_templates_model->isEnabled()->dropdown('name');

		return $data;
	}

	protected function _saveTemplate() {
		if ($this->validateForm() === TRUE) {
			$save_type = (!is_numeric($this->input->get('id'))) ? $this->lang->line('text_added') : $this->lang->line('text_updated');
			if ($template_id = $this->Mail_templates_model->saveTemplate($this->input->get('id'), $this->input->post())) {
				$this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Mail Template ' . $save_type));
			} else {
				$this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
			}

			return $template_id;
		}
	}

	protected function _deleteTemplate() {
		if ($this->input->post('delete')) {
			$deleted_rows = $this->Mail_templates_model->deleteTemplate($this->input->post('delete'));
			if ($deleted_rows > 0) {
				$prefix = ($deleted_rows > 1) ? '[' . $deleted_rows . '] Mail Templates' : 'Mail Template';
				$this->alert->set('success', sprintf($this->lang->line('alert_success'), $prefix . ' ' . $this->lang->line('text_deleted')));
			} else {
				$this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_deleted')));
			}

			return TRUE;
		}
	}

	protected function validateForm() {
		$rules[] = array('name', 'lang:label_name', 'xss_clean|trim|required|min_length[2]|max_length[32]');

		if (!$this->input->get('id')) {
			$rules[] = array('clone_template_id', 'lang:label_clone', 'xss_clean|trim|required|integer');
		}

		$rules[] = array('language_id', 'lang:label_language', 'xss_clean|trim|required|integer');
		$rules[] = array('status', 'lang:label_status', 'xss_clean|trim|required|integer');

		if ($this->input->post('templates')) {
			foreach ($this->input->post('templates') as $key => $value) {
				$rules[] = array('templates[' . $key . '][code]', 'lang:label_code', 'xss_clean|trim|required');
				$rules[] = array('templates[' . $key . '][subject]', 'lang:label_subject', 'xss_clean|trim|required|min_length[2]|max_length[128]');
				$rules[] = array('templates[' . $key . '][body]', 'lang:label_body', 'required|min_length[3]');
			}
		}

		return $this->Mail_templates_model->set_rules($rules)->validate();
	}

	protected function getVariables() {
		$data['filters'] = array(
			'General'            => array('registration', 'registration_alert', 'password_reset', 'password_reset_alert', 'order', 'order_alert', 'order_update', 'reservation', 'reservation_alert', 'reservation_update', 'internal', 'contact'),
			'Customer'           => array('registration', 'registration_alert', 'password_reset', 'password_reset_alert', 'order', 'order_alert', 'order_update', 'reservation', 'reservation_alert', 'reservation_update'),
			'Staff'              => array('password_reset_alert', 'order', 'order_alert', 'order_update', 'reservation', 'reservation_alert', 'reservation_update'),
			'Registration/Reset' => array('registration', 'registration_alert', 'password_reset', 'password_reset_alert'),
			'Order'              => array('order', 'order_alert', 'order_update'),
			'Reservation'        => array('reservation', 'reservation_alert', 'reservation_update'),
			'Status'             => array('order', 'order_alert', 'order_update', 'reservation', 'reservation_alert', 'reservation_update'),
			'Contact'            => array('contact'),
		);

		$data['variables'] = array(
			'General'            => array(
				array(
					'var'  => '{site_name}', 'name' => 'Site name',
				),
				array(
					'var'  => '{site_logo}', 'name' => 'Site logo',
				),
				array(
					'var'  => '{site_url}', 'name' => 'Site URL',
				),
				array(
					'var'  => '{signature}', 'name' => 'Signature',
				),
				array(
					'var'  => '{location_name}', 'name' => 'Location name',
				),
			),
			'Customer'           => array(
				array(
					'var'  => '{full_name}', 'name' => 'Customer full name',
				),
				array(
					'var'  => '{first_name}', 'name' => 'Customer first name',
				),
				array(
					'var'  => '{last_name}', 'name' => 'Customer last name',
				),
				array(
					'var'  => '{email}', 'name' => 'Customer email address',
				),
				array(
					'var'  => '{telephone}', 'name' => 'Customer telephone address',
				),
			),
			'Staff'              => array(
				array(
					'var'  => '{staff_name}', 'name' => 'Staff name',
				),
				array(
					'var'  => '{staff_username}', 'name' => 'Staff username',
				),
			),
			'Registration/Reset' => array(
				array(
					'var'  => '{account_login_link}', 'name' => 'Account login link',
				),
				array(
					'var'  => '{reset_password}', 'name' => 'Created password on password reset',
				),
			),
			'Order'              => array(
				array(
					'var'  => '{order_number}', 'name' => 'Order number',
				),
				array(
					'var'  => '{order_view_url}', 'name' => 'Order view URL',
				),
				array(
					'var'  => '{order_type}', 'name' => 'Order type ex. delivery/pick-up',
				),
				array(
					'var'  => '{order_time}', 'name' => 'Order delivery/pick-up time',
				),
				array(
					'var'  => '{order_date}', 'name' => 'Order delivery/pick-up date',
				),
				array(
					'var'  => '{order_address}', 'name' => 'Customer address for delivery order',
				),
				array(
					'var'  => '{order_payment}', 'name' => 'Order payment method',
				),
				array(
					'var'  => '{order_menus}', 'name' => 'Order menus  - START iteration',
				),
				array(
					'var'  => '{menu_name}', 'name' => 'Order menu name',
				),
				array(
					'var'  => '{menu_quantity}', 'name' => 'Order menu quantity',
				),
				array(
					'var'  => '{menu_price}', 'name' => 'Order menu price',
				),
				array(
					'var'  => '{menu_subtotal}', 'name' => 'Order menu subtotal',
				),
				array(
					'var'  => '{menu_options}', 'name' => 'Order menu option ex. name: price',
				),
				array(
					'var'  => '{menu_comment}', 'name' => 'Order menu comment',
				),
				array(
					'var'  => '{/order_menus}', 'name' => 'Order menus  - END iteration',
				),
				array(
					'var'  => '{order_totals}', 'name' => 'Order total pairs - START iteration',
				),
				array(
					'var'  => '{order_total_title}', 'name' => 'Order total title',
				),
				array(
					'var'  => '{order_total_value}', 'name' => 'Order total value',
				),
				array(
					'var'  => '{/order_totals}', 'name' => 'Order total pairs - END iteration',
				),
				array(
					'var'  => '{order_comment}', 'name' => 'Order comment',
				),
			),
			'Reservation'        => array(
				array(
					'var'  => '{reservation_number}', 'name' => 'Reservation number',
				),
				array(
					'var'  => '{reservation_view_url}', 'name' => 'Reservation view URL',
				),
				array(
					'var'  => '{reservation_date}', 'name' => 'Reservation date',
				),
				array(
					'var'  => '{reservation_time}', 'name' => 'Reservation time',
				),
				array(
					'var'  => '{reservation_guest_no}', 'name' => 'No. of guest reserved',
				),
				array(
					'var'  => '{reservation_comment}', 'name' => 'Reservation comment',
				),
			),
			'Status'             => array(
				array(
					'var'  => '{status_name}', 'name' => 'Status name',
				),
				array(
					'var'  => '{status_comment}', 'name' => 'Status comment',
				),
			),
			'Contact'            => array(
				array(
					'var'  => '{contact_topic}', 'name' => 'Contact topic',
				),
				array(
					'var'  => '{contact_telephone}', 'name' => 'Contact telephone',
				),
				array(
					'var'  => '{contact_message}', 'name' => 'Contact message body',
				),
			),
		);

		return $data;
	}
}

/* End of file Mail_templates.php */
/* Location: ./admin/controllers/Mail_templates.php */