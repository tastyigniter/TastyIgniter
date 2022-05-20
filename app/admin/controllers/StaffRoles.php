<?php

namespace Admin\Controllers;

use Admin\Facades\AdminMenu;

class StaffRoles extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model' => 'Admin\Models\Staff_roles_model',
            'title' => 'lang:admin::lang.staff_roles.text_title',
            'emptyMessage' => 'lang:admin::lang.staff_roles.text_empty',
            'defaultSort' => ['staff_role_id', 'DESC'],
            'configFile' => 'staff_roles_model',
        ],
    ];

    public $formConfig = [
        'name' => 'lang:admin::lang.staff_roles.text_form_name',
        'model' => 'Admin\Models\Staff_roles_model',
        'request' => 'Admin\Requests\StaffRole',
        'create' => [
            'title' => 'lang:admin::lang.form.create_title',
            'redirect' => 'staff_roles/edit/{staff_role_id}',
            'redirectClose' => 'staff_roles',
            'redirectNew' => 'staff_roles/create',
        ],
        'edit' => [
            'title' => 'lang:admin::lang.form.edit_title',
            'redirect' => 'staff_roles/edit/{staff_role_id}',
            'redirectClose' => 'staff_roles',
            'redirectNew' => 'staff_roles/create',
        ],
        'preview' => [
            'title' => 'lang:admin::lang.form.preview_title',
            'redirect' => 'staff_roles',
        ],
        'delete' => [
            'redirect' => 'staff_roles',
        ],
        'configFile' => 'staff_roles_model',
    ];

    protected $requiredPermissions = 'Admin.Staffs';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('staffs', 'system');
    }
}
