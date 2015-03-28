<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Tables extends Admin_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		$this->load->library('pagination');
		$this->load->model('Tables_model');
	}

	public function index() {
		if (!$this->user->islogged()) {
  			redirect('login');
		}

    	if (!$this->user->hasPermissions('access', 'tables')) {
  			redirect('permission');
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
			$filter['sort_by'] = $data['sort_by'] = 'table_id';
		}

		if ($this->input->get('order_by')) {
			$filter['order_by'] = $data['order_by'] = $this->input->get('order_by');
			$data['order_by_active'] = $this->input->get('order_by') .' active';
		} else {
			$filter['order_by'] = $data['order_by'] = 'ASC';
			$data['order_by_active'] = 'ASC';
		}

		$this->template->setTitle('Tables');
		$this->template->setHeading('Tables');
		$this->template->setButton('+ New', array('class' => 'btn btn-primary', 'href' => page_url() .'/edit'));
		$this->template->setButton('Delete', array('class' => 'btn btn-danger', 'onclick' => '$(\'#list-form\').submit();'));

		$data['text_empty'] 		= 'There are no tables available.';

		$order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'ASC') ? 'DESC' : 'ASC';
		$data['sort_name'] 			= site_url('tables'.$url.'sort_by=table_name&order_by='.$order_by);
		$data['sort_min'] 			= site_url('tables'.$url.'sort_by=min_capacity&order_by='.$order_by);
		$data['sort_cap'] 			= site_url('tables'.$url.'sort_by=max_capacity&order_by='.$order_by);
		$data['sort_id'] 			= site_url('tables'.$url.'sort_by=table_id&order_by='.$order_by);

		$data['tables'] = array();
		$results = $this->Tables_model->getList($filter);
		foreach ($results as $result) {
			$data['tables'][] = array(
				'table_id'			=> $result['table_id'],
				'table_name'		=> $result['table_name'],
				'min_capacity'		=> $result['min_capacity'],
				'max_capacity'		=> $result['max_capacity'],
				'table_status'		=> ($result['table_status'] == '1') ? 'Enabled' : 'Disabled',
				'edit'				=> site_url('tables/edit?id=' . $result['table_id'])
			);
		}

		if ($this->input->get('sort_by') AND $this->input->get('order_by')) {
			$url .= 'sort_by='.$filter['sort_by'].'&';
			$url .= 'order_by='.$filter['order_by'].'&';
		}

		$config['base_url'] 		= site_url('tables').$url;
		$config['total_rows'] 		= $this->Tables_model->getCount($filter);
		$config['per_page'] 		= $filter['limit'];

		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		if ($this->input->post('delete') AND $this->_deleteTable() === TRUE) {
			redirect('tables');
		}

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('tables', $data);
	}

	public function edit() {
		if (!$this->user->islogged()) {
  			redirect('login');
		}

    	if (!$this->user->hasPermissions('access', 'tables')) {
  			redirect('permission');
		}

		$table_info = $this->Tables_model->getTable((int) $this->input->get('id'));

		if ($table_info) {
			$table_id = $table_info['table_id'];
			$data['action']	= site_url('tables/edit?id='. $table_id);
		} else {
		    $table_id = 0;
			$data['action']	= site_url('tables/edit');
		}

		$title = (isset($table_info['table_name'])) ? $table_info['table_name'] : 'New';
		$this->template->setTitle('Table: '. $title);
		$this->template->setHeading('Table: '. $title);
		$this->template->setButton('Save', array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton('Save & Close', array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setBackButton('btn btn-back', site_url('tables'));


		$data['table_id'] 			= $table_info['table_id'];
		$data['table_name'] 		= $table_info['table_name'];
		$data['min_capacity'] 		= $table_info['min_capacity'];
		$data['max_capacity'] 		= $table_info['max_capacity'];
		$data['table_status'] 		= $table_info['table_status'];

		if ($this->input->post() AND $this->_addTable() === TRUE) {
			if ($this->input->post('save_close') !== '1' AND is_numeric($this->input->post('insert_id'))) {
				redirect('tables/edit?id='. $this->input->post('insert_id'));
			} else {
				redirect('tables');
			}
		}

		if ($this->input->post() AND $this->_updateTable() === TRUE) {
			if ($this->input->post('save_close') === '1') {
				redirect('tables');
			}

			redirect('tables/edit?id='. $table_id);
		}

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('tables_edit', $data);
	}

	public function autocomplete() {
		$json = array();

		if ($this->input->get('term')) {
			$filter = array(
				'table_name' => $this->input->get('term')
			);

			$results = $this->Tables_model->getAutoComplete($filter);

			if ($results) {
				foreach ($results as $result) {
					$json['results'][] = array(
						'id' 		=> $result['table_id'],
						'text' 		=> utf8_encode($result['table_name']),
						'min' 		=> $result['min_capacity'],
						'max' 		=> $result['max_capacity']
					);
				}
			} else {
				$json['results'] = array('id' => '0', 'text' => 'No Matches Found');
			}
		}

		$this->output->set_output(json_encode($json));
	}

	public function _addTable() {

    	if (!$this->user->hasPermissions('modify', 'tables')) {

			$this->alert->set('warning', 'Warning: You do not have permission to add!');
			return TRUE;

    	} else if ( ! is_numeric($this->input->get('id')) AND $this->validateForm() === TRUE) {
			$add = array();

			$add['table_name'] 		= $this->input->post('table_name');
			$add['min_capacity'] 	= $this->input->post('min_capacity');
			$add['max_capacity'] 	= $this->input->post('max_capacity');
			$add['table_status'] 	= $this->input->post('table_status');

			if ($_POST['insert_id'] = $this->Tables_model->addTable($add)) {
				$this->alert->set('success', 'Table added sucessfully.');
			} else {
				$this->alert->set('warning', 'An error occured, nothing added.');
			}

			return TRUE;
		}
	}

	public function _updateTable() {
    	if (!$this->user->hasPermissions('modify', 'tables')) {
			$this->alert->set('warning', 'Warning: You do not have permission to update!');
			return TRUE;
    	} else if (is_numeric($this->input->get('id')) AND $this->validateForm() === TRUE) {
			$update = array();

			$update['table_id'] 		= $this->input->get('id');
			$update['table_name'] 		= $this->input->post('table_name');
			$update['min_capacity'] 	= $this->input->post('min_capacity');
			$update['max_capacity'] 	= $this->input->post('max_capacity');
			$update['table_status'] 	= $this->input->post('table_status');

			if ($this->Tables_model->updateTable($update)) {
				$this->alert->set('success', 'Table updated sucessfully.');
			} else {
				$this->alert->set('warning', 'An error occured, nothing updated.');
			}

			return TRUE;
		}
	}

	public function _deleteTable() {
    	if (!$this->user->hasPermissions('modify', 'tables')) {
			$this->alert->set('warning', 'Warning: You do not have permission to delete!');
    	} else if (is_array($this->input->post('delete'))) {
			foreach ($this->input->post('delete') as $key => $value) {
				$this->Tables_model->deleteTable($value);
			}

			$this->alert->set('success', 'Table(s) deleted sucessfully!');
		}

		return TRUE;
	}

	public function validateForm() {
		$this->form_validation->set_rules('table_name', 'Name', 'xss_clean|trim|required|min_length[2]|max_length[255]');
		$this->form_validation->set_rules('min_capacity', 'Minimum', 'xss_clean|trim|required|integer|greater_than[1]');
		$this->form_validation->set_rules('max_capacity', 'Capacity', 'xss_clean|trim|required|integer|greater_than[1]|callback_check_capacity');
		$this->form_validation->set_rules('table_status', 'Status', 'xss_clean|trim|required|integer');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function check_capacity($str) {
    	if ($str < $_POST['min_capacity']) {
			$this->form_validation->set_message('check_capacity', 'The Maximum capacity value must be greater than minimum capacity value.');
			return FALSE;
		}

		return TRUE;
	}
}

/* End of file tables.php */
/* Location: ./admin/controllers/tables.php */