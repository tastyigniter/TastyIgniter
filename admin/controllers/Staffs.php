<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Staffs extends Admin_Controller {

    public function __construct() {
		parent::__construct(); //  calls the constructor

        $this->load->model('Staffs_model');
        $this->load->model('Locations_model'); // load the locations model
        $this->load->model('Staff_groups_model');

        $this->load->library('pagination');

        $this->lang->load('staffs');
    }

	public function index() {
        $this->user->restrict('Admin.Staffs');

		$url = '?';
		$filter = array();
		if ($this->input->get('page')) {
			$filter['page'] = (int) $this->input->get('page');
		} else {
			$filter['page'] = '';
		}

		if ($this->config->item('page_limit')) {
			$filter['limit'] = $this->config->item('page_limit');
		}

		if ($this->input->get('filter_search')) {
			$filter['filter_search'] = $data['filter_search'] = $this->input->get('filter_search');
			$url .= 'filter_search='.$filter['filter_search'].'&';
		} else {
			$data['filter_search'] = '';
		}

		if ($this->input->get('filter_group')) {
			$filter['filter_group'] = $data['filter_group'] = $this->input->get('filter_group');
			$url .= 'filter_group='.$filter['filter_group'].'&';
		} else {
			$filter['filter_group'] = $data['filter_group'] = '';
		}

    	if (is_numeric($this->input->get('filter_location'))) {
			$filter['filter_location'] = $data['filter_location'] = $this->input->get('filter_location');
			$url .= 'filter_location='.$filter['filter_location'].'&';
		} else {
			$filter['filter_location'] = $data['filter_location'] = '';
		}

		if ($this->input->get('filter_date')) {
			$filter['filter_date'] = $data['filter_date'] = $this->input->get('filter_date');
			$url .= 'filter_date='.$filter['filter_date'].'&';
		} else {
			$filter['filter_date'] = $data['filter_date'] = '';
		}

		if (is_numeric($this->input->get('filter_status'))) {
			$filter['filter_status'] = $data['filter_status'] = $this->input->get('filter_status');
			$url .= 'filter_status='.$filter['filter_status'].'&';
		} else {
			$filter['filter_status'] = $data['filter_status'] = '';
		}

		if ($this->input->get('sort_by')) {
			$filter['sort_by'] = $data['sort_by'] = $this->input->get('sort_by');
		} else {
			$filter['sort_by'] = $data['sort_by'] = 'staffs.date_added';
		}

		if ($this->input->get('order_by')) {
			$filter['order_by'] = $data['order_by'] = $this->input->get('order_by');
			$data['order_by_active'] = $this->input->get('order_by') .' active';
		} else {
			$filter['order_by'] = $data['order_by'] = 'DESC';
			$data['order_by_active'] = 'DESC';
		}

        $this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading($this->lang->line('text_heading'));
		$this->template->setButton($this->lang->line('button_new'), array('class' => 'btn btn-primary', 'href' => page_url() .'/edit'));
		$this->template->setButton($this->lang->line('button_delete'), array('class' => 'btn btn-danger', 'onclick' => 'confirmDelete();'));;

		if ($this->input->post('delete') AND $this->_deleteStaff() === TRUE) {
			redirect('staffs');
		}

		$order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'ASC') ? 'DESC' : 'ASC';
		$data['sort_name'] 			= site_url('staffs'.$url.'sort_by=staff_name&order_by='.$order_by);
		$data['sort_group']			= site_url('staffs'.$url.'sort_by=staff_group_name&order_by='.$order_by);
		$data['sort_location'] 		= site_url('staffs'.$url.'sort_by=location_name&order_by='.$order_by);
		$data['sort_date'] 			= site_url('staffs'.$url.'sort_by=date_added&order_by='.$order_by);
		$data['sort_id'] 			= site_url('staffs'.$url.'sort_by=staff_id&order_by='.$order_by);

		$data['staffs'] = array();
		$results = $this->Staffs_model->getList($filter);
		foreach ($results as $result) {

			$data['staffs'][] = array(
				'staff_id' 				=> $result['staff_id'],
				'staff_name' 			=> $result['staff_name'],
				'staff_email' 			=> $result['staff_email'],
				'staff_group_name' 		=> $result['staff_group_name'],
				'location_name' 		=> $result['location_name'],
				'date_added' 			=> day_elapsed($result['date_added']),
				'staff_status' 			=> ($result['staff_status'] === '1') ? $this->lang->line('text_enabled') : $this->lang->line('text_disabled'),
				'edit' 					=> site_url('staffs/edit?id=' . $result['staff_id'])
			);
		}

		$data['staff_groups'] = array();
		$results = $this->Staff_groups_model->getStaffGroups();
		foreach ($results as $result) {
			$data['staff_groups'][] = array(
				'staff_group_id'	=>	$result['staff_group_id'],
				'staff_group_name'	=>	$result['staff_group_name']
			);
		}

		$this->load->model('Locations_model');
		$data['locations'] = array();
		$results = $this->Locations_model->getLocations();
		foreach ($results as $result) {
			$data['locations'][] = array(
				'location_id'	=>	$result['location_id'],
				'location_name'	=>	$result['location_name'],
			);
		}

		$data['staff_dates'] = array();
		$staff_dates = $this->Staffs_model->getStaffDates();
		foreach ($staff_dates as $staff_date) {
			$month_year = $staff_date['year'].'-'.$staff_date['month'];
			$data['staff_dates'][$month_year] = mdate('%F %Y', strtotime($staff_date['date_added']));
		}

		if ($this->input->get('sort_by') AND $this->input->get('order_by')) {
			$url .= 'sort_by='.$filter['sort_by'].'&';
			$url .= 'order_by='.$filter['order_by'].'&';
		}

		$config['base_url'] 		= site_url('staffs'.$url);
		$config['total_rows'] 		= $this->Staffs_model->getCount($filter);
		$config['per_page'] 		= $filter['limit'];

		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		$this->template->render('staffs', $data);
	}

	public function edit() {
        if ($this->user->getStaffId() !== $this->input->get('id')) {
            $this->user->restrict('Admin.Staffs');
        }

        $staff_info = $this->Staffs_model->getStaff((int) $this->input->get('id'));

		if ($staff_info) {
			$staff_id = $staff_info['staff_id'];
			$data['_action']	= site_url('staffs/edit?id='. $staff_id);
		} else {
		    $staff_id = 0;
			$data['_action']	= site_url('staffs/edit');
		}

		$user_info = $this->Staffs_model->getStaffUser($staff_id);

		$title = (isset($staff_info['staff_name'])) ? $staff_info['staff_name'] : $this->lang->line('text_new');
        $this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $title));
        $this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $title));
		$this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));

		if ($this->user->hasPermission('Admin.Staffs.Access')) {
			$this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		}

		$this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('staffs')));

		if ($this->input->post() AND $staff_id = $this->_saveStaff($staff_info['staff_email'], $user_info['username'])) {
			if ($this->input->post('save_close') === '1') {
				redirect('staffs');
			}

			redirect('staffs/edit?id='. $staff_id);
		}

		$data['display_staff_group'] = FALSE;
        if ($this->user->hasPermission('Admin.StaffGroups.Manage')) {
            $data['display_staff_group'] = TRUE;
        }

        $data['staff_name'] 		= $staff_info['staff_name'];
		$data['staff_email'] 		= $staff_info['staff_email'];
		$data['staff_group_id'] 	= $staff_info['staff_group_id'];
		$data['staff_location_id'] 	= $staff_info['staff_location_id'];
		$data['staff_status'] 		= $staff_info['staff_status'];
		$data['username'] 			= $user_info['username'];

		$data['staff_groups'] = array();
		$results = $this->Staff_groups_model->getStaffGroups();
		foreach ($results as $result) {
			$data['staff_groups'][] = array(
				'staff_group_id'	=>	$result['staff_group_id'],
				'staff_group_name'	=>	$result['staff_group_name']
			);
		}

		$data['locations'] = array();
		$results = $this->Locations_model->getLocations();
		foreach ($results as $result) {
			$data['locations'][] = array(
				'location_id'	=>	$result['location_id'],
				'location_name'	=>	$result['location_name'],
			);
		}

		$this->template->render('staffs_edit', $data);
	}

	public function autocomplete() {
		$json = array();

		if ($this->input->get('term')) {
			$filter['staff_name'] = $this->input->get('term');
			$filter['staff_id'] = $this->input->get('staff_id');

			$results = $this->Staffs_model->getAutoComplete($filter);
			if ($results) {
				foreach ($results as $result) {
					$json['results'][] = array(
						'id' 		=> $result['staff_id'],
						'text' 		=> utf8_encode($result['staff_name'])
					);
				}
			} else {
				$json['results'] = array('id' => '0', 'text' => $this->lang->line('text_no_match'));
			}
		}

		$this->output->set_output(json_encode($json));
	}

	private function _saveStaff($staff_email, $username) {
        if ($this->validateForm($staff_email, $username) === TRUE) {
            $save_type = ( ! is_numeric($this->input->get('id'))) ? $this->lang->line('text_added') : $this->lang->line('text_updated');

            if ($staff_id = $this->Staffs_model->saveStaff($this->input->get('id'), $this->input->post())) {
                $action = ($this->input->get('id') === $this->user->getStaffId()) ? $save_type.' their' : $save_type;
                $message_lang = ($this->input->get('id') === $this->user->getStaffId()) ? 'activity_custom_no_link' : 'activity_custom';
                $item = ($this->input->get('id') === $this->user->getStaffId()) ? 'details' : $this->input->post('staff_name');

                log_activity($this->user->getStaffId(), $action, 'staffs', get_activity_message($message_lang,
                    array('{staff}', '{action}', '{context}', '{link}', '{item}'),
                    array($this->user->getStaffName(), $action, 'staff', current_url(), $item)
                ));

                $this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Staff '.$save_type));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
			}

			return $staff_id;
		}
	}

	private function _deleteStaff() {
        if ($this->input->post('delete')) {
            $deleted_rows = $this->Staffs_model->deleteStaff($this->input->post('delete'));

            if ($deleted_rows > 0) {
                $prefix = ($deleted_rows > 1) ? '['.$deleted_rows.'] Staffs': 'Staff';
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), $prefix.' '.$this->lang->line('text_deleted')));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_deleted')));
            }

            return TRUE;
        }
	}

	private function validateForm($staff_email = FALSE, $username = FALSE) {
		$this->form_validation->set_rules('staff_name', 'lang:label_name', 'xss_clean|trim|required|min_length[2]|max_length[128]');

		if ($staff_email !== $this->input->post('staff_email')) {
			$this->form_validation->set_rules('staff_email', 'lang:label_email', 'xss_clean|trim|required|max_length[96]|valid_email|is_unique[staffs.staff_email]');
		}

		if ($username !== $this->input->post('username')) {
			$this->form_validation->set_rules('username', 'lang:label_username', 'xss_clean|trim|required|is_unique[users.username]|min_length[2]|max_length[32]');
		}

		$this->form_validation->set_rules('password', 'lang:label_password', 'xss_clean|trim|min_length[6]|max_length[32]|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', 'lang:label_confirm_password', 'xss_clean|trim');

		if (!$this->input->get('id')) {
			$this->form_validation->set_rules('password', 'lang:label_password', 'xss_clean|trim|required|min_length[6]|max_length[32]|matches[password_confirm]');
			$this->form_validation->set_rules('password_confirm', 'lang:label_confirm_password', 'xss_clean|trim|required');
		}

		if ($this->user->hasPermission('Admin.StaffGroups.Manage')) {
			$this->form_validation->set_rules('staff_group_id', 'lang:label_group', 'xss_clean|trim|required|integer');
			$this->form_validation->set_rules('staff_location_id', 'lang:label_location', 'xss_clean|trim|integer');
		}

		$this->form_validation->set_rules('staff_status', 'lang:label_status', 'xss_clean|trim|integer');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file staffs.php */
/* Location: ./admin/controllers/staffs.php */