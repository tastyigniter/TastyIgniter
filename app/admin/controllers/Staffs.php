<?php

namespace Admin\Controllers;

use Admin\Facades\AdminAuth;
use Admin\Facades\AdminMenu;
use Igniter\Flame\Exception\ApplicationException;

class Staffs extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
        'Admin\Actions\LocationAwareController',
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
            'redirectNew' => 'staffs/create',
        ],
        'edit' => [
            'title' => 'lang:admin::lang.form.edit_title',
            'redirect' => 'staffs/edit/{staff_id}',
            'redirectClose' => 'staffs',
            'redirectNew' => 'staffs/create',
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

        if ($this->action == 'account') {
            $this->requiredPermissions = null;
        }

        AdminMenu::setContext('staffs', 'system');
    }

    public function account()
    {
        $this->asExtension('LocationAwareController')->setConfig(['applyScopeOnFormQuery' => false]);

        return $this->asExtension('FormController')->edit('account', $this->getUser()->getKey());
    }

    public function account_onSave()
    {
        $this->asExtension('LocationAwareController')->setConfig(['applyScopeOnFormQuery' => false]);

        $result = $this->asExtension('FormController')->edit_onSave('account', $this->currentUser->user_id);

        $usernameChanged = $this->currentUser->username != post('Staff[user][username]');
        $passwordChanged = strlen(post('Staff[user][password]'));
        $languageChanged = $this->currentUser->language != post('Staff[language_id]');
        if ($usernameChanged || $passwordChanged || $languageChanged) {
            $this->currentUser->reload()->reloadRelations();
            AdminAuth::login($this->currentUser, true);
        }

        return $result;
    }

    public function onImpersonate($context, $recordId = null)
    {
        if (!AdminAuth::user()->hasPermission('Admin.Impersonate')) {
            throw new ApplicationException(lang('admin::lang.staff.alert_login_restricted'));
        }

        $id = post('recordId', $recordId);
        if ($staff = $this->formFindModelObject((int)$id)) {
            AdminAuth::stopImpersonate();
            AdminAuth::impersonate($staff->user);
            flash()->success(sprintf(lang('admin::lang.customers.alert_impersonate_success'), $staff->staff_name));
        }
    }

    public function listExtendQuery($query)
    {
        if (!AdminAuth::isSuperUser()) {
            $query->whereNotSuperUser();
        }
    }

    public function formExtendQuery($query)
    {
        if (!AdminAuth::isSuperUser()) {
            $query->whereNotSuperUser();
        }
    }

    public function formExtendFields($form)
    {
        if (!AdminAuth::isSuperUser()) {
            $form->removeField('staff_role_id');
            $form->removeField('staff_status');
            $form->removeField('user[super_user]');
        }
    }

    public function formAfterSave($model)
    {
        if ($this->status && !$this->is_activated)
            $model->completeActivation($model->getActivationCode());
    }
}
