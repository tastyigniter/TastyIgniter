<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Customers_activity extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('user');
		$this->load->library('pagination');
		$this->load->model('Activity_model');
	}

	public function index() {
		if (!$this->user->islogged()) {  
  			redirect(ADMIN_URI.'/login');
		}

    	if (!$this->user->hasPermissions('access', ADMIN_URI.'/customers_activity')) {
  			redirect(ADMIN_URI.'/permission');
		}
		
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
		
		$time_out = ($this->config->item('activity_timeout') > 120) ? $this->config->item('activity_timeout') : 120; 
		$filter['time_out'] = mdate('%Y-%m-%d %H:%i:%s', time() - $time_out);
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
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else {
			$data['alert'] = '';
		}

		$this->template->setTitle('Activities');
		$this->template->setHeading('Activities');
		$this->template->setButton('Options', array('class' => 'btn btn-default pull-right', 'href' => site_url(ADMIN_URI.'/settings#system')));

		if ($this->input->get('filter_type') === 'online') {
			$data['text_empty'] 	= 'There are no online customer activity available.';
		} else {
			$data['text_empty'] 	= 'There are no customer activity available.';
		}
			
		$order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'ASC') ? 'DESC' : 'ASC';
		$data['sort_date'] 			= site_url(ADMIN_URI.'/customers_activity'.$url.'sort_by=date_added&order_by='.$order_by);

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
				'request_uri'		=> (!empty($activity['request_uri'])) ? $activity['request_uri'] : '--',
				'referrer_uri'		=> (!empty($activity['referrer_uri'])) ? $activity['referrer_uri'] : '--',
				'date_added'		=> mdate('%d %M %y - %H:%i', strtotime($activity['date_added'])),
				'country_code'		=> base_url('assets/img/flags/'. $country_code .'.png'),
				'country_name'		=> $country_name,
				'blacklist' 		=> site_url(ADMIN_URI.'/customers_activity/blacklist?ip=' . $activity['ip_address'])
			);
		}
			
		$data['types'] = array(
			'online' => array('badge' => '', 'url' => site_url(ADMIN_URI.'/customers_activity?filter_type=online')),
			'all' 	=> array('badge' => '', 'url' => site_url(ADMIN_URI.'/customers_activity?filter_type=all'))
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
		
		$config['base_url'] 		= site_url(ADMIN_URI.'/customers_activity'. $url);
		$config['total_rows'] 		= $this->Activity_model->getAdminListCount($filter);
		$config['per_page'] 		= $filter['limit'];
		
		$this->pagination->initialize($config);
				
		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);
			
		if ($this->input->post('delete') AND $this->_deleteActivity() === TRUE) {
			redirect(ADMIN_URI.'/customers_activity');  			
		}	

		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme').'customers_activity.php')) {
			$this->template->render('themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme'), 'customers_activity', $data);
		} else {
			$this->template->render('themes/'.ADMIN_URI.'/default/', 'customers_activity', $data);
		}
	}
	
	public function blacklist() {
    	if ( ! $this->user->hasPermissions('modify', ADMIN_URI.'/customers_activity')) {
			$this->session->set_flashdata('alert', '<p class="alert-warning">Warning: You do not have permission to update!</p>');
    	} else if ($this->input->get('extension')) { 
			
			$this->session->set_flashdata('alert', '<p class="alert-success">Extension Uninstalled Sucessfully!</p>');				
		}
		
		redirect(ADMIN_URI.'/customers_activity');
	}	
	
	public function _deleteActivity() {
    	if (!$this->user->hasPermissions('modify', ADMIN_URI.'/customers_activity')) {
			$this->session->set_flashdata('alert', '<p class="alert-warning">Warning: You do not have permission to delete!</p>');
    	} else if (is_array($this->input->post('delete'))) {
			foreach ($this->input->post('delete') as $key => $activity_id) {
				$this->Activity_model->deleteActivity($activity_id);
			}			
		
			$this->session->set_flashdata('alert', '<p class="alert-success">Activity(s) deleted sucessfully!</p>');
		}
				
		return TRUE;
	}
}

/* End of file customers_activity.php */
/* Location: ./application/controllers/admin/customers_activity.php */