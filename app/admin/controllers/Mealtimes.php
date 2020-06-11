<?php namespace Admin\Controllers;

use AdminMenu;

class Mealtimes extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model' => 'Admin\Models\Mealtimes_model',
            'title' => 'lang:admin::lang.mealtimes.text_title',
            'emptyMessage' => 'lang:admin::lang.mealtimes.text_empty',
            'defaultSort' => ['mealtime_id', 'DESC'],
            'configFile' => 'mealtimes_model',
        ],
    ];

    public $formConfig = [
        'name' => 'lang:admin::lang.mealtimes.text_form_name',
        'model' => 'Admin\Models\Mealtimes_model',
        'request' => 'Admin\Requests\Mealtime',
        'create' => [
            'title' => 'lang:admin::lang.form.create_title',
            'redirect' => 'mealtimes/edit/{mealtime_id}',
            'redirectClose' => 'mealtimes',
        ],
        'edit' => [
            'title' => 'lang:admin::lang.form.edit_title',
            'redirect' => 'mealtimes/edit/{mealtime_id}',
            'redirectClose' => 'mealtimes',
        ],
        'preview' => [
            'title' => 'lang:admin::lang.form.preview_title',
            'redirect' => 'mealtimes',
        ],
        'delete' => [
            'redirect' => 'mealtimes',
        ],
        'configFile' => 'mealtimes_model',
    ];

    protected $requiredPermissions = 'Admin.Mealtimes';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('mealtimes', 'restaurant');
    }
}