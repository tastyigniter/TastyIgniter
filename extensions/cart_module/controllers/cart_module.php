<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Cart_module extends Ext_Controller {

	public function __construct() {
		parent::__construct(); 																	// calls the constructor
		$this->load->library('cart'); 															// load the cart library
		$this->load->library('customer');
		$this->load->library('currency'); 														// load the currency library
		$this->load->library('location'); 														// load the location library
		$this->load->model('Cart_model'); 														// load the menus model
		$this->load->model('Image_tool_model'); 														// load the Image tool model
		$this->lang->load('cart_module/cart_module');
	}

	public function index($ext_data = array()) {
		if ( ! file_exists(EXTPATH .'cart_module/views/cart_module.php')) { 								//check if file exists in views folder
			show_404(); 																		// Whoops, show 404 error page!
		}

		if ($this->session->flashdata('cart_alert')) {
			$data['cart_alert'] = $this->session->flashdata('cart_alert');  								// retrieve session flashdata variable if available
		} else {
			$data['cart_alert'] = '';
        }

        $data['cart_alert'] = '';
        // START of retrieving lines from language file to pass to view.
		$data['text_heading'] 		= $this->lang->line('text_heading');
		$data['text_no_cart_items'] = $this->lang->line('text_no_cart_items');
		$data['text_my_order'] 		= $this->lang->line('text_my_order');
		$data['text_change_location'] 	= $this->lang->line('text_change_location');
		$data['text_search_query'] 	= $this->lang->line('text_search_query');
		$data['text_find'] 			= $this->lang->line('text_find');
		$data['text_order_total'] 	= $this->lang->line('text_order_total');
		$data['text_apply_coupon'] 	= $this->lang->line('text_apply_coupon');
		$data['text_delivery'] 		= $this->lang->line('text_delivery');
		$data['text_collection'] 	= $this->lang->line('text_collection');
		$data['text_coupon'] 		= $this->lang->line('text_coupon');
		$data['text_sub_total'] 	= $this->lang->line('text_sub_total');
		$data['text_min_total'] 	= $this->lang->line('text_min_total');
		$data['column_menu'] 		= $this->lang->line('column_menu');
		$data['column_price'] 		= $this->lang->line('column_price');
		$data['column_qty'] 		= $this->lang->line('column_qty');
		$data['column_total'] 		= $this->lang->line('column_total');
		$data['button_coupon'] 		= $this->lang->line('button_coupon');
		// END of retrieving lines from language file to send to view.

		if ( ! $this->location->isOpened()) { 													// else if local restaurant is not open
			$data['text_closed'] = $this->lang->line('text_is_closed');
		}

		$data['order_type'] = $this->location->orderType();

		if ($this->location->deliveryCharge() > 0) {
			$data['delivery_charge'] = sprintf($this->lang->line('text_delivery_charge'), $this->currency->format($this->location->deliveryCharge()));
		} else {
			$data['delivery_charge'] = $this->lang->line('text_free_delivery');
		}

		if ($this->location->minimumOrder() > 0) {
			$data['min_total'] = $this->currency->format($this->location->minimumOrder());
		} else {
			$data['min_total'] = $this->currency->format('0.00');
		}

		if (!$this->location->searchQuery()) {
			$data['alert_no_postcode'] = $this->lang->line('alert_no_postcode');
			if (($this->config->item('search_by') === 'postcode')) {
				$this->alert->set('custom', $this->lang->line('alert_no_postcode'));
			} else {
				$this->alert->set('custom', $this->lang->line('alert_no_address'));
			}
		}

		$data['search_query'] 		= $this->location->searchQuery();
		$data['delivery_time'] 		= sprintf($this->lang->line('text_delivery_time'), $this->location->deliveryTime());
		$data['collection_time'] 	= sprintf($this->lang->line('text_collection_time'), $this->location->collectionTime());

     	$menus = $this->Cart_model->getMenus();

     	$data['cart_items'] = array();
    	$cart_contents = $this->cart->contents();
    	if ($cart_contents) {															// checks if cart contents is not empty
      		foreach ($cart_contents as $cart_item) {								// loop through items in cart
				$menu_data = isset($menus[$cart_item['id']]) ? $menus[$cart_item['id']] : FALSE;				// get menu data based on cart item id from getMenu method in Menus model

 				if (!$menu_data) {
					$this->alert->set('custom', $this->lang->line('alert_menu'));
 					$cart_status = FALSE;
 				} else if ($menu_data['subtract_stock'] === '1' AND $menu_data['stock_qty'] <= 0) {												// checks if stock quantity is less than or equal to zero
					$this->alert->set('custom', sprintf($this->lang->line('alert_stock'), $cart_item['name']));
 					$cart_status = FALSE;
 				} else if ($cart_item['qty'] < $menu_data['minimum_qty']) {									// checks if stock quantity is less than or equal to zero
					$this->alert->set('custom', sprintf($this->lang->line('alert_min_qty'), $cart_item['name'], $menu_data['minimum_qty']));
 					$cart_status = FALSE;
				} else {
 					$cart_status = TRUE;
				}

				$options = array();
				if ($this->cart->has_options($cart_item['rowid']) == TRUE) {
					$menu_options = $this->cart->product_options($cart_item['rowid']);
					$options = str_replace('|', ', ', trim($menu_options['name'], '|'));
				}

				$cart_image = '';
				if (isset($ext_data['show_cart_images']) AND $ext_data['show_cart_images'] === '1') {
					if (!empty($menu_data['menu_photo'])) {
						$cart_image = $this->Image_tool_model->resize($menu_data['menu_photo'], $ext_data['cart_images_h'], $ext_data['cart_images_w']);
					} else {
						$cart_image = $this->Image_tool_model->resize('data/no_photo.png', $ext_data['cart_images_h'], $ext_data['cart_images_w']);
					}
				}

				if ($cart_status === TRUE) {
					$data['cart_items'][] = array(													// load menu data into array
						'rowid'				=> $cart_item['rowid'],
						'menu_id' 			=> $cart_item['id'],
						'name' 				=> (strlen($cart_item['name']) > 15) ? strtolower(substr($cart_item['name'], 0, 15)) .'...' : strtolower($cart_item['name']),
						'price' 			=> $this->currency->format($cart_item['price']),		//add currency symbol and format item price to two decimal places
						'qty' 				=> $cart_item['qty'],
						'image' 			=> $cart_image,
						'sub_total' 		=> $this->currency->format($cart_item['subtotal']), 	//add currency symbol and format item subtotal to two decimal places
						'options' 			=> $options
					);
				} else {
					$this->cart->update(array('rowid' => $cart_item['rowid'], 'qty' => '0'));										// pass the cart_data array to add item to cart, if successful
				}
			}

			if ($this->location->orderType() == '1') {
				if ($this->cart->set_delivery($this->location->deliveryCharge())) {
					$data['sub_total'] 	= $this->currency->format($this->cart->total());
					$data['delivery'] = $this->currency->format($this->cart->delivery());
				}
			}

			if ($this->location->orderType() == '2') {
				$this->cart->set_delivery(0);
			}

			$data['coupon'] = array();
            $coupon = $this->cart->coupon();
			if (!empty($coupon['code'])) {
				$response = $this->validateCoupon($coupon['code']);

				if (!is_array($response)) {
					$this->alert->set('custom', $response);
				} else {
					$data['sub_total'] 	= $this->currency->format($this->cart->total());
					$data['coupon'] = array(
						'code' 		=> $coupon['code'],
						'discount' 	=> $this->currency->format($coupon['discount'])
					);
				}
			}

			$data['order_total'] = $this->currency->format($this->cart->order_total());
		}

		$data['show_cart_image'] 	= isset($ext_data['show_cart_images']) ? $ext_data['show_cart_images'] : '';
		$data['cart_images_h'] 		= isset($ext_data['cart_images_h']) ? $ext_data['cart_images_h'] : '';
		$data['cart_images_w'] 		= isset($ext_data['cart_images_w']) ? $ext_data['cart_images_w'] :'';

		$this->load->view('cart_module/cart_module', $data);
	}

	public function options() {																	// _updateModule() method to update cart
		if ( ! file_exists(EXTPATH .'cart_module/views/cart_options.php')) { 								//check if file exists in views folder
			show_404(); 																		// Whoops, show 404 error page!
		}

		if ($this->session->flashdata('option_alert')) {
			$data['option_alert'] = $this->session->flashdata('option_alert');  								// retrieve session flashdata variable if available
		} else {
			$data['option_alert'] = '';
		}

		$menu_id = $this->input->get('menu_id');											// store $_POST menu_id value into variable
		$menu_data = $this->Cart_model->getMenu($menu_id);
		$row_id = $this->input->get('row_id');											// store $_POST menu_id value into variable

		if ($this->input->get('row_id')) {
			$data['heading'] = sprintf($this->lang->line('text_update_menu'), strtolower($menu_data['menu_name']));
		} else {
			$data['heading'] = sprintf($this->lang->line('text_add_menu'), strtolower($menu_data['menu_name']));
		}

		$data['menu_id'] 				= $menu_id;
		$data['row_id'] 				= $row_id;
		$data['menu_name'] 				= $menu_data['menu_name'];
		$data['description'] 			= $menu_data['menu_description'];
		$data['quantities'] 			= array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10');
		$data['menu_option_value_ids'] 	= array();

		if ($this->cart->get_item($row_id)) {
			$cart_item = $this->cart->get_item($row_id);
			$quantity = $cart_item['qty'];

			if (!empty($cart_item['options']) AND isset($cart_item['options']['menu_option_value_id'])) {
				$data['menu_option_value_ids'] = explode('|', $cart_item['options']['menu_option_value_id']);
			}
		}

		$data['quantity'] = (isset($quantity)) ? $quantity : 1;
		$data['menu_options'] = array();
		$menu_options = $this->Cart_model->getMenuOptions($menu_id);						// get menu option data based on menu option id from getMenuOption method in Menus model
		if ($menu_options) {
			foreach ($menu_options as $menu_id => $option) {
				$option_values_data = array();

				$option_values = $this->Cart_model->getMenuOptionValues($option['menu_option_id'], $option['option_id']);
				foreach ($option_values as $value) {
					$option_values_data[] = array(
						'option_value_id'		=> $value['option_value_id'],
						'menu_option_value_id'	=> $value['menu_option_value_id'],
						'value'					=> $value['value'],
						'price'					=> (empty($value['new_price']) OR $value['new_price'] == '0.00') ? $this->currency->format($value['price']) : $this->currency->format($value['new_price']),
					);
				}

				$data['menu_options'][$option['menu_option_id']] = array(
					'menu_option_id'	=> $option['menu_option_id'],
					'menu_id'			=> $option['menu_id'],
					'option_id'			=> $option['option_id'],
					'option_name'		=> $option['option_name'],
					'display_type'		=> $option['display_type'],
					'priority'			=> $option['priority'],
					'option_values'		=> $option_values_data
				);
			}
		}

		$this->load->view('cart_module/cart_options', $data);
	}

	public function add() {																		// add() method to add item to cart
		$json = array();
		$update_cart = $cart_option = FALSE;

		if ( ! $this->input->is_ajax_request()) {
			$json['error'] = $this->lang->line('alert_error');
		} else if ( ! $this->location->local() AND $this->config->item('location_order') === '1') { 														// if local restaurant is not selected
			$json['error'] = $this->lang->line('alert_local');
		} else if ( ! $this->location->isOpened() AND $this->config->item('future_orders') !== '1') { 											// else if local restaurant is not open
			$json['error'] = $this->lang->line('alert_closed');
		} else if ( ! $this->input->post('menu_id')) {
			$json['error'] = $this->lang->line('alert_select');
		} else if ($menu_data = $this->Cart_model->getMenu($this->input->post('menu_id'))) {
			$menu_id = $this->input->post('menu_id');
			$menu_options = $this->Cart_model->getMenuOptions($menu_id);						// get menu option data based on menu option id from getMenuOption method in Menus model

			if ($this->input->post('quantity') AND $this->input->post('quantity') < $menu_data['minimum_qty']) {
				$json['error'] = $this->lang->line('alert_menu_min_qty');
			}

			if ($menu_data['subtract_stock'] === '1' AND $menu_data['stock_qty'] <= 0) {												// checks if stock quantity is less than or equal to zero
				$json['error'] = $this->lang->line('alert_menu_stock');
			}

			$menu_option_data = array();
			$option_price = 0;
			if ($this->input->post('menu_options') AND is_array($this->input->post('menu_options'))) {
				$menu_option_value_ids = $option_names = $option_prices = array();

				foreach ($this->input->post('menu_options') as $menu_option) {
					if (isset($menu_options[$menu_option['menu_option_id']])) {
						if ($menu_options[$menu_option['menu_option_id']]['required'] == '1' AND (empty($menu_option['option_values']) OR empty($menu_option['option_values'][0]))) {
							$cart_option = TRUE;
							break;
						}

						$option_values = $this->Cart_model->getMenuOptionValues($menu_option['menu_option_id'], $menu_option['option_id']);
						if (!empty($menu_option['option_values'])) {
							foreach ($menu_option['option_values'] as $key => $value) {
								if (isset($option_values[$value])) {
									$menu_option_value_ids[] 	= $option_values[$value]['menu_option_value_id'];
									$option_names[]				= $option_values[$value]['value'];
									$option_prices[]			= $option_values[$value]['price'];

									$option_price += $option_values[$value]['price'];
								}
							}
						}
					}
				}

				if ($cart_option === TRUE) {
					$json['error'] = sprintf($this->lang->line('alert_option_required'), $menu_options[$menu_option['menu_option_id']]['option_name']);
				} else {
					$menu_option_data = array(
						'menu_option_value_id'	=> implode('|', $menu_option_value_ids),
						'name'					=> implode('|', $option_names),
						'price'					=> implode('|', $option_prices)
					);
				}
			}

			if ($menu_options AND (!$this->input->post('menu_options') OR $cart_option)) {
				$json['options'] = TRUE;
			}

			$quantity = ($this->input->post('quantity')) ? $this->input->post('quantity') : 1;
			$quantity = ($quantity < $menu_data['minimum_qty']) ? $menu_data['minimum_qty'] : $quantity;

			if ($cart_item = $this->cart->get_item($this->input->post('row_id'))) {
				$cart_options = ( ! empty($cart_item['options'])) ? explode('|', $cart_item['options']['menu_option_value_id']) : array();
				$options_data = ( ! empty($menu_option_data)) ? explode('|', $menu_option_data['menu_option_value_id']) : array();

				if ($cart_item['rowid'] == $this->input->post('row_id') OR ( ! array_diff($cart_options, $options_data) AND ! array_diff($options_data, $cart_options))) {
					$row_id = $cart_item['rowid'];
					$quantity = ( ! $this->input->post('quantity')) ? $cart_item['qty'] + $quantity : $quantity;
					$update_cart = TRUE;
				}
			}

			if (!empty($option_price)) {															// checks if menu option data if available
				$menu_price = $option_price + $menu_data['menu_price'];
			} else if ($menu_data['is_special'] === '1') {											// else if special_price is empty
				$menu_price = $menu_data['special_price'];
			} else {
				$menu_price = $menu_data['menu_price'];
			}

			$cart_data = array(																// create an array of item to be added to cart with id, name, qty, price and options as keys
				'id'     		=> $menu_id,
				'name'   		=> $menu_data['menu_name'],
				'qty'    		=> $quantity,
				'price'  		=> $this->cart->format_number($menu_price),
				'options' 		=> $menu_option_data
			);
		}

		if (!$json) {
			if ($update_cart === TRUE) {
				$cart_data['rowid'] = $row_id;

				if ($this->cart->update($cart_data)) {
					$json['success'] = $this->lang->line('alert_menu_updated');					// display success message
				} else {
					$json['error'] = $this->lang->line('alert_error');							// display error message
				}
			} else {
				if ($this->cart->insert($cart_data)) {
					$json['success'] = $this->lang->line('alert_menu_added');					// display success message
				} else {
					$json['error'] = $this->lang->line('alert_error');							// display error message
				}
			}
		}

		$this->output->set_output(json_encode($json));											// encode the json array and set final out to be sent to jQuery AJAX
	}

	public function remove() {																	// remove() method to update cart
		$json = array();

		if (!$json) {
			$row_id = $this->input->post('row_id');												// store $_POST row_id value into variable
			$quantity = $this->input->post('quantity');											// store $_POST quantity value into variable

			$update_data = array (																// create an array of item to be updated in cart with rowid, and qty as keys
				'rowid' => $row_id,
				'qty' => $quantity
			);

			if ($this->cart->update($update_data)) {											// pass the cart_data array to add item to cart, if successful
				$json['success'] = $this->lang->line('alert_menu_updated');						// display success message
			} else {																			// else redirect to menus page
				$json['redirect'] = site_url('menus');
			}
		}

		$this->output->set_output(json_encode($json));	// encode the json array and set final out to be sent to jQuery AJAX
	}

	public function coupon() {																	// _updateModule() method to update cart
		$json = array();

		if (!$json AND $this->input->post('code')) {
			switch ($this->input->get('action')) {
				case 'remove':
					$this->cart->remove_coupon($this->input->post('code'));
					$json['success'] = $this->lang->line('alert_coupon_removed');						// display success message
					break;

				case 'add':
					$response = $this->validateCoupon($this->input->post('code'));

					if (is_array($response)) {
						$this->cart->add_coupon($response);
						$json['success'] = $this->lang->line('alert_coupon_applied');						// display success message
					} else {
						$json['error'] = $response;
					}
					break;
			}
		}

		$this->output->set_output(json_encode($json));											// encode the json array and set final out to be sent to jQuery AJAX
	}

	public function order_type() {																	// _updateModule() method to update cart
		$json = array();

		if (!$json) {
			$this->load->library('location');

			if (!$this->location->searchQuery() OR !$this->location->local()) {
				$json['error'] = ($this->config->item('search_by') === 'postcode') ? $this->lang->line('alert_no_postcode') : $this->lang->line('alert_no_address');
			} else {
				$order_type = (is_numeric($this->input->post('order_type'))) ? $this->input->post('order_type') : '1';

				if ($order_type === '1') {
					if (!$this->location->hasDelivery()) {
						$json['error'] = $this->lang->line('alert_no_delivery');
					} else if ($this->location->hasDelivery() AND !$this->location->checkDeliveryCoverage()) {
						$json['error'] = $this->lang->line('alert_delivery_coverage');
					} else if ($this->cart->contents() AND ! $this->location->checkMinimumOrder($this->cart->total())) { 							// checks if cart contents is empty
						$json['error'] = $this->lang->line('alert_min_total');
					}

				} else if ($order_type === '2') {
					if (!$this->location->hasCollection()) {
						$json['error'] = $this->lang->line('alert_no_collection');
					}
				}

				$this->location->setOrderType($order_type);
			}
		}

		$this->output->set_output(json_encode($json));	// encode the json array and set final out to be sent to jQuery AJAX
	}

	public function validateCoupon($code = '') {
		$error = '';

		if (!empty($code)) {
			$coupon = $this->Cart_model->checkCoupon($code);
		} else {
			$error = $this->lang->line('alert_coupon_invalid');						// display error message
		}

		if (!$coupon AND !$error) {
			$error = $this->lang->line('alert_coupon_expired');								// display error message
		} else {
			if ($coupon['min_total'] > $this->cart->total()) {
				$error = sprintf($this->lang->line('alert_coupon_total'), $this->currency->format($coupon['min_total']));
			}

			$used = $this->Cart_model->checkCouponHistory($coupon['coupon_id']);

			if (!empty($coupon['redemptions']) AND ($coupon['redemptions']) <= ($used)) {
				$error = $this->lang->line('alert_coupon_redeem');
			}

			if ($coupon['customer_redemptions'] === '1' AND $this->customer->getId()) {
				$customer_used = $this->Cart_model->checkCustomerCouponHistory($coupon['coupon_id'], $this->customer->getId());

				if ($coupon['customer_redemptions'] <= $customer_used) {
					$error = $this->lang->line('alert_coupon_redeem');
				}
			}
		}

		if ($error !== '') {
			return $error;
		} else {
			return array('code' => $coupon['code'], 'type' => $coupon['type'], 'discount' => $coupon['discount']);
		}
	}
}

/* End of file cart_module.php */
/* Location: ./extensions/cart_module/controllers/cart_module.php */