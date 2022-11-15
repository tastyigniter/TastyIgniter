<?php

namespace Admin\Controllers;

use Admin\Facades\AdminMenu;
use Admin\Models\Staff_groups_model;

class StaffGroups extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model' => 'Admin\Models\Staff_groups_model',
            'title' => 'lang:admin::lang.staff_groups.text_title',
            'emptyMessage' => 'lang:admin::lang.staff_groups.text_empty',
            'defaultSort' => ['staff_group_id', 'DESC'],
            'configFile' => 'staff_groups_model',
        ],
    ];

    public $formConfig = [
        'name' => 'lang:admin::lang.staff_groups.text_form_name',
        'model' => 'Admin\Models\Staff_groups_model',
        'request' => 'Admin\Requests\StaffGroup',
        'create' => [
            'title' => 'lang:admin::lang.form.create_title',
            'redirect' => 'staff_groups/edit/{staff_group_id}',
            'redirectClose' => 'staff_groups',
            'redirectNew' => 'staff_groups/create',
        ],
        'edit' => [
            'title' => 'lang:admin::lang.form.edit_title',
            'redirect' => 'staff_groups/edit/{staff_group_id}',
            'redirectClose' => 'staff_groups',
            'redirectNew' => 'staff_groups/create',
        ],
        'preview' => [
            'title' => 'lang:admin::lang.form.preview_title',
            'redirect' => 'staff_groups',
        ],
        'delete' => [
            'redirect' => 'staff_groups',
        ],
        'configFile' => 'staff_groups_model',
    ];

    protected $requiredPermissions = 'Admin.StaffGroups';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('staffs', 'system');
    }

    public function formAfterSave()
    {
        Staff_groups_model::syncAutoAssignStatus();
    }
}
