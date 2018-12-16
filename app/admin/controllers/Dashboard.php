<?php namespace Admin\Controllers;

use Admin\Widgets\DashboardContainer;
use AdminMenu;
use Request;
use Template;

class Dashboard extends \Admin\Classes\AdminController
{
    public $containerConfig = [
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
        ],
    ];

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
        new DashboardContainer($this, $this->containerConfig);
    }
}