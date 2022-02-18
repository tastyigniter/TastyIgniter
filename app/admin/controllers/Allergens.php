<?php

namespace Admin\Controllers;

use Admin\Classes\AdminController;
use Admin\Facades\AdminMenu;

class Allergens extends AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
        'Admin\Actions\LocationAwareController',
    ];

    public $listConfig = [
        'list' => [
            'model' => 'Admin\Models\Allergen',
            'title' => 'lang:admin::lang.allergens.text_title',
            'emptyMessage' => 'lang:admin::lang.allergens.text_empty',
            'defaultSort' => ['allergens_id', 'DESC'],
            'configFile' => 'allergen',
        ],
    ];

    public $formConfig = [
        'name' => 'lang:admin::lang.allergens.text_form_name',
        'model' => 'Admin\Models\Allergen',
        'request' => 'Admin\Requests\Allergen',
        'create' => [
            'title' => 'lang:admin::lang.form.create_title',
            'redirect' => 'allergens/edit/{allergen_id}',
            'redirectClose' => 'allergens',
            'redirectNew' => 'allergens/create',
        ],
        'edit' => [
            'title' => 'lang:admin::lang.form.edit_title',
            'redirect' => 'allergens/edit/{allergen_id}',
            'redirectClose' => 'allergens',
            'redirectNew' => 'allergens/create',
        ],
        'preview' => [
            'title' => 'lang:admin::lang.form.preview_title',
            'redirect' => 'allergens',
        ],
        'delete' => [
            'redirect' => 'allergens',
        ],
        'configFile' => 'allergen',
    ];

    protected $requiredPermissions = 'Admin.Allergens';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('menus', 'restaurant');
    }
}
