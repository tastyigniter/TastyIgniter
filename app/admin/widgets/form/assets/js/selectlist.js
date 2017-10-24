/*
 * Select list class
 */
+function ($) {
    "use strict";

    if ($.ti === undefined) $.ti = {}

    if ($.ti.starRating === undefined)
        $.ti.starRating = {}

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
        // this.options.onChange = $.proxy(this.onChange, this)

        this.$el.multiselect(this.options)
    }

    SelectList.prototype.onInitialized = function (select, container) {
        this.$container = $(container);

        this.$container.find('.multiselect').tooltip('destroy')

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
        // $(event.relatedTarget).tooltip('destroy')
    }

    SelectList.prototype.onChange = function (option, checked, select) {
        console.log($('input[value="'+$(option).val()+'"]'))
        $('input[value="'+$(option).val()+'"]').trigger('click')
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
        buttonClass: 'btn btn-default btn-block',
        optionClass: function (element) {
            return 'multiselect-item'
        },
        templates: {
            filter: '<li class="multiselect-item filter"><div class="input-group input-group-sm"><span class="input-group-addon"><i class="fa fa-search"></i></span><input class="form-control multiselect-search" type="text"></div></li>',
            filterClearBtn: '<span class="input-group-addon"><i class="fa fa-times-circle multiselect-clear-filter"></i></span>',
            li: '<li><a href="javascript:void(0);"><div><label></label></div></a></li>',
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

    $(document).ready(function () {
        $('[data-control="selectlist"]').selectList()
    })

}(window.jQuery);
