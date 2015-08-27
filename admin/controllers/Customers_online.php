<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Customers_online extends Admin_Controller {

	public function __construct() {
		parent::__construct();

        $this->user->restrict('Admin.CustomersOnline');

        $this->load->model('Customer_online_model');

        $this->load->library('pagination');

        $this->lang->load('customer_online');
	}

	public function index() {
        $this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading($this->lang->line('text_heading'));
        $this->template->setButton($this->lang->line('button_option'), array('class' => 'btn btn-default pull-right', 'href' => site_url('settings#system')));

        $filter = array();
        $online_time_out = ($this->config->item('customer_online_time_out') > 120) ? $this->config->item('customer_online_time_out') : 120;
        $filter['time_out'] = mdate('%Y-%m-%d %H:%i:%s', time() - $online_time_out);
        $filter['filter_type'] = $data['filter_type'] = 'online';

        $data = $this->getList($data, $filter);

		$this->template->render('customers_online', $data);
	}

	public function all() {
        $this->template->setTitle($this->lang->line('text_all_heading'));
        $this->template->setHeading($this->lang->line('text_all_heading'));
        $this->template->setButton($this->lang->line('button_option'), array('class' => 'btn btn-default pull-right', 'href' => site_url('settings#system')));

        $filter = array();
        $filter['filter_type'] = $data['filter_type'] = 'all';

        $data = $this->getList($data, $filter);

		$this->template->render('customers_online', $data);
	}

    private function getList($data, $filter) {
        $url = '?';
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

        if ($this->input->get('filter_access')) {
            $filter['filter_access'] = $data['filter_access'] = $this->input->get('filter_access');
            $url .= 'filter_access=' . $filter['filter_access'] . '&';
        } else {
            $filter['filter_access'] = $data['filter_access'] = '';
        }

        if ($this->input->get('filter_date')) {
            $filter['filter_date'] = $data['filter_date'] = $this->input->get('filter_date');
            $url .= 'filter_date=' . $filter['filter_date'] . '&';
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
            $data['order_by_active'] = $this->input->get('order_by') . ' active';
        } else {
            $filter['order_by'] = $data['order_by'] = 'DESC';
            $data['order_by_active'] = '';
        }

        if ($filter['filter_type'] === 'online') {
            $data['text_empty'] = $this->lang->line('text_empty');
        } else {
            $data['text_empty'] = $this->lang->line('text_empty_report');
        }

        $order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'ASC') ? 'DESC' : 'ASC';
        $data['sort_date'] = site_url('customers_online' . $url . 'sort_by=date_added&order_by=' . $order_by);

        $customers_online = $this->Customer_online_model->getList($filter);

        $data['customers_online'] = array();
        foreach ($customers_online as $online) {
            $country_code = ($online['country_code']) ? strtolower($online['country_code']) : 'no_flag';

            $data['customers_online'][] = array(
                'activity_id'   => $online['activity_id'],
                'ip_address'    => $online['ip_address'],
                'customer_name' => ($online['customer_id']) ? $online['first_name'] . ' ' . $online['last_name'] : $this->lang->line('text_guest'),
                'access_type'   => ucwords($online['access_type']),
                'browser'       => $online['browser'],
                'user_agent'    => $online['user_agent'],
                'request_uri'   => (!empty($online['request_uri'])) ? $online['request_uri'] : '--',
                'referrer_uri'  => (!empty($online['referrer_uri'])) ? $online['referrer_uri'] : '--',
                'request_url'   => (!empty($online['request_uri'])) ? root_url($online['request_uri']) : '#',
                'referrer_url'  => (!empty($online['referrer_uri'])) ? root_url($online['referrer_uri']) : '#',
                'date_added'    => time_elapsed($online['date_added']),
                'country_code'  => image_url('data/flags/' . $country_code . '.png'),
                'country_name'  => ($online['country_name']) ? $online['country_name'] : $this->lang->line('text_private')
            );
        }

        $data['types'] = array(
            'online' => array('badge' => '', 'url' => site_url('customers_online'), 'title' => $this->lang->line('text_online')),
            'all'    => array('badge' => '', 'url' => site_url('customers_online/all'), 'title' => $this->lang->line('text_all'))
        );

        $data['online_dates'] = array();
        $online_dates = $this->Customer_online_model->getOnlineDates($filter);
        foreach ($online_dates as $date) {
            $month_year = mdate('%Y-%m', strtotime($date['year'] . '-' . $date['month']));
            $data['online_dates'][$month_year] = mdate('%F %Y', strtotime($date['date_added']));
        }

        if ($this->input->get('sort_by') AND $this->input->get('order_by')) {
            $url .= 'sort_by=' . $filter['sort_by'] . '&';
            $url .= 'order_by=' . $filter['order_by'] . '&';
        }

        $config['base_url'] = page_url() . $url;
        $config['total_rows'] = $this->Customer_online_model->getCount($filter);
        $config['per_page'] = $filter['limit'];

        $this->pagination->initialize($config);

        $data['pagination'] = array(
            'info'  => $this->pagination->create_infos(),
            'links' => $this->pagination->create_links()
        );

        return $data;
    }
}

/* End of file customers_online.php */
/* Location: ./admin/controllers/customers_online.php */