/*
 * Datepicker plugin
 *
 * Data attributes:
 * - data-control="daterangepicker" - enables the plugin on an element
 */
+function ($) {
    "use strict"

    // FIELD CHART CONTROL CLASS DEFINITION
    // ============================

    var DateRangePickerControl = function (element, options) {
        this.options = options
        this.$el = $(element)

        // Init
        this.initPicker();
    }

    DateRangePickerControl.DEFAULTS = {
        opens: 'right',
        autoUpdateInput: false,
        singleDatePicker: true,
        showDropdowns: true,
        autoApply: true,
        timePicker: false,
        locale: {
            format: 'MMM D, YYYY',
        }
    }

    DateRangePickerControl.prototype.initPicker = function () {
        var options = this.options,
            $el = this.$el.find('[data-datepicker-trigger]')

        if (!options.singleDatePicker) {
            options.ranges = {
                'Today': [moment().startOf('day'), moment().endOf('day')],
                'Yesterday': [moment().subtract(1, 'days').startOf('day'), moment().subtract(1, 'days').endOf('day')],
                'Last 7 Days': [moment().subtract(6, 'days').startOf('day'), moment().endOf('day')],
                'Last 30 Days': [moment().subtract(29, 'days').startOf('day'), moment().endOf('day')],
                'This Month': [moment().startOf('month').startOf('day'), moment().endOf('month').endOf('day')],
                'Last Month': [moment().subtract(1, 'month').startOf('month').startOf('day'), moment().subtract(1, 'month').endOf('month').endOf('day')],
                'Lifetime': ['', ''],
            }

            if (this.$el.find('[data-datepicker-range-start]').val() == '')
                options.startDate = '';

            if (this.$el.find('[data-datepicker-range-end]').val() == '')
                options.endDate = '';
        }

        $el.daterangepicker(options, $.proxy(this.onDateSelected, this))
        $el.on('showCalendar.daterangepicker', $.proxy(this.onShowCalendar, this));
    }

    DateRangePickerControl.prototype.onDateSelected = function (start, end, label, initialize) {
        var format = this.options.timePicker ? 'YYYY-MM-DD HH:mm:ss' : 'YYYY-MM-DD',
            inputChanged

        if (!this.options.singleDatePicker) {
            var $startInput = this.$el.find('[data-datepicker-range-start]'),
                $endInput = this.$el.find('[data-datepicker-range-end]'),
                startValue = $startInput.val(),
                endValue = $endInput.val()

            $startInput.val(start.isValid() ? start.format(format) : '');
            $endInput.val(end.isValid() ? end.format(format) : '');

            inputChanged = startValue != $startInput.val() || endValue != $endInput.val()
        } else {
            var $dateInput = this.$el.find('[data-datepicker-input]'),
                dateValue = $dateInput.val()

            $dateInput.val(start.format(format));

            inputChanged = dateValue != $dateInput.val();
        }

        if (!initialize && inputChanged) this.$el.closest('form').submit();
    }

    DateRangePickerControl.prototype.onShowCalendar = function (event, daterangepicker) {
        var valueChanged = false;

        if (!daterangepicker.startDate.isValid()) {
            daterangepicker.setStartDate(moment().startOf('day'));
            valueChanged = true;
        }

        if (!daterangepicker.endDate.isValid()) {
            daterangepicker.setEndDate(moment().endOf('day'));
            valueChanged = true;
        }

        if (valueChanged) {
            daterangepicker.updateCalendars();
        }
    }

    DateRangePickerControl.prototype.unbind = function () {
        this.$el.dateRangePickerControl('destroy')
        this.$el.removeData('ti.dateRangePickerControl')
    }

    // FIELD DATE RANGE PICKER CONTROL PLUGIN DEFINITION
    // ============================

    var old = $.fn.dateRangePickerControl

    $.fn.dateRangePickerControl = function (option) {
        var args = Array.prototype.slice.call(arguments, 1), result
        this.each(function () {
            var $this = $(this)
            var data = $this.data('ti.dateRangePickerControl')
            var options = $.extend({}, DateRangePickerControl.DEFAULTS, $this.data(), typeof option === 'object' && option)
            if (!data) $this.data('ti.dateRangePickerControl', (data = new DateRangePickerControl(this, options)))
            if (typeof option === 'string') result = data[option].apply(data, args)
            if (typeof result !== 'undefined') return false
        })

        return result ? result : this
    }

    $.fn.dateRangePickerControl.Constructor = DateRangePickerControl

    // FIELD DATE RANGE PICKER CONTROL NO CONFLICT
    // =================

    $.fn.dateRangePickerControl.noConflict = function () {
        $.fn.dateRangePickerControl = old
        return this
    }

    // FIELD DATE RANGE PICKER CONTROL DATA-API
    // ===============

    $(document).render(function () {
        $('[data-control="daterangepicker"]').dateRangePickerControl()
    })
}(window.jQuery)
