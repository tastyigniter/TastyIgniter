<?php
class Messages extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		$this->load->library('pagination');
		$this->load->model('Messages_model');
		$this->load->model('Staffs_model');
	}

	public function index() {
			
		if (!file_exists(APPPATH .'views/admin/messages.php')) {
			show_404();
		}
			
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/messages')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		$filter = array();
		if ($this->input->get('label')) {
			$filter['label'] = $this->input->get('label');
			$data['label'] = $filter['label'];
		} else {
			$filter['label'] = 'staffs';
			$data['label'] = 'inbox';
		}
		
		if ($this->input->get('page')) {
			$filter['page'] = (int) $this->input->get('page');
		} else {
			$filter['page'] = 1;
		}
		
		if ($this->config->item('page_limit')) {
			$filter['limit'] = $this->config->item('page_limit');
		}
		
		$data['heading'] 			= 'Messages';
		$data['sub_menu_delete'] 	= 'Delete';
		$data['sub_menu_add'] 		= 'Send Message';
		$data['text_empty'] 		= 'There are no messages available.';

		$data['messages'] = array();
		$results = $this->Messages_model->getList($filter);
		foreach ($results as $result) {					
			$data['messages'][] = array(
				'message_id'	=> $result['message_id'],
				'sender'		=> $result['staff_name'],
				'subject' 		=> $result['subject'],
				'date'			=> mdate('%d %M %y - %H:%i', strtotime($result['date'])),
				'body' 			=> substr(strip_tags(html_entity_decode($result['body'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..',
				'view'			=> $this->config->site_url('admin/messages/view?id=' . $result['message_id'])
			);
		}
		
		$data['labels'] = array(
			'inbox' => $this->config->site_url('admin/messages'), 
			'sent' => $this->config->site_url('admin/messages?label=sent'),
			'draft' => $this->config->site_url('admin/messages?label=draft')
		);

		$config['base_url'] 		= $this->config->site_url('admin/messages');
		$config['total_rows'] 		= $this->Messages_model->record_count($filter);
		$config['per_page'] 		= $filter['limit'];
		$config['num_links'] 		= round($config['total_rows'] / $config['per_page']);
		
		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);
		
		if ($this->input->post('delete') && $this->_deleteMessage() === TRUE) {
			redirect('admin/messages');
		}	

		$regions = array(
			'admin/header',
			'admin/footer'
		);
		
		$this->template->regions($regions);
		$this->template->load('admin/messages', $data);
	}

	public function view() {
		
		if (!file_exists(APPPATH .'views/admin/messages_view.php')) {
			show_404();
		}
			
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		//check if customer_id is set in uri string
		if (is_numeric($this->input->get('id'))) {
			$message_id = (int)$this->input->get('id');
		} else {
		    redirect('admin/messages');
		}

		$data['heading'] 		= 'Messages';
		$data['sub_menu_back'] 	= $this->config->site_url('admin/messages');

		$message_info = $this->Messages_model->viewAdminMessage($message_id);
		
		if ($message_info) {
			if ($message_info['label'] === 'customers') {
				$receiver = 'All Customers';
			} else if ($message_info['label'] === 'staffs') {
				$receiver = 'All Staffs';
			} else {
				$receiver = 'No Label';
			}
			
			$data['message_id'] 	= $message_info['message_id'];
			$data['date'] 			= mdate('%d %M %y - %H:%i', strtotime($message_info['date']));
			$data['sender'] 		= $message_info['staff_name'];
			$data['receiver'] 		= $receiver;
			$data['subject'] 		= $message_info['subject'];
			$data['body'] 			= $message_info['body'];
		}		

		$regions = array('admin/header', 'admin/footer');
		$this->template->regions($regions);
		$this->template->load('admin/messages_view', $data);
	}

	public function edit() {
		
		if (!file_exists(APPPATH .'views/admin/messages_edit.php')) {
			show_404();
		}
			
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		$data['heading'] 			= 'Messages';
		$data['sub_menu_save'] 		= 'Send';
		$data['sub_menu_back'] 		= $this->config->site_url('admin/messages');

		$data['default_location_id'] = $this->config->item('default_location_id');

		$this->load->model('Locations_model');	    
		$data['locations'] = array();
		$results = $this->Locations_model->getLocations();
		foreach ($results as $result) {					
			$data['locations'][] = array(
				'location_id'	=>	$result['location_id'],
				'location_name'	=>	$result['location_name'],
			);
		}
	
		if ($this->input->post() && $this->_sendMessage() === TRUE) {
			redirect('admin/messages');
		}

		$regions = array(
			'admin/header',
			'admin/footer'
		);
		
		$this->template->regions($regions);
		$this->template->load('admin/messages_edit', $data);
	}

	public function _sendMessage() {
    	if (!$this->user->hasPermissions('modify', 'admin/messages')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have the right permission to edit!</p>');
  			return TRUE;
    	} else if ($this->validateForm() === TRUE) { 
			$send = array();
			$send['sender']		= $this->user->getStaffId();
			$send['label'] 		= $this->input->post('receiver');
			$send['subject']	= $this->input->post('subject');
			$send['body']		= $this->input->post('body');

			if ($this->Messages_model->sendMessage($send)) {
				$this->session->set_flashdata('alert', '<p class="success">Message Sent Sucessfully!</p>');
			} else { 
				$this->session->set_flashdata('alert', '<p class="warning">Nothing Added!</p>');
			}

			return TRUE;
		}	
	}

	public function _deleteMessage($menu_id = FALSE) {
    	if (!$this->user->hasPermissions('modify', 'admin/messages')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have the right permission to edit!</p>');
    	} else { 
			if (is_array($this->input->post('delete'))) {
				foreach ($this->input->post('delete') as $key => $value) {
					$message_id = $value;
					$this->Messages_model->deleteMessage($message_id);
				}			
			
				$this->session->set_flashdata('alert', '<p class="success">Message(s) Deleted Sucessfully!</p>');
			}
		}
				
		return TRUE;
	}

	public function validateForm() {
		$this->form_validation->set_rules('receiver', 'To', 'trim|required|min_length[2]|max_length[128]');
		$this->form_validation->set_rules('subject', 'Subject', 'trim|required|min_length[2]|max_length[128]');
		$this->form_validation->set_rules('body', 'Body', 'encode_php_tags|prep_for_form|htmlspecialchars|required|min_length[3]');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}		
	}
}