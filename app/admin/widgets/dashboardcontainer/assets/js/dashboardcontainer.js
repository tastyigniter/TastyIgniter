/*
 * Dashboard container widget
 *
 * Data attributes:
 * - data-control="dashboard-container" - enables the dashboard container plugin
 *
 * JavaScript API:
 * $('#container').dashboardContainer()
 */
+function ($) {
    "use strict";

    // DASHBOARDCONTAINER CLASS DEFINITION
    // ============================

    var DashboardContainer = function (element, options) {
        this.options = options
        this.$el = $(element)
        this.$form = this.$el.closest('form')
        this.$toolbar = $('[data-container-toolbar]')
        this.$dateRangeEl = $(options.dateRangeSelector, this.$toolbar)

        this.init();
        this.initSortable()
        this.initDateRange();
    }

    DashboardContainer.DEFAULTS = {
        alias: undefined,
        breakpoint: 768,
        columns: 10,
        sortableContainer: '.is-sortable',
        dateRangeFormat: 'MMMM D, YYYY',
        dateRangeSelector: '[data-control="daterange"]',
    }

    DashboardContainer.DATE_RANGE_DEFAULTS = {
        opens: 'left',
        startDate: moment().subtract(29, 'days'),
        endDate: moment(),
        timePicker: true,
        locale: {
            format: 'MM/DD/YYYY'
        },
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        parentEl: '.dashboard-toolbar',
    }

    DashboardContainer.prototype.init = function () {
        var self = this

        this.fetchWidgets()

        this.$el.on('click', '[data-control="remove-widget"]', function () {
            var $btn = $(this)
            if (!confirm('Are you sure you want to do this?'))
                return false;

            $.ti.loadingIndicator.show()
            self.$form.request(self.options.alias + '::onRemoveWidget', {
                data: {
                    'alias': $('[data-widget-alias]', $btn.closest('div.widget-item')).val()
                }
            }).done(function () {
                $btn.closest('div.col').remove()
            }).always(function () {
                $.ti.loadingIndicator.hide()
            })
        })
    }

    DashboardContainer.prototype.initSortable = function () {
        var self = this,
            $sortableContainer

        $(window).on('ajaxUpdateComplete', function () {
            $sortableContainer = $(self.options.sortableContainer, self.$el)
            if ($sortableContainer.length) {
                Sortable.create($sortableContainer.get(0), {
                    handle: '.handle',
                    onSort: $.proxy(self.onSortWidgets, self)
                })
            }
        })
    }

    DashboardContainer.prototype.initDateRange = function () {
        var options = $.extend({}, DashboardContainer.DATE_RANGE_DEFAULTS, this.$dateRangeEl.data())
        this.$dateRangeEl.daterangepicker(options, $.proxy(this.onDateRangeSelected, this))
    }

    DashboardContainer.prototype.onSortWidgets = function (event) {
        var aliases = [],
            sortOrders = [],
            self = this

        $('[data-widget-alias]', this.$el).each(function () {
            aliases.push($(this).val())
        })

        $('[data-widget-priority]', this.$el).each(function () {
            sortOrders.push($(this).val())
        })

        this.$form.request(self.options.alias + '::onSetWidgetPriorities', {
            data: {
                'aliases': aliases,
                'priorities': sortOrders
            }
        })
    }

    DashboardContainer.prototype.onDateRangeSelected = function (start, end, label) {
        $('span', this.$dateRangeEl).html(start.format(this.options.dateRangeFormat)
            + ' - ' + end.format(this.options.dateRangeFormat));

        $('.dashboard-widgets .progress-indicator').show()

        this.$dateRangeEl.request(this.options.alias + '::onSetDateRange', {
            data: {start: start.toISOString(), end: end.toISOString()}
        }).always(function () {
            $('.dashboard-widgets .progress-indicator').attr('style', 'display: none !important;');
        })
    }

    DashboardContainer.prototype.fetchWidgets = function () {
        $.request(this.options.alias + '::onRenderWidgets').always(function () {
            $('.dashboard-widgets .progress-indicator').attr('style', 'display: none !important;');
        })
    }

    // DASHBOARDCONTAINER PLUGIN DEFINITION
    // ============================

    var old = $.fn.dashboardContainer

    $.fn.dashboardContainer = function (option) {
        return this.each(function () {
            var $this = $(this)
            var data = $this.data('ti.dashboardContainer')
            var options = $.extend({}, DashboardContainer.DEFAULTS, $this.data(), typeof option === 'object' && option)
            if (!data) $this.data('ti.dashboardContainer', (data = new DashboardContainer(this, options)))
            if (typeof option === 'string') data[option].call($this)
        })
    }

    $.fn.dashboardContainer.Constructor = DashboardContainer

    // DASHBOARDCONTAINER NO CONFLICT
    // =================

    $.fn.dashboardContainer.noConflict = function () {
        $.fn.dashboardContainer = old
        return this
    }

    // DASHBOARDCONTAINER DATA-API
    // ===============

    $(document).render(function () {
        $('[data-control="dashboard-container"]').dashboardContainer()
    })
}(window.jQuery);
