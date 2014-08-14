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
		
		$this->initialize();
	}
	
	public function initialize() {
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
			
			if ($query->num_rows() === 1) {
				$row = $query->row_array();

				$this->user_id 			= $row['user_id'];
				$this->username			= $row['username'];
				$this->staff_id 		= $row['staff_id'];
				$this->staff_name 		= $row['staff_name'];
				$this->staff_group_id 	= $row['staff_group_id'];
				$this->staff_group 		= $row['staff_group_name'];
				$this->location_id 		= $row['location_id'];
				$this->location_name 	= $row['location_name'];

				if (!empty($row['permission'])) {
					$permission = unserialize($row['permission']);

					if (is_array($permission)) {
						foreach ($permission as $key => $value) {
							$this->permissions[$key] = $value;
						}
					}
				}
				
				if ($row['location_access'] == '1') {
					$this->setLocationAccess();
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
			
			$this->user_id 		= $row['user_id'];
			$this->username 	= $row['username'];
			$this->staff_id 	= $row['staff_id'];
			$this->staff_name 	= $row['staff_name'];

	  		return TRUE;
		} else {
      		return FALSE;
		}
	}

  	public function isLogged() {
	    return $this->user_id;
	}

  	public function getId() {
		return $this->user_id;
  	}

  	public function getUserName() {
    	return $this->username;
  	}	

  	public function getStaffId() {
    	return $this->staff_id;
  	}	

  	public function getStaffName() {
    	return $this->staff_name;
  	}	

  	public function getLocationId() {
    	return $this->location_id;
  	}	

  	public function getLocationName() {
    	return $this->location_name;
  	}	

  	public function staffGroup() {
    	return $this->staff_group;
  	}	

  	public function getStaffGroupId() {
    	return $this->staff_group_id;
  	}	

  	public function setLocationAccess() {
    	//if (!isset($_GET['filter_location'])) {
    		$_GET['filter_location'] = $this->location_id;
    	//}
  	}	

  	public function hasPermissions($key, $value) {
    	if (isset($this->permissions[$key])) {
	  		return in_array($value, $this->permissions[$key]);
		} else {
	  		return FALSE;
		}
  	}

  	public function unreadMessageTotal() {
    	if (empty($this->unread)) {
			$this->CI->load->model('Messages_model');
    		$this->unread = $this->CI->Messages_model->getAdminMessageUnread($this->staff_id);
		}
    	return $this->unread;
  	}	

  	public function logout() {		
		$this->CI->session->unset_userdata('user_info');

		$this->user_id = '';
		$this->username = '';
		$this->staff_id = '';
		$this->staff_name = '';
		$this->staff_group = '';
		$this->staff_group_id = '';
		$this->location_id = '';
		$this->location_name = '';
	}
}

// END User Class

/* End of file User.php */
/* Location: ./application/libraries/User.php */