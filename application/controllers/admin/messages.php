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
			
		if ( !file_exists(APPPATH .'/views/admin/messages.php')) { //check if file exists in views folder
			show_404(); // Whoops, show 404 error page!
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
		if ($this->input->get('page')) {
			$filter['page'] = (int) $this->input->get('page');
		} else {
			$filter['page'] = 1;
		}
		
		if ($this->config->item('config_page_limit')) {
			$filter['limit'] = $this->config->item('config_page_limit');
		}
				
		$data['heading'] 			= 'Messages';
		$data['sub_menu_add'] 		= 'Send';
		$data['sub_menu_delete'] 	= 'Delete';
		$data['sub_menu_list'] 		= '<li><a id="menu-add">Send Message</a></li>';
		$data['text_empty'] 		= 'There are no message(s).';

		$data['messages'] = array();
		$results = $this->Messages_model->getList($filter);
		foreach ($results as $result) {					
			$data['messages'][] = array(
				'message_id'	=> $result['message_id'],
				'date'			=> $result['date'],
				'time' 			=> $result['time'],
				'sender'		=> $result['staff_name'],
				'subject' 		=> $result['subject'],
				'body' 			=> substr(strip_tags(html_entity_decode($result['body'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..',
				'view'			=> $this->config->site_url('admin/messages/view/' . $result['message_id'])
			);
		}
		
		$data['staffs'] = array();
		$staffs = $this->Staffs_model->getStaffs();
		foreach ($staffs as $staff) {
			$data['staffs'][] = array(
				'staff_id'		=> $staff['staff_id'],
				'staff_name'	=> $staff['staff_name']
			);
		}
		
		$config['base_url'] 		= $this->config->site_url('admin/messages');
		$config['total_rows'] 		= $this->Messages_model->record_count();
		$config['per_page'] 		= $filter['limit'];
		$config['num_links'] 		= round($config['total_rows'] / $config['per_page']);
		
		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);
		
		// check POST submit, validate fields and send quantity data to model
		if ($this->input->post() && $this->_sendMessage() === TRUE) {
		
			redirect('admin/messages');
		}

		//check if POST submit then remove quantity_id
		if ($this->input->post('delete') && $this->_deleteMessage() === TRUE) {
			
			redirect('admin/messages');
		}	

		//load home page content
		$this->load->view('admin/header', $data);
		$this->load->view('admin/messages', $data);
		$this->load->view('admin/footer');
	}

	public function view() {
		
		if ( !file_exists(APPPATH .'/views/admin/messages_view.php')) { //check if file exists in views folder
			show_404(); // Whoops, show 404 error page!
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
		if ($this->uri->segment(4)) {
			$message_id = (int)$this->uri->segment(4);
		} else {
		    redirect('admin/messages');
		}

		$message_info = $this->Messages_model->viewAdminMessage($message_id);
		
		if ($message_info) {
			$data['heading'] 		= 'Messages';
			$data['sub_menu_back'] 	= $this->config->site_url('admin/messages');

			if (!empty($message_info['to'])) {
				$receiver = $this->Staffs_model->getStaff($message_info['to']);
				$to = $receiver['staff_name'];
			} else {
				$to = 'Customers';
			}
			
			$data['message_id'] 	= $message_info['message_id'];
			$data['date'] 			= mdate('%d-%m-%Y', strtotime($message_info['date']));
			$data['time'] 			= mdate('%H:%i', strtotime($message_info['time']));
			$data['sender'] 		= $message_info['staff_name'];
			$data['to'] 			= $to;
			$data['subject'] 		= $message_info['subject'];
			$data['body'] 			= $message_info['body'];
		}		

		//load customer_edit page content
		$this->load->view('admin/header', $data);
		$this->load->view('admin/messages_view', $data);
		$this->load->view('admin/footer');
	}

	public function _sendMessage() {

    	if (!$this->user->hasPermissions('modify', 'admin/messages')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
  			return TRUE;
    	
    	} else { 

			
			$date_format = '%Y-%m-%d';
			$time_format = '%h:%i';
			$current_date_time = time();
	
			//form validation
			$this->form_validation->set_rules('subject', 'Subject', 'trim|required|min_length[2]|max_length[128]');
			$this->form_validation->set_rules('body', 'Body', 'trim|required|min_length[10]');

			//if validation is true
			if ($this->form_validation->run() === TRUE) {
				$send = array();

				$send['date']	 	= mdate($date_format, $current_date_time);
				$send['time']	 	= mdate($time_format, $current_date_time);
				$send['sender']	 	= $this->user->getStaffId();

				//Sanitizing the POST values
				$to = $this->input->post('to');
				
				if ($to === 'customers') {
					$send['to'] = '0';
					$type = 'customers';
				}
				
				$send['subject']	= $this->input->post('subject');
				$send['body']		= $this->input->post('body');

				if ($this->Messages_model->sendMessage($type, $send)) {
			
					$this->session->set_flashdata('alert', '<p class="success">Message Sent Sucessfully!</p>');
			
				} else { 
			
					$this->session->set_flashdata('alert', '<p class="warning">Nothing Added!</p>');
			
				}

				return TRUE;
			}
		}	
	}

	public function _deleteMessage($menu_id = FALSE) {
    	if (!$this->user->hasPermissions('modify', 'admin/messages')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
    	
    	} else { 
		
			if (is_array($this->input->post('delete'))) {

				//sorting the post[quantity] array to rowid and qty.
				foreach ($this->input->post('delete') as $key => $value) {
					$message_id = $value;
				
					$this->Messages_model->deleteMessage($message_id);
				}			
			
				$this->session->set_flashdata('alert', '<p class="success">Message(s) Deleted Sucessfully!</p>');

			}
		}
				
		return TRUE;
	}
}