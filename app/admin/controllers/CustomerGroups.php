<?php

namespace Admin\Controllers;

use Admin\Facades\AdminMenu;
use Admin\Models\Customer_groups_model;

class CustomerGroups extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model' => 'Admin\Models\Customer_groups_model',
            'title' => 'lang:admin::lang.customer_groups.text_title',
            'emptyMessage' => 'lang:admin::lang.customer_groups.text_empty',
            'defaultSort' => ['customer_group_id', 'DESC'],
            'configFile' => 'customer_groups_model',
        ],
    ];

    public $formConfig = [
        'name' => 'lang:admin::lang.customer_groups.text_form_name',
        'model' => 'Admin\Models\Customer_groups_model',
        'request' => 'Admin\Requests\CustomerGroup',
        'create' => [
            'title' => 'lang:admin::lang.form.create_title',
            'redirect' => 'customer_groups/edit/{customer_group_id}',
            'redirectClose' => 'customer_groups',
            'redirectNew' => 'customer_groups/create',
        ],
        'edit' => [
            'title' => 'lang:admin::lang.form.edit_title',
            'redirect' => 'customer_groups/edit/{customer_group_id}',
            'redirectClose' => 'customer_groups',
            'redirectNew' => 'customer_groups/create',
        ],
        'preview' => [
            'title' => 'lang:admin::lang.form.preview_title',
            'redirect' => 'customer_groups',
        ],
        'delete' => [
            'redirect' => 'customer_groups',
        ],
        'configFile' => 'customer_groups_model',
    ];

    protected $requiredPermissions = 'Admin.CustomerGroups';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('customers', 'users');
    }

    public function index_onSetDefault()
    {
        if (Customer_groups_model::updateDefault(post('default'))) {
            flash()->success(sprintf(lang('admin::lang.alert_success'), lang('admin::lang.customer_groups.alert_set_default')));
        }

        return $this->refreshList('list');
    }

    public function listOverrideColumnValue($record, $column, $alias = null)
    {
        if ($column->type != 'button')
            return null;

        if ($column->columnName != 'default')
            return null;

        $attributes = $column->attributes;
        $column->iconCssClass = 'fa fa-star-o';
        if ($record->getKey() == setting('customer_group_id')) {
            $column->iconCssClass = 'fa fa-star';
        }

        return $attributes;
    }
}
