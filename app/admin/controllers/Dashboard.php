<?php namespace Admin\Controllers;

use Admin\Widgets\DashboardContainer;
use AdminMenu;
use Request;
use Template;

class Dashboard extends \Admin\Classes\AdminController
{
    public $containerConfig = [];

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
        new DashboardContainer($this, array_merge_recursive(
            $this->getDefaultWidgets(), $this->containerConfig
        ));
    }

    protected function getDefaultWidgets()
    {
        return [
            'defaultWidgets' => [
                'onboarding' => [
                    'class' => \Admin\DashboardWidgets\Onboarding::class,
                    'priority' => 1,
                    'config' => [
                        'title' => 'admin::lang.dashboard.onboarding.title',
                        'width' => '6',
                    ],
                ],
                'news' => [
                    'class' => \System\DashboardWidgets\News::class,
                    'priority' => 2,
                    'config' => [
                        'title' => 'admin::lang.dashboard.text_news',
                        'width' => '6',
                    ],
                ],
                'order_stats' => [
                    'class' => \Admin\DashboardWidgets\Statistics::class,
                    'priority' => 3,
                    'config' => [
                        'context' => 'sale',
                        'width' => '4',
                    ],
                ],
                'reservation_stats' => [
                    'class' => \Admin\DashboardWidgets\Statistics::class,
                    'priority' => 4,
                    'config' => [
                        'context' => 'lost_sale',
                        'width' => '4',
                    ],
                ],
                'customer_stats' => [
                    'class' => \Admin\DashboardWidgets\Statistics::class,
                    'priority' => 5,
                    'config' => [
                        'context' => 'cash_payment',
                        'width' => '4',
                    ],
                ],
                'charts' => [
                    'class' => \Admin\DashboardWidgets\Charts::class,
                    'priority' => 6,
                    'config' => [
                        'title' => 'admin::lang.dashboard.text_reports_chart',
                        'width' => '12',
                    ],
                ],
            ],
        ];
    }
}