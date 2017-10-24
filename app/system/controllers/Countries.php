<?php namespace System\Controllers;

use AdminMenu;

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
            'model'        => 'System\Models\Countries_model',
            'title'        => 'lang:system::countries.text_title',
            'emptyMessage' => 'lang:system::countries.text_empty',
            'defaultSort'  => ['country_name', 'ASC'],
            'configFile'   => 'countries_model',
        ],
    ];

    public $formConfig = [
        'name'       => 'lang:system::countries.text_form_name',
        'model'      => 'System\Models\Countries_model',
        'create'     => [
            'title'         => 'lang:admin::default.form.create_title',
            'redirect'      => 'countries/edit/{country_id}',
            'redirectClose' => 'countries',
        ],
        'edit'       => [
            'title'         => 'lang:admin::default.form.edit_title',
            'redirect'      => 'countries/edit/{country_id}',
            'redirectClose' => 'countries',
        ],
        'preview'    => [
            'title'    => 'lang:admin::default.form.preview_title',
            'redirect' => 'countries',
        ],
        'delete'     => [
            'redirect' => 'countries',
        ],
        'configFile' => 'countries_model',
    ];

    protected $requiredPermissions = 'Site.Countries';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('countries', 'localisation');
    }

    public function formValidate($model, $form)
    {
        $rules = [
            ['country_name', 'lang:system::countries.label_name', 'required|min:2|max:128'],
            ['priority', 'lang:system::countries.label_priority', 'required|integer'],
            ['iso_code_2', 'lang:system::countries.label_iso_code2', 'required|string|size:2'],
            ['iso_code_3', 'lang:system::countries.label_iso_code3', 'required|string|size:3'],
            ['flag', 'lang:system::countries.label_flag', 'required'],
            ['format', 'lang:system::countries.label_format', 'min:2'],
            ['status', 'lang:admin::default.label_status', 'required|integer'],
        ];

        return $this->validatePasses(post($form->arrayName), $rules);
    }
}