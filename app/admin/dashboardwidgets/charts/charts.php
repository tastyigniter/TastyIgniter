<div class="dashboard-widget widget-charts">
    <h6 class="widget-title"><?= e(trans($this->property('title'))) ?></h6>
    <div
        class="chart-container"
        data-control="chart"
        data-alias="<?= $this->alias; ?>"
        data-range-selector="#<?= $this->alias; ?>-daterange"
        data-range-parent-selector="#<?= $this->alias; ?>-daterange-parent"
        data-range-format="<?= $this->property('rangeFormat'); ?>"
    >
        <div
            id="<?= $this->alias; ?>-daterange-parent"
            class="chart-toolbar d-flex justify-content-end pb-3"
        >
            <button
                id="<?= $this->alias; ?>-daterange"
                class="btn btn-light btn-sm"
                data-control="daterange"
            >
                <i class="fa fa-calendar"></i>&nbsp;&nbsp;
                <span><?php echo lang('admin::lang.dashboard.text_select_range'); ?></span>&nbsp;&nbsp;
                <i class="fa fa-caret-down"></i>
            </button>
        </div>
        <div class="chart-canvas">
            <canvas
                id="<?= $this->alias; ?>"
            ></canvas>
        </div>
    </div>
</div>
