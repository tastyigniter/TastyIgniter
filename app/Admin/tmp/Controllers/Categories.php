<?php

namespace Admin\Controllers;

use Admin\Classes\AdminController;
use Admin\Facades\AdminMenu;
use Admin\Models\Categories_model;

class Categories extends AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
        'Admin\Actions\LocationAwareController',
    ];

    public $listConfig = [
        'list' => [
            'model' => 'Admin\Models\Categories_model',
            'title' => 'lang:admin::lang.categories.text_title',
            'emptyMessage' => 'lang:admin::lang.categories.text_empty',
            'defaultSort' => ['category_id', 'DESC'],
            'configFile' => 'categories_model',
        ],
    ];

    public $formConfig = [
        'name' => 'lang:admin::lang.categories.text_form_name',
        'model' => 'Admin\Models\Categories_model',
        'request' => 'Admin\Requests\Category',
        'create' => [
            'title' => 'lang:admin::lang.form.create_title',
            'redirect' => 'categories/edit/{category_id}',
            'redirectClose' => 'categories',
            'redirectNew' => 'categories/create',
        ],
        'edit' => [
            'title' => 'lang:admin::lang.form.edit_title',
            'redirect' => 'categories/edit/{category_id}',
            'redirectClose' => 'categories',
            'redirectNew' => 'categories/create',
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

        AdminMenu::setContext('categories', 'restaurant');
    }

    public function formBeforeSave($model)
    {
        if (!$model->getRgt() || !$model->getLft())
            $model->fixTree();

        if (Categories_model::isBroken())
            Categories_model::fixTree();
    }
}
