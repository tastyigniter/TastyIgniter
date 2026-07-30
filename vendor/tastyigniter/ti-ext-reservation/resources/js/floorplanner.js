+function ($) {
    "use strict";

    var FloorPlanner = function (element, options) {
        this.options = options
        this.$container = $(element)

        this.computedStyle = window.getComputedStyle(document.documentElement)
        this.options.textOptions.fontFamily = this.computedStyle.getPropertyValue('--bs-font-sans-serif')
        this.options.textOptions.fill = this.computedStyle.getPropertyValue('--bs-body-color')

        this.$container.addClass('initialized')

        this.stage = null
        this.layer = null
        this.transformer = null
        this.transformerOptions = {}
        this.zoom = 1

        this.init()
        this.initKonva()
    }

    FloorPlanner.prototype.init = function () {
        this.$container.on('click', '[data-floor-planner-control]', $.proxy(this.onControlClick, this))
        $('[data-control="form-tabs"] [data-bs-toggle="tab"]').on('shown.bs.tab', $.proxy(this.initKonva, this))
    }

    FloorPlanner.prototype.initKonva = function () {
        var self = this,
            $el = this.$container.find(this.options.canvasSelector)

        if (this.stage || this.$container.is(':hidden'))
            return

        this.stage = new Konva.Stage({
            container: $el[0],
            width: $el.width() - this.options.tableVerticalPadding,
            height: this.options.canvasHeight,
            draggable: true,
        })

        this.layer = new Konva.Layer()
        this.stage.add(this.layer)

        this.createTables()

        this.stage.on('click', $.proxy(this.onClickStage, this))
            .on('mouseenter', function () {
                self.stage.container().style.cursor = 'grab';
            })
            .on('mouseleave', function () {
                self.stage.container().style.cursor = 'default';
            })
            .on('dragend', function () {
                self.saveState()
            })

        this.loadState()

        this.layer.draw()
    }

    FloorPlanner.prototype.saveState = function () {
        var state = {stage: {}, groups: []}

        if (this.options.alias === undefined)
            return

        state.stage.x = this.stage.x()
        state.stage.y = this.stage.y()
        state.stage.scaleX = this.stage.scaleX()
        state.stage.scaleY = this.stage.scaleY()

        this.layer.getChildren(function (node) {
            return node.getClassName() === 'Group';
        }).forEach(function (group) {
            state.groups.push({
                id: group.id(),
                x: group.x(),
                y: group.y(),
                rotation: group.rotation(),
            })
        })

        $.request(this.options.alias + '::onSaveState', {
            data: {state: JSON.stringify(state)},
        })
    }

    FloorPlanner.prototype.loadState = function () {
        try {
            var state = JSON.parse(this.$container.find(this.options.dataInputSelector).val())
        } catch (ex) {
            return
        }

        if (!state)
            return

        this.stage.x(state.stage.x)
        this.stage.y(state.stage.y)
        this.stage.scaleX(state.stage.scaleX)
        this.stage.scaleY(state.stage.scaleY)

        if (!state.groups)
            return

        state.groups.forEach(function (groupState) {
            var group = this.layer.findOne('#' + groupState.id)
            if (group) {
                group.x(groupState.x)
                group.y(groupState.y)
                group.rotation(groupState.rotation)
            }
        }, this)
    }

    FloorPlanner.prototype.createTables = function () {
        var self = this,
            count = 1

        for (var i = 0; i < this.options.diningTables.length; i++) {
            var diningTable = this.options.diningTables[i],
                group = new Konva.Group({
                    id: 'group-' + diningTable.id,
                    x: diningTable.seatLayout ? diningTable.seatLayout.x : this.options.seatWidth * count,
                    y: diningTable.seatLayout ? diningTable.seatLayout.y : this.options.seatWidth * count,
                    rotation: diningTable.seatLayout ? diningTable.seatLayout.rotation : 0,
                    draggable: !this.options.previewMode,
                })

            if (diningTable.shape === 'round') {
                this.applyRoundLayout(diningTable)
            } else {
                this.applyRectLayout(diningTable)
            }

            this.createTable(diningTable, group)
            this.createTableInfo(diningTable, group)

            group.on('click', $.proxy(this.onClickShape, this))
                .on('mouseenter', function () {
                    self.stage.container().style.cursor = 'pointer';
                })
                .on('mouseleave', function () {
                    self.stage.container().style.cursor = 'grab';
                })
                .on('transformend', function () {
                    self.saveState()
                })

            this.layer.add(group)
            ++count
        }
    }

    FloorPlanner.prototype.applyRectLayout = function (diningTable) {
        var width, height, seats = {},
            seatCapacity = diningTable.capacity

        width = height = this.options.seatWidth

        if (seatCapacity === 2) {
            seats.top = seats.bottom = 1
        } else if (seatCapacity === 4) {
            seats.top = seats.bottom = seats.left = seats.right = 1
        } else if (seatCapacity > 2) {
            if ((seatCapacity % 2) === 0) {
                seats.left = seats.right = 1
                seats.top = seats.bottom = (seatCapacity - 2) / 2;
            } else {
                seats.left = 1;
                seats.top = seats.bottom = (seatCapacity - 1) / 2;
            }

            width = (this.options.seatWidth * seats.top) + (this.options.seatSpacing * (seats.top - 1))
        } else {
            seats.left = 1;
        }

        diningTable.shapeLayout = {
            id: 'table-' + diningTable.id,
            seats: seats,
            x: this.options.tableLayoutPadding,
            y: this.options.tableLayoutPadding,
            width: width + (this.options.tableHorizontalPadding * 2),
            height: height + (this.options.tableVerticalPadding * 2),
            cornerRadius: 4
        }
    }

    FloorPlanner.prototype.applyRoundLayout = function (diningTable) {
        var width, radius,
            seatCapacity = diningTable.capacity,
            seats = {round: seatCapacity},
            remaining = seatCapacity - 2

        width = this.options.seatWidth

        if (seatCapacity > 2) {
            width = this.options.seatWidth * Math.round(remaining / 2)
        }

        width += (this.options.seatWidth / 2) * 2
        radius = width / 2

        diningTable.shapeLayout = {
            id: 'table-' + diningTable.id,
            seats: seats,
            x: this.options.tableLayoutPadding,
            y: this.options.tableLayoutPadding,
            radius: radius,
            width: width,
        }
    }

    FloorPlanner.prototype.createTableInfo = function (diningTable, group) {
        var tableName, options = $.extend({
            name: 'table-name',
            id: diningTable.id,
            x: this.options.tableLayoutPadding,
            y: (diningTable.shapeLayout.height / 2) - 7,
            text: diningTable.name,
            width: diningTable.shapeLayout.width,
        }, this.options.textOptions)

        if (diningTable.shape === 'round') {
            options.x = -diningTable.shapeLayout.radius
            options.y = -this.options.tableLayoutPadding
        }

        tableName = new Konva.Text(options)
        group.add(tableName)

        if (diningTable.customerName) {
            group.add(tableName.clone({
                name: 'table-guest',
                x: options.x,
                y: options.y = options.y + this.options.textOptions.height,
                text: diningTable.customerName,
                fontSize: 12,
            }))
        }

        group.add(tableName.clone({
            name: 'table-description',
            x: options.x,
            y: options.y + this.options.textOptions.height,
            text: diningTable.description,
            fontSize: 12,
        }))

        tableName.on('dblclick', $.proxy(this.onDoubleClickControl, this))

        return tableName
    }

    FloorPlanner.prototype.createTable = function (diningTable, group) {
        var table, options = $.extend({}, diningTable.shapeLayout, {
            name: 'table-top',
            fill: diningTable.tableColor ?? this.options.tableColor,
            stroke: diningTable.seatColor ?? this.options.seatColor,
            strokeWidth: 1,
        })

        if (diningTable.shape === 'round') {
            table = new Konva.Circle(options)

            this.createRoundSeats(diningTable, group)
        } else {
            table = new Konva.Rect(options)

            this.createRectSeats(diningTable, group)
        }

        table.id(diningTable.id)
        group.add(table)
        return table
    }

    FloorPlanner.prototype.createRectSeats = function (diningTable, group) {
        for (var position in diningTable.shapeLayout.seats) {
            var seatCapacity = diningTable.shapeLayout.seats[position]

            for (var count = 1; count <= seatCapacity; count++) {
                var seat,
                    options = {
                        name: 'table-seat',
                        x: 0,
                        y: 0,
                        width: this.options.seatWidth,
                        height: this.options.seatWidth,
                        fill: diningTable.seatColor ?? this.options.seatColor,
                        cornerRadius: 4
                    }

                switch (position) {
                    case 'top':
                        options.x = this.options.tableLayoutPadding + this.options.tableHorizontalPadding
                        if (count > 1)
                            options.x += (this.options.seatWidth + this.options.seatSpacing) * (count - 1)
                        break;
                    case 'right':
                        options.y = 30
                        options.x = diningTable.shapeLayout.width - (this.options.tableLayoutPadding * 2)
                        break;
                    case 'bottom':
                        options.y = (diningTable.shapeLayout.height + (this.options.tableLayoutPadding * 2)) - this.options.seatWidth
                        options.x = this.options.tableLayoutPadding + this.options.tableHorizontalPadding
                        if (count > 1)
                            options.x += (this.options.seatWidth + this.options.seatSpacing) * (count - 1)
                        break;
                    case 'left':
                        options.y = 30
                        break;
                }

                seat = new Konva.Rect(options)
                group.add(seat)
            }
        }
    }

    FloorPlanner.prototype.createRoundSeats = function (diningTable, group) {
        for (var position in diningTable.shapeLayout.seats) {
            var seatCapacity = diningTable.shapeLayout.seats[position],
                degree = 360 / seatCapacity

            for (var count = 1; count <= seatCapacity; count++) {
                var seat,
                    angle = degree * count,
                    radian = angle * (Math.PI / 180),
                    options = {
                        name: 'table-seat',
                        x: ((diningTable.shapeLayout.radius - this.options.tableLayoutPadding) * Math.cos(radian)) + this.options.tableLayoutPadding,
                        y: ((diningTable.shapeLayout.radius - this.options.tableLayoutPadding) * Math.sin(radian)) + this.options.tableLayoutPadding,
                        radius: this.options.seatWidth / 2,
                        fill: diningTable.seatColor ?? this.options.seatColor,
                        angle: angle,
                    }

                seat = new Konva.Circle(options)
                group.add(seat)
            }
        }
    }

    FloorPlanner.prototype.zoomStage = function (event, action) {
        switch (action) {
            case 'in':
                this.zoom += 0.1
                break;
            case 'out':
                this.zoom -= 0.1
                break;
            case 'reset':
                this.zoom = 1
                break;
        }

        this.stage.scaleX(this.zoom)
        this.stage.scaleY(this.zoom)

        this.saveState()
    }

    // EVENT HANDLERS
    // ============================

    FloorPlanner.prototype.onControlClick = function (event) {
        var $el = $(event.currentTarget),
            control = $el.data('floorPlannerControl')

        switch (control) {
            case 'zoom-in':
                this.zoomStage(event, 'in')
                break
            case 'zoom-out':
                this.zoomStage(event, 'out')
                break
            case 'zoom-reset':
                this.zoomStage(event, 'reset')
                break
        }
    }

    FloorPlanner.prototype.onDoubleClickControl = function (event) {
        var className = event.target.getClassName(),
            connectorWidgetAlias = this.options.connectorWidgetAlias

        if (className !== 'Text' || !connectorWidgetAlias)
            return

        new $.ti.recordEditor.modal({
            alias: connectorWidgetAlias,
            recordId: event.target.getAttr('id'),
            onSave: function () {
                this.hide()
            }
        })
    }

    FloorPlanner.prototype.onClickStage = function (event) {
        if (event.target.getType() === 'Stage' && this.transformer) {
            this.transformer.detach()
        }
    }

    FloorPlanner.prototype.onClickShape = function (event) {
        if (!this.options.previewMode) {
            event.target.getParent().moveToTop()

            if (this.transformer) this.transformer.detach()

            this.transformer = new Konva.Transformer(this.options.transformerOptions)
            this.transformer.nodes([event.target.getParent()])
            this.layer.add(this.transformer)
        }
    }

    FloorPlanner.DEFAULTS = {
        alias: undefined,
        canvasSelector: '[data-floor-planner-canvas]',
        dataInputSelector: '[data-floor-planner-input]',
        connectorWidgetAlias: undefined,
        previewMode: false,
        diningTables: {},
        canvasWidth: 1200,
        canvasHeight: 600,
        seatWidth: 40,
        seatSpacing: 20,
        tableColor: '#D2D4DF',
        seatColor: '#9194A6',
        tableHorizontalPadding: 30,
        tableVerticalPadding: 20,
        tableLayoutPadding: 10,
        transformerOptions: {
            resizeEnabled: false,
            rotateAnchorOffset: 20,
            anchorStrokeWidth: 2,
            borderStrokeWidth: 2,
            padding: 3,
        },
        textOptions: {
            fontSize: 15,
            fontFamily: undefined,
            fill: undefined,
            height: 20,
            padding: 10,
            align: 'center',
            verticalAlign: 'middle',
            wrap: 'none',
            ellipsis: true,
        }
    }

    // INITIALIZATION
    // ============================

    if ($.ti === undefined) $.ti = {}

    $.fn.floorPlanner = function (option) {
        var args = Array.prototype.slice.call(arguments, 1), result
        this.each(function () {
            var $this = $(this)
            var data = $this.data('ti.floorPlanner')
            var options = $.extend({}, FloorPlanner.DEFAULTS, $this.data(), typeof option == 'object' && option)
            if (!data) $this.data('ti.floorPlanner', (data = new FloorPlanner(this, options)))
            if (typeof option == 'string') result = data[option].apply(data, args)
            if (typeof result != 'undefined') return false
        })

        return result ? result : this
    }

    $.fn.floorPlanner.Constructor = FloorPlanner

    $(document).render(function () {
        $('[data-control="floorplanner"]:not(".initialized")').floorPlanner()
    })
}(window.jQuery);
