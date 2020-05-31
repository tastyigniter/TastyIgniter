/*
 * Field Repeater plugin
 * 
 * Data attributes:
 * - data-control="repeater" - enables the plugin on an element
 */

+function ($) {
    "use strict";

    // FIELD REPEATER CLASS DEFINITION
    // ============================

    var Repeater = function (element, options) {
        this.options = options
        this.$el = $(element)
        this.$appendTo = $(this.options.appendTo, this.$el)
        this.$sortable = null
        this.$sortableContainer = $(this.options.sortableContainer, this.$el)

        // Init
        this.init()
    }

    Repeater.DEFAULTS = {
        appendTo: 'table.repeater-items > tbody',
        sortableContainer: 'table.repeater-items > tbody',
        sortableHandle: '.repeater-item-handle',
    }

    Repeater.prototype.init = function () {
        this.$el.on('click', '[data-control="add-item"]', $.proxy(this.addItem, this))
        this.$el.on('click', '[data-control="remove-item"]', $.proxy(this.removeItem, this))

        this.bindSorting()
    }

    Repeater.prototype.bindSorting = function () {
        var sortableOptions = {
            handle: this.options.sortableHandle,

            ghostClass: "sortable-ghost",  // Class name for the drop placeholder
            chosenClass: "sortable-chosen",  // Class name for the chosen item
            dragClass: "sortable-drag",  // Class name for the dragging item
            fallbackClass: "sortable-fallback",  // Class name for the cloned DOM Element when using forceFallback
        }

        this.$sortable = Sortable.create(this.$sortableContainer.get(0), sortableOptions)
    }

    Repeater.prototype.unbind = function () {
        this.$sortable.destroy()
        this.$el.removeData('ti.repeater')
    }

    Repeater.prototype.removeItem = function (event) {
        var $element = $(event.currentTarget),
            $parent = $($element.data('target')),
            prompt = $element.data('prompt')

        if (prompt.length && !confirm(prompt))
            return false;

        $parent.remove()
    }

    Repeater.prototype.addItem = function (event) {
        var self = this,
            $element = $(event.target),
            $template = self.$el.find('[data-repeater-template]'),
            $newTemplate = $template.clone(),
            findString = $template.data('find'),
            find = new RegExp(findString, "g"),
            secFind = new RegExp(findString.replace(/_/g, '-'), "g"),
            replace = $template.data('replace')

        if (!$newTemplate.length) {
            throw new Error("No template element found with attribute [data-repeater-template]")
        }

        this.$appendTo.find('.repeater-item-placeholder').remove()

        this.$appendTo.append($newTemplate[0].innerHTML.replace(find, replace).replace(secFind, replace))
        $template.data('replace', parseInt(replace) + 1)

        $('select.form-control', document).select2();
    }

    // FIELD REPEATER PLUGIN DEFINITION
    // ============================

    var old = $.fn.repeater

    $.fn.repeater = function (option) {
        var args = Array.prototype.slice.call(arguments, 1), result
        this.each(function () {
            var $this = $(this)
            var data = $this.data('ti.repeater')
            var options = $.extend({}, Repeater.DEFAULTS, $this.data(), typeof option == 'object' && option)
            if (!data) $this.data('ti.repeater', (data = new Repeater(this, options)))
            if (typeof option == 'string') result = data[option].apply(data, args)
            if (typeof result != 'undefined') return false
        })

        return result ? result : this
    }

    $.fn.repeater.Constructor = Repeater

    // FIELD REPEATER NO CONFLICT
    // =================

    $.fn.repeater.noConflict = function () {
        $.fn.repeater = old
        return this
    }

    // FIELD REPEATER DATA-API
    // ===============

    $(document).render(function () {
        $('[data-control="repeater"]', document).repeater()
    });

}(window.jQuery);