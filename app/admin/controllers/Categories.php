<?php

namespace Admin\Controllers;

use Admin\Classes\AdminController;
use Admin\Facades\AdminMenu;
use Admin\Models\Category;

class Categories extends AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
        'Admin\Actions\LocationAwareController',
    ];

    public $listConfig = [
        'list' => [
            'model' => 'Admin\Models\Category',
            'title' => 'lang:admin::lang.categories.text_title',
            'emptyMessage' => 'lang:admin::lang.categories.text_empty',
            'defaultSort' => ['category_id', 'DESC'],
            'configFile' => 'category',
        ],
    ];

    public $formConfig = [
        'name' => 'lang:admin::lang.categories.text_form_name',
        'model' => 'Admin\Models\Category',
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
        'configFile' => 'category',
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

        if (Category::isBroken())
            Category::fixTree();
    }
}
