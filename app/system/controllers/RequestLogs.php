<?php namespace System\Controllers;

use Admin\Facades\AdminMenu;
use System\Models\Request_logs_model;

class RequestLogs extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model' => 'System\Models\Request_logs_model',
            'title' => 'lang:system::lang.request_logs.text_title',
            'emptyMessage' => 'lang:system::lang.request_logs.text_empty',
            'defaultSort' => ['count', 'DESC'],
            'configFile' => 'request_logs_model',
        ],
    ];

    public $formConfig = [
        'name' => 'lang:system::lang.request_logs.text_form_name',
        'model' => 'System\Models\Request_logs_model',
        'preview' => [
            'title' => 'lang:admin::lang.form.preview_title',
            'redirect' => 'request_logs',
        ],
        'delete' => [
            'redirect' => 'request_logs',
        ],
        'configFile' => 'request_logs_model',
    ];

    protected $requiredPermissions = 'Admin.SystemLogs';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('system_logs', 'system');
    }

    public function index_onEmptyLog()
    {
        Request_logs_model::truncate();

        flash()->success(sprintf(lang('admin::lang.alert_success'), 'Logs Emptied '));

        return $this->refreshList('list');
    }
}