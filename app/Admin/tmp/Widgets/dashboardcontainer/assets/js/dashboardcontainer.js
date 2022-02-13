/*
 * Dashboard container widget
 *
 * Data attributes:
 * - data-control="dashboard-container" - enables the dashboard container plugin
 *
 * JavaScript API:
 * $('#container').dashboardContainer()
 */
+function ($) { "use strict";

    // DASHBOARDCONTAINER CLASS DEFINITION
    // ============================

    var DashboardContainer = function(element, options) {
        this.options = options
        this.$el = $(element)
        this.$form = this.$el.closest('form')
        this.$toolbar = $('[data-container-toolbar]', this.$form)

        this.init();
        this.initSortable()
    }

    DashboardContainer.DEFAULTS = {
        alias: undefined,
        breakpoint: 768,
        columns: 10,
        sortableContainer: '.is-sortable',
    }

    DashboardContainer.prototype.init = function() {
        var self = this

        $.request(this.options.alias + '::onRenderWidgets')

        this.$el.on('click', '[data-control="remove-widget"]', function() {
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
                    onSort: $.proxy(self.postSortPriorities, self)
                })
            }
        })
    }

    DashboardContainer.prototype.postSortPriorities = function (event) {
        var aliases = [],
            sortOrders = [],
            self = this

        $('[data-widget-alias]', this.$el).each(function () {
            aliases.push($(this).val())
        })

        $('[data-widget-priority]', this.$el).each(function() {
            sortOrders.push($(this).val())
        })

        this.$form.request(self.options.alias + '::onSetWidgetPriorities', {
            data: {
                'aliases': aliases.join(','),
                'priorities': sortOrders.join(',')
            }
        })
    }

    // DASHBOARDCONTAINER PLUGIN DEFINITION
    // ============================

    var old = $.fn.dashboardContainer

    $.fn.dashboardContainer = function(option) {
        return this.each(function() {
            var $this   = $(this)
            var data    = $this.data('ti.dashboardContainer')
            var options = $.extend({}, DashboardContainer.DEFAULTS, $this.data(), typeof option === 'object' && option)
            if (!data) $this.data('ti.dashboardContainer', (data = new DashboardContainer(this, options)))
            if (typeof option === 'string') data[option].call($this)
        })
    }

    $.fn.dashboardContainer.Constructor = DashboardContainer

    // DASHBOARDCONTAINER NO CONFLICT
    // =================

    $.fn.dashboardContainer.noConflict = function() {
        $.fn.dashboardContainer = old
        return this
    }

    // DASHBOARDCONTAINER DATA-API
    // ===============

    $(document).render(function() {
        $('[data-control="dashboard-container"]').dashboardContainer()
    })
}(window.jQuery);
