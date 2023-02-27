/*
 * Color Picker plugin
 *
 * Data attributes:
 * - data-control="colorpicker" - enables the plugin on an element
 */
+function ($) {
    "use strict"

    // FIELD REPEATER CLASS DEFINITION
    // ============================

    var ColorPicker = function (element, options) {
        this.options = options
        this.$el = $(element)

        // Init
        this.init()
    }

    ColorPicker.DEFAULTS = {
    }

    ColorPicker.prototype.init = function () {
        this.$el.find('[data-swatches-color]').on('click', $.proxy(this.onPresetClick, this))
    }

    ColorPicker.prototype.unbind = function () {
        this.$el.removeData('ti.colorpicker')
        this.picker = null
    }

    ColorPicker.prototype.onPresetClick = function (event) {
        var $button = $(event.currentTarget)

        this.$el.find('input[type="color"]').val($button.data('swatchesColor'))
    }

    // FIELD ColorPicker PLUGIN DEFINITION
    // ============================

    var old = $.fn.colorPicker

    $.fn.colorPicker = function (option) {
        var args = Array.prototype.slice.call(arguments, 1), result
        this.each(function () {
            var $this = $(this)
            var data = $this.data('ti.colorpicker')
            var options = $.extend({}, ColorPicker.DEFAULTS, $this.data(), typeof option == 'object' && option)
            if (!data) $this.data('ti.colorpicker', (data = new ColorPicker(this, options)))
            if (typeof option == 'string') result = data[option].apply(data, args)
            if (typeof result != 'undefined') return false
        })

        return result ? result : this
    }

    $.fn.colorPicker.Constructor = ColorPicker

    // FIELD ColorPicker NO CONFLICT
    // =================

    $.fn.colorPicker.noConflict = function () {
        $.fn.colorPicker = old
        return this
    }

    // FIELD ColorPicker DATA-API
    // ===============

    $(document).render(function () {
        $('[data-control="colorpicker"]').colorPicker()
    })

}(window.jQuery)
