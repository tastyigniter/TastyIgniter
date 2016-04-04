<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Uri_routes extends Admin_Controller {

    public function __construct() {
		parent::__construct();
        $this->user->restrict('Admin.UriRoutes');
        $this->load->model('Layouts_model');

        $this->alert->set('warning', 'URI Routes Page disabled for improvement in next release');
        redirect('dashboard');
	}

	public function index() {
		$this->template->setTitle('URI Routes');
		$this->template->setHeading('URI Routes');
		$this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));

		$this->template->setScriptTag(assets_url('js/jquery-sortable.js'), 'jquery-sortable-js');

		if ($this->input->post() AND $this->_updateRoute() === TRUE){
			redirect('uri_routes');
		}

		if ($this->input->post('routes')) {
			$routes = $this->input->post('routes');
		} else {
			$routes = $this->Layouts_model->getRoutes();
		}

		$data['routes'] = array();
		foreach ($routes as $route) {

			$data['routes'][] = array(
				'uri_route'		=> $route['uri_route'],
				'controller' 	=> $route['controller'],
			);
		}

		$this->template->render('uri_routes', $data);
	}

	private function _updateRoute() {
    	if ($this->input->post('routes') AND $this->validateForm() === TRUE) {
			$update = array();

			$update = $this->input->post('routes');

			if ($this->Layouts_model->updateRoutes($update)) {
				$this->alert->set('success', 'URI Routes updated successfully.');
			} else {
				$this->alert->set('warning', 'An error occurred, nothing updated.');
			}

			return TRUE;
		}
	}

	private function validateForm() {
		if ($this->input->post('routes')) {
			foreach ($this->input->post('routes') as $key => $value) {
				$this->form_validation->set_rules('routes['.$key.'][uri_route]', 'URI Route', 'xss_clean|trim|required|min_length[2]|max_length[255]');
				$this->form_validation->set_rules('routes['.$key.'][controller]', 'Controller', 'xss_clean|trim|required|min_length[2]|max_length[128]');
			}
		}

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file uri_routes.php */
/* Location: ./admin/controllers/uri_routes.php */