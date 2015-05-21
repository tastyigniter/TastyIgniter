<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Layouts extends Admin_Controller {

    public $_permission_rules = array('access[index|edit]', 'modify[index|edit]');

    public function __construct() {
		parent::__construct();
		$this->load->model('Layouts_model');
		$this->load->model('Extensions_model');
	}

	public function index() {
		$this->template->setTitle('Layouts');
		$this->template->setHeading('Layouts');
		$this->template->setButton('+ New', array('class' => 'btn btn-primary', 'href' => page_url() .'/edit'));
		$this->template->setButton('Delete', array('class' => 'btn btn-danger', 'onclick' => '$(\'#list-form\').submit();'));

		$data['text_empty'] 		= 'There are no layouts available.';

		$data['layouts'] = array();
		$results = $this->Layouts_model->getLayouts();
		foreach ($results as $result) {
			$data['layouts'][] = array(
				'layout_id'		=> $result['layout_id'],
				'name'			=> $result['name'],
				'edit' 			=> site_url('layouts/edit?id=' . $result['layout_id'])
			);
		}

		$data['uri_routes'] = array();
		$results = $this->Layouts_model->getRoutes(1);
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
		$layout_info = $this->Layouts_model->getLayout((int) $this->input->get('id'));

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

        $data['layout_positions'] = array('top' => 'Content Top', 'left' => 'Content Left', 'right' => 'Content Right', 'bottom' => 'Content Bottom');

        if ($this->input->post('modules')) {
            $layout_modules = $this->input->post('modules');
        } else {
            $layout_modules = $this->Layouts_model->getLayoutModules($layout_id);
        }

        $data['layout_modules'] = array();
        foreach ($layout_modules as $priority => $module) {
            $data['layout_modules'][] = array(
                'module_code'       => $module['module_code'],
                'position' 		    => $module['position'],
                'priority' 		    => !empty($module['priority']) ? $module['priority'] : $priority,
                'status' 		    => $module['status']
            );
        }

        if ($this->input->post('routes')) {
            $data['layout_routes'] = $this->input->post('routes');
        } else {
            $data['layout_routes'] = $this->Layouts_model->getLayoutRoutes($layout_id);
        }

        $data['modules'] = array();
        $results = $this->Extensions_model->getModules();
        foreach ($results as $result) {
            $data['modules'][] = array(
                'extension_id'	=> $result['extension_id'],
                'module_code'	=> $result['name'],
                'title'			=> $result['title']
            );
        }

        $data['routes'] = array();
		$results = $this->Layouts_model->getRoutes(1);
		foreach ($results as $result) {
			$data['routes'][] = array(
				'route_id'		=> $result['uri_route_id'],
				'route'			=> $result['uri_route']
			);
		}

		if ($this->input->post() AND $layout_id = $this->_saveLayout()) {
			if ($this->input->post('save_close') === '1') {
				redirect('layouts');
			}

			redirect('layouts/edit?id='. $layout_id);
		}

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('layouts_edit', $data);
	}

	public function _saveLayout() {
    	if ($this->validateForm() === TRUE) {
            $save_type = (! is_numeric($this->input->get('id'))) ? 'added' : 'updated';

			if ($layout_id = $this->Layouts_model->saveLayout($this->input->get('id'), $this->input->post())) {
				$this->alert->set('success', 'Layout ' . $save_type . ' successfully.');
			} else {
				$this->alert->set('warning', 'An error occurred, nothing ' . $save_type . '.');
			}

			return $layout_id;
		}
	}

	public function _deleteLayout() {
    	if (is_array($this->input->post('delete'))) {
			foreach ($this->input->post('delete') as $key => $value) {
				$this->Layouts_model->deleteLayout($value);
			}

			$this->alert->set('success', 'Layout deleted successfully!');
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

        if ($this->input->post('modules')) {
            foreach ($this->input->post('modules') as $key => $value) {
                $this->form_validation->set_rules('modules['.$key.'][module_code]', 'Module ['.$key.'] code', 'xss_clean|trim|required|alpha_dash');
                $this->form_validation->set_rules('modules['.$key.'][position]', 'Module ['.$key.'] position', 'xss_clean|trim|required|alpha');
                $this->form_validation->set_rules('modules['.$key.'][priority]', 'Module ['.$key.'] priority', 'xss_clean|trim|required|integer');
                $this->form_validation->set_rules('modules['.$key.'][status]', 'Module ['.$key.'] status', 'xss_clean|trim|required|integer');
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