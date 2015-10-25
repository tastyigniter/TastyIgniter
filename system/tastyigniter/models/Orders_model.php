<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Orders_model extends TI_Model {

	public function getCount($filter = array()) {
		if (APPDIR === ADMINDIR) {
			if ( ! empty($filter['filter_search'])) {
				$this->db->like('order_id', $filter['filter_search']);
				$this->db->or_like('location_name', $filter['filter_search']);
				$this->db->or_like('first_name', $filter['filter_search']);
				$this->db->or_like('last_name', $filter['filter_search']);
			}

			if ( ! empty($filter['filter_location'])) {
				$this->db->where('orders.location_id', $filter['filter_location']);
			}

			if (isset($filter['filter_type']) AND is_numeric($filter['filter_type'])) {
				$this->db->where('order_type', $filter['filter_type']);
			}

			if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
				$this->db->where('orders.status_id', $filter['filter_status']);
			}

			if ( ! empty($filter['filter_date'])) {
				$date = explode('-', $filter['filter_date']);
				$this->db->where('YEAR(date_added)', $date[0]);
				$this->db->where('MONTH(date_added)', $date[1]);
			}
		} else {
			if ( ! empty($filter['customer_id']) AND is_numeric($filter['customer_id'])) {
				$this->db->where('customer_id', $filter['customer_id']);
			}
		}

		$this->db->from('orders');
		$this->db->join('locations', 'locations.location_id = orders.location_id', 'left');

		return $this->db->count_all_results();
	}

	public function getList($filter = array()) {
		if ( ! empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

		if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->select('*, orders.status_id, status_name, status_color, orders.date_added, orders.date_modified');
			$this->db->from('orders');
			$this->db->join('statuses', 'statuses.status_id = orders.status_id', 'left');
			$this->db->join('locations', 'locations.location_id = orders.location_id', 'left');

			if ( ! empty($filter['sort_by']) AND ! empty($filter['order_by'])) {
				$this->db->order_by($filter['sort_by'], $filter['order_by']);
			}

			if ( ! empty($filter['customer_id']) AND is_numeric($filter['customer_id'])) {
				$this->db->where('customer_id', $filter['customer_id']);
			}

			if ( ! empty($filter['filter_location'])) {
				$this->db->where('orders.location_id', $filter['filter_location']);
			}

			if ( ! empty($filter['filter_search'])) {
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

			if ( ! empty($filter['filter_date'])) {
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

	public function getOrder($order_id = FALSE, $customer_id = '') {
		if ( ! empty($order_id)) {
			$this->db->from('orders');
			$this->db->join('statuses', 'statuses.status_id = orders.status_id', 'left');
			$this->db->where('order_id', $order_id);

			if ( ! empty($customer_id)) {
				$this->db->where('customer_id', $customer_id);
			}

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				return $query->row_array();
			}
		}

		return $order_id;
	}

	public function getCheckoutOrder($order_id, $customer_id) {
		if (isset($order_id, $customer_id)) {
			$this->db->from('orders');

			$this->db->where('order_id', $order_id);
			$this->db->where('customer_id', $customer_id);
			$this->db->where('status_id', NULL);

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
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getOrderMenuOptions($order_id) {
		$result = array();

		if ( ! empty($order_id)) {
			$this->db->from('order_options');
			$this->db->where('order_id', $order_id);

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				foreach ($query->result_array() as $row) {
					$result[] = $row;
				}
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

	public function updateOrder($order_id = NULL, $update = array()) {
		$query = FALSE;

		if (isset($update['order_status'])) {
			$this->db->set('status_id', $update['order_status']);
		}

		if (isset($update['assignee_id'])) {
			$this->db->set('assignee_id', $update['assignee_id']);
		}

		if (isset($update['date_modified'])) {
			$this->db->set('date_modified', mdate('%Y-%m-%d', time()));
		}

		if (is_numeric($order_id)) {
			$this->db->where('order_id', $order_id);
			$query = $this->db->update('orders');

			if ($query AND (int) $update['old_status_id'] !== (int) $update['order_status']) {
				$update['staff_id'] = $this->user->getStaffId();
				$update['object_id'] = (int) $order_id;
				$update['status_id'] = (int) $update['order_status'];
				$update['comment'] = $update['status_comment'];
				$update['date_added'] = mdate('%Y-%m-%d %H:%i:%s', time());

				$this->Statuses_model->addStatusHistory('order', $update);
			}
		}

		return $query;
	}

	public function addOrder($order_info = array(), $cart_contents = array()) {
		$query = FALSE;
		$current_time = time();

		if (isset($order_info['location_id'])) {
			$this->db->set('location_id', $order_info['location_id']);
		}

		if (isset($order_info['customer_id'])) {
			$this->db->set('customer_id', $order_info['customer_id']);
		} else {
			$this->db->set('customer_id', '0');
		}

		if (isset($order_info['first_name'])) {
			$this->db->set('first_name', $order_info['first_name']);
		}

		if (isset($order_info['last_name'])) {
			$this->db->set('last_name', $order_info['last_name']);
		}

		if (isset($order_info['email'])) {
			$this->db->set('email', $order_info['email']);
		}

		if (isset($order_info['telephone'])) {
			$this->db->set('telephone', $order_info['telephone']);
		}

		if (isset($order_info['order_type'])) {
			$this->db->set('order_type', $order_info['order_type']);
		}

		if (isset($order_info['order_time'])) {
			$order_time = (strtotime($order_info['order_time']) < strtotime($current_time)) ? $current_time : $order_info['order_time'];
			$this->db->set('order_time', mdate('%H:%i', strtotime($order_time)));
			$this->db->set('date_added', mdate('%Y-%m-%d %H:%i:%s', $current_time));
			$this->db->set('date_modified', mdate('%Y-%m-%d', $current_time));
			$this->db->set('ip_address', $this->input->ip_address());
			$this->db->set('user_agent', $this->input->user_agent());
		}

		if (isset($order_info['address_id'])) {
			$this->db->set('address_id', $order_info['address_id']);
		}

		if (isset($order_info['payment'])) {
			$this->db->set('payment', $order_info['payment']);
		}

		if (isset($order_info['comment'])) {
			$this->db->set('comment', $order_info['comment']);
		}

		if (isset($cart_contents['order_total'])) {
			$this->db->set('order_total', $cart_contents['order_total']);
		}

		if (isset($cart_contents['total_items'])) {
			$this->db->set('total_items', $cart_contents['total_items']);
		}

		if ( ! empty($order_info)) {
			if (isset($order_info['order_id'])) {
				$_action = 'updated';
				$this->db->where('order_id', $order_info['order_id']);
				$query = $this->db->update('orders');
				$order_id = $order_info['order_id'];
			} else {
				$_action = 'added';
				$query = $this->db->insert('orders');
				$order_id = $this->db->insert_id();
			}

			if ($query AND $order_id) {
				if (isset($order_info['address_id'])) {
					$this->load->model('Addresses_model');
					$this->Addresses_model->updateDefault($order_info['customer_id'], $order_info['address_id']);
				}

				if ($_action === 'added' AND APPDIR === MAINDIR) {
					log_activity($order_info['customer_id'], 'created', 'orders',
					             get_activity_message('activity_created_order',
					                                  array('{customer}', '{link}', '{order_id}'),
					                                  array($order_info['first_name'] . ' ' . $order_info['last_name'], admin_url('orders/edit?id=' . $order_id), $order_id)
					             ));
				}

				return $order_id;
			}
		}
	}

	public function completeOrder($order_id, $order_info, $cart_contents) {
		$current_time = time();

		if ($order_id AND ! empty($order_info)) {

			$this->addOrderMenus($order_id, $cart_contents);

			$order_totals = array(
				'cart_total'  => array('title' => 'Sub Total', 'value' => (isset($cart_contents['cart_total'])) ? $cart_contents['cart_total'] : ''),
				'order_total' => array('title' => 'Order Total', 'value' => (isset($cart_contents['order_total'])) ? $cart_contents['order_total'] : ''),
				'delivery'    => array('title' => 'Delivery', 'value' => (isset($cart_contents['delivery'])) ? $cart_contents['delivery'] : ''),
				'coupon'      => array('title' => 'Coupon (' . $cart_contents['coupon']['code'] . ') ', 'value' => $cart_contents['coupon']['discount']),
			);

			$this->addOrderTotals($order_id, $order_totals);

			if ( ! empty($cart_contents['coupon'])) {
				$this->addOrderCoupon($order_id, $order_info['customer_id'], $cart_contents['coupon']);
			}

			$notify = $this->_sendMail($order_id);

			$status_id = ! empty($order_info['status_id']) ? (int) $order_info['status_id'] : (int) $this->config->item('new_order_status');

			$this->db->set('status_id', $status_id);
			$this->db->set('notify', $notify);
			$this->db->where('order_id', $order_id);

			if ($this->db->update('orders')) {
				$this->load->model('Statuses_model');
				$status = $this->Statuses_model->getStatus($status_id);
				$order_history = array(
					'object_id'  => $order_id,
					'status_id'  => $status_id,
					'notify'     => $notify,
					'comment'    => $status['status_comment'],
					'date_added' => mdate('%Y-%m-%d %H:%i:%s', $current_time),
				);

				$this->Statuses_model->addStatusHistory('order', $order_history);

				return TRUE;
			}
		}
	}

	public function addOrderMenus($order_id, $cart_contents = array()) {
		if (is_array($cart_contents) AND ! empty($cart_contents) AND $order_id) {
			foreach ($cart_contents as $key => $item) {
				if (is_array($item) AND isset($item['rowid']) AND $key === $item['rowid']) {

					if (isset($item['id'])) {
						$this->db->set('menu_id', $item['id']);
					}

					if (isset($item['name'])) {
						$this->db->set('name', $item['name']);
					}

					if (isset($item['qty'])) {
						$this->db->set('quantity', $item['qty']);
					}

					if (isset($item['price'])) {
						$this->db->set('price', $item['price']);
					}

					if (isset($item['subtotal'])) {
						$this->db->set('subtotal', $item['subtotal']);
					}

					if (isset($item['comment'])) {
						$this->db->set('comment', $item['comment']);
					}

					if ( ! empty($item['options'])) {
						$this->db->set('option_values', serialize($item['options']));
					}

					$this->db->set('order_id', $order_id);

					if ($query = $this->db->insert('order_menus')) {
						$order_menu_id = $this->db->insert_id();
						$this->subtractStock($item['id'], $item['qty']);

						if ( ! empty($item['options'])) {
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
			$this->db->set('stock_qty', 'stock_qty - ' . $quantity, FALSE);

			$this->db->where('menu_id', $menu_id);
			$this->db->update('menus');
		}
	}

	public function addOrderMenuOptions($order_menu_id, $order_id, $menu_id, $menu_options) {
		if ( ! empty($order_id) AND ! empty($menu_id) AND ! empty($menu_options)) {

			foreach ($menu_options as $menu_option_id => $options) {
				foreach ($options as $option) {
					$this->db->set('order_menu_option_id', $menu_option_id);
					$this->db->set('order_menu_id', $order_menu_id);
					$this->db->set('order_id', $order_id);
					$this->db->set('menu_id', $menu_id);
					$this->db->set('menu_option_value_id', $option['value_id']);
					$this->db->set('order_option_name', $option['value_name']);
					$this->db->set('order_option_price', $option['value_price']);

					$this->db->insert('order_options');
				}
			}
		}
	}

	public function addOrderTotals($order_id, $order_totals) {
		if (is_numeric($order_id) AND ! empty($order_totals)) {
			$this->db->where('order_id', $order_id);
			$this->db->delete('order_totals');

			foreach ($order_totals as $key => $value) {
				if (is_numeric($value['value'])) {
					$this->db->set('order_id', $order_id);
					$this->db->set('code', $key);
					$this->db->set('title', $value['title']);

					if ($key === 'coupon') {
						$this->db->set('value', '-' . $value['value']);
					} else {
						$this->db->set('value', $value['value']);
					}

					$this->db->insert('order_totals');
				}
			}

			return TRUE;
		}
	}

	public function addOrderCoupon($order_id, $customer_id, $coupon) {
		if (is_array($coupon) AND is_numeric($coupon['discount'])) {
			$this->db->where('order_id', $order_id);
			$this->db->delete('coupons_history');

			$this->load->model('Coupons_model');
			$temp_coupon = $this->Coupons_model->getCouponByCode($coupon['code']);

			$this->db->set('order_id', $order_id);
			$this->db->set('customer_id', $customer_id);
			$this->db->set('coupon_id', $temp_coupon['coupon_id']);
			$this->db->set('code', $temp_coupon['code']);
			$this->db->set('amount', '-' . $coupon['discount']);
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

			$data['order_number'] = $result['order_id'];
			$data['order_view_url'] = root_url('account/orders/view/' . $result['order_id']);
			$data['order_type'] = ($result['order_type'] === '1') ? 'delivery' : 'collection';
			$data['order_time'] = mdate('%H:%i', strtotime($result['order_time']));
			$data['order_date'] = mdate('%d %M %y', strtotime($result['date_added']));
			$data['first_name'] = $result['first_name'];
			$data['last_name'] = $result['last_name'];
			$data['email'] = $result['email'];

			$data['order_menus'] = array();
			$menus = $this->getOrderMenus($result['order_id']);
			$options = $this->getOrderMenuOptions($result['order_id']);
			if ($menus) {
				foreach ($menus as $menu) {
					$option_data = array();

					if ( ! empty($options[$menu['menu_id']])) {
						foreach ($options[$menu['menu_id']] as $option) {
							$option_data[] = $option['order_option_name'];
						}
					}

					$data['order_menus'][] = array(
						'menu_name'     => (strlen($menu['name']) > 20) ? substr($menu['name'], 0,
						                                                    20) . '...' : $menu['name'],
						'menu_quantity' => $menu['quantity'],
						'menu_price'    => $this->currency->format($menu['price']),
						'menu_subtotal' => $this->currency->format($menu['subtotal']),
						'menu_options'  => implode(', ', $option_data),
					);
				}
			}

			$order_totals = $this->getOrderTotals($result['order_id']);
			if ($order_totals) {
				$data['order_totals'] = array();
				foreach ($order_totals as $total) {
					$data['order_totals'][] = array(
						'order_total_title' => $total['title'],
						'order_total_value' => $this->currency->format($total['value']),
					);
				}
			}

			$data['order_address'] = 'This is a collection order';
			if ( ! empty($result['address_id'])) {
				$this->load->model('Addresses_model');
				$order_address = $this->Addresses_model->getAddress($result['customer_id'], $result['address_id']);
				$data['order_address'] = $this->country->addressFormat($order_address);
			}

			if ( ! empty($result['location_id'])) {
				$this->load->model('Locations_model');
				$location = $this->Locations_model->getLocation($result['location_id']);
				$data['location_name'] = $location['location_name'];
			}
		}

		return $data;
	}

	public function _sendMail($order_id) {
		$this->load->library('email');

		$notify = $send_mail = '0';

		$mail_data = $this->getMailData($order_id);
		if ($mail_data) {
			$this->email->initialize();

			$this->email->from($this->config->item('site_email'), $this->config->item('site_name'));

			if ($this->config->item('customer_order_email') === '1' AND $this->config->item('location_order_email') === '1') {
				$this->email->to(strtolower($mail_data['email']));

				if ($this->location->getEmail()) {
					$this->email->cc(strtolower($this->location->getEmail()));
				}

				$send_mail = '1';
			} else if ($this->config->item('customer_order_email') === '1' AND $this->config->item('location_order_email') !== '1') {
				$this->email->to(strtolower($mail_data['email']));
				$send_mail = '1';
			} else if ($this->config->item('customer_order_email') !== '1' AND $this->config->item('location_order_email') === '1' AND $this->location->getEmail()) {
				$this->email->to(strtolower($this->location->getEmail()));
				$send_mail = '1';
			}

			if ($send_mail === '1') {
				$this->load->model('Mail_templates_model');
				$mail_template = $this->Mail_templates_model->getTemplateData($this->config->item('mail_template_id'),
				                                                              'order');

				$this->email->subject($mail_template['subject'], $mail_data);
				$this->email->message($mail_template['body'], $mail_data);

				if ( ! $this->email->send()) {
					log_message('debug', $this->email->print_debugger(array('headers')));
					$notify = '0';
				} else {
					$notify = '1';
				}
			}
		}

		return $notify;
	}

	public function validateOrder($order_id) {
		if ( ! empty($order_id)) {
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
		if (is_numeric($order_id)) $order_id = array($order_id);

		if ( ! empty($order_id) AND ctype_digit(implode('', $order_id))) {
			$this->db->where_in('order_id', $order_id);
			$this->db->delete('orders');

			if (($affected_rows = $this->db->affected_rows()) > 0) {
				$this->db->where_in('order_id', $order_id);
				$this->db->delete('order_menus');

				$this->db->where_in('order_id', $order_id);
				$this->db->delete('order_options');

				$this->db->where_in('order_id', $order_id);
				$this->db->delete('order_totals');

				$this->db->where_in('order_id', $order_id);
				$this->db->delete('coupons_history');

				return $affected_rows;
			}
		}
	}
}

/* End of file orders_model.php */
/* Location: ./system/tastyigniter/models/orders_model.php */