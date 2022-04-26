<?php

namespace Admin\Traits;

use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

trait HasChartDatasets
{
    use LocationAwareWidget;

    public function loadAssets()
    {
        $this->addJs('~/app/admin/assets/src/js/vendor/moment.min.js', 'moment-js');
        $this->addJs('~/app/admin/dashboardwidgets/charts/assets/vendor/daterange/daterangepicker.js', 'daterangepicker-js');
        $this->addCss('~/app/admin/dashboardwidgets/charts/assets/vendor/daterange/daterangepicker.css', 'daterangepicker-css');

        $this->addJs('~/app/admin/dashboardwidgets/charts/assets/vendor/chartjs/Chart.min.js', 'chartsjs-js');
        $this->addJs('~/app/admin/dashboardwidgets/charts/assets/vendor/chartjs/chartjs-adapter-moment.min.js', 'chartsjs-adapter-js');
        $this->addCss('~/app/admin/dashboardwidgets/charts/assets/css/charts.css', 'charts-css');
        $this->addJs('~/app/admin/dashboardwidgets/charts/assets/js/charts.js', 'charts-js');
    }

    public function onFetchDatasets()
    {
        $start = post('start');
        $end = post('end');

        $start = Carbon::parse($start);
        $end = Carbon::parse($end);

        if ($start->eq($end)) {
            $start = $start->startOfDay();
            $end = $end->endOfDay();
        }

        return $this->getDatasets($start, $end);
    }

    protected function getDatasets($start, $end)
    {
        $config = [];
        $results[] = $this->makeDataset($config, $start, $end);

        return $results;
    }

    protected function makeDataset($config, $start, $end)
    {
        [$r, $g, $b] = sscanf($config['color'], '#%02x%02x%02x');
        $backgroundColor = sprintf('rgba(%s, %s, %s, 0.5)', $r, $g, $b);
        $borderColor = sprintf('rgb(%s, %s, %s)', $r, $g, $b);

        return array_merge($this->datasetOptions, [
            'label' => lang($config['label']),
            'data' => $this->queryDatasets($config, $start, $end),
            'backgroundColor' => $backgroundColor,
            'borderColor' => $borderColor,
        ]);
    }

    protected function queryDatasets($config, $start, $end)
    {
        $modelClass = $config['model'];
        $dateColumnName = $config['column'];

        $dateColumn = DB::raw('DATE_FORMAT('.$dateColumnName.', "%Y-%m-%d") as x');
        $query = $modelClass::select($dateColumn, DB::raw('count(*) as y'));
        $query->whereBetween($dateColumnName, [$start, $end])->groupBy('x');

        $dateRanges = $this->getDatePeriod($start, $end);
        $this->locationApplyScope($query);

        return $this->getPointsArray($dateRanges, $query->pluck('y', 'x'));
    }

    protected function getDatePeriod($start, $end)
    {
        return new DatePeriod(
            Carbon::parse($start)->startOfDay(),
            new DateInterval('P1D'),
            Carbon::parse($end)->endOfDay()
        );
    }

    protected function getPointsArray($dateRanges, Collection $result)
    {
        $points = [];
        $keyedResult = $result->keyBy('x');
        foreach ($dateRanges as $date) {
            $x = $date->format('Y-m-d');
            $points[] = [
                'x' => $x,
                'y' => $keyedResult->get($x) ?? 0,
            ];
        }

        return $points;
    }
}
