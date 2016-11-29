<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Staff_groups extends Admin_Controller
{

	public $default_sort = ['staff_group_id', 'DESC'];

	public function __construct()
	{
		parent::__construct(); //  calls the constructor

		$this->user->restrict('Admin.StaffGroups');

		$this->load->model('Staff_groups_model');
		$this->load->model('Permissions_model');

		$this->lang->load('staff_groups');
	}

	public function index()
	{
		if ($this->input->post('delete') AND $this->_deleteStaffGroup() === TRUE) {
			$this->redirect();
		}

		$this->template->setTitle($this->lang->line('text_title'));
		$this->template->setHeading($this->lang->line('text_heading'));
		$this->template->setButton($this->lang->line('button_new'), ['class' => 'btn btn-primary', 'href' => page_url() . '/edit']);
		$this->template->setButton($this->lang->line('button_delete'), ['class' => 'btn btn-danger', 'onclick' => 'confirmDelete();']);;

		$data = $this->getList();

		$this->template->render('staff_groups', $data);
	}

	public function edit()
	{
		if ($this->input->post() AND $staff_group_id = $this->_saveStaffGroup()) {
			$this->redirect($staff_group_id);
		}

		$group_info = $this->Staff_groups_model->getStaffGroup((int)$this->input->get('id'));

		$title = (isset($group_info['staff_group_name'])) ? $group_info['staff_group_name'] : $this->lang->line('text_new');
		$this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $title));
		$this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $title));
		$this->template->setButton($this->lang->line('button_save'), ['class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();']);
		$this->template->setButton($this->lang->line('button_save_close'), ['class' => 'btn btn-default', 'onclick' => 'saveClose();']);
		$this->template->setButton($this->lang->line('button_icon_back'), ['class' => 'btn btn-default', 'href' => site_url('staff_groups')]);

		$data = $this->getForm($group_info);

		$this->template->render('staff_groups_edit', $data);
	}

	public function getList()
	{
		$data = array_merge($this->getFilter(), $this->getSort());

		$data['staff_groups'] = [];
		$results = $this->Staff_groups_model->paginateWithFilter($this->getFilter());
		foreach ($results->list as $result) {
			$data['staff_groups'][] = array_merge($result, [
				'users_count' => $this->Staff_groups_model->getUsersCount($result['staff_group_id']),
				'edit'        => $this->pageUrl($this->edit_url, ['id' => $result['staff_group_id']]),
			]);
		}

		$data['pagination'] = $results->pagination;

		return $data;
	}

	public function getForm($group_info)
	{
		$data = $group_info;

		$staff_group_id = 0;
		$data['_action'] = $this->pageUrl($this->create_url);
		if (!empty($group_info['staff_group_id'])) {
			$staff_group_id = $group_info['staff_group_id'];
			$data['_action'] = $this->pageUrl($this->edit_url, ['id' => $staff_group_id]);
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
		} else if (is_array($group_info['permissions'])) {
			$group_permissions = $group_info['permissions'];
		}

		$data['permissions_list'] = [];
		$results = $this->Permissions_model->getPermissions();
		foreach ($results as $domain => $permissions) {
			foreach ($permissions as $permission) {
				$data['permissions_list'][$domain][] = array_merge($permission, [
					'action'            => empty($permission['action']) ? [] : $permission['action'],
					'group_permissions' => (!empty($group_permissions[$permission['name']])) ? $group_permissions[$permission['name']] : [],
				]);
			}
		}

		return $data;
	}

	protected function _saveStaffGroup()
	{
		if ($this->validateForm() === TRUE) {
			$data = $this->input->post();

			$permissions = $this->Permissions_model->getPermissionsByIds();
			foreach ($data['permissions'] as $permission_id => $permission_access) {
				$data['permissions'][$permissions[$permission_id]['name']] = $data['permissions'][$permission_id];
				unset($data['permissions'][$permission_id]);
			}

			$save_type = (!is_numeric($this->input->get('id'))) ? $this->lang->line('text_added') : $this->lang->line('text_updated');
			if ($staff_group_id = $this->Staff_groups_model->saveStaffGroup($this->input->get('id'), $data)) { // calls model to save data to SQL
				$this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Staff Groups ' . $save_type));
			} else {
				$this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
			}

			return $staff_group_id;
		}
	}

	protected function _deleteStaffGroup()
	{
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

	protected function validateForm()
	{
		$rules[] = ['staff_group_name', 'lang:label_name', 'xss_clean|trim|required|min_length[2]|max_length[32]'];
		$rules[] = ['customer_account_access', 'lang:label_customer_account_access', 'xss_clean|trim|required|integer'];
		$rules[] = ['location_access', 'lang:label_location_access', 'xss_clean|trim|required|integer'];

		if ($this->input->post('permissions')) {
			foreach ($this->input->post('permissions') as $key => $permissions) {
				foreach ($permissions as $k => $permission) {
					$rules[] = ['permissions[' . $key . '][' . $k . ']', ucfirst($permission) . ' Permission', 'xss_clean|trim|alpha|max_length[6]'];
				}
			}
		}

		return $this->form_validation->set_rules($rules)->run();
	}
}

/* End of file Staff_groups.php */
/* Location: ./admin/controllers/Staff_groups.php */