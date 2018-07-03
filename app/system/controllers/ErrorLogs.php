<?php namespace System\Controllers;

use AdminMenu;
use File;
use Igniter\Flame\Support\LogViewer;
use Template;

class ErrorLogs extends \Admin\Classes\AdminController
{
    protected $requiredPermissions = 'Admin.ErrorLogs';

    protected $logFile = 'system.';

    public function index()
    {
        AdminMenu::setContext('error_logs', 'system');

        Template::setTitle(lang('system::lang.error_logs.text_title'));
        Template::setHeading(lang('system::lang.error_logs.text_heading'));
        Template::setButton(lang('system::lang.error_logs.text_clear_logs'), [
            'class'             => 'btn btn-danger',
            'data-request-form' => '#list-form',
            'data-request'      => 'onClearLogs',
        ]);
        Template::setButton(lang('admin::lang.button_refresh'), [
            'class' => 'btn btn-default',
            'href'  => 'error_logs',
        ]);

        LogViewer::setFile(storage_path('logs/system.log'));

        $this->vars['logs'] = LogViewer::all();
    }

    public function index_onClearLogs()
    {
        if (!$this->getUser()->hasPermission('Admin.ErrorLogs.Delete', TRUE))
            return $this->redirectBack();

        if (File::isWritable(storage_path('logs/system.log'))) {
            File::put(storage_path('logs/system.log'), "");

            flash()->success(sprintf(lang('admin::lang.alert_success'), 'Logs Cleared '));
        }

        return $this->redirectBack();
    }
}