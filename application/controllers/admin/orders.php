<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orders extends CI_Controller {

	private $error = array();

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		$this->load->library('pagination');
		$this->load->library('currency'); // load the currency library
		$this->load->model('Customers_model');
		$this->load->model('Locations_model');
		$this->load->model('Orders_model');
		$this->load->model('Statuses_model');
		$this->load->model('Payments_model');
		$this->load->model('Countries_model');
	}

	public function index() {
		
		if (!file_exists(APPPATH .'views/admin/orders.php')) {
			show_404();
		}
			
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}
		
    	if (!$this->user->hasPermissions('access', 'admin/orders')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else { 
			$data['alert'] = '';
		}
		
		$filter = array();
		if ($this->input->get('page')) {
			$filter['page'] = (int) $this->input->get('page');
		} else {
			$filter['page'] = 1;
		}
		
		if ($this->config->item('page_limit')) {
			$filter['limit'] = $this->config->item('page_limit');
		}
				
		$data['heading'] 			= 'Orders';
		$data['sub_menu_delete'] 	= 'Delete';
		$data['text_empty'] 		= 'There are no orders available.';
		
		$results = $this->Orders_model->getList($filter);
		
		//load category data into array
		$data['orders'] = array();
		foreach ($results as $result) {					
			$current_date = mdate('%d-%m-%Y', time());
			$date_added = mdate('%d-%m-%Y', strtotime($result['date_added']));
			
			if ($current_date === $date_added) {
				$date_added = 'Today';
			} else {
				$date_added = mdate('%d %M %y', strtotime($date_added));
			}
			
			$data['orders'][] = array(
				'order_id'			=> $result['order_id'],
				'location_name'		=> $result['location_name'],
				'first_name'		=> $result['first_name'],
				'last_name'			=> $result['last_name'],
				'order_type' 		=> ($result['order_type'] === '1') ? 'Delivery' : 'Collection',
				'order_time'		=> mdate('%H:%i', strtotime($result['order_time'])),
				'order_status'		=> $result['status_name'],
				'date_added'		=> $date_added,
				'edit' 				=> $this->config->site_url('admin/orders/edit?id=' . $result['order_id'])
			);
		}
			
		$config['base_url'] 		= $this->config->site_url('admin/orders');
		$config['total_rows'] 		= $this->Orders_model->record_count($filter);
		$config['per_page'] 		= $filter['limit'];
		$config['num_links'] 		= round($config['total_rows'] / $config['per_page']);
		
		$this->pagination->initialize($config);
				
		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		if ($this->input->post('delete') && $this->_deleteOrder() === TRUE) {
			redirect('admin/orders');
		}	

		$regions = array(
			'admin/header',
			'admin/footer'
		);
		
		$this->template->regions($regions);
		$this->template->load('admin/orders', $data);
	}

	public function edit() {
		
		if (!file_exists(APPPATH .'views/admin/orders_edit.php')) {
			show_404();
		}
			
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/orders')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else { 
			$data['alert'] = '';
		}		

		//check if customer_id is set in uri string
		if (is_numeric($this->input->get('id'))) {
			$order_id = $this->input->get('id');
			$data['action']	= $this->config->site_url('admin/orders/edit?id='. $order_id);
		} else {
		    $order_id = 0;
			//$data['action']	= $this->config->site_url('admin/orders/edit');
			redirect('admin/orders');
		}
		
		$order_info = $this->Orders_model->getAdminOrder($order_id);

		$data['heading'] 			= 'Order - '. $order_info['order_id'];
		$data['sub_menu_save'] 		= 'Save';
		$data['sub_menu_back'] 		= $this->config->site_url('admin/orders');
		$data['text_empty'] 		= 'There are no status history for this order.';

		$data['order_id'] 			= $order_info['order_id'];
		$data['customer_id'] 		= $order_info['customer_id'];
		$data['customer_edit'] 		= $this->config->site_url('admin/customers/edit?id=' . $order_info['customer_id']);
		$data['first_name'] 		= $order_info['first_name'];
		$data['last_name'] 			= $order_info['last_name'];
		$data['email'] 				= $order_info['email'];
		$data['telephone'] 			= $order_info['telephone'];
		$data['date_added'] 		= mdate('%d %M %y - %H:%i', strtotime($order_info['date_added']));
		$data['date_modified'] 		= mdate('%d %M %y', strtotime($order_info['date_modified']));
		$data['order_time'] 		= mdate('%H:%i', strtotime($order_info['order_time']));
		$data['order_type'] 		= ($order_info['order_type'] === '1') ? 'Delivery' : 'Collection';
		$data['status_id'] 			= $order_info['status_id'];
		$data['comment'] 			= $order_info['comment'];
		$data['notify'] 			= $order_info['notify'];
		$data['ip_address'] 		= $order_info['ip_address'];
		$data['user_agent'] 		= $order_info['user_agent'];
		$data['check_order_type'] 	= $order_info['order_type'];

		if ($order_info['payment'] === 'paypal') {
			$data['payment'] = 'PayPal';
			//$this->Payments_model->saveTransactionDetails($transaction_id, $order_id, $customer_id);
			$data['paypal_details'] = $this->Payments_model->getPaypalDetails($order_info['order_id'], $order_info['customer_id']);
		} else if ($order_info['payment'] === 'cod') {
			$data['payment'] = 'Cash On Delivery';
			$data['paypal_details'] = array();
		} else {
			$data['payment'] = 'No Payment';
			$data['paypal_details'] = array();			
		}
	
		$data['countries'] = array();
		$results = $this->Countries_model->getCountries();
		foreach ($results as $result) {					
			$data['countries'][] = array(
				'country_id'	=>	$result['country_id'],
				'name'			=>	$result['country_name'],
			);
		}
									
		$data['statuses'] = array();
		$statuses = $this->Statuses_model->getStatuses('order');
		foreach ($statuses as $statuses) {
			$data['statuses'][] = array(
				'status_id'			=> $statuses['status_id'],
				'status_name'		=> $statuses['status_name'],
				'notify'			=> $statuses['notify_customer'],
				'status_comment'	=> $statuses['status_comment']
			);
		}

		$data['status_history'] = array();
		$status_history = $this->Statuses_model->getStatusHistories('order', $order_id);
		foreach ($status_history as $history) {
			$data['status_history'][] = array(
				'history_id'	=> $history['status_history_id'],
				'date_time'		=> mdate('%d %M %y - %H:%i', strtotime($history['date_added'])),
				'staff_name'	=> $history['staff_name'],
				'status_name'	=> $history['status_name'],
				'notify'		=> $history['notify'],
				'comment'		=> $history['comment']
			);
		}

		$this->load->library('country');
		$location_address = $this->Locations_model->getLocationAddress($order_info['location_id']);
		$data['location_name'] = $location_address['location_name'];
		$data['location_address'] = $this->country->addressFormat($location_address);
		
		$customer_address = $this->Customers_model->getCustomerAddress($order_info['customer_id'], $order_info['address_id']);
		$data['customer_address'] = $this->country->addressFormat($customer_address);
		
		$data['cart_items'] = array();			
		$cart_items = $this->Orders_model->getOrderMenus($order_info['order_id']);
		foreach ($cart_items as $cart_item) {
			$options = array();
			if (!empty($cart_item['order_option_id'])) {
				$options = array('name' => $cart_item['option_name'], 'price' => $cart_item['option_price']);
			}

			$data['cart_items'][] = array(
				'id' 			=> $cart_item['menu_id'],
				'name' 			=> $cart_item['name'],			
				'qty' 			=> $cart_item['quantity'],
				'price' 		=> $this->currency->format($cart_item['price']),
				'subtotal' 		=> $this->currency->format($cart_item['subtotal']),
				'options'		=> $options
			);
		}

		$data['totals'] = array();			
		$order_total = $this->Orders_model->getOrderTotal($order_info['order_id']);
		foreach ($order_total as $total) {
			$data['totals'][] = array(
				'title' 		=> $total['title'],
				'value' 		=> $this->currency->format($total['value'])			
			);
		}

		$data['order_total'] 		= $this->currency->format($order_info['order_total']);
		$data['total_items']		= $order_info['total_items'];
					
		if ($this->input->post() && $this->_updateOrder($order_info['status_id']) === TRUE) {
			redirect('admin/orders');
		}
				
		$regions = array(
			'admin/header',
			'admin/footer'
		);
		
		$this->template->regions($regions);
		$this->template->load('admin/orders_edit', $data);
	}

	public function _updateOrder($status_id = FALSE) {
			
    	if (!$this->user->hasPermissions('modify', 'admin/orders')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have the right permission to edit!</p>');
			return TRUE;
    	
    	} else if ($this->input->get('id') AND $this->validateForm() === TRUE) { 
			$update = array();
			$history = array();
			$current_time = time();														// retrieve current timestamp
			
			//Sanitizing the POST values
			$update['order_id'] = (int)$this->input->get('id');
			$update['status_id'] = (int)$this->input->post('order_status');
			$update['date_modified'] =  mdate('%Y-%m-%d', $current_time);
		
			if ($status_id !== $this->input->post('order_status')) {
				$status = $this->Statuses_model->getStatus($this->input->post('order_status'));
				$history['staff_id']	= $this->user->getStaffId();
				$history['order_id'] 	= $this->input->get('id');
				$history['status_id']	= $this->input->post('order_status');
				$history['notify']		= $this->input->post('notify');
				$history['comment']		= $status['status_comment'];
				$history['date_added']	= mdate('%Y-%m-%d %H:%i:%s', $current_time);
				
				$this->Statuses_model->addStatusHistory('order', $history);
			}

			if ($this->Orders_model->updateOrder($update)) {
				$this->session->set_flashdata('alert', '<p class="success">Order Updated Sucessfully!</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');
			}
	
			return TRUE;
		}
	}

	public function _deleteOrder() {
    	if (!$this->user->hasPermissions('modify', 'admin/orders')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have the right permission to edit!</p>');
    	
    	} else { 
			if (is_array($this->input->post('delete'))) {
				foreach ($this->input->post('delete') as $key => $value) {
					$order_id = $value;            	
					$this->Orders_model->deleteOrder($order_id);
				}			
			
				$this->session->set_flashdata('alert', '<p class="success">Order Deleted Sucessfully!</p>');
			}
		}
				
		return TRUE;
	}

	public function validateForm() {
		$this->form_validation->set_rules('order_status', 'Order Status', 'trim|required|integer');
		$this->form_validation->set_rules('assigned_staff', 'Assign Staff', 'trim|integer');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}		
	}
}