/*
 * Charts plugin
 *
 * Data attributes:
 * - data-control="chart" - enables the plugin on an element
 */
+function ($) {
    "use strict"

    // FIELD CHART CONTROL CLASS DEFINITION
    // ============================

    var ChartControl = function (element, options) {
        this.options = options
        this.$el = $(element)
        this.$rangeEl = this.$el.find('[data-control="daterange"]')
        this.chartJs = null
        this.rangePicker = null

        // Init
        this.initChartJs();
        this.initDateRange();
    }

    ChartControl.DEFAULTS = {
        alias: undefined,
        rangeFormat: 'MMMM D, YYYY',
        responsive: true,
        type: 'line',
        options: {
            maintainAspectRatio: false,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        callback: function (value) {
                            if (value % 1 === 0) {
                                return value;
                            }
                        }
                    }
                }],
                xAxes: [{
                    type: 'time',
                    time: {
                        unit: 'day'
                    },
                    gridLines: {
                        display: false
                    }
                }]
            }
        }
    }

    ChartControl.DATE_RANGE_DEFAULTS = {
        opens: 'left',
        parentEl: '.chart-toolbar',
        startDate: moment().subtract(29, 'days'),
        endDate: moment(),
        timePicker: true,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
    }

    ChartControl.prototype.initChartJs = function () {
        this.chartJs = new Chart(this.$el.find('canvas'), this.options)
        this.chartJs.resize()
    }

    ChartControl.prototype.initDateRange = function () {
        this.$rangeEl.daterangepicker(ChartControl.DATE_RANGE_DEFAULTS, $.proxy(this.onRangeSelected, this))
        this.rangePicker = this.$rangeEl.data('daterangepicker');

        this.onRangeSelected(ChartControl.DATE_RANGE_DEFAULTS.startDate, ChartControl.DATE_RANGE_DEFAULTS.endDate)
    }

    ChartControl.prototype.unbind = function () {
        this.$el.chartControl('destroy')
        this.$el.removeData('ti.chartControl')
        this.chartJs = null

        this.$rangeEl.daterangepicker('destroy')
    }

    ChartControl.prototype.fetchChartData = function (start, end) {
        $.request(this.options.alias + '::onFetchDatasets', {
            data: {start: start, end: end},
            success: $.proxy(this.onUpdateChart, this)
        })
    }

    ChartControl.prototype.onRangeSelected = function (start, end, label) {
        $('span', this.$rangeEl).html(start.format(this.options.rangeFormat)
            + ' - ' + end.format(this.options.rangeFormat));

        this.onApplyChart()
    }

    ChartControl.prototype.onApplyChart = function () {
        this.fetchChartData(this.rangePicker.startDate.toISOString(), this.rangePicker.endDate.toISOString());
    }

    ChartControl.prototype.onUpdateChart = function (json) {
        this.chartJs.data.datasets = json

        this.chartJs.update();
        this.chartJs.resize()
    }

    // FIELD CHART CONTROL PLUGIN DEFINITION
    // ============================

    var old = $.fn.chartControl

    $.fn.chartControl = function (option) {
        var args = Array.prototype.slice.call(arguments, 1), result
        this.each(function () {
            var $this = $(this)
            var data = $this.data('ti.chartControl')
            var options = $.extend({}, ChartControl.DEFAULTS, $this.data(), typeof option === 'object' && option)
            if (!data) $this.data('ti.chartControl', (data = new ChartControl(this, options)))
            if (typeof option === 'string') result = data[option].apply(data, args)
            if (typeof result !== 'undefined') return false
        })

        return result ? result : this
    }

    $.fn.chartControl.Constructor = ChartControl

    // FIELD CHART CONTROL NO CONFLICT
    // =================

    $.fn.chartControl.noConflict = function () {
        $.fn.chartControl = old
        return this
    }

    // FIELD CHART CONTROL DATA-API
    // ===============

    $(document).render(function () {
        $('[data-control="chart"]').chartControl()
    })
}(window.jQuery)