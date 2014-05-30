<?php
class Customer_groups extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		$this->load->library('pagination');
		$this->load->model('Customer_groups_model');
	}

	public function index() {
			
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/customer_groups')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

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
		$this->template->setButton('+ New', array('class' => 'add_button', 'href' => page_url() .'/edit'));
		$this->template->setButton('Delete', array('class' => 'delete_button', 'onclick' => '$(\'form:not(#filter-form)\').submit();'));

		$data['text_empty'] 		= 'There is no customer group available.';

		$order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'ASC') ? 'DESC' : 'ASC';
		$data['sort_id'] 			= site_url('admin/customer_groups'.$url.'sort_by=customer_group_id&order_by='.$order_by);

		$data['customer_group_id'] 	= $this->config->item('customer_group_id');

		$data['customer_groups'] = array();
		$results = $this->Customer_groups_model->getList($filter);
		foreach ($results as $result) {					
			$data['customer_groups'][] = array(
				'customer_group_id'		=> $result['customer_group_id'],
				'group_name'			=> $result['group_name'],
				'edit'					=> site_url('admin/customer_groups/edit?id=' . $result['customer_group_id'])
			);
		}

		if ($this->input->get('sort_by') AND $this->input->get('order_by')) {
			$url .= 'sort_by='.$filter['sort_by'].'&';
			$url .= 'order_by='.$filter['order_by'].'&';
		}
		
		$config['base_url'] 		= site_url('admin/customer_groups').$url;
		$config['total_rows'] 		= $this->Customer_groups_model->record_count($filter);
		$config['per_page'] 		= $filter['limit'];
		
		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		if ($this->input->post('delete') AND $this->_deleteCustomerGroup() === TRUE) {
		    redirect('admin/customer_groups');
		}	

		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'customer_groups.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'customer_groups', $data);
		} else {
			$this->template->render('themes/admin/default/', 'customer_groups', $data);
		}
	}

	public function edit() {
			
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/customer_groups')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		if (is_numeric($this->input->get('id'))) {
			$customer_group_id = $this->input->get('id');
			$data['action']	= site_url('admin/customer_groups/edit?id='. $customer_group_id);
		} else {
		    $customer_group_id = 0;
			$data['action']	= site_url('admin/customer_groups/edit');
		}

		$result = $this->Customer_groups_model->getCustomerGroup($customer_group_id);
		
		$title = (isset($result['group_name'])) ? 'Edit - '. $result['group_name'] : 'New';	
		$this->template->setTitle('Customer Group: '. $title);
		$this->template->setHeading('Customer Group: '. $title);
		$this->template->setButton('Save', array('class' => 'save_button', 'onclick' => '$(\'form\').submit();'));
		$this->template->setButton('Save & Close', array('class' => 'save_close_button', 'onclick' => 'saveClose();'));
		$this->template->setBackButton('back_button', site_url('admin/customer_groups'));

		$data['customer_group_id'] 	= $result['customer_group_id'];
		$data['group_name'] 		= $result['group_name'];
		$data['approval'] 			= $result['approval'];
		$data['description'] 		= $result['description'];

		if ($this->input->post() AND $this->_addCustomerGroup() === TRUE) {
			if ($this->input->post('save_close') !== '1' AND is_numeric($this->input->post('insert_id'))) {	
				redirect('admin/customer_groups/edit?id='. $this->input->post('insert_id'));
			} else {
				redirect('admin/customer_groups');
			}
		}

		if ($this->input->post() AND $this->_updateCustomerGroup() === TRUE) {
			if ($this->input->post('save_close') === '1') {
				redirect('admin/customer_groups');
			}
			
			redirect('admin/customer_groups/edit?id='. $customer_group_id);
		}
		
		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'customer_groups_edit.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'customer_groups_edit', $data);
		} else {
			$this->template->render('themes/admin/default/', 'customer_groups_edit', $data);
		}
	}

	public function _addCustomerGroup() {
    	if (!$this->user->hasPermissions('modify', 'admin/customer_groups')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to add!</p>');
  			return TRUE;
    	} else if ( ! is_numeric($this->input->get('id')) AND $this->validateForm() === TRUE) { 
			$add = array();

			$add['group_name']	= $this->input->post('group_name');
			$add['approval']	= $this->input->post('approval');
			$add['description']	= $this->input->post('description');
			
			if ($_POST['insert_id'] = $this->Customer_groups_model->addCustomerGroup($add)) {
				$this->session->set_flashdata('alert', '<p class="success">Customer Groups added sucessfully.</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="warning">An error occured, nothing updated.</p>');
			}
		
			return TRUE;
		}
	}

	public function _updateCustomerGroup() {
    	if (!$this->user->hasPermissions('modify', 'admin/customer_groups')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to update!</p>');
  			return TRUE;
    	} else if (is_numeric($this->input->get('id')) AND $this->validateForm() === TRUE) { 
			$update = array();

			$update['customer_group_id']	= $this->input->get('id');
			$update['group_name']			= $this->input->post('group_name');
			$update['approval']				= $this->input->post('approval');
			$update['description']			= $this->input->post('description');
		
			if ($this->Customer_groups_model->updateCustomerGroup($update)) {
				$this->session->set_flashdata('alert', '<p class="success">Customer Group updated sucessfully.</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="warning">An error occured, nothing updated.</p>');
			}
		
			return TRUE;
		}
	}	

	public function _deleteCustomerGroup() {
    	if (!$this->user->hasPermissions('modify', 'admin/customer_groups')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to delete!</p>');
    	} else if (is_array($this->input->post('delete'))) {
			foreach ($this->input->post('delete') as $key => $value) {
				$this->Customer_groups_model->deleteCustomerGroup($value);
			}			
		
			$this->session->set_flashdata('alert', '<p class="success">Customer Group(s) deleted sucessfully!</p>');
		}
				
		return TRUE;
	}
	
	public function validateForm() {
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
/* Location: ./application/controllers/admin/customer_groups.php */