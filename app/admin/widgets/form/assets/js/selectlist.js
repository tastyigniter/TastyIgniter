/*
 * Select list class
 */
+function ($) {
    "use strict";

    var SelectList = function (element, options) {
        this.$el = $(element)
        this.$container = null

        this.options = options

        this.init()
    }

    SelectList.prototype.constructor = SelectList

    SelectList.prototype.init = function () {
        this.options.onInitialized = $.proxy(this.onInitialized, this)
        this.options.onDropdownShown = $.proxy(this.onDropdownShown, this)
        this.options.onDropdownHide = $.proxy(this.onDropdownHidden, this)

        this.$el.multiselect(this.options)
    }

    SelectList.prototype.onInitialized = function (select, container) {
        this.$container = $(container);

        this.$container.find('.multiselect').removeClass('text-center')
        this.$container.find('.multiselect').tooltip('dispose')
    }

    SelectList.prototype.onDropdownShown = function (event) {
        $(event.relatedTarget).tooltip('dispose')
        this.$el.parents('.form-group').css({ zIndex: 1000 });
    }

    SelectList.prototype.onDropdownHidden = function (event) {
        $(event.relatedTarget).tooltip('dispose')
        this.$el.parents('.form-group').css({ zIndex: '' });
    }

    // MEDIA MANAGER PLUGIN DEFINITION
    // ============================

    SelectList.DEFAULTS = {
        numberDisplayed: 5,
        includeSelectAllOption: true,
        maxHeight: 200,
        enableFiltering: false,
        enableCaseInsensitiveFiltering: true,
        selectAllText: 'Select all/none',
        optionClass: function (element) {
            return 'dropdown-item multiselect-item'
        },
        templates: {
            button: '<button type="button" class="multiselect dropdown-toggle btn btn-light btn-block" data-toggle="dropdown"><span class="multiselect-selected-text"></span></button>',
        }
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
