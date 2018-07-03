<?php namespace Admin\Controllers;

use AdminMenu;

class StaffGroups extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model'        => 'Admin\Models\Staff_groups_model',
            'title'        => 'lang:admin::lang.staff_groups.text_title',
            'emptyMessage' => 'lang:admin::lang.staff_groups.text_empty',
            'defaultSort'  => ['staff_group_id', 'DESC'],
            'configFile'   => 'staff_groups_model',
        ],
    ];

    public $formConfig = [
        'name'       => 'lang:admin::lang.staff_groups.text_form_name',
        'model'      => 'Admin\Models\Staff_groups_model',
        'create'     => [
            'title'         => 'lang:admin::lang.form.create_title',
            'redirect'      => 'staff_groups/edit/{staff_group_id}',
            'redirectClose' => 'staff_groups',
        ],
        'edit'       => [
            'title'         => 'lang:admin::lang.form.edit_title',
            'redirect'      => 'staff_groups/edit/{staff_group_id}',
            'redirectClose' => 'staff_groups',
        ],
        'preview'    => [
            'title'    => 'lang:admin::lang.form.preview_title',
            'redirect' => 'staff_groups',
        ],
        'delete'     => [
            'redirect' => 'staff_groups',
        ],
        'configFile' => 'staff_groups_model',
    ];

    protected $requiredPermissions = 'Admin.StaffGroups';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('staff_groups', 'users');
    }

    public function formValidate($model, $form)
    {
        $rules = [
            ['staff_group_name', 'lang:admin::lang.staff_groups.label_name', 'required|min:2|max:32'],
            ['customer_account_access', 'lang:admin::lang.staff_groups.label_customer_account_access', 'required|integer'],
            ['location_access', 'lang:admin::lang.staff_groups.label_location_access', 'required|integer'],
        ];

        $rules[] = ['permissions.*.*', 'Permission', 'string'];

        return $this->validatePasses($form->getSaveData(), $rules);
    }
}