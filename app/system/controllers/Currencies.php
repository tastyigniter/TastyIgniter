<?php namespace System\Controllers;

use AdminMenu;

class Currencies extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model'        => 'System\Models\Currencies_model',
            'title'        => 'lang:system::lang.currencies.text_title',
            'emptyMessage' => 'lang:system::lang.currencies.text_empty',
            'defaultSort'  => ['country_name', 'ASC'],
            'configFile'   => 'currencies_model',
        ],
    ];

    public $formConfig = [
        'name'       => 'lang:system::lang.currencies.text_form_name',
        'model'      => 'System\Models\Currencies_model',
        'create'     => [
            'title'         => 'lang:admin::lang.form.create_title',
            'redirect'      => 'currencies/edit/{currency_id}',
            'redirectClose' => 'currencies',
        ],
        'edit'       => [
            'title'         => 'lang:admin::lang.form.edit_title',
            'redirect'      => 'currencies/edit/{currency_id}',
            'redirectClose' => 'currencies',
        ],
        'preview'    => [
            'title'    => 'lang:admin::lang.form.preview_title',
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
            ['currency_name', 'lang:system::lang.currencies.label_title', 'required|min:2|max:32'],
            ['currency_code', 'lang:system::lang.currencies.label_code', 'required|string|size:3'],
            ['currency_symbol', 'lang:system::lang.currencies.label_symbol', 'required|string'],
            ['country_id', 'lang:system::lang.currencies.label_country', 'required|integer'],
            ['symbol_position', 'lang:system::lang.currencies.label_symbol_position', 'required|string|size:1'],
            ['currency_rate', 'lang:system::lang.currencies.label_rate', 'required|numeric'],
            ['thousand_sign', 'lang:system::lang.currencies.label_thousand_sign', 'required|string|size:1'],
            ['decimal_sign', 'lang:system::lang.currencies.label_decimal_sign', 'required|size:1'],
            ['decimal_position', 'lang:system::lang.currencies.label_decimal_position', 'required|string|size:1'],
            ['currency_status', 'lang:admin::lang.label_status', 'required|integer'],
        ];

        return $this->validatePasses(post($form->arrayName), $rules);
    }
}