<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Messages extends Admin_Controller
{

	public $index_url = 'messages';
	public $create_url = 'messages/compose';
	public $edit_url = 'messages/compose?id={id}';
	public $view_url = 'messages/view?id={id}&folder={folder}';

	public $filter = array(
		'filter_search'    => '',
		'filter_recipient' => '',
		'filter_type'      => '',
		'filter_date'      => '',
		'filter_folder'    => 'inbox',
	);

	public $default_sort = array('messages.date_added', 'DESC');

	public $sort = array('send_type', 'date_added');

	public $folders = array();
	public $labels = array();

	public function __construct() {
		parent::__construct(); //  calls the constructor

		$this->load->model('Messages_model');
		$this->load->model('Staffs_model');

		$this->lang->load('messages');

		$message_unread = $this->user->unreadMessageTotal();
		$this->folders = array(
			'inbox'   => array('title' => $this->lang->line('text_inbox'), 'icon' => 'fa-inbox', 'badge' => $message_unread, 'url' => $this->pageUrl()),
			'draft'   => array('title' => $this->lang->line('text_draft'), 'icon' => 'fa-file-text-o', 'badge' => '', 'url' => $this->pageUrl($this->index_url . '/draft')),
			'sent'    => array('title' => $this->lang->line('text_sent'), 'icon' => 'fa-paper-plane-o', 'badge' => '', 'url' => $this->pageUrl($this->index_url . '/sent')),
			'all'     => array('title' => $this->lang->line('text_all'), 'icon' => 'fa-briefcase', 'badge' => '', 'url' => $this->pageUrl($this->index_url . '/all')),
			'archive' => array('title' => $this->lang->line('text_archive'), 'icon' => 'fa-archive', 'badge' => '', 'url' => $this->pageUrl($this->index_url . '/archive')),
		);

		$this->labels = array(
			'account' => array('title' => $this->lang->line('text_account'), 'icon' => 'fa-user', 'url' => page_url() . '?filter_type=account'),
			'email'   => array('title' => $this->lang->line('text_email'), 'icon' => 'fa-at', 'url' => page_url() . '?filter_type=email'),
		);
	}

	public function index() {
		$this->template->setTitle($this->lang->line('text_title'));
		$this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $this->lang->line('text_inbox')));
		$this->template->setButton($this->lang->line('button_compose'), array('class' => 'btn btn-primary', 'href' => site_url('messages/compose')));
		$this->template->setButton($this->lang->line('button_icon_filter'), array('class' => 'btn btn-default btn-filter pull-right', 'data-toggle' => 'button'));

		$data = $this->getList();

		$this->template->render('messages', $data);
	}

	public function all() {
		$this->user->restrict('Admin.Messages');

		$this->setFilter(array('filter_folder' => 'all'));
		$this->index_url = 'messages/all';

		$this->template->setTitle($this->lang->line('text_title'));
		$this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $this->lang->line('text_all')));
		$this->template->setButton($this->lang->line('button_compose'), array('class' => 'btn btn-primary', 'href' => site_url('messages/compose')));
		$this->template->setButton($this->lang->line('button_icon_filter'), array('class' => 'btn btn-default btn-filter pull-right', 'data-toggle' => 'button'));

		$data = $this->getList();

		$this->template->render('messages', $data);
	}

	public function draft() {
		$this->user->restrict('Admin.Messages');

		$this->setFilter(array('filter_folder' => 'draft'));
		$this->index_url = 'messages/draft';

		$this->template->setTitle($this->lang->line('text_title'));
		$this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $this->lang->line('text_draft')));
		$this->template->setButton($this->lang->line('button_compose'), array('class' => 'btn btn-primary', 'href' => site_url('messages/compose')));
		$this->template->setButton($this->lang->line('button_icon_filter'), array('class' => 'btn btn-default btn-filter pull-right', 'data-toggle' => 'button'));

		$data = $this->getList();

		$this->template->render('messages', $data);
	}

	public function sent() {
		$this->index_url = 'messages/sent';

		$this->template->setTitle($this->lang->line('text_title'));
		$this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $this->lang->line('text_sent')));
		$this->template->setButton($this->lang->line('button_compose'), array('class' => 'btn btn-primary', 'href' => site_url('messages/compose')));
		$this->template->setButton($this->lang->line('button_icon_filter'), array('class' => 'btn btn-default btn-filter pull-right', 'data-toggle' => 'button'));

		$this->setFilter(array('filter_folder' => 'sent'));
		$data = $this->getList();

		$this->template->render('messages', $data);
	}

	public function archive() {
		$this->index_url = 'messages/archive';

		$this->template->setTitle($this->lang->line('text_title'));
		$this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $this->lang->line('text_archive')));
		$this->template->setButton($this->lang->line('button_compose'), array('class' => 'btn btn-primary', 'href' => site_url('messages/compose')));
		$this->template->setButton($this->lang->line('button_icon_filter'), array('class' => 'btn btn-default btn-filter pull-right', 'data-toggle' => 'button'));

		$this->setFilter(array('filter_folder' => 'archive'));
		$data = $this->getList();

		$this->template->render('messages', $data);
	}

	public function view() {
		$message_info = $this->Messages_model->viewMessage((int)$this->input->get('id'), $this->user->getStaffId());

		if (empty($message_info)) $this->redirect();

		$message_folder = $this->input->get('folder');
		$previous_uri = (empty($message_folder) OR $message_folder === 'inbox') ? 'messages' : 'messages/' . $message_folder;

		if ($this->input->post('message_state')) {
			if ($this->_updateMessageState($this->input->post('message_state'), $this->user->getStaffId(), $message_folder) === TRUE) {
				$this->redirect($previous_uri);
			}
		} else if ($message_info['state'] !== '1') {
			$this->_updateMessageState('read', $this->user->getStaffId(), $message_folder, FALSE);
		}

		$this->template->setTitle($this->lang->line('text_title'));
		$this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $this->lang->line('text_view')));
		$this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url($previous_uri)));

		$data = $this->getView($message_info);

		$this->template->render('messages_view', $data);
	}

	public function compose() {
		$this->user->restrict('Admin.Messages');
		$this->user->restrict('Admin.Messages.Add');

		if ($this->input->post() AND $message_id = $this->_saveMessage()) {
			$this->redirect($message_id);
		}

		$message_info = $this->Messages_model->getDraftMessage((int)$this->input->get('id'));

		$this->template->setTitle($this->lang->line('text_title'));
		$this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), 'Compose'));
		$this->template->setButton($this->lang->line('button_send'), array('class' => 'btn btn-success', 'onclick' => '$(\'#compose-form\').submit();'));
		$this->template->setButton($this->lang->line('button_save_draft'), array('class' => 'btn btn-default', 'onclick' => 'saveAsDraft();'));
		$this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('messages')));

		$this->template->setStyleTag(assets_url('js/summernote/summernote.css'), 'summernote-css', '111');
		$this->template->setScriptTag(assets_url('js/summernote/summernote.min.js'), 'summernote-js', '111');

		$data = $this->getForm($message_info);

		$data['folders'] = $this->folders;
		$data['labels'] = $this->labels;

		$this->template->render('messages_compose', $data);
	}

	public function latest() {
		$this->setFilter(array('filter_folder' => 'inbox', 'limit' => '10'));
		$this->index_url = 'messages/latest';

		$data = $this->getList();

		$this->template->render('messages_latest', $data);
	}

	public function getList() {
		$this->setFilter('filter_staff', $this->user->getStaffId());
		$data = $filter = array_merge($this->getFilter(), $this->getSort());

		if ($this->input->post('message_state')) {
			if ($this->_updateMessageState($this->input->post('message_state'), $this->user->getStaffId(), $data['filter_folder']) === TRUE) {
				$this->redirect(current_url());
			}
		}
		
		$data['folders'] = $this->folders;
		$data['labels'] = $this->labels;
		$message_state = ($data['filter_folder'] === 'inbox') ? 'message message-unread active' : 'message';

		$data['messages'] = array();
		$results = $this->Messages_model->paginate($this->getFilter());
		foreach ($results->list as $result) {
			$date_added = time_elapsed($result['date_added']);
			if (strpos($date_added, 'month') !== 'FALSE' OR strpos($date_added, 'year') !== 'FALSE') {
				$date_added = mdate('%d %M %y', strtotime($result['date_added']));
			}

			$folder = 'archive';
			if (empty($result['deleted']) AND $result['message_status'] == '1' AND $result['item'] === 'staff_id') {
				$folder = 'inbox';
			} else if (empty($result['message_status']) AND $result['sender_id'] == $this->user->getStaffId()) {
				$folder = 'draft';
			} else if (empty($result['deleted']) AND $result['message_status'] === '1' AND $result['item'] === 'sender_id' AND $result['sender_id'] == $this->user->getStaffId()) {
				$folder = 'sent';
			}

			$compose_url = $this->pageUrl($this->edit_url, array('id' => $result['message_id']));
			$view_url = $this->pageUrl($this->view_url, array('id' => $result['message_id'], 'folder' => $data['filter_folder']));
			$body = strip_tags(html_entity_decode($result['body'], ENT_QUOTES, 'UTF-8'));
			$data['messages'][] = array_merge($result, array(
				'message_meta_id' => isset($result['message_meta_id']) ? $result['message_meta_id'] : 0,
				'from'            => $result['staff_name'],
				'send_type_class' => (isset($result['send_type']) AND $result['send_type'] === 'account') ? 'fa-user' : 'fa-at',
				'subject'         => strip_tags(html_entity_decode($result['subject'], ENT_QUOTES, 'UTF-8')),
				'recipient'       => ucwords(str_replace('_', ' ', $result['recipient'])),
				'date_added'      => $date_added,
				'folder'          => $folder,
				'body'            => (strlen($body) > 40) ? character_limiter($body, 40) : $body,
				'state'           => (isset($result['state']) AND $result['state'] === '1') ? 'message message-read' : $message_state,
				'view'            => ($data['filter_folder'] === 'draft') ? $compose_url : $view_url,
			));
		}

		$data['pagination'] = $results->pagination;

		$data['message_dates'] = array();
		$message_dates = $this->Messages_model->getMessageDates();
		foreach ($message_dates as $message_date) {
			$month_year = $message_date['year'] . '-' . $message_date['month'];
			$data['message_dates'][$month_year] = mdate('%F %Y', strtotime($message_date['date_added']));
		}

		return $data;
	}

	protected function getView($message_info = array()) {
		$data = $message_info;
		$message_id = $message_info['message_id'];

		if (empty($message_info['deleted']) AND $message_info['message_status'] == '1' AND $message_info['item'] === 'staff_id') {
			$data['message_folder'] = 'inbox';
		} else if (empty($message_info['message_status']) AND $message_info['sender_id'] == $this->user->getStaffId()) {
			$data['message_folder'] = 'draft';
		} else if (empty($message_info['deleted']) AND $message_info['message_status'] === '1' AND $message_info['item'] === 'sender_id' AND $message_info['sender_id'] == $this->user->getStaffId()) {
			$data['message_folder'] = 'sent';
		} else {
			$data['message_folder'] = 'archive';
		}

		$data['folders'] = $this->folders;
		$data['labels'] = $this->labels;

		$data['message_id'] = $message_info['message_id'];
		$data['message_meta_id'] = $message_info['message_meta_id'];
		$data['date_added'] = mdate('%H:%i - %d %M %y', strtotime($message_info['date_added']));
		$data['send_type'] = $message_info['send_type'];
		$data['from'] = $message_info['staff_name'];
		$data['recipient'] = ucwords(str_replace('_', ' ', $message_info['recipient']));
		$data['subject'] = $message_info['subject'];
		$data['body'] = $message_info['body'];
		$data['message_deleted'] = ($message_info['status'] === '0') ? TRUE : FALSE;

		$data['recipients'] = array();
		$recipients = $this->Messages_model->getRecipients($message_id);
		if ($recipients) {
			foreach ($recipients as $recipient) {
				$recipient_name = $recipient['first_name'] . ' ' . $recipient['last_name'];
				$recipient_email = !empty($recipient['email']) ? $recipient['email'] : $recipient['value'];
				if ($recipient['item'] === 'staff_email' OR $recipient['item'] === 'staff_id') {
					$recipient_name = $recipient['staff_name'];
					$recipient_email = !empty($recipient['staff_email']) ? $recipient['staff_email'] : $recipient['value'];
				}

				$data['recipients'][] = array_merge($recipient, array(
					'recipient_name'  => empty($recipient_name) ? $recipient_email : $recipient_name,
					'recipient_email' => $recipient_email,
					'sent'            => ($recipient['status'] === '1') ? '<i class="fa fa-check-square green"></i>' : '<i class="fa fa-exclamation-circle red"></i>',
					'read'            => ($recipient['state'] === '1') ? '<i class="fa fa-check-square green"></i>' : '--',
					'deleted'         => (empty($recipient['deleted'])) ? '--' : '<i class="fa fa-check-square green"></i>',
				));
			}
		}

		return $data;
	}

	public function getForm($message_info = array()) {
		$data = $message_info;

		$message_id = 0;
		$data['_action'] = $this->pageUrl($this->create_url);
		if (!empty($message_info['message_id'])) {
			$message_id = $message_info['message_id'];
			$data['_action'] = $this->pageUrl($this->edit_url, array('id' => $message_id));
		}

		if ($this->input->get('id') AND !$message_info) {
			$this->redirect();
		}

		$data['sub_menu_back'] = $this->pageUrl();

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

		$data['subject'] = $message_info['subject'];
		$data['body'] = $message_info['body'];

		$data['recipients'] = array(
			'all_newsletters' => $this->lang->line('text_all_newsletters'),
			'all_customers'   => $this->lang->line('text_all_customers'),
			'customer_group'  => $this->lang->line('text_customer_group'),
			'customers'       => $this->lang->line('text_customers'),
			'all_staffs'      => $this->lang->line('text_all_staff'),
			'staff_group'     => $this->lang->line('text_staff_group'),
			'staffs'          => $this->lang->line('text_staff'),
		);

		$data['customer_groups'] = array();
		$this->load->model('Customer_groups_model');
		$results = $this->Customer_groups_model->getCustomerGroups();
		foreach ($results as $result) {
			$data['customer_groups'][] = array(
				'customer_group_id' => $result['customer_group_id'],
				'group_name'        => $result['group_name'],
			);
		}

		$data['staff_groups'] = array();
		$this->load->model('Staff_groups_model');
		$results = $this->Staff_groups_model->getStaffGroups();
		foreach ($results as $result) {
			$data['staff_groups'][] = array(
				'staff_group_id'   => $result['staff_group_id'],
				'staff_group_name' => $result['staff_group_name'],
			);
		}

		return $data;
	}

	protected function _saveMessage() {
		if ($this->validateForm() === TRUE) {
			$save_type = (is_numeric($this->input->post('save_as_draft'))) ? $this->lang->line('text_saved_to_draft') : $this->lang->line('text_sent');
			if ($message_id = $this->Messages_model->saveMessage($this->input->get('id'), $this->input->post())) {
				$this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Message ' . $save_type));
			} else {
				$this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
			}

			return $message_id;
		}
	}

	protected function _updateMessageState($state = '', $staff_id = '', $folder = '', $display_error = TRUE) {
		if (is_numeric($staff_id)) {
			if ($state === 'unread') {
				$alert = $this->lang->line('alert_mark_as_unread');
			} else if ($state === 'read') {
				$alert = $this->lang->line('alert_mark_as_read');
			} else if ($state === 'restore') {
				$alert = $this->lang->line('alert_move_to_inbox');
			} else if ($state === 'archive') {
				$alert = $this->lang->line('alert_move_to_archive');
			} else if ($state === 'trash') {
				$alert = $this->lang->line('alert_move_to_trash');
			}

			if ($state !== '' AND $this->input->post('delete')) {
				if ($folder === 'draft') {
					$this->Messages_model->deleteMessage($this->input->post('delete'), $staff_id);
				} else {
					$this->Messages_model->updateState($this->input->post('delete'), $staff_id, $state, $folder);
				}

				$num = count($this->input->post('delete'));
				if ($num > 0) {
					$alert_msg = ($num == 1) ? 'Message ' . $alert : $num . ' messages ' . $alert;

					if ($display_error === TRUE) $this->alert->set('success', $alert_msg);

					return TRUE;
				}
			}
		}

		return FALSE;
	}

	protected function validateForm() {
		$rules[] = array('recipient', 'lang:label_to', 'xss_clean|trim|required|min_length[2]|max_length[128]');
		$rules[] = array('subject', 'lang:label_subject', 'xss_clean|trim|required|min_length[2]|max_length[128]');
		$rules[] = array('body', 'lang:label_body', 'required|min_length[3]');

		return $this->Messages_model->set_rules($rules)->validate();
	}
}

/* End of file Messages.php */
/* Location: ./admin/controllers/Messages.php */