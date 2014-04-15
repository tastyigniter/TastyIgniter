<?php
class Orders_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

    public function record_count($filter = array()) {
		$this->db->from('orders');

		return $this->db->count_all_results();
    }
    
    public function customer_record_count($filter = array()) {
		if ($filter['customer_id'] = '') {
			return array();
		}

		$this->db->where('orders.customer_id', $filter['customer_id']);
		$this->db->from('orders');

		return $this->db->count_all_results();
    }
    
	public function getList($filter = array()) {
		if ($filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}
			
		if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->select('order_id, location_name, customer_id, first_name, last_name, order_type, order_time, status_name, orders.date_added, orders.date_modified');
			$this->db->from('orders');
			$this->db->join('statuses', 'statuses.status_id = orders.status_id', 'left');
			$this->db->join('locations', 'locations.location_id = orders.location_id', 'left');
			$this->db->order_by('order_id', 'DESC');
		
			$query = $this->db->get();
			$result = array();
		
			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}
		
			return $result;
		}
	}
	
	public function getAdminOrder($order_id = FALSE) {
		if ($order_id !== FALSE) {
			$this->db->from('orders');
			$this->db->join('statuses', 'statuses.status_id = orders.status_id', 'left');
		
			$this->db->where('order_id', $order_id);			
			$query = $this->db->get();
		
			if ($query->num_rows() > 0) {
				return $query->row_array();
			}
		}
	}

	public function getMainOrders($customer_id = FALSE) {
		if ($customer_id !== FALSE) {
			$this->db->from('orders');
			$this->db->join('statuses', 'statuses.status_id = orders.status_id', 'left');
			$this->db->join('locations', 'locations.location_id = orders.location_id', 'left');
			$this->db->order_by('order_id', 'DESC');

			$this->db->where('customer_id', $customer_id);

			$query = $this->db->get();
			$result = array();
		
			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}
		
			return $result;
		}
	}
	
	public function getMainOrder($order_id, $customer_id) {
		if (isset($order_id, $customer_id)) {
			$this->db->from('orders');
			$this->db->where('order_id', $order_id);
			$this->db->where('customer_id', $customer_id);
			
			$query = $this->db->get();
		
			if ($query->num_rows() > 0) {
				return $query->row_array();
			}
		}
		
		return FALSE;
	}

	public function getCustomerOrders($filter = array()) {
		if ($filter['customer_id'] === '') {
			return array();
		}

		if ($filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}
		
		if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->select('order_id, location_name, customer_id, first_name, last_name, order_type, order_time, status_name, orders.date_added, orders.date_modified');
			$this->db->from('orders');
			$this->db->join('statuses', 'statuses.status_id = orders.status_id', 'left');
			$this->db->join('locations', 'locations.location_id = orders.location_id', 'left');
			$this->db->order_by('order_id', 'DESC');
	
			$this->db->where('orders.customer_id', $filter['customer_id']);

			$query = $this->db->get();
			$result = array();
	
			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}
	
			return $result;
		}
	}

	public function getOrderMenus($order_id) {
		$this->db->from('order_menus');
		$this->db->join('order_options', 'order_options.order_option_id = order_menus.order_option_id', 'left');
		$this->db->where('order_menus.order_id', $order_id);
			
		$query = $this->db->get();
		$result = array();
	
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}
	
		return $result;
	}

	public function getOrderTotal($order_id) {
		$this->db->from('order_total');
		$this->db->where('order_id', $order_id);
			
		$query = $this->db->get();
		$result = array();
	
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}
	
		return $result;
	}

	public function updateOrder($update = array()) {
		
		if (!empty($update['status_id'])) {
			$this->db->set('status_id', $update['status_id']);
		}
		
		if (!empty($update['date_modified'])) {
			$this->db->set('date_modified', $update['date_modified']);
		}
		
		if (!empty($update['order_id'])) {
			$this->db->where('order_id', $update['order_id']);
			$this->db->update('orders');
		}	

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}

	public function addOrder($order_info = array(), $cart_contents = array()) {

		$current_time = time();

		if (!empty($order_info['location_id'])) {
			$this->db->set('location_id', $order_info['location_id']);
		}

		if (!empty($order_info['customer_id'])) {
			$this->db->set('customer_id', $order_info['customer_id']);
		} else {
			$this->db->set('customer_id', '0');
		}

		if (!empty($order_info['first_name'])) {
			$this->db->set('first_name', $order_info['first_name']);
		}

		if (!empty($order_info['last_name'])) {
			$this->db->set('last_name', $order_info['last_name']);
		}

		if (!empty($order_info['email'])) {
			$this->db->set('email', $order_info['email']);
		}

		if (!empty($order_info['telephone'])) {
			$this->db->set('telephone', $order_info['telephone']);
		}

		if (!empty($order_info['order_type'])) {
			$this->db->set('order_type', $order_info['order_type']);
		}

		if (!empty($order_info['order_time'])) {
			$order_time = (strtotime($order_info['order_time']) < strtotime($current_time)) ? $current_time : $order_info['order_time'];
			$this->db->set('order_time', mdate('%H:%i', strtotime($order_time)));
			$this->db->set('date_added', mdate('%Y-%m-%d %H:%i:%s', $current_time));
			$this->db->set('date_modified', mdate('%Y-%m-%d', $current_time));
			$this->db->set('ip_address', $this->input->ip_address());
			$this->db->set('user_agent', $this->input->user_agent());
		}

		if (!empty($order_info['address_id'])) {
			$this->db->set('address_id', $order_info['address_id']);
		}

		if (!empty($order_info['payment'])) {
			$this->db->set('payment', $order_info['payment']);
		}

		if (!empty($order_info['comment'])) {
			$this->db->set('comment', $order_info['comment']);
		}

		if (isset($cart_contents['order_total'])) {
			$this->db->set('order_total', $cart_contents['order_total']);
		}

		if (isset($cart_contents['total_items'])) {
			$this->db->set('total_items', $cart_contents['total_items']);
		}

		if (!empty($order_info)) {
			$this->db->insert('orders');
		
			if ($this->db->affected_rows() > 0) {
				$order_id = $this->db->insert_id();
								
				$order_info = $this->getMainOrder($order_id, $order_info['customer_id']);

				if ($order_info OR !empty($cart_contents)) {
				
					$this->addDefaultAddress($order_info['customer_id'], $order_info['address_id']);
					$this->addOrderMenus($order_id, $cart_contents);

					if ($order_info['payment'] === 'paypal' AND $this->config->item('paypal_order_status')) {
						$status_id = (int)$this->config->item('paypal_order_status');
						$this->db->set('status_id', $status_id);
					} else if ($order_info['payment'] === 'cod' AND $this->config->item('cod_order_status')) {
						$status_id = (int)$this->config->item('cod_order_status');
						$this->db->set('status_id', $status_id);
					} else {
						$status_id = (int)$this->config->item('order_status_new');
						$this->db->set('status_id', $status_id);
					}

					$notify = $this->_sendOrderMail($order_id);
					$this->db->set('notify', $notify);
				
					$this->db->where('order_id', $order_id);
					$this->db->update('orders'); 
					
					$this->load->model('Statuses_model');
					$status = $this->Statuses_model->getStatus($status_id);
					$order_history = array(
						'order_id' => $order_id, 
						'status_id' => $status_id, 
						'notify' => $notify, 
						'comment' => $status['comment'], 
						'date_added' => mdate('%Y-%m-%d %H:%i:%s', $current_time)
					);
					$this->Statuses_model->addStatusHistory('order', $order_history);
				}

				return $order_id;
			
			} else {
				return FALSE;
			}
		}
	}	
	
	public function addOrderMenus($order_id, $cart_contents = array()) {
		if (is_array($cart_contents) AND !empty($cart_contents)) {
			$order_option_id = 0;
			foreach ($cart_contents as $key => $item) {
				if (is_array($item) AND $key === $item['rowid']) {			
					if (!empty($item['options']['option_id'])) {
						$order_option_id = $this->addOrderMenuOption($order_id, $item['id'], $item['options']['option_id']); //$options = serialize($item['options']);
					}
			
					$order_menus = array (
						'order_id' 		=> $order_id,
						'menu_id' 		=> $item['id'],
						'name' 			=> $item['name'],
						'quantity' 		=> $item['qty'],
						'price' 		=> $item['price'],
						'subtotal' 		=> $item['subtotal'],
						'order_option_id' => $order_option_id
					);
				
					$this->db->insert('order_menus', $order_menus); 
				
					$this->load->model('Menus_model');
					$menu_data = $this->Menus_model->getAdminMenu($item['id']);
				
					if ($menu_data['subtract_stock'] === '1') {
						$this->db->set('stock_qty', 'stock_qty - '. $item['qty'], FALSE);
				
						$this->db->where('menu_id', $item['id']);
						$this->db->update('menus'); 
					}
				}
			}

			$this->addOrderTotal($order_id, $cart_contents['cart_total'], $cart_contents['delivery'], $cart_contents['coupon']);
			$this->cart->destroy();
	
			return TRUE;
		}
	}

	public function addOrderMenuOption($order_id, $menu_id, $option_id) {
		if (!empty($order_id)) {
			$this->db->set('order_id', $order_id);
		}

		if (!empty($menu_id)) {
			$this->db->set('menu_id', $menu_id);
		}

		if (!empty($option_id)) {
			$this->load->model('Menus_model');
			$menu_option = $this->Menus_model->getMenuOption($option_id);
			if ($menu_option) {
				$this->db->set('option_id', $menu_option['option_id']);
				$this->db->set('option_name', $menu_option['option_name']);
				$this->db->set('option_price', $menu_option['option_price']);
			}
		}

		$this->db->insert('order_options');

		if ($this->db->affected_rows() > 0) {
			$order_option_id = $this->db->insert_id();
			return $order_option_id;
		}
	}

	public function addOrderTotal($order_id, $cart_total, $delivery, $coupon) {
		if (is_numeric($cart_total)) {
			$this->db->set('order_id', $order_id);
			$this->db->set('code', 'cart_total');
			$this->db->set('title', 'Sub Total');
			$this->db->set('value', $cart_total);
			$this->db->insert('order_total'); 
		}

		if (is_numeric($delivery)) {
			$this->db->set('order_id', $order_id);
			$this->db->set('code', 'delivery');
			$this->db->set('title', 'Delivery Charge');
			$this->db->set('value', $delivery);
			$this->db->insert('order_total'); 
		}

		if (is_numeric($coupon)) {
			$this->db->set('order_id', $order_id);
			$this->db->set('code', 'coupon');
			$this->db->set('title', 'Coupon');
			$this->db->set('value', '-'. $coupon);
			$this->db->insert('order_total'); 
		}
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}
						
	public function addDefaultAddress($customer_id, $address_id) {
		$this->db->set('address_id', $address_id);
		$this->db->where('customer_id', $customer_id);
		$this->db->update('customers'); 
	}
						
	public function deleteOrder($order_id) {
		$delete_data = array();

		$delete_data['order_id'] = $order_id;
			
		return $this->db->delete('orders', $delete_data);
	}

	public function _sendOrderMail($order_id) {
		//loading upload library
	   	$this->load->library('email');
		$this->load->library('cart');
	   	$this->load->library('location');
	   	$this->load->library('currency'); // load the currency library
		$this->load->model('Customers_model');
		$this->load->model('Locations_model'); // load the locations model
		$this->lang->load('main/order_email');
		
		$order_info = $this->Orders_model->getAdminOrder($order_id);
		if (is_array($order_info) AND !empty($order_info)) {
			$data['text_heading'] 				= sprintf($this->lang->line('text_success_heading'), $order_id);
			$data['text_order_details'] 		= $this->lang->line('text_order_details');
			$data['text_order_items'] 			= $this->lang->line('text_order_items');
			$data['text_delivery_address'] 		= $this->lang->line('text_delivery_address');
			$data['text_local'] 				= $this->lang->line('text_local');
			$data['text_thank_you'] 			= $this->lang->line('text_thank_you');			

			$data['message'] = sprintf($this->lang->line('text_success_message'), $this->config->site_url('account/orders?id=' . $order_id));
			
			if ($order_info['order_type'] === '1') { 
				$order_type = 'delivery';
			} else {
				$order_type = 'collection';
			}
			
			$data['text_greetings'] = sprintf($this->lang->line('text_greetings'), $order_info['first_name']);
			
			$data['order_details'] = sprintf($this->lang->line('text_order_details'), $order_id, $order_type, $order_info['date_added'], $order_info['order_time']);
			
			$data['menus'] = $this->getOrderMenus($order_info['order_id']);
			
			$data['order_total'] = sprintf($this->lang->line('text_order_total'), $this->currency->format($order_info['order_total']));
			
			if (!empty($order_info['address_id'])) {
				$data['delivery_address'] = $this->Customers_model->getCustomerAddress($order_info['customer_id'], $order_info['address_id']);
			} else {
				$data['delivery_address'] = '';
			}
			
			$location = $this->Locations_model->getLocation($order_info['location_id']);
			$data['location_name'] = $location['location_name'];

		}
		
		//setting upload preference
		$this->email->set_protocol($this->config->item('protocol'));
		$this->email->set_mailtype($this->config->item('mailtype'));
		$this->email->set_smtp_host($this->config->item('smtp_host'));
		$this->email->set_smtp_port($this->config->item('smtp_port'));
		$this->email->set_smtp_user($this->config->item('smtp_user'));
		$this->email->set_smtp_pass($this->config->item('smtp_pass'));
		$this->email->set_newline("\r\n");
		$this->email->initialize();

		$this->email->from($this->config->item('site_email'), $this->config->item('site_name'));
		
		if ($this->config->item('send_order_email') === '1') {
			$this->email->cc($this->location->getEmail());
		}
		
		$this->email->to(strtolower($order_info['email']));

		$this->email->subject(sprintf($this->lang->line('text_success_heading'), $order_id));
		
		$message = $this->load->view('main/order_email', $data, TRUE);
		$this->email->message($message);
	
		if ( ! $this->email->send()) {
			$notify = '0';
		} else {
			$notify = '1';
		}			
		
		return $notify;
	}
}