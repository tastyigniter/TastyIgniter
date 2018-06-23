+function ($) {
    "use strict";

    var MediaFinder = function (element, options) {
        this.$el = $(element)
        this.options = options || {}
        this.init()
    }

    MediaFinder.prototype.init = function () {
        this.$container = $('.media-image', this.$el)
        this.$template = this.$el.get(0).querySelector('[data-image-template]')
        this.$blankTemplate = this.$el.get(0).querySelector('[data-blank-template]')

        if (this.options.isMulti === null) {
            this.options.isMulti = this.$el.hasClass('is-multi')
        }

        this.$el.on('click', '.find-button', $.proxy(this.onClickFindButton, this))
        this.$el.on('click', '.find-remove-button', $.proxy(this.onClickRemoveButton, this))
    }

    MediaFinder.prototype.dispose = function () {
        this.$el.off('click', '.find-button', $.proxy(this.onClickFindButton))
        this.$el.off('click', '.find-remove-button', $.proxy(this.onClickRemoveButton))
        this.$el.off('dispose-control', $.proxy(this.dispose))
        this.$el.removeData('ti.mediaFinder')

        this.$findValue = null
        this.$el = null
        this.options = null
    }

    MediaFinder.prototype.onClickRemoveButton = function (event) {
        var $button = $(event.target)

        $button.closest('.media-finder').remove()

        if (!this.options.isMulti)
            this.$container.append(this.$blankTemplate.innerHTML)
    }

    MediaFinder.prototype.onClickFindButton = function (event) {
        var self = this,
            $button = $(event.target),
            $findValue = $('[data-find-value]', $button.closest('.media-finder'))

        new $.ti.mediaManager.modal({
            alias: 'mediamanager',
            selectMode: this.options.isMulti ? 'multi' : 'single',
            chooseButton: true,
            goToItem: $findValue.val(),
            onInsert: function (items) {
                if (!items.length) {
                    alert('Please select image(s) to insert.')
                    return
                }

                if (this.options.isMulti && items.length > 1) {
                    alert('Please select a single item.')
                    return
                }

                self.updateFinder($button, items)

                this.hide()
            }
        })
    }

    MediaFinder.prototype.updateFinder = function ($element, items) {
        var item,
            $finderElement = $element.closest('.media-finder'),
            $listElement = this.$container.find('.image-list'),
            isPopulated = $('[data-find-value]', $finderElement).val(),
            $template = $(this.$template.innerHTML)

        if (isPopulated || !this.options.isMulti) {
            item = items[0].querySelector('[data-media-item]');
            this.populateValue(item, $template)
            $finderElement.html($template.html())
        }

        if (!$listElement)
            return;

        var start = isPopulated ? 1 : 0
        for (var i = start, len = items.length; i < len; i++) {
            item = items[i].querySelector('[data-media-item]')
            this.populateValue(item, $template)
            $listElement.find('> .media-finder:last-child').before($template.clone())
        }
    }

    MediaFinder.prototype.populateValue = function (item, $template) {
        var $findName = $template.find('[data-find-name]'),
            $findImage = $template.find('[data-find-image]'),
            $findValue = $template.find('[data-find-value]')

        if ($findName.length) $findName.text(item.getAttribute('data-media-item-name'))
        if ($findImage.length) $findImage.attr('src', item.getAttribute('data-media-item-url'))
        if ($findValue.length) $findValue.val(item.getAttribute('data-media-item-path'))
        if ($findValue.length) $findValue.text(item.getAttribute('data-media-item-path'))

        // fallback: not sure why val() doesn't work in some cases
        if ($findValue.length) $findValue.attr('value', item.getAttribute('data-media-item-path'))
    }

    MediaFinder.DEFAULTS = {
        mode: null,
        isMulti: null,
    }

    // PLUGIN DEFINITION
    // ============================

    var old = $.fn.mediaFinder

    $.fn.mediaFinder = function (option) {
        var args = arguments;

        return this.each(function () {
            var $this = $(this)
            var data = $this.data('ti.mediaFinder')
            var options = $.extend({}, MediaFinder.DEFAULTS, $this.data(), typeof option == 'object' && option)
            if (!data) $this.data('ti.mediaFinder', (data = new MediaFinder(this, options)))
            if (typeof option == 'string') data[option].apply(data, args)
        })
    }

    $.fn.mediaFinder.Constructor = MediaFinder

    $.fn.mediaFinder.noConflict = function () {
        $.fn.mediaFinder = old
        return this
    }

    $(document).ready(function () {
        $('[data-control="mediafinder"]').mediaFinder();
    })

}(window.jQuery);
