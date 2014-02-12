<?php
class Alerts extends CI_Controller {

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
		
		if ($this->config->item('page_limit')) {
			$filter['limit'] = $this->config->item('page_limit');
		}
				
		if ($this->user->getStaffId()) {
			$filter['staff_id'] = (int)$this->user->getStaffId();
		}

		$data['heading'] 			= 'Alerts';
		$data['sub_menu_delete'] 	= 'Delete';
		$data['text_empty'] 		= 'There are no alerts available.';

		//load ratings data into array
		$data['alerts'] = array();
		$results = $this->Messages_model->getAlertsList($filter);
		foreach ($results as $result) {					
			$data['alerts'][] = array(
				'message_id'	=> $result['message_id'],
				'date'			=> mdate('%d-%m-%Y', strtotime($result['date'])),
				'time' 			=> mdate('%H:%i', strtotime($result['time'])),
				'sender'		=> $result['staff_name'],
				'subject' 		=> $result['subject'],
				'body' 			=> substr(strip_tags(html_entity_decode($result['body'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..',
				'view'			=> $this->config->site_url('admin/alerts/view?id=' . $result['message_id'])
			);
		}
		
		$config['base_url'] 		= $this->config->site_url('admin/alerts');
		$config['total_rows'] 		= $this->Messages_model->alerts_record_count($filter);
		$config['per_page'] 		= $filter['limit'];
		$config['num_links'] 		= round($config['total_rows'] / $config['per_page']);
		
		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		//check if POST submit then remove quantity_id
		if ($this->input->post('delete') && $this->_deleteMessage() === TRUE) {
			
			redirect('admin/alerts');
		}	

		$regions = array(
			'admin/header',
			'admin/footer'
		);
		
		$this->template->regions($regions);
		$this->template->load('admin/alerts', $data);
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
		    redirect('admin/alerts');
		}

		$message_info = $this->Messages_model->viewAdminMessage($message_id);
		
		if ($message_info) {
			$data['heading'] 		= 'Alerts';
			$data['sub_menu_back'] 	= $this->config->site_url('admin/alerts');

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

		$regions = array(
			'admin/header',
			'admin/footer'
		);
		
		$this->template->regions($regions);
		$this->template->load('admin/alerts_view', $data);
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