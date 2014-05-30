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

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		if ($this->input->post('message_state')) {
			$data['alert'] = $this->_updateMessageState($this->input->post('message_state'), '', $this->user->getStaffId());
		}
		
		$url = '?';
		$filter = array();
		if ($this->input->get('page')) {
			$filter['page'] = (int) $this->input->get('page');
		} else {
			$filter['page'] = '';
		}
		
		if ($this->config->item('page_limit')) {
			$filter['limit'] = $this->config->item('page_limit');
		}
		
		if ($this->input->get('filter_search')) {
			$filter['filter_search'] = $data['filter_search'] = $this->input->get('filter_search');
			$url .= 'filter_search='.$filter['filter_search'].'&';
		} else {
			$data['filter_search'] = '';
		}
		
		if (!empty($this->input->get('filter_label'))) {
			$filter['filter_label'] = $data['filter_label'] = $this->input->get('filter_label');
			$url .= 'filter_label='.$filter['filter_label'].'&';
		} else {
			$filter['filter_label'] = $data['filter_label'] = 'inbox';
		}

		if (!empty($this->input->get('filter_recipient'))) {
			$filter['filter_recipient'] = $data['filter_recipient'] = $this->input->get('filter_recipient');
			$url .= 'filter_recipient='.$filter['filter_recipient'].'&';
		} else {
			$filter['filter_recipient'] = $data['filter_recipient'] = '';
		}

		if (!empty($this->input->get('filter_type'))) {
			$filter['filter_type'] = $data['filter_type'] = $this->input->get('filter_type');
			$url .= 'filter_type='.$filter['filter_type'].'&';
		} else {
			$filter['filter_type'] = $data['filter_type'] = '';
		}

		if ($this->input->get('filter_label') === 'all' AND !$this->user->hasPermissions('access', 'admin/messages')) { 
			$data['alert'] = '<p class="warning">Warning: You do not have permission to view all message!</p>';
			$filter['filter_label'] = 'inbox';
			$data['filter_label'] = 'all';
		}
		
		$filter['filter_staff'] = $this->user->getStaffId();

		if ($this->input->get('filter_date')) {
			$filter['filter_date'] = $data['filter_date'] = $this->input->get('filter_date');
			$filter['filter_date'];
			$url .= 'filter_date='.$filter['filter_date'].'&';
		} else {
			$filter['filter_date'] = $data['filter_date'] = '';
		}
		
		if ($this->input->get('sort_by')) {
			$filter['sort_by'] = $data['sort_by'] = $this->input->get('sort_by');
		} else {
			$filter['sort_by'] = $data['sort_by'] = 'messages.date_added';
		}
		
		if ($this->input->get('order_by')) {
			$filter['order_by'] = $data['order_by'] = $this->input->get('order_by');
			$data['order_by_active'] = $this->input->get('order_by') .' active';
		} else {
			$filter['order_by'] = $data['order_by'] = 'DESC';
			$data['order_by_active'] = 'DESC';
		}
		
		$this->template->setTitle('Messages');
		$this->template->setHeading('Messages');
		$this->template->setButton('+ New', array('class' => 'add_button', 'href' => page_url() .'/edit'));

		$data['text_empty'] 		= 'There are no messages available.';

		$order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'ASC') ? 'DESC' : 'ASC';
		$data['sort_type'] 			= site_url('admin/messages'.$url.'sort_by=send_type&order_by='.$order_by);
		$data['sort_date'] 			= site_url('admin/messages'.$url.'sort_by=messages.date_added&order_by='.$order_by);

		$data['messages'] = array();
		$results = $this->Messages_model->getList($filter);
		foreach ($results as $result) {					
			$data['messages'][] = array(
				'message_id'	=> $result['message_id'],
				'from'			=> $result['staff_name'],
				'send_type'		=> $result['send_type'],
				'subject' 		=> $result['subject'],
				'recipient' 	=> ucwords(str_replace('_', ' ', $result['recipient'])),
				'date_added'	=> mdate('%H:%i - %d %M %y', strtotime($result['date_added'])),
				'body' 			=> substr(strip_tags(html_entity_decode($result['body'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..',
				'state'			=> (isset($result['state']) AND $result['state'] === '0') ? 'unread' : 'read',
				'view'			=> site_url('admin/messages/view?id=' . $result['message_id'])
			);
		}

		$data['message_dates'] = array();
		$message_dates = $this->Messages_model->getMessageDates();
		foreach ($message_dates as $message_date) {
			$month_year = '';
			$month_year = $message_date['year'].'-'.$message_date['month'];
			$data['message_dates'][$month_year] = mdate('%F %Y', strtotime($message_date['date_added']));
		}

		if ($this->input->get('sort_by') AND $this->input->get('order_by')) {
			$url .= 'sort_by='.$filter['sort_by'].'&';
			$url .= 'order_by='.$filter['order_by'].'&';
		}
		
		$config['base_url'] 		= site_url('admin/messages').$url;
		$config['total_rows'] 		= $this->Messages_model->record_count($filter);
		$config['per_page'] 		= $filter['limit'];
		
		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'messages.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'messages', $data);
		} else {
			$this->template->render('themes/admin/default/', 'messages', $data);
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

		if (is_numeric($this->input->get('id'))) {
			$message_id = $this->input->get('id');
		} else {
		    redirect('admin/messages');
		}

    	if (!$this->user->hasPermissions('access', 'admin/messages')) {
 			$message_info = $this->Messages_model->viewAdminMessage($message_id, $this->user->getStaffId());
 			$data['label'] = 'inbox';
 		} else {
 			$message_info = $this->Messages_model->viewAdminMessage($message_id);
 			$data['label'] = 'all';
		}
		
		if (!$message_info) {
		    redirect('admin/messages');
		}
		
		if ($this->input->post('message_state')) {
			$alert = $this->_updateMessageState($this->input->post('message_state'), $message_id, $this->user->getStaffId());
			$this->session->set_flashdata('alert', $alert);
		    redirect('admin/messages');
		} else if ($message_info['state'] !== '1') {
			$this->_updateMessageState('read', $message_id, $this->user->getStaffId());
		}

		$this->template->setTitle('Messages - View');
		$this->template->setHeading('Messages - View');
		$this->template->setBackButton('back_button', site_url('admin/messages'));

		$data['text_empty'] 	= 'There are no recipients available.';
		
		if ($message_info['status'] === '0') {
			$this->template->setButton('Resend', array('class' => 'white_button', 'onclick' => 'resendList()'));
			$this->template->setButton('Mark As Unread', array('class' => 'white_button', 'onclick' => 'markAsUnread()'));
			$this->template->setButton('Move To Inbox', array('class' => 'white_button', 'onclick' => 'moveToInbox()'));
		} else {
			$this->template->setButton('Resend', array('class' => 'white_button', 'onclick' => 'resendList()'));
			$this->template->setButton('Mark As Unread', array('class' => 'white_button', 'onclick' => 'markAsUnread()'));
			$this->template->setButton('Move To Trash', array('class' => 'delete_button', 'onclick' => 'moveToTrash()'));
		}
		
		$data['message_id'] 	= $message_info['message_id'];
		$data['date_added'] 	= mdate('%d %M %y - %H:%i', strtotime($message_info['date_added']));
		$data['send_type'] 		= ucwords($message_info['send_type']);
		$data['from'] 			= $message_info['staff_name'];
		$data['recipient'] 		= ucwords(str_replace('_', ' ', $message_info['recipient']));
		$data['subject'] 		= $message_info['subject'];
		$data['body'] 			= $message_info['body'];
		
		if ($data['label']) {
			$data['recipients'] = array();
			$recipients = $this->Messages_model->getMessageRecipients($message_id);
			foreach ($recipients as $recipient) {					
				$data['recipients'][] = array(
					'message_recipient_id'	=> $recipient['message_recipient_id'],
					'message_id'			=> $recipient['message_id'],
					'recipient_name'		=> (isset($recipient['first_name']) AND isset($recipient['last_name'])) ? $recipient['first_name'] .' '. $recipient['last_name'] : $recipient['staff_name'] ,
					'recipient_email'		=> (isset($recipient['customer_email'])) ? $recipient['customer_email'] : $recipient['staff_email'],
					'status'				=> ($recipient['status'] === '1') ? '<span class="green">Sent</span>' : '<span class="red">Failed</span>'
				);
			}
		}
		
		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'messages_view.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'messages_view', $data);
		} else {
			$this->template->render('themes/admin/default/', 'messages_view', $data);
		}
	}

	public function edit() {

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

		$this->template->setTitle('Message: Compose');
		$this->template->setHeading('Message: Compose');
		$this->template->setButton('Send', array('class' => 'save_button', 'onclick' => '$(\'form\').submit();'));
		$this->template->setBackButton('back_button', site_url('admin/messages'));

		$data['sub_menu_back'] 		= site_url('admin/messages');

		$this->load->model('Customer_groups_model');
		$data['customer_groups'] = array();
		$results = $this->Customer_groups_model->getCustomerGroups();
		foreach ($results as $result) {					
			$data['customer_groups'][] = array(
				'customer_group_id'	=>	$result['customer_group_id'],
				'group_name'		=>	$result['group_name']
			);
		}

		$this->load->model('Staff_groups_model');
		$data['staff_groups'] = array();
		$results = $this->Staff_groups_model->getStaffGroups();
		foreach ($results as $result) {					
			$data['staff_groups'][] = array(
				'staff_group_id'	=>	$result['staff_group_id'],
				'staff_group_name'	=>	$result['staff_group_name']
			);
		}

		if ($this->input->post() AND $this->_sendMessage() === TRUE) {
			redirect('admin/messages');
		}

		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'messages_edit.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'messages_edit', $data);
		} else {
			$this->template->render('themes/admin/default/', 'messages_edit', $data);
		}
	}

	public function _sendMessage() {
    	if (!$this->user->hasPermissions('modify', 'admin/messages')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to send message!</p>');
  			return TRUE;
    	} else if ($this->validateForm() === TRUE) { 
			$this->load->model('Customers_model');
			$add = array();
			$recipients = array();
				
			switch ($this->input->post('recipient')) {
			case 'all_newsletters':
				$results = $this->Customers_model->getCustomersByNewsletter();
		
				foreach ($results as $result) {
					$recipients['customer_ids'][] 		= $result['customer_id'];
					$recipients['customer_emails'][] 	= $result['email'];
				}
			
				break;
			case 'all_customers':
				$results = $this->Customers_model->getCustomers();
		
				foreach ($results as $result) {
					$recipients['customer_ids'][] 	= $result['customer_id'];
					$recipients['customer_emails'][] 	= $result['email'];
				}
			
				break;
			case 'customer_group':
				$results = $this->Customers_model->getCustomersByGroupId($this->input->post('customer_group_id'));
		
				foreach ($results as $result) {
					$recipients['customer_ids'][] 	= $result['customer_id'];
					$recipients['customer_emails'][] 	= $result['email'];
				}
			
				break;
			case 'customers':
				if ($this->input->post('customers')) {
					foreach ($this->input->post('customers') as $key => $customer_id) {
						$result = $this->Customers_model->getCustomer($customer_id);
		
						if ($result) {
							$recipients['customer_ids'][] 	= $result['customer_id'];
							$recipients['customer_emails'][] 	= $result['email'];
						}
					}
				}
			
				break;
			case 'all_staffs':
				$results = $this->Staffs_model->getStaffs();
		
				foreach ($results as $result) {
					$recipients['staff_ids'][] 		= $result['staff_id'];
					$recipients['staff_emails'][] 	= $result['staff_email'];
				}
			
				break;
			case 'staff_group':
				$results = $this->Staffs_model->getStaffsByGroupId($this->input->post('staff_group_id'));
		
				foreach ($results as $result) {
					$recipients['staff_ids'][] 		= $result['staff_id'];
					$recipients['staff_emails'][] 	= $result['staff_email'];
				}
			
				break;
			case 'staffs':
				if ($this->input->post('staffs')) {
					foreach ($this->input->post('staffs') as $key => $staff_id) {
						$result = $this->Staffs_model->getStaff($staff_id);
					
						if ($result) {
							$recipients['staff_ids'][] 		= $result['staff_id'];
							$recipients['staff_emails'][] 	= $result['staff_email'];
						}
					}
				}
			
				break;
			}		

			$add['send_type']		= $this->input->post('send_type');
			$add['staff_id_from']	= $this->user->getStaffId();
			$add['recipient'] 		= $this->input->post('recipient');
			$add['subject']			= $this->input->post('subject');
			$add['body']			= $this->input->post('body');
			$add['date_added']		= mdate('%Y-%m-%d %H:%i:%s', time());

			if ($this->Messages_model->addMessage($add, $recipients)) {
				$this->session->set_flashdata('alert', '<p class="success">Message Sent Sucessfully!</p>');
			} else { 
				$this->session->set_flashdata('alert', '<p class="warning">An error occured, nothing added.</p>');
			}

			return TRUE;
		}	
	}

	public function _updateMessageState($state = '', $message_id = '', $staff_id = '') {
    	if (is_numeric($staff_id)) {
			if ($state === 'unread') {
				$state = '0';
				$alert = 'has been marked as unread.';
			} else if ($state === 'read') {
				$state = '1';
				$alert = 'has been marked as read.';
			} else if ($state === 'inbox') {
				$state = 'inbox';
				$alert = 'has been moved to inbox.';
			} else if ($state === 'trash') {
				$state = 'trash';
				$alert = 'has been moved to trash.';
			}

			if ($state !== '') {
				if (is_array($this->input->post('delete'))) {
					$num = 0;
					foreach ($this->input->post('delete') as $key => $id) {
						$this->Messages_model->updateMessageState($id, $staff_id, $state);
						$num++;
					}			
				} else if (is_numeric($message_id)) {
					$this->Messages_model->updateMessageState($message_id, $staff_id, $state);
					$num = 1;
				}
				
				$num_message = ($num == 1) ? 'The message '.$alert : $num.' messages '.$alert;
				
				return '<p class="success">'. $num_message .'</p>';
			}
		}
	}

	public function validateForm() {
		$this->form_validation->set_rules('recipient', 'To', 'xss_clean|trim|required|min_length[2]|max_length[128]');
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