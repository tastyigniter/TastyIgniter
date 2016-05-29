<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Admin_featured_menus extends Admin_Controller {

	public function index($module = array()) {
        $this->load->model('Featured_menus_model'); 														// load the featured menus model
        $this->lang->load('featured_menus/featured_menus');
        $this->user->restrict('Module.FeaturedMenus');

        if (empty($module)) return;

        $title = (isset($module['title'])) ? $module['title'] : $this->lang->line('_text_title');

        $this->template->setTitle('Module: ' . $title);
        $this->template->setHeading('Module: ' . $title);
        $this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
        $this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
        $this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('extensions')));

        if ($this->input->post() AND $this->_updateModule() === TRUE) {
            if ($this->input->post('save_close') === '1') {
                redirect('extensions');
            }

            redirect('extensions/edit/module/featured_menus');
        }

        $ext_data = array();
        if (!empty($module['ext_data']) AND is_array($module['ext_data'])) {
            $ext_data = $module['ext_data'];
        }

        if ($this->input->post('featured_menu')) {
            $filter['menu_ids'] = $this->input->post('featured_menu');
        } else if (!empty($ext_data['featured_menu'])) {
            $filter['menu_ids'] = $ext_data['featured_menu'];
        } else {
            $filter['menu_ids'] = array();
        }

        $filter['page'] = '1';
        $filter['limit'] = $this->config->item('menus_page_limit');

        if ($this->input->post('title')) {
            $data['title'] = $this->input->post('title');
        } else if (!empty($module['title'])) {
            $data['title'] = $module['title'];
        } else {
            $data['title'] = '';
        }

        if ($this->input->post('limit')) {
            $data['limit'] = $this->input->post('limit');
        } else if (isset($ext_data['limit'])) {
            $data['limit'] = $ext_data['limit'];
        } else {
            $data['limit'] = '3';
        }

        if ($this->input->post('items_per_row')) {
            $data['items_per_row'] = $this->input->post('items_per_row');
        } else if (isset($ext_data['items_per_row'])) {
            $data['items_per_row'] = $ext_data['items_per_row'];
        } else {
            $data['items_per_row'] = '3';
        }

        if ($this->input->post('dimension_w')) {
            $data['dimension_w'] = $this->input->post('dimension_w');
        } else if (isset($ext_data['dimension_w'])) {
            $data['dimension_w'] = $ext_data['dimension_w'];
        } else {
            $data['dimension_w'] = '400';
        }

        if ($this->input->post('dimension_h')) {
            $data['dimension_h'] = $this->input->post('dimension_h');
        } else if (isset($ext_data['dimension_h'])) {
            $data['dimension_h'] = $ext_data['dimension_h'];
        } else {
            $data['dimension_h'] = '300';
        }

        $data['dimension_w'] = (isset($ext_data['dimension_w'])) ? $ext_data['dimension_w'] : '400';
        $data['dimension_h'] = (isset($ext_data['dimension_h'])) ? $ext_data['dimension_h'] : '300';

        $data['featured_menus'] = $this->Featured_menus_model->getByIds($filter);

        return $this->load->view('featured_menus/admin_featured_menus', $data, TRUE);
    }

    private function _updateModule() {
        $this->user->restrict('Module.FeaturedMenus.Manage');

        if ($this->validateForm() === TRUE) {

            if ($this->Extensions_model->updateExtension('module', 'featured_menus', $this->input->post())) {
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), $this->lang->line('_text_title').' module '.$this->lang->line('text_updated')));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_updated')));
            }

            return TRUE;
        }
    }

    private function validateForm() {
        $this->form_validation->set_rules('title', 'lang:label_title', 'xss_clean|trim|required|min_length[2]|max_length[128]');
        $this->form_validation->set_rules('featured_menu[]', 'lang:label_menus', 'xss_clean|trim|required|integer');
        $this->form_validation->set_rules('limit', 'lang:label_limit', 'xss_clean|trim|required|integer');
        $this->form_validation->set_rules('dimension_w', 'lang:label_dimension_w', 'xss_clean|trim|required|integer');
        $this->form_validation->set_rules('dimension_h', 'lang:label_dimension_h', 'xss_clean|trim|required|integer');

        if ($this->form_validation->run() === TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}

/* End of file Admin_featured_menus.php */
/* Location: ./extensions/featured_menus/controllers/Admin_featured_menus.php */