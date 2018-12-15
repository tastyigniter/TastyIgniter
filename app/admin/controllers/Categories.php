<?php namespace Admin\Controllers;

use Admin\Classes\AdminController;
use AdminMenu;

class Categories extends AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model' => 'Admin\Models\Categories_model',
            'title' => 'lang:admin::lang.categories.text_title',
            'emptyMessage' => 'lang:admin::lang.categories.text_empty',
            'defaultSort' => ['order_id', 'DESC'],
            'configFile' => 'categories_model',
        ],
    ];

    public $formConfig = [
        'name' => 'lang:admin::lang.categories.text_form_name',
        'model' => 'Admin\Models\Categories_model',
        'create' => [
            'title' => 'lang:admin::lang.form.create_title',
            'redirect' => 'categories/edit/{category_id}',
            'redirectClose' => 'categories',
        ],
        'edit' => [
            'title' => 'lang:admin::lang.form.edit_title',
            'redirect' => 'categories/edit/{category_id}',
            'redirectClose' => 'categories',
        ],
        'preview' => [
            'title' => 'lang:admin::lang.form.preview_title',
            'redirect' => 'categories',
        ],
        'delete' => [
            'redirect' => 'categories',
        ],
        'configFile' => 'categories_model',
    ];

    protected $requiredPermissions = 'Admin.Categories';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('categories', 'kitchen');
    }

    public function formValidate($model, $form)
    {
        $namedRules = [
            ['name', 'lang:admin::lang.categories.label_name', 'required|min:2|max:128'],
            ['description', 'lang:admin::lang.categories.label_description', 'min:2'],
            ['permalink_slug', 'lang:admin::lang.categories.label_permalink_slug', 'alpha_dash|max:255'],
            ['parent_id', 'lang:admin::lang.categories.label_parent', 'integer'],
            ['priority', 'lang:admin::lang.categories.label_priority', 'integer'],
            ['status', 'lang:admin::lang.label_status', 'required|integer'],
        ];

        return $this->validatePasses(post($form->arrayName), $namedRules);
    }
}