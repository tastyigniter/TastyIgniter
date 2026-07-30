<?php

declare(strict_types=1);

namespace Igniter\Admin\DashboardWidgets;

use DateTimeInterface;
use Igniter\Admin\Classes\BaseDashboardWidget;
use Igniter\Admin\Traits\HasChartDatasets;
use Igniter\Local\Traits\LocationAwareWidget;
use Override;

/**
 * Charts dashboard widget.
 */
class Charts extends BaseDashboardWidget
{
    use HasChartDatasets;
    use LocationAwareWidget;

    /**
     * @var string A unique alias to identify this widget.
     */
    protected string $defaultAlias = 'charts';

    protected array $datasetOptions = [
        'label' => null,
        'data' => [],
        'fill' => true,
        'backgroundColor' => null,
        'borderColor' => null,
    ];

    public array $contextDefinitions = [];

    public string $rangeFormat = 'MMMM D, YYYY';

    public ?string $dataset = null;

    protected ?array $datasetsConfig = null;

    protected static $registeredDatasets = [];

    #[Override]
    public function initialize(): void
    {
        $this->setProperty('rangeFormat', 'MMMM D, YYYY');
    }

    #[Override]
    public function defineProperties(): array
    {
        return [
            'dataset' => [
                'label' => 'admin::lang.dashboard.text_charts_dataset',
                'default' => 'reports',
                'type' => 'select',
                'placeholder' => 'lang:admin::lang.text_please_select',
                'options' => $this->getDatasetOptions(...),
                'validationRule' => 'required|alpha_dash',
            ],
        ];
    }

    #[Override]
    public function loadAssets(): void
    {
        $this->addJs('js/vendor.datetime.js', 'vendor-datetime-js');
        $this->addJs('js/vendor.chart.js', 'vendor-chart-js');

        $this->addCss('dashboardwidgets/charts.css', 'charts-css');
        $this->addJs('dashboardwidgets/charts.js', 'charts-js');
    }

    /**
     * Renders the widget.
     */
    #[Override]
    public function render(): string
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
        $this->vars['chartOptions'] = $this->getDataDefinition('options', []);
        $this->vars['chartData'] = $this->getData();
    }

    public function getActiveDataset(): mixed
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
        $definitions = $this->getDataDefinition('sets') ?? [];
        foreach (array_filter($definitions) as $config) {
            $datasets[] = $this->makeDataset($config, $start, $end);
        }

        return ['datasets' => $datasets];
    }

    public function getDatasetOptions(): array
    {
        return array_map(fn($context) => array_get($context, 'label'), $this->listSets());
    }

    public function addDataset(string $code, array $config = []): static
    {
        $this->datasetsConfig[$code] = $config;

        return $this;
    }

    public function mergeDataset(string $code, string $key, mixed $value): static
    {
        $this->datasetsConfig[$code][$key] = array_merge($this->datasetsConfig[$code][$key] ?? [], $value);

        return $this;
    }

    public static function registerDatasets($callback): void
    {
        static::$registeredDatasets[] = $callback;
    }

    public static function clearRegisteredDatasets(): void
    {
        static::$registeredDatasets = [];
    }

    protected function makeDataset(array $config, DateTimeInterface $start, DateTimeInterface $end): array
    {
        $config['label'] = lang(array_pull($config, 'label', ''));

        if ($color = array_pull($config, 'color')) {
            [$r, $g, $b] = sscanf($color, '#%02x%02x%02x');
        } else {
            [$r, $g, $b] = [random_int(0, 255), random_int(0, 255), random_int(0, 255)];
        }

        $config['data'] = $this->getDatasets($config, $start, $end);

        return array_merge($this->datasetOptions, [
            'backgroundColor' => sprintf('rgba(%s, %s, %s, 0.5)', $r, $g, $b),
            'borderColor' => sprintf('rgb(%s, %s, %s)', $r, $g, $b),
        ], array_except($config, ['model', 'column', 'priority', 'datasetFrom']));
    }

    protected function listSets()
    {
        if (!is_null($this->datasetsConfig)) {
            return $this->datasetsConfig;
        }

        $result = $this->getDefaultSets();

        foreach (static::$registeredDatasets as $callback) {
            foreach ($callback() as $code => $config) {
                $result[$code] = $config;
            }
        }

        $this->datasetsConfig = $result;

        $this->fireSystemEvent('admin.charts.extendDatasets');

        $this->datasetsConfig = collect($this->datasetsConfig)
            ->mapWithKeys(function(array $config, $code): array {
                if (array_key_exists('sets', $config)) {
                    $config['sets'] = sort_array($config['sets']);
                }

                return [$code => $config];
            })
            ->all();

        return $this->datasetsConfig;
    }

    protected function getDefaultSets(): array
    {
        return [
            'reports' => [
                'label' => 'igniter::admin.dashboard.text_reports_chart',
                'sets' => [],
            ],
        ];
    }
}
