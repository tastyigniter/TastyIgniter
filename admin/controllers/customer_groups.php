<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Customer_groups extends Admin_Controller {

    public $_permission_rules = array('access[index|edit]', 'modify[index|edit]');

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('pagination');
		$this->load->model('Customer_groups_model');
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


		if ($this->input->get('sort_by')) {
			$filter['sort_by'] = $data['sort_by'] = $this->input->get('sort_by');
		} else {
			$filter['sort_by'] = $data['sort_by'] = 'customer_group_id';
		}

		if ($this->input->get('order_by')) {
			$filter['order_by'] = $data['order_by'] = $this->input->get('order_by');
			$data['order_by_active'] = $this->input->get('order_by') .' active';
		} else {
			$filter['order_by'] = $data['order_by'] = 'DESC';
			$data['order_by_active'] = '';
		}

		$this->template->setTitle('Customer Groups');
		$this->template->setHeading('Customer Groups');
		$this->template->setButton('+ New', array('class' => 'btn btn-primary', 'href' => page_url() .'/edit'));
		$this->template->setButton('Delete', array('class' => 'btn btn-danger', 'onclick' => '$(\'#list-form\').submit();'));

		$data['text_empty'] 		= 'There is no customer group available.';

		$order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'ASC') ? 'DESC' : 'ASC';
		$data['sort_id'] 			= site_url('customer_groups'.$url.'sort_by=customer_group_id&order_by='.$order_by);

		$data['customer_group_id'] 	= $this->config->item('customer_group_id');

		$data['customer_groups'] = array();
		$results = $this->Customer_groups_model->getList($filter);
		foreach ($results as $result) {
			$data['customer_groups'][] = array(
				'customer_group_id'		=> $result['customer_group_id'],
				'group_name'			=> $result['group_name'],
				'edit'					=> site_url('customer_groups/edit?id=' . $result['customer_group_id'])
			);
		}

		if ($this->input->get('sort_by') AND $this->input->get('order_by')) {
			$url .= 'sort_by='.$filter['sort_by'].'&';
			$url .= 'order_by='.$filter['order_by'].'&';
		}

		$config['base_url'] 		= site_url('customer_groups').$url;
		$config['total_rows'] 		= $this->Customer_groups_model->getCount($filter);
		$config['per_page'] 		= $filter['limit'];

		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		if ($this->input->post('delete') AND $this->_deleteCustomerGroup() === TRUE) {
		    redirect('customer_groups');
		}

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('customer_groups', $data);
	}

	public function edit() {
		$group_info = $this->Customer_groups_model->getCustomerGroup((int) $this->input->get('id'));

		if ($group_info) {
			$customer_group_id = $group_info['customer_group_id'];
			$data['action']	= site_url('customer_groups/edit?id='. $customer_group_id);
		} else {
		    $customer_group_id = 0;
			$data['action']	= site_url('customer_groups/edit');
		}

		$title = (isset($group_info['group_name'])) ? $group_info['group_name'] : 'New';
		$this->template->setTitle('Customer Group: '. $title);
		$this->template->setHeading('Customer Group: '. $title);
		$this->template->setButton('Save', array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton('Save & Close', array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setBackButton('btn btn-back', site_url('customer_groups'));

		$data['customer_group_id'] 	= $group_info['customer_group_id'];
		$data['group_name'] 		= $group_info['group_name'];
		$data['approval'] 			= $group_info['approval'];
		$data['description'] 		= $group_info['description'];

		if ($this->input->post() AND $customer_group_id = $this->_saveCustomerGroup()) {
			if ($this->input->post('save_close') === '1') {
				redirect('customer_groups');
			}

			redirect('customer_groups/edit?id='. $customer_group_id);
		}

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('customer_groups_edit', $data);
	}

	private function _saveCustomerGroup() {
    	if ($this->validateForm() === TRUE) {
            $save_type = ( ! is_numeric($this->input->get('id'))) ? 'added' : 'updated';

			if ($customer_group_id = $this->Customer_groups_model->saveCustomerGroup($this->input->get('id'), $this->input->post())) {
				$this->alert->set('success', 'Customer Groups ' . $save_type . ' successfully.');
			} else {
                $this->alert->set('warning', 'An error occurred, nothing ' . $save_type . '.');
			}

			return $customer_group_id;
		}
	}

	private function _deleteCustomerGroup() {
        if ($this->input->post('delete')) {
            $deleted_rows = $this->Customer_groups_model->deleteCustomerGroup($this->input->post('delete'));

            if ($deleted_rows > 0) {
                $prefix = ($deleted_rows > 1) ? '['.$deleted_rows.'] Currencies': 'Currency';
                $this->alert->set('success', $prefix.' deleted successfully.');
            } else {
                $this->alert->set('warning', 'An error occurred, nothing deleted.');
            }

            return TRUE;
        }
	}

	private function validateForm() {
		$this->form_validation->set_rules('group_name', 'Name', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('approval', 'Approval', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('description', 'Description', 'xss_clean|trim|min_length[2]|max_length[1028]');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file customer_groups.php */
/* Location: ./admin/controllers/customer_groups.php */