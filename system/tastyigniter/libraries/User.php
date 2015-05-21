<?php  if ( ! defined('BASEPATH')) exit('No direct access allowed');

class User {
    private $is_logged = FALSE;
    private $user_id;
    private $username;
    private $staff_id;
    private $permissions = array();
    private $staff_name;
    private $staff_group_name;
    private $staff_group_id;
    private $location_id;
    private $location_name;
    private $location_access;
	private $unread;
    private $uri_segment;
    private $ignore_uri;

    public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->database();
        $this->uri_segment = $this->CI->uri->rsegment(1);

		$this->initialize();
    }

	public function initialize() {
        $this->ignore_uri = array('login', 'logout', 'dashboard', 'permission', 'notifications');
        $this->uri_segment = $this->CI->uri->rsegment(1);

        $user_info = $this->CI->session->userdata('user_info');

        if ( !empty($user_info['user_id']) AND !empty($user_info['username']) AND !empty($user_info['email'])) {
            $this->CI->db->from('users');
            $this->CI->db->join('staffs', 'staffs.staff_id = users.staff_id', 'left');
            $this->CI->db->join('staff_groups', 'staff_groups.staff_group_id = staffs.staff_group_id', 'left');
            $this->CI->db->join('locations', 'locations.location_id = staffs.staff_location_id', 'left');

            $this->CI->db->where('user_id', $user_info['user_id']);
            $this->CI->db->where('username', $user_info['username']);
            $this->CI->db->where('staff_email', $user_info['email']);
            $this->CI->db->where('staff_status', '1');
            $query = $this->CI->db->get();

            if ($query->num_rows() === 1) {
                $row = $query->row_array();

                foreach ($query->row_array() as $key => $value) {
                    if (property_exists($this, $key)) {
                        $this->$key = $value;
                    }
                }

                $this->setPermissions($row['permission']);
                $this->setLocationAccess($row['location_access']);

                $this->is_logged = TRUE;
            }
        }

        if (!$this->is_logged) $this->logout();
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
				'username'     		=> $row['username'],
				'email'     		=> $row['staff_email']
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
        return $this->is_logged;
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
    	return $this->staff_group_name;
  	}

  	public function getStaffGroupId() {
    	return $this->staff_group_id;
  	}

  	public function setLocationAccess($location_access =  '0') {
        if ($location_access == '1') {
            if (!isset($_GET['filter_location'])) {
                $_GET['filter_location'] = $this->location_id;
            }
    	}
  	}

    private function setPermissions($permission) {
        if (!empty($permission)) {
            $permission = unserialize($permission);
            if (is_array($permission)) {
                foreach ($permission as $key => $value) {
                    $this->permissions[$key] = $value;
                }
            }
        }
    }

    public function hasPermissions($type, $uri_segment = '') {
        $type = !empty($type) ? $type : 'access';

        if ($uri_segment === '') {
            $uri_segment = $this->uri_segment;
        }

        return $this->checkPermission($type, $uri_segment);
    }

    public function checkPermission($type, $uri_segment = '') {
        if (in_array($uri_segment, $this->ignore_uri)) {
            return TRUE;
        } else if (isset($this->permissions[$type]) AND in_array($uri_segment, $this->permissions[$type])) {
            return TRUE;
        }

        return FALSE;
    }

    public function unreadMessageTotal() {
    	if (empty($this->unread)) {
			$this->CI->load->model('Messages_model');
    		$this->unread = $this->CI->Messages_model->getUnreadCount($this->staff_id);
		}

    	return $this->unread;
  	}

    public function logout() {
		$this->CI->session->unset_userdata('user_info');

		$this->is_logged = FALSE;
		$this->user_id = '';
		$this->username = '';
		$this->staff_id = '';
		$this->staff_name = '';
		$this->staff_group_name = '';
		$this->staff_group_id = '';
		$this->location_id = '';
		$this->location_name = '';
	}
}

// END User Class

/* End of file User.php */
/* Location: ./system/tastyigniter/libraries/User.php */