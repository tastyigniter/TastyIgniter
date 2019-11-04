<?php namespace System\Controllers;

use AdminMenu;
use System\Models\Permissions_model;

class Permissions extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model' => 'System\Models\Permissions_model',
            'title' => 'lang:system::lang.permissions.text_title',
            'emptyMessage' => 'lang:system::lang.permissions.text_empty',
            'defaultSort' => ['permission_id', 'DESC'],
            'configFile' => 'permissions_model',
        ],
    ];

    public $formConfig = [
        'name' => 'lang:system::lang.permissions.text_form_name',
        'model' => 'System\Models\Permissions_model',
        'request' => 'System\Requests\Permission',
        'create' => [
            'title' => 'lang:admin::lang.form.create_title',
            'redirect' => 'permissions/edit/{permission_id}',
            'redirectClose' => 'permissions',
        ],
        'edit' => [
            'title' => 'lang:admin::lang.form.edit_title',
            'redirect' => 'permissions/edit/{permission_id}',
            'redirectClose' => 'permissions',
        ],
        'preview' => [
            'title' => 'lang:admin::lang.form.preview_title',
            'redirect' => 'permissions',
        ],
        'delete' => [
            'redirect' => 'permissions',
        ],
        'configFile' => 'permissions_model',
    ];

    protected $requiredPermissions = 'Admin.Permissions';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('staffs', 'users');
    }

    public function index()
    {
        if ($this->getUser()->hasPermission('Admin.Permissions.Manage'))
            Permissions_model::syncAll();

        $this->asExtension('ListController')->index();
    }

    public function formExtendFields($form)
    {
        if ($form->context != 'create') {
            $field = $form->getField('name');
            $field->disabled = TRUE;
        }
    }

    public function formBeforeSave($model)
    {
        $model->is_custom = TRUE;
    }
}