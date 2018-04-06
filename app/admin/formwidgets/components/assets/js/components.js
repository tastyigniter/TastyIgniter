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
        this.partialContainer = '[data-control="partial"]'

        this.$el.on('click', '[data-control="add-component"]', $.proxy(this.onAddClicked, this))
        this.$el.on('click', '[data-control="remove-component"]', $.proxy(this.onRemoveClicked, this))
        this.$el.on('click', '.panel-partial', $.proxy(this.onPanelClicked, this))
    }

    Components.prototype.initSortable = function () {
        var $sortableContainer = $(this.partialContainer, this.$el).find('.panel-partial')

        $(this.options.sortableContainer, $sortableContainer).sortable({
            group: 'panel-partial',
            containerSelector: this.options.sortableContainer,
            itemPath: '> .panel-body',
            itemSelector: '.panel-component',
            placeholder: '<div class="panel-component placeholder"></div>',
            handle: '.handle',
            onDrop: $.proxy(this.onDropPanel, this)
        })
    }

    Components.prototype.highlightPanel = function ($panel) {
        var $partialPanels = this.$el.find('[data-control="partial"]')

        if (!$partialPanels.length)
            return

        if (!$panel || !$panel.length)
            $panel = $partialPanels.get(0)

        $partialPanels.removeClass('selected')
        $panel.addClass('selected')
    }

    // EVENT HANDLERS
    // ============================

    Components.prototype.onDropPanel = function ($item, container, _super) {
        var $currentPartial = $(container.el.get(0)).closest('[data-control="partial"]'),
            replacePartial = $currentPartial.data('partial'),
            findPartial = $item.data('partial'),
            findPartialRegEx = new RegExp(findPartial, "g")

        if (findPartial != replacePartial) {
            $item.html($item.get(0).innerHTML
                .replace(findPartialRegEx, replacePartial))
        }

        _super($item, container);
        this.highlightPanel($currentPartial)
    }

    Components.prototype.onAddClicked = function (event) {
        var $element = $(event.currentTarget),
            $selectedPartial = this.$el.find('[data-control="partial"].selected'),
            componentCode = $element.data('component')

        if (!$selectedPartial.length) {
            alert('Please select a partial.')
            return;
        }

        var component = this.options.data[componentCode]
        component.partial = $selectedPartial.data('partial')

        $.ti.loadingIndicator.show()
        $element.request(this.options.handler, {
            data: component
        }).always(function () {
            $.ti.loadingIndicator.hide()
        }).done(function () {
            $selectedPartial.find('.panel-component:last-child [data-toggle="toggle"]').bootstrapToggle('refresh');
        })
    }

    Components.prototype.onRemoveClicked = function (event) {
        var $element = $(event.currentTarget)
        $element.closest('.panel-component').remove()
    }

    Components.prototype.onPanelClicked = function (event) {
        var $panel = $(event.target).closest('[data-control="partial"]')
        this.highlightPanel($panel)
    }

    Components.DEFAULTS = {
        alias: undefined,
        handler: undefined,
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
    $(document).ready(function () {
        $('[data-control="components"]').components()
    })
}(window.jQuery);