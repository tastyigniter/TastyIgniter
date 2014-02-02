<?php
class Payments extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('user');
		$this->load->model('Payments_model');
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
	}

	public function index() {
			
		//check if file exists in views
		if ( !file_exists(APPPATH .'/views/admin/payments.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		}

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

		$data['cod_name'] 		= 'PayPal Express Checkout';
		$data['cod_status'] 	= 'Enabled';
		$data['cod_edit'] 		= $this->config->site_url('admin/cod');

		$data['paypal_name'] 	= 'PayPal Express Checkout';
		$data['paypal_status'] 	= $this->config->item('config_paypal_status') ? 'Enabled' : 'Disabled';
		$data['paypal_edit'] 	= $this->config->site_url('admin/paypal_express');

		//load home page content
		$this->load->view('admin/header', $data);
		$this->load->view('admin/payments', $data);
		$this->load->view('admin/footer');
	}
}