<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Customers_online extends Admin_Controller
{

	public $filter = [
		'filter_search' => '',
		'filter_access' => '',
		'filter_date'   => '',
		'filter_type'   => 'online',
		'time_out'      => '',
	];

	public $default_sort = ['customers_online.date_added', 'DESC'];

	public $sort = ['date_added'];

	public function __construct()
	{
		parent::__construct();

		$this->user->restrict('Admin.CustomersOnline');

		$this->load->model('Customer_online_model');

		$this->lang->load('customer_online');
	}

	public function index()
	{
		$this->template->setTitle($this->lang->line('text_title'));
		$this->template->setHeading($this->lang->line('text_heading'));
		$this->template->setButton($this->lang->line('button_icon_filter'), ['class' => 'btn btn-default btn-filter pull-right', 'data-toggle' => 'button']);
		$this->template->setButton($this->lang->line('button_option'), ['class' => 'btn btn-default pull-right', 'href' => site_url('settings#system')]);

		$online_time_out = ($this->config->item('customer_online_time_out') > 120) ? $this->config->item('customer_online_time_out') : 120;
		$this->setFilter(['time_out' => mdate('%Y-%m-%d %H:%i:%s', time() - $online_time_out)]);

		$data = $this->getList();

		$this->template->render('customers_online', $data);
	}

	public function all()
	{
		$this->template->setTitle($this->lang->line('text_all_heading'));
		$this->template->setHeading($this->lang->line('text_all_heading'));
		$this->template->setButton($this->lang->line('button_icon_filter'), ['class' => 'btn btn-default btn-filter pull-right', 'data-toggle' => 'button']);
		$this->template->setButton($this->lang->line('button_option'), ['class' => 'btn btn-default pull-right', 'href' => site_url('settings#system')]);

		$this->setFilter(['filter_type' => 'all']);

		$data = $this->getList();

		$this->template->render('customers_online', $data);
	}

	public function getList()
	{
		$data = array_merge($this->getFilter(), $this->getSort());

		if ($data['filter_type'] === 'online') {
			$data['text_empty'] = $this->lang->line('text_empty');
		} else {
			$data['text_empty'] = $this->lang->line('text_empty_report');
		}

		$data['customers_online'] = [];
		$results = $this->Customer_online_model->paginateWithFilter($this->getFilter());
		foreach ($results->list as $online) {
			$country_code = ($online['country_code']) ? strtolower($online['country_code']) : 'no_flag';
			$data['customers_online'][] = array_merge($online, [
				'customer_name' => ($online['customer_id']) ? $online['first_name'] . ' ' . $online['last_name'] : $this->lang->line('text_guest'),
				'country_code'  => image_url('data/flags/' . $country_code . '.png'),
				'country_name'  => (isset($online['country_name'])) ? $online['country_name'] : $this->lang->line('text_protected'),
			]);
		}

		$data['types'] = [
			'online' => ['badge' => '', 'url' => $this->pageUrl(), 'title' => $this->lang->line('text_online')],
			'all'    => ['badge' => '', 'url' => $this->pageUrl($this->index_url . '/all'), 'title' => $this->lang->line('text_all')],
		];

		$data['online_dates'] = $this->Customer_online_model->getOnlineDates();

		$data['pagination'] = $results->pagination;

		return $data;
	}
}

/* End of file Customers_online.php */
/* Location: ./admin/controllers/Customers_online.php */