<?php namespace Admin\DashboardWidgets;

use Admin\Classes\BaseDashboardWidget;
use Admin\Models\Customers_model;
use Admin\Models\Orders_model;
use Admin\Models\Reservations_model;
use Admin\Models\Reviews_model;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DB;
use Illuminate\Support\Collection;

/**
 * Charts dashboard widget.
 */
class Charts extends BaseDashboardWidget
{
    /**
     * @var string A unique alias to identify this widget.
     */
    protected $defaultAlias = 'charts';

    public function initialize()
    {
        $this->setProperty('rangeFormat', 'MMMM D, YYYY');
    }

    public function defineProperties()
    {
        return [
            'title' => [
                'label' => 'admin::lang.dashboard.label_widget_title',
                'default' => 'admin::lang.dashboard.text_reports_chart',
            ],
        ];
    }

    /**
     * Renders the widget.
     */
    public function render()
    {
        return $this->makePartial('charts/charts');
    }

    public function loadAssets()
    {
        $this->addJs('~/app/system/assets/ui/js/vendor/moment.min.js', 'moment-js');
        $this->addJs('vendor/daterange/daterangepicker.js', 'daterangepicker-js');
        $this->addCss('vendor/daterange/daterangepicker.css', 'daterangepicker-css');

        $this->addJs('vendor/chartjs/Chart.min.js', 'chartsjs-js');
        $this->addCss('css/charts.css', 'charts-css');
        $this->addJs('js/charts.js', 'charts-js');
    }

    public function listContext()
    {
        return [
            'order' => [
                'label' => 'lang:admin::lang.dashboard.charts.text_orders',
                'color' => '#64B5F6',
                'model' => Orders_model::class,
                'column' => 'order_date',
            ],
            'reservation' => [
                'label' => 'lang:admin::lang.dashboard.charts.text_reservations',
                'color' => '#BA68C8',
                'model' => Reservations_model::class,
                'column' => 'reserve_date',
            ],
            'customer' => [
                'label' => 'lang:admin::lang.dashboard.charts.text_customers',
                'color' => '#4DB6AC',
                'model' => Customers_model::class,
                'column' => 'date_added',
            ],
            'review' => [
                'label' => 'lang:admin::lang.dashboard.charts.text_reviews',
                'color' => '#FFB74D',
                'model' => Reviews_model::class,
                'column' => 'date_added',
            ],
        ];
    }

    public function onFetchDatasets()
    {
        $start = post('start');
        $end = post('end');

        $start = Carbon::parse($start);
        $end = Carbon::parse($end);

        return $this->getDatasets($start, $end);
    }

    protected function getDatasets($start, $end)
    {
        $result = [];
        foreach ($this->listContext() as $context => $config) {
            $result[] = $this->makeDataset($config, $start, $end);
        }

        return $result;
    }

    protected function makeDataset($config, $start, $end)
    {
        list($r, $g, $b) = sscanf($config['color'], '#%02x%02x%02x');
        $backgroundColor = sprintf('rgba(%s, %s, %s, 0.5)', $r, $g, $b);
        $borderColor = sprintf('rgb(%s, %s, %s)', $r, $g, $b);

        return [
            'label' => lang($config['label']),
            'data' => $this->queryDatasets($config, $start, $end),
            'fill' => TRUE,
            'backgroundColor' => $backgroundColor,
            'borderColor' => $borderColor,
        ];
    }

    protected function queryDatasets($config, $start, $end)
    {
        $modelClass = $config['model'];
        $dateColumnName = $config['column'];

        $dateColumn = DB::raw('DATE_FORMAT('.$dateColumnName.', "%Y-%m-%d") as x');
        $query = $modelClass::select($dateColumn, DB::raw('count(*) as y'));
        $query->whereBetween($dateColumnName, [$start, $end])->groupBy('x');

        $dateRanges = $this->getDatePeriod($start, $end);

        return $this->getPointsArray($dateRanges, $query->get());
    }

    protected function getDatePeriod($start, $end)
    {
        return new DatePeriod(
            Carbon::parse($start),
            new DateInterval('P1D'),
            Carbon::parse($end)
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
