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

        this.$container.find('.multiselect').tooltip('dispose')

        var $options = this.$container.find('.multiselect-container > li')
        $options.each(function () {
            var $li = $(this),
                $label = $li.find('label'),
                classes = $label.attr('class')

            $label.attr('class', '')
            $label.parent('div').attr('class', classes)
        })
    }

    SelectList.prototype.onDropdownShown = function (event) {
        $(event.relatedTarget).tooltip('dispose')
    }

    SelectList.prototype.onDropdownHidden = function (event) {
        $(event.relatedTarget).tooltip('dispose')
    }

    // MEDIA MANAGER PLUGIN DEFINITION
    // ============================

    SelectList.DEFAULTS = {
        enableHTML: true,
        numberDisplayed: 5,
        includeSelectAllOption: true,
        maxHeight: 200,
        enableFiltering: false,
        enableCaseInsensitiveFiltering: true,
        buttonClass: 'btn btn-light btn-block',
        optionClass: function (element) {
            return 'dropdown-item multiselect-item'
        },
        templates: {
            filter: '<li class="dropdown-item multiselect-item filter"><div class="input-group"><span class="input-group-prepend"><span class="input-group-icon"><i class="fa fa-search"></i></span></span><input class="form-control multiselect-search" type="text"></div></li>',
            filterClearBtn: '<span class="input-group-prepend"><span class="input-group-icon"><i class="fa fa-times-circle multiselect-clear-filter"></i></span></span>',
            li: '<li class="dropdown-item"><a class="dropdown-link" href="javascript:void(0);"><div class="custom-control"><label></label></div></a></li>',
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
