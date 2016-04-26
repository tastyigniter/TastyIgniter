<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Inbox extends Main_Controller {

	public function __construct() {
		parent::__construct(); 																	//  calls the constructor
        if (!$this->customer->isLogged()) {  													// if customer is not logged in redirect to account login page
            redirect('account/login');
        }

        $this->load->model('Messages_model');													// loads messages model

		$this->lang->load('account/inbox');
	}

	public function index() {
		$url = '?';
		$filter = array();
		$filter['customer_id'] = (int) $this->customer->getId();

		if ($this->input->get('page')) {
			$filter['page'] = (int) $this->input->get('page');
		} else {
			$filter['page'] = '';
		}

		if ($this->config->item('page_limit')) {
			$filter['limit'] = $this->config->item('page_limit');
		}

		$filter['sort_by'] = 'messages.date_added';
		$filter['order_by'] = 'DESC';

		$this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
        $this->template->setBreadcrumb($this->lang->line('text_my_account'), 'account/account');
		$this->template->setBreadcrumb($this->lang->line('text_heading'), 'account/inbox');

		$this->template->setTitle($this->lang->line('text_heading'));
		$this->template->setHeading($this->lang->line('text_heading'));

		$data['back_url'] 		= site_url('account/account');

		$data['messages'] = array();
		$results = $this->Messages_model->getList($filter);									// retrieve all customer messages from getMainInbox method in Messages model
		foreach ($results as $result) {
			$data['messages'][] = array(														// create array of customer messages to pass to view
                'date_added'	=> time_elapsed($result['date_added']),
				'subject' 		=> $result['subject'],
				'body' 			=> substr(strip_tags(html_entity_decode($result['body'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..',
				'state'			=> ($result['state'] === '0') ? 'unread' : 'read',
				'view'			=> site_url('account/inbox/view/'. $result['message_id'])
			);
		}

		$prefs['base_url'] 			= site_url('account/inbox'.$url);
		$prefs['total_rows'] 		= $this->Messages_model->getCount($filter);
		$prefs['per_page'] 			= $filter['limit'];

		$this->load->library('pagination');
		$this->pagination->initialize($prefs);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		$this->template->render('account/inbox', $data);
	}

	public function view() {
		if (!($result = $this->Messages_model->viewMessage($this->uri->rsegment(3), $this->customer->getId()))) {															// check if customer_id is set in uri string
  			$this->alert->set('danger', $this->lang->line('alert_unknown_error'));
            redirect('account/inbox');
		}

		$this->Messages_model->updateState($result['message_meta_id'], $this->customer->getId(), 'read');

        $this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
        $this->template->setBreadcrumb($this->lang->line('text_my_account'), 'account/account');
        $this->template->setBreadcrumb($this->lang->line('text_heading'), 'account/inbox');
        $this->template->setBreadcrumb($this->lang->line('text_view_heading'), 'account/inbox/view');

        $this->template->setTitle($this->lang->line('text_view_heading'));
        $this->template->setHeading($this->lang->line('text_view_heading'));

        $data['back_url'] 			= site_url('account/inbox');
		$data['delete_url'] = site_url('account/inbox/delete/' . $result['message_meta_id']);

        $data['message_id'] 	= $result['message_id'];
        $data['date_added'] 	= time_elapsed($result['date_added']) . ' - ' . mdate('%d %M %y - %H:%i', strtotime($result['date_added']));
        $data['subject'] 		= $result['subject'];
        $data['body'] 			= $result['body'];

		$this->template->render('account/inbox_view', $data);
	}

	public function delete() {
		$message_meta_id = is_numeric($this->uri->rsegment(3)) ? $this->uri->rsegment(3) : FALSE;

		if ($this->Messages_model->updateState($message_meta_id, $this->customer->getId(), 'trash')) {
			$this->alert->set('success', $this->lang->line('alert_deleted_success'));
		}

		redirect('account/inbox');
	}
}

/* End of file inbox.php */
/* Location: ./main/controllers/inbox.php */