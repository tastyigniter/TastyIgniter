<?php

declare(strict_types=1);

namespace Igniter\System\Http\Controllers;

use Facades\Igniter\Flame\Support\LogViewer;
use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Facades\AdminMenu;
use Igniter\Admin\Facades\Template;
use Igniter\Flame\Support\Facades\File;
use Illuminate\Http\RedirectResponse;

class SystemLogs extends AdminController
{
    protected null|string|array $requiredPermissions = 'Admin.SystemLogs';

    protected string $logFile = '/logs/laravel';

    public function index(): void
    {
        AdminMenu::setContext('system_logs', 'system');

        Template::setTitle(lang('igniter::system.system_logs.text_title'));
        Template::setHeading(lang('igniter::system.system_logs.text_title'));
        Template::setButton(lang('igniter::admin.button_refresh'), [
            'class' => 'btn btn-primary',
            'href' => 'system_logs',
        ]);
        Template::setButton(lang('igniter::system.system_logs.button_empty'), [
            'class' => 'btn btn-link pull-right text-danger text-decoration-none',
            'data-request-form' => '#lists-list-form',
            'data-request' => 'onEmptyLog',
            'data-request-confirm' => lang('igniter::admin.alert_warning_confirm'),
        ]);
        Template::setButton(lang('igniter::system.system_logs.button_request_logs'), [
            'class' => 'btn btn-default',
            'href' => 'request_logs',
        ]);

        $logFile = $this->getLogsFile();

        $logs = [];
        if (File::exists($logFile)) {
            if (File::size($logFile) > \Igniter\Flame\Support\LogViewer::MAX_FILE_SIZE) {
                flash()->error(sprintf(
                    'The log file %s is too large to be processed. Maximum size is %d bytes.',
                    LogViewer::getFileName(),
                    \Igniter\Flame\Support\LogViewer::MAX_FILE_SIZE,
                ));
            } else {
                $logs = LogViewer::setFile($logFile)->all() ?? [];
            }
        }

        $this->vars['logs'] = $logs;
    }

    public function index_onEmptyLog(): RedirectResponse
    {
        $logFile = $this->getLogsFile();
        if (File::exists($logFile) && File::isWritable($logFile)) {
            File::put($logFile, '');

            flash()->success(sprintf(lang('igniter::admin.alert_success'), 'Logs Emptied '));
        }

        return $this->redirectBack();
    }

    /**
     * Get the path to the logs file
     */
    protected function getLogsFile(): string
    {
        // replace slashes with os directory separator
        $this->logFile = str_replace('/', DIRECTORY_SEPARATOR, $this->logFile);
        // default daily rotating logs (Laravel 5.0)
        $path = storage_path($this->logFile.'-'.date('Y-m-d').'.log');

        // single file logs
        if (!File::exists($path)) {
            $path = storage_path($this->logFile.'.log');
        }

        return $path;
    }
}
