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
            'defaultSort' => ['country_name', 'ASC'],
            'configFile' => 'permissions_model',
        ],
    ];

    public $formConfig = [
        'name' => 'lang:system::lang.permissions.text_form_name',
        'model' => 'System\Models\Permissions_model',
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

        AdminMenu::setContext('permissions', 'users');
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

    public function formValidate($model, $form)
    {
        $rules[] = ['name', 'lang:system::lang.permissions.label_name', 'required|min:2|max:128'];
        $rules[] = ['description', 'lang:system::lang.permissions.label_description', 'required|max:255'];
        $rules[] = ['action.*', 'lang:system::lang.permissions.label_action', 'required|alpha'];
        $rules[] = ['status', 'lang:admin::lang.label_status', 'required|integer'];

        $this->validateAfter(function ($validator) {
            if ($message = $this->permissionNameIsInvalid()) {
                $validator->errors()->add('name', $message);
            }
        });

        return $this->validatePasses($form->getSaveData(), $rules);
    }

    protected function permissionNameIsInvalid()
    {
        $name = explode('.', post('Permission.name'));
        if (count($name) != 2) {
            return lang('system::lang.permissions.error_invalid_name');
        }

        return FALSE;
    }
}