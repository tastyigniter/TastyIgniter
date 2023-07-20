/*
 * Select list class
 */
+function ($) {
    "use strict";

    var SelectList = function (element, options) {
        this.$el = $(element)
        this.options = options
        this.slimSelect = null

        this.init()
    }

    SelectList.prototype.constructor = SelectList

    SelectList.prototype.init = function () {
        this.slimSelect = new SlimSelect({
            select: this.$el.get(0),
            settings: this.options,
            events: {
                afterChange: (newVal) => {
                    this.$el.trigger('change')
                }
            }
        })
    }

    // SELECTLIST PLUGIN DEFINITION
    // ============================

    SelectList.DEFAULTS = {
        maxValuesShown: 5,
        showSearch: false,
        allowDeselect: true
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
