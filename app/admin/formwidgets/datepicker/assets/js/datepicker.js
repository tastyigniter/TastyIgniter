/*
 * Color Picker plugin
 *
 * Data attributes:
 * - data-control="datePicker" - enables the plugin on an element
 */
+function ($) {
    "use strict";

    // FIELD DATEPICKER CLASS DEFINITION
    // ============================

    var DatePicker = function (element, options) {
        this.options = options
        this.$el = $(element)
        this.picker = null

        this.bindPicker()
    }

    DatePicker.DEFAULTS = {
        autoclose: true,
        mode: 'date',
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        templates: {
            leftArrow: '<i class="fa fa-long-arrow-left"></i>',
            rightArrow: '<i class="fa fa-long-arrow-right"></i>'
        }
    }

    DatePicker.prototype.bindPicker = function () {
        if (this.options.mode === 'datetime') {
            this.picker = this.$el.datetimepicker({
                icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-arrow-up",
                    down: "fa fa-arrow-down"
                }
            });
        } else {
            this.picker = this.$el.datepicker(this.options);
            this.parsePickerValue()
        }
    }

    DatePicker.prototype.parsePickerValue = function () {
        var value = this.$el.val()

        if (value === '30-11--0001')
            this.$el.val('')
    }

    //
    // FIELD DatePicker PLUGIN DEFINITION
    // ============================

    var old = $.fn.datePicker

    $.fn.datePicker = function (option) {
        var args = Array.prototype.slice.call(arguments, 1), result
        this.each(function () {
            var $this = $(this)
            var data = $this.data('ti.datePicker')
            var options = $.extend({}, DatePicker.DEFAULTS, $this.data(), typeof option == 'object' && option)
            if (!data) $this.data('ti.datePicker', (data = new DatePicker(this, options)))
            if (typeof option == 'string') result = data[option].apply(data, args)
            if (typeof result != 'undefined') return false
        })

        return result ? result : this
    }

    $.fn.datePicker.Constructor = DatePicker

    // FIELD DatePicker NO CONFLICT
    // =================

    $.fn.datePicker.noConflict = function () {
        $.fn.datePicker = old
        return this
    }

    // FIELD DatePicker DATA-API
    // ===============

    $(document).render(function () {
        $('[data-control="datepicker"]').datePicker()
    });

}(window.jQuery);
