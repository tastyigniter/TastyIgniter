<?php  if ( ! defined('BASEPATH')) exit('No direct access allowed');

class User {
    private $is_logged = FALSE;
    private $user_id;
    private $username;
    private $staff_id;
    private $permissions = array();
    private $permitted_actions = array();
    private $available_actions = array();
    private $staff_name;
    private $staff_group_name;
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
                foreach ($query->row_array() as $key => $value) {
                    if (property_exists($this, $key)) {
                        $this->$key = $value;
                    }
                }

                $this->setPermissions();
                $this->setLocationAccess();

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

    public function restrict($permission) {
        // If user isn't logged in, redirect to the login page.
        if ( ! $this->is_logged AND $this->uri->rsegment(1) !== 'login') redirect(root_url(ADMINDIR.'/login'));

        if (empty($permission)) return TRUE;

        // Split the permission string into array and
        // remove the last element and use it as  the permission action
        $permission = explode('.', $permission);

        $action = '';
        if (count($permission) === 3) {
            $action = strtolower(array_pop($permission));
        }

        $permission = implode('.', $permission);

        // Check whether the user has the proper permissions action.
        if (($has_permission = $this->checkPermittedActions($permission, $action, TRUE)) === TRUE) return TRUE;

        // get the previous page from the session.
        $uri = referrer_url();

        // If previous page and current page are the same, but the user no longer
        // has permission, redirect to site URL to prevent an infinite loop.
        if ($uri === current_url() AND !$this->CI->input->post()) {
            $uri = site_url();
        }

        if (!$this->CI->input->is_ajax_request()) {  // remove later
            redirect($uri);
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

  	public function setLocationAccess() {
        if ($this->location_access == '1') {
            if (!isset($_GET['filter_location'])) {
                $_GET['filter_location'] = $this->location_id;
            }
    	}
  	}

    public function unreadMessageTotal() {
        if (empty($this->unread)) {
            $this->CI->load->model('Messages_model');
            $this->unread = $this->CI->Messages_model->getUnreadCount($this->staff_id);
        }

        return $this->unread;
    }

    public function hasPermission($permission) {
        if ( ! $this->is_logged) return FALSE;

        $permission = explode('.', $permission);

        $action = '';
        if (count($permission) === 3) {
            $action = strtolower(array_pop($permission));
        }

        $permission = implode('.', $permission);

        return $this->checkPermittedActions($permission, $action);
    }

    private function setPermissions() {
        $group_permissions = (!empty($this->permissions)) ? @unserialize($this->permissions) : NULL;

        if (is_array($group_permissions)) {
            $this->CI->load->model('Permissions_model');
            $permissions = $this->CI->Permissions_model->getPermissionsByIds();

            foreach ($permissions as $permission_id => $permission) {
                $this->available_actions[$permission['name']] = $permissions[$permission_id]['action'];
            }

            foreach ($group_permissions as $permission_id => $permitted_actions) {
                if (!empty($permissions[$permission_id]['name'])  AND $permission_name = $permissions[$permission_id]['name']
                    AND !empty(array_intersect($permitted_actions, $this->available_actions[$permission_name]))) {

                    $this->permitted_actions[$permission_name] = $permitted_actions;
                }
            }


        }
    }

    private function checkPermittedActions($perm = '', $action = '', $display_error = FALSE) {
        // Fail silently if the permission doesn't have any permitted or available actions
        if (!isset($this->permitted_actions[$perm]) AND !isset($this->available_actions[$perm])) {
            return TRUE;
        }

        $permitted = TRUE;
        // Fail if the staff group permision has available actions and no permitted actions.
        if (empty($this->permitted_actions[$perm]) AND !empty($this->available_actions[$perm])) $permitted = FALSE;

        // Success if the permission has no available actions
        if (empty($this->available_actions[$perm])) return TRUE;

        // Specify the requested action if not present, based on the $_SERVER REQUEST_METHOD
        if ($action === '') {
            if ($this->CI->input->server('REQUEST_METHOD') === 'POST') {
                if ($this->CI->input->post('delete')) {
                    $action = 'delete';
                } else if (is_numeric($this->CI->input->get('id'))) {
                    $action = 'manage';
                } else {
                    $action = 'add';
                }
            } else if ($this->CI->input->server('REQUEST_METHOD') === 'GET') {
                $action = 'access';
            }
        }

        // Ensure the action string is in lowercase
        $action = strtolower($action);

        // Fail if action is not permitted but is available.
        if ($permitted === FALSE OR (!in_array($action, $this->permitted_actions[$perm]) AND in_array($action, $this->available_actions[$perm]))) {
            $perm = explode('.', $perm);
            $context = isset($perm[1]) ? $perm[1] : '';
            if ($display_error) {
                $this->CI->alert->set('warning', 'Warning: You do not have the right permission to '.$action.' context ['.$context.'], please contact system administrator.');
            }

            return FALSE;
        }

        return $permitted;
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