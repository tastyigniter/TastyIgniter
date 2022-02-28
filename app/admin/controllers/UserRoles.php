<?php

namespace Admin\Controllers;

use Admin\Facades\AdminMenu;

class UserRoles extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model' => 'Admin\Models\UserRole',
            'title' => 'lang:admin::lang.user_roles.text_title',
            'emptyMessage' => 'lang:admin::lang.user_roles.text_empty',
            'defaultSort' => ['user_role_id', 'DESC'],
            'configFile' => 'userrole',
        ],
    ];

    public $formConfig = [
        'name' => 'lang:admin::lang.user_roles.text_form_name',
        'model' => 'Admin\Models\UserRole',
        'request' => 'Admin\Requests\UserRole',
        'create' => [
            'title' => 'lang:admin::lang.form.create_title',
            'redirect' => 'user_roles/edit/{user_role_id}',
            'redirectClose' => 'user_roles',
            'redirectNew' => 'user_roles/create',
        ],
        'edit' => [
            'title' => 'lang:admin::lang.form.edit_title',
            'redirect' => 'user_roles/edit/{user_role_id}',
            'redirectClose' => 'user_roles',
            'redirectNew' => 'user_roles/create',
        ],
        'preview' => [
            'title' => 'lang:admin::lang.form.preview_title',
            'redirect' => 'user_roles',
        ],
        'delete' => [
            'redirect' => 'user_roles',
        ],
        'configFile' => 'userrole',
    ];

    protected $requiredPermissions = 'Admin.Staffs';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('users', 'system');
    }
}
