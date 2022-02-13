<?php

namespace System\Controllers;

use Admin\Facades\AdminMenu;
use Admin\Facades\Template;
use Igniter\Flame\Support\Facades\File;
use Igniter\Flame\Support\LogViewer;

class SystemLogs extends \Admin\Classes\AdminController
{
    protected $requiredPermissions = 'Admin.SystemLogs';

    protected $logFile = 'system.';

    public function index()
    {
        AdminMenu::setContext('system_logs', 'system');

        Template::setTitle(lang('system::lang.system_logs.text_title'));
        Template::setHeading(lang('system::lang.system_logs.text_title'));
        Template::setButton(lang('admin::lang.button_refresh'), [
            'class' => 'btn btn-primary',
            'href' => 'system_logs',
        ]);
        Template::setButton(lang('system::lang.system_logs.button_empty'), [
            'class' => 'btn btn-danger',
            'data-request-form' => '#list-form',
            'data-request' => 'onEmptyLog',
        ]);
        Template::setButton(lang('system::lang.system_logs.button_request_logs'), [
            'class' => 'btn btn-default',
            'href' => 'request_logs',
        ]);

        $logFile = storage_path('logs/system.log');

        $logs = [];
        if (File::exists($logFile)) {
            LogViewer::setFile($logFile);
            $logs = LogViewer::all() ?? [];
        }

        $this->vars['logs'] = $logs;
    }

    public function index_onEmptyLog()
    {
        $logFile = storage_path('logs/system.log');
        if (File::exists($logFile) && File::isWritable($logFile)) {
            File::put(storage_path('logs/system.log'), '');

            flash()->success(sprintf(lang('admin::lang.alert_success'), 'Logs Emptied '));
        }

        return $this->redirectBack();
    }
}
