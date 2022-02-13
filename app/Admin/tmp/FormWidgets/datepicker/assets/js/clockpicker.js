/*
 * Color Picker plugin
 *
 * Data attributes:
 * - data-control="clockpicker" - enables the plugin on an element
 */
+function ($) {
    "use strict";

    // FIELD CLOCKPCIKER CLASS DEFINITION
    // ============================

    var ColorPicker = function (element, options) {
        this.options = options
        this.$el = $(element)
        this.picker = null

        this.picker = this.$el.clockpicker(this.options);
    }

    ColorPicker.DEFAULTS = {
        donetext: 'Done',
        placement: 'top',
        autoclose: true,
    }

    //
    // FIELD ColorPicker PLUGIN DEFINITION
    // ============================

    var old = $.fn.clockPicker

    $.fn.clockPicker = function (option) {
        var args = Array.prototype.slice.call(arguments, 1), result
        this.each(function () {
            var $this = $(this)
            var data = $this.data('ti.clockPicker')
            var options = $.extend({}, ColorPicker.DEFAULTS, $this.data(), typeof option == 'object' && option)
            if (!data) $this.data('ti.clockPicker', (data = new ColorPicker(this, options)))
            if (typeof option == 'string') result = data[option].apply(data, args)
            if (typeof result != 'undefined') return false
        })

        return result ? result : this
    }

    $.fn.clockPicker.Constructor = ColorPicker

    // FIELD ColorPicker NO CONFLICT
    // =================

    $.fn.clockPicker.noConflict = function () {
        $.fn.clockPicker = old
        return this
    }

    // FIELD ColorPicker DATA-API
    // ===============

    $(document).render(function () {
        $('[data-control="clockpicker"]').clockPicker()
    });

}(window.jQuery);
