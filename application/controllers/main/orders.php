<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Orders extends MX_Controller {

	public function __construct() {
		parent::__construct(); 																	//  calls the constructor
		$this->load->library('customer'); 														// load the customer library
		$this->load->model('Orders_model');														// load orders model
		$this->load->model('Addresses_model');														// load addresses model
		$this->load->library('currency'); 														// load the currency library
		$this->load->library('language');
		$this->lang->load('main/orders', $this->language->folder());
	}

	public function index() {
		if (!$this->customer->isLogged()) {  													// if customer is not logged in redirect to account login page
  			redirect('main/login');
		}

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  								// retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}
		
		$url = '?';
		$filter = array();
		$filter['customer_id'] = (int) $this->customer->getId();
		
		if ($this->input->get('page')) {
			$filter['page'] = (int) $this->input->get('page');
		} else {
			$filter['page'] = '';
		}
		
		if ($this->config->item('page_limit')) {
			$filter['limit'] = $this->config->item('page_limit');
		}
		
		// START of retrieving lines from language file to pass to view.
		$this->template->setTitle($this->lang->line('text_heading'));
		$this->template->setHeading($this->lang->line('text_heading'));
		$data['text_heading'] 			= $this->lang->line('text_heading');
		$data['text_empty'] 			= $this->lang->line('text_empty');
		$data['text_delivery'] 			= $this->lang->line('text_delivery');
		$data['text_collection'] 		= $this->lang->line('text_collection');
		$data['text_reorder'] 			= $this->lang->line('text_reorder');
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

		$data['back'] 					= site_url('main/account');
		$data['new_order_url'] 			= site_url('main/menus');

		$data['orders'] = array();
		$results = $this->Orders_model->getMainList($filter);			// retrieve customer orders based on customer id from getMainOrders method in Orders model
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
				'view' 					=> site_url('main/orders/view/' . $result['order_id']),
				'reorder' 				=> site_url('main/orders/reorder/'. $result['order_id']),
				'leave_review' 			=> site_url('main/reviews/add/'. $result['order_id'] .'/'. $result['location_id'])
			);
		}
		
		$prefs['base_url'] 			= site_url('main/orders').$url;
		$prefs['total_rows'] 		= $this->Orders_model->getMainListCount($filter);
		$prefs['per_page'] 			= $filter['limit'];
		
		$this->load->library('pagination');
		$this->pagination->initialize($prefs);
				
		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		$this->template->regions(array('header', 'content_top', 'content_left', 'content_right', 'footer'));
		if (file_exists(APPPATH .'views/themes/main/'.$this->config->item('main_theme').'orders.php')) {
			$this->template->render('themes/main/'.$this->config->item('main_theme'), 'orders', $data);
		} else {
			$this->template->render('themes/main/default/', 'orders', $data);
		}
	}
	
	public function view() {
		if (!$this->customer->isLogged()) {  													// if customer is not logged in redirect to account login page
  			redirect('main/login');
		}

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  								// retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		if ($this->uri->segment(4)) {															// check if customer_id is set in uri string
			$order_id = (int)$this->uri->segment(4);
		} else {
  			redirect('main/orders');
		}

		$result = $this->Orders_model->getMainOrder($order_id, $this->customer->getId());

		// START of retrieving lines from language file to pass to view.
		$this->template->setTitle($this->lang->line('text_view_heading'));
		$this->template->setHeading($this->lang->line('text_view_heading'));
		$data['text_heading'] 			= $this->lang->line('text_view_heading');
		$data['column_id'] 				= $this->lang->line('column_id');
		$data['column_date'] 			= $this->lang->line('column_date');
		$data['column_order'] 			= $this->lang->line('column_order');
		$data['column_delivery'] 		= $this->lang->line('column_delivery');
		$data['column_location'] 		= $this->lang->line('column_location');
		$data['button_reorder'] 		= $this->lang->line('button_reorder');
		// END of retrieving lines from language file to pass to view.
		
		$data['reorder_url'] 			= site_url('main/orders/reorder/'. $order_id);
		$data['button_back'] 			= $this->lang->line('button_back');
		$data['back_url'] 				= site_url('main/orders');

		if ($result) {
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
		
			$delivery_address = $this->Addresses_model->getCustomerAddress($result['customer_id'], $result['address_id']);
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
			$order_totals = $this->Orders_model->getOrderTotals($result['order_id']);
			foreach ($order_totals as $total) {
				$data['totals'][] = array(
					'title' 		=> $total['title'],
					'value' 		=> $this->currency->format($total['value'])			
				);
			}

			$data['order_total'] 		= $this->currency->format($result['order_total']);
			$data['total_items']		= $result['total_items'];
		} else {
			redirect('main/orders');
		}	

		$this->template->regions(array('header', 'content_top', 'content_left', 'content_right', 'footer'));
		if (file_exists(APPPATH .'views/themes/main/'.$this->config->item('main_theme').'orders_view.php')) {
			$this->template->render('themes/main/'.$this->config->item('main_theme'), 'orders_view', $data);
		} else {
			$this->template->render('themes/main/default/', 'orders_view', $data);
		}
	}

	public function reorder() {
		$this->load->library('cart'); 															// load the cart library
		if (!$this->customer->isLogged()) {  													// if customer is not logged in redirect to account login page
  			redirect('main/login');
		}

		$order_id = (int)$this->uri->segment(4);
		$order_menus = $this->Orders_model->getOrderMenus($order_id);
		
		if (!$order_menus) {
  			redirect('main/orders');
		} else {
			foreach ($order_menus as $menu) {
				$cart_data = array();
				$update_cart = FALSE;
				$options = array();
				if (!empty($menu['order_option_id'])) {
					$options = array('name' => $menu['option_name'], 'price' => $this->cart->format_number($menu['option_price']));
				}

				$quantity = $menu['quantity'];
				foreach ($this->cart->contents() as $cart_item) {								// loop through items in cart
					$cart_option_id = (empty($cart_item['option_id'])) ? '' : $cart_item['option_id'];					
					$menu_option_id = (empty($menu['order_option_id'])) ? '' : $menu_option_id;					
					if ($cart_item['id'] === $menu['menu_id'] AND $cart_option_id === $menu_option_id) {
						$row_id = $cart_item['rowid'];
						$quantity = $cart_item['qty'] + $menu['quantity'];
						$update_cart = TRUE;
					}
				}

				if ($update_cart === TRUE) {
					$this->cart->update(array('rowid' => $row_id, 'qty' => $quantity));
				} else {
					$cart_data = array(
						'id' 			=> $menu['menu_id'],
						'name' 			=> $menu['name'],			
						'qty' 			=> $quantity,
						'price' 		=> $this->cart->format_number($menu['price']),
						'options'		=> $options
					);
				
					$added_data = $this->cart->insert($cart_data);
				}
			}
			
			$this->session->set_flashdata('alert', sprintf($this->lang->line('alert_reorder'), $order_id));
			redirect('main/menus');
		}
	}
}

/* End of file orders.php */
/* Location: ./application/controllers/orders.php */