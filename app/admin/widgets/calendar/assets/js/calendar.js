/*
 * Calendar plugin
 *
 * Data attributes:
 * - data-control="calendar" - enables the plugin on an element
 */
+function ($) {
    "use strict"

    // FIELD CALENDAR CLASS DEFINITION
    // ============================

    var Calendar = function (element, options) {
        this.options = options
        this.$el = $(element)
        this.$form = this.$el.closest('form')
        this.picker = null
        this.calendar = null

        // Init
        this.init()
    }

    Calendar.prototype.init = function () {
        this.$calendar = $('<div/>', {
            id: this.$el.attr('id') + '-calendar',
        })

        this.$el.append(this.$calendar)

        this.initFullCalendar()
    }

    Calendar.prototype.initFullCalendar = function () {
        this.options.customButtons.datePicker = {
            text: 'Go To Date',
            click: $.proxy(this.onTogglePicker, this)
        }

        this.$calendar.fullCalendar(this.options)

        this.$calendar.fullCalendar('addEventSource', $.proxy(this.generateEvents, this))

        this.calendar = this.$calendar.fullCalendar('getCalendar')

        this.calendar.on('eventRender', $.proxy(this.onRenderEvent, this))
        this.calendar.on('eventDrop', $.proxy(this.onUpdateEvent, this))
        this.calendar.on('eventResize', $.proxy(this.onUpdateEvent, this))
    }

    Calendar.prototype.onRenderEvent = function (eventObj, $el) {
        if (!this.options.editable)
            return

        $el.addClass('popover-dismissable')
        $el.popover({
            title: eventObj.title,
            content: Mustache.render(this.$el.find('[data-calendar-popover-template]').html(), eventObj),
            trigger: 'click',
            placement: 'bottom',
            html: true,
            container: this.$el
        })

        $el.on('show.bs.popover', function () {
            $('.popover-dismissable').not(this).popover('hide')
        })
    }

    Calendar.prototype.onUpdateEvent = function (eventObj, delta, revertFunc, event) {
        var calendar = this.$calendar

        this.$form.request(this.options.alias + '::onUpdateEvent', {
            data: {
                eventId: eventObj.id,
                start: eventObj.start.toISOString(),
                end: eventObj.end ? eventObj.end.toISOString() : eventObj.start.clone().endOf('day').toISOString()
            }
        }).done(function () {
            calendar.fullCalendar('refetchEvents')
        }).fail(function (xhr) {
            $.ti.flashMessage({class: 'danger', text: xhr.responseText})
            revertFunc()
        })
    }

    Calendar.prototype.onTogglePicker = function (event) {
        var $button = $(event.currentTarget)

        if (!this.picker) {
            this.picker = $button.datepicker()
            $button.datepicker().on('changeDate', $.proxy(this.onPickerDateChanged, this))
        }

        $button.datepicker('show')
    }

    Calendar.prototype.onPickerDateChanged = function (event) {
        this.$calendar.fullCalendar('gotoDate', event.date)
    }

    Calendar.prototype.generateEvents = function (start, end, timezone, callback) {
        $.ti.loadingIndicator.show()
        var promise = this.$form.request(this.options.alias + '::onGenerateEvents', {
            data: {start: start.toISOString(), end: end.toISOString()}
        })

        promise.done(function (json) {
            callback(json.generatedEvents)
        }).always(function () {
            $.ti.loadingIndicator.hide()
        })
    }

    Calendar.DEFAULTS = {
        alias: undefined,
        aspectRatio: 2,
        editable: false,
        defaultDate: null,
        header: {
            left: 'today prev,datePicker,next',
            center: 'title',
            right: 'month,agendaWeek,agendaDay',
        },
        customButtons: {
            datePicker: {}
        },
        themeSystem: 'bootstrap4',
        bootstrapGlyphicons: false,
        eventLimit: 5,
        navLinks: true,
    }

    // FIELD CALENDAR PLUGIN DEFINITION
    // ============================

    var old = $.fn.calendar

    $.fn.calendar = function (option) {
        var args = Array.prototype.slice.call(arguments, 1), result
        this.each(function () {
            var $this = $(this)
            var data = $this.data('ti.calendar')
            var options = $.extend({}, Calendar.DEFAULTS, $this.data(), typeof option == 'object' && option)
            if (!data) $this.data('ti.calendar', (data = new Calendar(this, options)))
            if (typeof option == 'string') result = data[option].apply(data, args)
            if (typeof result != 'undefined') return false
        })

        return result ? result : this
    }

    $.fn.calendar.Constructor = Calendar

    // FIELD CALENDAR NO CONFLICT
    // =================

    $.fn.calendar.noConflict = function () {
        $.fn.calendar = old
        return this
    }

    // FIELD CALENDAR DATA-API
    // ===============

    $(document).render(function () {
        $('[data-control="calendar"]').calendar()
    })

}(window.jQuery)
