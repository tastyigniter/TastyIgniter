+function ($) {
    "use strict";

    var Components = function (element, options) {
        this.$el = $(element)
        this.options = options
        this.$modalRootElement = null

        this.init()
        this.initSortable()
    }

    Components.prototype.constructor = Components

    Components.prototype.init = function () {
        this.$modalRootElement = this.$el.find('[data-control="components-modal"]')

        this.$el.on('click', '[data-control="add-component"]', $.proxy(this.onAddClicked, this))
        this.$el.on('click', '[data-control="remove-component"]', $.proxy(this.onRemoveClicked, this))
    }

    Components.prototype.initSortable = function () {
        var $sortableContainer = $(this.options.sortableContainer, this.$el)

        $sortableContainer.sortable({
            group: 'components',
            containerSelector: this.options.sortableContainer,
            itemSelector: '.components-item:not(:first-child)',
            placeholder: '<div class="placeholder sortable-placeholder"></div>',
            handle: '.handle',
            nested: false,
            vertical: false,
            exclude: '.components-picker',
        })
    }

    // EVENT HANDLERS
    // ============================

    Components.prototype.onAddClicked = function (event) {
        var self = this,
            $element = $(event.currentTarget),
            componentCode = $element.data('componentCode')

        $element.request(this.options.addHandler, {
            data: {code: componentCode}
        }).always(function () {
            self.$modalRootElement.modal('hide')
        }).done(function (json) {
            self.$el.find('[data-control="toggle-components"]').parent().after(json)
        })
    }

    Components.prototype.onRemoveClicked = function (event) {
        var $element = $(event.currentTarget)

        $element.closest('.components-item').remove()
    }

    Components.DEFAULTS = {
        alias: undefined,
        addHandler: undefined,
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