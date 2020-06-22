/*
 * Datepicker plugin
 *
 * Data attributes:
 * - data-control="datepicker" - enables the plugin on an element
 */
+function ($) {
    "use strict"

    // FIELD CHART CONTROL CLASS DEFINITION
    // ============================

    var DatePickerControl = function (element, options) {
        this.options = options
        this.$el = $(element)

        // Init
        this.initPicker();
    }

    DatePickerControl.DEFAULTS = {
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

    DatePickerControl.prototype.initPicker = function () {
        var options = this.options,
            $el = this.$el.find('[data-datepicker-trigger]')

        if (!options.singleDatePicker) {
            options.ranges = {
                'Today': [moment().startOf('day'), moment().endOf('day')],
                'Yesterday': [moment().subtract(1, 'days').startOf('day'), moment().subtract(1, 'days').endOf('day')],
                'Last 7 Days': [moment().subtract(6, 'days').startOf('day'), moment().endOf('day')],
                'Last 30 Days': [moment().subtract(29, 'days').startOf('day'), moment().endOf('day')],
                'This Month': [moment().startOf('month').startOf('day'), moment().endOf('month').endOf('day')],
                'Last Month': [moment().subtract(1, 'month').startOf('month').startOf('day'), moment().subtract(1, 'month').endOf('month').endOf('day')]
            }
        }

        $el.daterangepicker(options, $.proxy(this.onDateSelected, this))
    }

    DatePickerControl.prototype.onDateSelected = function (start, end, label, initialize) {
        var format = this.options.timePicker ? 'YYYY-MM-DD HH:mm:ss' : 'YYYY-MM-DD'

        if (!this.options.singleDatePicker) {
            this.$el.find('[data-datepicker-range-start]').val(start.format(format));
            this.$el.find('[data-datepicker-range-end]').val(end.format(format));
        } else {
            this.$el.find('[data-datepicker-input]').val(start.format(format));
        }

        if (!initialize) this.$el.closest('form').submit();
    }

    DatePickerControl.prototype.unbind = function () {
        this.$el.datePickerControl('destroy')
        this.$el.removeData('ti.datePickerControl')
    }

    // FIELD DATEPICKER CONTROL PLUGIN DEFINITION
    // ============================

    var old = $.fn.datePickerControl

    $.fn.datePickerControl = function (option) {
        var args = Array.prototype.slice.call(arguments, 1), result
        this.each(function () {
            var $this = $(this)
            var data = $this.data('ti.datePickerControl')
            var options = $.extend({}, DatePickerControl.DEFAULTS, $this.data(), typeof option === 'object' && option)
            if (!data) $this.data('ti.datePickerControl', (data = new DatePickerControl(this, options)))
            if (typeof option === 'string') result = data[option].apply(data, args)
            if (typeof result !== 'undefined') return false
        })

        return result ? result : this
    }

    $.fn.datePickerControl.Constructor = DatePickerControl

    // FIELD DATEPICKER CONTROL NO CONFLICT
    // =================

    $.fn.datePickerControl.noConflict = function () {
        $.fn.datePickerControl = old
        return this
    }

    // FIELD DATEPICKER CONTROL DATA-API
    // ===============

    $(document).render(function () {
        $('[data-control="datepicker"]').datePickerControl()
    })
}(window.jQuery)