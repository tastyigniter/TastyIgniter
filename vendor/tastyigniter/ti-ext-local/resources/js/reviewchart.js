/*
 * Review Charts plugin
 *
 * Data attributes:
 * - data-control="review-chart" - enables the plugin on an element
 */
+function ($) {
    "use strict"

    // FIELD CHART CONTROL CLASS DEFINITION
    // ============================

    var reviewChart = function (element, options) {
        this.options = options
        this.$el = $(element)
        this.chartJs = null

        // Init
        this.initChartJs();
    }

    reviewChart.DEFAULTS = {
        alias: undefined,
        responsive: true,
        type: 'bar',
        options: {
            responsive: true,
            legend: {
                display: false,
            },
            maintainAspectRatio: true,
            tooltips: {
                callbacks: {
                    label: function (tooltipItem, data) {
                        return data.labels[tooltipItem.index];
                    },
                },
            },
        }
    }

    reviewChart.prototype.initChartJs = function () {
        this.chartJs = new Chart(this.$el.find('canvas'), this.options)
        this.chartJs.resize()
    }

    reviewChart.prototype.unbind = function () {
        this.$el.reviewChart('destroy')
        this.$el.removeData('ti.reviewChart')
        this.chartJs = null
    }

    // FIELD CHART CONTROL PLUGIN DEFINITION
    // ============================

    var old = $.fn.reviewChart

    $.fn.reviewChart = function (option) {
        var args = Array.prototype.slice.call(arguments, 1), result
        this.each(function () {
            var $this = $(this)
            var data = $this.data('ti.reviewChart')
            var options = $.extend({}, reviewChart.DEFAULTS, $this.data(), typeof option === 'object' && option)
            if (!data) $this.data('ti.reviewChart', (data = new reviewChart(this, options)))
            if (typeof option === 'string') result = data[option].apply(data, args)
            if (typeof result !== 'undefined') return false
        })

        return result ? result : this
    }

    $.fn.reviewChart.Constructor = reviewChart

    // FIELD CHART CONTROL NO CONFLICT
    // =================

    $.fn.reviewChart.noConflict = function () {
        $.fn.reviewChart = old
        return this
    }

    // FIELD CHART CONTROL DATA-API
    // ===============

    $(document).render(function () {
        $('[data-control="review-chart"]').reviewChart()
    })

}(window.jQuery)
