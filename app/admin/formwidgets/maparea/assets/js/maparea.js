+function ($) {
    "use strict";

    var MapArea = function (element, options) {
        this.$el = $(element)
        this.$form = this.$el.closest('form')
        this.$mapView = this.$el.find('[data-control="map-view"]')
        this.mapRefreshed = false
        this.options = options || {}

        this.init()
    }

    MapArea.prototype.init = function () {
        $(document).on('shown.bs.tab', 'a[data-toggle="tab"]', $.proxy(this.refreshMap, this))
        $(document).on('hide.bs.collapse', this.$el.find('.collapse'), $.proxy(this.onPanelHidden, this))
        $(document).on('show.bs.collapse', this.$el.find('.collapse'), $.proxy(this.onPanelShown, this))

        this.$el.on('change', '[data-toggle="map-shape"]', $.proxy(this.onShapeTypeToggle, this))

        this.$el.on('click', '[data-control="add-panel"]', $.proxy(this.addPanel, this))
        this.$el.on('click', '[data-control="add-row"]', this.addRow)
        this.$el.on('click', '[data-control="remove-panel"]', $.proxy(this.removePanel, this))

        this.$mapView.on('click.shape.ti.mapview', $.proxy(this.onShapeClicked, this))

        this.$form.on('submit', $.proxy(this.onSubmitForm, this))
    }

    MapArea.prototype.refreshMap = function (event) {
        var $tab = $($(event.target).attr('href')),
            $prevTab = $(event.relatedTarget),
            $mapView = $tab.find('[data-control="map-view"]')

        if (!this.mapRefreshed && $mapView.length) {
            $tab.find('[data-control="map-view"]').mapView('refresh');
            this.mapRefreshed = !!($mapView.find('.map-view').children().length);

            if (!this.mapRefreshed)
                $prevTab.tab('show');
        }
    }

    MapArea.prototype.addPanel = function () {
        var container = this.$el.get(0).querySelector('[data-control="area-list"]'),
            counter = parseInt(container.getAttribute('data-last-counter')),
            appendTo = container.querySelector('[data-append-to]'),
            template = container.getAttribute('data-template'),
            $template = $(template).clone(),
            indexRegEx = new RegExp('\\%\\%index\\%\\%', "g"),
            colorRegEx = new RegExp('\\%\\%color\\%\\%', "g")

        if (!$template.length) {
            throw new Error("No template element found, set one with attribute [data-template]")
        }

        counter++

        $(appendTo).append($template.get(0).innerHTML
            .replace(indexRegEx, counter)
            .replace(colorRegEx, this.areaColor(counter))
        )

        container.setAttribute('data-last-counter', counter)
        $(appendTo).find('select.form-control').select2({minimumResultsForSearch: Infinity})

        var shapeId = $(appendTo).find('.panel:last-child').attr('id')
        this.createShapeInput(counter, shapeId)
    }

    MapArea.prototype.removePanel = function (element) {
        var $button = $(element.currentTarget),
            confirmMsg = $button.data('confirm'),
            $container = $('[data-control="area-list"]', this.$el),
            $targetElement = $($button.data('target'), $container)

        if (!confirm(confirmMsg))
            return

        $targetElement.remove()
        this.$el.find('[data-control="map-view"]').mapView('removeShape', $targetElement.attr('id'));
    }

    MapArea.prototype.addRow = function () {
        var container = $($(this).data('parent')).get(0),
            parentRow = container.getAttribute('data-parent-row'),
            lastCounter = container.getAttribute('data-last-counter'),
            nextCounter = parseInt(lastCounter) + 1,
            appendTo = container.querySelector('[data-append-to]'),
            template = container.getAttribute('data-template'),
            $template = $(template).clone(),
            indexRegEx = new RegExp('\\%\\%index\\%\\%', "g"),
            parentRowRegEx = new RegExp('\\%\\%row\\%\\%', "g")

        if (!$template.length) {
            throw new Error("No template element found, set one with attribute [data-template]")
        }

        $(appendTo).append($template.get(0).innerHTML
            .replace(indexRegEx, nextCounter)
            .replace(parentRowRegEx, parentRow)
        )

        container.setAttribute('data-last-counter', nextCounter)
        $(appendTo).find('select.form-control').select2({minimumResultsForSearch: Infinity})
    }

    MapArea.prototype.createShapeInput = function (counter, shapeId) {
        var color = this.areaColor(counter),
            shapeOptions = {
                id: shapeId,
                default: this.options.defaultShape,
                options: {
                    fillColor: color,
                    strokeColor: color
                },
            }

        this.$el.find('[data-control="map-view"]').mapView('createShape', shapeOptions);
    }

    MapArea.prototype.onPanelShown = function (event) {
        var panel = $(event.target)
        if (!panel.parents('[data-control="area-list"]'))
            return;

        if (!panel.parent('.panel').attr('id'))
            return;

        this.$el.find('[data-control="map-view"]').mapView('editShape', panel.parent('.panel').attr('id'));
    }

    MapArea.prototype.onPanelHidden = function (event) {
        var panel = $(event.target)
        if (!panel.parents('[data-control="area-list"]'))
            return;

        if (!panel.parent('.panel').attr('id'))
            return;

        this.$el.find('[data-control="map-view"]')
            .mapView('clearEditShape', panel.parent('.panel').attr('id'))
    }

    MapArea.prototype.onShapeTypeToggle = function (event) {
        var $input = $(event.target),
            $panel = $input.closest('.panel'),
            shapeId = $panel.attr('id'),
            type = $input.val()

        if (type != 'circle') {
            $panel.find('[data-area-color]').addClass('fa-stop').removeClass('fa-circle')
        } else {
            $panel.find('[data-area-color]').addClass('fa-circle').removeClass('fa-stop')
        }

        this.$el.find('[data-control="map-view"]')
            .mapView('hideShape', shapeId)
            .mapView('showShape', shapeId, type)
            .mapView('editShape', shapeId);
    }

    MapArea.prototype.onSubmitForm = function (event) {
        try {
            var shapeData = this.$el.find('[data-control="map-view"]').mapView('getShapeData')
        } catch (ex) {
            throw new Error(ex);
        }

        for (var shapeId in shapeData) {
            var circle = shapeData[shapeId].circle,
                polygon = shapeData[shapeId].polygon,
                vertices = shapeData[shapeId].vertices

            this.$el.find('#' + shapeId + ' [data-shape-value="circle"]').val(JSON.stringify(circle))
            this.$el.find('#' + shapeId + ' [data-shape-value="polygon"]').val(polygon)
            this.$el.find('#' + shapeId + ' [data-shape-value="vertices"]').val(JSON.stringify(vertices))
        }
    }

    // HELPER METHODS
    // ============================

    MapArea.prototype.areaColor = function (index) {
        if (!this.options.areaColors)
            return;

        if (this.options.areaColors[index])
            return this.options.areaColors[index];
    }

    // EVENT HANDLERS
    // ============================

    MapArea.prototype.onShapeClicked = function (event, mapObject, shape) {
        if (!shape)
            return;

        this.$el.find('.collapse').collapse('hide')
        $('#' + shape.getId()).find('.collapse').collapse('toggle')
    }

    MapArea.DEFAULTS = {
        areaColors: [],
        defaultShape: 'polygon',
        vertices: null,
        circle: null
    }

    // PLUGIN DEFINITION
    // ============================

    var old = $.fn.mapArea

    $.fn.mapArea = function (option) {
        var args = arguments;

        return this.each(function () {
            var $this = $(this)
            var data = $this.data('ti.mapArea')
            var options = $.extend({}, MapArea.DEFAULTS, $this.data(), typeof option == 'object' && option)
            if (!data) $this.data('ti.mapArea', (data = new MapArea(this, options)))
            if (typeof option == 'string') data[option].apply(data, args)
        })
    }

    $.fn.mapArea.Constructor = MapArea

    $.fn.mapArea.noConflict = function () {
        $.fn.mapArea = old
        return this
    }

    $(document).ready(function () {
        $('[data-control="map-area"]').mapArea();

        $('.tab-pane.active').find('[data-control="map-view"]').mapView('refresh');

    })

}(window.jQuery);
