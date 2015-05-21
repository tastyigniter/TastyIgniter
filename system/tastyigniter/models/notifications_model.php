<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Notifications_model extends TI_Model {

	/**
	 * The permitted objects for alteration.
	 */
	private $_valid_objects = array('coupon', 'customer', 'extension', 'location', 'menu',
		'order', 'reservation', 'review', 'staff', 'table');

	private $_action_messages = array();
	private $_staffs_list = array();
	private $_status_list = array();
	private $_menus_list = array();
	private $_customers_list = array();
	private $_locations_list = array();
	private $_extensions_list = array();

	public function __construct() {
		parent::__construct();
        $this->config->load('notification');
        $_config = $this->config->item('notification');

        $this->_action_messages = $_config['action_messages'];
		$this->_staffs_list = $this->getStaffsList();
		$this->_status_list = $this->getStatusList();
		$this->_menus_list = $this->getMenusList();
		$this->_customers_list = $this->getCustomersList();
		$this->_locations_list = $this->getLocationsList();
		$this->_extensions_list = $this->getExtensionsList();
	}

	public function getCount($filter = array()) {
		if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
			$this->db->where('status', $filter['filter_status']);
		}

		$this->db->from('notifications');
		return $this->db->count_all_results();
    }

	public function getList($filter = array()) {
		if (!empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

		if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->from('notifications');

			if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
				$this->db->where('status', $filter['filter_status']);
			}

			$this->db->order_by('date_added', 'DESC');

			$query = $this->db->get();
			$result = $sort_result = array();

			if ($query->num_rows() > 0) {
                foreach ($query->result_array() as $row) {
					$result[] = array(
						'notification_id'	=> $row['notification_id'],
						'icon'				=> $this->getObjectIcon($row['action']),
						'message'			=> $this->getMessage($row),
						'time'				=> time_elapsed($row['date_added']),
                        'date_added'		=> $row['date_added'],
                        'action'			=> $row['action'],
						'status'			=> $row['status'],
						'row'				=> $row,
					);
				}
			}

			return $result;
		}
	}

	public function getNotification() {
		$this->db->from('notifications');
		$this->db->order_by('date_added', 'DESC');

		$query = $this->db->get();
		$notifications = array();

		if ($query->num_rows() > 0) {
			$notifications = $query->result_array();
		}

		return $notifications;
	}

	public function addNotification($notification = array()) {
		$current_time = time();
		//array('action', 'object', 'object_id', 'actor_id', 'subject');
		//var_dump($notification);

		// if action is not a _notification_messages array key value do nothing
		/*if (empty($notification['action']) OR !array_key_exists($notification['action'], $this->_action_types)) {
			log_message('debug', 'The notification action value passed is not a defined action');
			return FALSE;
		}*/

		// if object is not in _valid_object array do nothing
		if (empty($notification['object']) OR !in_array($notification['object'], $this->_valid_objects)) {
			log_message('debug', 'The notification object value passed does not match any defined object');
			return FALSE;
		}

		// if object id is false do nothing
		if (!isset($notification['object_id']) OR empty($notification['object_id'])
			OR !is_numeric($notification['object_id'])) {

			log_message('debug', 'Notification object id does not exist');
			return FALSE;
		}

		$this->db->set('date_added', mdate('%Y-%m-%d %H:%i:%s', $current_time));
		$this->db->set('action', $notification['action']);
		$this->db->set('object', $notification['object']);

		if (!empty($notification['object_id']) AND is_numeric($notification['object_id'])) {
			$this->db->set('object_id', $notification['object_id']);
		}

		if (!empty($notification['actor_id']) AND is_numeric($notification['actor_id'])) {
			$this->db->set('actor_id', $notification['actor_id']);
        } else if (!empty($this->user)) {
            $this->db->set('actor_id', $this->user->getStaffId());
        }

		if (!empty($notification['subject_id']) AND is_numeric($notification['subject_id'])) {
			$this->db->set('subject_id', $notification['subject_id']);
		}

		if (!empty($notification['suffix'])) {
			$this->db->set('suffix', $notification['suffix']);
		}

		if (!empty($notification) AND $this->db->insert('notifications')) {
			return TRUE;
		}
	}

	public function getObjectIcon($action = '') {
		return (isset($this->_action_messages[$action]) AND is_array($this->_action_messages[$action]))
			? $this->_action_messages[$action][1] : 'fa fa-tasks';
	}

	public function getMessage($notification = array()) {
		$action = 'notify_'.$notification['action'];

		$temp_message = (isset($this->_action_messages[$action]) AND is_array($this->_action_messages[$action]))
			? $this->_action_messages[$action][0] : 'No notification message';

		if (!empty($notification['actor_id'])) {
			$actor = $this->getActor($notification['actor_id']);
			$temp_message = str_replace('{actor}', $actor, $temp_message);
		}

		if (!empty($notification['object'])) {
			$object = $this->getObject($notification['object'], $notification['object_id'], $notification['action']);
			$temp_message = str_replace('{object}', $object, $temp_message);
		}

		if (!empty($notification['subject_id'])) {
			$subject = $this->getSubject($notification['object'], $notification['subject_id'], $notification['action']);
			$temp_message = str_replace('{subject}', $subject, $temp_message);
		}

		return $temp_message;
	}

	private function getActor($actor_id = '') {
		if (!isset($this->_staffs_list[$actor_id])) {
			return $actor_id;
		}

		$staff = $this->_staffs_list[$actor_id];
		if (!empty($staff['staff_name'])) {
			return ($actor_id === $this->user->getStaffId()) ? $this->_action_messages['notify_self'] : $staff['staff_name'];
		}

		//return '<a href="'.site_url('staffs/edit?id='.$staff['staff_id']).'">' .$actor . '</a>';
		return $actor_id;
	}

	private function getObject($object = '', $object_id = '', $action = '') {
		if (!in_array($object, $this->_valid_objects)) {
			return $object_id;
		}

		$controller = (substr($object, -1) == 's') ? $object.'es' : $object.'s';

		$temp_object_name = $temp_object = '';
		if (!empty($object_id) AND is_numeric($object_id)) {
			switch ($object) {
				case 'menu':
					$temp_object_name = isset($this->_menus_list[$object_id]) ? $this->_menus_list[$object_id] : $object_id;
					$temp_object = $object . ' <a href="'.site_url($controller.'/edit?id='.$object_id).'">'.$temp_object_name.'</a>';
					break;

				case 'customer':
					$temp_object_name = isset($this->_customers_list[$object_id]) ? $this->_customers_list[$object_id] : $object_id;
					$temp_object = $object . ' <a href="'.site_url($controller.'/edit?id='.$object_id).'">'.$temp_object_name.'</a>';
					break;

				case 'staff':
					$staff = isset($this->_staffs_list[$object_id]) ? $this->_staffs_list[$object_id] : $object_id;
					$temp_object_name = isset($staff['staff_name']) ? $staff['staff_name'] : '';
					$temp_object = $object . ' <a href="'.site_url($controller.'/edit?id='.$object_id).'">'.$temp_object_name.'</a>';
					break;

				case 'location':
					$temp_object_name = isset($this->_locations_list[$object_id]) ? $this->_locations_list[$object_id] : $object_id;
					$temp_object = $object . ' <a href="'.site_url($controller.'/edit?id='.$object_id).'">'.$temp_object_name.'</a>';
					break;

				case 'extension':
					$extension = isset($this->_extensions_list[$object_id]) ? $this->_extensions_list[$object_id] : $object_id;
					$extension_name = isset($extension['name']) ? $extension['name'] : '';
					$extension_type = isset($extension['type']) ? $extension['type'] : '';
					$temp_object = $object . ' '.$extension_type.' <b>'.$extension_name.'</b>';
					break;

				default:
					$temp_object_name = '#'.$object_id;
					$temp_object = $object . ' <a href="'.site_url($controller.'/edit?id='.$object_id).'">'.$temp_object_name.'</a>';
					break;
			}
		} else {
			$temp_object = $object;
		}

		return strtolower($temp_object);
	}

	private function getSubject($object = '', $subject_id = '', $action = '') {
		if (!in_array($object, $this->_valid_objects)) {
			return $object;
		}

		if (empty($subject_id) OR empty($action)) {
			return $subject_id;
		}

		$temp_subject = '';
		switch ($object) {
			case 'order':
			case 'reservation':
				if ($action === 'changed') {
					$temp_subject = isset($this->_status_list[$subject_id]) ? $this->_status_list[$subject_id] : $subject_id;
				} else if ($action === 'assigned') {
					$temp_subject = $this->getActor($subject_id);
				}

				break;

			case 'review':
				$temp_subject = isset($this->_customers_list[$subject_id]) ? $this->_customers_list[$subject_id] : $subject_id;
				break;

			default:
				$temp_subject = $subject_id;
				break;
		}

		return strtolower($temp_subject);
	}

	private function getStaffsList() {
		$this->db->from('staffs');
		$this->db->where('staff_status', '1');

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$result[$row['staff_id']] = array(
					'staff_id'			=> $row['staff_id'],
					'staff_name'		=> $row['staff_name'],
					'staff_group_id'	=> $row['staff_group_id'],
				);
			}
		}

		return $result;
	}

	private function getStatusList() {
		$result = array();

		$this->db->select('status_id, status_name');
		$this->db->from('statuses');

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$result[$row['status_id']] = $row['status_name'];
			}
		}

		return $result;
	}

	private function getMenusList() {
		$result = array();

		$this->db->select('menu_id, menu_name');
		$this->db->from('menus');

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$result[$row['menu_id']] = (strlen($row['menu_name']) > 15) ? strtolower(substr($row['menu_name'], 0, 15)).'...' : strtolower($row['menu_name']);
			}
		}

		return $result;
	}

	private function getCustomersList() {
		$result = array();

		$this->db->select('customer_id, first_name, last_name');
		$this->db->from('customers');

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$result[$row['customer_id']] = $row['first_name'].' '.$row['last_name'];
			}
		}

		return $result;
	}

	private function getLocationsList() {
		$result = array();

		$this->db->select('location_id, location_name');
		$this->db->from('locations');

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$result[$row['location_id']] = $row['location_name'];
			}
		}

		return $result;
	}

	private function getExtensionsList() {
		$result = array();

		$this->db->select('extension_id, name, title, type');
		$this->db->from('extensions');

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$result[$row['extension_id']] = array(
					'name'	=> empty($row['title']) ? ucwords(str_replace('_', ' ', $row['name'])) : $row['title'],
					'type'	=> $row['type']
				);
			}
		}

		return $result;
	}
}

/* End of file notifications_model.php */
/* Location: ./system/tastyigniter/models/notifications_model.php */
