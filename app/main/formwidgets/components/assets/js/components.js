+function ($) {
    "use strict";

    var Components = function (element, options) {
        this.$el = $(element)
        this.options = options

        this.init()
        this.initSortable()
    }

    Components.prototype.constructor = Components

    Components.prototype.init = function () {
        this.$el.on('click', '[data-component-control]', $.proxy(this.onControlClick, this))
    }

    Components.prototype.initSortable = function () {
        var $sortableContainer = $(this.options.sortableContainer, this.$el).get(0)

        Sortable.create($sortableContainer, {
            handle: '.handle',
            filter: '.components-picker',
        })
    }

    Components.prototype.loadComponentForm = function ($button) {
        var $container = this.$el.find('.components-container'),
            $component = $button.closest('[data-control="component"]'),
            componentAlias = $component.data('componentAlias')

        new $.ti.recordEditor.modal({
            alias: this.options.alias,
            recordId: componentAlias,
            onSave: function () {
                this.hide()
                $container.animate({
                    scrollLeft: $container.find('.components-item:last-child').position().left
                }, 500)
            }
        })
    }

    Components.prototype.removeComponent = function ($button) {
        var prompt = $button.data('prompt'),
            $component = $button.closest('[data-control="component"]'),
            componentAlias = $component.data('componentAlias')

        if (prompt.length && !confirm(prompt))
            return false;

        $.ti.loadingIndicator.show()
        $.request(this.options.removeHandler, {
            data: {code: componentAlias},
        }).done(function () {
            $component.remove()
        }).always(function () {
            $.ti.loadingIndicator.hide()
        });
    }

    // EVENT HANDLERS
    // ============================

    Components.prototype.onControlClick = function (event) {
        var $el = $(event.currentTarget),
            control = $el.data('component-control')

        switch (control) {
            case 'load':
                this.loadComponentForm($el)
                break;
            case 'drag':
                this.loadComponentForm($el)
                break;
            case 'remove':
                this.removeComponent($el)
                break;
        }
    }

    Components.DEFAULTS = {
        alias: undefined,
        removeHandler: undefined,
        sortableContainer: '.is-sortable',
    }

    // FormTable PLUGIN DEFINITION
    // ============================

    var old = $.fn.components

    $.fn.components = function (option) {
        var args = Array.prototype.slice.call(arguments, 1), result
        this.each(function () {
            var $this = $(this)
            var data = $this.data('ti.components')
            var options = $.extend({}, Components.DEFAULTS, $this.data(), typeof option == 'object' && option)
            if (!data) $this.data('ti.components', (data = new Components(this, options)))
            if (typeof option == 'string') result = data[option].apply(data, args)
            if (typeof result != 'undefined') return false
        })

        return result ? result : this
    }

    $.fn.components.Constructor = Components

    // Components NO CONFLICT
    // =================

    $.fn.components.noConflict = function () {
        $.fn.components = old
        return this
    }

    // Components DATA-API
    // ===============
    $(document).render(function () {
        $('[data-control="components"]').components()
    })
}(window.jQuery);