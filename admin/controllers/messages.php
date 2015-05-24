<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Messages extends Admin_Controller {

    public $_permission_rules = array('access[index|edit]', 'modify[index|edit]');

    public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('pagination');
		$this->load->model('Messages_model');
		$this->load->model('Staffs_model');
	}

	public function index() {
		if ($this->input->post('message_state')) {
			if ($alert_msg = $this->_updateMessageState($this->input->post('message_state'), '', $this->user->getStaffId())) {
                $this->alert->set('success', $alert_msg);
                redirect(current_url());
            }
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

		if ($this->input->get('filter_folder')) {
			$filter['filter_folder'] = $data['filter_folder'] = $this->input->get('filter_folder');
			$url .= 'filter_folder='.$filter['filter_folder'].'&';
		} else {
			$filter['filter_folder'] = $data['filter_folder'] = 'inbox';
		}

		if ($this->input->get('filter_recipient')) {
			$filter['filter_recipient'] = $data['filter_recipient'] = $this->input->get('filter_recipient');
			$url .= 'filter_recipient='.$filter['filter_recipient'].'&';
		} else {
			$filter['filter_recipient'] = $data['filter_recipient'] = '';
		}

		if ($this->input->get('filter_type')) {
			$filter['filter_type'] = $data['filter_type'] = $this->input->get('filter_type');
			$url .= 'filter_type='.$filter['filter_type'].'&';
		} else {
			$filter['filter_type'] = $data['filter_type'] = '';
		}

		if ($this->input->get('filter_folder') === 'all' AND !$this->user->hasPermissions('access', 'messages')) {
			$data['alert'] = '<p class="alert-warning">Warning: You do not have permission to view all message!</p>';
			$filter['filter_folder'] = 'inbox';
			$data['filter_folder'] = 'all';
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
		$this->template->setButton('+ Compose', array('class' => 'btn btn-primary', 'href' => page_url() .'/edit'));

		$data['text_empty'] 		= 'There are no messages available.';

		$order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'ASC') ? 'DESC' : 'ASC';
		$data['sort_type'] 			= site_url('messages'.$url.'sort_by=send_type&order_by='.$order_by);
		$data['sort_date'] 			= site_url('messages'.$url.'sort_by=messages.date_added&order_by='.$order_by);

		$data['messages'] = array();
		$results = $this->Messages_model->getList($filter);
		foreach ($results as $result) {
			$data['messages'][] = array(
				'message_id'	=> $result['message_id'],
				'from'			=> $result['staff_name'],
				'send_type'		=> $result['send_type'],
				'type_icon'		=> (isset($result['send_type']) AND $result['send_type'] === 'account') ? 'user' : 'envelope',
                'subject' 	    => (strlen($result['subject']) > 30) ? substr(strip_tags(html_entity_decode($result['subject'], ENT_QUOTES, 'UTF-8')), 0, 30) . '..' : strip_tags(html_entity_decode($result['subject'], ENT_QUOTES, 'UTF-8')),
                'recipient' 	=> ucwords(str_replace('_', ' ', $result['recipient'])),
				'date_added'	=> day_elapsed($result['date_added']),
				'body' 			=> (strlen($result['body']) > 40) ? substr(strip_tags(html_entity_decode($result['body'], ENT_QUOTES, 'UTF-8')), 0, 40) . '..' : strip_tags(html_entity_decode($result['body'], ENT_QUOTES, 'UTF-8')),
				'state'			=> (isset($result['state']) AND $result['state'] === '1') ? 'message-read' : 'message-unread',
				'view'			=> site_url('messages/view?id=' . $result['message_id'])
			);
		}

		$message_unread = $this->user->unreadMessageTotal();
		$data['folders'] = array(
			'inbox' => array('icon' => 'fa-inbox', 'badge' => $message_unread, 'url' => site_url('messages?filter_folder=inbox')),
			'draft' => array('icon' => 'fa-file-text-o', 'badge' => '', 'url' => site_url('messages?filter_folder=draft')),
			'sent' => array('icon' => 'fa-paper-plane-o', 'badge' => '', 'url' => site_url('messages?filter_folder=sent')),
			'all' 	=> array('icon' => 'fa-briefcase', 'badge' => '', 'url' => site_url('messages?filter_folder=all')),
            'trash' => array('icon' => 'fa-trash-o', 'badge' => '', 'url' => site_url('messages?filter_folder=trash'))
		);

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

		$config['base_url'] 		= site_url('messages').$url;
		$config['total_rows'] 		= $this->Messages_model->getCount($filter);
		$config['per_page'] 		= $filter['limit'];

		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('messages', $data);
	}

	public function view() {
    	if (!$this->user->hasPermissions('access', 'messages')) {
 			$message_info = $this->Messages_model->viewMessage((int) $this->input->get('id'), $this->user->getStaffId());
 			$data['label'] = 'inbox';
 		} else {
 			$message_info = $this->Messages_model->viewMessage((int) $this->input->get('id'));
 			$data['label'] = 'all';
		}

		if ($message_info) {
			$message_id = $message_info['message_id'];
		} else {
		    redirect('messages');
		}

		if (!$message_info) {
		    redirect('messages');
		}

		if ($this->input->post('message_state')) {
			if ($alert_msg = $this->_updateMessageState($this->input->post('message_state'), $message_id, $this->user->getStaffId())) {
                $this->alert->set('success', $alert_msg);
                redirect(current_url());
            }
		} else if ($message_info['state'] !== '1') {
			$this->_updateMessageState('read', $message_id, $this->user->getStaffId());
		}

        $message_unread = $this->user->unreadMessageTotal();
        $data['folders'] = array(
            'inbox' => array('icon' => 'fa-inbox', 'badge' => $message_unread, 'url' => site_url('messages?filter_folder=inbox')),
            'draft' => array('icon' => 'fa-file-text-o', 'badge' => '', 'url' => site_url('messages?filter_folder=draft')),
            'sent' => array('icon' => 'fa-paper-plane-o', 'badge' => '', 'url' => site_url('messages?filter_folder=sent')),
            'all' 	=> array('icon' => 'fa-briefcase', 'badge' => '', 'url' => site_url('messages?filter_folder=all')),
            'trash' => array('icon' => 'fa-trash-o', 'badge' => '', 'url' => site_url('messages?filter_folder=trash'))
        );

        $this->template->setTitle('Messages - View');
		$this->template->setHeading('Messages - View');
		$this->template->setBackButton('btn btn-back', site_url('messages'));

		$data['text_empty'] 	= 'There are no recipients available.';

		if ($message_info['status'] === '0') {
			$this->template->setButton('Resend', array('class' => 'btn btn-default', 'onclick' => 'resendList()'));
			$this->template->setButton('Mark As Unread', array('class' => 'btn btn-default', 'onclick' => 'markAsUnread()'));
			$this->template->setButton('Move To Inbox', array('class' => 'btn btn-default', 'onclick' => 'moveToInbox()'));
		} else {
			$this->template->setButton('Resend', array('class' => 'btn btn-default', 'onclick' => 'resendList()'));
			$this->template->setButton('Mark As Unread', array('class' => 'btn btn-default', 'onclick' => 'markAsUnread()'));
			$this->template->setButton('Move To Trash', array('class' => 'btn btn-default', 'onclick' => 'moveToTrash()'));
		}

		$data['message_id'] 	= $message_info['message_id'];
		$data['date_added'] 	= mdate('%H:%i - %d %M %y', strtotime($message_info['date_added']));
		$data['send_type'] 		= ucwords($message_info['send_type']);
		$data['from'] 			= $message_info['staff_name'];
		$data['recipient'] 		= ucwords(str_replace('_', ' ', $message_info['recipient']));
		$data['subject'] 		= $message_info['subject'];
        $data['body'] 			= $message_info['body'];
        $data['message_deleted'] = ($message_info['status'] === '0') ? TRUE : FALSE;

		if ($data['label']) {
			$data['recipients'] = array();
			$recipients = $this->Messages_model->getRecipients($message_id);
                if ($recipients) {
                    foreach ($recipients as $recipient) {
                        $data['recipients'][] = array(
                            'message_recipient_id'	=> $recipient['message_recipient_id'],
                            'message_id'			=> $recipient['message_id'],
                            'recipient_name'		=> (isset($recipient['first_name']) AND isset($recipient['last_name'])) ? $recipient['first_name'] .' '. $recipient['last_name'] : $recipient['staff_name'] ,
                            'recipient_email'		=> (isset($recipient['customer_email'])) ? $recipient['customer_email'] : $recipient['staff_email'],
                            'status'				=> ($recipient['status'] === '1') ? '<i class="fa fa-check-square green"></i>' : '<i class="fa fa-exclamation-circle red"></i>'
                        );
                    }
                }

		}

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('messages_view', $data);
	}

	public function edit() {
		$this->template->setTitle('Message: Compose');
		$this->template->setHeading('Message: Compose');
		$this->template->setButton('Send', array('class' => 'btn btn-success', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setBackButton('btn btn-back', site_url('messages'));

        $this->template->setScriptTag(root_url('assets/js/tinymce/tinymce.min.js'), 'tinymce-js', '111');

		$data['sub_menu_back'] 		= site_url('messages');

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

        $message_unread = $this->user->unreadMessageTotal();
        $data['folders'] = array(
            'inbox' => array('icon' => 'fa-inbox', 'badge' => $message_unread, 'url' => site_url('messages?filter_folder=inbox')),
            'draft' => array('icon' => 'fa-file-text-o', 'badge' => '', 'url' => site_url('messages?filter_folder=draft')),
            'sent' => array('icon' => 'fa-paper-plane-o', 'badge' => '', 'url' => site_url('messages?filter_folder=sent')),
            'all' 	=> array('icon' => 'fa-briefcase', 'badge' => '', 'url' => site_url('messages?filter_folder=all')),
            'trash' => array('icon' => 'fa-trash-o', 'badge' => '', 'url' => site_url('messages?filter_folder=trash'))
        );

        if ($this->input->post() AND $this->_sendMessage() === TRUE) {
			redirect('messages');
		}

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('messages_edit', $data);
	}

	private function _sendMessage() {
    	if ($this->validateForm() === TRUE) {
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

			if ($this->Messages_model->sendMessage($add, $recipients)) {
				$this->alert->set('success', 'Message Sent successfully.');
			} else {
				$this->alert->set('warning', 'An error occurred, nothing added.');
			}

			return TRUE;
		}
	}

	private function _updateMessageState($state = '', $message_id = '', $staff_id = '') {
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
				$num = 0;
				if (is_array($this->input->post('delete'))) {
                    foreach ($this->input->post('delete') as $key => $id) {
						$this->Messages_model->updateState($id, $staff_id, $state);
						$num++;
					}
				} else if (is_numeric($message_id)) {
                    $this->Messages_model->updateState($message_id, $staff_id, $state);
                    $num = 1;
                }

                if ($num > 0) {
					$num_message = ($num == 1) ? 'The message '.$alert : $num.' messages '.$alert;
                    return $num_message;
				}
			}
		}

        return FALSE;
	}

	private function validateForm() {
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
/* Location: ./admin/controllers/messages.php */