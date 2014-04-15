<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer {
	private $customer_id;
	private $firstname;
	private $lastname;
	private $email;
	private $password;
	private $telephone;
	private $address_id;
	private $security_question_id;
	private $security_answer;
	private $cart_contents;
	private $currency_symbol;
	
	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->database();
		
		if ( ! $this->CI->session->userdata('customer_id')) { 
			$this->logout();
		} else {
			$this->CI->db->from('customers');	
			$this->CI->db->where('customer_id', $this->CI->session->userdata('customer_id'));
			$this->CI->db->where('email', $this->CI->session->userdata('customer_email'));
			$query = $this->CI->db->get();
			$result = $query->row_array();

			if ($query->num_rows() === 1) {
				$this->CI->customer_id 			= $result['customer_id'];
				$this->CI->firstname 			= $result['first_name'];
				$this->CI->lastname 			= $result['last_name'];
				$this->CI->email 				= $result['email'];
				$this->CI->password 			= $result['password'];
				$this->CI->telephone			= $result['telephone'];
				$this->CI->address_id 			= $result['address_id'];
				$this->CI->security_question_id = $result['security_question_id'];
				$this->CI->security_answer 		= $result['security_answer'];

				$this->CI->db->from('customers_activity');	
				$this->CI->db->where('customer_id', $result['customer_id']);
				$this->CI->db->where('ip_address', $this->CI->input->ip_address());
				$query = $this->CI->db->get();

				if ($query->num_rows() < 1) {
					$this->CI->load->library('user_agent');	    
					$access_type = ($this->CI->agent->mobile()) ? 'mobile' : 'browser';
					$ip_json = @file_get_contents('http://api.hostip.info/get_json.php?ip='. $this->CI->input->ip_address());
					$ip_data = json_decode($ip_json);
					$this->CI->db->set('customer_id', $result['customer_id']);
					$this->CI->db->set('access_type', $access_type);
					$this->CI->db->set('browser', $this->CI->agent->browser());
					$this->CI->db->set('ip_address', $this->CI->input->ip_address());
					$this->CI->db->set('country_name', trim($ip_data->country_name, '()'));
					$this->CI->db->set('date_added', mdate('%Y-%m-%d %H:%i:%s', time()));
					$this->CI->db->insert('customers_activity');
				}
			} else {
				$this->logout();
			}
		}
	}

	public function login($email, $password) {

		$this->CI->db->from('customers');	
		$this->CI->db->where('email', strtolower($email));
		$this->CI->db->where('password', 'SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1("' . $password . '")))))', FALSE);
		$this->CI->db->where('status', '1');
		
		$query = $this->CI->db->get();
		if ($query->num_rows() === 1) {
			$result = $query->row_array();
			
			$this->CI->session->set_userdata('customer_id', $result['customer_id']);
			$this->CI->session->set_userdata('customer_email', $result['email']);
			
			$this->CI->customer_id = $result['customer_id'];
			$this->CI->email = $result['email'];

			$this->CI->db->set('ip_address', $this->CI->input->ip_address());
			$this->CI->db->where('customer_id', $result['customer_id']);
			$this->CI->db->update('customers');

	  		return TRUE;
		
		} else {
      		return FALSE;
		}
	}

  	public function logout() {		
		$this->CI->session->unset_userdata('customer_id');
		$this->CI->session->unset_userdata('customer_email');

		$this->CI->customer_id = '';
		$this->CI->firstname = '';
		$this->CI->lastname = '';
		$this->CI->email = '';
		$this->CI->telephone = '';
		$this->CI->address_id = '';
		$this->CI->security_question_id = '';
		$this->CI->security_answer = '';
		//$this->CI->cart_contents = '';

	}

  	public function isLogged() {
	    return $this->CI->customer_id;
	}

  	public function getId() {
		return $this->CI->customer_id;
  	}
  
  	public function getFirstName() {
		return $this->CI->firstname;
  	}
  
  	public function getLastName() {
		return $this->CI->lastname;
  	}
  
  	public function getEmail() {
		return strtolower($this->CI->email);
  	}
  
  	public function checkPassword($password) {
		$this->CI->db->select('*');
		$this->CI->db->from('customers');	
		$this->CI->db->where('email', strtolower($this->CI->email));
		$this->CI->db->where('password', 'SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1("' . $password . '")))))', FALSE);
		
		$query = $this->CI->db->get();
		//Login Successful 
		if ($query->num_rows() === 1) {
			return $this->CI->password;
		} else {
			return FAlSE;
		}
  	}

  	public function getTelephone() {
		return $this->CI->telephone;
  	}

  	public function getAddressId() {
	    return $this->CI->address_id;
	}
  	
  	public function getSecurityQuestionId() {
	    return $this->CI->security_question_id;
	}
  	
  	public function getSecurityAnswer() {
	    return $this->CI->security_answer;
	}
}