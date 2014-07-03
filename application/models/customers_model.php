<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Customers_model extends CI_Model {

    public function getAdminListCount($filter = array()) {
		if (!empty($filter['filter_search'])) {
			$this->db->like('first_name', $filter['filter_search']);
			$this->db->or_like('last_name', $filter['filter_search']);
			$this->db->or_like('email', $filter['filter_search']);
		}

		if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
			$this->db->where('status', $filter['filter_status']);
		}

		if (!empty($filter['filter_date'])) {
			$date = explode('-', $filter['filter_date']);
			$this->db->where('YEAR(date_added)', $date[0]);
			$this->db->where('MONTH(date_added)', $date[1]);
		}

		$this->db->from('customers');
		return $this->db->count_all_results();
    }
    
	public function getList($filter = array()) {
		if ($filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}
		
        if ($this->db->limit($filter['limit'], $filter['page'])) {	
			$this->db->from('customers');
			
			if (!empty($filter['sort_by']) AND !empty($filter['order_by'])) {
				$this->db->order_by($filter['sort_by'], $filter['order_by']);
			}

			if (!empty($filter['filter_search'])) {
				$this->db->like('first_name', $filter['filter_search']);
				$this->db->or_like('last_name', $filter['filter_search']);
				$this->db->or_like('email', $filter['filter_search']);
			}

			if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
				$this->db->where('status', $filter['filter_status']);
			}

			if (!empty($filter['filter_date'])) {
				$date = explode('-', $filter['filter_date']);
				$this->db->where('YEAR(date_added)', $date[0]);
				$this->db->where('MONTH(date_added)', $date[1]);
			}

			$query = $this->db->get();
			$result = array();
		
			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}
		
			return $result;
		}
	}

	public function getCustomers() {
		$this->db->from('customers');

		$query = $this->db->get();
		$result = array();
		
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}
		
		return $result;
	}

	public function getCustomer($customer_id) {
		if (is_numeric($customer_id)) {
			$this->db->from('customers');		
			$this->db->where('customer_id', $customer_id);
		
			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				return $query->row_array();
			}
		}
	}

	public function getCustomerDates() {
		$this->db->select('date_added, MONTH(date_added) as month, YEAR(date_added) as year');
		$this->db->from('customers');
		$this->db->group_by('MONTH(date_added)');
		$this->db->group_by('YEAR(date_added)');
		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}
	
	public function getCustomerByEmail($email) {
		$this->db->from('customers');		
		$this->db->where('email', strtolower($email));
		
		$query = $this->db->get();

		if ($query->num_rows() === 1) {
			$row = $query->row_array();
			
			return $row;
		}
	}

	public function getCustomersByGroupId($customer_group_id) {
		if ($customer_group_id) {
			$this->db->from('customers');		
			$this->db->where('customer_group_id', $customer_group_id);
		
			$query = $this->db->get();
			$result = array();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}

			return $result;
		}
	}

	public function getCustomersByNewsletter() {
		$this->db->from('customers');		
		$this->db->where('newsletter', '1');
		
		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}
    
	public function getAutoComplete($filter_data = array()) {
		if (is_array($filter_data) && !empty($filter_data)) {
			$this->db->from('customers');
	
			if (!empty($filter_data['customer_name'])) {
				$this->db->like('CONCAT(first_name, last_name)', $filter_data['customer_name']);		
			}
	
			$query = $this->db->get();
			$result = array();
		
			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}
		
			return $result;
		}
	}
	
	public function changePassword($customer_id, $password) {
		if (!empty($password)) {
			$this->db->set('password', sha1($password));
				
			$this->db->where('customer_id', $customer_id);
			return $this->db->update('customers');
		}
	}	

	public function resetPassword($customer_id = FALSE, $email = FALSE, $security_question_id = FALSE, $security_answer = FALSE) {
		if ($customer_id != FALSE && $email != FALSE && $security_question_id != FALSE && $security_answer != FALSE) {

			$this->db->from('customers');
			$this->db->where('customer_id', $customer_id);
			$this->db->where('email', strtolower($email));
			$this->db->where('security_question_id', $security_question_id);
			$this->db->where('security_answer', $security_answer);
			$this->db->where('status', '1');

			$query = $this->db->get();

			if ($query->num_rows() === 1) {
				$row = $query->row_array();

				//Randome Password
				$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
				$pass = array();
				for ($i = 0; $i < 8; $i++) {
					$n = rand(0, strlen($alphabet)-1);
					$pass[$i] = $alphabet[$n];
				}
		
				$password = implode('',$pass);

				$this->db->set('salt', $salt = substr(md5(uniqid(rand(), TRUE)), 0, 9));
				$this->db->set('password', sha1($salt . sha1($salt . sha1($password))));
				$this->db->where('customer_id', $row['customer_id']);
				$this->db->where('email', $row['email']);
			
				$this->db->update('customers');

				if ($this->db->affected_rows() > 0) {
					$this->load->library('mail_template'); 

					$mail_data['site_name'] 		= $this->config->item('site_name');
					$mail_data['first_name'] 		= $row['first_name'];
					$mail_data['last_name'] 		= $row['last_name'];
					$mail_data['created_password'] 	= $password;
					$mail_data['signature'] 		= $this->config->item('site_name');
					$mail_data['login_link'] 		= site_url('main/login');
			
					$message = $this->mail_template->parseTemplate('password_reset', $mail_data);
					$subject = $this->mail_template->getSubject();

					$this->sendMail($email, $subject, $message);
					return TRUE;
				}
			}
		}
		
		return FALSE;
	}

	public function updateCustomer($update = array()) {
		$query = FALSE;

		if (!empty($update['first_name'])) {
			$this->db->set('first_name', $update['first_name']);
		}
		
		if (!empty($update['last_name'])) {
			$this->db->set('last_name', $update['last_name']);			
		}
		
		if (!empty($update['email'])) {
			$this->db->set('email', strtolower($update['email']));
		}

		if (!empty($update['password'])) {
			$this->db->set('salt', $salt = substr(md5(uniqid(rand(), TRUE)), 0, 9));
			$this->db->set('password', sha1($salt . sha1($salt . sha1($update['password']))));
		}
			
		if (!empty($update['telephone'])) {
			$this->db->set('telephone', $update['telephone']);
		}
		
		if (!empty($update['security_question_id'])) {
			$this->db->set('security_question_id', $update['security_question_id']);
		}
		
		if (!empty($update['security_answer'])) {
			$this->db->set('security_answer', $update['security_answer']);
		}
		
		if ($update['newsletter'] === '1') {
			$this->db->set('newsletter', $update['newsletter']);
		} else {
			$this->db->set('newsletter', '0');
		}
		
		if (!empty($update['customer_group_id'])) {
			$this->db->set('customer_group_id', $update['customer_group_id']);
		}
		
		if (!empty($update['date_added'])) {
			$this->db->set('date_added', $update['date_added']);
		}
		
		if ($update['status'] === '1') {
			$this->db->set('status', $update['status']);
		} else if ($update['status'] === '0') {
			$this->db->set('status', '0');
		}
		
		if (!empty($update['customer_id'])) {
			$this->db->where('customer_id', $update['customer_id']);
			
			if ($query = $this->db->update('customers')) {
				if (!empty($update['address']) AND !empty($update['customer_id'])) {
					$this->load->model('Addresses_model');

					foreach ($update['address'] as $address) {
						if (!empty($address['address_id'])) {
							$this->Addresses_model->updateCustomerAddress($update['customer_id'], $address['address_id'], $address);
						} else {
							$this->Addresses_model->updateCustomerAddress($update['customer_id'], '', $address);
						}
					}
				}
			}
		}
				
		return $query;
	}	

	public function addCustomer($add = array()) {
		$query = FALSE;

		if (!empty($add['first_name'])) {
			$this->db->set('first_name', $add['first_name']);
		}
		
		if (!empty($add['last_name'])) {
			$this->db->set('last_name', $add['last_name']);
		}
		
		if (!empty($add['email'])) {
			$this->db->set('email', $add['email']);
		}

 		if (!empty($add['password'])) {
			$this->db->set('salt', $salt = substr(md5(uniqid(rand(), TRUE)), 0, 9));
			$this->db->set('password', sha1($salt . sha1($salt . sha1($add['password']))));
		}
		
		if (!empty($add['telephone'])) {
			$this->db->set('telephone', $add['telephone']);
		}
		
		if (!empty($add['security_question_id'])) {
			$this->db->set('security_question_id', $add['security_question_id']);
		}
		
		if (!empty($add['security_answer'])) {
			$this->db->set('security_answer', $add['security_answer']);
		}
		
		if ($add['newsletter'] === '1') {
			$this->db->set('newsletter', $add['newsletter']);
		} else {
			$this->db->set('newsletter', '0');
		}
		
		if (!empty($add['customer_group_id'])) {
			$this->db->set('customer_group_id', $add['customer_group_id']);
		}
		
		if (!empty($add['date_added'])) {
			$this->db->set('date_added', $add['date_added']);
		}
		
		if ($add['status'] === '1') {
			$this->db->set('status', $add['status']);
		} else {
			$this->db->set('status', '0');
		}
		
		if (!empty($add)) {
			if ($this->db->insert('customers')) {
				$customer_id = $this->db->insert_id();
			
				if (!empty($add['address']) AND $customer_id) {
					$this->load->model('Addresses_model');

					foreach ($add['address'] as $address) {
						$this->Addresses_model->addCustomerAddress($customer_id, $address);
					}
				}

				$mail_data['site_name'] 		= $this->config->item('site_name');
				$mail_data['first_name'] 		= $add['first_name'];
				$mail_data['last_name'] 		= $add['last_name'];
				$mail_data['signature'] 		= $this->config->item('site_name');
				$mail_data['login_link'] 		= site_url('main/login');
						
				$this->load->library('mail_template'); 
				$message = $this->mail_template->parseTemplate('registration', $mail_data);
				$subject = $this->mail_template->getSubject();

				$this->sendMail($add['email'], $subject, $message);

				$query = $customer_id;
			}
		}
				
		return $query;
	}

	public function deleteCustomer($customer_id) {
		if ($customer_id) {
			$this->db->where('customer_id', $customer_id);
			$this->db->delete('customers');
		
			$this->db->where('customer_id', $customer_id);
			$this->db->delete('address');
		}
		
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}

	public function sendMail($email, $subject, $message) {
	   	$this->load->library('email');

		$this->email->set_protocol($this->config->item('protocol'));
		$this->email->set_mailtype($this->config->item('mailtype'));
		$this->email->set_smtp_host($this->config->item('smtp_host'));
		$this->email->set_smtp_port($this->config->item('smtp_port'));
		$this->email->set_smtp_user($this->config->item('smtp_user'));
		$this->email->set_smtp_pass($this->config->item('smtp_pass'));
		$this->email->set_newline("\r\n");
		$this->email->initialize();

		$this->email->from($this->config->item('site_email'), $this->config->item('site_name'));
		$this->email->to(strtolower($email));

		$this->email->subject($subject);
		$this->email->message($message);

		return $this->email->send();
	}

	public function validateCustomer($customer_id) {
		if (is_numeric($customer_id)) {
			$this->db->from('customers');		
			$this->db->where('customer_id', $customer_id);
		
			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				return TRUE;
			}
		}
		
		return FALSE;
	}
}

/* End of file customers_model.php */
/* Location: ./application/models/customers_model.php */