<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Mail_templates extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('user');
		$this->load->model('Mail_templates_model');
		$this->load->model('Settings_model');
	}

	public function index() {
		if (!$this->user->islogged()) {  
  			redirect(ADMIN_URI.'/login');
		}

    	if (!$this->user->hasPermissions('access', ADMIN_URI.'/mail_templates')) {
  			redirect(ADMIN_URI.'/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else {
			$data['alert'] = '';
		}

		if ($this->input->get('default') === '1' AND $this->input->get('template_id')) {
			$template_id = $this->input->get('template_id');
		
			if ($this->Settings_model->addSetting('themes', 'mail_template_id', $template_id, '0')) {
				$this->session->set_flashdata('alert', '<p class="alert-success">Mail Template set as default sucessfully!</p>');
			}
			
			redirect(ADMIN_URI.'/mail_templates');
		}

		$this->template->setTitle('Mail Templates');
		$this->template->setHeading('Mail Templates');
		$this->template->setButton('+ New', array('class' => 'btn btn-success', 'href' => page_url() .'/edit'));
		$this->template->setButton('Delete', array('class' => 'btn btn-default', 'onclick' => '$(\'#list-form\').submit();'));

		$data['text_empty'] 		= 'There are no mail templates available.';

		$results = $this->Mail_templates_model->getList();

		$data['templates'] = array();
		foreach ($results as $result) {
			if ($result['template_id'] !== $this->config->item('mail_template_id')) {
				$default = site_url(ADMIN_URI.'/mail_templates?default=1&template_id='. $result['template_id']);
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
				'edit'				=> site_url(ADMIN_URI.'/mail_templates/edit?id='. $result['template_id'])
			);		
		}

		if ($this->input->post('delete') AND $this->_deleteTemplate() === TRUE) {
			//redirect(ADMIN_URI.'/mail_templates');  			
		}	

		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme').'mail_templates.php')) {
			$this->template->render('themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme'), 'mail_templates', $data);
		} else {
			$this->template->render('themes/'.ADMIN_URI.'/default/', 'mail_templates', $data);
		}
	}

	public function edit() {
		if (!$this->user->islogged()) {  
  			redirect(ADMIN_URI.'/login');
		}

    	if (!$this->user->hasPermissions('access', ADMIN_URI.'/mail_templates')) {
  			redirect(ADMIN_URI.'/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else { 
			$data['alert'] = '';
		}		

		$template_info = $this->Mail_templates_model->getTemplate((int) $this->input->get('id'));
		
		if ($template_info) {
			$template_id = $template_info['template_id'];
			$data['action']	= site_url(ADMIN_URI.'/mail_templates/edit?id='. $template_id);
		} else {
		    $template_id = 0;
			$data['action']	= site_url(ADMIN_URI.'/mail_templates/edit');
		}
		
		$title = (isset($template_info['name'])) ? $template_info['name'] : 'New';	
		$this->template->setTitle('Mail Template: '. $title);
		$this->template->setHeading('Mail Template: '. $title);
		$this->template->setButton('Save', array('class' => 'btn btn-success', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton('Save & Close', array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setBackButton('btn-back', site_url(ADMIN_URI.'/mail_templates'));

		$data['text_empty'] 		= 'There is no template message available.';

		$data['template_id'] 		= $template_info['template_id'];
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
						'title'				=> $title,
						'code'				=> $tpl_data['code'],
						'subject'			=> $tpl_data['subject'],
						'date_added'		=> mdate('%d %M %y - %H:%i', strtotime($tpl_data['date_added'])),
						'date_updated'		=> mdate('%d %M %y - %H:%i', strtotime($tpl_data['date_updated'])),
						'edit'				=> site_url(ADMIN_URI.'/mail_templates/message?id='. $tpl_data['template_id'] .'&message='. $tpl_data['code'])
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
			if ($this->input->post('save_close') !== '1' AND is_numeric($this->input->post('insert_id'))) {	
				redirect(ADMIN_URI.'/mail_templates/edit?id='. $this->input->post('insert_id'));
			} else {
				redirect(ADMIN_URI.'/mail_templates');
			}
		}

		if ($this->input->post() AND $this->_updateTemplate() === TRUE) {
			if ($this->input->post('save_close') === '1') {
				redirect(ADMIN_URI.'/mail_templates');
			}
			
			redirect(ADMIN_URI.'/mail_templates/edit?id='. $template_id);
		}
		
		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme').'mail_templates_edit.php')) {
			$this->template->render('themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme'), 'mail_templates_edit', $data);
		} else {
			$this->template->render('themes/'.ADMIN_URI.'/default/', 'mail_templates_edit', $data);
		}
	}

	public function message() {
		if (!$this->user->islogged()) {  
  			redirect(ADMIN_URI.'/login');
		}

    	if (!$this->user->hasPermissions('access', ADMIN_URI.'/mail_templates')) {
  			redirect(ADMIN_URI.'/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else { 
			$data['alert'] = '';
		}		

		$result = $this->Mail_templates_model->getTemplateData((int) $this->input->get('id'), $this->input->get('message'));

		if (!$result) {
			redirect(ADMIN_URI.'/mail_templates');
		}
		
		$template_id = $result['template_id'];

		$title = (isset($result['name'])) ? $result['name'] : 'New';	
		$this->template->setTitle('Mail Template: '. $title);
		$this->template->setHeading('Mail Template: '. $title);
		$this->template->setButton('Save', array('class' => 'btn btn-success', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton('Save & Close', array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setBackButton('btn-back', site_url(ADMIN_URI.'/mail_templates/edit?id='. $template_id));

		$data['text_empty'] 		= 'There is no template message available.';
		$data['action']				= site_url(ADMIN_URI.'/mail_templates/message?id='. $result['template_id'] .'&message='. $result['code']);

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
				redirect(ADMIN_URI.'/mail_templates/edit?id='. $result['template_id']);
			}
			
			redirect(ADMIN_URI.'/mail_templates/message?id='. $result['template_id'] .'&message='. $result['code']);
		}
		
		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme').'mail_templates_message.php')) {
			$this->template->render('themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme'), 'mail_templates_message', $data);
		} else {
			$this->template->render('themes/'.ADMIN_URI.'/default/', 'mail_templates_message', $data);
		}
	}
	
	public function _addTemplate() {
    	if ( ! $this->user->hasPermissions('modify', ADMIN_URI.'/mail_templates')) {
			$this->session->set_flashdata('alert', '<p class="alert-warning">Warning: You do not have permission to add!</p>');
  			return TRUE;
    	} else if ( ! is_numeric($this->input->get('id')) AND $this->validateForm() === TRUE) { 
			$add = array();

			$add['name'] 				= $this->input->post('name');
			$add['status'] 				= $this->input->post('status');
			$add['language_id'] 		= $this->input->post('language_id');
			$add['clone_template_id'] 	= $this->input->post('clone_template_id');
			$add['date_added'] 			= mdate('%Y-%m-%d %H:%i:%s', time());
			$add['date_updated'] 		= mdate('%Y-%m-%d %H:%i:%s', time());
			
			if ($_POST['insert_id'] = $this->Mail_templates_model->addTemplate($add)) {
				$this->session->set_flashdata('alert', '<p class="alert-success">Mail Template added sucessfully.</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="alert-warning">An error occured, nothing added.</p>');				
			}
							
			return TRUE;
		}	
	}

	public function _updateTemplate() {
    	if ( ! $this->user->hasPermissions('modify', ADMIN_URI.'/mail_templates')) {
		
			$this->session->set_flashdata('alert', '<p class="alert-warning">Warning: You do not have permission to update!</p>');
  			return TRUE;
  	
    	} else if (is_numeric($this->input->get('id')) AND $this->validateForm() === TRUE) { 
			$update = array();
			
			$update['template_id'] 		= $this->input->get('id');
			$update['name'] 			= $this->input->post('name');
			$update['status'] 			= $this->input->post('status');
			$update['language_id'] 		= $this->input->post('language_id');
			$update['date_updated'] 	= mdate('%Y-%m-%d %H:%i:%s', time());
			
			if ($this->Mail_templates_model->updateTemplate($update)) {
				$this->session->set_flashdata('alert', '<p class="alert-success">Mail Template updated sucessfully.</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="alert-warning">An error occured, nothing added.</p>');				
			}
							
			return TRUE;
		}	
	}	

	public function _updateTemplateData() {
    	if ( ! $this->user->hasPermissions('modify', ADMIN_URI.'/mail_templates')) {
		
			$this->session->set_flashdata('alert', '<p class="alert-warning">Warning: You do not have permission to update!</p>');
  			return TRUE;
  	
    	} else if (is_numeric($this->input->get('id')) AND $this->input->get('message')) { 
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
					$this->session->set_flashdata('alert', '<p class="alert-success">Mail Template Message updated sucessfully.</p>');
				} else {
					$this->session->set_flashdata('alert', '<p class="alert-warning">An error occured, nothing added.</p>');				
				}
				
				return TRUE;
			} else {
				return FALSE;
			}		
		}	
	}	

	public function _deleteTemplate() {
    	if (!$this->user->hasPermissions('modify', ADMIN_URI.'/mail_templates')) {
			$this->session->set_flashdata('alert', '<p class="alert-warning">Warning: You do not have permission to delete!</p>');
    	} else if (is_array($this->input->post('delete'))) {
			foreach ($this->input->post('delete') as $key => $value) {
				if ($value === $this->config->item('mail_template_id')) {
					$this->session->set_flashdata('alert', '<p class="alert-success">Default Mail Template can not be deleted!</p>');
				} else {
					$this->Mail_templates_model->deleteTemplate($value);
					$this->session->set_flashdata('alert', '<p class="alert-success">Mail Template deleted sucessfully!</p>');
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