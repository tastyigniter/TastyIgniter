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

        if ($this->action == 'account') {
            $this->requiredPermissions = null;
        }

        AdminMenu::setContext('staffs', 'users');
    }

    public function account()
    {
        return $this->asExtension('FormController')->edit('account', $this->getUser()->getKey());
    }

    public function account_onSave()
    {
        $result = $this->asExtension('FormController')->edit_onSave('account', $this->currentUser->user_id);

        $usernameChanged = $this->currentUser->username != post('Staff[user][username]');
        $passwordChanged = strlen(post('Staff[user][password]'));
        $languageChanged = $this->currentUser->language != post('Staff[language_id]');
        if ($usernameChanged OR $passwordChanged OR $languageChanged) {
            $this->currentUser->reload()->reloadRelations();
            AdminAuth::login($this->currentUser, TRUE);
        }

        return $result;
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
            $form->removeField('user[super_user]');
        }
    }
}