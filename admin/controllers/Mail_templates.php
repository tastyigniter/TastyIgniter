<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Mail_templates extends Admin_Controller {

    public function __construct() {
		parent::__construct();

        $this->user->restrict('Admin.MailTemplates');

        $this->load->model('Mail_templates_model');
        $this->load->model('Settings_model');

        $this->lang->load('mail_templates');
    }

	public function index() {
        $this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading($this->lang->line('text_heading'));

        $this->template->setButton($this->lang->line('button_new'), array('class' => 'btn btn-primary', 'href' => page_url() .'/edit'));
		$this->template->setButton($this->lang->line('button_delete'), array('class' => 'btn btn-danger', 'onclick' => '$(\'#list-form\').submit();'));

		$results = $this->Mail_templates_model->getList();

		$data['templates'] = array();
		foreach ($results as $result) {
			if ($result['template_id'] !== $this->config->item('mail_template_id')) {
				$default = site_url('mail_templates?default=1&template_id='. $result['template_id']);
			} else {
				$default = '1';
			}

			$data['templates'][] = array(
				'template_id' 		=> $result['template_id'],
				'name' 				=> $result['name'],
				'date_added' 		=> mdate('%d %M %y - %H:%i', strtotime($result['date_added'])),
				'date_updated' 		=> mdate('%d %M %y - %H:%i', strtotime($result['date_updated'])),
				'status' 			=> ($result['status'] === '1') ? $this->lang->line('text_enabled') : $this->lang->line('text_disabled'),
				'default' 			=> $default,
				'edit'				=> site_url('mail_templates/edit?id='. $result['template_id'])
			);
		}

        if ($this->input->get('default') === '1' AND $this->input->get('template_id')) {
            $template_id = $this->input->get('template_id');

            if ($this->Settings_model->addSetting('prefs', 'mail_template_id', $template_id, '0')) {
                $this->alert->set('success', $this->lang->line('alert_set_default'));
            }

            redirect('mail_templates');
        }

        if ($this->input->post('delete') AND $this->_deleteTemplate() === TRUE) {
			redirect('mail_templates');
		}

		$this->template->render('mail_templates', $data);
	}

	public function edit() {
		$template_info = $this->Mail_templates_model->getTemplate((int) $this->input->get('id'));

		if ($template_info) {
			$template_id = $template_info['template_id'];
			$data['_action']	= site_url('mail_templates/edit?id='. $template_id);
		} else {
		    $template_id = 0;
			$data['_action']	= site_url('mail_templates/edit');
		}

		$title = (isset($template_info['name'])) ? $template_info['name'] : $this->lang->line('text_new');
        $this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $title));
        $this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $title));

        $this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setBackButton('btn btn-back', site_url('mail_templates'));

        $this->template->setScriptTag(root_url('assets/js/tinymce/tinymce.min.js'), 'tinymce-js', '111');

		$data['template_id'] 		= $template_id;
		$data['name'] 				= $template_info['name'];
		$data['status'] 			= $template_info['status'];

		$titles = array(
			'registration'			=> $this->lang->line('text_registration'),
			'password_reset'		=> $this->lang->line('text_password_reset'),
			'order'					=> $this->lang->line('text_order'),
			'reservation'			=> $this->lang->line('text_reservation'),
			'internal'				=> $this->lang->line('text_internal'),
			'contact'				=> $this->lang->line('text_contact'),
			'order_alert'			=> $this->lang->line('text_order_alert'),
			'reservation_alert'		=> $this->lang->line('text_reservation_alert')
		);

		$data['template_data'] = array();
		$template_data = $this->Mail_templates_model->getAllTemplateData($template_id);
		foreach ($template_data as $tpl_data) {
			foreach ($titles as $key => $title) {
				if ($key === $tpl_data['code']) {
					$data['template_data'][] = array(
						'template_id'		=> $tpl_data['template_id'],
						'template_data_id'	=> $tpl_data['template_data_id'],
						'title'				=> $title,
						'code'				=> $tpl_data['code'],
						'subject'			=> $tpl_data['subject'],
						'body'				=> html_entity_decode($tpl_data['body']),
						'date_added'		=> mdate('%d %M %y - %H:%i', strtotime($tpl_data['date_added'])),
						'date_updated'		=> mdate('%d %M %y - %H:%i', strtotime($tpl_data['date_updated']))
					);
				}
			}
		}

		$data['templates'] = array();
		$results = $this->Mail_templates_model->getTemplates();
		foreach ($results as $result) {
			$data['templates'][] = array(
				'template_id' 		=> $result['template_id'],
				'name' 				=> $result['name'],
				'status' 			=> $result['status']
			);
		}

		if ($this->input->post() AND $template_id = $this->_saveTemplate()) {
			if ($this->input->post('save_close') === '1') {
				redirect('mail_templates');
			}

			redirect('mail_templates/edit?id='. $template_id);
		}

		$this->template->render('mail_templates_edit', $data);
	}

	public function variables() {
        $this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $this->lang->line('text_variables')));
        $this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $this->lang->line('text_variables')));

        $data['variables'] = array();

		$this->output->enable_profiler(FALSE);
		$this->template->render('mail_templates_variables', $data);
	}

	private function _saveTemplate() {
    	if ($this->validateForm() === TRUE) {
            $save_type = ( ! is_numeric($this->input->get('id'))) ? $this->lang->line('text_added') : $this->lang->line('text_updated');

			if ($template_id = $this->Mail_templates_model->saveTemplate($this->input->get('id'), $this->input->post())) {
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Mail Template '.$save_type));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
			}

			return $template_id;
		}
	}

	private function _deleteTemplate() {
        if ($this->input->post('delete')) {
            $deleted_rows = $this->Mail_templates_model->deleteTemplate($this->input->post('delete'));

            if ($deleted_rows > 0) {
                $prefix = ($deleted_rows > 1) ? '['.$deleted_rows.'] Mail Templates': 'Mail Template';
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), $prefix.' '.$this->lang->line('text_deleted')));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_deleted')));
            }

            return TRUE;
        }
	}

	private function validateForm() {
		$this->form_validation->set_rules('name', 'lang:label_name', 'xss_clean|trim|required|min_length[2]|max_length[32]');

		if (!$this->input->get('id')) {
			$this->form_validation->set_rules('clone_template_id', 'lang:label_clone', 'xss_clean|trim|required|integer');
		}

		$this->form_validation->set_rules('language_id', 'lang:label_language', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('status', 'lang:label_status', 'xss_clean|trim|required|integer');

        if ($this->input->post('templates')) {
            foreach ($this->input->post('templates') as $key => $value) {
                $this->form_validation->set_rules('templates[' . $key . '][code]', 'lang:label_code', 'xss_clean|trim|required');
                $this->form_validation->set_rules('templates[' . $key . '][subject]', 'lang:label_subject', 'xss_clean|trim|required|min_length[2]|max_length[128]');
                $this->form_validation->set_rules('templates[' . $key . '][body]', 'lang:label_body', 'required|min_length[3]');
            }
        }

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file mail_templates.php */
/* Location: ./admin/controllers/mail_templates.php */