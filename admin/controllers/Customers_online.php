<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Customers_online extends Admin_Controller
{

	public $filter = array(
		'filter_search' => '',
		'filter_access' => '',
		'filter_date'   => '',
		'filter_type'   => 'online',
		'time_out'      => '',
	);

	public $default_sort = array('customers_online.date_added', 'DESC');

	public $sort = array('date_added');

	public function __construct() {
		parent::__construct();

		$this->user->restrict('Admin.CustomersOnline');

		$this->load->model('Customer_online_model');

		$this->lang->load('customer_online');
	}

	public function index() {
		$this->template->setTitle($this->lang->line('text_title'));
		$this->template->setHeading($this->lang->line('text_heading'));
		$this->template->setButton($this->lang->line('button_icon_filter'), array('class' => 'btn btn-default btn-filter pull-right', 'data-toggle' => 'button'));
		$this->template->setButton($this->lang->line('button_option'), array('class' => 'btn btn-default pull-right', 'href' => site_url('settings#system')));

		$online_time_out = ($this->config->item('customer_online_time_out') > 120) ? $this->config->item('customer_online_time_out') : 120;
		$this->setFilter(array('time_out' => mdate('%Y-%m-%d %H:%i:%s', time() - $online_time_out)));

		$data = $this->getList();

		$this->template->render('customers_online', $data);
	}

	public function all() {
		$this->template->setTitle($this->lang->line('text_all_heading'));
		$this->template->setHeading($this->lang->line('text_all_heading'));
		$this->template->setButton($this->lang->line('button_icon_filter'), array('class' => 'btn btn-default btn-filter pull-right', 'data-toggle' => 'button'));
		$this->template->setButton($this->lang->line('button_option'), array('class' => 'btn btn-default pull-right', 'href' => site_url('settings#system')));

		$this->setFilter(array('filter_type' => 'all'));

		$data = $this->getList();

		$this->template->render('customers_online', $data);
	}

	public function getList() {
		$data = array_merge($this->getFilter(), $this->getSort());

		if ($data['filter_type'] === 'online') {
			$data['text_empty'] = $this->lang->line('text_empty');
		} else {
			$data['text_empty'] = $this->lang->line('text_empty_report');
		}

		$data['customers_online'] = array();
		$results = $this->Customer_online_model->paginate($this->getFilter());
		foreach ($results->list as $online) {
			$country_code = ($online['country_code']) ? strtolower($online['country_code']) : 'no_flag';
			$data['customers_online'][] = array_merge($online, array(
				'customer_name' => ($online['customer_id']) ? $online['first_name'] . ' ' . $online['last_name'] : $this->lang->line('text_guest'),
				'access_type'   => ucwords($online['access_type']),
				'request_uri'   => (!empty($online['request_uri'])) ? $online['request_uri'] : '--',
				'referrer_uri'  => (!empty($online['referrer_uri'])) ? $online['referrer_uri'] : '--',
				'request_url'   => (!empty($online['request_uri'])) ? root_url($online['request_uri']) : '#',
				'referrer_url'  => (!empty($online['referrer_uri'])) ? root_url($online['referrer_uri']) : '#',
				'date_added'    => time_elapsed($online['date_added']),
				'country_code'  => image_url('data/flags/' . $country_code . '.png'),
				'country_name'  => ($online['country_name']) ? $online['country_name'] : $this->lang->line('text_protected'),
			));
		}

		$data['types'] = array(
			'online' => array('badge' => '', 'url' => $this->pageUrl(), 'title' => $this->lang->line('text_online')),
			'all'    => array('badge' => '', 'url' => $this->pageUrl($this->index_url . '/all'), 'title' => $this->lang->line('text_all')),
		);

		$data['online_dates'] = array();
		$online_dates = $this->Customer_online_model->getOnlineDates();
		foreach ($online_dates as $date) {
			$month_year = mdate('%Y-%m', strtotime($date['year'] . '-' . $date['month']));
			$data['online_dates'][$month_year] = mdate('%F %Y', strtotime($date['date_added']));
		}

		$data['pagination'] = $results->pagination;

		return $data;
	}
}

/* End of file Customers_online.php */
/* Location: ./admin/controllers/Customers_online.php */