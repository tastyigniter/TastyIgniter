<?php

namespace Admin\Database\Migrations;

use Admin\DashboardWidgets\Charts;
use Admin\DashboardWidgets\Onboarding;
use Admin\DashboardWidgets\Statistics;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use System\DashboardWidgets\Activities;
use System\DashboardWidgets\Cache;
use System\DashboardWidgets\News;

class UpdateDashboardWidgetPropertiesOnUserPreferencesTable extends Migration
{
    protected array $widgetsMap = [
        Activities::class => ['recent-activities'],
        Cache::class => ['cache'],
        News::class => ['news'],
        Onboarding::class => ['onboarding'],
        Statistics::class => ['stats', 'card'],
        Charts::class => ['charts', 'dataset'],
    ];

    public function up()
    {
        $widgets = DB::table('user_preferences')
            ->where('item', 'admin_dashboardwidgets_dashboard')
            ->value('value');

        $widgets = collect(json_decode($widgets, true))->mapWithKeys(function ($properties, $alias) {
            if ($options = array_get($this->widgetsMap, array_pull($properties, 'class'))) {
                $properties['widget'] = $options[0];

                $props = array_pull($properties, 'config');
                if (isset($options[1], $props['context'])) {
                    $properties[$options[1]] = array_pull($props, 'context');
                }

                $properties = array_merge($properties, $props);
            }

            return [$alias => $properties];
        })->all();

        DB::table('user_preferences')
            ->where('item', 'admin_dashboardwidgets_dashboard')
            ->update(['value' => $widgets]);
    }

    public function down()
    {
    }
}
