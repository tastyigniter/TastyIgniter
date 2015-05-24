<?php  if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * TI Shopping Cart Extension Class
 */
class TI_Cart extends CI_Cart {

    private $coupon = array('code' => '', 'discount' => '');

	public function __construct($params = array()) {
		parent::__construct();
		$this->CI =& get_instance();

		if (!isset($this->_cart_contents['order_total'])) {
			$this->_cart_contents['order_total'] = 0;
		}

		if (!isset($this->_cart_contents['delivery'])) {
			$this->_cart_contents['delivery'] = 0;
		}

		if (!isset($this->_cart_contents['coupon'])) {
			$this->_cart_contents['coupon'] = $this->coupon;
		}

		log_message('info', "Cart Class Initialized");
	}

	// --------------------------------------------------------------------


    /**
     * Set Delivery Charge *** TASTYIGNITER
     *
     * This function permits calculates the delivery charge.
     *
     * @access    private
     * @param int $charge
     * @return bool
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
     * Add Coupon *** TASTYIGNITER
     *
     * This function permits calculates the coupon coupon from code.
     *
     * @access    private
     * @param array $coupon
     * @return bool
     */
	public function add_coupon($coupon = array()) {
		$save_cart = FALSE;

        if (!isset($coupon['type'])) {
            $coupon['type'] = 'F';
        }

        if ($coupon['type'] === 'P' AND is_numeric($coupon['discount']) AND $coupon['discount'] > 0) {
            $coupon['discount'] = ($coupon['discount'] / 100) * $this->_cart_contents['cart_total'];
        }

        if ($coupon['discount'] > 0) {
			$this->_cart_contents['coupon'] = array('code' => $coupon['code'], 'discount' => $coupon['discount']); //$coupon['discount'];
			$save_cart = TRUE;
		}

		if ($save_cart === TRUE) {
			$this->_save_cart();
		}

		return $save_cart;
	}

	// --------------------------------------------------------------------

    /**
     * Remove Coupon *** TASTYIGNITER
     *
     * This function removes coupon from cart.
     *
     * @access    private
     * @param string $coupon_code
     * @return bool
     */
	public function remove_coupon($coupon_code = '') {
		if (isset($this->_cart_contents['coupon'])) {
			if ($coupon_code !== '' AND $this->_cart_contents['coupon']['code'] === $coupon_code) {
				$this->_cart_contents['coupon'] = $this->coupon;
				$this->_save_cart();
			}
		}
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

		$total = (isset($this->_cart_contents['coupon']['discount'])) ? $total - $this->_cart_contents['coupon']['discount'] : $total;
		$total = (isset($this->_cart_contents['delivery'])) ? $total + $this->_cart_contents['delivery'] : $total;

		$this->_cart_contents['order_total'] = $total;

		// Is our cart empty? If so we delete it from the session
		if (count($this->_cart_contents) <= 5) {
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
	 * Total Items
	 *
	 * Returns the total item count
	 *
	 * @return	int
	 */
	public function total_items()
	{
		return isset($this->_cart_contents['total_items']) ? $this->_cart_contents['total_items'] : 0;
	}

	// --------------------------------------------------------------------

    /**
     * Cart Contents *** TASTYIGNITER
     *
     * @access    public
     * @param bool $newest_first
     * @return int
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
		return is_array($this->_cart_contents['coupon']) ? $this->_cart_contents['coupon'] : $this->coupon;
	}
}

// END Cart Class

/* End of file Cart.php */
/* Location: ./system/tastyigniter/libraries/Cart.php */