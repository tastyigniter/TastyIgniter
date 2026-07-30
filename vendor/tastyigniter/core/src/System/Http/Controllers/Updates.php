<?php

declare(strict_types=1);

namespace Igniter\System\Http\Controllers;

use Exception;
use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Facades\AdminMenu;
use Igniter\Admin\Facades\Template;
use Igniter\Flame\Support\Facades\Igniter;
use Igniter\Main\Models\Theme;
use Igniter\System\Classes\UpdateManager;
use Igniter\System\Models\Extension;
use Igniter\System\Traits\ManagesUpdates;

class Updates extends AdminController
{
    use ManagesUpdates;

    protected null|string|array $requiredPermissions = 'Site.Updates';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('updates', 'system');
    }

    public function index(): void
    {
        Extension::syncAll();
        Theme::syncAll();

        $pageTitle = lang('igniter::system.updates.text_title');
        Template::setTitle($pageTitle);
        Template::setHeading($pageTitle);

        $this->prepareAssets();

        try {
            $updateManager = resolve(UpdateManager::class);

            if ($updateManager->hasValidCarte()) {
                $updateManager->syncCarteLicence();
            }

            $this->vars['carteInfo'] = $updateManager->getCarteInfo();
            $this->vars['carteLicenceWarning'] = $updateManager->hasLicenceWarning();
            $this->vars['updates'] = $updateManager->requestUpdateList();
        } catch (Exception $exception) {
            flash()->warning($exception->getMessage())->now();
        }

        $this->vars['igniterVersion'] = Igniter::version();
    }
}
