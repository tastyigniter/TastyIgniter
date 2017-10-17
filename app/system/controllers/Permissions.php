<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Permissions extends Admin_Controller {

    public function __construct() {
		parent::__construct(); //  calls the constructor

        $this->user->restrict('Admin.Permissions');

        $this->load->model('Permissions_model');

        $this->load->library('pagination');

        $this->lang->load('permissions');
    }

	public function index() {
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

		if (is_numeric($this->input->get('filter_status'))) {
			$filter['filter_status'] = $data['filter_status'] = $this->input->get('filter_status');
			$url .= 'filter_status='.$filter['filter_status'].'&';
		} else {
			$filter['filter_status'] = $data['filter_status'] = '';
		}

		if ($this->input->get('sort_by')) {
			$filter['sort_by'] = $data['sort_by'] = $this->input->get('sort_by');
		} else {
			$filter['sort_by'] = $data['sort_by'] = 'permission_id';
		}

		if ($this->input->get('order_by')) {
			$filter['order_by'] = $data['order_by'] = $this->input->get('order_by');
			$data['order_by_active'] = $this->input->get('order_by') .' active';
		} else {
			$filter['order_by'] = $data['order_by'] = 'ASC';
			$data['order_by_active'] = 'ASC';
		}

        $this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading($this->lang->line('text_heading'));
		$this->template->setButton($this->lang->line('button_new'), array('class' => 'btn btn-primary', 'href' => page_url() .'/edit'));
		$this->template->setButton($this->lang->line('button_delete'), array('class' => 'btn btn-danger', 'onclick' => 'confirmDelete();'));;

		if ($this->input->post('delete') AND $this->_deletePermission() === TRUE) {
			redirect('permissions');
		}

		$order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'ASC') ? 'DESC' : 'ASC';
		$data['sort_name'] 			= site_url('permissions'.$url.'sort_by=name&order_by='.$order_by);
		$data['sort_status'] 		= site_url('permissions'.$url.'sort_by=status&order_by='.$order_by);
		$data['sort_id'] 			= site_url('permissions'.$url.'sort_by=permission_id&order_by='.$order_by);

		$data['permissions'] = array();
		$results = $this->Permissions_model->getList($filter);
		foreach ($results as $result) {
			$data['permissions'][] = array(
				'permission_id'		=> $result['permission_id'],
				'name'		        => $result['name'],
				'description'		=> $result['description'],
				'action'    		=> (!empty($result['action'])) ? ucwords(implode(' | ', unserialize($result['action']))) : '',
				'status'		    => ($result['status'] == '1') ? 'Enabled' : 'Disabled',
				'edit'				=> site_url('permissions/edit?id=' . $result['permission_id'])
			);
		}

		if ($this->input->get('sort_by') AND $this->input->get('order_by')) {
			$url .= 'sort_by='.$filter['sort_by'].'&';
			$url .= 'order_by='.$filter['order_by'].'&';
		}

		$config['base_url'] 		= site_url('permissions'.$url);
		$config['total_rows'] 		= $this->Permissions_model->getCount($filter);
		$config['per_page'] 		= $filter['limit'];

		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		$this->template->render('permissions', $data);
	}

	public function edit() {
		$permission_info = $this->Permissions_model->getPermission((int) $this->input->get('id'));

		if ($permission_info) {
			$permission_id = $permission_info['permission_id'];
			$data['_action']	= site_url('permissions/edit?id='. $permission_id);
		} else {
		    $permission_id = 0;
			$data['_action']	= site_url('permissions/edit');
		}

		$title = (isset($permission_info['name'])) ? $permission_info['name'] : $this->lang->line('text_new');
        $this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $title));
        $this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $title));

        $this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('permissions')));

		if ($this->input->post() AND $permission_id = $this->_savePermission()) {
			if ($this->input->post('save_close') === '1') {
				redirect('permissions');
			}

			redirect('permissions/edit?id='. $permission_id);
		}

		$data['permission_id'] 		= $permission_info['permission_id'];
		$data['name'] 		        = $permission_info['name'];
		$data['description'] 		= $permission_info['description'];
		$data['status'] 		    = $permission_info['status'];

        if ($this->input->post('action')) {
            $data['action'] = $this->input->post('action');
        } else if (!empty($permission_info['action'])) {
            $data['action'] = unserialize($permission_info['action']);
        } else {
            $data['action'] = array();
        }

        $data['permission_actions'] = array('access' => $this->lang->line('text_access'), 'manage' => $this->lang->line('text_manage'), 'add' => $this->lang->line('text_add'), 'delete' => $this->lang->line('text_delete'));

		$this->template->render('permissions_edit', $data);
	}

	private function _savePermission() {
    	if ($this->validateForm() === TRUE) {
            $save_type = ( ! is_numeric($this->input->get('id'))) ? $this->lang->line('text_added') : $this->lang->line('text_updated');

			if ($permission_id = $this->Permissions_model->savePermission($this->input->get('id'), $this->input->post())) {
                log_activity($this->user->getStaffId(), $save_type, 'permissions', get_activity_message('activity_custom_no_link',
                    array('{staff}', '{action}', '{context}', '{item}'),
                    array($this->user->getStaffName(), $save_type, 'permission', $this->input->post('name'))
                ));

                $this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Permission '.$save_type));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
			}

			return $permission_id;
		}
	}

	private function _deletePermission() {
        if ($this->input->post('delete')) {
            $deleted_rows = $this->Permissions_model->deletePermission($this->input->post('delete'));

            if ($deleted_rows > 0) {
                $prefix = ($deleted_rows > 1) ? '['.$deleted_rows.'] Permissions': 'Permission';
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), $prefix.' '.$this->lang->line('text_deleted')));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_deleted')));
            }

            return TRUE;
        }
	}

	private function validateForm() {
		$this->form_validation->set_rules('name', 'lang:label_name', 'xss_clean|trim|required|min_length[2]|max_length[128]');
		$this->form_validation->set_rules('description', 'lang:label_description', 'xss_clean|trim|required|max_length[255]');
		$this->form_validation->set_rules('status', 'lang:label_status', 'xss_clean|trim|required|integer');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file permissions.php */
/* Location: ./admin/controllers/permissions.php */