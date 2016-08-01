<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Staff_groups extends Admin_Controller
{

	public $list_filters = array(
		'sort_by'  => 'staff_group_id',
		'order_by' => 'DESC',
	);

	public function __construct() {
		parent::__construct(); //  calls the constructor

		$this->user->restrict('Admin.StaffGroups');

		$this->load->model('Staff_groups_model');
		$this->load->model('Permissions_model');

		$this->lang->load('staff_groups');
	}

	public function index() {
		if ($this->input->post('delete') AND $this->_deleteStaffGroup() === TRUE) {
			$this->redirect();
		}

		$this->template->setTitle($this->lang->line('text_title'));
		$this->template->setHeading($this->lang->line('text_heading'));
		$this->template->setButton($this->lang->line('button_new'), array('class' => 'btn btn-primary', 'href' => page_url() . '/edit'));
		$this->template->setButton($this->lang->line('button_delete'), array('class' => 'btn btn-danger', 'onclick' => 'confirmDelete();'));;

		$data = $this->getList();

		$this->template->render('staff_groups', $data);
	}

	public function edit() {
		if ($this->input->post() AND $staff_group_id = $this->_saveStaffGroup()) {
			$this->redirect($staff_group_id);
		}

		$group_info = $this->Staff_groups_model->getStaffGroup((int)$this->input->get('id'));

		$title = (isset($group_info['staff_group_name'])) ? $group_info['staff_group_name'] : $this->lang->line('text_new');
		$this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $title));
		$this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $title));
		$this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('staff_groups')));

		$data = $this->getForm($group_info);

		$this->template->render('staff_groups_edit', $data);
	}

	protected function getList() {
		$data = array_merge($this->list_filters, $this->sort_columns);
		$data['order_by_active'] = $this->list_filters['order_by'] . ' active';

		$data['staff_groups'] = array();
		$results = $this->Staff_groups_model->paginate($this->list_filters, $this->index_url);
		foreach ($results->list as $result) {
			$data['staff_groups'][] = array_merge($result, array(
				'users_count' => $this->Staff_groups_model->getUsersCount($result['staff_group_id']),
				'edit'        => $this->pageUrl($this->edit_url, array('id' => $result['staff_group_id'])),
			));
		}

		$data['pagination'] = $results->pagination;

		return $data;
	}

	protected function getForm($group_info) {
		$data = $group_info;

		$staff_group_id = 0;
		$data['_action'] = $this->pageUrl($this->create_url);
		if (!empty($group_info['staff_group_id'])) {
			$staff_group_id = $group_info['staff_group_id'];
			$data['_action'] = $this->pageUrl($this->edit_url, array('id' => $staff_group_id));
		}

		if (isset($this->input->post['staff_group_name'])) {
			$data['staff_group_name'] = $this->input->post['staff_group_name'];
		} else if (isset($group_info['staff_group_name'])) {
			$data['staff_group_name'] = $group_info['staff_group_name'];
		} else {
			$data['staff_group_name'] = '';
		}

		if (isset($this->input->post['customer_account_access'])) {
			$data['customer_account_access'] = $this->input->post['customer_account_access'];
		} else if (isset($group_info['customer_account_access'])) {
			$data['customer_account_access'] = $group_info['customer_account_access'];
		} else {
			$data['customer_account_access'] = '';
		}

		if (isset($this->input->post['location_access'])) {
			$data['location_access'] = $this->input->post['location_access'];
		} else if (isset($group_info['location_access'])) {
			$data['location_access'] = $group_info['location_access'];
		} else {
			$data['location_access'] = '';
		}

		if ($this->input->post('permissions')) {
			$group_permissions = $this->input->post('permissions');
		} else if (isset($group_info['permissions'])) {
			$group_permissions = unserialize($group_info['permissions']);
		}

		$data['permissions_list'] = array();
		$results = $this->Permissions_model->getPermissions();
		foreach ($results as $domain => $permissions) {

			foreach ($permissions as $permission) {
				$data['permissions_list'][$domain][] = array_merge($permission, array(
					'group_permissions' => (!empty($group_permissions[$permission['permission_id']])) ? $group_permissions[$permission['permission_id']] : array(),
				));
			}
		}

		return $data;
	}

	protected function _saveStaffGroup() {
		if ($this->validateForm() === TRUE) {
			$save_type = (!is_numeric($this->input->get('id'))) ? $this->lang->line('text_added') : $this->lang->line('text_updated');
			if ($staff_group_id = $this->Staff_groups_model->saveStaffGroup($this->input->get('id'), $this->input->post())) { // calls model to save data to SQL
				$this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Staff Groups ' . $save_type));
			} else {
				$this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
			}

			return $staff_group_id;
		}
	}

	protected function _deleteStaffGroup() {
		if ($this->input->post('delete')) {
			$deleted_rows = $this->Staff_groups_model->deleteStaffGroup($this->input->post('delete'));
			if ($deleted_rows > 0) {
				$prefix = ($deleted_rows > 1) ? '[' . $deleted_rows . '] Staff Groups' : 'Staff Group';
				$this->alert->set('success', sprintf($this->lang->line('alert_success'), $prefix . ' ' . $this->lang->line('text_deleted')));
			} else {
				$this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_deleted')));
			}

			return TRUE;
		}
	}

	protected function validateForm() {
		$rules[] = array('staff_group_name', 'lang:label_name', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$rules[] = array('customer_account_access', 'lang:label_customer_account_access', 'xss_clean|trim|required|integer');
		$rules[] = array('location_access', 'lang:label_location_access', 'xss_clean|trim|required|integer');

		if ($this->input->post('permissions')) {
			foreach ($this->input->post('permissions') as $key => $permissions) {
				foreach ($permissions as $k => $permission) {
					$rules[] = array('permissions[' . $key . '][' . $k . ']', ucfirst($permission) . ' Permission', 'xss_clean|trim|alpha|max_length[6]');
				}
			}
		}

		return $this->Staff_groups_model->set_rules($rules)->validate();
	}
}

/* End of file Staff_groups.php */
/* Location: ./admin/controllers/Staff_groups.php */