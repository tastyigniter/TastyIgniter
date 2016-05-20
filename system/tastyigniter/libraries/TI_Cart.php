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
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * TastyIgniter Shopping Cart Class
 *
 * @category       Libraries
 * @package        TastyIgniter\Libraries\TI_Cart.php
 * @link           http://docs.tastyigniter.com
 */
class TI_Cart extends CI_Cart {

	/**
	 * These are the regular expression rules that we use to validate the product ID and product name
	 * alpha-numeric, dashes, underscores, colons or periods
	 *
	 * @var string
	 */
	public $product_name_rules	= '^\/';

	protected $_cart_totals = array();

	public function __construct($params = array()) {
		// Set the super object to a local variable for use later
		$this->CI =& get_instance();

		// Are any config settings being passed manually?  If so, set them
		$config = is_array($params) ? $params : array();

		// Load the Sessions class
		$this->CI->load->driver('session', $config);

		// Grab the shopping cart array from the session table
		$this->_cart_contents = $this->CI->session->userdata('cart_contents');
		if ($this->_cart_contents === NULL)
		{
			// No cart exists so we'll set some base values
			$this->_cart_contents = array('cart_total' => 0, 'total_items' => 0, 'order_total' => 0, 'totals' => array());
		}

		$this->_cart_totals = isset($this->_cart_contents['totals']) ? $this->_cart_contents['totals'] : array();

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

		$this->_cart_totals['delivery'] = NULL;

		if ($charge > 0) {
			$this->_cart_totals['delivery']['priority'] = '2';
			$this->_cart_totals['delivery']['amount'] = $charge;
			$this->_cart_totals['delivery']['action'] = 'add';
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
			$this->_cart_totals['coupon']['priority'] = '1';
			$this->_cart_totals['coupon']['amount'] = $coupon['discount'];
			$this->_cart_totals['coupon']['action'] = 'subtract';
			$this->_cart_totals['coupon']['code'] = $coupon['code'];
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
		$coupon = $this->coupon();

		if ($coupon_code !== '' AND isset($coupon['code']) AND $coupon['code'] === $coupon_code) {
			unset($this->_cart_totals['coupon']);
			$this->_save_cart();
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Calculate tax if enabled
	 *
	 * @return float
	 */
	public function calculate_tax() {
		$this->_cart_totals['taxes'] = array();

		// Calculate taxes if enabled
		if ($this->CI->config->item('tax_mode') === '1' AND $this->CI->config->item('tax_percentage')) {
			$tax_percent = $this->CI->config->item('tax_percentage') ? $this->CI->config->item('tax_percentage') : 0;

			$total = $this->_cart_contents['order_total'];

			// Remove delivery charge from total if its not taxable
			if (isset($this->_cart_totals['delivery']['amount']) AND $this->CI->config->item('tax_delivery_charge') !== '1') {
				$total -= $this->_cart_totals['delivery']['amount'];
			}

			// If apply taxes on menu price, else
			if ($this->CI->config->item('tax_menu_price') === '1') {
				$tax_title = ' (' . $tax_percent . '%)';
				$ignore = 'add';

				// calculate tax amount based on percentage
				$tax_amount = ($tax_percent / 100 * $total);
			} else {
				$tax_title = ' (' . $tax_percent . '% included)';
				$ignore = 'ignore';

				// calculate tax amount based on percentage
				$tax_amount = $total - ($total / (1 + $tax_percent / 100));
			}

			$this->_cart_totals['taxes']['priority'] = '3';
			$this->_cart_totals['taxes']['amount'] = $tax_amount;
			$this->_cart_totals['taxes']['action'] = $ignore;
			$this->_cart_totals['taxes']['tax'] = $tax_title;
			$this->_cart_totals['taxes']['percent'] = $tax_percent;

			$this->_save_cart();
		}

		return $this->_cart_totals['taxes'];
	}

	// --------------------------------------------------------------------

	/**
	 * Add additional cart total
	 *
	 * This function adds new total to cart totals.
	 *
	 * @access    public
	 * @param array $total
	 *
	 * @return int
	 */
	public function add_total($total = array()) {
		if ( ! is_array($total) OR ! isset($total['amount'], $total['title'], $total['action'], $total['priority'])) {
			log_message('error', 'The cart total array must contain a total name, title, amount, action, and priority.');
			return FALSE;
		}

		if ( ! isset($total['name']) OR ! preg_match('/^[a-z0-9_-]+$/i', $total['name'])) {
			log_message('error', 'An invalid name was submitted as the total name: The name can only contain alpha-numeric characters, dashes, underscores');
			return FALSE;
		}

		$total['amount'] = (float) $total['amount'];
		$total['title'] = htmlspecialchars_decode($total['title']);
		$this->_cart_totals[$total['name']] = $total;

		$this->_save_cart();

		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Remove Total
	 *
	 * This function removes total from totals.
	 *
	 * @access    public
	 * @param string $total_name
	 * @return bool
	 */
	public function remove_total($total_name = '') {
		if ($total_name !== '' AND isset($this->_cart_totals[$total_name])) {
			unset($this->_cart_totals[$total_name]);
			$this->_save_cart();
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

		$this->_cart_contents['totals'] = sort_array($this->_cart_totals);
		foreach ($this->_cart_contents['totals'] as $key => $val) {
			if ( ! is_array($val) OR ! isset($val['amount'], $val['action'], $val['priority'])) {
				continue;
			}

			if ($val['action'] === 'add') {
				$total += $val['amount'];
			} else if ($val['action'] === 'subtract') {
				$total -= $val['amount'];
			}
		}

		$this->_cart_contents['order_total'] = $total;

		// Is our cart empty? If so we delete it from the session
		if (count($this->_cart_contents) <= 4) {
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
		unset($cart['totals']);

		// Backward compatibility
		if (isset($cart['delivery'])) unset($cart['delivery']);
		if (isset($cart['coupon'])) unset($cart['coupon']);
		if (isset($cart['taxes'])) unset($cart['taxes']);

		return $cart;
	}

	// --------------------------------------------------------------------

	/**
	 * Get Cart Totals
	 *
	 * Returns the cart totals array
	 *
	 * @access	public
	 * @return	integer
	 */
	public function totals() {
		$cart_totals = $this->_cart_totals;
		$cart_totals['cart_total']['amount'] = $this->total();
		$cart_totals['order_total']['amount'] = $this->order_total();

		return $cart_totals;
	}

	// --------------------------------------------------------------------

	/**
	 * Get cart total
	 *
	 * Returns the total from the cart totals array
	 *
	 * @param	string	$total_name
	 * @return	array
	 */
	public function get_total($total_name = '') {
		$total = array();

		if ($total_name !== '' AND isset($this->_cart_totals[$total_name])) {
			$total = $this->_cart_totals[$total_name];
		}

		return $total;
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
		return isset($this->_cart_totals['delivery']['amount']) ? $this->_cart_totals['delivery']['amount'] : 0;
	}

	// --------------------------------------------------------------------

	/**
	 * Coupon Amount *** TASTYIGNITER
	 *
	 * Returns coupon
	 *
	 * @access	public
	 * @return	integer
	 */
	public function coupon() {
		return !empty($this->_cart_totals['coupon']) ? $this->_cart_totals['coupon'] : array();
	}

	// --------------------------------------------------------------------

	/**
	 * Coupon Code *** TASTYIGNITER
	 *
	 * Returns the coupon code
	 *
	 * @access	public
	 * @return	integer
	 */
	public function coupon_code() {
		$coupon = $this->coupon();
		return !empty($coupon['code']) ? $coupon['code'] : NULL;
	}

	// --------------------------------------------------------------------

	/**
	 * Coupon Discount *** TASTYIGNITER
	 *
	 * Returns coupon discount
	 *
	 * @access	public
	 * @return	integer
	 */
	public function coupon_discount() {
		$coupon = $this->coupon();
		return (!empty($coupon['amount'])) ? $coupon['amount'] : NULL;
	}

	/**
	 * Get Taxes
	 *
	 * Returns taxes array
	 *
	 * @access	public
	 * @return	integer
	 */
	public function tax_array() {
		return !empty($this->_cart_totals['taxes']) ? $this->_cart_totals['taxes'] : array();
	}

	// --------------------------------------------------------------------

	/**
	 * Get Taxes Title
	 *
	 * Returns the taxes title
	 *
	 * @access	public
	 * @return	integer
	 */
	public function tax_title() {
		$taxes = $this->tax_array();
		return !empty($taxes['title']) ? $taxes['title'] : NULL;
	}

	// --------------------------------------------------------------------

	/**
	 * Get Taxes Percentage
	 *
	 * Returns the taxes percentage
	 *
	 * @access	public
	 * @return	integer
	 */
	public function tax_percent() {
		$taxes = $this->tax_array();
		return !empty($taxes['percent']) ? $taxes['percent'] : NULL;
	}

	// --------------------------------------------------------------------

	/**
	 * Get Taxes Amount
	 *
	 * Returns the taxes amount
	 *
	 * @access	public
	 * @return	integer
	 */
	public function tax_amount() {
		$taxes = $this->tax_array();
		return !empty($taxes['amount']) ? $taxes['amount'] : NULL;
	}

	// --------------------------------------------------------------------

	public function product_options_string($row_id, $split = '<br />') {
		$string = '';

		$this->CI->load->library('currency');

		foreach ($this->product_options($row_id) as $option_id => $options) {
			foreach ($options as $option) {
				$string .= $this->CI->lang->line('text_plus') . $option['value_name'] . sprintf($this->CI->lang->line('text_option_price'), $this->CI->currency->format($option['value_price'])) . $split;
			}
		}

		return trim($string, $split);
	}

	public function product_options_ids($row_id) {
		$ids = array();

		foreach ($this->product_options($row_id) as $option_id => $options) {
			foreach ($options as $option) {
				$ids[$option_id][] = $option['value_id'];
			}
		}

		return $ids;
	}

	/**
	 * Destroy the cart
	 *
	 * Empties the cart and kills the session
	 *
	 * @return	void
	 */
	public function destroy()
	{
		$this->_cart_contents = array('cart_total' => 0, 'total_items' => 0, 'order_total' => 0, 'totals' => array());
		$this->CI->session->unset_userdata('cart_contents');
	}
}

// END Cart Class

/* End of file Cart.php */
/* Location: ./system/tastyigniter/libraries/Cart.php */