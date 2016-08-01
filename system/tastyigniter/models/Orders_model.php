<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package   TastyIgniter
 * @author    SamPoyigi
 * @copyright TastyIgniter
 * @link      http://tastyigniter.com
 * @license   http://opensource.org/licenses/GPL-3.0 The GNU GENERAL PUBLIC LICENSE
 * @since     File available since Release 1.0
 */
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Orders Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Orders_model.php
 * @link           http://docs.tastyigniter.com
 */
class Orders_model extends TI_Model
{
	/**
	 * @var string The database table name
	 */
	protected $table_name = 'orders';

	/**
	 * @var string The database table primary key
	 */
	protected $primary_key = 'order_id';

	/**
	 * @var array The model table column to convert to dates on insert/update
	 */
	protected $timestamps = array('created' => 'date_added', 'updated' => 'date_modified');

	protected $belongs_to = array(
		'locations' => 'Locations_model',
		'statuses'  => 'Statuses_model',
	);

	/**
	 * Count the number of records
	 *
	 * @param array $filter
	 *
	 * @return int
	 */
	public function getCount($filter = array()) {
		return $this->filter($filter)->with('locations', 'statuses')->count();
	}

	/**
	 * List all orders matching the filter
	 *
	 * @param array $filter
	 *
	 * @return array
	 */
	public function getList($filter = array()) {
		$this->select('*, orders.status_id, status_name, status_color, orders.date_added, orders.date_modified');

		return $this->filter($filter)->with('locations', 'statuses')->find_all();
	}

	/**
	 * Filter database records
	 *
	 * @param array $filter an associative array of field/value pairs
	 *
	 * @return $this
	 */
	public function filter($filter = array()) {
		if (!empty($filter['filter_search'])) {
			$this->like('order_id', $filter['filter_search']);
			$this->or_like('location_name', $filter['filter_search']);
			$this->or_like('first_name', $filter['filter_search']);
			$this->or_like('last_name', $filter['filter_search']);
		}

		if (!empty($filter['customer_id']) AND is_numeric($filter['customer_id'])) {
			$this->where('customer_id', $filter['customer_id']);
		}

		if (!empty($filter['filter_location'])) {
			$this->where('orders.location_id', $filter['filter_location']);
		}

		if (isset($filter['filter_type']) AND is_numeric($filter['filter_type'])) {
			$this->where('order_type', $filter['filter_type']);
		}

		if (!empty($filter['filter_payment'])) {
			$this->where('payment', $filter['filter_payment']);
		}

		if (APPDIR === MAINDIR) {
			$this->where('orders.status_id !=', '0');
		} else {
			if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
				$this->where('orders.status_id', $filter['filter_status']);
			} else {
				$this->where('orders.status_id !=', '0');
			}
		}

		if (!empty($filter['filter_date'])) {
			$date = explode('-', $filter['filter_date']);
			$this->where('YEAR(date_added)', $date[0]);
			$this->where('MONTH(date_added)', $date[1]);
		}

