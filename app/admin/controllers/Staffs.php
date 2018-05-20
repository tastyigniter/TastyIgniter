<?php namespace Admin\Controllers;

use AdminAuth;
use AdminMenu;

class Staffs extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model'        => 'Admin\Models\Staffs_model',
            'title'        => 'lang:admin::staffs.text_title',
            'emptyMessage' => 'lang:admin::staffs.text_empty',
            'defaultSort'  => ['staff_id', 'DESC'],
            'configFile'   => 'staffs_model',
        ],
    ];

    public $formConfig = [
        'name'       => 'lang:admin::staffs.text_form_name',
        'model'      => 'Admin\Models\Staffs_model',
        'create'     => [
            'title'         => 'lang:admin::default.form.create_title',
            'redirect'      => 'staffs/edit/{staff_id}',
            'redirectClose' => 'staffs',
        ],
        'edit'       => [
            'title'         => 'lang:admin::default.form.edit_title',
            'redirect'      => 'staffs/edit/{staff_id}',
            'redirectClose' => 'staffs',
        ],
        'preview'    => [
            'title'    => 'lang:admin::default.form.preview_title',
            'redirect' => 'staffs',
        ],
        'delete'     => [
            'redirect' => 'staffs',
        ],
        'configFile' => 'staffs_model',
    ];

    protected $requiredPermissions = 'Admin.Staffs';

    public function __construct()
    {
        parent::__construct();

        if ($this->action == 'edit' AND AdminAuth::getStaffId() == current($this->params))
            $this->requiredPermissions = null;

        AdminMenu::setContext('staffs', 'users');
    }

    public function formExtendFields($form, $fields)
    {
        if (!AdminAuth::isSuperUser()) {
            $form->removeField('staff_group_id');
            $form->removeField('staff_location_id');
            $form->removeField('user[username]');
            $form->removeField('user[super_user]');
            $form->removeField('staff_status');
        }
    }

    public function formValidate($model, $form)
    {
        $rules = [
            ['staff_name', 'lang:admin::staffs.label_name', 'required|min:2|max:128'],
            ['staff_email', 'lang:admin::staffs.label_email', 'required|max:96|email'
                .($form->context == 'create' ? '|unique:staffs,staff_email' : '')],
        ];

        $rules[] = ['user.password', 'lang:admin::staffs.label_password', 'sometimes|min:6|max:32|same:user.password_confirm'];
        $rules[] = ['user.password_confirm', 'lang:admin::staffs.label_confirm_password'];

        if (AdminAuth::isSuperUser()) {
            $rules[] = ['user.username', 'lang:admin::staffs.label_username', 'required|min:2|max:32'
                .($form->context == 'create' ? '|unique:users,username' : '')];
            $rules[] = ['staff_status', 'lang:admin::default.label_status', 'integer'];
            $rules[] = ['staff_group_id', 'lang:admin::staffs.label_group', 'required|integer'];
            $rules[] = ['staff_location_id', 'lang:admin::staffs.label_location', 'integer'];
        }

        return $this->validatePasses($form->getSaveData(), $rules);
    }
}