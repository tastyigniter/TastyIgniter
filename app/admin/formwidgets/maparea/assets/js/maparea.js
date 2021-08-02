+function ($) {
    "use strict";

    var MapArea = function (element, options) {
        this.$el = $(element)
        this.$form = this.$el.closest('form')
        this.$mapView = null
        this.options = options || {}
        this.$sortable = null
        this.$sortableContainer = $(this.options.sortableContainer, this.$el)

        this.init()
    }

    MapArea.prototype.init = function () {
        $(window).on('recordEditorModalShown', $.proxy(this.onModalShown, this))

        this.$el.on('click', '[data-control="load-area"]', $.proxy(this.onLoadArea, this))
        this.$el.on('click', '[data-control="remove-area"]', $.proxy(this.onRemoveArea, this))

        this.bindSorting()
    }

    MapArea.prototype.bindSorting = function () {
        var sortableOptions = {
            handle: this.options.sortableHandle,
        }

        if (this.$sortableContainer.get(0))
            this.$sortable = Sortable.create(this.$sortableContainer.get(0), sortableOptions)
    }

    MapArea.prototype.onModalShown = function (event, $modalEl) {
        var $typeInput = $modalEl.find('[data-toggle="map-shape"]'),
        $checkedTypeInput = $modalEl.find('[data-toggle="map-shape"]:checked')

        this.$mapView = $modalEl.find('[data-control="map-view"]')

        $typeInput.on('change', $.proxy(this.onShapeTypeToggle, this))

        if ($checkedTypeInput.val() === 'polygon' || $checkedTypeInput.val() === 'circle')
            this.refreshMap();

        this.$mapView.on('click.shape.ti.mapview', '.map-view', $.proxy(this.onShapeClicked, this))
    }

    MapArea.prototype.refreshMap = function () {
        if (this.$mapView.length && !this.$mapView.find('.map-view').children().length) {
            this.$mapView.mapView('refresh');
        }
    }

    MapArea.prototype.onLoadArea = function (event) {
        var self = this,
            $button = $(event.currentTarget),
            $area = $button.closest('[data-control="area"]')

        new $.ti.recordEditor.modal({
            alias: this.options.alias,
            recordId: $area.data('areaId'),
            onSubmit: $.proxy(self.onSubmitForm, self),
            onSave: function () {
                this.hide()
            }
        })
    }

    MapArea.prototype.onRemoveArea = function (event) {
        var $button = $(event.currentTarget),
            confirmMsg = $button.data('confirmMessage'),
            $selectedArea = $button.closest('[data-control="area"]'),
            areaId = $selectedArea.data('areaId')

        if (confirmMsg.length && !confirm(confirmMsg))
            return

        $.ti.loadingIndicator.show()
        $.request(this.options.removeHandler, {
            data: {areaId: areaId},
        }).done(function () {
            $selectedArea.remove()
        }).always(function () {
            $.ti.loadingIndicator.hide()
        });
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

    MapArea.prototype.onShapeTypeToggle = function (event) {
        var $input = $(event.target),
            $container = $input.closest('[data-control="area-form"]'),
            areaId = $container.find('[data-map-shape]').data('id'),
            type = $input.val()

        if (type === 'address')
            return

        this.refreshMap()

        var shape = this.$mapView.mapView('getShape', areaId)
        if (shape.options) {
            shape.options.default = type
            this.$mapView.mapView('hideShape', areaId).mapView('showShape', areaId, type)
            window.setTimeout(function() {
                this.$mapView.mapView('resize')
            }.bind(this), 200);
        }
    }

    MapArea.prototype.onSubmitForm = function (event) {
        try {
            var shapeData = this.$mapView.mapView('getShapeData'),
                $modalForm = this.$mapView.closest('[data-control="area-form"]')
        } catch (ex) {
            throw new Error(ex);
        }

        for (var shapeId in shapeData) {
            var circle = shapeData[shapeId].circle,
                polygon = shapeData[shapeId].polygon,
                vertices = shapeData[shapeId].vertices,
                color = $modalForm.find('[data-map-shape]').data('color')

            $modalForm.find('[data-shape-value="color"]').val(color)
            $modalForm.find('[data-shape-value="circle"]').val(JSON.stringify(circle))
            $modalForm.find('[data-shape-value="polygon"]').val(polygon)
            $modalForm.find('[data-shape-value="vertices"]').val(JSON.stringify(vertices))
        }
    }

    // HELPER METHODS
    // ============================

    MapArea.DEFAULTS = {
        alias: undefined,
        removeHandler: undefined,
        sortableHandle: '.maparea-item-handle',
        sortableContainer: '.field-maparea-items',
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
