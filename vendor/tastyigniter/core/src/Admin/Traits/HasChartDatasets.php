<?php

declare(strict_types=1);

namespace Igniter\Admin\Traits;

use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTimeInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

trait HasChartDatasets
{
    protected function getDataDefinition(string $key, $default = null)
    {
        return array_get($this->listSets(), $this->getActiveDataset().'.'.$key, $default);
    }

    protected function getDatasets(array $config, DateTimeInterface $start, DateTimeInterface $end): array
    {
        $dataPoints = $this->queryDatasets($config, $start, $end);

        return collect($this->getDatePeriod($start, $end))->map(fn($date): array => ['x' => $x = $date->format('Y-m-d'), 'y' => $dataPoints->get($x) ?? 0])->all();
    }

    protected function queryDatasets(array $config, DateTimeInterface $start, DateTimeInterface $end): Collection
    {
        $dateColumnName = $config['column'];

        $query = $config['model']::query()->select(
            DB::raw('DATE_FORMAT('.$dateColumnName.', "%Y-%m-%d") as x'),
            DB::raw('count(*) as y'),
        )->whereBetween($dateColumnName, [$start, $end])->groupBy('x');

        $this->locationApplyScope($query);

        return $query->get()->pluck('y', 'x');
    }

    protected function getDatePeriod(DateTimeInterface $start, DateTimeInterface $end): DatePeriod
    {
        return new DatePeriod(
            Carbon::parse($start)->startOfDay(),
            new DateInterval('P1D'),
            Carbon::parse($end)->endOfDay(),
        );
    }
}
