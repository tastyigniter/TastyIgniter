<?php

declare(strict_types=1);

namespace Igniter\System\Http\Controllers;

use Facades\Igniter\System\Helpers\CacheHelper;
use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Facades\AdminMenu;
use Igniter\Admin\Facades\Template;
use Igniter\Flame\Exception\FlashException;
use Igniter\System\Classes\UpdateManager;
use Igniter\System\Health\HealthManager;
use Illuminate\Support\Facades\Artisan;
use Throwable;

class System extends AdminController
{
    protected null|string|array $requiredPermissions = 'Admin.SystemInfo';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('updates', 'system');
    }

    public function index(): void
    {
        $pageTitle = lang('igniter::system.system.text_title');
        Template::setTitle($pageTitle);
        Template::setHeading($pageTitle);

        $this->configureToolbar();

        $results = resolve(HealthManager::class)->run();

        $this->vars['results'] = $results;
        $this->vars['alerts'] = $this->buildAlerts($results);
    }

    public function onClearCache(): array
    {
        rescue(fn() => CacheHelper::clear());

        flash()->success(lang('igniter::system.system.alert_cache_cleared'));

        return $this->refreshPage();
    }

    public function onMigrateDatabase(): array
    {
        try {
            Artisan::call('migrate', ['--force' => true]);

            resolve(UpdateManager::class)->migrate();

            flash()->success(lang('igniter::system.system.alert_migrate_success'));
        } catch (Throwable $throwable) {
            throw FlashException::error($throwable->getMessage());
        }

        return $this->refreshPage();
    }

    protected function configureToolbar(): void
    {
        $this->widgets['toolbar']->reInitialize([
            'buttons' => [
                'clear_cache' => [
                    'label' => 'igniter::system.system.button_clear_cache',
                    'class' => 'btn btn-default',
                    'data-request' => 'onClearCache',
                    'data-progress-indicator' => 'igniter::admin.text_loading',
                ],
                'migrate' => [
                    'label' => 'igniter::system.system.button_migrate',
                    'class' => 'btn btn-primary',
                    'data-request' => 'onMigrateDatabase',
                    'data-request-confirm' => lang('igniter::system.system.confirm_migrate'),
                    'data-progress-indicator' => 'igniter::admin.text_loading',
                ],
            ],
        ]);
    }

    protected function refreshPage(): array
    {
        $results = resolve(HealthManager::class)->run();

        $this->vars['results'] = $results;
        $this->vars['alerts'] = $this->buildAlerts($results);

        return [
            '#system-page-content' => $this->makePartial('system/page_content'),
        ];
    }

    protected function buildAlerts($results)
    {
        return $results->flatMap(function(array $item) {
            $check = $item['check'];
            $result = $item['result'];

            return collect($result->alerts())->map(fn(array $alert) => (object) [
                'name' => $check->name(),
                'label' => $check->label(),
                'status' => $alert['status'],
                'summary' => $alert['summary'],
                'actionMessage' => $alert['actionMessage'],
                'actionUrl' => $alert['actionUrl'],
                'actionUrlLabel' => $alert['actionUrlLabel'],
            ]);
        })->values();
    }
}
