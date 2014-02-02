<?php
class Orders_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

    public function record_count() {
        return $this->db->count_all('orders');
    }
    
    public function assigned_record_count($filter = array()) {
		if (!empty($filter['staff_id'])) {
			$this->db->where('order_staff_id', $filter['staff_id']);
			$this->db->from('orders');
		
			return $this->db->count_all_results();
		}
    }
    
	public function getList($filter = array()) {
		if ($filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}
			
		if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->select('order_id, location_name, first_name, last_name, order_type, order_time, status_name, staff_name, orders.date_added, orders.date_modified');
			$this->db->from('orders');
			$this->db->join('statuses', 'statuses.status_id = orders.status_id', 'left');
			$this->db->join('staffs', 'staffs.staff_id = orders.order_staff_id', 'left');
			$this->db->join('locations', 'locations.location_id = orders.order_location_id', 'left');
			$this->db->order_by('order_id', 'DESC');
		
			if (!empty($filter['staff_id'])) {
				$this->db->where('staff_id', $filter['staff_id']);
			}

			$query = $this->db->get();
			return $query->result_array();
		}
	}
	
	public function getOrders() {
		$this->db->from('orders');
		$this->db->join('statuses', 'statuses.status_id = orders.status_id', 'left');
		$this->db->join('staffs', 'staffs.staff_id = orders.order_staff_id', 'left');
		$this->db->join('locations', 'locations.location_id = orders.order_location_id', 'left');
		$this->db->order_by('order_id', 'DESC');

		$query = $this->db->get();
		return $query->result_array();
	}

	public function getAdminOrder($order_id = FALSE) {
		if ($order_id !== FALSE) {
			$this->db->from('orders');
			$this->db->join('statuses', 'statuses.status_id = orders.status_id', 'left');
			$this->db->join('staffs', 'staffs.staff_id = orders.order_staff_id', 'left');
			//$this->db->join('locations', 'locations.location_id = orders.order_location_id', 'left');
			//$this->db->join('address', 'address.address_id = orders.order_address_id', 'left');
		
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
			$this->db->join('locations', 'locations.location_id = orders.order_location_id', 'left');
			$this->db->order_by('order_id', 'DESC');

			$this->db->where('order_customer_id', $customer_id);

			$query = $this->db->get();
			return $query->result_array();
		}
	}
	
	public function getMainOrder($order_id, $customer_id) {
		if (isset($order_id, $customer_id)) {
			$this->db->from('orders');
			$this->db->where('order_id', $order_id);
			$this->db->where('order_customer_id', $customer_id);
			
			$query = $this->db->get();
		
			if ($query->num_rows() > 0) {
				return $query->row_array();
			}
		}
		
		return FALSE;
	}

	public function getOrderMenus($order_id) {
		$this->db->from('order_menus');
		$this->db->where('order_id', $order_id);
			
		$query = $this->db->get();
		return $query->result_array();
	}

	public function updateOrder($update = array()) {
		
		if (!empty($update['status_id'])) {
			$this->db->set('status_id', $update['status_id']);
		}
		
		if (!empty($update['order_staff_id'])) {
			$this->db->set('order_staff_id', $update['order_staff_id']);
		}
		
		if (!empty($update['date_modified'])) {
			$this->db->set('date_modified', $update['date_modified']);
		}
		
		if (!empty($update['order_id'])) {
			$this->db->where('order_id', $update['order_id']);
			$this->db->update('orders');
		}	

		if ($this->db->affected_rows() > 0) {

			if (!empty($update['status_id']) && !empty($update['order_staff_id'])) {
				$this->load->library('user');
				$this->load->model('Messages_model');

				$date_format = '%Y-%m-%d';
				$time_format = '%h:%i';
				$current_date_time = time();

				$send_data = array();

				$send_data['date']		= mdate($date_format, $current_date_time);
				$send_data['time']		= mdate($time_format, $current_date_time);
				$send_data['sender']	= $this->user->getStaffId();
				$send_data['to'] 		= $update['order_staff_id'];
	
				$statuses = $this->Statuses_model->getStatus($update['status_id']);
	
				$send_data['subject']	= 'Order Assigned: '. $update['order_id'];
				$send_data['body']		= 'Order <a href="'. site_url('admin/orders/edit/' . $update['order_id']) .'">'. $update['order_id'] . '</a> has been assigned to you for '. $statuses['status_name'];

				$this->Messages_model->sendMessage('alert', $send_data);
			}
						
			return TRUE;
		}
	}

	public function addOrder($order_details = array(), $cart_items = array()) {

		$current_date_time = time();

		if (!empty($order_details['order_location_id'])) {
			$this->db->set('order_location_id', $order_details['order_location_id']);
		}

		if (!empty($order_details['order_customer_id'])) {
			$this->db->set('order_customer_id', $order_details['order_customer_id']);
		} else {
			$this->db->set('order_customer_id', '0');
		}

		if (!empty($order_details['first_name'])) {
			$this->db->set('first_name', $order_details['first_name']);
		}

		if (!empty($order_details['last_name'])) {
			$this->db->set('last_name', $order_details['last_name']);
		}

		if (!empty($order_details['email'])) {
			$this->db->set('email', $order_details['email']);
		}

		if (!empty($order_details['telephone'])) {
			$this->db->set('telephone', $order_details['telephone']);
		}

		if (!empty($order_details['order_type'])) {
			$this->db->set('order_type', $order_details['order_type']);
		}

		if (!empty($order_details['order_time'])) {
			$this->db->set('order_time', mdate('%H:%i', strtotime($order_details['order_time'])));
			$this->db->set('date_added', mdate('%Y-%m-%d %H:%i', $current_date_time));
			$this->db->set('date_modified', mdate('%Y-%m-%d', $current_date_time));
			$this->db->set('ip_address', $this->input->ip_address());
			$this->db->set('user_agent', $this->input->user_agent());
		}

		if (!empty($order_details['order_address_id'])) {
			$this->db->set('order_address_id', $order_details['order_address_id']);
		}

		if (!empty($order_details['payment'])) {
			$this->db->set('payment', $order_details['payment']);
		}

		if (!empty($order_details['comment'])) {
			$this->db->set('comment', $order_details['comment']);
		}

		$this->load->library('cart');
		if ($this->cart->order_total()) {
			$this->db->set('order_total', $this->cart->order_total());
		}

		if ($this->cart->total_items()) {
			$this->db->set('total_items', $this->cart->total_items());
		}

		if (!empty($order_details)) {
			$this->db->insert('orders');
		
			if ($this->db->affected_rows() > 0) {
				$order_id = $this->db->insert_id();
								
				$this->db->set('address_id', $order_details['order_address_id']);
				$this->db->where('customer_id', $order_details['order_customer_id']);
				$this->db->update('customers'); 
							
				$order_info = $this->getMainOrder($order_id, $order_details['order_customer_id']);

				if ($order_info OR !empty($cart_items)) {
				
					$this->addOrderMenus($order_id, $cart_items);

					if ($order_info['payment'] === 'paypal' && $this->config->item('config_paypal_order_status')) {
						$this->db->set('status_id', $this->config->item('config_paypal_order_status'));
					} else if ($order_info['payment'] === 'cod' && $this->config->item('config_cod_order_status')) {
						$this->db->set('status_id', $this->config->item('config_cod_order_status'));
					} else {
						$this->db->set('status_id', $this->config->item('config_order_received'));
					}

					$notify = $this->_sendOrderMail($order_id, $order_info, $cart_items);
					$this->db->set('notify', $notify);
				
					$this->db->where('order_id', $order_id);
					$this->db->update('orders'); 
				}
				
				$this->session->unset_userdata('order_details');
				$this->cart->destroy();
				
				return $order_id;
			
			} else {
				return FALSE;
			}
		}
	}	
	
	public function addOrderMenus($order_id, $cart_items = array()) {
		if (is_array($cart_items) && !empty($cart_items)) {
			foreach ($cart_items as $cart_item) {
			
				if (!empty($cart_item['options'])) {
					$options = serialize($cart_item['options']);
				} else {
					$options = '';
				}
			
				$order_menus = array (
					'order_id' 		=> $order_id,
					'menu_id' 		=> $cart_item['id'],
					'name' 			=> $cart_item['name'],
					'quantity' 		=> $cart_item['qty'],
					'price' 		=> $cart_item['price'],
					'subtotal' 		=> $cart_item['subtotal'],
					'options'		=> $options
				);
				
				$this->db->insert('order_menus', $order_menus); 

				$this->load->model('Menus_model');
				$menu_data = $this->Menus_model->getAdminMenu($cart_item['id']);
				
				if ($menu_data['subtract_stock'] === '1') {
					$sql = "UPDATE menus SET stock_qty = stock_qty - ? WHERE menu_id = ?";
					$query = $this->db->query($sql, array($cart_item['qty'], $cart_item['id']));
				}
			}
	
			return TRUE;
		}
	}

	public function deleteOrder($order_id) {
		$delete_data = array();

		$delete_data['order_id'] = $order_id;
			
		return $this->db->delete('orders', $delete_data);
	}

	public function _sendOrderMail($order_id, $order_info = array(), $cart_items = array()) {
		//loading upload library
	   	$this->load->library('email');
		$this->load->library('cart');
	   	$this->load->library('location');
	   	$this->load->library('currency'); // load the currency library
		$this->load->model('Customers_model');
		$this->load->model('Locations_model'); // load the locations model
		$this->lang->load('main/order_email');
		
		if (is_array($order_info) && !empty($order_info)) {
			$data['text_heading'] 				= sprintf($this->lang->line('text_success_heading'), $order_id);
			$data['text_order_details'] 		= $this->lang->line('text_order_details');
			$data['text_order_items'] 			= $this->lang->line('text_order_items');
			$data['text_delivery_address'] 		= $this->lang->line('text_delivery_address');
			$data['text_local'] 				= $this->lang->line('text_local');
			$data['text_thank_you'] 			= $this->lang->line('text_thank_you');			

			$data['message'] = sprintf($this->lang->line('text_success_message'), $this->config->site_url('account/orders/' . $order_id));
			
			if ($order_info['order_type'] === 1) { 
				$order_type = 'delivery';
			} else {
				$order_type = 'collection';
			}
			
			$data['text_greetings'] = sprintf($this->lang->line('text_greetings'), $order_info['first_name']);
			
			$data['order_details'] = sprintf($this->lang->line('text_order_details'), $order_id, $order_type, $order_info['date_added'], $order_info['order_time']);
			
			$data['menus'] = $cart_items;
			
			$data['order_total'] = sprintf($this->lang->line('text_order_total'), $this->currency->format($this->cart->total()));
			
			if (!empty($order_info['address_id'])) {
				$data['delivery_address'] = $this->Customers_model->getCustomerAddress($order_info['order_customer_id'], $order_info['order_address_id']);
			} else {
				$data['delivery_address'] = '';
			}
			
			$location = $this->Locations_model->getLocation($order_info['order_location_id']);
			$data['location_name'] = $location['location_name'];

		}
		
		//setting upload preference
		$this->email->set_protocol($this->config->item('config_protocol'));
		$this->email->set_mailtype($this->config->item('config_mailtype'));
		$this->email->set_smtp_host($this->config->item('config_smtp_host'));
		$this->email->set_smtp_port($this->config->item('config_smtp_port'));
		$this->email->set_smtp_user($this->config->item('config_smtp_user'));
		$this->email->set_smtp_pass($this->config->item('config_smtp_pass'));
		$this->email->set_newline("\r\n");
		$this->email->initialize();

		$this->email->from($this->config->item('config_site_email'), $this->config->item('config_site_name'));
		$this->email->cc($this->location->getEmail());
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