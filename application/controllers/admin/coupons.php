<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Coupons extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		$this->load->library('pagination');
		$this->load->model('Coupons_model');
	}

	public function index() {
		if (!$this->user->islogged()) {  
  			redirect(ADMIN_URI.'/login');
		}

    	if (!$this->user->hasPermissions('access', ADMIN_URI.'/coupons')) {
  			redirect(ADMIN_URI.'/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		$url = '?';
		$filter = array();
		if ($this->input->get('page')) {
			$filter['page'] = (int) $this->input->get('page');
		} else {
			$filter['page'] = '';
		}
		
		if ($this->config->item('page_limit')) {
			$filter['limit'] = $this->config->item('page_limit');
		}
				
		if ($this->input->get('filter_search')) {
			$filter['filter_search'] = $data['filter_search'] = $this->input->get('filter_search');
			$url .= 'filter_search='.$filter['filter_search'].'&';
		} else {
			$data['filter_search'] = '';
		}
		
		if ($this->input->get('filter_type')) {
			$filter['filter_type'] = $data['filter_type'] = $this->input->get('filter_type');
			$url .= 'filter_type='.$filter['filter_type'].'&';
		} else {
			$filter['filter_type'] = $data['filter_type'] = '';
		}
		
		if (is_numeric($this->input->get('filter_status'))) {
			$filter['filter_status'] = $data['filter_status'] = $this->input->get('filter_status');
			$url .= 'filter_status='.$filter['filter_status'].'&';
		} else {
			$filter['filter_status'] = $data['filter_status'] = '';
		}
		
		if ($this->input->get('sort_by')) {
			$filter['sort_by'] = $data['sort_by'] = $this->input->get('sort_by');
		} else {
			$filter['sort_by'] = $data['sort_by'] = 'coupon_id';
		}
		
		if ($this->input->get('order_by')) {
			$filter['order_by'] = $data['order_by'] = $this->input->get('order_by');
			$data['order_by_active'] = $this->input->get('order_by') .' active';
		} else {
			$filter['order_by'] = $data['order_by'] = 'DESC';
			$data['order_by_active'] = 'DESC';
		}
		
		$this->template->setTitle('Coupons');
		$this->template->setHeading('Coupons');
		$this->template->setButton('+ New', array('class' => 'btn btn-success', 'href' => page_url() .'/edit'));
		$this->template->setButton('Delete', array('class' => 'btn btn-default', 'onclick' => '$(\'#list-form\').submit();'));

		$data['text_empty'] 		= 'There are no coupons available.';

		$order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'ASC') ? 'DESC' : 'ASC';
		$data['sort_name'] 			= site_url(ADMIN_URI.'/coupons'.$url.'sort_by=name&order_by='.$order_by);
		$data['sort_code'] 			= site_url(ADMIN_URI.'/coupons'.$url.'sort_by=code&order_by='.$order_by);
		$data['sort_type'] 			= site_url(ADMIN_URI.'/coupons'.$url.'sort_by=type&order_by='.$order_by);
		$data['sort_discount'] 		= site_url(ADMIN_URI.'/coupons'.$url.'sort_by=discount&order_by='.$order_by);

		$data['coupons'] = array();
		$results = $this->Coupons_model->getList($filter);
		foreach ($results as $result) {					
			$data['coupons'][] = array(
				'coupon_id'		=> $result['coupon_id'],
				'name'			=> $result['name'],
				'code'			=> $result['code'],
				'type'			=> ($result['type'] === 'P') ? 'Percentage' : 'Fixed Amount',
				'discount'		=> ($result['type'] === 'P') ? round($result['discount']) .'%' : $result['discount'],
				'min_total'		=> $result['min_total'],
				'description'	=> $result['description'],
				'status'		=> ($result['status'] === '1') ? 'Enabled' : 'Disabled',
				'edit' 			=> site_url(ADMIN_URI.'/coupons/edit?id=' . $result['coupon_id'])
			);
		}

		if ($this->input->get('sort_by') AND $this->input->get('order_by')) {
			$url .= 'sort_by='.$filter['sort_by'].'&';
			$url .= 'order_by='.$filter['order_by'].'&';
		}
		
		$config['base_url'] 		= site_url(ADMIN_URI.'/coupons').$url;
		$config['total_rows'] 		= $this->Coupons_model->getAdminListCount($filter);
		$config['per_page'] 		= $filter['limit'];
		
		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		if ($this->input->post('delete') AND $this->_deleteCoupon() === TRUE) {
			redirect(ADMIN_URI.'/coupons');  			
		}	

		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme').'coupons.php')) {
			$this->template->render('themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme'), 'coupons', $data);
		} else {
			$this->template->render('themes/'.ADMIN_URI.'/default/', 'coupons', $data);
		}
	}

	public function edit() {
		if (!$this->user->islogged()) {  
  			redirect(ADMIN_URI.'/login');
		}

    	if (!$this->user->hasPermissions('access', ADMIN_URI.'/coupons')) {
  			redirect(ADMIN_URI.'/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else { 
			$data['alert'] = '';
		}		
		
		$coupon_info = $this->Coupons_model->getCoupon((int) $this->input->get('id'));
		
		if ($coupon_info) {
			$coupon_id = $coupon_info['coupon_id'];
			$data['action']	= site_url(ADMIN_URI.'/coupons/edit?id='. $coupon_id);
		} else {
		    $coupon_id = 0;
			$data['action']	= site_url(ADMIN_URI.'/coupons/edit');
		}
		
		$title = (isset($coupon_info['name'])) ? $coupon_info['name'] : 'New';	
		$this->template->setTitle('Coupon: '. $title);
		$this->template->setHeading('Coupon: '. $title);
		$this->template->setButton('Save', array('class' => 'btn btn-success', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton('Save & Close', array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setBackButton('btn-back', site_url(ADMIN_URI.'/coupons'));

		$data['text_empty'] 		= 'There is no history available for this coupon.';

		$data['coupon_id'] 			= $coupon_info['coupon_id'];
		$data['name'] 				= $coupon_info['name'];
		$data['code'] 				= $coupon_info['code'];
		$data['type'] 				= $coupon_info['type'];
		$data['discount'] 			= substr($coupon_info['discount'], 0, strripos($coupon_info['discount'], '.'));
		$data['min_total'] 			= $coupon_info['min_total'];
		$data['redemptions'] 		= $coupon_info['redemptions'];
		$data['customer_redemptions'] = $coupon_info['customer_redemptions'];
		$data['description'] 		= $coupon_info['description'];
		$data['start_date'] 		= (isset($coupon_info['start_date']) AND $coupon_info['start_date'] !== '0000-00-00') ? mdate('%d-%m-%Y', strtotime($coupon_info['start_date'])) : '';
		$data['end_date'] 			= (isset($coupon_info['end_date']) AND $coupon_info['end_date'] !== '0000-00-00') ? mdate('%d-%m-%Y', strtotime($coupon_info['end_date'])) : '';
		$data['date_added'] 		= $coupon_info['date_added'];
		$data['status'] 			= $coupon_info['status'];

		$data['coupon_histories'] = array();
		$coupon_histories = $this->Coupons_model->getCouponHistories($coupon_id);
		foreach ($coupon_histories as $coupon_history) {
			$data['coupon_histories'][] = array(
				'coupon_history_id'	=> $coupon_history['coupon_history_id'],
				'order_id'			=> $coupon_history['order_id'],
				'customer_name'		=> $coupon_history['first_name'] .' '. $coupon_history['last_name'],
				'code'				=> $coupon_history['code'],
				'amount'			=> $coupon_history['amount'],
				'used'				=> $coupon_history['used'],
				'used_url'			=> site_url(ADMIN_URI.'/coupons/edit?id='. $coupon_id .'&customer_id='. $coupon_history['customer_id']),
				'date_used'			=> mdate('%d %M %y', strtotime($coupon_history['date_used']))
			);
		}

		if ($this->input->post() AND $this->_addCoupon() === TRUE) {
			if ($this->input->post('save_close') !== '1' AND is_numeric($this->input->post('insert_id'))) {	
				redirect(ADMIN_URI.'/coupons/edit?id='. $this->input->post('insert_id'));
			} else {
				redirect(ADMIN_URI.'/coupons');
			}
		}

		if ($this->input->post() AND $this->_updateCoupon() === TRUE) {
			if ($this->input->post('save_close') === '1') {
				redirect(ADMIN_URI.'/coupons');
			}
			
			redirect(ADMIN_URI.'/coupons/edit?id='. $coupon_id);
		}
				
		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme').'coupons_edit.php')) {
			$this->template->render('themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme'), 'coupons_edit', $data);
		} else {
			$this->template->render('themes/'.ADMIN_URI.'/default/', 'coupons_edit', $data);
		}
	}

	public function _addCoupon() {
    	if (!$this->user->hasPermissions('modify', ADMIN_URI.'/coupons')) {
			$this->session->set_flashdata('alert', '<p class="alert-warning">Warning: You do not have permission to add!</p>');
  			return TRUE;
    	} else if ( ! is_numeric($this->input->get('id')) AND $this->validateForm() === TRUE) { 
			$add = array();
			
			$add['name'] 			= $this->input->post('name');
			$add['code'] 			= str_replace(' ', '', $this->input->post('code'));
			$add['type'] 			= $this->input->post('type');
			$add['discount'] 		= $this->input->post('discount');
			$add['min_total'] 		= $this->input->post('min_total');
			$add['redemptions'] 	= $this->input->post('redemptions');
			$add['customer_redemptions'] = $this->input->post('customer_redemptions');
			$add['description'] 	= $this->input->post('description');
			$add['start_date'] 		= $this->input->post('start_date');
			$add['end_date'] 		= $this->input->post('end_date');
			$add['status'] 			= $this->input->post('status');

			if ($_POST['insert_id'] = $this->Coupons_model->addCoupon($add)) {	
				$this->session->set_flashdata('alert', '<p class="alert-success">Coupon added sucessfully.</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="alert-warning">An error occured, nothing updated.</p>');				
			}
		
			return TRUE;
		}
	}
	
	public function _updateCoupon() {
    	if (!$this->user->hasPermissions('modify', ADMIN_URI.'/coupons')) {
			$this->session->set_flashdata('alert', '<p class="alert-warning">Warning: You do not have permission to update!</p>');
  			return TRUE;
    	} else if (is_numeric($this->input->get('id')) AND $this->validateForm() === TRUE) { 
			$update = array();
			
			$update['coupon_id'] 		= $this->input->get('id');
			$update['name'] 			= $this->input->post('name');
			$update['code'] 			= str_replace(' ', '', $this->input->post('code'));
			$update['type'] 			= $this->input->post('type');
			$update['discount'] 		= $this->input->post('discount');
			$update['min_total'] 		= $this->input->post('min_total');
			$update['redemptions'] 		= $this->input->post('redemptions');
			$update['customer_redemptions'] = $this->input->post('customer_redemptions');
			$update['description'] 		= $this->input->post('description');
			$update['start_date'] 		= $this->input->post('start_date');
			$update['end_date'] 		= $this->input->post('end_date');
			$update['status'] 			= $this->input->post('status');	

			if ($this->Coupons_model->updateCoupon($update)) {	
				$this->session->set_flashdata('alert', '<p class="alert-success">Coupon updated sucessfully.</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="alert-warning">An error occured, nothing updated.</p>');				
			}
		
			return TRUE;
		}		
	}	
	
	public function _deleteCoupon() {
    	if (!$this->user->hasPermissions('modify', ADMIN_URI.'/coupons')) {
			$this->session->set_flashdata('alert', '<p class="alert-warning">Warning: You do not have permission to delete!</p>');
    	} else if (is_array($this->input->post('delete'))) {
			foreach ($this->input->post('delete') as $key => $value) {
				$this->Coupons_model->deleteCoupon($value);
			}			
		
			$this->session->set_flashdata('alert', '<p class="alert-success">Coupon(s) deleted sucessfully!</p>');
		}
				
		return TRUE;
	}

	public function validateForm() {
		$this->form_validation->set_rules('name', 'Coupon Name', 'xss_clean|trim|required|min_length[2]|max_length[128]');
		$this->form_validation->set_rules('code', 'Code', 'xss_clean|trim|required|min_length[2]|max_length[15]');
		$this->form_validation->set_rules('type', 'Type', 'xss_clean|trim|required|exact_length[1]');
		$this->form_validation->set_rules('discount', 'Discount', 'xss_clean|trim|required|numeric');
		
		if ($this->input->post('type') === 'P') {
			$this->form_validation->set_rules('discount', 'Discount', 'less_than[100]');
		}
		
		$this->form_validation->set_rules('min_total', 'Minimum Total', 'xss_clean|trim|numeric');
		$this->form_validation->set_rules('redemptions', 'Redemptions', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('customer_redemptions', 'Customer Redemptions', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('description', 'Description', 'xss_clean|trim|min_length[2]|max_length[1028]');
		$this->form_validation->set_rules('start_date', 'Start Date', 'xss_clean|trim|valid_date');
		$this->form_validation->set_rules('end_date', 'End Date', 'xss_clean|trim|valid_date');
		$this->form_validation->set_rules('status', 'Status', 'xss_clean|trim|required|integer');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}		
	}
}

/* End of file coupons.php */
/* Location: ./application/controllers/admin/coupons.php */