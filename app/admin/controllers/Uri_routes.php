<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Uri_routes extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->user->restrict('Admin.UriRoutes');

        $this->load->model('Layouts_model');

        $this->alert->set('warning', 'URI Routes Page disabled for improvement in next release');
        $this->redirect();
    }

    public function index()
    {
        if ($this->input->post() AND $this->_updateRoute() === TRUE) {
            $this->redirect();
        }

        $this->template->setTitle('URI Routes');
        $this->template->setHeading('URI Routes');
        $this->template->setButton($this->lang->line('button_save'), ['class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();']);

        $this->assets->setScriptTag(assets_url('js/jquery-sortable.js'), 'jquery-sortable-js');

        $data = $this->getList();

        $this->template->render('uri_routes', $data);
    }

    public function getList()
    {
        if ($this->input->post('routes')) {
            $data['routes'] = $this->input->post('routes');
        } else {
            $data['routes'] = $this->Layouts_model->getRoutes();
        }

        return $data;
    }

    protected function _updateRoute()
    {
        if ($this->input->post('routes') AND $this->validateForm() === TRUE) {
            $update = [];

            $update = $this->input->post('routes');

            if ($this->Layouts_model->updateRoutes($update)) {
                $this->alert->set('success', 'URI Routes updated successfully.');
            } else {
                $this->alert->set('warning', 'An error occurred, nothing updated.');
            }

            return TRUE;
        }
    }

    protected function validateForm()
    {
        if ($this->input->post('routes')) {
            $rules = [];
            foreach ($this->input->post('routes') as $key => $value) {
                $rules[] = ['routes['.$key.'][uri_route]', 'URI Route', 'xss_clean|trim|required|min_length[2]|max_length[255]'];
                $rules[] = ['routes['.$key.'][controller]', 'Controller', 'xss_clean|trim|required|min_length[2]|max_length[128]'];
            }

            return $this->form_validation->set_rules($rules)->run();
        }
    }
}

/* End of file Uri_routes.php */
/* Location: ./admin/controllers/Uri_routes.php */