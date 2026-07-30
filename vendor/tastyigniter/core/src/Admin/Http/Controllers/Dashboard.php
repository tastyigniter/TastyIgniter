<?php

declare(strict_types=1);

namespace Igniter\Admin\Http\Controllers;

use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Facades\AdminMenu;
use Igniter\Admin\Facades\Template;
use Igniter\Admin\Widgets\DashboardContainer;
use Igniter\User\Facades\AdminAuth;

class Dashboard extends AdminController
{
    public array $containerConfig = [];

    protected array $callbacks = [];

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('dashboard');
    }

    public function index(): mixed
    {
        Template::setTitle(lang('igniter::admin.dashboard.text_title'));
        Template::setHeading(lang('igniter::admin.dashboard.text_heading'));

        $this->initDashboardContainer();

        return $this->makeView('dashboard');
    }

    public function initDashboardContainer(): void
    {
        $this->containerConfig['canManage'] = array_get($this->containerConfig, 'canManage', $this->canManageWidgets());
        $this->containerConfig['canSetDefault'] = array_get($this->containerConfig, 'canSetDefault', AdminAuth::isSuperUser());
        $this->containerConfig['defaultWidgets'] = array_get($this->containerConfig, 'defaultWidgets', $this->getDefaultWidgets());

        $widget = new DashboardContainer($this, $this->containerConfig);

        foreach ($this->callbacks as $callback) {
            $callback($widget);
        }

        $widget->bindToController();
    }

    protected function getDefaultWidgets(): array
    {
        return [
            'onboarding' => [
                'priority' => 1,
                'width' => '12',
            ],
            'reports' => [
                'widget' => 'charts',
                'priority' => 10,
                'width' => '6',
            ],
            'news' => [
                'priority' => 10,
                'width' => '6',
            ],
            'order_stats' => [
                'widget' => 'stats',
                'priority' => 20,
                'card' => 'sale',
                'width' => '4',
            ],
            'reservation_stats' => [
                'widget' => 'stats',
                'priority' => 20,
                'card' => 'lost_sale',
                'width' => '4',
            ],
            'customer_stats' => [
                'widget' => 'stats',
                'priority' => 20,
                'card' => 'cash_payment',
                'width' => '4',
            ],
        ];
    }

    protected function canManageWidgets(): bool
    {
        return $this->getUser()->hasPermission('Admin.Dashboard');
    }

    public function extendDashboardContainer(callable $callback): void
    {
        $this->callbacks[] = $callback;
    }
}
