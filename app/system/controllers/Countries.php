<?php

namespace System\Controllers;

use Admin\Facades\AdminMenu;

/**
 * Controller Class Countries
 */
class Countries extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model' => 'System\Models\Country',
            'title' => 'lang:system::lang.countries.text_title',
            'emptyMessage' => 'lang:system::lang.countries.text_empty',
            'defaultSort' => ['country_name', 'ASC'],
            'configFile' => 'country',
        ],
    ];

    public $formConfig = [
        'name' => 'lang:system::lang.countries.text_form_name',
        'model' => 'System\Models\Country',
        'request' => 'System\Requests\Country',
        'create' => [
            'title' => 'lang:admin::lang.form.create_title',
            'redirect' => 'countries/edit/{country_id}',
            'redirectClose' => 'countries',
            'redirectNew' => 'countries/create',
        ],
        'edit' => [
            'title' => 'lang:admin::lang.form.edit_title',
            'redirect' => 'countries/edit/{country_id}',
            'redirectClose' => 'countries',
            'redirectNew' => 'countries/create',
        ],
        'preview' => [
            'title' => 'lang:admin::lang.form.preview_title',
            'redirect' => 'countries',
        ],
        'delete' => [
            'redirect' => 'countries',
        ],
        'configFile' => 'country',
    ];

    protected $requiredPermissions = 'Site.Countries';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('countries', 'localisation');
    }
}