		return $this;
	}

	/**
	 * Find a single order by order_id
	 *
	 * @param int $order_id
	 * @param int $customer_id
	 *
	 * @return bool|object
	 */
	public function getOrder($order_id = NULL, $customer_id = NULL) {
		if (!empty($order_id)) {
			if (!empty($customer_id)) {
				$this->where('customer_id', $customer_id);
			}

			return $this->with('locations', 'statuses')->find($order_id);
		}

		return $order_id;
	}

	/**
	 * Find a single invoice by order_id
	 *
	 * @param int $order_id
	 *
	 * @return bool|object
	 */
	public function getInvoice($order_id = NULL) {
		if (!empty($order_id) AND is_numeric($order_id)) {
			return $this->with('locations', 'statuses')->find($order_id);
		}

		return FALSE;
	}

	/**
	 * Find a single order by order_id during checkout
	 *
	 * @param int $order_id
	 * @param int $customer_id
	 *
	 * @return bool|object
	 */
	public function getCheckoutOrder($order_id, $customer_id) {
		if (isset($order_id, $customer_id)) {
			$this->where('customer_id', $customer_id);
			$this->where('status_id', NULL);

			return $this->find($order_id);
		}

		return FALSE;
	}

	/**
	 * Return all order menu by order_id
	 *
	 * @param int $order_id
	 *
	 * @return array
	 */
	public function getOrderMenus($order_id) {
		$this->where('order_id', $order_id);

		return $this->from('order_menus')->get_many();
	}

	/**
	 * Return all order menu options by order_id
	 *
	 * @param int $order_id
	 *
	 * @return array
	 */
	public function getOrderMenuOptions($order_id) {
		$result = array();

		if (!empty($order_id)) {
			$this->where('order_id', $order_id);
			$result = $this->from('order_options')->get_many();
		}

		return $result;
	}

	/**
	 * Return all order totals by order_id
	 *
	 * @param int $order_id
	 *
	 * @return array
	 */
	public function getOrderTotals($order_id) {
		$this->where('order_id', $order_id);

		return $this->order_by('priority')->from('order_totals')->get_many();
	}

	/**
	 * Find a single used coupon by order_id
	 *
	 * @param int $order_id
	 *
	 * @return mixed
	 */
	public function getOrderCoupon($order_id) {
		$this->load->model('Coupons_history_model');
		$this->Coupons_history_model->where('order_id', $order_id);

		return $this->Coupons_history_model->find();
	}

	/**
	 * Return the dates of all orders
	 *
	 * @return array
	 */
	public function getOrderDates() {
		$this->select('date_added, MONTH(date_added) as month, YEAR(date_added) as year');
		$this->group_by('MONTH(date_added)');
		$this->group_by('YEAR(date_added)');

		return $this->find_all();
	}

	/**
	 * Check if an order was successfully placed
	 *
	 * @param int $order_id
	 *
	 * @return bool TRUE on success, or FALSE on failure
	 */
	public function isOrderPlaced($order_id) {
		$this->where('status_id >', '0');

		return $this->find($order_id) ? TRUE : FALSE;
	}

	/**
	 * Update an existing order by order_id
	 *
	 * @param int   $order_id
	 * @param array $update
	 *
	 * @return bool
	 */
	public function updateOrder($order_id = NULL, $update = array()) {
		if (!is_numeric($order_id)) return FALSE;

		if (isset($update['order_status']) AND !isset($update['status_id'])) {
			$update['status_id'] = $update['order_status'];
		}

		if ($query = $this->update($order_id, $update)) {
			$this->load->model('Statuses_model');
			$status = $this->Statuses_model->getStatus($update['order_status']);

			if (isset($update['status_notify']) AND $update['status_notify'] === '1') {
				$mail_data = $this->getMailData($order_id);

				$mail_data['status_name'] = $status['status_name'];
				$mail_data['status_comment'] = !empty($update['status_comment']) ? $update['status_comment'] : $this->lang->line('text_no_comment');

				$this->load->model('Mail_templates_model');
				$mail_template = $this->Mail_templates_model->getTemplateData($this->config->item('mail_template_id'), 'order_update');
				$update['status_notify'] = $this->sendMail($mail_data['email'], $mail_template, $mail_data);
			}

			$this->addStatusHistory($order_id, $update, $status);

			if ($this->config->item('auto_invoicing') === '1' AND in_array($update['order_status'], (array)$this->config->item('completed_order_status'))) {
				$this->createInvoiceNo($order_id);
			}

			// Make sure order status has not been previously updated
			// to one of the processing order status. If so,
			// skip to avoid updating stock twice.
			$processing_status_exists = $this->Statuses_model->statusExists('order', $order_id, $this->config->item('processing_order_status'));

			if (!$processing_status_exists AND in_array($update['order_status'], (array)$this->config->item('processing_order_status'))) {
				$this->subtractStock($order_id);

				$this->load->model('Coupons_model');
				$this->Coupons_model->redeemCoupon($order_id);
			}
		}

		return $query;
	}

	/**
	 * Generate and save an invoice number
	 *
	 * @param int $order_id
	 *
	 * @return bool|string invoice number on success, or FALSE on failure
	 */
	public function createInvoiceNo($order_id = NULL) {

		$order_status_exists = $this->Statuses_model->statusExists('order', $order_id, $this->config->item('completed_order_status'));
		if ($order_status_exists !== TRUE) return TRUE;

		$order_info = $this->getOrder($order_id);

		if ($order_info AND empty($order_info['invoice_no'])) {
			$order_info['invoice_prefix'] = str_replace('{year}', date('Y'), str_replace('{month}', date('m'), str_replace('{day}', date('d'), $this->config->item('invoice_prefix'))));

			$this->select_max('invoice_no');
			$row = $this->find('invoice_prefix', $order_info['invoice_prefix']);

			$invoice_no = $row ? $row['invoice_no'] + 1 : 1;

			$this->update($order_id, array(
				'invoice_prefix' => $order_info['invoice_prefix'],
				'invoice_no'     => $invoice_no,
				'invoice_date'   => mdate('%Y-%m-%d %H:%i:%s', time()),
			));

			return $order_info['invoice_prefix'] . $invoice_no;
		}

		return FALSE;
	}

	/**
	 * Create a new order
	 *
	 * @param array $order_info
	 * @param array $cart_contents
	 *
	 * @return bool|int order_id on success, FALSE on failure
	 */
	public function addOrder($order_info = array(), $cart_contents = array()) {
		if (empty($order_info) OR empty($cart_contents)) return FALSE;

		if (isset($order_info['order_time'])) {
			$current_time = time();
			$order_time = (strtotime($order_info['order_time']) < strtotime($current_time)) ? $current_time : $order_info['order_time'];
			$order_info['order_time'] = mdate('%H:%i', strtotime($order_time));
			$order_info['order_date'] = mdate('%Y-%m-%d', strtotime($order_time));
			$order_info['ip_address'] = $this->input->ip_address();
			$order_info['user_agent'] = $this->input->user_agent();
		}

		$order_id = is_numeric($order_info['order_id']) ? $order_info['order_id'] : NULL;
		if ($order_id = $this->skip_validation(TRUE)->save($order_info, $order_id)) {
			if (isset($order_info['address_id'])) {
				$this->load->model('Addresses_model');
				$this->Addresses_model->updateDefault($order_info['customer_id'], $order_info['address_id']);
			}

			$this->addOrderMenus($order_id, $cart_contents);

			$this->addOrderTotals($order_id, $cart_contents);

			if (!empty($cart_contents['coupon'])) {
				$this->addOrderCoupon($order_id, $order_info['customer_id'], $cart_contents['coupon']);
			}

			return $order_id;
		}
	}

	/**
	 * Complete order by sending email confirmation and,
	 * updating order status
	 *
	 * @param int   $order_id
	 * @param array $order_info
	 * @param array $cart_contents
	 *
	 * @return bool
	 */
	public function completeOrder($order_id, $order_info, $cart_contents = array()) {

		if ($order_id AND !empty($order_info)) {

			$notify = $this->sendConfirmationMail($order_id);

			$update = array(
				'old_status_id' => '',
				'order_status'  => !empty($order_info['status_id']) ? (int)$order_info['status_id'] : (int)$this->config->item('default_order_status'),
				'notify'        => $notify,
			);

			if ($this->updateOrder($order_id, $update)) {
				if (APPDIR === MAINDIR) {
					log_activity($order_info['customer_id'], 'created', 'orders', get_activity_message('activity_created_order',
						array('{customer}', '{link}', '{order_id}'),
						array($order_info['first_name'] . ' ' . $order_info['last_name'], admin_url('orders/edit?id=' . $order_id), $order_id)
					));
				}

				Events::trigger('after_create_order', array('order_id' => $order_id));

				return TRUE;
			}
		}
	}

	/**
	 * Add cart menu items to order by order_id
	 *
	 * @param int   $order_id
	 * @param array $cart_contents
	 *
	 * @return bool
	 */
	public function addOrderMenus($order_id, $cart_contents = array()) {
		if (is_array($cart_contents) AND !empty($cart_contents) AND $order_id) {
			$this->delete_from('order_menus', array('order_id', $order_id));

			foreach ($cart_contents as $key => $item) {
				if (is_array($item) AND isset($item['rowid']) AND $key === $item['rowid']) {
					$item['order_id'] = $order_id;

					if (isset($item['id'])) {
						$item['menu_id'] = $item['id'];
					}

					if (isset($item['qty'])) {
						$item['quantity'] = $item['qty'];
					}

					if (!empty($item['options'])) {
						$item['option_values'] = serialize($item['options']);
					}

					if ($order_menu_id = $this->insert_into('order_menus', $item)) {
						if (!empty($item['options'])) {
							$this->addOrderMenuOptions($order_menu_id, $order_id, $item['id'], $item['options']);
						}
					}
				}
			}

			return TRUE;
		}
	}

	/**
	 * Add cart menu item options to menu and order by,
	 * order_id and menu_id
	 *
	 * @param int   $order_menu_id
	 * @param int   $order_id
	 * @param int   $menu_id
	 * @param array $menu_options
	 */
	public function addOrderMenuOptions($order_menu_id, $order_id, $menu_id, $menu_options) {
		if (!empty($order_id) AND !empty($menu_id) AND !empty($menu_options)) {
			$this->delete_from('order_options', array(
				'order_id', $order_id,
				'order_menu_id' => $order_menu_id,
				'menu_id'       => $menu_id,
			));

			foreach ($menu_options as $menu_option_id => $options) {
				foreach ($options as $option) {
					$insert['order_menu_option_id'] = $menu_option_id;
					$insert['order_menu_id'] = $order_menu_id;
					$insert['order_id'] = $order_id;
					$insert['menu_id'] = $menu_id;
					$insert['menu_option_value_id'] = $option['value_id'];
					$insert['order_option_name'] = $option['value_name'];
					$insert['order_option_price'] = $option['value_price'];

					$this->insert_into('order_options', $insert);
				}
			}
		}
	}

	/**
	 * Add cart totals to order by order_id
	 *
	 * @param int   $order_id
	 * @param array $cart_contents
	 *
	 * @return bool
	 */
	public function addOrderTotals($order_id, $cart_contents = array()) {
		if (is_numeric($order_id) AND !empty($cart_contents['totals'])) {
			$this->delete_from('order_totals', array('order_id', $order_id));

			$this->load->model('cart_module/Cart_model');
			$order_totals = $this->Cart_model->getTotals();

			$cart_contents['totals']['cart_total']['amount'] = (isset($cart_contents['cart_total'])) ? $cart_contents['cart_total'] : '';
			$cart_contents['totals']['order_total']['amount'] = (isset($cart_contents['order_total'])) ? $cart_contents['order_total'] : '';

			foreach ($cart_contents['totals'] as $name => $total) {
				foreach ($order_totals as $total_name => $order_total) {
					if ($name === $total_name AND is_numeric($total['amount'])) {
						$total['title'] = empty($total['title']) ? $order_total['title'] : $total['title'];
						if (isset($total['code'])) {
							$total['title'] = str_replace('{coupon}', $total['code'], $total['title']);
						} else if (isset($total['tax'])) {
							$total['title'] = str_replace('{tax}', $total['tax'], $total['title']);
						}

						$this->insert_into('order_totals', array(
							'order_id' => $order_id,
							'code'     => $name,
							'title'    => htmlspecialchars($total['title']),
							'priority' => $order_total['priority'],
							'value'    => ($name === 'coupon') ? 0 - $total['amount'] : $total['amount'],
						));
					}
				}
			}

			return TRUE;
		}
	}

	/**
	 * Add cart coupon to order by order_id
	 *
	 * @param int   $order_id
	 * @param int   $customer_id
	 * @param array $coupon
	 *
	 * @return int|bool
	 */
	public function addOrderCoupon($order_id, $customer_id, $coupon) {
		if (is_array($coupon) AND is_numeric($coupon['amount'])) {
			$this->load->model('Coupons_model');
			$this->load->model('Coupons_history_model');

			$this->Coupons_history_model->delete('order_id', $order_id);

			$temp_coupon = $this->Coupons_model->getCouponByCode($coupon['code']);

			$insert = array(
				'order_id'    => $order_id,
				'customer_id' => empty($customer_id) ? '0' : $customer_id,
				'coupon_id'   => $temp_coupon['coupon_id'],
				'code'        => $temp_coupon['code'],
				'amount'      => '-' . $coupon['amount'],
				'date_used'   => mdate('%Y-%m-%d %H:%i:%s', time()),
			);

			return $this->Coupons_history_model->insert($insert);
		}
	}

	/**
	 * Add order status to status history
	 *
	 * @param int $order_id
	 * @param array $update
	 * @param array $status
	 *
	 * @return mixed
	 */
	protected function addStatusHistory($order_id, $update, $status) {
		$status_update = array();
		if (APPDIR === ADMINDIR) {
			$status_update['staff_id'] = $this->user->getStaffId();
		}

		$status_update['object_id'] = (int)$order_id;
		$status_update['status_id'] = (int)$update['order_status'];
		$status_update['comment'] = isset($update['status_comment']) ? $update['status_comment'] : $status['status_comment'];
		$status_update['notify'] = isset($update['status_notify']) ? $update['status_notify'] : $status['notify_customer'];
		$status_update['date_added'] = mdate('%Y-%m-%d %H:%i:%s', time());

		return $this->Statuses_model->addStatusHistory('order', $status_update);
	}

	/**
	 * Subtract cart item quantity from menu stock quantity
	 *
	 * @param int $order_id
	 *
	 * @return bool
	 */
	public function subtractStock($order_id) {
		$this->load->model('Menus_model');

		$order_menus = $this->getOrderMenus($order_id);

		foreach ($order_menus as $order_menu) {
			$this->Menus_model->updateStock($order_menu['menu_id'], $order_menu['quantity'], 'subtract');
		}
	}

	/**
	 * Send the order confirmation email
	 *
	 * @param int $order_id
	 *
	 * @return string 0 on failure, or 1 on success
	 */
	public function sendConfirmationMail($order_id) {
		$this->load->model('Mail_templates_model');

		$mail_data = $this->getMailData($order_id);
		$config_order_email = is_array($this->config->item('order_email')) ? $this->config->item('order_email') : array();

		$notify = '0';
		if ($this->config->item('customer_order_email') === '1' OR in_array('customer', $config_order_email)) {
			$mail_template = $this->Mail_templates_model->getTemplateData($this->config->item('mail_template_id'), 'order');
			$notify = $this->sendMail($mail_data['email'], $mail_template, $mail_data);
		}

		if (!empty($mail_data['location_email']) AND ($this->config->item('location_order_email') === '1' OR in_array('location', $config_order_email))) {
			$mail_template = $this->Mail_templates_model->getTemplateData($this->config->item('mail_template_id'), 'order_alert');
			$this->sendMail($mail_data['location_email'], $mail_template, $mail_data);
		}

		if (in_array('admin', $config_order_email)) {
			$mail_template = $this->Mail_templates_model->getTemplateData($this->config->item('mail_template_id'), 'order_alert');
			$this->sendMail($this->config->item('site_email'), $mail_template, $mail_data);
		}

		return $notify;
	}

	/**
	 * Return the order data to build mail template
	 *
	 * @param int $order_id
	 *
	 * @return array
	 */
	public function getMailData($order_id) {
		$data = array();

		if ($result = $this->getOrder($order_id)) {
			$this->load->library('country');
			$this->load->library('currency');

			$data['order_number'] = $result['order_id'];
			$data['order_view_url'] = root_url('account/orders/view/' . $result['order_id']);
			$data['order_type'] = ($result['order_type'] === '1') ? 'delivery' : 'collection';
			$data['order_time'] = mdate('%H:%i', strtotime($result['order_time'])) . ' ' . mdate('%d %M', strtotime($result['order_date']));
			$data['order_date'] = mdate('%d %M %y', strtotime($result['date_added']));
			$data['first_name'] = $result['first_name'];
			$data['last_name'] = $result['last_name'];
			$data['email'] = $result['email'];
			$data['telephone'] = $result['telephone'];
			$data['order_comment'] = $result['comment'];

			if ($payment = $this->extension->getPayment($result['payment'])) {
				$data['order_payment'] = !empty($payment['ext_data']['title']) ? $payment['ext_data']['title'] : $payment['title'];
			} else {
				$data['order_payment'] = $this->lang->line('text_no_payment');
			}

			$data['order_menus'] = array();
			$menus = $this->getOrderMenus($result['order_id']);
			$options = $this->getOrderMenuOptions($result['order_id']);
			if ($menus) {
				foreach ($menus as $menu) {
					$option_data = array();

					if (!empty($options)) {
						foreach ($options as $key => $option) {
							if ($menu['order_menu_id'] === $option['order_menu_id']) {
								$option_data[] = $option['order_option_name'] . $this->lang->line('text_equals') . $this->currency->format($option['order_option_price']);
							}
						}
					}

					$data['order_menus'][] = array(
						'menu_name'     => $menu['name'],
						'menu_quantity' => $menu['quantity'],
						'menu_price'    => $this->currency->format($menu['price']),
						'menu_subtotal' => $this->currency->format($menu['subtotal']),
						'menu_options'  => implode('<br /> ', $option_data),
						'menu_comment'  => $menu['comment'],
					);
				}
			}

			$data['order_totals'] = array();
			$order_totals = $this->getOrderTotals($result['order_id']);
			if ($order_totals) {
				foreach ($order_totals as $total) {
					$data['order_totals'][] = array(
						'order_total_title' => htmlspecialchars_decode($total['title']),
						'order_total_value' => $this->currency->format($total['value']),
						'priority'          => $total['priority'],
					);
				}
			}

			$data['order_address'] = $this->lang->line('text_collection_order_type');
			if (!empty($result['address_id'])) {
				$this->load->model('Addresses_model');
				$order_address = $this->Addresses_model->getAddress($result['customer_id'], $result['address_id']);
				$data['order_address'] = $this->country->addressFormat($order_address);
			}

			if (!empty($result['location_id'])) {
				$this->load->model('Locations_model');
				$location = $this->Locations_model->getLocation($result['location_id']);
				$data['location_name'] = $location['location_name'];
				$data['location_email'] = $location['location_email'];
			}
		}

		return $data;
	}

	/**
	 * Send an email
	 *
	 * @param int   $email
	 * @param array $mail_template
	 * @param array $mail_data
	 *
	 * @return bool|string
	 */
	public function sendMail($email, $mail_template = array(), $mail_data = array()) {
		if (empty($mail_template) OR !isset($mail_template['subject'], $mail_template['body']) OR empty($mail_data)) {
			return FALSE;
		}

		$this->load->library('email');

		$this->email->initialize();

		if (!empty($mail_data['status_comment'])) {
			$mail_data['status_comment'] = $this->email->parse_template($mail_data['status_comment'], $mail_data);
		}

		$this->email->from($this->config->item('site_email'), $this->config->item('site_name'));
		$this->email->to(strtolower($email));
		$this->email->subject($mail_template['subject'], $mail_data);
		$this->email->message($mail_template['body'], $mail_data);

		if (!$this->email->send()) {
			log_message('error', $this->email->print_debugger(array('headers')));
			$notify = '0';
		} else {
			$notify = '1';
		}

		return $notify;
	}

	/**
	 * Check if an order id already exists in database
	 *
	 * @param int $order_id
	 *
	 * @return bool
	 */
	public function validateOrder($order_id) {
		return (is_numeric($order_id) AND $this->find($order_id)) ? TRUE : FALSE;
	}

	/**
	 * Delete a single or multiple order by order_id, with relationships
	 *
	 * @param int $order_id
	 *
	 * @return int  The number of deleted rows
	 */
	public function deleteOrder($order_id) {
		if (is_numeric($order_id)) $order_id = array($order_id);

		if (!empty($order_id) AND ctype_digit(implode('', $order_id))) {
			$affected_rows = $this->delete('order_id', $order_id);

			if ($affected_rows > 0) {
				$this->delete_from('order_menus', array('order_id', $order_id));

				$this->delete_from('order_options', array('order_id', $order_id));

				$this->delete_from('order_totals', array('order_id', $order_id));

				$this->load->model('Coupons_history_model');
				$this->Coupons_history_model->delete('order_id', $order_id);

				return $affected_rows;
			}
		}
	}
}

/* End of file Orders_model.php */
/* Location: ./system/tastyigniter/models/Orders_model.php */