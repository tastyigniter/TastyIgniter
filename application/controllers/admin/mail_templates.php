<?php
class Mail_templates extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('user');
		$this->load->model('Mail_templates_model');
		$this->load->model('Settings_model');
	}

	public function index() {
			
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/mail_templates')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else {
			$data['alert'] = '';
		}

		$data['heading'] 			= 'Mail Templates';
		$data['button_add'] 		= 'New';
		$data['button_delete'] 		= 'Delete';
		$data['text_empty'] 		= 'There are no mail templates available.';

		$results = $this->Mail_templates_model->getList();

		$data['templates'] = array();
		foreach ($results as $result) {
			$data['templates'][] = array(
				'template_id' 		=> $result['template_id'],
				'name' 				=> $result['name'],
				'date_added' 		=> mdate('%d %M %y - %H:%i', strtotime($result['date_added'])),
				'date_updated' 		=> mdate('%d %M %y - %H:%i', strtotime($result['date_updated'])),
				'status' 			=> ($result['status'] === '1') ? 'Enabled' : 'Disabled',
				'edit'				=> site_url('admin/mail_templates/edit?id='. $result['template_id'])
			);		
		}

		if ($this->input->post('delete') AND $this->_deleteTemplate() === TRUE) {
			redirect('admin/mail_templates');  			
		}	

		$regions = array('header', 'footer');
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'mail_templates.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'mail_templates', $regions, $data);
		} else {
			$this->template->render('themes/admin/default/', 'mail_templates', $regions, $data);
		}
	}

	public function edit() {
			
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/mail_templates')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else { 
			$data['alert'] = '';
		}		

		if (is_numeric($this->input->get('id'))) {
			$template_id = (int)$this->input->get('id');
			$data['action']	= site_url('admin/mail_templates/edit?id='. $template_id);
		} else {
		    $template_id = 0;
			$data['action']	= site_url('admin/mail_templates/edit');
		}
		
		$result = $this->Mail_templates_model->getTemplate($template_id);
		
		$data['heading'] 			= 'Mail Templates - '. $result['name'];
		$data['button_save'] 		= 'Save';
		$data['button_save_close'] 	= 'Save & Close';
		$data['sub_menu_back'] 		= site_url('admin/mail_templates');
		$data['text_empty'] 		= 'There is no template message available.';

		$data['template_id'] 		= $result['template_id'];
		$data['name'] 				= $result['name'];
		$data['status'] 			= $result['status'];
	
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
						'title'				=> $title,
						'code'				=> $tpl_data['code'],
						'subject'			=> $tpl_data['subject'],
						'date_added'		=> mdate('%d %M %y - %H:%i', strtotime($tpl_data['date_added'])),
						'date_updated'		=> mdate('%d %M %y - %H:%i', strtotime($tpl_data['date_updated'])),
						'edit'				=> site_url('admin/mail_templates/message?id='. $tpl_data['template_id'] .'&message='. $tpl_data['code'])
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

		if ($this->input->post() AND $this->_addTemplate() === TRUE) {
			redirect('/admin/mail_templates');
		}

		if ($this->input->post() AND $this->_updateTemplate() === TRUE) {
			if ($this->input->post('save_close') === '1') {
				redirect('admin/mail_templates');
			}
			
			redirect('admin/mail_templates/edit?id='. $template_id);
		}
		
		$regions = array('header', 'footer');
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'mail_templates_edit.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'mail_templates_edit', $regions, $data);
		} else {
			$this->template->render('themes/admin/default/', 'mail_templates_edit', $regions, $data);
		}
	}

	public function message() {
			
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/mail_templates')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else { 
			$data['alert'] = '';
		}		

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

		$result = $this->Mail_templates_model->getTemplateData((int)$this->input->get('id'), $this->input->get('message'));

		if (!$result) {
			redirect('admin/mail_templates');
		}
		
		$template_id = $result['template_id'];

		$data['heading'] 			= 'Mail Templates Message - '. $result['name'];
		$data['button_save'] 		= 'Save';
		$data['button_save_close'] 	= 'Save & Close';
		$data['sub_menu_back'] 		= site_url('admin/mail_templates/edit?id='. $template_id);
		$data['text_empty'] 		= 'There is no template message available.';

		$data['action']				= site_url('admin/mail_templates/message?id='. $result['template_id'] .'&message='. $result['code']);

		foreach ($titles as $key => $title) {					
			if ($key === $result['code']) {
				$message_title = $title;
			}
		}

		$data['message_title']		= $message_title;
		$data['name'] 				= $result['name'];
		$data['subject'] 			= $result['subject'];
		$data['body'] 				= html_entity_decode($result['body']);
		$data['date_updated'] 		= $result['date_updated'];

		if ($this->input->post() AND $this->_updateTemplateData() === TRUE) {
			if ($this->input->post('save_close') === '1') {
				redirect('admin/mail_templates/edit?id='. $result['template_id']);
			}
			
			redirect('admin/mail_templates/message?id='. $result['template_id'] .'&message='. $result['code']);
		}
		
		$regions = array('header', 'footer');
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'mail_templates_message.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'mail_templates_message', $regions, $data);
		} else {
			$this->template->render('themes/admin/default/', 'mail_templates_message', $regions, $data);
		}
	}
	
	public function _addTemplate() {
    	if ( ! $this->user->hasPermissions('modify', 'admin/mail_templates')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to add!</p>');
  			return TRUE;
    	} else if ( ! $this->input->get('id') AND $this->validateForm() === TRUE) { 
			$add = array();

			$add['name'] 				= $this->input->post('name');
			$add['status'] 				= $this->input->post('status');
			$add['language_id'] 		= $this->input->post('language_id');
			$add['clone_template_id'] 	= $this->input->post('clone_template_id');
			$add['date_added'] 			= mdate('%Y-%m-%d %H:%i:%s', time());
			$add['date_updated'] 		= mdate('%Y-%m-%d %H:%i:%s', time());
			
			if ($this->Mail_templates_model->addTemplate($add)) {
				$this->session->set_flashdata('alert', '<p class="success">Mail Template Added Sucessfully!</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="warning">Nothing Added!</p>');				
			}
							
			return TRUE;
		}	
	}

	public function _updateTemplate() {
    	if ( ! $this->user->hasPermissions('modify', 'admin/mail_templates')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to update!</p>');
  			return TRUE;
  	
    	} else if ($this->input->get('id') AND $this->validateForm() === TRUE) { 
			$update = array();
			
			$update['template_id'] 		= $this->input->get('id');
			$update['name'] 			= $this->input->post('name');
			$update['status'] 			= $this->input->post('status');
			$update['language_id'] 		= $this->input->post('language_id');
			$update['date_updated'] 	= mdate('%Y-%m-%d %H:%i:%s', time());
			
			if ($this->Mail_templates_model->updateTemplate($update)) {
				$this->session->set_flashdata('alert', '<p class="success">Mail Template Updated Sucessfully!</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="warning">Nothing Added!</p>');				
			}
							
			return TRUE;
		}	
	}	

	public function _updateTemplateData() {
    	if ( ! $this->user->hasPermissions('modify', 'admin/mail_templates')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to update!</p>');
  			return TRUE;
  	
    	} else if ($this->input->get('id') AND $this->input->get('message')) { 
			$this->form_validation->set_rules('subject', 'Subject', 'xss_clean|trim|required|min_length[2]|max_length[128]');
			$this->form_validation->set_rules('body', 'Body', 'required|min_length[3]');

			if ($this->form_validation->run() === TRUE) {
				$update = array();

				$update['template_id'] 		= $this->input->get('id');
				$update['code'] 			= $this->input->get('message');
				$update['subject'] 			= $this->input->post('subject');
				$update['body'] 			= preg_replace('~>\s+<~m', '><', $this->input->post('body'));
				$update['date_updated'] 	= mdate('%Y-%m-%d %H:%i:%s', time());
			
				if ($this->Mail_templates_model->updateTemplateData($update)) {
					$this->session->set_flashdata('alert', '<p class="success">Mail Template Message Updated Sucessfully!</p>');
				} else {
					$this->session->set_flashdata('alert', '<p class="warning">Nothing Added!</p>');				
				}
				
				return TRUE;
			} else {
				return FALSE;
			}		
		}	
	}	

	public function _deleteTemplate() {
    	if (!$this->user->hasPermissions('modify', 'admin/mail_templates')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to delete!</p>');
    	} else { 
			if (is_array($this->input->post('delete'))) {
				foreach ($this->input->post('delete') as $key => $value) {
					$template_id = $value;
					if ($template_id === '11') {
						$this->session->set_flashdata('alert', '<p class="success">Default Mail Template can not be deleted!</p>');
					} else {
						$this->Mail_templates_model->deleteTemplate($template_id);
						$this->session->set_flashdata('alert', '<p class="success">Mail Template Deleted Sucessfully!</p>');
					}
				}			
			}
		}
				
		return TRUE;
	}
	
	public function validateForm() {
		$this->form_validation->set_rules('name', 'Name', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		if (!$this->input->get('id')) {
			$this->form_validation->set_rules('clone_template_id', 'Clone Template', 'xss_clean|trim|required|integer');
		}
		$this->form_validation->set_rules('language_id', 'Language', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('status', 'Status', 'xss_clean|trim|required|integer');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}		
	}
}

/* End of file mail_templates.php */
/* Location: ./application/controllers/admin/mail_templates.php */