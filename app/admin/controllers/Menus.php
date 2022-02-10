<?php

namespace Admin\Controllers;

use Admin\Classes\AdminController;
use Admin\Facades\AdminMenu;

class Menus extends AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
        'Admin\Actions\LocationAwareController',
    ];

    public $listConfig = [
        'list' => [
            'model' => 'Admin\Models\Menus_model',
            'title' => 'lang:admin::lang.menus.text_title',
            'emptyMessage' => 'lang:admin::lang.menus.text_empty',
            'defaultSort' => ['menu_id', 'DESC'],
            'configFile' => 'menus_model',
        ],
    ];

    public $formConfig = [
        'name' => 'lang:admin::lang.menus.text_form_name',
        'model' => 'Admin\Models\Menus_model',
        'request' => 'Admin\Requests\Menu',
        'create' => [
            'title' => 'lang:admin::lang.form.create_title',
            'redirect' => 'menus/edit/{menu_id}',
            'redirectClose' => 'menus',
            'redirectNew' => 'menus/create',
        ],
        'edit' => [
            'title' => 'lang:admin::lang.form.edit_title',
            'redirect' => 'menus/edit/{menu_id}',
            'redirectClose' => 'menus',
            'redirectNew' => 'menus/create',
        ],
        'preview' => [
            'title' => 'lang:admin::lang.form.preview_title',
            'redirect' => 'menus',
        ],
        'delete' => [
            'redirect' => 'menus',
        ],
        'configFile' => 'menus_model',
    ];

    protected $requiredPermissions = 'Admin.Menus';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('menus', 'restaurant');
    }
}
