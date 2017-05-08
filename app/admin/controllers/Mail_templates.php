<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Mail_templates extends Admin_Controller
{

    public $defaultTemplate;
    public $update_url = 'mail_templates/update?id={id}';

    public function __construct()
    {
        parent::__construct();

        $this->user->restrict('Admin.MailTemplates');

        $this->load->model('Mail_templates_model');
        $this->load->model('Mail_templates_data_model');
        $this->load->model('Settings_model');

        $this->lang->load('mail_templates');

        $this->defaultTemplate = $this->Mail_templates_model->defaultTemplateId;
    }

    public function index()
    {
        if ($this->input->get('default') == '1' AND $this->input->get('template_id')) {
            $template_id = $this->input->get('template_id');

            if ($this->Settings_model->addSetting('prefs', 'mail_template_id', $template_id, '0')) {
                $this->alert->set('success', $this->lang->line('alert_set_default'));
            }

            $this->redirect();
        }

        if ($this->input->post('delete') AND $this->_deleteTemplate() === TRUE) {
            $this->redirect();
        }

        $this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading($this->lang->line('text_heading'));

        $this->template->setButton($this->lang->line('button_new'), ['class' => 'btn btn-primary', 'href' => page_url().'/edit']);
        $this->template->setButton($this->lang->line('button_delete'), ['class' => 'btn btn-danger', 'onclick' => 'confirmDelete();']);;

        $data = $this->getList();

        $this->template->render('mail_templates', $data);
    }

    public function edit()
    {
        if ($this->input->post() AND $template_id = $this->_saveTemplate()) {
            $this->redirect($template_id);
        }

        $templateModel = $this->Mail_templates_model->findOrNew((int)$this->input->get('id'));

        $title = (isset($templateModel->name)) ? $templateModel->name : $this->lang->line('text_new');
        $this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $title));
        $this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $title));

        $this->template->setButton($this->lang->line('button_save'), ['class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();']);
        $this->template->setButton($this->lang->line('button_save_close'), ['class' => 'btn btn-default', 'onclick' => 'saveClose();']);

        if (is_numeric($templateModel->template_id) AND $templateModel->template_id !== $this->defaultTemplate)
            $this->template->setButton($this->lang->line('button_icon_update'), [
                'class' => 'btn btn-success pull-right',
                'title' => $this->lang->line('text_fetch_changes'),
                'href'  => $this->pageUrl($this->update_url, ['id' => $templateModel->template_id]),
            ]);

        $this->template->setButton($this->lang->line('button_icon_back'), ['class' => 'btn btn-default', 'href' => site_url('mail_templates')]);

        $this->assets->setStyleTag(assets_url('js/summernote/summernote.css'), 'summernote-css');
        $this->assets->setScriptTag(assets_url('js/summernote/summernote.min.js'), 'summernote-js');

        $data = $this->getForm($templateModel);

        $this->template->render('mail_templates_edit', $data);
    }

    public function update()
    {
        if ($this->input->post() AND $template_id = $this->_updateTemplateChanges()) {
            $this->redirect($this->pageUrl($this->edit_url, ['id' => $template_id]));
        }

        $templateModel = $this->Mail_templates_model->findOrNew((int)$this->input->get('id'));

        $title = (isset($templateModel->name)) ? $templateModel->name : $this->lang->line('text_new');
        $this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $title));
        $this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $title));

        $this->template->setButton($this->lang->line('button_save'), ['class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();']);

        $this->assets->setStyleTag(assets_url('js/summernote/summernote.css'), 'summernote-css');
        $this->assets->setScriptTag(assets_url('js/summernote/summernote.min.js'), 'summernote-js');

        $data['_action'] = $this->pageUrl($this->update_url, ['id' => $templateModel->template_id]);

        $data['changes'] = $this->Mail_templates_data_model->fetchChanges($templateModel->template_id);

        $this->template->render('mail_templates_update', $data);
    }

    public function variables()
    {
        $this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $this->lang->line('text_variables')));
        $this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $this->lang->line('text_variables')));

        $data = $this->getVariables();

        $this->output->enable_profiler(FALSE);
        $this->template->render('mail_templates_variables', $data);
    }

    public function getList()
    {
        $data['templates'] = [];
        $results = $this->Mail_templates_model->paginate();
        foreach ($results->list as $result) {
            $default = ($result['template_id'] !== $this->config->item('mail_template_id')) ? $this->pageUrl($this->index_url.'?default=1&template_id='.$result['template_id']) : '1';
            $data['templates'][] = array_merge($result, [
                'date_added'   => mdate('%d %M %y - %H:%i', strtotime($result['date_added'])),
                'date_updated' => mdate('%d %M %y - %H:%i', strtotime($result['date_updated'])),
                'default'      => $default,
                'edit'         => $this->pageUrl($this->edit_url, ['id' => $result['template_id']]),
            ]);
        }

        $data['pagination'] = $results->pagination;

        return $data;
    }

    public function getForm(Mail_templates_model $templateModel)
    {
        $data = $template_info = $templateModel->toArray();

        $template_id = 0;
        $data['_action'] = $this->pageUrl($this->create_url);
        if (!empty($template_info['template_id'])) {
            $template_id = $template_info['template_id'];
            $data['_action'] = $this->pageUrl($this->edit_url, ['id' => $template_id]);
        }

        if ($template_id == $this->defaultTemplate) {
            $this->alert->set('info', $this->lang->line('alert_caution_edit'));
        }

        $data['template_data'] = [];
        $template_data = $this->Mail_templates_model->getAllTemplateData($template_id);
        foreach ($template_data as $tpl_data) {
            $data['template_data'][] = array_merge($tpl_data, [
                'title'        => $tpl_data['title'],
                'date_added'   => mdate('%d %M %y - %H:%i', strtotime($tpl_data['date_added'])),
                'date_updated' => mdate('%d %M %y - %H:%i', strtotime($tpl_data['date_updated'])),
            ]);
        }

        $data['templates'] = $this->Mail_templates_model->isEnabled()->dropdown('name');

        return $data;
    }

    protected function _saveTemplate()
    {
        if ($this->validateForm() === TRUE) {
            $save_type = (!is_numeric($this->input->get('id'))) ? $this->lang->line('text_added') : $this->lang->line('text_updated');
            if ($template_id = $this->Mail_templates_model->saveTemplate($this->input->get('id'), $this->input->post())) {
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Mail Template '.$save_type));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
            }

            return $template_id;
        }
    }

    protected function _updateTemplateChanges()
    {
        if ($this->Mail_templates_data_model->updateChanges($this->input->get('id'), $this->input->post())) {
            $this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Mail Template '.$this->lang->line('text_updated')));
        } else {
            $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_updated')));
        }

        return $this->input->get('id');
    }

    protected function _deleteTemplate()
    {
        if ($this->input->post('delete')) {
            $deleted_rows = $this->Mail_templates_model->deleteTemplate($this->input->post('delete'));
            if ($deleted_rows > 0) {
                $prefix = ($deleted_rows > 1) ? '['.$deleted_rows.'] Mail Templates' : 'Mail Template';
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), $prefix.' '.$this->lang->line('text_deleted')));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_deleted')));
            }

            return TRUE;
        }
    }

    protected function validateForm()
    {
        $rules[] = ['name', 'lang:label_name', 'xss_clean|trim|required|min_length[2]|max_length[32]'];

        if (!$this->input->get('id')) {
            $rules[] = ['clone_template_id', 'lang:label_clone', 'xss_clean|trim|required|integer'];
        }

        $rules[] = ['language_id', 'lang:label_language', 'xss_clean|trim|required|integer'];
        $rules[] = ['status', 'lang:label_status', 'xss_clean|trim|required|integer'];

        if ($this->input->post('templates')) {
            foreach ($this->input->post('templates') as $key => $value) {
                $rules[] = ['templates['.$key.'][code]', 'lang:label_code', 'xss_clean|trim|required'];
                $rules[] = ['templates['.$key.'][subject]', 'lang:label_subject', 'xss_clean|trim|required|min_length[2]|max_length[128]'];
                $rules[] = ['templates['.$key.'][body]', 'lang:label_body', 'trim|required|min_length[3]'];
            }
        }

        return $this->form_validation->set_rules($rules)->run();
    }

    protected function getVariables()
    {
        $data['filters'] = [
            'General'            => ['registration', 'registration_alert', 'password_reset', 'password_reset_alert', 'password_reset_request', 'password_reset_request_alert', 'order', 'order_alert', 'order_update', 'reservation', 'reservation_alert', 'reservation_update', 'internal', 'contact'],
            'Customer'           => ['registration', 'registration_alert', 'password_reset', 'password_reset_alert', 'password_reset_request', 'password_reset_request_alert', 'order', 'order_alert', 'order_update', 'reservation', 'reservation_alert', 'reservation_update'],
            'Staff'              => ['password_reset_alert', 'order', 'order_alert', 'order_update', 'reservation', 'reservation_alert', 'reservation_update'],
            'Registration/Reset' => ['registration', 'registration_alert', 'password_reset_request', 'password_reset_request_alert', 'password_reset', 'password_reset_alert'],
            'Order'              => ['order', 'order_alert', 'order_update'],
            'Reservation'        => ['reservation', 'reservation_alert', 'reservation_update'],
            'Status'             => ['order', 'order_alert', 'order_update', 'reservation', 'reservation_alert', 'reservation_update'],
            'Contact'            => ['contact'],
        ];

        $data['variables'] = [
            'General'            => [
                ['var' => '{site_name}', 'name' => 'Site name'],
                ['var' => '{site_logo}', 'name' => 'Site logo'],
                ['var' => '{site_url}', 'name' => 'Site URL'],
                ['var' => '{signature}', 'name' => 'Signature'],
                ['var' => '{location_name}', 'name' => 'Location name'],
            ],
            'Customer'           => [
                ['var' => '{full_name}', 'name' => 'Customer full name'],
                ['var' => '{first_name}', 'name' => 'Customer first name'],
                ['var' => '{last_name}', 'name' => 'Customer last name'],
                ['var' => '{email}', 'name' => 'Customer email address'],
                ['var' => '{telephone}', 'name' => 'Customer telephone address'],
            ],
            'Staff'              => [
                ['var' => '{staff_name}', 'name' => 'Staff name'],
                ['var' => '{staff_username}', 'name' => 'Staff username'],
            ],
            'Registration/Reset' => [
                ['var' => '{account_login_link}', 'name' => 'Account login link'],
                ['var' => '{reset_password}', 'name' => 'Created password on password reset'],
            ],
            'Order'              => [
                ['var' => '{order_number}', 'name' => 'Order number'],
                ['var' => '{order_view_url}', 'name' => 'Order view URL'],
                ['var' => '{order_type}', 'name' => 'Order type ex. delivery/pick-up'],
                ['var' => '{order_time}', 'name' => 'Order delivery/pick-up time'],
                ['var' => '{order_date}', 'name' => 'Order delivery/pick-up date'],
                ['var' => '{order_address}', 'name' => 'Customer address for delivery order'],
                ['var' => '{order_payment}', 'name' => 'Order payment method'],
                ['var' => '{order_menus}', 'name' => 'Order menus  - START iteration'],
                ['var' => '{menu_name}', 'name' => 'Order menu name'],
                ['var' => '{menu_quantity}', 'name' => 'Order menu quantity'],
                ['var' => '{menu_price}', 'name' => 'Order menu price'],
                ['var' => '{menu_subtotal}', 'name' => 'Order menu subtotal'],
                ['var' => '{menu_options}', 'name' => 'Order menu option ex. name: price'],
                ['var' => '{menu_comment}', 'name' => 'Order menu comment'],
                ['var' => '{/order_menus}', 'name' => 'Order menus  - END iteration'],
                ['var' => '{order_totals}', 'name' => 'Order total pairs - START iteration'],
                ['var' => '{order_total_title}', 'name' => 'Order total title'],
                ['var' => '{order_total_value}', 'name' => 'Order total value'],
                ['var' => '{/order_totals}', 'name' => 'Order total pairs - END iteration'],
                ['var' => '{order_comment}', 'name' => 'Order comment'],
            ],
            'Reservation'        => [
                ['var' => '{reservation_number}', 'name' => 'Reservation number'],
                ['var' => '{reservation_view_url}', 'name' => 'Reservation view URL'],
                ['var' => '{reservation_date}', 'name' => 'Reservation date'],
                ['var' => '{reservation_time}', 'name' => 'Reservation time'],
                ['var' => '{reservation_guest_no}', 'name' => 'No. of guest reserved'],
                ['var' => '{reservation_comment}', 'name' => 'Reservation comment'],
            ],
            'Status'             => [
                ['var' => '{status_name}', 'name' => 'Status name'],
                ['var' => '{status_comment}', 'name' => 'Status comment'],
            ],
            'Contact'            => [
                ['var' => '{contact_topic}', 'name' => 'Contact topic'],
                ['var' => '{contact_telephone}', 'name' => 'Contact telephone'],
                ['var' => '{contact_message}', 'name' => 'Contact message body'],
            ],
        ];

        return $data;
    }
}

/* End of file Mail_templates.php */
/* Location: ./admin/controllers/Mail_templates.php */