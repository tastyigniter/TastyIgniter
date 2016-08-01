<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Activities extends Admin_Controller
{

	public $list_filters = array(
		'filter_status' => '',
		'sort_by'       => 'date_added',
		'order_by'      => 'DESC',
	);

	public function __construct() {
		parent::__construct(); //  calls the constructor

		$this->user->restrict('Admin.Activities');

		$this->load->model('Activities_model');

		$this->lang->load('activities');
	}

	public function index() {
		$this->template->setTitle($this->lang->line('text_title'));
		$this->template->setHeading($this->lang->line('text_heading'));

		$data = $this->getList();

		$this->template->render('activities', $data);
	}

	public function latest() {
		$this->list_filters = array_merge($this->list_filters, array('page' => '1', 'limit' => '10'));

		$data['activities'] = array();
		foreach ($this->getList()['activities'] as $activities) {
			foreach ($activities as $activity) {
				$data['activities'][] = $activity;
			}
		}

		$this->template->render('activities_latest', $data);
	}

	public function recent() {
		$this->list_filters = array_merge($this->list_filters, array('page' => '1', 'limit' => '10'));

		$data['activities'] = array();
		foreach ($this->getList()['activities'] as $activities) {
			foreach ($activities as $activity) {
				$data['activities'][] = $activity;
			}
		}

		$this->template->render('activities', $data);
	}

	protected function getList() {
		$data = $this->list_filters;

		$data['activities'] = array();
		$results = $this->Activities_model->paginate($this->list_filters, $this->index_url);
		foreach ($results->list as $result) {
			$result['day_elapsed'] = day_elapsed($result['date_added']);
			$data['activities'][$result['day_elapsed']][] = array_merge($result, array(
				'time'         => mdate('%h:%i %A', strtotime($result['date_added'])),
				'time_elapsed' => time_elapsed($result['date_added']),
				'icon'         => 'fa fa-tasks',
				'state'        => $result['status'] === '1' ? 'read' : 'unread',
			));
		}

		$data['pagination'] = $results->pagination;

		return $data;
	}
}

/* End of file Activities.php */
/* Location: ./admin/controllers/Activities.php */