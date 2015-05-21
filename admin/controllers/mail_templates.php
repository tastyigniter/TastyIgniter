<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Mail_templates extends Admin_Controller {

    public $_permission_rules = array('access[index|edit]', 'modify[index|edit]');

    public function __construct() {
		parent::__construct();
		$this->load->model('Mail_templates_model');
		$this->load->model('Settings_model');
	}

	public function index() {
		$this->template->setTitle('Mail Templates');
		$this->template->setHeading('Mail Templates');
		$this->template->setButton('+ New', array('class' => 'btn btn-primary', 'href' => page_url() .'/edit'));
		$this->template->setButton('Delete', array('class' => 'btn btn-danger', 'onclick' => '$(\'#list-form\').submit();'));

		$data['text_empty'] 		= 'There are no mail templates available.';

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
				'status' 			=> ($result['status'] === '1') ? 'Enabled' : 'Disabled',
				'default' 			=> $default,
				'edit'				=> site_url('mail_templates/edit?id='. $result['template_id'])
			);
		}

        if ($this->input->get('default') === '1' AND $this->input->get('template_id')) {
            $template_id = $this->input->get('template_id');

            if ($this->Settings_model->addSetting('prefs', 'mail_template_id', $template_id, '0')) {
                $this->alert->set('success', 'Mail Template set as default successfully!');
            }

            redirect('mail_templates');
        }

        if ($this->input->post('delete') AND $this->_deleteTemplate() === TRUE) {
			redirect('mail_templates');
		}

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('mail_templates', $data);
	}

	public function edit() {
		$template_info = $this->Mail_templates_model->getTemplate((int) $this->input->get('id'));

		if ($template_info) {
			$template_id = $template_info['template_id'];
			$data['action']	= site_url('mail_templates/edit?id='. $template_id);
		} else {
		    $template_id = 0;
			$data['action']	= site_url('mail_templates/edit');
		}

		$title = (isset($template_info['name'])) ? $template_info['name'] : 'New';
		$this->template->setTitle('Mail Template: '. $title);
		$this->template->setHeading('Mail Template: '. $title);
		$this->template->setButton('Save', array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton('Save & Close', array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setBackButton('btn btn-back', site_url('mail_templates'));

        $this->template->setScriptTag(root_url('assets/js/tinymce/tinymce.min.js'), 'tinymce-js', '111');

        $data['text_empty'] 		= 'There is no template message available.';

		$data['template_id'] 		= $template_id;
		$data['name'] 				= $template_info['name'];
		$data['status'] 			= $template_info['status'];

		$titles = array(
			'registration'			=> 'Registration Email',
			'password_reset'		=> 'Password Reset Email',
			'order'					=> 'Order Email',
			'reservation'			=> 'Reservation Email',
			'internal'				=> 'Internal Message',
			'contact'				=> 'Contact Email',
			'order_alert'			=> 'Order Alert',
			'reservation_alert'		=> 'Reservation Alert'
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

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('mail_templates_edit', $data);
	}

	public function variables() {
		$this->template->setTitle('Mail Templates - Variables');
		$this->template->setHeading('Mail Templates - Variables');

		$data['variables'] = array();

		$this->output->enable_profiler(FALSE);
		$this->template->render('mail_templates_variables', $data);
	}

	private function _saveTemplate() {
    	if ($this->validateForm() === TRUE) {
            $save_type = ( ! is_numeric($this->input->get('id'))) ? 'added' : 'updated';

			if ($template_id = $this->Mail_templates_model->saveTemplate($this->input->get('id'), $this->input->post())) {
				$this->alert->set('success', 'Mail Template ' . $save_type . ' successfully.');
			} else {
				$this->alert->set('warning', 'An error occurred, nothing ' . $save_type . '.');
			}

			return $template_id;
		}
	}

	private function _deleteTemplate() {
    	if (is_array($this->input->post('delete'))) {
			foreach ($this->input->post('delete') as $key => $value) {
				if ($value === $this->config->item('mail_template_id')) {
					$this->alert->set('success', 'Default Mail Template can not be deleted!');
				} else {
					$this->Mail_templates_model->deleteTemplate($value);
					$this->alert->set('success', 'Mail Template deleted successfully!');
				}
			}
		}

		return TRUE;
	}

	private function validateForm() {
		$this->form_validation->set_rules('name', 'Name', 'xss_clean|trim|required|min_length[2]|max_length[32]');

		if (!$this->input->get('id')) {
			$this->form_validation->set_rules('clone_template_id', 'Clone Template', 'xss_clean|trim|required|integer');
		}

		$this->form_validation->set_rules('language_id', 'Language', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('status', 'Status', 'xss_clean|trim|required|integer');

        if ($this->input->post('templates')) {
            foreach ($this->input->post('templates') as $key => $value) {
                $this->form_validation->set_rules('templates[' . $key . '][code]', 'Code', 'xss_clean|trim|required');
                $this->form_validation->set_rules('templates[' . $key . '][subject]', 'Subject', 'xss_clean|trim|required|min_length[2]|max_length[128]');
                $this->form_validation->set_rules('templates[' . $key . '][body]', 'Body', 'required|min_length[3]');
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