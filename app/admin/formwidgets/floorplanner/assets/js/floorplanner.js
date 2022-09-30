+function ($) {
    "use strict";

    var FloorPlanner = function (element, options) {
        this.options = options
        this.$container = $(element)

        this.$tableLayout = null;
        this.$table = null;
        this.$chair = null;
        this.$activeRotate = null;

        this.zoom = 1;

        this.init()
        this.initDraggable()
        this.initRotatable()
    }

    FloorPlanner.prototype.init = function () {
        this.$tableLayout = $('<div/>', {class: this.options.tableLayoutClass})
        this.$table = $('<div/>', {class: this.options.tableClass})
        this.$chair = $('<div/>', {class: this.options.chairClass})
        this.$tableInfo = this.$container.find('[data-table-info-template]')

        this.$container.on('click', '[data-floor-planner-control]', $.proxy(this.onTableControlClick, this))
        this.$container.on('dblclick', '[data-control="load-table-form"]', $.proxy(this.onLoadTableFormClick, this))

        this.createTables()
    }

    FloorPlanner.prototype.initDraggable = function () {
        var self = this
        this.$container.find(this.options.draggableSelector).each(function () {
            var $this = $(this),
                $container = $this.closest('[data-table-id]')


            interact($this.get(0)).draggable({
                allowFrom: '.'+self.options.tableClass,
                ignoreFrom: '.table-controls',
                modifiers: [
                    interact.modifiers.restrictRect({
                        restriction: self.options.wrapperSelector
                    })
                ],
                listeners: {
                    move(event) {
                        var position = self.tableLayoutVal($container)
                        position.x += event.dx
                        position.y += event.dy

                        self.tableLayoutVal($container, position)

                        event.target.style.transform = `translate(${position.x}px, ${position.y}px) rotate(${position.degree}deg)`
                    },
                },
            })
        })
    }

    FloorPlanner.prototype.initRotatable = function () {
        this.$container.on('mousedown', this.options.rotatableSelector, $.proxy(this.onStartRotate, this))
        this.$container.on('mousemove', $.proxy(this.onRotate, this))
        this.$container.on('mouseup', $.proxy(this.onStopRotate, this))

        this.$container.find('[data-table-id]').each(function () {
            var rotate = {}

            rotate.angle = 0
            rotate.rotation = 0
            rotate.startAngle = 0
            rotate.r2d = 180 / Math.PI
            rotate.center = {
                x: 0,
                y: 0
            }

            $(this).data('rotate', rotate)
        });
    }

    FloorPlanner.prototype.createTables = function () {
        var self = this
        this.$container.find('[data-table-id]').each(function () {
            var $this = $(this), $table, seatLayout = {},
                $tableLayout = self.$tableLayout.clone()

            $table = self.createTableTop($this.data())
            seatLayout = $table.data('seatLayout')

            $.each($table.data('seatLayout').seats, function (side, seatCapacity) {
                for (var i = 1; i <= seatCapacity; i++) {
                    side === 'round'
                        ? $table.append(self.createRoundSeat(i, seatCapacity, seatLayout.tableWidth))
                        : $tableLayout.append(self.createRectangleSeat(i, side))
                }
            });

            $table.append(Mustache.render(self.$tableInfo.clone().html(), $this.data()))

            $tableLayout.addClass('draggable')
                .append($table)
                .css({
                    width: seatLayout.tableWidth+(self.options.tableLayoutPadding * 2),
                    height: seatLayout.tableHeight+(self.options.tableLayoutPadding * 2),
                    'touch-action': 'none',
                    'user-select': 'none'
                })

            var position = self.tableLayoutVal($this)
            $tableLayout[0].style.transform = `translate(${position.x}px, ${position.y}px) rotate(${position.degree}deg)`

            $this.append($tableLayout)
        })
    }

    FloorPlanner.prototype.createTableTop = function (data) {
        var $table = this.$table.clone(),
            seatLayout

        data = $.extend({tableShape: 'rectangle', tableCapacity: 1}, data)

        if (data.tableShape === 'round') {
            seatLayout = this.createRoundLayout(data.tableCapacity)
            $table.addClass('rounded-circle')
        } else {
            seatLayout = this.createRectangleLayout(data.tableCapacity)
        }

        $table.data('seatLayout', seatLayout)
            .addClass('rounded')
            .css({
                position: 'absolute',
                top: this.options.tableLayoutPadding,
                left: this.options.tableLayoutPadding,
                height: seatLayout.tableHeight,
                width: seatLayout.tableWidth
            })

        return $table;
    }

    FloorPlanner.prototype.createRectangleLayout = function (capacity) {
        var remaining = capacity-2, tableWidth, tableHeight,
            seats = {top: 0, right: 0, bottom: 0, left: 0}

        tableWidth = tableHeight = (this.options.seatWidth)

        if (capacity == 2) {
            seats.top = seats.bottom = 1
        } else if (capacity > 2) {
            seats.left = seats.right = 1;
            if ((remaining % 2) === 0) {
                seats.top = seats.bottom = remaining / 2;
            } else {
                seats.bottom = seats.top = (remaining-1) / 2;
                ++seats.top;
            }

            tableWidth = (this.options.seatWidth * seats.top)+(this.options.seatSpacing * (seats.top-1))
        } else {
            seats.left = 1;
        }

        return {
            seats: seats,
            tableWidth: tableWidth+(this.options.tableHorizontalPadding * 2),
            tableHeight: tableHeight+(this.options.tableVerticalPadding * 2),
        }
    }

    FloorPlanner.prototype.createRoundLayout = function (capacity) {
        var tableWidth, tableHeight,
            remaining = capacity-2,
            seats = {round: capacity}

        tableWidth = tableHeight = this.options.seatWidth
        if (capacity > 2) {
            tableWidth = tableHeight = this.options.seatWidth * (remaining / 2)
        }

        return {
            seats: seats,
            tableWidth: tableWidth+((this.options.seatWidth / 2) * 2),
            tableHeight: tableHeight+((this.options.seatWidth / 2) * 2),
        }
    }

    FloorPlanner.prototype.createRectangleSeat = function (index, position) {
        var $el = this.$chair.clone(),
            css = {
                position: 'absolute',
                width: this.options.seatWidth,
                height: this.options.seatWidth
            }

        switch (position) {
            case 'top':
                css.top = 0
                css.left = this.options.tableLayoutPadding+this.options.tableHorizontalPadding
                if (index > 1)
                    css.left += (this.options.seatWidth+this.options.seatSpacing) * (index-1)
                break;
            case 'right':
                css.right = 0
                css.top = this.options.tableLayoutPadding+this.options.tableVerticalPadding
                if (index > 1)
                    css.top += (this.options.seatWidth+this.options.tableVerticalPadding) * (index-1)
                break;
            case 'bottom':
                css.bottom = 0
                css.right = this.options.tableLayoutPadding+this.options.tableHorizontalPadding
                if (index > 1)
                    css.right += (this.options.seatWidth+this.options.seatSpacing) * (index-1)
                break;
            case 'left':
                css.left = 0
                css.top = this.options.tableLayoutPadding+this.options.tableVerticalPadding
                if (index > 1)
                    css.right += (this.options.seatWidth+this.options.tableVerticalPadding) * (index-1)
                break;
        }

        $el.addClass(position+' rounded')
        $el.css(css)

        return $el
    }

    FloorPlanner.prototype.createRoundSeat = function (index, capacity, tableWidth) {
        var css = {
                position: 'absolute',
                width: this.options.seatWidth,
                height: this.options.seatWidth
            },
            $el = this.$chair.clone(),
            start = this.options.seatWidth-(this.options.seatWidth / 4),
            degree = 360 / capacity


        if (capacity > 1) {
            start = (tableWidth / 2)-(this.options.seatWidth / 4)
        }

        css.top = '50%'
        css.left = '50%'
        css.margin = -(this.options.seatWidth / 2)
        css.transform = 'translate('+start+'px)'

        if (index > 1) {
            degree = degree * (index-1)
            css.transform = 'rotate('+degree+'deg) translate('+start+'px) rotate(-'+degree+'deg)'
        }

        $el.addClass('rounded-circle').css(css)

        return $el
    }

    FloorPlanner.prototype.zoomFloorPlan = function ($el, action) {
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

        this.$container.find(this.options.wrapperSelector).css('transform', 'scale('+this.zoom+')')
    }

    FloorPlanner.prototype.selectTable = function ($table) {
        this.$container.find('.table-controls').remove()
        this.$container.find('[data-table-id]').removeClass('selected')

        var $controlWrapper = $('<div/>', {class: 'table-controls d-flex justify-content-center'}),
            $rotate = $('<div/>', {class: 'rotate'}),
            $container = $table.closest('[data-table-id]')

        if ($container.length && !$container.hasClass('selected')) {
            $container.addClass('selected')
            $controlWrapper.append($rotate)
            $container.find('.'+this.options.tableLayoutClass).prepend($controlWrapper)
        } else {
            $container.removeClass('selected')
            $container.find('.table-controls').remove()
        }
    }

    FloorPlanner.prototype.tableLayoutVal = function ($container, layout) {
        if (typeof layout === 'undefined') {
            var positionX = $container.find('[data-table-layout-x]').val(),
                positionY = $container.find('[data-table-layout-y]').val(),
                positionDegree = $container.find('[data-table-layout-degree]').val()

            return {x: parseFloat(positionX), y: parseFloat(positionY), degree: parseFloat(positionDegree)}
        } else {
            $container.find('[data-table-layout-x]').val(layout.x)
            $container.find('[data-table-layout-y]').val(layout.y)
            $container.find('[data-table-layout-degree]').val(layout.degree)
        }
    }

    // EVENT HANDLERS
    // ============================

    FloorPlanner.prototype.onTableControlClick = function (event) {
        var $el = $(event.currentTarget),
            control = $el.data('floorPlannerControl')

        switch (control) {
            case 'zoom-in':
                this.zoomFloorPlan($el, 'in')
                break
            case 'zoom-out':
                this.zoomFloorPlan($el, 'out')
                break
            case 'zoom-reset':
                this.zoomFloorPlan($el, 'reset')
                break
            case 'select-table':
                this.selectTable($el)
                break
        }
    }

    FloorPlanner.prototype.onLoadTableFormClick = function (event) {
        var $el = $(event.currentTarget),
            $container = $el.closest('[data-table-id]')

        new $.ti.recordEditor.modal({
            alias: $el.data('connectorWidgetAlias'),
            recordId: $container.data('tableId'),
            onSave: function () {
                this.hide()
            }
        })
    }

    FloorPlanner.prototype.onStartRotate = function (event) {
        event.preventDefault();

        this.$activeRotate = $(event.target)

        var $layout = this.$activeRotate.closest('.'+this.options.tableLayoutClass),
            top = $layout.offset().top,
            left = $layout.offset().left,
            height = $layout.outerHeight(),
            width = $layout.outerWidth(),
            x, y, rotate

        this.$activeRotate.addClass('rotating')
        rotate = this.$activeRotate.closest('[data-table-id]').data('rotate')

        rotate.center = {
            x: left+(width / 2),
            y: top+(height / 2)
        }

        x = event.clientX-rotate.center.x
        y = event.clientY-rotate.center.y

        rotate.startAngle = rotate.r2d * Math.atan2(y, x)

        this.$activeRotate.closest('[data-table-id]').data('rotate', rotate)
    }

    FloorPlanner.prototype.onRotate = function (event) {
        if (!this.$activeRotate)
            return

        if (this.$activeRotate.hasClass('rotating')) {
            event.preventDefault();

            var $container = this.$activeRotate.closest('[data-table-id]'),
                rotate = $container.data('rotate'),
                position = this.tableLayoutVal($container),
                x = event.clientX-rotate.center.x,
                y = event.clientY-rotate.center.y,
                d = rotate.r2d * Math.atan2(y, x),
                transform

            rotate.rotation = d-rotate.startAngle
            position.degree = rotate.angle+rotate.rotation

            transform = `translate(${position.x}px, ${position.y}px) rotate(${position.degree}deg)`
            $container.find('.'+this.options.tableLayoutClass)[0].style.webkitTransform = transform

            $container.data('rotate', rotate)
            this.tableLayoutVal($container, position)
        }
    }

    FloorPlanner.prototype.onStopRotate = function (event) {
        if (!this.$activeRotate)
            return

        event.preventDefault();

        var $container = this.$activeRotate.closest('[data-table-id]'),
            rotate = $container.data('rotate')

        rotate.angle += rotate.rotation;

        $container.find('[data-table-layout-degree]').val(rotate.angle)
        $container.data('rotate', rotate)

        this.$activeRotate.removeClass('rotating')
        this.$activeRotate = null
    }

    FloorPlanner.DEFAULTS = {
        wrapperSelector: '.dining-table-wrapper',
        draggableSelector: '.draggable',
        rotatableSelector: '.rotate',
        seatWidth: 40,
        seatSpacing: 20,
        tableHorizontalPadding: 30,
        tableVerticalPadding: 20,
        tableLayoutPadding: 10,
        tableLayoutClass: 'dining-table-layout',
        tableClass: 'dining-table-top',
        chairClass: 'dining-chair',
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
        $('[data-control="floorplanner"]').floorPlanner()
    })
}(window.jQuery);
