<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Inbox extends MX_Controller {

	public function __construct() {
		parent::__construct(); 																	//  calls the constructor
		$this->load->library('customer'); 														// load the customer library
		$this->load->model('Messages_model');													// loads messages model

		$this->load->library('language');
		$this->lang->load('main/inbox', $this->language->folder());
	}

	public function index() {
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  								// retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		if (!$this->customer->isLogged()) {  													// if customer is not logged in redirect to account login page
  			redirect('main/login');
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

		$data['back'] 					= site_url('main/account');
		
		$data['messages'] = array();
		$results = $this->Messages_model->getMainList($filter);									// retrieve all customer messages from getMainInbox method in Messages model
		foreach ($results as $result) {					
			$data['messages'][] = array(														// create array of customer messages to pass to view
				'date_added'	=> mdate('%d %M %y - %H:%i', strtotime($result['date_added'])),
				'subject' 		=> $result['subject'],
				'body' 			=> substr(strip_tags(html_entity_decode($result['body'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..',
				'state'			=> ($result['state'] === '0') ? 'unread' : 'read',
				'view'			=> site_url('main/inbox/view/'. $result['message_id'])
			);
		}
		
		$prefs['base_url'] 			= site_url('main/inbox').$url;
		$prefs['total_rows'] 		= $this->Messages_model->getMainListCount($filter);
		$prefs['per_page'] 			= $filter['limit'];
		
		$this->load->library('pagination');
		$this->pagination->initialize($prefs);
				
		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		$this->template->regions(array('header', 'content_top', 'content_left', 'content_right', 'footer'));
		if (file_exists(APPPATH .'views/themes/main/'.$this->config->item('main_theme').'inbox.php')) {
			$this->template->render('themes/main/'.$this->config->item('main_theme'), 'inbox', $data);
		} else {
			$this->template->render('themes/main/default/', 'inbox', $data);
		}
	}

	public function view() {
		if (!$this->customer->isLogged()) {  													// if customer is not logged in redirect to account login page
  			redirect('main/login');
		}

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  								// retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		if ($this->uri->segment(4)) {															// check if customer_id is set in uri string
			$message_id = (int)$this->uri->segment(4);
		} else {
  			redirect('main/inbox');
		}

		$result = $this->Messages_model->viewMainMessage($this->customer->getId(), $message_id);								// retrieve specific customer message based on message id to be passed to view

		// START of retrieving lines from language file to pass to view.
		$this->template->setTitle($this->lang->line('text_view_heading'));
		$this->template->setHeading($this->lang->line('text_view_heading'));
		$data['text_heading'] 			= $this->lang->line('text_view_heading');
		$data['column_date'] 			= $this->lang->line('column_date');
		$data['column_time'] 			= $this->lang->line('column_time');
		$data['column_subject'] 		= $this->lang->line('column_subject');
		$data['button_back'] 			= $this->lang->line('button_back');
		// END of retrieving lines from language file to pass to view.

		$data['back'] 					= site_url('main/inbox');
		if ($result) {
			$data['error'] 			= '';
			$data['message_id'] 	= $result['message_id'];
			$data['date_added'] 	= mdate('%d %M %y - %H:%i', strtotime($result['date_added']));
			$data['subject'] 		= $result['subject'];
			$data['body'] 			= $result['body'];
			$this->Messages_model->updateMainMessageState($result['message_id'], $this->customer->getId(), '1');
		} else {
			$data['error'] = '<p class="error">Sorry, an error has occurred.</p>';
		}

		$this->template->regions(array('header', 'content_top', 'content_left', 'content_right', 'footer'));
		if (file_exists(APPPATH .'views/themes/main/'.$this->config->item('main_theme').'inbox_view.php')) {
			$this->template->render('themes/main/'.$this->config->item('main_theme'), 'inbox_view', $data);
		} else {
			$this->template->render('themes/main/default/', 'inbox_view', $data);
		}
	}
}

/* End of file inbox.php */
/* Location: ./application/controllers/main/inbox.php */