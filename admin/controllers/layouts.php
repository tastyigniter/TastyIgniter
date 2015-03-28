<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Layouts extends Admin_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('user');
		$this->load->model('Design_model');
	}

	public function index() {
		if (!$this->user->islogged()) {
  			redirect('login');
		}

    	if (!$this->user->hasPermissions('access', 'layouts')) {
  			redirect('permission');
		}

		$this->template->setTitle('Layouts');
		$this->template->setHeading('Layouts');
		$this->template->setButton('+ New', array('class' => 'btn btn-primary', 'href' => page_url() .'/edit'));
		$this->template->setButton('Delete', array('class' => 'btn btn-danger', 'onclick' => '$(\'#list-form\').submit();'));

		$data['text_empty'] 		= 'There are no layouts available.';

		$data['layouts'] = array();
		$results = $this->Design_model->getLayouts();
		foreach ($results as $result) {
			$data['layouts'][] = array(
				'layout_id'		=> $result['layout_id'],
				'name'			=> $result['name'],
				'edit' 			=> site_url('layouts/edit?id=' . $result['layout_id'])
			);
		}

		$data['uri_routes'] = array();
		$results = $this->Design_model->getRoutes(1);
		foreach ($results as $result) {
			$data['uri_routes'][] = array(
				'uri_route_id'		=> $result['uri_route_id'],
				'uri_route'			=> $result['uri_route']
			);
		}

		if ($this->input->post('delete') AND $this->_deleteLayout() === TRUE) {

			redirect('layouts');
		}

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('layouts', $data);
	}

	public function edit() {
		if (!$this->user->islogged()) {
  			redirect('login');
		}

    	if (!$this->user->hasPermissions('access', 'layouts')) {
  			redirect('permission');
		}

		$layout_info = $this->Design_model->getLayout((int) $this->input->get('id'));

		if ($layout_info) {
			$layout_id = $layout_info['layout_id'];
			$data['action']	= site_url('layouts/edit?id='. $layout_id);
		} else {
		    $layout_id = 0;
			$data['action']	= site_url('layouts/edit');
		}

		$title = (isset($layout_info['name'])) ? $layout_info['name'] : 'New';
		$this->template->setTitle('Layout: '. $title);
		$this->template->setHeading('Layout: '. $title);
		$this->template->setButton('Save', array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton('Save & Close', array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setBackButton('btn btn-back', site_url('layouts'));

		$data['layout_id'] 			= $layout_info['layout_id'];
		$data['name'] 				= $layout_info['name'];

		if ($this->input->post('routes')) {
			$data['routes'] = $this->input->post('routes');
		} else {
			$data['routes'] = $this->Design_model->getLayoutRoutes($layout_info['layout_id']);
		}

		$data['uri_routes'] = array();
		$results = $this->Design_model->getRoutes(1);
		foreach ($results as $result) {
			$data['uri_routes'][] = array(
				'uri_route_id'		=> $result['uri_route_id'],
				'uri_route'			=> $result['uri_route']
			);
		}

		if ($this->input->post() AND $this->_addLayout() === TRUE) {
			if ($this->input->post('save_close') !== '1' AND is_numeric($this->input->post('insert_id'))) {
				redirect('layouts/edit?id='. $this->input->post('insert_id'));
			} else {
				redirect('layouts');
			}
		}

		if ($this->input->post() AND $this->_updateLayout() === TRUE) {
			if ($this->input->post('save_close') === '1') {
				redirect('layouts');
			}

			redirect('layouts/edit?id='. $layout_id);
		}

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('layouts_edit', $data);
	}

	public function _addLayout() {
    	if ( ! $this->user->hasPermissions('modify', 'layouts')) {
			$this->alert->set('warning', 'Warning: You do not have permission to add!');
  			return TRUE;
    	} else if ( ! is_numeric($this->input->get('id')) AND $this->validateForm() === TRUE) {
			$add = array();

			$add['name'] 		= $this->input->post('name');
			$add['routes'] 		= $this->input->post('routes');

			if ($_POST['insert_id'] = $this->Design_model->addLayout($add)) {
				$this->alert->set('success', 'Layout added sucessfully.');
			} else {
				$this->alert->set('warning', 'An error occured, nothing added.');
			}

			return TRUE;
		}
	}

	public function _updateLayout() {
    	if ( ! $this->user->hasPermissions('modify', 'layouts')) {
			$this->alert->set('warning', 'Warning: You do not have permission to update!');
  			return TRUE;
    	} else if (is_numeric($this->input->get('id')) AND $this->validateForm() === TRUE) {
			$update = array();

			$update['layout_id'] 	= $this->input->get('id');
			$update['name'] 		= $this->input->post('name');
			$update['routes'] 		= $this->input->post('routes');

			if ($this->Design_model->updateLayout($update)) {
				$this->alert->set('success', 'Layout updated sucessfully.');
			} else {
				$this->alert->set('warning', 'An error occured, nothing added.');
			}

			return TRUE;
		}
	}

	public function _deleteLayout() {
    	if (!$this->user->hasPermissions('modify', 'layouts')) {
			$this->alert->set('warning', 'Warning: You do not have permission to delete!');
    	} else if (is_array($this->input->post('delete'))) {
			foreach ($this->input->post('delete') as $key => $value) {
				$this->Design_model->deleteLayout($value);
			}

			$this->alert->set('success', 'Layout deleted sucessfully!');
		}

		return TRUE;
	}

	public function validateForm() {
		$this->form_validation->set_rules('name', 'Name', 'xss_clean|trim|required|min_length[2]|max_length[128]');

		if ($this->input->post('routes')) {
			foreach ($this->input->post('routes') as $key => $value) {
				$this->form_validation->set_rules('routes['.$key.'][uri_route]', 'Route', 'xss_clean|trim|required');
			}
		}

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file layouts.php */
/* Location: ./admin/controllers/layouts.php */