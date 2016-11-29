<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Inbox extends Main_Controller
{

	public $default_sort = ['messages.date_added', 'DESC'];

	public function __construct()
	{
		parent::__construct();                                                                    //  calls the constructor

		if (!$this->customer->isLogged()) {                                                    // if customer is not logged in redirect to account login page
			$this->redirect('account/login');
		}

		$this->load->model('Messages_model');                                                    // loads messages model

		$this->lang->load('account/inbox');
	}

	public function index()
	{
		$this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
		$this->template->setBreadcrumb($this->lang->line('text_my_account'), 'account/account');
		$this->template->setBreadcrumb($this->lang->line('text_heading'), 'account/inbox');

		$this->template->setTitle($this->lang->line('text_heading'));
		$this->template->setHeading($this->lang->line('text_heading'));

		$this->filter['customer_id'] = (int)$this->customer->getId();

		$data['back_url'] = $this->pageUrl('account/account');

		$data['messages'] = [];
		$results = $this->Messages_model->paginateWithFilter($this->filter);                                    // retrieve all customer messages from getMainInbox method in Messages model
		foreach ($results->list as $result) {
			$data['messages'][] = array_merge($result, [                                                        // create array of customer messages to pass to view
				'date_added' => time_elapsed($result['date_added']),
				'body'       => substr(strip_tags(html_entity_decode($result['body'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..',
				'state'      => ($result['state'] == '0') ? 'unread' : 'read',
				'view'       => $this->pageUrl('account/inbox/view/' . $result['message_id']),
			]);
		}

		$data['pagination'] = $results->pagination;

		$this->template->render('account/inbox', $data);
	}

	public function view()
	{
		if (!($result = $this->Messages_model->viewMessage($this->uri->rsegment(3), $this->customer->getId()))) {                                                            // check if customer_id is set in uri string
			$this->alert->set('danger', $this->lang->line('alert_unknown_error'));
			$this->redirect('account/inbox');
		}

		$this->Messages_model->updateState($result['message_meta_id'], $this->customer->getId(), 'read');

		$this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
		$this->template->setBreadcrumb($this->lang->line('text_my_account'), 'account/account');
		$this->template->setBreadcrumb($this->lang->line('text_heading'), 'account/inbox');
		$this->template->setBreadcrumb($this->lang->line('text_view_heading'), 'account/inbox/view');

		$this->template->setTitle($this->lang->line('text_view_heading'));
		$this->template->setHeading($this->lang->line('text_view_heading'));

		$data['back_url'] = $this->pageUrl('account/inbox');
		$data['delete_url'] = $this->pageUrl('account/inbox/delete/' . $result['message_meta_id']);

		$data['message_id'] = $result['message_id'];
		$data['date_added'] = time_elapsed($result['date_added']) . ' - ' . mdate('%d %M %y - %H:%i', strtotime($result['date_added']));
		$data['subject'] = $result['subject'];
		$data['body'] = $result['body'];

		$this->template->render('account/inbox_view', $data);
	}

	public function delete()
	{
		$message_meta_id = is_numeric($this->uri->rsegment(3)) ? $this->uri->rsegment(3) : FALSE;

		if ($this->Messages_model->updateState($message_meta_id, $this->customer->getId(), 'trash')) {
			$this->alert->set('success', $this->lang->line('alert_deleted_success'));
		}

		$this->redirect('account/inbox');
	}
}

/* End of file Inbox.php */
/* Location: ./main/controllers/Inbox.php */