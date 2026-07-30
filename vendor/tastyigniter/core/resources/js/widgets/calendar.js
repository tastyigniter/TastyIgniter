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
        this.eventData = null
        this.$modalRootElement = null
        this.$popoverTemplate = this.$el.find('[data-calendar-popover-template]')

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
        this.options.locale = this.options.locale.replace('_', '-').split('-').shift();
        this.options.events = $.proxy(this.generateEvents, this);
        this.calendar = new FullCalendar.Calendar(this.$calendar[0], this.options);

        this.calendar.on('eventClick', $.proxy(this.onClickEvent, this))
        this.calendar.on('eventDrop', $.proxy(this.onUpdateEvent, this))
        this.calendar.on('eventResize', $.proxy(this.onUpdateEvent, this))

        this.calendar.render();
    }

    Calendar.prototype.showPopover = function () {
        this.$modalRootElement = $('<div/>', {
            id: 'calender-editor-modal',
            class: 'calender-editor-modal modal fade',
            role: 'dialog',
            tabindex: -1,
            ariaHidden: true,
        })

        this.$modalRootElement.one('hide.bs.modal', $.proxy(this.onModalHide, this))

        this.$modalRootElement.html(Mustache.render(this.$popoverTemplate.html(), this.eventData));

        $('body').append(this.$modalRootElement)

        var modal = new bootstrap.Modal('#' + this.$modalRootElement.attr('id'))
        modal.show()
    }

    Calendar.prototype.onClickEvent = function (eventObj) {
        if (!this.options.editable)
            return

        var renderProps = {...eventObj.event.extendedProps};
        renderProps.id = eventObj.event.id;

        this.eventData = renderProps
        this.showPopover();
    }

    Calendar.prototype.onUpdateEvent = function (eventObj) {
        var calendar = this.calendar

        this.$form.request(this.options.alias + '::onUpdateEvent', {
            data: {
                eventId: eventObj.event.id,
                start: eventObj.event.start.toISOString(),
                end: eventObj.event.end ? eventObj.event.end.toISOString() : eventObj.event.start.clone().endOf('day').toISOString()
            }
        }).done(function () {
            calendar.refetchEvents()
        }).fail(function (xhr) {
            $.ti.flashMessage({class: 'danger', text: xhr.responseText})
            eventObj.revert()
        })
    }

    Calendar.prototype.onPickerDateChanged = function (selectedDates, dateStr, instance) {
        this.calendar.gotoDate(dateStr)
    }

    Calendar.prototype.onModalHide = function (event) {
        this.$modalRootElement.remove()
        this.$modalRootElement = null
    }

    Calendar.prototype.generateEvents = function (fetchInfo, callback, failure) {
        $.ti.loadingIndicator.show()
        var promise = this.$form.request(this.options.alias + '::onGenerateEvents', {
            data: {start: fetchInfo.start.toISOString(), end: fetchInfo.end.toISOString()}
        })

        promise.done(function (json) {
            callback(json.generatedEvents)
        }).always(function () {
            $.ti.loadingIndicator.hide()
        })
    }

    Calendar.prototype.getCalendar = function () {
        return this.calendar
    }

    Calendar.DEFAULTS = {
        alias: undefined,
        aspectRatio: 2,
        editable: false,
        initialDate: null,
        headerToolbar: {
            left: 'prev,today,next',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay',
        },
        themeSystem: 'bootstrap4',
        dayMaxEventRows: 5,
        navLinks: true,
        initialView: 'dayGridMonth',
        locale: 'en',
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
