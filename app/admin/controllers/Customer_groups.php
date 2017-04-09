<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Customer_groups extends Admin_Controller
{
    public $default_sort = ['customer_group_id', 'DESC'];

    public $sort = ['customer_group_id'];

    public function __construct()
    {
        parent::__construct(); //  calls the constructor

        $this->user->restrict('Admin.CustomerGroups');

        $this->load->model('Customer_groups_model');

        $this->lang->load('customer_groups');
    }

    public function index()
    {
        if ($this->input->post('delete') AND $this->_deleteCustomerGroup() === TRUE) {
            $this->redirect();
        }

        $this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading($this->lang->line('text_heading'));
        $this->template->setButton($this->lang->line('button_new'), ['class' => 'btn btn-primary', 'href' => page_url().'/edit']);
        $this->template->setButton($this->lang->line('button_delete'), ['class' => 'btn btn-danger', 'onclick' => 'confirmDelete();']);;

        $data = $this->getList();

        $this->template->render('customer_groups', $data);
    }

    public function edit()
    {
        if ($this->input->post() AND $customer_group_id = $this->_saveCustomerGroup()) {
            $this->redirect($customer_group_id);
        }

        $customerGroupModel = $this->Customer_groups_model->findOrNew((int)$this->input->get('id'));

        $title = (isset($customerGroupModel->group_name)) ? $customerGroupModel->group_name : $this->lang->line('text_new');
        $this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $title));
        $this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $title));

        $this->template->setButton($this->lang->line('button_save'), ['class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();']);
        $this->template->setButton($this->lang->line('button_save_close'), ['class' => 'btn btn-default', 'onclick' => 'saveClose();']);
        $this->template->setButton($this->lang->line('button_icon_back'), ['class' => 'btn btn-default', 'href' => site_url('customer_groups')]);

        $data = $this->getForm($customerGroupModel);

        $this->template->render('customer_groups_edit', $data);
    }

    public function getList()
    {
        $data = array_merge($this->getFilter(), $this->getSort());

        $data['customer_group_id'] = $this->config->item('customer_group_id');

        $data['customer_groups'] = [];
        $results = $this->Customer_groups_model->paginateWithFilter($this->getFilter());
        foreach ($results->list as $result) {
            $data['customer_groups'][] = array_merge($result, [
                'customers_count' => $this->Customer_groups_model->getCustomersCount($result['customer_group_id']),
                'edit'            => $this->pageUrl($this->edit_url, ['id' => $result['customer_group_id']]),
            ]);
        }

        $data['pagination'] = $results->pagination;

        return $data;
    }

    public function getForm(Customer_groups_model $customerGroupModel)
    {
        $data = $group_info = $customerGroupModel->toArray();

        $data['_action'] = $this->pageUrl($this->create_url);
        if (!empty($group_info['customer_group_id'])) {
            $data['_action'] = $this->pageUrl($this->edit_url, ['id' => $group_info['customer_group_id']]);
        }

        return $data;
    }

    protected function _saveCustomerGroup()
    {
        if ($this->validateForm() === TRUE) {
            $save_type = (!is_numeric($this->input->get('id'))) ? $this->lang->line('text_added') : $this->lang->line('text_updated');
            if ($customer_group_id = $this->Customer_groups_model->saveCustomerGroup($this->input->get('id'), $this->input->post())) {
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Customer Groups '.$save_type));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
            }

            return $customer_group_id;
        }
    }

    protected function _deleteCustomerGroup()
    {
        if ($this->input->post('delete')) {
            $deleted_rows = $this->Customer_groups_model->deleteCustomerGroup($this->input->post('delete'));
            if ($deleted_rows > 0) {
                $prefix = ($deleted_rows > 1) ? '['.$deleted_rows.'] Currencies' : 'Currency';
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
            ['group_name', 'lang:label_name', 'xss_clean|trim|required|min_length[2]|max_length[32]'],
            ['approval', 'lang:label_approval', 'xss_clean|trim|required|integer'],
            ['description', 'lang:label_description', 'xss_clean|trim|min_length[2]|max_length[1028]'],
        ];

        return $this->form_validation->set_rules($rules)->run();
    }
}

/* End of file Customer_groups.php */
/* Location: ./admin/controllers/Customer_groups.php */