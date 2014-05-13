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

		$url = '?';
		$filter = array();
		if ($this->input->get('filter_label')) {
			$filter['filter_label'] = $this->input->get('filter_label');
			$data['filter_label'] = $filter['filter_label'];
			$url .= 'filter_label='.$filter['filter_label'].'&';
		} else {
			$filter['filter_label'] = 'staffs';
			$data['filter_label'] = '';
		}
		
		if ($this->input->get('page')) {
			$filter['page'] = (int) $this->input->get('page');
		} else {
			$filter['page'] = '';
		}
		
		if ($this->config->item('page_limit')) {
			$filter['limit'] = $this->config->item('page_limit');
		}
		
		if ($this->input->get('filter_search')) {
			$filter['filter_search'] = $this->input->get('filter_search');
			$data['filter_search'] = $filter['filter_search'];
			$url .= 'filter_search='.$filter['filter_search'].'&';
		} else {
			$data['filter_search'] = '';
		}
		
		$data['heading'] 			= 'Messages';
		$data['button_delete'] 		= 'Delete';
		$data['button_add'] 		= 'Send Message';
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
				'view'			=> site_url('admin/messages/view?id=' . $result['message_id'])
			);
		}

		$config['base_url'] 		= site_url('admin/messages').$url;
		$config['total_rows'] 		= $this->Messages_model->record_count($filter);
		$config['per_page'] 		= $filter['limit'];
		
		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);
		
		if ($this->input->post('delete') && $this->_deleteMessage() === TRUE) {
			redirect('admin/messages');
		}	

		$regions = array('header', 'footer');
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'messages.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'messages', $regions, $data);
		} else {
			$this->template->render('themes/admin/default/', 'messages', $regions, $data);
		}
	}

	public function view() {
			
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
		$data['sub_menu_back'] 	= site_url('admin/messages');

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

		$regions = array('header', 'footer');
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'messages_view.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'messages_view', $regions, $data);
		} else {
			$this->template->render('themes/admin/default/', 'messages_view', $regions, $data);
		}
	}

	public function edit() {

		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		$data['heading'] 			= 'Messages - Send Message';
		$data['button_save'] 		= 'Send';
		$data['sub_menu_back'] 		= site_url('admin/messages');

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

		$regions = array('header', 'footer');
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'messages_edit.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'messages_edit', $regions, $data);
		} else {
			$this->template->render('themes/admin/default/', 'messages_edit', $regions, $data);
		}
	}

	public function _sendMessage() {
    	if (!$this->user->hasPermissions('modify', 'admin/messages')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to send message!</p>');
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
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to delete!</p>');
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
		$this->form_validation->set_rules('receiver', 'To', 'xss_clean|trim|required|min_length[2]|max_length[128]');
		$this->form_validation->set_rules('subject', 'Subject', 'xss_clean|trim|required|min_length[2]|max_length[128]');
		$this->form_validation->set_rules('body', 'Body', 'required|min_length[3]');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}		
	}
}

/* End of file messages.php */
/* Location: ./application/controllers/admin/messages.php */