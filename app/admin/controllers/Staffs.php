<?php namespace Admin\Controllers;

use AdminAuth;
use AdminMenu;
use Request;

class Staffs extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model' => 'Admin\Models\Staffs_model',
            'title' => 'lang:admin::lang.staff.text_title',
            'emptyMessage' => 'lang:admin::lang.staff.text_empty',
            'defaultSort' => ['staff_id', 'DESC'],
            'configFile' => 'staffs_model',
        ],
    ];

    public $formConfig = [
        'name' => 'lang:admin::lang.staff.text_form_name',
        'model' => 'Admin\Models\Staffs_model',
        'request' => 'Admin\Requests\Staff',
        'create' => [
            'title' => 'lang:admin::lang.form.create_title',
            'redirect' => 'staffs/edit/{staff_id}',
            'redirectClose' => 'staffs',
        ],
        'edit' => [
            'title' => 'lang:admin::lang.form.edit_title',
            'redirect' => 'staffs/edit/{staff_id}',
            'redirectClose' => 'staffs',
        ],
        'preview' => [
            'title' => 'lang:admin::lang.form.preview_title',
            'redirect' => 'staffs',
        ],
        'delete' => [
            'redirect' => 'staffs',
        ],
        'configFile' => 'staffs_model',
    ];

    protected $requiredPermissions = 'Admin.Staffs';

    public function __construct()
    {
        parent::__construct();

        if ($this->action == 'edit' AND Request::method() != 'DELETE' AND AdminAuth::getStaffId() == current($this->params))
            $this->requiredPermissions = null;

        AdminMenu::setContext('staffs', 'users');
    }

    public function listExtendQuery($query)
    {
        if (!AdminAuth::isSuperUser()) {
            $query->whereNotSuperUser();
        }
    }

    public function formExtendFields($form, $fields)
    {
        if (!AdminAuth::isSuperUser()) {
            $form->removeField('staff_group_id');
            $form->removeField('staff_location_id');
            $form->removeField('user[super_user]');
            $form->removeField('staff_status');
        }
    }

    public function formExtendQuery($query)
    {
        if (!AdminAuth::isSuperUser()) {
            $query->whereNotSuperUser();
        }
    }
}