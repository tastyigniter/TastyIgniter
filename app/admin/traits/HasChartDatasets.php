<?php

namespace Admin\Traits;

use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use Illuminate\Support\Facades\DB;

trait HasChartDatasets
{
    use LocationAwareWidget;

    protected $datasetOptions = [
        'label' => null,
        'data' => [],
        'fill' => true,
        'backgroundColor' => null,
        'borderColor' => null,
    ];

    protected $dataDefinition;

    protected static $registeredDatasets = [];

    public static function registerDatasets($callback)
    {
        static::$registeredDatasets[] = $callback;
    }

    public function loadAssets()
    {
        $this->addJs('~/app/admin/dashboardwidgets/charts/assets/vendor/chartjs/Chart.min.js', 'chartsjs-js');
        $this->addJs('~/app/admin/dashboardwidgets/charts/assets/vendor/chartjs/chartjs-adapter-moment.min.js', 'chartsjs-adapter-js');
        $this->addCss('~/app/admin/dashboardwidgets/charts/assets/css/charts.css', 'charts-css');
        $this->addJs('~/app/admin/dashboardwidgets/charts/assets/js/charts.js', 'charts-js');
    }

    protected function makeDataset($config, $start, $end)
    {
        $config['label'] = lang(array_pull($config, 'label'));

        if ($color = array_pull($config, 'color')) {
            [$r, $g, $b] = sscanf($color, '#%02x%02x%02x');
        } else {
            [$r, $g, $b] = [random_int(0, 255), random_int(0, 255), random_int(0, 255)];
        }

        $config['data'] = $this->getDatasets($config, $start, $end);

        return array_merge($this->datasetOptions, [
            'backgroundColor' => sprintf('rgba(%s, %s, %s, 0.5)', $r, $g, $b),
            'borderColor' => sprintf('rgb(%s, %s, %s)', $r, $g, $b),
        ], array_except($config, ['model', 'column', 'datasetFrom']));
    }

    protected function listSets()
    {
        $result = $this->getDefaultSets();

        foreach (static::$registeredDatasets as $callback) {
            foreach ($callback() as $code => $config) {
                $result[$code] = $config;
            }
        }

        return $result;
    }

    protected function getDataDefinition($key, $default = null)
    {
        if (is_null($this->dataDefinition))
            $this->dataDefinition = array_get($this->listSets(), $this->getActiveDataset());

        return array_get($this->dataDefinition, $key, $default);
    }

    protected function getDatasets($config, $start, $end)
    {
        $dataPoints = $this->queryDatasets($config, $start, $end);

        return collect($this->getDatePeriod($start, $end))->map(function ($date) use ($dataPoints) {
            return ['x' => $x = $date->format('Y-m-d'), 'y' => $dataPoints->get($x) ?? 0];
        })->all();
    }

    protected function queryDatasets($config, $start, $end)
    {
        $dateColumnName = $config['column'];

        $query = $config['model']::query()->select(
            DB::raw('DATE_FORMAT('.$dateColumnName.', "%Y-%m-%d") as x'),
            DB::raw('count(*) as y')
        )->whereBetween($dateColumnName, [$start, $end])->groupBy('x');

        $this->locationApplyScope($query);

        return $query->get()->pluck('y', 'x');
    }

    protected function getDatePeriod($start, $end)
    {
        return new DatePeriod(
            Carbon::parse($start)->startOfDay(),
            new DateInterval('P1D'),
            Carbon::parse($end)->endOfDay()
        );
    }
}
