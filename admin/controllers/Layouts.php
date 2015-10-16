<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Layouts extends Admin_Controller {

    public function __construct() {
		parent::__construct();

        $this->user->restrict('Site.Layouts');

        $this->load->model('Layouts_model');

        $this->load->model('Extensions_model');

        $this->lang->load('layouts');
    }

	public function index() {
        $this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading($this->lang->line('text_heading'));
		$this->template->setButton($this->lang->line('button_new'), array('class' => 'btn btn-primary', 'href' => page_url() .'/edit'));
		$this->template->setButton($this->lang->line('button_delete'), array('class' => 'btn btn-danger', 'onclick' => '$(\'#list-form\').submit();'));

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

		$this->template->render('layouts', $data);
	}

	public function edit() {
		$layout_info = $this->Layouts_model->getLayout((int) $this->input->get('id'));

		if ($layout_info) {
			$layout_id = $layout_info['layout_id'];
			$data['_action']	= site_url('layouts/edit?id='. $layout_id);
		} else {
		    $layout_id = 0;
			$data['_action']	= site_url('layouts/edit');
		}

		$title = (isset($layout_info['name'])) ? $layout_info['name'] : $this->lang->line('text_new');
        $this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $title));
        $this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $title));

        $this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('layouts')));

		$data['layout_id'] 			= $layout_info['layout_id'];
		$data['name'] 				= $layout_info['name'];

		$theme_partials = get_theme_partials($this->config->item('main', 'default_themes'), 'main');
        foreach ($theme_partials as $partial) {
            $partial['id'] = isset($partial['id']) ? $partial['id'] : '';
            $deprecated_id = explode('_', $partial['id']);
            $partial['deprecated_id'] = isset($deprecated_id['1']) ? $deprecated_id['1'] : ''; // support @DEPRECATED position key

            $partial['name'] = isset($partial['name']) ? $partial['name'] : '';

            $data['theme_partials'][] = $partial;
        }

        if ($this->input->post('modules')) {
            $layout_modules = $this->input->post('modules');
        } else {
            $layout_modules = $this->Layouts_model->getLayoutModules($layout_id);
        }

        $data['layout_modules'] = array();
        foreach ($layout_modules as $priority => $module) {
            $data['layout_modules'][] = array(
                'module_code'       => $module['module_code'],
                'partial' 		    => !empty($module['position']) ? $module['position'] : $module['partial'], // position key @DEPRECATED starting from v1.4.0
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
                'title'			=> $result['title'],
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

		$this->template->render('layouts_edit', $data);
	}

	private function _saveLayout() {
    	if ($this->validateForm() === TRUE) {
            $save_type = (! is_numeric($this->input->get('id'))) ? $this->lang->line('text_added') : $this->lang->line('text_updated');

			if ($layout_id = $this->Layouts_model->saveLayout($this->input->get('id'), $this->input->post())) {
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Layout '.$save_type));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
			}

			return $layout_id;
		}
	}

	private function _deleteLayout() {
        if ($this->input->post('delete')) {
            $deleted_rows = $this->Layouts_model->deleteLayout($this->input->post('delete'));

            if ($deleted_rows > 0) {
                $prefix = ($deleted_rows > 1) ? '['.$deleted_rows.'] Layouts': 'Layout';
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), $prefix.' '.$this->lang->line('text_deleted')));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_deleted')));
            }

            return TRUE;
        }
	}

	private function validateForm() {
		$this->form_validation->set_rules('name', 'lang:label_name', 'xss_clean|trim|required|min_length[2]|max_length[128]');

        if ($this->input->post('routes')) {
            foreach ($this->input->post('routes') as $key => $value) {
                $this->form_validation->set_rules('routes['.$key.'][uri_route]', 'lang:label_route', 'xss_clean|trim|required');
            }
        }

        if ($this->input->post('modules')) {
            foreach ($this->input->post('modules') as $key => $value) {
                $this->form_validation->set_rules('modules['.$key.'][module_code]', '['.$key.'] lang:label_module_code', 'xss_clean|trim|required|alpha_dash');
                $this->form_validation->set_rules('modules['.$key.'][partial]', '['.$key.'] lang:label_module_partial', 'xss_clean|trim|required|alpha_dash');
                $this->form_validation->set_rules('modules['.$key.'][priority]', '['.$key.'] lang:label_module_priority', 'xss_clean|trim|required|integer');
                $this->form_validation->set_rules('modules['.$key.'][status]', '['.$key.'] lang:label_module_status', 'xss_clean|trim|required|integer');
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