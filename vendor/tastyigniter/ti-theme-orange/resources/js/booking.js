+function ($) {
    "use strict"

    var Booking = function (element, options) {
        this.$el = $(element)
        this.options = options || {}
        this.$datePicker = this.$el.find('[data-control="datepicker"]')
        this.$datePickerValue = null

        this.init()
    }

    Booking.prototype.init = function () {
        if (this.$datePicker)
            this.initDatePicker();
    }

    Booking.prototype.initDatePicker = function () {
        this.$datePickerValue = this.$datePicker.data('startDate');

        var options = $.extend({
            static: true,
            mode: 'single',
            dateFormat: 'Y-m-d',
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down"
            },
            todayHighlight: true,
            onChange: $.proxy(this.onSelectDatePicker, this)
        }, this.$el.data())

        this.$datePicker.flatpickr(options);

        this.$dataLocker = this.$datePicker.next('input');
    }

    Booking.prototype.onSelectDatePicker = function (selectedDates, dateStr) {
        this.$datePickerValue = dateStr;
        this.$dataLocker.val(dateStr);
    }

    Booking.DEFAULTS = {}

    // PLUGIN DEFINITION
    // ============================

    var old = $.fn.booking

    $.fn.booking = function (option) {
        var args = arguments

        return this.each(function () {
            var $this = $(this)
            var data = $this.data('ti.booking')
            var options = $.extend({}, Booking.DEFAULTS, $this.data(), typeof option == 'object' && option)
            if (!data) $this.data('ti.booking', (data = new Booking(this, options)))
            if (typeof option == 'string') data[option].apply(data, args)
        })
    }

    $.fn.booking.Constructor = Booking

    $.fn.booking.noConflict = function () {
        $.fn.booking = old
        return this
    }

    $(document).render(function () {
        $('[data-control="booking"]').booking()
    })

}(window.jQuery)
