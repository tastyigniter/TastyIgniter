<?php

namespace System\Controllers;

use Admin\Facades\AdminMenu;

class Currencies extends \Admin\Classes\AdminController
{
    public $implement = [
        \Admin\Actions\ListController::class,
        \Admin\Actions\FormController::class,
    ];

    public $listConfig = [
        'list' => [
            'model' => \System\Models\Currency::class,
            'title' => 'lang:system::lang.currencies.text_title',
            'emptyMessage' => 'lang:system::lang.currencies.text_empty',
            'defaultSort' => ['currency_status', 'DESC'],
            'configFile' => 'currency',
        ],
    ];

    public $formConfig = [
        'name' => 'lang:system::lang.currencies.text_form_name',
        'model' => \System\Models\Currency::class,
        'request' => \System\Requests\Currency::class,
        'create' => [
            'title' => 'lang:admin::lang.form.create_title',
            'redirect' => 'currencies/edit/{currency_id}',
            'redirectClose' => 'currencies',
            'redirectNew' => 'currencies/create',
        ],
        'edit' => [
            'title' => 'lang:admin::lang.form.edit_title',
            'redirect' => 'currencies/edit/{currency_id}',
            'redirectClose' => 'currencies',
            'redirectNew' => 'currencies/create',
        ],
        'preview' => [
            'title' => 'lang:admin::lang.form.preview_title',
            'redirect' => 'currencies',
        ],
        'delete' => [
            'redirect' => 'currencies',
        ],
        'configFile' => 'currency',
    ];

    protected $requiredPermissions = 'Site.Currencies';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('currencies', 'localisation');
    }
}
