<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Controller Class Countries
 */
class Countries extends Admin_Controller
{
    public $filter = [
        'filter_search' => '',
        'filter_status' => '',
    ];

    public $default_sort = ['country_name', 'ASC'];

    public $sort = ['country_name', 'iso_code_2', 'iso_code_3'];

    public function __construct()
    {
        parent::__construct(); //  calls the constructor

        $this->user->restrict('Site.Countries');

        $this->load->model('Countries_model');
        $this->load->model('Image_tool_model');

        $this->lang->load('countries');
    }

    public function index()
    {
        $this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading($this->lang->line('text_heading'));
        $this->template->setButton($this->lang->line('button_new'), ['class' => 'btn btn-primary', 'href' => page_url().'/edit']);
        $this->template->setButton($this->lang->line('button_delete'), ['class' => 'btn btn-danger', 'onclick' => 'confirmDelete();']);;
        $this->template->setButton($this->lang->line('button_icon_filter'), ['class' => 'btn btn-default btn-filter pull-right', 'data-toggle' => 'button']);

        if ($this->input->post('delete') AND $this->_deleteCountry() === TRUE) {
            $this->redirect();
        }

        $data = $this->getList();

        $this->template->render('countries', $data);
    }

    public function edit()
    {
        if ($this->input->post() AND $country_id = $this->_saveCountry()) {
            $this->redirect($country_id);
        }

        $countryModel = $this->Countries_model->findOrNew((int)$this->input->get('id'));

        $title = (isset($countryModel->country_name)) ? $countryModel->country_name : $this->lang->line('text_new');
        $this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $title));
        $this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $title));

        $this->template->setButton($this->lang->line('button_save'), ['class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();']);
        $this->template->setButton($this->lang->line('button_save_close'), ['class' => 'btn btn-default', 'onclick' => 'saveClose();']);
        $this->template->setButton($this->lang->line('button_icon_back'), ['class' => 'btn btn-default', 'href' => site_url('countries')]);

        $data = $this->getFrom($countryModel);

        $this->template->render('countries_edit', $data);
    }

    public function getList()
    {
        $data = array_merge($this->getFilter(), $this->getSort());

        $data['country_id'] = $this->config->item('country_id');

        $no_country_flag = $this->Image_tool_model->resize('data/flags/no_flag.png');

        $data['countries'] = [];
        $results = $this->Countries_model->paginateWithFilter($this->getFilter());
        foreach ($results->list as $result) {
            $data['countries'][] = array_merge($result, [
                'flag' => (!empty($result['flag'])) ? $this->Image_tool_model->resize($result['flag']) : $no_country_flag,
                'edit' => $this->pageUrl($this->edit_url, ['id' => $result['country_id']]),
            ]);
        }

        $data['pagination'] = $results->pagination;

        return $data;
    }

    protected function getFrom(Countries_model $countryModel)
    {
        $data = $country_info = $countryModel->toArray();

        $data['_action'] = $this->pageUrl($this->create_url);
        if (!empty($country_info['country_id'])) {
            $data['_action'] = $this->pageUrl($this->edit_url, ['id' => $country_info['country_id']]);
        }

        $data['no_photo'] = $this->Image_tool_model->resize('data/flags/no_flag.png');

        $data['flag'] = [];
        if ($this->input->post('flag')) {
            $data['flag']['path'] = $this->Image_tool_model->resize($this->input->post('flag'));
            $data['flag']['name'] = basename($this->input->post('flag'));
            $data['flag']['input'] = $this->input->post('flag');
        } else if (!empty($country_info['flag'])) {
            $data['flag']['path'] = $this->Image_tool_model->resize($country_info['flag']);
            $data['flag']['name'] = basename($country_info['flag']);
            $data['flag']['input'] = $country_info['flag'];
        } else {
            $data['flag']['path'] = $this->Image_tool_model->resize('data/flags/no_flag.png');
            $data['flag']['name'] = 'no_flag.png';
            $data['flag']['input'] = 'data/flags/no_flag.png';
        }

        return $data;
    }

    protected function _saveCountry()
    {
        if ($this->validateForm() === TRUE) {
            $save_type = (!is_numeric($this->input->get('id'))) ? $this->lang->line('text_added') : $this->lang->line('text_updated');
            if ($country_id = $this->Countries_model->saveCountry($this->input->get('id'), $this->input->post())) {
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Country '.$save_type));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
            }

            return $country_id;
        }
    }

    protected function _deleteCountry()
    {
        if ($this->input->post('delete')) {
            $deleted_rows = $this->Countries_model->deleteCountry($this->input->post('delete'));
            if ($deleted_rows > 0) {
                $prefix = ($deleted_rows > 1) ? '['.$deleted_rows.'] Countries' : 'Country';
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), $prefix.' '.$this->lang->line('text_deleted')));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_deleted')));
            }

            return TRUE;
        }
    }

    protected function validateForm()
    {
        $rules = [
            ['country_name', 'lang:label_name', 'xss_clean|trim|required|min_length[2]|max_length[128]'],
            ['iso_code_2', 'lang:label_iso_code2', 'xss_clean|trim|required|exact_length[2]'],
            ['iso_code_3', 'lang:label_iso_code3', 'xss_clean|trim|required|exact_length[3]'],
            ['flag', 'lang:label_flag', 'xss_clean|trim|required'],
            ['format', 'lang:label_format', 'xss_clean|trim|min_length[2]'],
            ['status', 'lang:label_status', 'xss_clean|trim|required|integer'],
        ];

        return $this->form_validation->set_rules($rules)->run();
    }
}

/* End of file Countries.php */
/* Location: ./admin/controllers/Countries.php */