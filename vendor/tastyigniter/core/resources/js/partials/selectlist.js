/*
 * Select list class
 */
+function ($) {
    "use strict";

    var SelectList = function (element, options) {
        this.$el = $(element)
        this.$container = null
        this.choices = null

        this.options = options

        this.init()
    }

    SelectList.prototype.constructor = SelectList

    SelectList.prototype.init = function () {
        if (this.$el.find('option').length < 8) {
            this.options.searchEnabled = false
        }

        delete this.options.control

        this.choices = new Choices(this.$el[0], this.options)
    }

    SelectList.prototype.setChoices = function (choices) {
        this.choices.setChoices(choices, 'value', 'label', true)
    }

    // SELECT LIST PLUGIN DEFINITION
    // ============================

    SelectList.DEFAULTS = {
        removeItemButton: true,
        allowHTML: true,
    }

    var old = $.fn.selectList

    $.fn.selectList = function (option) {
        var args = Array.prototype.slice.call(arguments, 1),
            result = undefined

        this.each(function () {
            var $this = $(this)
            var data = $this.data('ti.selectList')
            var options = $.extend({}, SelectList.DEFAULTS, $this.data(), typeof option == 'object' && option)
            if (!data) $this.data('ti.selectList', (data = new SelectList(this, options)))
            if (typeof option == 'string') result = data[option].apply(data, args)
            if (typeof result != 'undefined') return false
        })

        return result ? result : this
    }

    $.fn.selectList.Constructor = SelectList

    // SELECT LIST NO CONFLICT
    // =================

    $.fn.selectList.noConflict = function () {
        $.fn.selectList = old
        return this
    }

    // SELECT LIST DATA-API
    // ===============

    $(document).render(function () {
        $('[data-control="selectlist"]').selectList()
    })

}(window.jQuery);
