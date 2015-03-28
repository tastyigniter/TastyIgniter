<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Orders_model extends CI_Model {

    public function getCount($filter = array()) {
		if (!empty($filter['filter_search'])) {
			$this->db->like('order_id', $filter['filter_search']);
			$this->db->or_like('location_name', $filter['filter_search']);
			$this->db->or_like('first_name', $filter['filter_search']);
			$this->db->or_like('last_name', $filter['filter_search']);
		}

		if (!empty($filter['filter_location'])) {
			$this->db->where('orders.location_id', $filter['filter_location']);
		}

		if (isset($filter['filter_type']) AND is_numeric($filter['filter_type'])) {
			$this->db->where('order_type', $filter['filter_type']);
		}

		if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
			$this->db->where('orders.status_id', $filter['filter_status']);
		}

		if (!empty($filter['filter_date'])) {
			$date = explode('-', $filter['filter_date']);
			$this->db->where('YEAR(date_added)', $date[0]);
			$this->db->where('MONTH(date_added)', $date[1]);
		}

		$this->db->from('orders');
		$this->db->join('locations', 'locations.location_id = orders.location_id', 'left');
		return $this->db->count_all_results();
    }

    public function getCustomerCount($filter = array()) {
		if (!empty($filter['customer_id'])) {
			$this->db->where('orders.customer_id', $filter['customer_id']);

			$this->db->from('orders');
			return $this->db->count_all_results();
		}
    }

	public function getList($filter = array()) {
		if (!empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

		if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->select('order_id, location_name, customer_id, first_name, last_name, order_type, order_time, order_total, orders.status_id, status_name, orders.date_added, orders.date_modified');
			$this->db->from('orders');
			$this->db->join('statuses', 'statuses.status_id = orders.status_id', 'left');
			$this->db->join('locations', 'locations.location_id = orders.location_id', 'left');

			if (!empty($filter['sort_by']) AND !empty($filter['order_by'])) {
				$this->db->order_by($filter['sort_by'], $filter['order_by']);
			}

			if (!empty($filter['filter_location'])) {
				$this->db->where('orders.location_id', $filter['filter_location']);
			}

			if (!empty($filter['filter_search'])) {
				$this->db->like('order_id', $filter['filter_search']);
				$this->db->or_like('location_name', $filter['filter_search']);
				$this->db->or_like('first_name', $filter['filter_search']);
				$this->db->or_like('last_name', $filter['filter_search']);
			}

			if (isset($filter['filter_type']) AND is_numeric($filter['filter_type'])) {
				$this->db->where('order_type', $filter['filter_type']);
			}

			if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
				$this->db->where('orders.status_id', $filter['filter_status']);
			}

			if (!empty($filter['filter_date'])) {
				$date = explode('-', $filter['filter_date']);
				$this->db->where('YEAR(date_added)', $date[0]);
				$this->db->where('MONTH(date_added)', $date[1]);
			}

			$query = $this->db->get();
			$result = array();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}

			return $result;
		}
	}

	public function getOrder($order_id = FALSE) {
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

	public function getCustomerOrders($filter = array()) {
		if (empty($filter['customer_id'])) {
			return array();
		}

		if (!empty($filter['page']) AND $filter['page'] !== 0) {
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
		$this->db->where('order_id', $order_id);

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getOrderMenuOptions($order_id, $menu_id) {
		$result = array();

		if (!empty($order_id) AND !empty($menu_id)) {
			$this->db->from('order_options');
			$this->db->where('order_id', $order_id);
			$this->db->where('menu_id', $menu_id);

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}
		}

		return $result;
	}

	public function getOrderTotals($order_id) {
		$this->db->from('order_totals');
		$this->db->where('order_id', $order_id);

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getOrderCoupon($order_id) {
		$this->db->from('coupons_history');
		$this->db->where('order_id', $order_id);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
	}

	public function getOrderDates() {
		$this->db->select('date_added, MONTH(date_added) as month, YEAR(date_added) as year');
		$this->db->from('orders');
		$this->db->group_by('MONTH(date_added)');
		$this->db->group_by('YEAR(date_added)');
		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function updateOrder($update = array(), $status_id = '') {
		$query = FALSE;

		if (!empty($update['status_id'])) {
			$this->db->set('status_id', $update['status_id']);
		}

		if (!empty($update['assignee_id'])) {
			$this->db->set('assignee_id', $update['assignee_id']);
		}

		if (!empty($update['date_modified'])) {
			$this->db->set('date_modified', $update['date_modified']);
		}

		if (!empty($update['order_id'])) {
			$this->db->where('order_id', $update['order_id']);
			$query = $this->db->update('orders');

			$this->load->model('Notifications_model');
			$notification = array('object' => 'order', 'object_id' => $update['order_id'],
				'actor_id' => $update['staff_id'], 'subject_id' => $update['status_id'],
			);

			if ($query AND (int) $status_id !== (int) $update['status_id']) {
				$this->Statuses_model->addStatusHistory('order', $update);

				$notification['action'] = 'changed';
				$this->Notifications_model->addNotification($notification);
			}

			if ($query AND $update['old_assignee_id'] !== $update['assignee_id']) {
				$notification['action'] = 'assigned';
				$notification['subject_id'] = $update['assignee_id'];
				$this->Notifications_model->addNotification($notification);
			}
		}

		return $query;
	}

	/*public function addOrder($order_info = array(), $cart_contents = array()) {
		$query = FALSE;
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
			if ($this->db->insert('orders')) {
				$order_id = $this->db->insert_id();

				if (isset($order_info['address_id'])) {
					$this->load->model('Addresses_model');
					$this->Addresses_model->updateCustomerDefaultAddress($order_info['customer_id'], $order_info['address_id']);
				}

				$this->addOrderMenus($order_id, $cart_contents);

				$order_totals = array(
					'cart_total' => array('title' => 'Sub Total', 'value' => $cart_contents['cart_total']),
					'delivery' => array('title' => 'Delivery', 'value' => $cart_contents['delivery']),
					'coupon' => array('title' => 'Coupon', 'value' => $cart_contents['coupon'])
				);

				$this->addOrderTotals($order_id, $order_totals);

				if (!empty($order_info['coupon'])) {
					$this->addOrderCoupon($order_id, $order_info['customer_id'], $cart_contents['coupon'], $order_info['coupon']['code']);
				}

				return $order_id;
			}
		}
	}

	public function completeOrder($order_id, $order_info) {
		$current_time = time();

		if ($order_id AND !empty($order_info)) {
			$notify = $this->_sendMail($order_id);
			$payment = $this->Extensions_model->getPayment($order_info['payment']);

			$status_id = (int)$this->config->item('order_status_new');
			if (isset($payment['order_status']) AND is_numeric($payment['order_status'])) {
				$status_id = (int) $payment['order_status'];
			}

			$this->db->set('status_id', $status_id);
			$this->db->set('notify', $notify);
			$this->db->where('order_id', $order_id);

			if ($this->db->update('orders')) {
				$this->load->model('Statuses_model');
				$status = $this->Statuses_model->getStatus($status_id);
				$order_history = array(
					'order_id' 		=> $order_id,
					'status_id' 	=> $status_id,
					'notify' 		=> $notify,
					'comment' 		=> $status['status_comment'],
					'date_added' 	=> mdate('%Y-%m-%d %H:%i:%s', $current_time)
				);

				$this->Statuses_model->addStatusHistory('order', $order_history);

				$this->cart->destroy();
				$this->session->unset_userdata('order_data');
			}
		}
	}

	public function addOrderMenus($order_id, $cart_contents = array()) {
		if (is_array($cart_contents) AND !empty($cart_contents) AND $order_id) {
			foreach ($cart_contents as $key => $item) {
				if (is_array($item) AND $key === $item['rowid']) {

					if (!empty($item['id'])) {
						$this->db->set('menu_id', $item['id']);
					}

					if (!empty($item['name'])) {
						$this->db->set('name', $item['name']);
					}

					if (!empty($item['qty'])) {
						$this->db->set('quantity', $item['qty']);
					}

					if (!empty($item['price'])) {
						$this->db->set('price', $item['price']);
					}

					if (!empty($item['subtotal'])) {
						$this->db->set('subtotal', $item['subtotal']);
					}

					if (!empty($item['options'])) {
						$this->db->set('option_values', serialize($item['options']));
					}

					$this->db->set('order_id', $order_id);

					if ($query = $this->db->insert('order_menus')) {
						$order_menu_id = $this->db->insert_id();
						$this->subtractStock($item['id'], $item['qty']);

						if (!empty($item['options'])) {
							$this->addOrderMenuOptions($order_menu_id, $order_id, $item['id'], $item['options']);
						}
					}

				}
			}

			return TRUE;
		}
	}

	public function subtractStock($menu_id, $quantity) {
		$this->load->model('Menus_model');
		$menu_data = $this->Menus_model->getMenu($menu_id);

		if ($menu_data['subtract_stock'] === '1' AND $quantity) {
			$this->db->set('stock_qty', 'stock_qty - '. $quantity, FALSE);

			$this->db->where('menu_id', $menu_id);
			$this->db->update('menus');
		}
	}

	public function addOrderMenuOptions($order_menu_id, $order_id, $menu_id, $menu_option) {
		if (!empty($order_menu_id) AND !empty($order_id) AND !empty($menu_id) AND !empty($menu_option)) {
			$menu_option_value_ids = (!empty($menu_option['menu_option_value_id'])) ? explode('|', $menu_option['menu_option_value_id']) : array();
			$option_names = (!empty($menu_option['name'])) ? explode('|', $menu_option['name']) : array();
			$option_prices = (!empty($menu_option['price'])) ? explode('|', $menu_option['price']) : array();

			if (count($menu_option_value_ids) > 0) {
				foreach ($menu_option_value_ids as $key => $value) {
					$this->db->set('order_menu_id', $order_menu_id);
					$this->db->set('order_id', $order_id);
					$this->db->set('menu_id', $menu_id);
					$this->db->set('menu_option_value_id', $value);
					$this->db->set('order_option_name', $option_names[$key]);
					$this->db->set('order_option_price', $option_prices[$key]);

					$query = $this->db->insert('order_options');
				}
			}
		}
	}

	public function addOrderTotals($order_id, $order_totals) {
		if (is_numeric($order_id) AND !empty($order_totals)) {
			foreach ($order_totals as $key => $value) {
				if (is_numeric($value['value'])) {
					$this->db->set('order_id', $order_id);
					$this->db->set('code', $key);
					$this->db->set('title', $value['title']);

					if ($key === 'code') {
						$this->db->set('value', '-'. $value['value']);
					} else {
						$this->db->set('value', $value['value']);
					}

					$this->db->insert('order_totals');
				}
			}

			return TRUE;
		}
	}

	public function addOrderCoupon($order_id, $customer_id, $coupon_amt, $coupon_code) {
		if (is_numeric($coupon_amt)) {
			$this->load->model('Coupons_model');
			$coupon = $this->Coupons_model->getCouponByCode($coupon_code);
			$this->db->set('order_id', $order_id);
			$this->db->set('customer_id', $customer_id);
			$this->db->set('coupon_id', $coupon['coupon_id']);
			$this->db->set('code', $coupon['code']);
			$this->db->set('amount', '-'. $coupon_amt);
			$this->db->set('date_used', mdate('%Y-%m-%d %H:%i:%s', time()));

			if ($this->db->insert('coupons_history')) {
				return $this->db->insert_id();
			}
		}
	}

	public function getMailData($order_id) {
		$data = array();

		$result = $this->getOrder($order_id);
		if ($result) {
			$this->load->library('country');
	   		$this->load->library('currency');

			$data['order_number'] 		= $result['order_id'];
			$data['order_link'] 		= root_url('main/orders?id='. $result['order_id']);
			$data['order_type']			= ($result['order_type'] === '1') ? 'delivery' : 'collection';
			$data['order_time']			= mdate('%H:%i', strtotime($result['order_time']));
			$data['order_date']			= mdate('%d %M %y', strtotime($result['date_added']));
			$data['first_name'] 		= $result['first_name'];
			$data['last_name'] 			= $result['last_name'];
			$data['email'] 				= $result['email'];
			$data['signature'] 			= $this->config->item('site_name');

			$data['order_address'] = 'This is a collection order';
			if (!empty($result['address_id'])) {
				$this->load->model('Addresses_model');
				$order_address = $this->Addresses_model->getCustomerAddress($result['customer_id'], $result['address_id']);
				$data['order_address'] = $this->country->addressFormat($order_address);
			}

			$data['menus'] = array();
			$menus = $this->getOrderMenus($result['order_id']);
			if ($menus) {
				foreach ($menus as $menu) {
					$option_data = array();
					$options = $this->getOrderMenuOptions($result['order_id'], $menu['menu_id']);
					if ($options) {
						foreach ($options as $option) {
							$option_data[] = $option['order_option_name'];
						}
					}

					$data['menus'][] = array(
						'name' 			=> (strlen($menu['name']) > 20) ? substr($menu['name'], 0, 20) .'...' : $menu['name'],
						'quantity' 		=> $menu['quantity'],
						'price'			=> $this->currency->format($menu['price']),
						'subtotal'		=> $this->currency->format($menu['subtotal']),
						'options'		=> explode(', ', $option_data)
					);
				}
			}

			$order_totals = $this->getOrderTotals($result['order_id']);
			if ($order_totals) {
				$data['order_totals'] = array();
				foreach ($order_totals as $total) {
					$data['order_totals'][] = array(
						'title' 		=> $total['title'],
						'value' 		=> $this->currency->format($total['value'])
					);
				}
			}

			if (!empty($result['location_id'])) {
				$this->load->model('Locations_model');
				$location = $this->Locations_model->getLocation($result['location_id']);
				$data['location_name'] = $location['location_name'];
			}
		}

		return $data;
	}

	public function _sendMail($order_id) {
	   	$this->load->library('email');
		$this->load->library('mail_template');

		$notify = '0';

		$mail_data = $this->getMailData($order_id);
		if ($mail_data) {
			$prefs['protocol'] = $this->config->item('protocol');
			$prefs['mailtype'] = $this->config->item('mailtype');
			$prefs['smtp_host'] = $this->config->item('smtp_host');
			$prefs['smtp_port'] = $this->config->item('smtp_port');
			$prefs['smtp_user'] = $this->config->item('smtp_user');
			$prefs['smtp_pass'] = $this->config->item('smtp_pass');
			$prefs['newline'] = "\r\n";

			$this->email->initialize($prefs);

			$this->email->from($this->config->item('site_email'), $this->config->item('site_name'));
			if ($this->config->item('location_order_email') === '1') {
				$this->email->cc($this->location->getEmail());
			}

			$message = $this->mail_template->parseTemplate('order', $mail_data);
			$this->email->to(strtolower($mail_data['email']));
			$this->email->subject($this->mail_template->getSubject());
			$this->email->message($message);

			if ( ! $this->email->send()) {
				$notify = '0';
			} else {
				$notify = '1';
			}
		}

		return $notify;
	}*/

	public function validateOrder($order_id) {
		if (!empty($order_id)) {
			$this->db->from('orders');
			$this->db->where('order_id', $order_id);

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				return TRUE;
			}
		}

		return FALSE;
	}

	public function deleteOrder($order_id) {
		if (is_numeric($order_id)) {
			$this->db->where('order_id', $order_id);
			$this->db->delete('orders');

			$this->db->where('order_id', $order_id);
			$this->db->delete('order_menus');

			$this->db->where('order_id', $order_id);
			$this->db->delete('order_options');

			$this->db->where('order_id', $order_id);
			$this->db->delete('order_totals');

			$this->db->where('order_id', $order_id);
			$this->db->delete('coupons_history');

			if ($this->db->affected_rows() > 0) {
				return TRUE;
			}
		}
	}
}

/* End of file orders_model.php */
/* Location: ./admin/models/orders_model.php */