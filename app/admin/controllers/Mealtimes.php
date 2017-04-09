<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Mealtimes extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct(); //  calls the constructor

        $this->user->restrict('Admin.Mealtimes');

        $this->load->model('Mealtimes_model');

        $this->lang->load('mealtimes');
    }

    public function index()
    {
        $this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading($this->lang->line('text_heading'));
        $this->template->setButton($this->lang->line('button_save'), ['class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();']);

        $this->assets->setStyleTag(assets_url('js/datepicker/bootstrap-timepicker.css'), 'bootstrap-timepicker-css');
        $this->assets->setScriptTag(assets_url("js/datepicker/bootstrap-timepicker.js"), 'bootstrap-timepicker-js');

        $data = $this->getList();

        $this->template->render('mealtimes', $data);
    }

    public function getList()
    {
        if ($this->input->post() AND $this->_updateMealtimes() === TRUE) {
            $this->redirect();
        }

        if ($this->input->post('mealtimes')) {
            $results = $this->input->post('mealtimes');
        } else {
            $results = $this->Mealtimes_model->getMealtimes();
        }

        $data['mealtimes'] = [];
        foreach ($results as $result) {
            $data['mealtimes'][] = array_merge($result, [
                'mealtime_id' => ($result['mealtime_id'] > 0) ? $result['mealtime_id'] : '0',
                'start_time'  => mdate('%h:%i %A', strtotime($result['start_time'])),
                'end_time'    => mdate('%h:%i %A', strtotime($result['end_time'])),
            ]);
        }

        return $data;
    }

    protected function _updateMealtimes()
    {
        if ($this->input->post('mealtimes') AND $this->validateForm() === TRUE) {
            if ($this->Mealtimes_model->updateMealtimes($this->input->post('mealtimes'))) {
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), $this->lang->line('text_heading').' '.$this->lang->line('text_updated').' '));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), 'updated'));
            }

            return TRUE;
        }
    }

    protected function validateForm()
    {
        if ($this->input->post('mealtimes')) {
            $rules = [];
            foreach ($this->input->post('mealtimes') as $key => $value) {
                $rules[] = ['mealtimes['.$key.'][mealtime_id]', 'lang:label_mealtime_id', 'xss_clean|trim|required|integer'];
                $rules[] = ['mealtimes['.$key.'][mealtime_name]', 'lang:label_mealtime_name', 'xss_clean|trim|required|min_length[2]|max_length[128]'];
                $rules[] = ['mealtimes['.$key.'][start_time]', 'lang:label_start_time', 'xss_clean|trim|required|valid_time'];
                $rules[] = ['mealtimes['.$key.'][end_time]', 'lang:label_end_time', 'xss_clean|trim|required|valid_time'];
                $rules[] = ['mealtimes['.$key.'][mealtime_status]', 'lang:label_mealtime_status', 'xss_clean|trim|required|integer'];
            }

            return $this->form_validation->set_rules($rules)->run();
        }
    }
}

/* End of file Mealtimes.php */
/* Location: ./admin/controllers/Mealtimes.php */