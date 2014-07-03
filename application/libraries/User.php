<?php  if ( ! defined('BASEPATH')) exit('No direct access allowed');

class User {
	private $user_id;
	private $username;
	private $staff_id;
	private $permissions = array();
	private $staff_name;
	private $staff_group;
	private $staff_group_id;
	private $location_id;
	private $location_name;
	private $location_access;
	private $unread;
	
	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->database();
		
		$user_info = $this->CI->session->userdata('user_info');

		if ( ! isset($user_info['user_id']) AND  ! isset($user_info['username'])) { 
			$this->logout();
		} else {
	
			$this->CI->db->from('users');	
			$this->CI->db->join('staffs', 'staffs.staff_id = users.staff_id', 'left');
			$this->CI->db->join('staff_groups', 'staff_groups.staff_group_id = staffs.staff_group_id', 'left');
			$this->CI->db->join('locations', 'locations.location_id = staffs.staff_location_id', 'left');

			$this->CI->db->where('user_id', $user_info['user_id']);
			$this->CI->db->where('username', $user_info['username']);

			$query = $this->CI->db->get();
			$row = $query->row_array();
			
			if ($query->num_rows() === 1) {
				$this->CI->user_id 			= $row['user_id'];
				$this->CI->username			= $row['username'];
				$this->CI->staff_id 		= $row['staff_id'];
				$this->CI->staff_name 		= $row['staff_name'];
				$this->CI->location_id 		= $row['location_id'];
				$this->CI->location_name 	= $row['location_name'];

				$this->CI->staff_group_id 	= $row['staff_group_id'];
				$this->CI->staff_group 		= $row['staff_group_name'];
				$this->CI->location_access 	= $row['location_access'];
			
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
	}

	public function login($user, $password) {
		$this->CI->db->from('users');	
		$this->CI->db->join('staffs', 'staffs.staff_id = users.staff_id', 'left');
		
		$this->CI->db->where('username', strtolower($user));
		$this->CI->db->where('password', 'SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1("' . $password . '")))))', FALSE);
		$this->CI->db->where('staff_status', '1');
		
		$query = $this->CI->db->get();
		
		//Login Successful 
		if ($query->num_rows() === 1) {
			$row = $query->row_array();

			$user_data = array(
				'user_id'  			=> $row['user_id'],
				'username'     		=> $row['username']
			);
			
			$this->CI->session->set_userdata('user_info', $user_data);
			
			$this->CI->user_id 		= $row['user_id'];
			$this->CI->username 	= $row['username'];
			$this->CI->staff_id 	= $row['staff_id'];
			$this->CI->staff_name 	= $row['staff_name'];

	  		return TRUE;
		} else {
      		return FALSE;
		}
	}

  	public function logout() {		
		$this->CI->session->unset_userdata('user_info');

		$this->CI->user_id = '';
		$this->CI->username = '';
		$this->CI->staff_id = '';
		$this->CI->staff_name = '';
		$this->CI->staff_group = '';
		$this->CI->staff_group_id = '';
		$this->CI->location_id = '';
		$this->CI->location_name = '';
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

  	public function staffGroup() {
    	return $this->CI->staff_group;
  	}	

  	public function getStaffGroupId() {
    	return $this->CI->staff_group_id;
  	}	

  	public function staffLocationAccess() {
    	return $this->CI->location_access;
  	}	

  	public function hasPermissions($key, $value) {
    	if (isset($this->CI->permissions[$key])) {
	  		return in_array($value, $this->CI->permissions[$key]);
		} else {
	  		return FALSE;
		}
  	}

  	public function unreadMessageTotal() {
    	if (empty($this->unread)) {
			$this->CI->load->model('Messages_model');
    		$this->unread = $this->CI->Messages_model->getAdminMessageUnread($this->CI->staff_id);
		}
    	return $this->unread;
  	}	
}

// END User Class

/* End of file User.php */
/* Location: ./application/libraries/User.php */