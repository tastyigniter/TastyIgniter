<?php

namespace Admin\DashboardWidgets;

use Admin\Classes\BaseDashboardWidget;
use Admin\Models\Customers_model;
use Admin\Models\Orders_model;
use Admin\Models\Reservations_model;
use Admin\Traits\HasChartDatasets;

/**
 * Charts dashboard widget.
 */
class Charts extends BaseDashboardWidget
{
    use HasChartDatasets;

    /**
     * @var string A unique alias to identify this widget.
     */
    protected $defaultAlias = 'charts';

    public function defineProperties()
    {
        return [
            'dataset' => [
                'label' => 'admin::lang.dashboard.text_charts_dataset',
                'default' => 'reports',
                'type' => 'select',
                'placeholder' => 'lang:admin::lang.text_please_select',
                'options' => $this->getDatasetOptions(),
                'validationRule' => 'required|alpha_dash',
            ],
        ];
    }

    /**
     * Renders the widget.
     */
    public function render()
    {
        $this->prepareVars();

        return $this->makePartial('charts/charts');
    }

    protected function prepareVars()
    {
        $this->vars['chartContext'] = $this->getActiveDataset();
        $this->vars['chartType'] = $this->getDataDefinition('type', 'line');
        $this->vars['chartLabel'] = $this->getDataDefinition('label', '--');
        $this->vars['chartIcon'] = $this->getDataDefinition('icon', 'fa fa-bar-chart-o');
        $this->vars['chartData'] = $this->getData();
    }

    public function getActiveDataset()
    {
        return $this->property('dataset', 'reports');
    }

    public function getData()
    {
        $start = $this->getStartDate();
        $end = $this->getEndDate();

        if ($datasetFromCallable = $this->getDataDefinition('datasetFrom')) {
            return $datasetFromCallable($this->getActiveDataset(), $start, $end);
        }

        $datasets = [];
        $definitions = $this->getDataDefinition('sets') ?? [$this->dataDefinition];
        foreach (array_filter($definitions) as $config) {
            $datasets[] = $this->makeDataset($config, $start, $end);
        }

        return ['datasets' => $datasets];
    }

    protected function getDatasetOptions()
    {
        return array_map(function ($context) {
            return array_get($context, 'label');
        }, $this->listSets());
    }

    protected function getDefaultSets()
    {
        return [
            'reports' => [
                'label' => 'admin::lang.dashboard.text_reports_chart',
                'sets' => [
                    [
                        'label' => 'lang:admin::lang.dashboard.charts.text_customers',
                        'color' => '#4DB6AC',
                        'model' => Customers_model::class,
                        'column' => 'created_at',
                    ],
                    [
                        'label' => 'lang:admin::lang.dashboard.charts.text_orders',
                        'color' => '#64B5F6',
                        'model' => Orders_model::class,
                        'column' => 'order_date',
                    ],
                    [
                        'label' => 'lang:admin::lang.dashboard.charts.text_reservations',
                        'color' => '#BA68C8',
                        'model' => Reservations_model::class,
                        'column' => 'reserve_date',
                    ],
                ],
            ],
        ];
    }
}
