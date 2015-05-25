<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Inbox extends Main_Controller {

	public function __construct() {
		parent::__construct(); 																	//  calls the constructor
		$this->load->library('customer'); 														// load the customer library
		$this->load->model('Messages_model');													// loads messages model

		$this->lang->load('account/inbox');
	}

	public function index() {
		if (!$this->customer->isLogged()) {  													// if customer is not logged in redirect to account login page
  			redirect('account/login');
		}

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

		$this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
		$this->template->setBreadcrumb($this->lang->line('text_heading'), 'account/inbox');

		// START of retrieving lines from language file to pass to view.
		$this->template->setTitle($this->lang->line('text_heading'));
		$this->template->setHeading($this->lang->line('text_heading'));
		$data['text_heading'] 			= $this->lang->line('text_heading');
		$data['text_view'] 				= $this->lang->line('text_view');
		$data['text_empty'] 			= $this->lang->line('text_empty');
		$data['column_date'] 			= $this->lang->line('column_date');
		$data['column_time'] 			= $this->lang->line('column_time');
		$data['column_subject'] 		= $this->lang->line('column_subject');
		$data['column_text'] 			= $this->lang->line('column_text');
		$data['column_action'] 			= $this->lang->line('column_action');
		$data['button_back'] 			= $this->lang->line('button_back');
		// END of retrieving lines from language file to pass to view.

		$data['back'] 					= site_url('account/account');

		$data['messages'] = array();
		$results = $this->Messages_model->getList($filter);									// retrieve all customer messages from getMainInbox method in Messages model
		foreach ($results as $result) {
			$data['messages'][] = array(														// create array of customer messages to pass to view
				'date_added'	=> mdate('%d %M %y - %H:%i', strtotime($result['date_added'])),
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

		$this->template->setPartials(array('header', 'content_top', 'content_left', 'content_right', 'content_bottom', 'footer'));
		$this->template->render('account/inbox', $data);
	}

	public function view() {
		if (!$this->customer->isLogged()) {  													// if customer is not logged in redirect to account login page
  			redirect('account/login');
		}

		if ($this->uri->rsegment(4)) {															// check if customer_id is set in uri string
			$message_id = (int)$this->uri->rsegment(4);
		} else {
  			redirect('account/inbox');
		}

		$result = $this->Messages_model->viewMessage($message_id, $this->customer->getId());								// retrieve specific customer message based on message id to be passed to view

		$this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
		$this->template->setBreadcrumb($this->lang->line('text_heading'), 'account/inbox');
		$this->template->setBreadcrumb($this->lang->line('text_view_heading'), 'account/inbox/view');

		// START of retrieving lines from language file to pass to view.
		$this->template->setTitle($this->lang->line('text_view_heading'));
		$this->template->setHeading($this->lang->line('text_view_heading'));
		$data['text_heading'] 			= $this->lang->line('text_view_heading');
		$data['column_date'] 			= $this->lang->line('column_date');
		$data['column_time'] 			= $this->lang->line('column_time');
		$data['column_subject'] 		= $this->lang->line('column_subject');
		$data['button_back'] 			= $this->lang->line('button_back');
		// END of retrieving lines from language file to pass to view.

		$data['back'] 					= site_url('account/inbox');
		if ($result) {
			$data['error'] 			= '';
			$data['message_id'] 	= $result['message_id'];
			$data['date_added'] 	= mdate('%d %M %y - %H:%i', strtotime($result['date_added']));
			$data['subject'] 		= $result['subject'];
			$data['body'] 			= $result['body'];
			$this->Messages_model->updateState($result['message_id'], $this->customer->getId(), '1');
		} else {
			$data['error'] = '<p class="error">Sorry, an error has occurred.</p>';
		}

		$this->template->setPartials(array('header', 'content_top', 'content_left', 'content_right', 'content_bottom', 'footer'));
		$this->template->render('account/inbox_view', $data);
	}
}

/* End of file inbox.php */
/* Location: ./main/controllers//inbox.php */