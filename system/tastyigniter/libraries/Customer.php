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
 * Customer Class
 *
 * @category       Libraries
 * @package        TastyIgniter\Libraries\Customer.php
 * @link           http://docs.tastyigniter.com
 */
class Customer {

	private $customer_id;
	private $firstname;
	private $lastname;
	private $email;
	private $telephone;
	private $address_id;
	private $security_question_id;
	private $security_answer;
	private $customer_group_id;

	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->database();
        $this->CI->load->driver('session');
		$this->CI->load->library('user_agent');
		$this->CI->load->library('cart');

		$this->initialize();
	}

	public function initialize() {
		$cust_info = $this->CI->session->userdata('cust_info');

		if (isset($cust_info['customer_id']) AND  isset($cust_info['email'])) {
			$this->CI->db->from('customers');
			$this->CI->db->where('customer_id', $cust_info['customer_id']);
			$this->CI->db->where('email', $cust_info['email']);
			$query = $this->CI->db->get();
			$result = $query->row_array();

			if ($query->num_rows() === 1) {
				$this->customer_id 			= $result['customer_id'];
				$this->firstname 			= $result['first_name'];
				$this->lastname 			= $result['last_name'];
				$this->email 				= strtolower($result['email']);
				$this->telephone			= $result['telephone'];
				$this->address_id 			= $result['address_id'];
				$this->security_question_id = $result['security_question_id'];
				$this->security_answer 		= $result['security_answer'];
				$this->customer_group_id 	= $result['customer_group_id'];

				$this->updateCart();
			} else {
				$this->logout();
			}
		}
	}

	public function login($email, $password, $override_login = FALSE) {

		$this->CI->db->from('customers');
		$this->CI->db->where('email', strtolower($email));

		if ($override_login === FALSE) {
			$this->CI->db->where('password', 'SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1("' . $password . '")))))', FALSE);
		}

		$this->CI->db->where('status', '1');

		$query = $this->CI->db->get();
		if ($query->num_rows() === 1) {
			$result = $query->row_array();

			if (!empty($result['cart']) AND is_string($result['cart'])) {
				$cart_contents = unserialize($result['cart']);

				foreach ($cart_contents as $rowid => $item) {
					if (!empty($item['rowid']) AND $rowid === $item['rowid']) {
						$this->CI->cart->insert($item);
					}
				}
			}

			$this->CI->session->set_userdata('cust_info', array(
				'customer_id' 	=> $result['customer_id'],
				'email'			=> $result['email']
			));

			$this->customer_id          = $result['customer_id'];
            $this->firstname            = $result['first_name'];
            $this->lastname             = $result['last_name'];
			$this->email 				= strtolower($result['email']);
			$this->telephone			= $result['telephone'];
			$this->address_id 			= $result['address_id'];
			$this->security_question_id = $result['security_question_id'];
			$this->security_answer 		= $result['security_answer'];
			$this->customer_group_id 	= $result['customer_group_id'];

			$this->CI->db->set('ip_address', $this->CI->input->ip_address());
			$this->CI->db->where('customer_id', $result['customer_id']);
			$this->CI->db->update('customers');

	  		return TRUE;
		} else {
      		return FALSE;
		}
	}

  	public function logout() {
		$this->CI->session->unset_userdata('cust_info');

		$this->customer_id = '0';
		$this->firstname = '';
		$this->lastname = '';
		$this->email = '';
		$this->telephone = '';
		$this->address_id = '';
		$this->security_question_id = '';
		$this->security_answer = '';
		$this->customer_group_id = '';
    }

  	public function isLogged() {
	    return $this->customer_id;
	}

  	public function getId() {
		return $this->customer_id;
  	}

  	public function getName() {
		return $this->firstname . ' ' . $this->lastname;
  	}

  	public function getFirstName() {
		return $this->firstname;
  	}

  	public function getLastName() {
		return $this->lastname;
  	}

  	public function getEmail() {
		return strtolower($this->email);
  	}

  	public function checkPassword($password) {
		$this->CI->db->select('*');
		$this->CI->db->from('customers');
		$this->CI->db->where('email', $this->email);
		$this->CI->db->where('password', 'SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1("' . $password . '")))))', FALSE);

		$query = $this->CI->db->get();
		if ($query->num_rows() === 1) {
			return TRUE;
		} else {
			return FAlSE;
		}
  	}

  	public function getTelephone() {
		return $this->telephone;
  	}

  	public function getAddressId() {
	    return $this->address_id;
	}

  	public function getSecurityQuestionId() {
	    return $this->security_question_id;
	}

  	public function getSecurityAnswer() {
	    return $this->security_answer;
	}

  	public function getGroupId() {
	    return $this->customer_group_id;
	}

	public function updateCart() {
		$this->CI->db->set('cart', ($cart_contents = $this->CI->cart->contents()) ? serialize($cart_contents) : '');
		$this->CI->db->where('customer_id', $this->customer_id);
		$this->CI->db->where('email', $this->email);
		$this->CI->db->update('customers');
	}
}

// END Customer Class

/* End of file Customer.php */
/* Location: ./system/tastyigniter/libraries/Customer.php */