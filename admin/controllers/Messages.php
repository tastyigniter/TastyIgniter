<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Messages extends Admin_Controller {

    public function __construct() {
		parent::__construct(); //  calls the constructor

        $this->load->library('pagination');

        $this->load->model('Messages_model');
        $this->load->model('Staffs_model');

        $this->lang->load('messages');
    }

	public function index() {
        $filter = array();
        $filter['filter_folder'] = $data['filter_folder'] = 'inbox';
        $data['page_uri'] = 'messages';

        $this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), 'Inbox'));
        $this->template->setButton($this->lang->line('button_compose'), array('class' => 'btn btn-primary', 'href' => site_url('messages/compose')));

        $data = $this->getList($data, $filter);

		$this->template->render('messages', $data);
	}

    public function all() {
        $this->user->restrict('Admin.Messages');

        $filter = array();
        $filter['filter_folder'] = $data['filter_folder'] = 'all';
        $data['page_uri'] = 'messages/all';

        $this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), 'All'));
        $this->template->setButton($this->lang->line('button_compose'), array('class' => 'btn btn-primary', 'href' => site_url('messages/compose')));
        $this->template->setButton($this->lang->line('button_delete'), array('class' => 'btn btn-danger', 'onclick' => '$(\'#message-form\').submit();'));

        $data = $this->getList($data, $filter);

        $this->template->setPartials(array('header', 'footer'));
        $this->template->render('messages', $data);
	}

    public function draft() {
        $this->user->restrict('Admin.Messages');

        $filter = array();
        $filter['filter_folder'] = $data['filter_folder'] = 'draft';
        $data['page_uri'] = 'messages/draft';

        $this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), 'Draft'));
        $this->template->setButton($this->lang->line('button_compose'), array('class' => 'btn btn-primary', 'href' => site_url('messages/compose')));

        $data = $this->getList($data, $filter);

        $this->template->setPartials(array('header', 'footer'));
        $this->template->render('messages', $data);
	}

    public function sent() {
        $filter = array();
        $filter['filter_folder'] = $data['filter_folder'] = 'sent';
        $data['page_uri'] = 'messages/sent';

        $this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), 'Sent'));
        $this->template->setButton($this->lang->line('button_compose'), array('class' => 'btn btn-primary', 'href' => site_url('messages/compose')));

        $data = $this->getList($data, $filter);

        $this->template->setPartials(array('header', 'footer'));
        $this->template->render('messages', $data);
	}

    public function archive() {
        $filter = array();
        $filter['filter_folder'] = $data['filter_folder'] = 'archive';
        $data['page_uri'] = 'messages/sent';

        $this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), 'Archive'));
        $this->template->setButton($this->lang->line('button_compose'), array('class' => 'btn btn-primary', 'href' => site_url('messages/compose')));

        $data = $this->getList($data, $filter);

        $this->template->setPartials(array('header', 'footer'));
        $this->template->render('messages', $data);
	}

    public function view() {
    	if (!$this->user->hasPermission('Admin.Messages.Access')) {
 			$message_info = $this->Messages_model->viewMessage((int) $this->input->get('id'), $this->user->getStaffId());
 		} else {
 			$message_info = $this->Messages_model->viewMessage((int) $this->input->get('id'));
		}

		if (!$message_info) {
            redirect('messages');
        }

        $message_id = $message_info['message_id'];

        if ($this->input->post('message_state')) {
			if ($this->_updateMessageState($this->input->post('message_state'), $message_id, $this->user->getStaffId()) === TRUE) {
                redirect('messages');
            }
		} else if ($message_info['state'] !== '1') {
			$this->_updateMessageState('read', $message_id, $this->user->getStaffId(), FALSE);
		}

        $message_unread = $this->user->unreadMessageTotal();
        $data['folders'] = array(
            'inbox' => array('title' => $this->lang->line('text_inbox'), 'icon' => 'fa-inbox', 'badge' => $message_unread, 'url' => site_url('messages')),
            'draft' => array('title' => $this->lang->line('text_draft'), 'icon' => 'fa-file-text-o', 'badge' => '', 'url' => site_url('messages/draft')),
            'sent' => array('title' => $this->lang->line('text_sent'), 'icon' => 'fa-paper-plane-o', 'badge' => '', 'url' => site_url('messages/sent')),
            'all' 	=> array('title' => $this->lang->line('text_all'), 'icon' => 'fa-briefcase', 'badge' => '', 'url' => site_url('messages/all')),
            'archive' 	=> array('title' => $this->lang->line('text_archive'), 'icon' => 'fa-archive', 'badge' => '', 'url' => site_url('messages/archive')),
        );

        $data['labels'] = array(
            'account' => array('title' => $this->lang->line('text_account'), 'icon' => 'fa-circle-o text-primary', 'url' => page_url().'?filter_type=account'),
            'email' => array('title' => $this->lang->line('text_email'), 'icon' => 'fa-circle-o text-danger', 'url' => page_url().'?filter_type=email'),
        );

        $this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $this->lang->line('text_view')));
		$this->template->setBackButton('btn btn-back', site_url('messages'));

		$data['message_id'] 	= $message_info['message_id'];
		$data['date_added'] 	= mdate('%H:%i - %d %M %y', strtotime($message_info['date_added']));
		$data['send_type'] 		= ucwords($message_info['send_type']);
		$data['from'] 			= $message_info['staff_name'];
		$data['recipient'] 		= ucwords(str_replace('_', ' ', $message_info['recipient']));
		$data['subject'] 		= $message_info['subject'];
        $data['body'] 			= $message_info['body'];
        $data['message_deleted'] = ($message_info['status'] === '0') ? TRUE : FALSE;

        $data['recipients'] = array();
        $recipients = $this->Messages_model->getRecipients($message_id);
        if ($recipients) {
            foreach ($recipients as $recipient) {
                $data['recipients'][] = array(
                    'message_recipient_id'	=> $recipient['message_recipient_id'],
                    'message_id'			=> $recipient['message_id'],
                    'recipient_name'		=> (!empty($recipient['first_name']) AND !empty($recipient['last_name'])) ? $recipient['first_name'] .' '. $recipient['last_name'] : $recipient['staff_name'] ,
                    'recipient_email'		=> (!empty($recipient['customer_email'])) ? $recipient['customer_email'] : $recipient['staff_email'],
                    'status'				=> ($recipient['status'] === '1') ? '<i class="fa fa-check-square green"></i>' : '<i class="fa fa-exclamation-circle red"></i>'
                );
            }
        }

		$this->template->render('messages_view', $data);
	}

	public function compose() {
        $this->user->restrict('Admin.Messages');

        $message_info = $this->Messages_model->getDraftMessage((int)$this->input->get('id'));

        if ($message_info) {
            $message_id = $message_info['message_id'];
            $data['_action']	= site_url('messages/compose?id='. $message_id);
        } else {
            $message_id = 0;
            $data['_action']	= site_url('messages/compose');
        }

        if ($this->input->get('id') AND !$message_info) {
            redirect('messages');
        }

        $this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), 'Compose'));
		$this->template->setButton($this->lang->line('button_send'), array('class' => 'btn btn-success', 'onclick' => '$(\'#compose-form\').submit();'));
        $this->template->setButton($this->lang->line('button_save_draft'), array('class' => 'btn btn-default', 'onclick' => 'saveAsDraft();'));
        $this->template->setBackButton('btn btn-back', site_url('messages'));

        $this->template->setScriptTag(root_url('assets/js/tinymce/tinymce.min.js'), 'tinymce-js', '111');

		$data['sub_menu_back'] 		= site_url('messages');

        if ($this->input->post('recipient')) {
            $data['recipient'] = $this->input->post('recipient');
        } else {
            $data['recipient'] = $message_info['recipient'];
        }

        if ($this->input->post('send_type')) {
            $data['send_type'] = $this->input->post('send_type');
        } else {
            $data['send_type'] = $message_info['send_type'];
        }

        $data['subject'] 			= $message_info['subject'];
        $data['body'] 			    = $message_info['body'];

        $data['recipients']     = array(
            'all_newsletters'   =>  $this->lang->line('text_all_customers'),
            'customer_group'    =>  $this->lang->line('text_customer_group'),
            'customers'         =>  $this->lang->line('text_customers'),
            'all_staffs'        =>  $this->lang->line('text_all_staffs'),
            'staff_group'       =>  $this->lang->line('text_staff_group'),
            'staffs'            =>  $this->lang->line('text_staffs')
        );

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
            'inbox' => array('title' => $this->lang->line('text_inbox'), 'icon' => 'fa-inbox', 'badge' => $message_unread, 'url' => site_url('messages')),
            'draft' => array('title' => $this->lang->line('text_draft'), 'icon' => 'fa-file-text-o', 'badge' => '', 'url' => site_url('messages/draft')),
            'sent' => array('title' => $this->lang->line('text_sent'), 'icon' => 'fa-paper-plane-o', 'badge' => '', 'url' => site_url('messages/sent')),
            'all' 	=> array('title' => $this->lang->line('text_all'), 'icon' => 'fa-briefcase', 'badge' => '', 'url' => site_url('messages/all')),
            'archive' 	=> array('title' => $this->lang->line('text_archive'), 'icon' => 'fa-archive', 'badge' => '', 'url' => site_url('messages/archive')),
        );

        $data['labels'] = array(
            'account' => array('title' => $this->lang->line('text_account'), 'icon' => 'fa-circle-o text-primary', 'url' => page_url().'?filter_type=account'),
            'email' => array('title' => $this->lang->line('text_email'), 'icon' => 'fa-circle-o text-danger', 'url' => page_url().'?filter_type=email'),
        );

        if ($this->input->post() AND $message_id = $this->_saveMessage()) {
            if ($this->input->post('save_as_draft') === '1') {
                redirect('messages/compose?id='.$message_id);
            }

			redirect('messages');
		}

		$this->template->render('messages_compose', $data);
	}

    public function latest() {
        $filter = array();
        $filter['filter_folder'] = $data['filter_folder'] = 'inbox';
        $data['page_uri'] = 'messages/latest';
        $this->config->set_item('page_limit', '10');

        $data = $this->getList($data, $filter);

        $this->template->render('messages_latest', $data);
    }

    private function _saveMessage() {
    	if ($this->validateForm() === TRUE) {
            $save_type = (is_numeric($this->input->post('save_as_draft'))) ? 'saved to draft' : 'sent';

			if ($message_id = $this->Messages_model->saveMessage($this->input->get('id'), $this->input->post())) {
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Message '.$save_type));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
			}

			return $message_id;
		}
	}

	private function _updateMessageState($state = '', $message_id = '', $staff_id = '', $display_error = TRUE) {
    	if (is_numeric($staff_id)) {
			if ($state === 'unread') {
				$alert = $this->lang->line('alert_mark_as_unread');
			} else if ($state === 'read') {
				$alert = $this->lang->line('alert_mark_as_read');
			} else if ($state === 'inbox') {
				$alert = $this->lang->line('alert_move_to_inbox');
			} else if ($state === 'archive') {
				$alert = $this->lang->line('alert_move_to_archive');
			}

			if ($state !== '') {
				$num = 0;
				if (is_array($this->input->post('delete'))) {
                    $this->Messages_model->updateState($this->input->post('delete'), $staff_id, $state);
                    foreach ($this->input->post('delete') as $key => $id) {
						$num++;
					}
				} else if (is_numeric($message_id)) {
                    $this->Messages_model->updateState(array($message_id), $staff_id, $state);
                    $num = 1;
                }

                if ($num > 0) {
                    $alert_msg = ($num == 1) ? 'Message '.$alert : $num.' messages '.$alert;

                    if ($display_error === TRUE) $this->alert->set('success', $alert_msg);

                    return TRUE;
				}
			}
		}

        return FALSE;
	}

	private function validateForm() {
		$this->form_validation->set_rules('recipient', 'lang:label_to', 'xss_clean|trim|required|min_length[2]|max_length[128]');
		$this->form_validation->set_rules('subject', 'lang:label_subject', 'xss_clean|trim|required|min_length[2]|max_length[128]');
		$this->form_validation->set_rules('body', 'lang:label_body', 'required|min_length[3]');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

    private function getList($data, $filter) {
        if ($this->input->post('message_state')) {
            if ($this->_updateMessageState($this->input->post('message_state'), '', $this->user->getStaffId()) === TRUE) {
                redirect(current_url());
            }
        }

        $url = '?';

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
            $url .= 'filter_search=' . $filter['filter_search'] . '&';
        } else {
            $data['filter_search'] = '';
        }

        if ($this->input->get('filter_recipient')) {
            $filter['filter_recipient'] = $data['filter_recipient'] = $this->input->get('filter_recipient');
            $url .= 'filter_recipient=' . $filter['filter_recipient'] . '&';
        } else {
            $filter['filter_recipient'] = $data['filter_recipient'] = '';
        }

        if ($this->input->get('filter_type')) {
            $filter['filter_type'] = $data['filter_type'] = $this->input->get('filter_type');
            $url .= 'filter_type=' . $filter['filter_type'] . '&';
        } else {
            $filter['filter_type'] = $data['filter_type'] = '';
        }

        $filter['filter_staff'] = $this->user->getStaffId();

        if ($this->input->get('filter_date')) {
            $filter['filter_date'] = $data['filter_date'] = $this->input->get('filter_date');
            $filter['filter_date'];
            $url .= 'filter_date=' . $filter['filter_date'] . '&';
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
            $data['order_by_active'] = $this->input->get('order_by') . ' active';
        } else {
            $filter['order_by'] = $data['order_by'] = 'DESC';
            $data['order_by_active'] = 'DESC';
        }

        $order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'ASC') ? 'DESC' : 'ASC';
        $data['sort_type'] 			= site_url($data['page_uri'].$url.'sort_by=send_type&order_by='.$order_by);
        $data['sort_date'] 			= site_url($data['page_uri'].$url.'sort_by=messages.date_added&order_by='.$order_by);

        $message_state = ($data['filter_folder'] === 'inbox') ? 'message message-unread' : 'message';

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
                'date_added'	=> time_elapsed($result['date_added']),
                'body' 			=> (strlen($result['body']) > 40) ? substr(strip_tags(html_entity_decode($result['body'], ENT_QUOTES, 'UTF-8')), 0, 40) . '..' : strip_tags(html_entity_decode($result['body'], ENT_QUOTES, 'UTF-8')),
                'state'			=> (isset($result['state']) AND $result['state'] === '1') ? 'message message-read' : $message_state,
                'view'			=> ($filter['filter_folder'] === 'draft') ? site_url('messages/compose?id=' . $result['message_id']) : site_url('messages/view?id=' . $result['message_id'])
            );
        }

        $message_unread = $this->user->unreadMessageTotal();
        $data['folders'] = array(
            'inbox' => array('title' => $this->lang->line('text_inbox'), 'icon' => 'fa-inbox', 'badge' => $message_unread, 'url' => site_url('messages')),
            'draft' => array('title' => $this->lang->line('text_draft'), 'icon' => 'fa-file-text-o', 'badge' => '', 'url' => site_url('messages/draft')),
            'sent' => array('title' => $this->lang->line('text_sent'), 'icon' => 'fa-paper-plane-o', 'badge' => '', 'url' => site_url('messages/sent')),
            'all' 	=> array('title' => $this->lang->line('text_all'), 'icon' => 'fa-briefcase', 'badge' => '', 'url' => site_url('messages/all')),
            'archive' 	=> array('title' => $this->lang->line('text_archive'), 'icon' => 'fa-archive', 'badge' => '', 'url' => site_url('messages/archive')),
        );

        $data['labels'] = array(
            'account' => array('title' => $this->lang->line('text_account'), 'icon' => 'fa-circle-o text-primary', 'url' => page_url().'?filter_type=account'),
            'email' => array('title' => $this->lang->line('text_email'), 'icon' => 'fa-circle-o text-danger', 'url' => page_url().'?filter_type=email'),
        );

        $data['message_dates'] = array();
        $message_dates = $this->Messages_model->getMessageDates();
        foreach ($message_dates as $message_date) {
            $month_year = $message_date['year'].'-'.$message_date['month'];
            $data['message_dates'][$month_year] = mdate('%F %Y', strtotime($message_date['date_added']));
        }

        if ($this->input->get('sort_by') AND $this->input->get('order_by')) {
            $url .= 'sort_by='.$filter['sort_by'].'&';
            $url .= 'order_by='.$filter['order_by'].'&';
        }

        $config['base_url'] 		= site_url($data['page_uri'].$url);
        $config['total_rows'] 		= $this->Messages_model->getCount($filter);
        $config['per_page'] 		= $filter['limit'];

        $this->pagination->initialize($config);

        $data['pagination'] = array(
            'info'		=> $this->pagination->create_infos(),
            'links'		=> $this->pagination->create_links()
        );

        return $data;
    }
}

/* End of file messages.php */
/* Location: ./admin/controllers/messages.php */