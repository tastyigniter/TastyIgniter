+function ($) {
    "use strict";

    var MapArea = function (element, options) {
        this.$el = $(element)
        this.$form = this.$el.closest('form')
        this.$mapToolbar = this.$el.find('[data-control="map-toolbar"]')
        this.$mapView = this.$el.find('[data-control="map-view"]')
        this.mapRefreshed = false
        this.options = options || {}

        this.init()
    }

    MapArea.prototype.init = function () {
        $(document).on('shown.bs.tab', 'a[data-toggle="tab"]', $.proxy(this.refreshMap, this))

        $(document).on('hide.bs.collapse', this.$el.find('.collapse'), $.proxy(this.onAreaHidden(), this))
        $(document).on('show.bs.collapse', this.$el.find('.collapse'), $.proxy(this.onAreaShown(), this))

        this.$el.on('change', '[data-toggle="map-shape"]', $.proxy(this.onShapeTypeToggle, this))

        this.$el.on('click', '[data-control="toggle-editor"]', $.proxy(this.onToggleEditor, this))
        this.$el.on('click', '[data-control="add-area"]', $.proxy(this.onAddArea, this))
        this.$el.on('click', '[data-control="remove-area"]', $.proxy(this.removeArea, this))

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

    MapArea.prototype.addArea = function (lastCounter, shapeId) {
        lastCounter++

        this.$el.get(0).setAttribute('data-last-counter', lastCounter)

        this.createShapeInput(shapeId)

        $('[data-control="repeater"]').repeater()
    }

    MapArea.prototype.removeArea = function (event) {
        var $button = $(event.currentTarget),
            confirmMsg = $button.data('confirm'),
            $selectedArea = this.$el.find('[data-control="area"]:not(.hide)')

        if (!$selectedArea.length || $selectedArea.length !== 1)
            return alert('Please select an area to delete.')

        if (!confirm(confirmMsg))
            return

        $selectedArea.remove()
        this.$el.find('[data-control="map-view"]').mapView('removeShape', $selectedArea.attr('id'));

        this.selectArea(this.$el.find('[data-control="area"]:first-child').attr('id'))
    }

    MapArea.prototype.selectArea = function (shapeId) {
        this.$el.find('[data-control="area"]').addClass('hide')

        this.$el.find('#' + shapeId).removeClass('hide')
    }

    MapArea.prototype.createShapeInput = function (shapeId) {
        var $areaContainer = this.$el.find('#'+shapeId),
            color = $areaContainer.data('areaColor'),
            shapeOptions = {
                id: shapeId,
                default: this.options.defaultShape,
                options: {
                    fillColor: color,
                    strokeColor: color
                },
            }

        this.$mapView.mapView('createShape', shapeOptions)
    }

    // EVENT HANDLERS
    // ============================

    MapArea.prototype.onShapeClicked = function (event, mapObject, shape) {
        if (!shape)
            return;

        if (!shape.getId())
            return;

        this.selectArea(shape.getId())

        this.$mapView.mapView('editShape', shape);
    }

    MapArea.prototype.onToggleEditor = function (event) {
        var $button = $(event.currentTarget),
            showEditor = !$button.hasClass('active')

        if (showEditor) {
            this.$el.find('.map-area-container').removeClass('hide')
            this.$mapView.closest('.map-view-container').removeClass('mw-100')
        } else {
            this.$el.find('.map-area-container').addClass('hide')
            this.$mapView.closest('.map-view-container').addClass('mw-100')
        }

        this.$mapView.mapView('clearAllEditable')
        this.$mapView.mapView('resize')
    }

    MapArea.prototype.onAddArea = function (event) {
        var self = this,
            lastCounter = parseInt(this.$el.get(0).getAttribute('data-last-counter')),
            $button = $(event.target),
            handler = $button.data('handler')

        $.request(handler, {
            data: {lastCounter: lastCounter},
            success: function (data, textStatus, jqXHR) {
                var dataArray = []

                dataArray = data

                for (var partial in dataArray) {
                    var selector = partial
                    if (jQuery.type(selector) === 'string' && selector.charAt(0) == '@') {
                        $(selector.substring(1)).append(dataArray[partial])
                    }
                }

                self.addArea(lastCounter, dataArray.areaShapeId)
            }
        })
    }

    MapArea.prototype.onAreaShown = function () {
        var $toolbar = this.$mapToolbar,
            shapeId = $toolbar.attr('data-selected-area')

        if (!shapeId)
            return;

        this.$el.find('[data-control="map-view"]').mapView('editShape', shapeId);
    }

    MapArea.prototype.onAreaHidden = function () {
        var $toolbar = this.$mapToolbar,
            shapeId = $toolbar.attr('data-selected-area')

        if (!shapeId)
            return;

        this.$el.find('[data-control="map-view"]').mapView('clearEditShape', shapeId)
    }

    MapArea.prototype.onShapeTypeToggle = function (event) {
        var $input = $(event.target),
            $container = $input.closest('[data-control="area"]'),
            shapeId = $container.attr('id'),
            type = $input.val()

        this.$mapView.mapView('hideShape', shapeId)
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

    $(document).render(function () {
        $('[data-control="map-area"]').mapArea();

        $('.tab-pane.active').find('[data-control="map-view"]').mapView('refresh');

    })

}(window.jQuery);
