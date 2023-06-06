<?php

namespace Admin\Controllers;

use Admin\Facades\AdminAuth;
use Admin\Facades\AdminMenu;
use Admin\Facades\Template;
use Admin\Widgets\DashboardContainer;
use Illuminate\Support\Facades\Request;

class Dashboard extends \Admin\Classes\AdminController
{
    public $containerConfig = [];

    protected $callbacks = [];

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('dashboard');
    }

    public function index()
    {
        if (is_null(Request::segment(2)))
            return $this->redirect('dashboard');

        Template::setTitle(lang('admin::lang.dashboard.text_title'));
        Template::setHeading(lang('admin::lang.dashboard.text_heading'));

        $this->initDashboardContainer();

        return $this->makeView('dashboard');
    }

    public function initDashboardContainer()
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

    protected function getDefaultWidgets()
    {
        return [
            'onboarding' => [
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
            'reports' => [
                'widget' => 'charts',
                'priority' => 30,
                'width' => '12',
            ],
            'recent-activities' => [
                'widget' => 'recent-activities',
                'priority' => 40,
                'width' => '6',
            ],
            'cache' => [
                'priority' => 90,
                'width' => '6',
            ],
        ];
    }

    protected function canManageWidgets()
    {
        return $this->getUser()->hasPermission('Admin.Dashboard');
    }

    public function extendDashboard(callable $callback)
    {
        $this->callbacks[] = $callback;
    }
}
