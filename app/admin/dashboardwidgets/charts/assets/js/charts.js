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
        this.$rangeEl = $(options.rangeSelector)
        this.chartJs = null

        // Init
        this.initChartJs();
    }

    ChartControl.DEFAULTS = {
        alias: undefined,
        type: 'line',
        rangeSelector: '[data-control="daterange"]',
        options: {
            responsive: true,
            maintainAspectRatio: false,
        }
    }

    ChartControl.LINE_TYPE_OPTIONS = {
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function (value) {
                        if (value % 1 === 0) {
                            return value;
                        }
                    }
                }
            },
            x: {
                type: 'time',
                time: {
                    unit: 'day'
                },
                gridLines: {
                    display: false
                }
            }
        }
    }

    ChartControl.PIE_TYPE_OPTIONS = {
        plugins: {
            legend: {
                display: false,
            },
        },
    }

    ChartControl.prototype.initChartJs = function () {
        var chartOptions = (this.options.type === 'line') ? ChartControl.LINE_TYPE_OPTIONS : ChartControl.PIE_TYPE_OPTIONS
        this.options.options = $.extend({}, this.options.options, chartOptions)
        this.chartJs = new Chart(this.$el.find('canvas'), this.options)
        this.chartJs.update()
    }

    ChartControl.prototype.unbind = function () {
        this.$el.chartControl('destroy')
        this.$el.removeData('ti.chartControl')
        this.chartJs = null

        this.$rangeEl.daterangepicker('destroy')
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
