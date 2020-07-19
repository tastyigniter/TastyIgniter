<?php namespace Admin\Controllers;

use Admin\Facades\AdminAuth;
use AdminMenu;
use Auth;
use Igniter\Flame\Exception\ApplicationException;

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
        ],
        'edit' => [
            'title' => 'lang:admin::lang.form.edit_title',
            'redirect' => 'customers/edit/{customer_id}',
            'redirectClose' => 'customers',
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
}