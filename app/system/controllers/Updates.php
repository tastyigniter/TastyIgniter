<?php

namespace System\Controllers;

use Admin\Facades\AdminMenu;
use Admin\Facades\Template;
use Exception;
use System\Classes\UpdateManager;
use System\Models\Extensions_model;
use System\Models\Themes_model;
use System\Traits\ManagesUpdates;

class Updates extends \Admin\Classes\AdminController
{
    use ManagesUpdates;

    public $checkUrl = 'updates';

    public $browseUrl = 'updates/browse';

    protected $requiredPermissions = 'Site.Updates';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('updates', 'system');
    }

    public function index()
    {
        Extensions_model::syncAll();
        Themes_model::syncAll();

        $pageTitle = lang('system::lang.updates.text_title');
        Template::setTitle($pageTitle);
        Template::setHeading($pageTitle);

        Template::setButton(lang('system::lang.updates.button_check'), ['class' => 'btn btn-success', 'data-request' => 'onCheckUpdates']);
        Template::setButton(lang('system::lang.updates.button_carte'), ['class' => 'btn btn-default pull-right', 'role' => 'button', 'data-bs-target' => '#carte-modal', 'data-bs-toggle' => 'modal']);

        Template::setButton(sprintf(lang('system::lang.version'), params('ti_version')), [
            'class' => 'btn disabled text-muted pull-right', 'role' => 'button',
        ]);

        $this->prepareAssets();

        try {
            $updateManager = UpdateManager::instance();
            $this->vars['carteInfo'] = $updateManager->getSiteDetail();
            $this->vars['updates'] = $updates = $updateManager->requestUpdateList();

            $lastChecked = isset($updates['last_check'])
                ? time_elapsed($updates['last_check'])
                : lang('admin::lang.text_never');

            Template::setButton(sprintf(lang('system::lang.updates.text_last_checked'), $lastChecked), [
                'class' => 'btn disabled text-muted pull-right', 'role' => 'button',
            ]);

            if (!empty($updates['items']) || !empty($updates['ignoredItems'])) {
                Template::setButton(lang('system::lang.updates.button_update'), [
                    'class' => 'btn btn-primary pull-left mr-2 ml-0',
                    'id' => 'apply-updates', 'role' => 'button',
                ]);
            }
        }
        catch (Exception $ex) {
            flash()->warning($ex->getMessage())->now();
        }
    }
}
