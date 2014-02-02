<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cart extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Foods_model');
		$this->load->library('cart');
		$this->load->library('currency');
	}

	public function index() {
		//check if file exists in views
		if ( !file_exists('application/views/main/cart.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		}
			
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else {
			$data['alert'] = '';
		}

		$data['heading'] = 'Shopping Cart';
		$data['text_no_cart_items'] = 'There are no foods added in your cart.';

		$data['quantities'] = $this->Foods_model->getQuantities();


     	$data['cart_items'] = array();

    	if ($this->cart->contents()) {

      		foreach ($this->cart->contents() as $cart_results) {
      			      		
				$data['cart_items'][] = array(
					'key'				=> $cart_results['rowid'],
					'food_id' 			=> $cart_results['id'],
					'food_name' 		=> $cart_results['name'],			
					'food_price' 		=> $this->currency->symbol() . $cart_results['price'],
					'quantity_value' 	=> $cart_results['qty'],
					'sub_total' 		=> $this->currency->symbol() . $this->cart->format_number($cart_results['subtotal'])
				);
			}
			
			$data['total'] = $this->currency->symbol() . $this->cart->format_number($this->cart->total());
		}
	
		$data['continue'] = $this->config->site_url('foods');
		$data['checkout'] = $this->config->site_url('checkout');

		$this->load->view('main/header', $data);
		$this->load->view('main/cart', $data);
		$this->load->view('main/footer');
	}		

	public function add() {
		$json = array();
				
		//set food_id else 0
		if ($this->input->post('food_id')) {
			$food_id = $this->input->post('food_id');
		} else {
			$food_id = 0;
		}

		
		//selecting food details based on food_id
		$food_data = $this->Foods_model->getFood($food_id);
		
		if ($food_data) {

			if ($this->input->post('food_options')) {
				$option_id = $this->input->post('food_options');
			}
	
			$quantity = '1';

			$option_data = $this->Foods_model->getFoodOptions($option_id);
											
			//adding data to cart
			if ($option_data) {
					$food_options = array('With' => $option_data['option_name'] . ': ' . $this->currency->symbol() . $option_data['option_price']);
					$food_price = $option_data['option_price']+$food_data['food_price'];
			} else {
					$food_price = $food_data['food_price'];
					$food_options = array();
			}

			if (!$json) {
				
				$cart_data = array(
        			'id'     		=> $food_id,
               		'name'   		=> $food_data['food_name'],
               		'qty'    		=> $quantity,
               		'price'  		=> $this->cart->format_number($food_price),
	                'options' 		=> $food_options
        		);
				
				if (($added_data = $this->cart->insert($cart_data))) {
					$json['success'] = 'Success: Food as been added to cart.';
				} else {
					$json['redirect'] = $this->config->site_url('foods');
				}
			}	
		}
		
		$this->output->set_output(json_encode($json));
	}
	
	public function update() {
		$json = array();
		
		// Update Cart
		if (!$json) {

			$row_id = $this->input->post('row_id');
			$quantity = $this->input->post('quantity');
			
				//send array to update()
					$update_data = array (
            		   	'rowid' => $row_id,
        	    		'qty'   => $quantity
    	        );
					
			if ($this->cart->update($update_data)) {
				$json['success'] = 'Success: Cart Updated Successfully!.';
			} else {
				$json['redirect'] = $this->config->site_url('foods');
			}
		}

		$this->output->set_output(json_encode($json));
	}	
}