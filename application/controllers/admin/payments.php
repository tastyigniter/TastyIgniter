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

		$data['heading'] 		= 'Payment Methods';

		$data['free_name'] 		= 'Free Checkout';
		$data['free_status'] 	= 'Disabled';
		$data['free_edit'] 		= site_url('admin/free_checkout');

		$data['cod_name'] 		= 'Cash On Delivery';
		$data['cod_status'] 	= 'Enabled';
		$data['cod_edit'] 		= site_url('admin/cod');

		$data['paypal_name'] 	= 'PayPal Express Checkout';
		$data['paypal_status'] 	= $this->config->item('paypal_status') ? 'Enabled' : 'Disabled';
		$data['paypal_edit'] 	= site_url('admin/paypal_express');

		$data['google_name'] 	= 'Google Checkout';
		$data['google_status'] 	= 'Disabled';
		$data['google_edit'] 	= site_url('admin/google_checkout');

		$regions = array('header', 'footer');
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'payments.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'payments', $regions, $data);
		} else {
			$this->template->render('themes/admin/default/', 'payments', $regions, $data);
		}
	}
}

/* End of file payments.php */
/* Location: ./application/controllers/admin/payments.php */