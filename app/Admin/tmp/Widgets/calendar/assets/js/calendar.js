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

        this.options.locale = this.options.locale.replace('_', '-').split('-').shift();
        this.options.events = $.proxy(this.generateEvents, this);
        this.calendar = new FullCalendar.Calendar(this.$calendar[0], this.options);

        this.$calendar.find('.fc-toolbar .btn').removeClass('btn-primary').addClass(this.options.toolbarButtonClass)

        this.calendar.on('eventClick', $.proxy(this.onClickEvent, this))
        this.calendar.on('eventDrop', $.proxy(this.onUpdateEvent, this))
        this.calendar.on('eventResize', $.proxy(this.onUpdateEvent, this))
        this.calendar.on('datesSet', $.proxy(this.hidePopovers, this))

        this.calendar.render();
    }

    Calendar.prototype.onClickEvent = function (eventObj) {
        if (!this.options.editable)
            return

        var renderProps = {...eventObj.event.extendedProps};
        renderProps.id = eventObj.event.id;

        var $el = $(eventObj.el);
        $el.addClass('popover-dismissable')

        this.hidePopovers();

        $el.popover({
            title: eventObj.event.title,
            content: Mustache.render(this.$el.find('[data-calendar-popover-template]').html(), renderProps),
            trigger: 'click focus',
            placement: 'bottom',
            html: true,
            container: this.$el
        })
        .popover('toggle')
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

    Calendar.prototype.onTogglePicker = function (event) {
        var $button = $(event.currentTarget)

        if (!this.picker) {
            this.picker = $button.datepicker()
            $button.datepicker().on('changeDate', $.proxy(this.onPickerDateChanged, this))
        }

        $button.datepicker('show')
    }

    Calendar.prototype.onPickerDateChanged = function (event) {
        this.calendar.gotoDate(event.date)
    }

    Calendar.prototype.hidePopovers = function() {
        $('.popover.show').remove()
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
            left: 'today prev,datePicker,next',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay',
        },
        customButtons: {
            datePicker: {}
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
