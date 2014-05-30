<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cart_module extends MX_Controller {

	public function __construct() {
		parent::__construct(); 																	// calls the constructor
		$this->load->library('cart'); 															// load the cart library
		$this->load->library('customer');
		$this->load->library('currency'); 														// load the currency library
		$this->load->library('location'); 														// load the location library
		$this->load->model('Cart_model'); 														// load the menus model
		$this->load->model('Coupons_model'); 														// load the coupons model
		$this->load->library('language');
		$this->lang->load('main/cart_module', $this->language->folder());
	}

	public function index() {
		if ( !file_exists(EXTPATH .'main/views/cart_module.php')) { 								//check if file exists in views folder
			show_404(); 																		// Whoops, show 404 error page!
		}
			
		if ($this->session->flashdata('cart_alert')) {
			$data['cart_alert'] = $this->session->flashdata('cart_alert');  								// retrieve session flashdata variable if available
		} else {
			$data['cart_alert'] = '';
		}

		if ($this->session->userdata('cart_alert')) {
			$data['cart_alert'] = $this->session->userdata('cart_alert');  								// retrieve session flashdata variable if available
			$this->session->unset_userdata('cart_alert');
		} else {
			$data['cart_alert'] = '';
		}

		// START of retrieving lines from language file to pass to view.
		$data['text_heading'] 		= $this->lang->line('text_heading');
		$data['text_no_cart_items'] = $this->lang->line('text_no_cart_items');
		$data['text_your_order'] 	= $this->lang->line('text_your_order');
		$data['text_order_total'] 	= $this->lang->line('text_order_total');
		$data['text_apply_coupon'] 	= $this->lang->line('text_apply_coupon');
		$data['text_delivery'] 		= $this->lang->line('text_delivery');
		$data['text_coupon'] 		= $this->lang->line('text_coupon');
		$data['text_sub_total'] 	= $this->lang->line('text_sub_total');
		$data['column_menu'] 		= $this->lang->line('column_menu');
		$data['column_price'] 		= $this->lang->line('column_price');
		$data['column_qty'] 		= $this->lang->line('column_qty');
		$data['column_total'] 		= $this->lang->line('column_total');

		$data['button_back'] 		= $this->lang->line('button_back');
		$data['button_continue'] 	= $this->lang->line('button_continue');
		$data['button_coupon'] 		= $this->lang->line('button_coupon');
		// END of retrieving lines from language file to send to view.

		$data['back'] 				= site_url('main/menus');
		$data['continue'] 			= site_url('main/checkout');

		$data['quantities'] = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '20');	// load array of quantity values

     	$data['cart_items'] = array();

    	if ($this->cart->contents()) {															// checks if cart contents is not empty

      		foreach ($this->cart->contents() as $cart_item) {								// loop through items in cart
				$menu_data = $this->Cart_model->getMenu($cart_item['id']);				// get menu data based on cart item id from getMenu method in Menus model
 				
 				if (!$menu_data) {
					$data['cart_alert'] = '<p class="error">Menu Unavailable, please try again.</p>';
 					$cart_status = FALSE; 				
 				} else if ($menu_data['stock_qty'] <= 0) {												// checks if stock quantity is less than or equal to zero
					$data['cart_alert'] = '<p class="error">'. $cart_item['name'] .' is currently out of stock</p>';
 					$cart_status = FALSE;
 				} else if ($cart_item['qty'] < $menu_data['minimum_qty']) {									// checks if stock quantity is less than or equal to zero
					$data['cart_alert'] = $cart_item['name'] .' minimum quantity is ' .$menu_data['minimum_qty'];							// display error		
 					$cart_status = FALSE;
				} else {				
 					$cart_status = TRUE;
				}
				
				$cart_options = array();
				if ($this->cart->has_options($cart_item['rowid']) == TRUE) {
					$menu_option = $this->cart->product_options($cart_item['rowid']);
					$cart_options = array('name' => $menu_option['name'], 'price' => $this->currency->format($menu_option['price']));
				}

				if ($cart_status === TRUE) {
					$data['cart_items'][] = array(													// load menu data into array
						'rowid'				=> $cart_item['rowid'],
						'menu_id' 			=> $cart_item['id'],
						'name' 				=> (strlen($cart_item['name']) > 20) ? substr($cart_item['name'], 0, 20) .'...' : $cart_item['name'],			
						'price' 			=> $this->currency->format($cart_item['price']),		//add currency symbol and format item price to two decimal places
						'qty' 				=> $cart_item['qty'],
						'sub_total' 		=> $this->currency->format($cart_item['subtotal']), 	//add currency symbol and format item subtotal to two decimal places
						'options' 			=> $cart_options
					);
				} else {

					$this->cart->update(array('rowid' => $cart_item['rowid'], 'qty' => '0'));										// pass the cart_data array to add item to cart, if successful				
				}
			}
			
			if ( ! $this->location->checkMinTotal($this->cart->total())) { 							// checks if cart contents is empty  
				$data['cart_alert'] = '<p class="error">Order total is below the minimum delivery total!</p>';
			}
			
			if ($this->cart->set_delivery($this->location->getDeliveryCharge())) {
				$data['sub_total'] 	= $this->currency->format($this->cart->total());
				$data['delivery'] = ($this->cart->delivery()) ? $this->currency->format($this->cart->delivery()) : FALSE;
			}
			
			if ($this->session->userdata('coupon_code')) {
				$data['coupon_code'] = $this->session->userdata('coupon_code');
				$error = $this->validateCoupon($this->session->userdata('coupon_code'), '');
				$data['cart_alert'] = '<p class="error">'. $error .'</p>';
			} else {
				$data['coupon_code'] = '';
			}
			
			if ($this->cart->coupon()) {
				$data['sub_total'] 	= $this->currency->format($this->cart->total());
				$data['coupon'] = $this->currency->format($this->cart->coupon());
			}
			
			$data['order_total'] = $this->currency->format($this->cart->order_total());
		}

		// pass array $data and load view files
		$this->load->view('main/cart_module', $data);
	}		

	public function add() {																		// add() method to add item to cart
		$json = array();
		$menu_data = array();
		$menu_option_data = array();
		$error = 0;
		
		if ( ! $this->input->is_ajax_request()) {
			$error = 1;
		}
		
		$quantity = 1;				
		$update_cart = FALSE;
		if ($this->input->post('menu_id') OR $this->input->post('menu_options')) {
			$menu_id 			= $this->input->post('menu_id');									// retrieve $_POST menu_id value
			$menu_option_id 	= $this->input->post('menu_options');								// retrieve $_POST menu_options value
			$menu_data 			= $this->Cart_model->getMenu($menu_id);								// get menu data based on menu id from getMenu method in Menus model
			$menu_option_data 	= $this->Cart_model->getMenuOption($menu_option_id);			// get menu option data based on menu option id from getMenuOption method in Menus model
	
			if ($menu_data['stock_qty'] <= 0) {												// checks if stock quantity is less than or equal to zero
				$error = 6;
			}
		} else {
			$error = 2;
		}
		
		if ( ! $this->location->local() AND $this->config->item('location_order') === '1') { 														// if local restaurant is not selected
			$error = 3;
		} else if ( ! $this->location->isOpened()) { 											// else if local restaurant is not open
			$error = 4;
		}
		
		switch ($error) {
		case 1:
			$json['error'] = 'Error occurred, please check and try again.';		
			break;
		case 2:
			$json['error'] = 'Please select a menu to add!';
			break;
		case 3:
			$json['error'] = 'Please select your local restaurant';								// display error and redirect
			break;
		case 4:
			$json['error'] = 'Sorry, you can\'t place an order now, we are currently closed,<br /> please come back later during our opening times.';
			break;
		case 5:
			$json['error'] = 'Selected quantity is below the menu\'s minimum order quantity';							// display error		
			break;
		case 6:
			$json['error'] = 'Menu is currently out of stock';							// display error		
			break;
		case 0:
			if ( ! $json) {															// checks if menu option data if available
				$menu_options = array();
				if ($menu_option_data) {															// checks if menu option data if available
					$menu_options = array('option_id' => $menu_option_data['option_id'], 'name' => $menu_option_data['option_name'], 'price' => $menu_option_data['option_price']);
					$menu_price = $menu_option_data['option_price'] + $menu_data['menu_price'];
				} else if ($menu_data['is_special'] === '1') {											// else if special_price is empty			
					$menu_price = $menu_data['special_price'];			
				} else {
					$menu_price = $menu_data['menu_price'];			
				}
	
				if ($this->cart->contents()) {
					foreach ($this->cart->contents() as $cart_item) {								// loop through items in cart
						$cart_option_id = (!empty($cart_item['options']['option_id'])) ? $cart_item['options']['option_id'] : '';					
						$menu_option_id = ($menu_option_id === 'undefined') ? '' : $menu_option_id;					
						if ($cart_item['id'] === $menu_id AND $cart_option_id === $menu_option_id) {
							$row_id = $cart_item['rowid'];
							$quantity = $cart_item['qty'] + 1;
							$update_cart = TRUE;
						}
					}
				}

				if ($update_cart === TRUE) {
					$this->cart->update(array('rowid' => $row_id, 'qty' => $quantity));										// pass the cart_data array to add item to cart, if successful				
					$json['success'] = 'Success: Cart Updated Successfully.';						// display success message
				} else {
					$cart_data = array(																// create an array of item to be added to cart with id, name, qty, price and options as keys
						'id'     		=> $menu_id,
						'name'   		=> $menu_data['menu_name'],
						'qty'    		=> ($quantity) ? $quantity : $menu_data['minimum_qty'],
						'price'  		=> $this->cart->format_number($menu_price),
						'options' 		=> $menu_options
					);
		
					$added_data = $this->cart->insert($cart_data);
					$json['success'] = 'Success: Menu as been added to cart.';					// display success message
				}
			}
			break;
		default:
			$json['redirect'] = site_url('main/menus');					// display success message
		}

		$this->output->set_output(json_encode($json));											// encode the json array and set final out to be sent to jQuery AJAX
	}
	
	public function update() {																	// update() method to update cart
		$json = array();
		
		// Update Cart
		if (!$json) {

			$menu_id = $this->input->post('menu_id');											// store $_POST menu_id value into variable
			$row_id = $this->input->post('row_id');												// store $_POST row_id value into variable
			$quantity = $this->input->post('quantity');											// store $_POST quantity value into variable
			
			$menu_data = $this->Cart_model->getMenu($menu_id);									// get menu data based on menu id from getMenu method in Menus model
			
			$update_data = array (																// create an array of item to be updated in cart with rowid, and qty as keys
				'rowid' => $row_id,
				'qty'   => $quantity
			);
					
			if ($this->cart->update($update_data)) {											// pass the cart_data array to add item to cart, if successful
			
				$json['success'] = 'Success: Cart Updated Successfully.';						// display success message
			
			} else {																			// else redirect to menus page
				$json['redirect'] = site_url('main/menus');
			}
		}

		$this->output->set_output(json_encode($json));											// encode the json array and set final out to be sent to jQuery AJAX
	}	

	public function coupon() {																	// update() method to update cart
		$json = array();
		
		if (!$json) {
			$sess_code = $this->session->userdata('coupon_code');	
			$code = $this->input->post('code');
			$coupon = $this->Coupons_model->checkCoupon($code);

			if ($this->input->get('remove')) {
				$this->cart->set_coupon('', '');
				$this->session->unset_userdata('coupon_code');			
				$json['success'] = 'Coupon removed successfully.';
			} 
			
			if ($this->input->post('code')) { 
				if ($error = $this->validateCoupon('', $coupon)) {
					$json['error'] = $error;
				} else {
					$this->cart->set_coupon($coupon['type'], $coupon['discount']);
					$json['success'] = 'Coupon Applied Successfully.';									// display success message
				}
			} else {
				$json['error'] = 'Please enter a valid coupon.';
			}
		}
							
		$this->output->set_output(json_encode($json));											// encode the json array and set final out to be sent to jQuery AJAX
	}	

	public function validateCoupon($code = '', $coupon = '') {
		$error = '';
		
		if ($code !== '') {
			$coupon = $this->Coupons_model->checkCoupon($code);
		}
					
		if (!$coupon) {
			$error = 'The coupon code you entered is either invalid or expired.';								// display error message		
		} else {
			if ($coupon['min_total'] > $this->cart->total()) {
				$error = 'Coupon can not be applied to orders below '. $this->currency->format($coupon['min_total']);
			}
			
			$used = $this->Coupons_model->checkCouponHistory($coupon['coupon_id']);
			
			if (!empty($coupon['redemptions']) AND ($coupon['redemptions']) <= ($used)) { 
				$error = 'We have reached the maximum number of redemptions for the coupon entered.';								// display error message		
			}

			if ($this->customer->getId()) {
				$customer_used = $this->Coupons_model->checkCustomerCouponHistory($coupon['coupon_id'], $this->customer->getId());
				
				if (!empty($coupon['customer_redemptions']) AND ($coupon['customer_redemptions']) <= ($customer_used)) { 
					$error = 'You have reached the maximum number of redemptions for the coupon entered.';								// display error message		
				}
			}
		}
		
		if ($error) {
			$this->cart->set_coupon('', '');
			return $error;
		} else {
			$this->session->set_userdata('coupon_code', $coupon['code']);
			return FALSE;
		}
	}
}

/* End of file cart_module.php */
/* Location: ./application/extensions/main/controllers/cart_module.php */