<?php
class Payments extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('user');
		$this->load->model('Payments_model');
	}

	public function index() {
			
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/payments')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else {
			$data['alert'] = '';
		}

		$data['heading'] = 'Payment Methods';

		$data['cod_name'] 		= 'Cash On Delivery';
		$data['cod_status'] 	= 'Enabled';
		$data['cod_edit'] 		= $this->config->site_url('admin/cod');

		$data['paypal_name'] 	= 'PayPal Express Checkout';
		$data['paypal_status'] 	= $this->config->item('paypal_status') ? 'Enabled' : 'Disabled';
		$data['paypal_edit'] 	= $this->config->site_url('admin/paypal_express');

		$regions = array(
			'admin/header',
			'admin/footer'
		);
		
		$this->template->regions($regions);
		$this->template->load('admin/payments', $data);
	}
}