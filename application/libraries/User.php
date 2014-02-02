<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User {
	private $user_id;
	private $username;
	private $staff_id;
	private $permissions = array();
	private $staff_name;
	private $department;
	private $department_id;
	private $location_id;
	private $location_name;
	
	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->database();
		
		if ( ! $this->CI->session->userdata('user_id')) { 
	
			$this->logout();
	
		} else {
	
			$this->CI->db->from('users');	
			$this->CI->db->join('staffs', 'staffs.staff_id = users.staff_id', 'left');
			$this->CI->db->join('departments', 'departments.department_id = staffs.staff_department', 'left');
			$this->CI->db->join('locations', 'locations.location_id = staffs.staff_location', 'left');

			$this->CI->db->where('user_id', $this->CI->session->userdata('user_id'));
			$this->CI->db->where('username', $this->CI->session->userdata('username'));

			$query = $this->CI->db->get();

			$row = $query->row_array();
			
			if ($query->num_rows() === 1) {

				$this->CI->user_id 			= $row['user_id'];
				$this->CI->username			= $row['username'];
				$this->CI->staff_id 		= $row['staff_id'];
				$this->CI->staff_name 		= $row['staff_name'];
				$this->CI->location_id 		= $row['location_id'];
				$this->CI->location_name 	= $row['location_name'];

				$this->CI->department_id 	= $row['department_id'];
				$this->CI->department 		= $row['department_name'];
			
				if (!empty($row['permission'])) {
					$permission = unserialize($row['permission']);

					if (is_array($permission)) {
						foreach ($permission as $key => $value) {
							$this->CI->permissions[$key] = $value;
						}
					}
				}

			} else {
				$this->logout();
			}
		}
		
		if ($this->CI->session->userdata('staff_department')) { 

		
		}
	}

	public function login($user, $password) {

		$this->CI->db->from('users');	
		$this->CI->db->join('staffs', 'staffs.staff_id = users.staff_id', 'left');
		
		$this->CI->db->where('username', strtolower($user));
		$this->CI->db->where('password', 'SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1("' . $password . '")))))', FALSE);
		$this->CI->db->where('staff_status', '1');
		
		$query = $this->CI->db->get();
		
		$row = $query->row_array();
		
		//Login Successful 
		if ($query->num_rows() === 1) {

			//add login into session
			$admin_data = array(
				'user_id'  			=> $row['user_id'],
				'username'     		=> $row['username']
			);
			$this->CI->session->set_userdata($admin_data);
			
			$this->CI->user_id 		= $row['user_id'];
			$this->CI->username 	= $row['username'];
			$this->CI->staff_id 	= $row['staff_id'];
			$this->CI->staff_name 	= $row['staff_name'];

	  		return TRUE;
		//Login failed and field empty
		}else {
      		return FALSE;
		}
	}

  	public function logout() {		
		$sess_admin_data = array(
			'user_id' 			=> '',
			'staff_department'	=> '',
			'username' 			=> ''
		);
		
		$this->CI->session->unset_userdata($sess_admin_data);

		$this->CI->user_id = '';
		$this->CI->username = '';
	}

  	public function isLogged() {
	    return $this->CI->user_id;
	}

  	public function getId() {
		return $this->CI->user_id;
  	}

  	public function getUserName() {
    	return $this->CI->username;
  	}	

  	public function getStaffId() {
    	return $this->CI->staff_id;
  	}	

  	public function getStaffName() {
    	return $this->CI->staff_name;
  	}	

  	public function getLocationId() {
    	return $this->CI->location_id;
  	}	

  	public function getLocationName() {
    	return $this->CI->location_name;
  	}	

  	public function department() {
    	return $this->CI->department;
  	}	

  	public function getDepartmentId() {
    	return $this->CI->department_id;
  	}	

  	public function getPaths() {
		$ignore_path = array(
			'admin/login',
			'admin/logout',
			'admin/dashboard',
			'common/forgotten'
		);
	
		$files = glob(APPPATH .'/controllers/admin/*.php');
		$extension_files = glob(APPPATH .'extensions/admin/controllers/*.php');
	
		$paths = array();
		foreach (array_merge($files, $extension_files) as $file) {
			$file_name = 'admin/'. basename($file, '.php');

			if (!in_array($file_name, $ignore_path)) {
				$paths[] = $file_name;
			}
		}

		return $paths;
	}

  	public function hasPermissions($key, $value) {
    	if (isset($this->CI->permissions[$key])) {
	  		return in_array($value, $this->CI->permissions[$key]);
		} else {
	  		return FALSE;
		}
  	}
}