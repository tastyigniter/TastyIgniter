<?php 

class Orders extends MX_Controller {

	public function __construct() {
		parent::__construct(); 																	//  calls the constructor
		$this->load->library('customer'); 														// load the customer library
		$this->load->model('Orders_model');														// load orders model
		$this->load->library('currency'); 														// load the currency library
	}

	public function index() {
		$this->lang->load('main/orders');  														// loads language file
		
		if (!file_exists(APPPATH .'views/main/orders.php')) {
			show_404();
		}
			
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  								// retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}
		
		if (!$this->customer->isLogged()) {  													// if customer is not logged in redirect to account login page
  			redirect('account/login');
		}

		// START of retrieving lines from language file to pass to view.
		$data['text_heading'] 			= $this->lang->line('text_heading');
		$data['text_empty'] 			= $this->lang->line('text_empty');
		$data['text_delivery'] 			= $this->lang->line('text_delivery');
		$data['text_collection'] 		= $this->lang->line('text_collection');
		$data['text_leave_review'] 		= $this->lang->line('text_leave_review');
		$data['column_id'] 				= $this->lang->line('column_id');
		$data['column_status'] 			= $this->lang->line('column_status');
		$data['column_location'] 		= $this->lang->line('column_location');
		$data['column_date'] 			= $this->lang->line('column_date');
		$data['column_order'] 			= $this->lang->line('column_order');
		$data['column_items'] 			= $this->lang->line('column_items');
		$data['column_total'] 			= $this->lang->line('column_total');
		$data['button_back'] 			= $this->lang->line('button_back');
		$data['button_order'] 			= $this->lang->line('button_order');
		// END of retrieving lines from language file to pass to view.

		$data['back'] 					= $this->config->site_url('account');

		$data['orders'] = array();
		$results = $this->Orders_model->getMainOrders($this->customer->getId());				// retrieve customer orders based on customer id from getMainOrders method in Orders model
		foreach ($results as $result) {

			if ($result['order_type'] === '1') {												// if order type is equal to 1, order type is delivery else collection
				$order_type = $this->lang->line('text_delivery');
			} else {
				$order_type = $this->lang->line('text_collection');
			}
					
			$data['orders'][] = array(															// create array of customer orders to pass to view
				'order_id' 				=> $result['order_id'],
				'location_name' 		=> $result['location_name'],
				'date_added' 			=> mdate('%d %M %y', strtotime($result['date_added'])),
				'order_time'			=> mdate('%H:%i', strtotime($result['order_time'])),
				'total_items'			=> $result['total_items'],
				'order_total' 			=> $this->currency->format($result['order_total']),		// add currency symbol and format order total to two decimal places
				'order_type' 			=> ucwords(strtolower($order_type)),					// convert string to lower case and capitalize first letter
				'status_name' 			=> $result['status_name'],
				'view' 					=> $this->config->site_url('account/orders/view?order_id=' . $result['order_id']),
				'leave_review' 			=> $this->config->site_url('account/reviews/add?order_id='. $result['order_id'] .'&location_id='. $result['location_id'])
			);
		}
				
		$regions = array('main/header', 'main/content_left', 'main/footer');
		$this->template->regions($regions);
		$this->template->load('main/orders', $data);
	}
	
	public function view() {
		$this->lang->load('main/orders');  														// loads language file

		if (!file_exists(APPPATH .'views/main/orders_view.php')) {
			show_404();
		}
			
		if (!$this->customer->isLogged()) {  													// if customer is not logged in redirect to account login page
  			redirect('account/login');
		}

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  								// retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		if ($this->input->get('order_id')) {															// check if customer_id is set in uri string
			$order_id = (int)$this->input->get('order_id');
		} else {
  			redirect('account/orders');
		}

		$result = $this->Orders_model->getMainOrder($order_id, $this->customer->getId());					// retrieve total number of customer messages from getMainInboxTotal method in Messages model

		// START of retrieving lines from language file to pass to view.
		$data['text_heading'] 			= $this->lang->line('text_view_heading');
		$data['column_id'] 				= $this->lang->line('column_id');
		$data['column_date'] 			= $this->lang->line('column_date');
		$data['column_order'] 			= $this->lang->line('column_order');
		$data['column_delivery'] 		= $this->lang->line('column_delivery');
		$data['column_location'] 		= $this->lang->line('column_location');
		$data['button_reorder'] 		= $this->lang->line('button_reorder');
		// END of retrieving lines from language file to pass to view.


		if ($result) {
			$data['error'] 			= '';
			$data['order_id'] 		= $result['order_id'];
			$data['date_added'] 	= mdate('%d %M %y', strtotime($result['date_added']));
			$data['order_time'] 	= mdate('%H:%i', strtotime($result['order_time']));

			if ($result['order_type'] === '1') {												// if order type is equal to 1, order type is delivery else collection
				$data['order_type'] = $this->lang->line('text_delivery');
			} else {
				$data['order_type'] = $this->lang->line('text_collection');
			}
				
			$this->load->library('country');
			$this->load->model('Locations_model');														// load orders model
			$this->load->model('Customers_model');														// load orders model
			$location_address = $this->Locations_model->getLocationAddress($result['location_id']);
			$data['location_name'] = $location_address['location_name'];
			$data['location_address'] = $this->country->addressFormat($location_address);
		
			$delivery_address = $this->Customers_model->getCustomerAddress($result['customer_id'], $result['address_id']);
			$data['delivery_address'] = $this->country->addressFormat($delivery_address);
		
			$data['menus'] = array();			
			$order_menus = $this->Orders_model->getOrderMenus($result['order_id']);
			foreach ($order_menus as $order_menu) {
				$options = array();
				if (!empty($order_menu['order_option_id'])) {
					$options = array('name' => $order_menu['option_name'], 'price' => $order_menu['option_price']);
				}

				$data['menus'][] = array(
					'id' 			=> $order_menu['menu_id'],
					'name' 			=> $order_menu['name'],			
					'qty' 			=> $order_menu['quantity'],
					'price' 		=> $this->currency->format($order_menu['price']),
					'subtotal' 		=> $this->currency->format($order_menu['subtotal']),
					'options'		=> $options
				);
			}

			$data['totals'] = array();			
			$order_total = $this->Orders_model->getOrderTotal($result['order_id']);
			foreach ($order_total as $total) {
				$data['totals'][] = array(
					'title' 		=> $total['title'],
					'value' 		=> $this->currency->format($total['value'])			
				);
			}

			$data['order_total'] 		= $this->currency->format($result['order_total']);
			$data['total_items']		= $result['total_items'];
		} else {
			$data['error'] = '<p class="error">Sorry, an error has occurred.</p>';
		}
		
		$data['button_back'] 			= $this->lang->line('button_back');
		$data['back'] 					= $this->config->site_url('account/inbox');

		$regions = array('main/header', 'main/content_left', 'main/footer');
		$this->template->regions($regions);
		$this->template->load('main/orders_view', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */