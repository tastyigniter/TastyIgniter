<?php

namespace Admin\Controllers;

use Admin\Facades\AdminMenu;

class Statuses extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model' => 'Admin\Models\Status',
            'title' => 'lang:admin::lang.statuses.text_title',
            'emptyMessage' => 'lang:admin::lang.statuses.text_empty',
            'defaultSort' => ['status_id', 'DESC'],
            'configFile' => 'status',
        ],
    ];

    public $formConfig = [
        'name' => 'lang:admin::lang.statuses.text_form_name',
        'model' => 'Admin\Models\Status',
        'request' => 'Admin\Requests\Status',
        'create' => [
            'title' => 'lang:admin::lang.form.create_title',
            'redirect' => 'statuses/edit/{status_id}',
            'redirectClose' => 'statuses',
            'redirectNew' => 'statuses/create',
        ],
        'edit' => [
            'title' => 'lang:admin::lang.form.edit_title',
            'redirect' => 'statuses/edit/{status_id}',
            'redirectClose' => 'statuses',
            'redirectNew' => 'statuses/create',
        ],
        'preview' => [
            'title' => 'lang:admin::lang.form.preview_title',
            'redirect' => 'statuses',
        ],
        'delete' => [
            'redirect' => 'statuses',
        ],
        'configFile' => 'status',
    ];

    protected $requiredPermissions = 'Admin.Statuses';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('statuses', 'sales');
    }
}
