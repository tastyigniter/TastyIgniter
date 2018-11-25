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
        this.picker = null

        // Init
        this.init()
    }

    ColorPicker.DEFAULTS = {
        customClass: 'colorpicker-2x',
        align: 'left',
        sliders: {
            saturation: {
                maxLeft: 200, maxTop: 200
            },
            hue: {
                maxTop: 200
            },
            alpha: {
                maxTop: 200
            }
        }
    }

    ColorPicker.prototype.init = function () {
        this.$el.find('input').on('focus', $.proxy(this.onInputFocused, this))

        this.options.component = this.$el.find('.component')
        this.picker = this.$el.colorpicker(this.options)

        this.picker.on('create', $.proxy(this.watchComponent, this))
        this.picker.on('changeColor', $.proxy(this.watchComponent, this))
    }

    ColorPicker.prototype.unbind = function () {
        this.$el.colorpicker('destroy')
        this.$el.removeData('ti.colorpicker')
        this.picker = null
    }

    ColorPicker.prototype.watchComponent = function () {
        var $component = this.$el.data('colorpicker').component
        $component.find('i')
            .css('color', this.$el.data('colorpicker').color)
            .css('background-color', 'transparent')
    }

    ColorPicker.prototype.onInputFocused = function () {
        if (!this.picker)
            return

        this.$el.colorpicker('show')
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