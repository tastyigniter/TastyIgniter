+function ($) {
    "use strict";

    var MapArea = function (element, options) {
        this.$el = $(element)
        this.$form = this.$el.closest('form')
        this.$mapToolbar = this.$el.find('[data-control="map-toolbar"]')
        this.$mapModal = this.$el.find('[data-area-map-modal]')
        this.$mapView = this.$el.find('[data-control="map-view"]')
        this.mapRefreshed = false
        this.options = options || {}

        this.init()
    }

    MapArea.prototype.init = function () {
        this.$mapModal.on('shown.bs.modal', $.proxy(this.onModalShown, this))

        this.$el.on('change', '[data-toggle="map-shape"]', $.proxy(this.onShapeTypeToggle, this))
        this.$el.on('change', '[data-toggle="area-default"]', $.proxy(this.onAreaDefaultToggle, this))

        this.$el.on('click', '[data-control="add-area"]', $.proxy(this.onAddArea, this))
        this.$el.on('click', '[data-control="remove-area"]', $.proxy(this.removeArea, this))

        this.$mapView.on('click.shape.ti.mapview', $.proxy(this.onShapeClicked, this))

        this.$form.on('submit', $.proxy(this.onSubmitForm, this))
    }

    MapArea.prototype.onModalShown = function (event) {
        var $modal = $(event.target)

        this.refreshMap();

        if (!this.mapRefreshed)
            $modal.modal('hide');
    }

    MapArea.prototype.refreshMap = function () {
        var $mapView = $('[data-control="map-view"]')

        if (!this.mapRefreshed && $mapView.length) {
            $mapView.mapView('refresh');
            this.mapRefreshed = !!($mapView.find('.map-view').children().length);
        }
    }

    MapArea.prototype.addArea = function (lastCounter, shapeId) {
        lastCounter++

        this.$el.get(0).setAttribute('data-last-counter', lastCounter)

        if (this.mapRefreshed) {
            this.createShape(shapeId)
        }

        $('[data-control="repeater"]').repeater()
    }

    MapArea.prototype.removeArea = function (event) {
        var $button = $(event.currentTarget),
            confirmMsg = $button.data('confirmMessage'),
            $selectedArea = this.$el.find($button.data('areaSelector'))

        if (!$selectedArea.length || $selectedArea.length !== 1)
            return alert('Please select an area to delete.')

        if (!confirm(confirmMsg))
            return

        $selectedArea.remove()
        this.$mapView.mapView('removeShape', $selectedArea.attr('id'));
    }

    MapArea.prototype.createShape = function (shapeId) {
        var $areaContainer = this.$el.find('#' + shapeId),
            $areaShape = $areaContainer.find('[data-map-shape]'),
            shapeOptions = $areaShape.data()

        this.$mapView.mapView('createShape', $areaShape, shapeOptions)
    }

    // EVENT HANDLERS
    // ============================

    MapArea.prototype.onShapeClicked = function (event, mapObject, shape) {
        if (!shape)
            return;

        if (!shape.getId())
            return;

        this.$mapView.mapView('editShape', shape);
        this.$mapView.mapView('resize')
    }

    MapArea.prototype.onAddArea = function (event) {
        var self = this,
            lastCounter = parseInt(this.$el.get(0).getAttribute('data-last-counter')),
            $button = $(event.target),
            handler = $button.data('handler')

        $.request(handler, {
            data: {lastCounter: lastCounter}
        }).done(function (json) {
            self.addArea(lastCounter, json.areaShapeId)
        })
    }

    MapArea.prototype.onShapeTypeToggle = function (event) {
        var $input = $(event.target),
            $container = $input.closest('[data-control="area"]'),
            shapeId = $container.attr('id'),
            type = $input.val()

        $container.find('[data-map-shape]').get(0).setAttribute('data-default', type)

        if (!this.mapRefreshed && type !== 'address') {
            this.refreshMap()
            return
        }

        var shape = this.$mapView.mapView('getShape', shapeId)
        if (shape.options) {
            shape.options.default = type
            this.$mapView.mapView('hideShape', shapeId)
                .mapView('showShape', shapeId, type)
        }
    }

    MapArea.prototype.onAreaDefaultToggle = function (event) {
        var $input = $(event.target)
        $('[data-toggle="area-default"]').prop('checked', false)
        $input.prop('checked', true)
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

    MapArea.DEFAULTS = {
        alias: undefined,
        lastCounter: 0,
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
    })

}(window.jQuery);
