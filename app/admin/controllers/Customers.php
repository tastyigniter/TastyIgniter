<?php

namespace Admin\Controllers;

use Admin\Facades\AdminAuth;
use Admin\Facades\AdminMenu;
use Admin\Facades\Template;
use Igniter\Flame\Exception\ApplicationException;
use Main\Facades\Auth;

class Customers extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model' => 'Admin\Models\Customers_model',
            'title' => 'lang:admin::lang.customers.text_title',
            'emptyMessage' => 'lang:admin::lang.customers.text_empty',
            'defaultSort' => ['customer_id', 'DESC'],
            'configFile' => 'customers_model',
        ],
    ];

    public $formConfig = [
        'name' => 'lang:admin::lang.customers.text_form_name',
        'model' => 'Admin\Models\Customers_model',
        'request' => 'Admin\Requests\Customer',
        'create' => [
            'title' => 'lang:admin::lang.form.create_title',
            'redirect' => 'customers/edit/{customer_id}',
            'redirectClose' => 'customers',
            'redirectNew' => 'customers/create',
        ],
        'edit' => [
            'title' => 'lang:admin::lang.form.edit_title',
            'redirect' => 'customers/edit/{customer_id}',
            'redirectClose' => 'customers',
            'redirectNew' => 'customers/create',
        ],
        'preview' => [
            'title' => 'lang:admin::lang.form.preview_title',
            'redirect' => 'customers',
        ],
        'delete' => [
            'redirect' => 'customers',
        ],
        'configFile' => 'customers_model',
    ];

    protected $requiredPermissions = 'Admin.Customers';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('customers', 'users');
    }

    public function onImpersonate($context, $recordId = null)
    {
        if (!AdminAuth::user()->hasPermission('Admin.ImpersonateCustomers')) {
            throw new ApplicationException(lang('admin::lang.customers.alert_login_restricted'));
        }

        $id = post('recordId', $recordId);
        if ($customer = $this->formFindModelObject((int)$id)) {
            Auth::stopImpersonate();
            Auth::impersonate($customer);
            flash()->success(sprintf(lang('admin::lang.customers.alert_impersonate_success'), $customer->full_name));
        }
    }

    public function edit_onActivate($context, $recordId = null)
    {
        if ($customer = $this->formFindModelObject((int)$recordId)) {
            $customer->completeActivation($customer->getActivationCode());
            flash()->success(sprintf(lang('admin::lang.customers.alert_activation_success'), $customer->full_name));
        }

        return $this->redirectBack();
    }

    public function formExtendModel($model)
    {
        if ($model->exists && !$model->is_activated) {
            Template::setButton(lang('admin::lang.customers.button_activate'), [
                'class' => 'btn btn-success pull-right',
                'data-request' => 'onActivate',
            ]);
        }
    }

    public function formAfterSave($model)
    {
        if (!$model->group || $model->group->requiresApproval())
            return;

        if ($this->status && !$this->is_activated)
            $model->completeActivation($model->getActivationCode());
    }
}
