<?php

namespace Admin\Controllers;

use Admin\Facades\AdminMenu;

class MenuOptions extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
        'Admin\Actions\LocationAwareController',
    ];

    public $listConfig = [
        'list' => [
            'model' => 'Admin\Models\Menu_options_model',
            'title' => 'lang:admin::lang.menu_options.text_title',
            'emptyMessage' => 'lang:admin::lang.menu_options.text_empty',
            'defaultSort' => ['option_id', 'DESC'],
            'configFile' => 'menuoption',
        ],
    ];

    public $formConfig = [
        'name' => 'lang:admin::lang.menu_options.text_form_name',
        'model' => 'Admin\Models\Menu_options_model',
        'request' => 'Admin\Requests\MenuOption',
        'create' => [
            'title' => 'lang:admin::lang.form.create_title',
            'redirect' => 'menu_options/edit/{option_id}',
            'redirectClose' => 'menu_options',
            'redirectNew' => 'menu_options/create',
        ],
        'edit' => [
            'title' => 'lang:admin::lang.form.edit_title',
            'redirect' => 'menu_options/edit/{option_id}',
            'redirectClose' => 'menu_options',
            'redirectNew' => 'menu_options/create',
        ],
        'preview' => [
            'title' => 'lang:admin::default.form.preview_title',
            'redirect' => 'menu_options',
        ],
        'delete' => [
            'redirect' => 'menu_options',
        ],
        'configFile' => 'menuoption',
    ];

    protected $requiredPermissions = 'Admin.Menus';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('menus', 'restaurant');
    }
}
