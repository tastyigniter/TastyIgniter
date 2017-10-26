<?php namespace System\Controllers;

use AdminMenu;
use Exception;
use File;
use Template;

class Maintenance extends \Admin\Classes\AdminController
{
    protected $requiredPermissions = 'Admin.Maintenance';

    protected $modelClass = 'System\Models\Maintenance_model';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('maintenance', 'tools');
    }

    public function index()
    {
        try {
            $pageTitle = lang('system::maintenance.text_title');
            Template::setTitle($pageTitle);
            Template::setHeading($pageTitle);

            $dbTables = [];
            $maintenanceModel = $this->createModel();
            foreach ($maintenanceModel->getDbTables() as $dbTable) {
                $dbTables[$dbTable['table_name']] = $dbTable['table_name'].' - '.$dbTable['table_rows'];
            }

            $this->vars['dbTables'] = $dbTables;
            $this->vars['existingBackups'] = $maintenanceModel->getBackupFiles();
        } catch (Exception $ex) {
            $this->handleError($ex);
        }
    }

    public function index_onBackupDatabase()
    {
        if (post('backup_tables') AND $this->validateForm() === TRUE) {

            $maintenanceModel = $this->createModel();
            if ($maintenanceModel->backupDatabase(post())) {
                flash()->success(sprintf(lang('admin::default.alert_success'), 'Database backed up '));
            }

            $this->refresh();
        }
    }

    public function index_onRestoreBackup()
    {
        if (post('file')) {
            $maintenanceModel = $this->createModel();
            if ($this->config->item('maintenance_mode') != '1') {
                flash()->warning(sprintf(lang('system::maintenance.alert_warning_maintenance'), 'restore'));
            }
            else if ($maintenanceModel->restoreDatabase(post('file'))) { // calls model to save data to SQL
                flash()->success(sprintf(lang('admin::default.alert_success'), 'Database restored '));
            }
            else {
                flash()->warning(sprintf(lang('admin::default.alert_error_nothing'), 'restored'));
            }

            $this->refresh();
        }
    }

    public function index_onDownloadBackup()
    {
        if (post('file')) {
            $maintenanceModel = $this->createModel();
            if ($result = $maintenanceModel->readBackupFile(post('file'))) {
                File::get($result['filename'], $result['content']);
            }
        }
    }

    public function index_onDeleteBackup()
    {
        if (post('file')) {
            $maintenanceModel = $this->createModel();
            if ($result = $maintenanceModel->deleteBackupFile(post('file'))) {
                flash()->success(sprintf(lang('admin::default.alert_success'), 'Database backup deleted '));
            }

            $this->refresh();
        }
    }

    protected function createModel()
    {
        if (!strlen($this->modelClass) OR !class_exists($this->modelClass)) {
            throw new Exception(sprintf(lang('admin::default.not_found.model'), $this->modelClass));
        }

        $model = new $this->modelClass;

        return $model;
    }

    protected function validateForm()
    {
        $rules[] = ['drop_tables', 'lang:system::maintenance.label_drop_tables', 'required|alpha_dash'];
        $rules[] = ['add_inserts', 'lang:system::maintenance.label_add_inserts', 'required|alpha_dash'];
        $rules[] = ['backup_tables.*', 'lang:system::maintenance.label_backup_table', 'required|alpha_dash'];

        return $this->validatePasses(post(), $rules);
    }
}