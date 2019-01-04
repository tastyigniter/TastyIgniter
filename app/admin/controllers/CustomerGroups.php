<?php namespace Admin\Controllers;

use Admin\Models\Customer_groups_model;
use AdminMenu;

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
            'defaultSort' => ['country_name', 'ASC'],
            'configFile' => 'customer_groups_model',
        ],
    ];

    public $formConfig = [
        'name' => 'lang:admin::lang.customer_groups.text_form_name',
        'model' => 'Admin\Models\Customer_groups_model',
        'create' => [
            'title' => 'lang:admin::lang.form.create_title',
            'redirect' => 'customer_groups/edit/{customer_group_id}',
            'redirectClose' => 'customer_groups',
        ],
        'edit' => [
            'title' => 'lang:admin::lang.form.edit_title',
            'redirect' => 'customer_groups/edit/{customer_group_id}',
            'redirectClose' => 'customer_groups',
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

        AdminMenu::setContext('customer_groups', 'users');
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

    public function formValidate($model, $form)
    {
        $rules = [
            ['group_name', 'lang:admin::lang.customer_groups.label_name', 'required|min:2|max:32'],
            ['approval', 'lang:admin::lang.customer_groups.label_approval', 'required|integer'],
            ['description', 'lang:admin::lang.customer_groups.label_description', 'min:2|max:512'],
        ];

        return $this->validatePasses(post($form->arrayName), $rules);
    }
}