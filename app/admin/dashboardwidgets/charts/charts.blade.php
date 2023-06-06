<div class="dashboard-widget widget-charts">
    <h6 class="widget-title"><i class="stat-icon {{ $chartIcon }}"></i> @lang($chartLabel)</h6>
    <div
        class="chart-container"
        data-control="chart"
        data-alias="{{ $this->alias }}"
        data-type="{{ $chartType }}"
        data-data='@json($chartData)'
    >
        <div class="chart-canvas chart-{{ name_to_id($chartType) }} chart-{{ name_to_id($this->alias) }}">
            <canvas id="{{ $this->alias }}"></canvas>
        </div>
    </div>
</div>
