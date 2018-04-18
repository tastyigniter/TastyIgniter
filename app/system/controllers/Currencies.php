<?php namespace System\Controllers;

use AdminAuth;
use AdminMenu;
use System\Models\Currencies_model;

class Currencies extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model'        => 'System\Models\Currencies_model',
            'title'        => 'lang:system::currencies.text_title',
            'emptyMessage' => 'lang:system::currencies.text_empty',
            'defaultSort'  => ['country_name', 'ASC'],
            'configFile'   => 'currencies_model',
        ],
    ];

    public $formConfig = [
        'name'       => 'lang:system::currencies.text_form_name',
        'model'      => 'System\Models\Currencies_model',
        'create'     => [
            'title'         => 'lang:admin::default.form.create_title',
            'redirect'      => 'currencies/edit/{currency_id}',
            'redirectClose' => 'currencies',
        ],
        'edit'       => [
            'title'         => 'lang:admin::default.form.edit_title',
            'redirect'      => 'currencies/edit/{currency_id}',
            'redirectClose' => 'currencies',
        ],
        'preview'    => [
            'title'    => 'lang:admin::default.form.preview_title',
            'redirect' => 'currencies',
        ],
        'delete'     => [
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

    public function formValidate($model, $form)
    {
        $rules = [
            ['currency_name', 'lang:system::currencies.label_title', 'required|min:2|max:32'],
            ['currency_code', 'lang:system::currencies.label_code', 'required|string|size:3'],
            ['currency_symbol', 'lang:system::currencies.label_symbol', 'required|string'],
            ['country_id', 'lang:system::currencies.label_country', 'required|integer'],
            ['symbol_position', 'lang:system::currencies.label_symbol_position', 'required|string|size:1'],
            ['currency_rate', 'lang:system::currencies.label_rate', 'required|numeric'],
            ['thousand_sign', 'lang:system::currencies.label_thousand_sign', 'required|string|size:1'],
            ['decimal_sign', 'lang:system::currencies.label_decimal_sign', 'required|size:1'],
            ['decimal_position', 'lang:system::currencies.label_decimal_position', 'required|string|size:1'],
            ['currency_status', 'lang:admin::default.label_status', 'required|integer'],
        ];

        return $this->validatePasses(post($form->arrayName), $rules);
    }
}