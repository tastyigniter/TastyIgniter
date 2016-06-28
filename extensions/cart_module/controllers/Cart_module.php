<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Cart_module extends Main_Controller {

	protected $referrer_uri;

	public function __construct() {
		parent::__construct(); 																	// calls the constructor

        $this->load->model('cart_module/Cart_model'); 														// load the cart model
        $this->load->model('Image_tool_model'); 														// load the Image tool model

		$this->load->library('location');
		$this->location->initialize();

		$this->load->library('cart'); 															// load the cart library
        $this->load->library('currency'); 														// load the currency library

        $this->lang->load('cart_module/cart_module');

		$this->load->library('cart_module/Cart_module_lib'); 												// load the cart module library

		$referrer_uri = explode('/', str_replace(site_url(), '', $this->agent->referrer()));
		$this->referrer_uri = ($this->uri->rsegment(1) === 'cart_module' AND !empty($referrer_uri[0])) ? $referrer_uri[0] : $this->uri->rsegment(1);
	}

	public function index($module = array(), $data = array()) {
		$this->getCart($module, $data);
	}

	public function add() {																		// add() method to add item to cart
		$json = array();

		if ( ! $this->input->is_ajax_request()) {

			$json['error'] = $this->lang->line('alert_bad_request');

		} else if ( $this->config->item('location_order') === '1' AND ! $this->location->hasSearchQuery()) { 														// if local restaurant is not selected

			$json['error'] = $this->lang->line('alert_no_search_query');

		} else if (($response = $this->cart_module_lib->validateOrderType('', FALSE)) !== TRUE) {

			$json['error'] = $response;

		} else if ( ! $this->input->post('menu_id')) {

			$json['error'] = $this->lang->line('alert_no_menu_selected');

		} else if ($menu_data = $this->Cart_model->getMenu($this->input->post('menu_id'))) {

			$quantity = (is_numeric($this->input->post('quantity'))) ? $this->input->post('quantity') : 0;

			$alert_msg = $this->cart_module_lib->validateCartMenu($menu_data, array('qty' => $quantity));
			if (!empty($alert_msg) AND is_string($alert_msg)) {
				$json['error'] = $alert_msg;
			}

			$menu_options = $this->Cart_model->getMenuOptions($menu_data['menu_id']);                        // get menu option data based on menu option id from getMenuOption method in Menus model

			$cart_options = $this->cart_module_lib->validateCartMenuOption($menu_data, $menu_options);
			if (!empty($cart_options) AND is_string($cart_options)) {
				$json['option_error'] = $cart_options;
				$cart_options = array();
			}

			if ($cart_item = $this->cart->get_item($this->input->post('row_id'))) {
				$quantity = ($quantity <= 0) ? $cart_item['qty'] + $quantity : $quantity;
			}

			$price = (!empty($menu_data['special_status']) AND $menu_data['is_special'] === '1') ? $menu_data['special_price'] : $menu_data['menu_price'];

			$cart_data = array(																// create an array of item to be added to cart with id, name, qty, price and options as keys
				'rowid'         => !empty($cart_item['rowid']) ? $cart_item['rowid'] : NULL,
				'id'     		=> $menu_data['menu_id'],
				'name'   		=> $menu_data['menu_name'],
				'qty'    		=> $quantity,
				'price'  		=> $price,
				'comment'       => $this->input->post('comment') ? substr(htmlspecialchars(trim($this->input->post('comment'))), 0, 50) : '',
				'options' 		=> $cart_options
			);
		}

		if (!$json AND !empty($cart_data)) {
			if ($cart_data['rowid'] !== NULL AND $this->cart->update($cart_data)) {
				$json['success'] = $this->lang->line('alert_menu_updated');					// display success message
			} else if ($this->cart->insert($cart_data)) {
				$json['success'] = $this->lang->line('alert_menu_added');					// display success message
			}

			if (!isset($json['success'])) {
				$json['error'] = $this->lang->line('alert_unknown_error');							// display error message
			}
		}

		$this->output->set_output(json_encode($json));											// encode the json array and set final out to be sent to jQuery AJAX
	}

	public function options() {																	// _updateModule() method to update cart
		if ( ! file_exists(EXTPATH .'cart_module/views/cart_options.php')) { 								//check if file exists in views folder
			show_404(); 																		// Whoops, show 404 error page!
		}

		$menu_data = $this->Cart_model->getMenu($this->input->get('menu_id'));

		if ($cart_item = $this->cart->get_item($this->input->get('row_id'))) {
			$data['text_heading'] = $this->lang->line('text_update_heading');
			$quantity = $cart_item['qty'];
		} else {
			$data['text_heading'] = $this->lang->line('text_add_heading');
		}

		$data['menu_id'] 				= $this->input->get('menu_id');
		$data['row_id'] 				= $this->input->get('row_id');
		$data['menu_name'] 				= $menu_data['menu_name'];
		$data['menu_price'] 			= $this->currency->format($menu_data['menu_price']);
		$data['description'] 			= $menu_data['menu_description'];
		$data['quantities'] 			= array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10');
		$data['quantity']               = (isset($quantity)) ? $quantity : 1;
		$data['comment']                = isset($cart_item['comment']) ? $cart_item['comment'] : '';

		$menu_photo = (!empty($menu_data['menu_photo'])) ? $menu_data['menu_photo'] : 'data/no_photo.png';
		$menu_images_w = (is_numeric($this->config->item('menu_images_w'))) ? $this->config->item('menu_images_w') : '154';
		$menu_images_h = (is_numeric($this->config->item('menu_images_h'))) ? $this->config->item('menu_images_h') : '154';
		$data['menu_image'] = $this->Image_tool_model->resize($menu_photo, $menu_images_w, $menu_images_h);

		$data['cart_option_value_ids'] = (!empty($cart_item['options'])) ?
			$this->cart->product_options_ids($this->input->get('row_id')) : array();

		// get menu option data based on menu option id from getMenuOption method in Menus model
		$data['menu_options'] = array();
		if ($menu_options = $this->Cart_model->getMenuOptions($this->input->get('menu_id'))) {
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
					'menu_option_id'   => $option['menu_option_id'],
					'menu_id'          => $option['menu_id'],
					'option_id'        => $option['option_id'],
					'option_name'      => $option['option_name'],
					'display_type'     => $option['display_type'],
					'priority'         => $option['priority'],
					'default_value_id' => isset($option['default_value_id']) ? $option['default_value_id'] : 0,
					'option_values'    => $option_values_data,
				);
			}
		}

		$data['cart_option_alert'] = $this->alert->display('cart_option_alert');

		$this->load->view('cart_module/cart_options', $data);
	}

	public function order_type() {																// _updateModule() method to update cart
		$json = array();

		$order_type = (is_numeric($this->input->post('order_type'))) ? $this->input->post('order_type') : NULL;

		if (!$json AND $order_type) {
			$response = $this->cart_module_lib->validateOrderType($order_type);

			if ($response !== TRUE) {
				$json['error'] = $response;
			}

			$this->location->setOrderType($order_type);

			$json['order_type'] = $this->location->orderType();
			$json['redirect'] = referrer_url();
		}

		$this->output->set_output(json_encode($json));	// encode the json array and set final out to be sent to jQuery AJAX
    }

	public function coupon() {																	// _updateModule() method to update cart
        $json = array();

        if (!$json AND $this->cart->contents() AND is_string($this->input->post('code'))) {
            switch ($this->input->post('action')) {
                case 'remove':
                    $this->cart->remove_coupon($this->input->post('code'));
                    $json['success'] = $this->lang->line('alert_coupon_removed');						// display success message
                    break;

                case 'add':
                    if (($response = $this->cart_module_lib->validateCoupon($this->input->post('code'))) === TRUE) {
                        $json['success'] = $this->lang->line('alert_coupon_applied');						// display success message
                    } else {
                        $json['error'] = $response;
                    }
                    break;
                default:
                    $json['redirect'] = referrer_url();
                    break;
            }
        }

        $this->output->set_output(json_encode($json));											// encode the json array and set final out to be sent to jQuery AJAX
    }

	public function remove() {																	// remove() method to update cart
        $json = array();

        if (!$json) {
            if ($this->cart->update(array ('rowid' => $this->input->post('row_id'), 'qty' => $this->input->post('quantity')))) {											// pass the cart_data array to add item to cart, if successful
                $json['success'] = $this->lang->line('alert_menu_updated');						// display success message
            } else {																			// else redirect to menus page
                $json['redirect'] = site_url(referrer_url());
            }
        }

        $this->output->set_output(json_encode($json));	// encode the json array and set final out to be sent to jQuery AJAX
    }

	public function getCart($module = array(), $data = array(), $is_mobile = FALSE) {
		if ( ! file_exists(EXTPATH .'cart_module/views/cart_module.php')) { 								//check if file exists in views folder
			show_404(); 																		// Whoops, show 404 error page!
		}

		$data['rsegment'] = $rsegment = $this->referrer_uri;

		$ext_data = (!empty($module['data']) AND is_array($module['data'])) ? $module['data'] : array();

		if (empty($ext_data)) {
			$extension = $this->extension->getModule('cart_module');
			if (!empty($extension['ext_data'])) {
				$ext_data = $extension['ext_data'];
			};
		}

		$this->template->setStyleTag(extension_url('cart_module/views/stylesheet.css'), 'cart-module-css', '144000');

		$data['is_opened']                  = $this->location->isOpened();
		$data['order_type']                 = $this->location->orderType();
		$data['search_query'] 		        = $this->location->searchQuery();
		$data['opening_status']		 		= $this->location->workingStatus('opening');
		$data['delivery_status']			= $this->location->workingStatus('delivery');
		$data['collection_status']			= $this->location->workingStatus('collection');
		$data['has_delivery']               = $this->location->hasDelivery();
		$data['has_collection']             = $this->location->hasCollection();
		$data['show_cart_images'] 	        = isset($ext_data['show_cart_images']) ? $ext_data['show_cart_images'] : '';
		$data['cart_images_h'] 		        = isset($ext_data['cart_images_h']) ? $ext_data['cart_images_h'] : '';
		$data['cart_images_w'] 		        = isset($ext_data['cart_images_w']) ? $ext_data['cart_images_w'] :'';

		$data['delivery_time'] = $this->location->deliveryTime();
		if ($data['delivery_status'] === 'closed') {
			$data['delivery_time'] = 'closed';
		} else if ($data['delivery_status'] === 'opening') {
			$data['delivery_time'] = $this->location->workingTime('delivery', 'open');
		}

		$data['collection_time'] = $this->location->collectionTime();
		if ($data['collection_status'] === 'closed') {
			$data['collection_time'] = 'closed';
		} else if ($data['collection_status'] === 'opening') {
			$data['collection_time'] = $this->location->workingTime('collection', 'open');
		}

		$order_data = $this->session->userdata('order_data');
		if ($this->input->post('checkout_step')) {
			$checkout_step = $this->input->post('checkout_step');
		} else if (isset($order_data['checkout_step'])) {
			$checkout_step = $order_data['checkout_step'];
		} else {
			$checkout_step = 'one';
		}

		if ($rsegment === 'checkout' AND $checkout_step === 'two') {
			$data['button_order'] = '<a class="btn btn-order btn-primary btn-block btn-lg" onclick="$(\'#checkout-form\').submit();">' . $this->lang->line('button_confirm') . '</a>';
		} else if ($rsegment == 'checkout') {
			$data['button_order'] = '<a class="btn btn-order btn-primary btn-block btn-lg" onclick="$(\'#checkout-form\').submit();">' . $this->lang->line('button_payment') . '</a>';
		} else {
			$data['button_order'] = '<a class="btn btn-order btn-primary btn-block btn-lg" href="' . site_url('checkout') . '">' . $this->lang->line('button_order') . '</a>';
		}

		if ($this->location->isClosed() OR ! $this->location->checkOrderType()) {
			$data['button_order'] = '<a class="btn btn-default btn-block btn-lg" href="' . site_url('checkout') . '"><b>' . $this->lang->line('text_is_closed') . '</b></a>';
		}

		$menus = $this->Cart_model->getMenus();

		$data['cart_items'] = $data['cart_totals'] = array();
		if ($cart_contents = $this->cart->contents()) {															// checks if cart contents is not empty
			foreach ($cart_contents as $row_id => $cart_item) {								// loop through items in cart
				$menu_data = isset($menus[$cart_item['id']]) ? $menus[$cart_item['id']] : FALSE;				// get menu data based on cart item id from getMenu method in Menus model

				if (($alert_msg = $this->cart_module_lib->validateCartMenu($menu_data, $cart_item)) === TRUE) {
					$cart_image = '';
					if (isset($data['show_cart_images']) AND $data['show_cart_images'] === '1') {
						$menu_photo = (!empty($menu_data['menu_photo'])) ? $menu_data['menu_photo'] : 'data/no_photo.png';
						$cart_image = $this->Image_tool_model->resize($menu_photo, $data['cart_images_h'], $data['cart_images_w']);
					}

					// load menu data into array
					$data['cart_items'][] = array(
						'rowid'				=> $cart_item['rowid'],
						'menu_id' 			=> $cart_item['id'],
						'name' 				=> (strlen($cart_item['name']) > 25) ? strtolower(substr($cart_item['name'], 0, 25)) .'...' : strtolower($cart_item['name']),
						//add currency symbol and format item price to two decimal places
						'price' 			=> $this->currency->format($cart_item['price']),
						'qty' 				=> $cart_item['qty'],
						'image' 			=> $cart_image,
						//add currency symbol and format item subtotal to two decimal places
						'sub_total' 		=> $this->currency->format($cart_item['subtotal']),
						'comment'           => isset($cart_item['comment']) ? $cart_item['comment'] : '',
						'options' 			=> ($this->cart->has_options($row_id) == TRUE) ? $this->cart->product_options_string($row_id) : ''
					);

				} else {
					$this->alert->set('custom_now', $alert_msg, 'cart_module');
					$this->cart->update(array('rowid' => $cart_item['rowid'], 'qty' => '0'));										// pass the cart_data array to add item to cart, if successful
				}
			}

			if (($response = $this->cart_module_lib->validateOrderType()) !== TRUE) {
				$this->alert->set('custom', $response, 'cart_module');
			}

			if (($response = $this->cart_module_lib->validateDeliveryCharge($this->cart->total())) !== TRUE) {
				$this->alert->set('custom', $response, 'cart_module');
			}

			if (($response = $this->cart_module_lib->validateCoupon($this->cart->coupon_code())) !== TRUE) {
				$this->alert->set('custom', $response, 'cart_module');
			}

            Events::trigger('cart_module_before_cart_totals');

            $this->cart->calculate_tax();

            $data['cart_totals'] = $this->cart_module_lib->cartTotals();
		}

		$data['fixed_cart'] = '';
		$fixed_cart = isset($ext_data['fixed_cart']) ? $ext_data['fixed_cart'] : '1';
		if (!$is_mobile AND $fixed_cart === '1' AND $rsegment !== 'checkout') {
			$fixed_top_offset = isset($ext_data['fixed_top_offset']) ? $ext_data['fixed_top_offset'] : '250';
			$fixed_bottom_offset = isset($ext_data['fixed_bottom_offset']) ? $ext_data['fixed_bottom_offset'] : '120';
			$data['fixed_cart'] = 'id="cart-box-affix" data-spy="affix" data-offset-top="'.$fixed_top_offset.'" data-offset-bottom="'.$fixed_bottom_offset.'"';
		}

		$data['is_checkout'] = ($rsegment === 'checkout') ? TRUE : FALSE;
		$data['is_mobile'] = $is_mobile;

		$data['cart_alert'] = $this->alert->display('cart_module');

		if ($is_mobile) {
			return $this->load->view('cart_module/cart_module', $data, TRUE);
		} else {
			$this->load->view('cart_module/cart_module', $data);
		}
	}
}

/* End of file cart_module.php */
/* Location: ./extensions/cart_module/controllers/cart_module.php */