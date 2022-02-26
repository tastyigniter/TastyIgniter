<?php

namespace Admin\Controllers;

use Admin\Facades\AdminMenu;
use Admin\Models\UserGroup;

class UserGroups extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model' => 'Admin\Models\UserGroup',
            'title' => 'lang:admin::lang.user_groups.text_title',
            'emptyMessage' => 'lang:admin::lang.user_groups.text_empty',
            'defaultSort' => ['user_group_id', 'DESC'],
            'configFile' => 'staffgroup',
        ],
    ];

    public $formConfig = [
        'name' => 'lang:admin::lang.user_groups.text_form_name',
        'model' => 'Admin\Models\UserGroup',
        'request' => 'Admin\Requests\UserGroup',
        'create' => [
            'title' => 'lang:admin::lang.form.create_title',
            'redirect' => 'user_groups/edit/{user_group_id}',
            'redirectClose' => 'user_groups',
            'redirectNew' => 'user_groups/create',
        ],
        'edit' => [
            'title' => 'lang:admin::lang.form.edit_title',
            'redirect' => 'user_groups/edit/{user_group_id}',
            'redirectClose' => 'user_groups',
            'redirectNew' => 'user_groups/create',
        ],
        'preview' => [
            'title' => 'lang:admin::lang.form.preview_title',
            'redirect' => 'user_groups',
        ],
        'delete' => [
            'redirect' => 'user_groups',
        ],
        'configFile' => 'staffgroup',
    ];

    protected $requiredPermissions = 'Admin.StaffGroups';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('staffs', 'users');
    }

    public function formAfterSave()
    {
        UserGroup::syncAutoAssignStatus();
    }
}
