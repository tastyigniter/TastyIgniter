<?php  if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Shopping Cart Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Shopping Cart
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/cart.html
 */
class TI_Cart extends CI_Cart {

	// Private variables.  Do not change!
	var $CI;
	var $_cart_contents	= array();


	public function __construct($params = array()) {
		parent::__construct();
		// Set the super object to a local variable for use later
		$this->CI =& get_instance();

		// Are any config settings being passed manually?  If so, set them
		$config = array();
		if (count($params) > 0) {
			foreach ($params as $key => $val) {
				$config[$key] = $val;
			}
		}

		// Load the Sessions class
		//$this->CI->load->library('session', $config);

		// Grab the shopping cart array from the session table, if it exists
		$this->_cart_contents = $this->CI->session->userdata('cart_contents');
		if ($this->_cart_contents === NULL) {
			// No cart exists so we'll set some base values
			$this->_cart_contents = array('order_total' => 0, 'delivery' => 0, 'coupon' => 0);
		}

		if (!isset($this->_cart_contents['delivery'])) {
			$this->_cart_contents['delivery'] = 0;
		}

		if (!isset($this->_cart_contents['coupon'])) {
			$this->_cart_contents['coupon'] = 0;
		}

		log_message('debug', "Cart Class Initialized");
	}

	// --------------------------------------------------------------------


	/**
	 * Set Delivery Charge *** TASTYIGNITER
	 *
	 * This function permits calculates the delivery charge.
	 *
	 * @access	private
	 * @return	bool
	 */
	public function set_delivery($charge = 0) {
		if (is_numeric($charge) OR $charge <= 0) {
			$save_cart = FALSE;
		}
		
		$this->_cart_contents['delivery'] = 0;

		if ($charge > 0) {
			$this->_cart_contents['delivery'] = $charge;
			$save_cart = TRUE;
		}
		
		$this->_save_cart();
		if ($save_cart === TRUE) {
			return TRUE;
		}
		
		return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Set Coupon *** TASTYIGNITER
	 *
	 * This function permits calculates the coupon coupon from code.
	 *
	 * @access	private
	 * @return	bool
	 */
	public function set_coupon($type = '', $amount = 0) {
		if ($type !== 'P' OR $type !== 'F') {
			$save_cart = FALSE;
		}
		
		if ( ! is_numeric($amount) AND $amount <= 0) {
			$save_cart = FALSE;
		}

		if ($type === 'P' AND $amount > 0) {
			$amount = ($amount / 100) * $this->_cart_contents['cart_total'];
		}

		$this->_cart_contents['coupon'] = 0;

		if ($amount > 0) {
			$this->_cart_contents['coupon'] = $amount;
			$save_cart = TRUE;
		}

		$this->_save_cart();
		if ($save_cart === TRUE) {
			return TRUE;
		}
		
		return FALSE;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Save the cart array to the session DB
	 *
	 * @access	private
	 * @return	bool
	 */
	protected function _save_cart() {
		// Let's add up the individual prices and set the cart sub-total
		$this->_cart_contents['total_items'] = $this->_cart_contents['cart_total'] = $this->_cart_contents['order_total'] = 0;
		foreach ($this->_cart_contents as $key => $val) {
			// We make sure the array contains the proper indexes
			if ( ! is_array($val) OR ! isset($val['price'], $val['qty'])) {
				continue;
			}

			$this->_cart_contents['cart_total'] += ($val['price'] * $val['qty']);
			$this->_cart_contents['total_items'] += $val['qty'];
			$this->_cart_contents[$key]['subtotal'] = ($this->_cart_contents[$key]['price'] * $this->_cart_contents[$key]['qty']);
		}

		$total = $this->_cart_contents['cart_total'];

		$total = (isset($this->_cart_contents['coupon'])) ? $total - $this->_cart_contents['coupon'] : $total;
		$total = (isset($this->_cart_contents['delivery'])) ? $total + $this->_cart_contents['delivery'] : $total;
		
		$this->_cart_contents['order_total'] = $total;

		// Is our cart empty? If so we delete it from the session
		if (count($this->_cart_contents) <= 2) {
			$this->CI->session->unset_userdata('cart_contents');

			// Nothing more to do... coffee time!
			return FALSE;
		}

		// If we made it this far it means that our cart has data.
		// Let's pass it to the Session class so it can be stored
		$this->CI->session->set_userdata(array('cart_contents' => $this->_cart_contents));

		// Woot!
		return TRUE;
	}

	// --------------------------------------------------------------------


	/**
	 * Cart Contents *** TASTYIGNITER
	 *
	 * @access	public
	 * @return	integer
	 */
	public function contents($newest_first = FALSE) {
		// do we want the newest first?
		$cart = ($newest_first) ? array_reverse($this->_cart_contents) : $this->_cart_contents;

		// Remove these so they don't create a problem when showing the cart table
		unset($cart['total_items']);
		unset($cart['cart_total']);
		unset($cart['order_total']);
		unset($cart['delivery']);
		unset($cart['coupon']);

		return $cart;
	}

	// --------------------------------------------------------------------


	/**
	 * Get cart item by id
	 *
	 * Returns the details of a specific item in the cart
	 *
	 * @param	string	$id
	 * @return	array
	 */
	public function get_item_by_id($id) {
		$cart = $this->contents();
		
		$cart_item = array();
		foreach ($cart as $item) {
			if ($item['id'] === $id) {
				$cart_item = $item;
			}
		}

		return $cart_item;
	}

	// --------------------------------------------------------------------

	/**
	 * Order Total *** TASTYIGNITER
	 *
	 * @access	public
	 * @return	integer
	 */
	public function order_total() {
		return $this->_cart_contents['order_total'];
	}
	
	// --------------------------------------------------------------------

	/**
	 * Delivery Charge *** TASTYIGNITER
	 *
	 * Returns the delivery charge amount
	 *
	 * @access	public
	 * @return	integer
	 */
	public function delivery() {
		return $this->_cart_contents['delivery'];
	}

	// --------------------------------------------------------------------

	/**
	 * Coupon Amount *** TASTYIGNITER
	 *
	 * Returns coupon amount
	 *
	 * @access	public
	 * @return	integer
	 */
	public function coupon() {
		return $this->_cart_contents['coupon'];
	}
}

// END Cart Class

/* End of file Cart.php */
/* Location: ./application/libraries/Cart.php */