<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Ratings extends Admin_Controller
{

    public function index()
    {
        $this->user->restrict('Admin.Ratings');

        $this->lang->load('ratings');

        if ($this->input->post() AND $this->_updateRating() === TRUE) {
            $this->redirect();
        }

        $this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading($this->lang->line('text_heading'));
        $this->template->setButton($this->lang->line('button_save'), ['class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();']);

        $this->assets->setScriptTag(assets_url('js/jquery-sortable.js'), 'jquery-sortable-js');

        $data = $this->getList();

        $this->template->render('ratings', $data);
    }

    public function getList()
    {
        if ($this->input->post('ratings')) {
            $results = $this->input->post('ratings');
        } else if ($this->config->item('ratings')) {
            $ratings = $this->config->item('ratings');
            $results = $ratings['ratings'];
        } else {
            $results = '';
        }

        $data['ratings'] = [];
        if (is_array($results)) {
            foreach ($results as $key => $value) {
                $data['ratings'][$key] = $value;
            }
        }

        return $data;
    }

    protected function _updateRating()
    {
        if ($this->input->post('ratings') AND $this->validateForm() === TRUE) {
            $update = [];
            $update['ratings'] = $this->input->post('ratings');

            $this->load->model('Settings_model');
            if ($this->Settings_model->addSetting('ratings', 'ratings', $update, '1')) {
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Rating updated '));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), 'updated'));
            }

            return TRUE;
        }
    }

    protected function validateForm()
    {
        if ($this->input->post('ratings')) {
            $rules = [];
            foreach ($this->input->post('ratings') as $key => $value) {
                $rules[] = ['ratings['.$key.']', 'lang:label_name', 'xss_clean|trim|required|min_length[2]|max_length[32]'];
            }
        }

        return $this->form_validation->set_rules($rules)->run();
    }
}

/* End of file Ratings.php */
/* Location: ./admin/controllers/Ratings.php */