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
            'model'        => 'System\Models\Permissions_model',
            'title'        => 'lang:system::permissions.text_title',
            'emptyMessage' => 'lang:system::permissions.text_empty',
            'defaultSort'  => ['country_name', 'ASC'],
            'configFile'   => 'permissions_model',
        ],
    ];

    public $formConfig = [
        'name'       => 'lang:system::permissions.text_form_name',
        'model'      => 'System\Models\Permissions_model',
        'create'     => [
            'title'         => 'lang:admin::default.form.create_title',
            'redirect'      => 'permissions/edit/{permission_id}',
            'redirectClose' => 'permissions',
        ],
        'edit'       => [
            'title'         => 'lang:admin::default.form.edit_title',
            'redirect'      => 'permissions/edit/{permission_id}',
            'redirectClose' => 'permissions',
        ],
        'preview'    => [
            'title'    => 'lang:admin::default.form.preview_title',
            'redirect' => 'permissions',
        ],
        'delete'     => [
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

    public function formBeforeCreate($model)
    {
        $model->is_custom = TRUE;
    }

    public function formValidate($model, $form)
    {
        $rules[] = ['name', 'lang:system::permissions.label_name', 'required|min:2|max:128'];
        $rules[] = ['description', 'lang:system::permissions.label_description', 'required|max:255'];
        $rules[] = ['action.*', 'lang:system::permissions.label_action', 'required|alpha'];
        $rules[] = ['status', 'lang:admin::default.label_status', 'required|integer'];

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
            return lang('system::permissions.error_invalid_name');
        }

        return FALSE;
    }
}