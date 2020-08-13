<?php

namespace System\Controllers;

use AdminMenu;

class Currencies extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model' => 'System\Models\Currencies_model',
            'title' => 'lang:system::lang.currencies.text_title',
            'emptyMessage' => 'lang:system::lang.currencies.text_empty',
            'defaultSort' => ['currency_status', 'DESC'],
            'configFile' => 'currencies_model',
        ],
    ];

    public $formConfig = [
        'name' => 'lang:system::lang.currencies.text_form_name',
        'model' => 'System\Models\Currencies_model',
        'request' => 'System\Requests\Currency',
        'create' => [
            'title' => 'lang:admin::lang.form.create_title',
            'redirect' => 'currencies/edit/{currency_id}',
            'redirectClose' => 'currencies',
        ],
        'edit' => [
            'title' => 'lang:admin::lang.form.edit_title',
            'redirect' => 'currencies/edit/{currency_id}',
            'redirectClose' => 'currencies',
        ],
        'preview' => [
            'title' => 'lang:admin::lang.form.preview_title',
            'redirect' => 'currencies',
        ],
        'delete' => [
            'redirect' => 'currencies',
        ],
        'configFile' => 'currencies_model',
    ];

    protected $requiredPermissions = 'Site.Currencies';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('currencies', 'localisation');
    }

    public function index()
    {
        app('currency')->updateRates();

        $this->asExtension('ListController')->index();
    }
}
