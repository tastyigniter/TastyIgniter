<?php namespace Admin\Controllers;

use AdminMenu;

class CustomerGroups extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model'        => 'Admin\Models\Customer_groups_model',
            'title'        => 'lang:admin::customer_groups.text_title',
            'emptyMessage' => 'lang:admin::customer_groups.text_empty',
            'defaultSort'  => ['country_name', 'ASC'],
            'configFile'   => 'customer_groups_model',
        ],
    ];

    public $formConfig = [
        'name'       => 'lang:admin::customer_groups.text_form_name',
        'model'      => 'Admin\Models\Customer_groups_model',
        'create'     => [
            'title'         => 'lang:admin::default.form.create_title',
            'redirect'      => 'customer_groups/edit/{customer_group_id}',
            'redirectClose' => 'customer_groups',
        ],
        'edit'       => [
            'title'         => 'lang:admin::default.form.edit_title',
            'redirect'      => 'customer_groups/edit/{customer_group_id}',
            'redirectClose' => 'customer_groups',
        ],
        'preview'    => [
            'title'    => 'lang:admin::default.form.preview_title',
            'redirect' => 'customer_groups',
        ],
        'delete'     => [
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

    public function formValidate($model, $form)
    {
        $rules = [
            ['group_name', 'lang:admin::customer_groups.label_name', 'required|min:2|max:32'],
            ['approval', 'lang:admin::customer_groups.label_approval', 'required|integer'],
            ['description', 'lang:admin::customer_groups.label_description', 'min:2|max:512'],
        ];

        return $this->validatePasses(post($form->arrayName), $rules);
    }
}