<?php

namespace Admin\Controllers;

use Admin\Facades\AdminMenu;

class Mealtimes extends \Admin\Classes\AdminController
{
    public $implement = [
        \Admin\Actions\ListController::class,
        \Admin\Actions\FormController::class,
        \Admin\Actions\LocationAwareController::class,
    ];

    public $listConfig = [
        'list' => [
            'model' => \Admin\Models\Mealtime::class,
            'title' => 'lang:admin::lang.mealtimes.text_title',
            'emptyMessage' => 'lang:admin::lang.mealtimes.text_empty',
            'defaultSort' => ['mealtime_id', 'DESC'],
            'configFile' => 'mealtime',
        ],
    ];

    public $formConfig = [
        'name' => 'lang:admin::lang.mealtimes.text_form_name',
        'model' => \Admin\Models\Mealtime::class,
        'request' => \Admin\Requests\Mealtime::class,
        'create' => [
            'title' => 'lang:admin::lang.form.create_title',
            'redirect' => 'mealtimes/edit/{mealtime_id}',
            'redirectClose' => 'mealtimes',
            'redirectNew' => 'mealtimes/create',
        ],
        'edit' => [
            'title' => 'lang:admin::lang.form.edit_title',
            'redirect' => 'mealtimes/edit/{mealtime_id}',
            'redirectClose' => 'mealtimes',
            'redirectNew' => 'mealtimes/create',
        ],
        'preview' => [
            'title' => 'lang:admin::lang.form.preview_title',
            'redirect' => 'mealtimes',
        ],
        'delete' => [
            'redirect' => 'mealtimes',
        ],
        'configFile' => 'mealtime',
    ];

    protected $requiredPermissions = 'Admin.Mealtimes';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('mealtimes', 'restaurant');
    }
}
