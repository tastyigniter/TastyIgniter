<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Customers_activity extends Admin_Controller {

    public $_permission_rules = array('access[index|blacklist]', 'modify[index|blacklist]');

	public function __construct() {
		parent::__construct();
		$this->load->library('pagination');
		$this->load->model('Activity_model');
	}

	public function index() {
		$url = '?';
		$filter = array();
		if ($this->input->get('page')) {
			$filter['page'] = (int) $this->input->get('page');
		} else {
			$filter['page'] = 1;
		}

		if ($this->config->item('page_limit')) {
			$filter['limit'] = $this->config->item('page_limit');
		} else {
			$filter['limit'] = '';
		}

		if ($this->input->get('filter_search')) {
			$filter['filter_search'] = $data['filter_search'] = $this->input->get('filter_search');
		} else {
			$data['filter_search'] = '';
		}

		$online_time_out = ($this->config->item('activity_online_time_out') > 120) ? $this->config->item('activity_online_time_out') : 120;
		$filter['time_out'] = mdate('%Y-%m-%d %H:%i:%s', time() - $online_time_out);
		if ($this->input->get('filter_type')) {
			$filter['filter_type'] = $data['filter_type'] = $this->input->get('filter_type');
			$url .= 'filter_type='.$filter['filter_type'].'&';
		} else {
			$filter['filter_type'] = $data['filter_type'] = 'online';
		}

		if ($this->input->get('filter_access')) {
			$filter['filter_access'] = $data['filter_access'] = $this->input->get('filter_access');
			$url .= 'filter_access='.$filter['filter_access'].'&';
		} else {
			$filter['filter_access'] = $data['filter_access'] = '';
		}

		if ($this->input->get('filter_date')) {
			$filter['filter_date'] = $data['filter_date'] = $this->input->get('filter_date');
			$url .= 'filter_date='.$filter['filter_date'].'&';
		} else {
			$filter['filter_date'] = $data['filter_date'] = '';
		}

		if ($this->input->get('sort_by')) {
			$filter['sort_by'] = $data['sort_by'] = $this->input->get('sort_by');
		} else {
			$filter['sort_by'] = $data['sort_by'] = 'date_added';
		}

		if ($this->input->get('order_by')) {
			$filter['order_by'] = $data['order_by'] = $this->input->get('order_by');
			$data['order_by_active'] = $this->input->get('order_by') .' active';
		} else {
			$filter['order_by'] = $data['order_by'] = 'DESC';
			$data['order_by_active'] = '';
		}

		$this->template->setTitle('Customer Activities');
		$this->template->setHeading('Customer Activities');
		$this->template->setButton('Options', array('class' => 'btn btn-default pull-right', 'href' => site_url('settings#system')));

		if ($this->input->get('filter_type') === 'online') {
			$data['text_empty'] 	= 'There are no online customer activity available.';
		} else {
			$data['text_empty'] 	= 'There are no customer activity available.';
		}

		$order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'ASC') ? 'DESC' : 'ASC';
		$data['sort_date'] 			= site_url('customers_activity'.$url.'sort_by=date_added&order_by='.$order_by);

		$activities = $this->Activity_model->getList($filter);

		$data['activities'] = array();
		foreach ($activities as $activity) {
			$country_code = ($activity['country_code']) ? strtolower($activity['country_code']) : 'nn';
			$country_name = ($activity['country_name']) ? $activity['country_name'] : 'Private';

			$data['activities'][] = array(
				'activity_id' 		=> $activity['activity_id'],
				'ip_address' 		=> $activity['ip_address'],
				'customer_name'		=> ($activity['customer_id']) ? $activity['first_name'] .' '. $activity['last_name'] : 'Guest',
				'access_type'		=> ucwords($activity['access_type']),
				'browser'			=> $activity['browser'],
				'page_views'		=> $activity['page_views'],
				'request_uri'		=> (!empty($activity['request_uri'])) ? $activity['request_uri'] : '--',
				'referrer_uri'		=> (!empty($activity['referrer_uri'])) ? $activity['referrer_uri'] : '--',
				'date_added'		=> time_elapsed($activity['date_added']),
				'country_code'		=> image_url('flags/'. $country_code .'.png'),
				'country_name'		=> $country_name,
				'blacklist' 		=> site_url('customers_activity/blacklist?ip=' . $activity['ip_address'])
			);
		}

		$data['types'] = array(
			'online' 	=> array('badge' => '', 'url' => site_url('customers_activity?filter_type=online')),
			'all' 		=> array('badge' => '', 'url' => site_url('customers_activity?filter_type=all'))
		);

		$data['activity_dates'] = array();
		$activity_dates = $this->Activity_model->getActivityDates($filter);
		foreach ($activity_dates as $date) {
			$month_year = '';
			$month_year = mdate('%Y-%m', strtotime($date['year'].'-'.$date['month']));
			$data['activity_dates'][$month_year] = mdate('%F %Y', strtotime($date['date_added']));
		}

		if ($this->input->get('sort_by') AND $this->input->get('order_by')) {
			$url .= 'sort_by='.$filter['sort_by'].'&';
			$url .= 'order_by='.$filter['order_by'].'&';
		}

		$config['base_url'] 		= site_url('customers_activity'. $url);
		$config['total_rows'] 		= $this->Activity_model->getCount($filter);
		$config['per_page'] 		= $filter['limit'];

		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		if ($this->input->post('delete') AND $this->_deleteActivity() === TRUE) {
			redirect('customers_activity');
		}

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('customers_activity', $data);
	}

	public function blacklist() {
    	if ($this->input->get('ip')) {
			$this->alert->set('success', 'Activity IP added to blacklist successfully!');
		}

		redirect('customers_activity');
	}
}

/* End of file customers_activity.php */
/* Location: ./admin/controllers/customers_activity.php */