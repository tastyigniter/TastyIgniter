<?php namespace System\DashboardWidgets;

use Admin\Classes\BaseDashboardWidget;
use AdminAuth;
use System\Models\Activities_model;

/**
 * System activities dashboard widget.
 */
class Activities extends BaseDashboardWidget
{
    /**
     * @var string A unique alias to identify this widget.
     */
    protected $defaultAlias = 'activities';

    public function render()
    {
        $this->prepareVars();

        return $this->makePartial('activities/activities');
    }

    public function defineProperties()
    {
        return [
            'title' => [
                'label' => 'admin::lang.dashboard.label_widget_title',
                'default' => 'admin::lang.dashboard.text_recent_activity',
                'type' => 'text',
            ],
            'count' => [
                'label' => 'admin::lang.dashboard.text_activities_count',
                'default' => 5,
                'type' => 'select',
                'options' => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10],
            ],
        ];
    }

    protected function prepareVars()
    {
        $user = AdminAuth::getUser();
        $this->vars['activities'] = Activities_model::listRecent([
            'pageLimit' => $this->property('count'),
            'exceptUser' => $user,
        ])->get();
    }
}
