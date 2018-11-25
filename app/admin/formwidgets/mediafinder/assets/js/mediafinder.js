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
        this.$configTemplate = this.$el.get(0).querySelector('[data-config-modal-template]')

        if (this.options.isMulti === null) {
            this.options.isMulti = this.$el.hasClass('is-multi')
        }

        this.$el.on('click', '.find-button', $.proxy(this.onClickFindButton, this))
        this.$el.on('click', '.find-config-button', $.proxy(this.onClickConfigButton, this))
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
        var self = this,
            $button = $(event.target),
            $findId = $('[data-find-identifier]', $button.closest('.media-finder'))

        if (this.options.useAttachment) {
            $.request(this.options.alias+'::onRemoveAttachment', {
                data: {media_id: $findId.val()}
            }).done(function () {
                self.removeMediaItem($button)
            })
        } else {
            self.removeMediaItem($button)
        }
    }

    MediaFinder.prototype.onClickConfigButton = function (event) {
        var self = this,
            $container = $(event.target).closest('.media-finder'),
            $mediaIdentifier = $('[data-find-identifier]', $container).val(),
            $modalElement = $('<div/>', {
                id: this.options.alias+'attachment-config-modal',
                class: 'modal fade slideInDown',
                role: 'dialog',
                tabindex: -1,
                ariaLabelled: '#attachment-config-modal',
                ariaHidden: true,
            })

        $modalElement.html(this.$configTemplate.innerHTML)
        $modalElement.modal({backdrop: 'static', keyboard: false})

        $modalElement.one('shown.bs.modal', function (event) {
            $.request(self.options.alias + '::onLoadAttachmentConfig', {
                data: {media_id: $mediaIdentifier}
            }).done(function () {
                $modalElement.find('form').on('ajaxDone', function () {
                    $modalElement.modal('hide')
                })
            })
        })

        $modalElement.one('hide.bs.modal', function (event) {
            var $modalElement = $(event.target)

            $modalElement.remove()
        })
    }

    MediaFinder.prototype.onClickFindButton = function (event) {
        var self = this,
            $button = $(event.target),
            $findValue = $('[data-find-value]', $button.closest('.media-finder'))

        new $.ti.mediaManager.modal({
            alias: 'mediamanager',
            selectMode: this.options.isMulti ? 'multi' : 'single',
            chooseButton: true,
            chooseButtonText: this.options.chooseButtonText,
            goToItem: !this.options.useAttachment ? $findValue.val() : null,
            onInsert: function (items) {
                if (!items.length) {
                    alert('Please select image(s) to insert.')
                    return
                }

                if (!self.options.isMulti && items.length > 1) {
                    alert('Please select a single item.')
                    return
                }

                items = self.extractItemData(items)

                if (self.options.useAttachment) {
                    $.request(self.options.alias+'::onAddAttachment', {
                        data: {items: items}
                    }).done(function (response) {
                        self.updateFinder($button, response)
                    })
                } else {
                    self.updateFinder($button, items)
                }

                this.hide()
            }
        })
    }

    MediaFinder.prototype.onModalShown = function (event) {
        var $modalElement = $(event.target)

        $.request(this.options.alias + '::onLoadAttachmentConfig', {
            data: {media_id: $modalElement.data('findIdentifier')}
        })
    }

    MediaFinder.prototype.extractItemData = function (items) {
        var itemsToAttach = []

        $(items).find('[data-media-item-path]').each(function () {
            itemsToAttach.push($(this).data('mediaItemData'))
        })

        return itemsToAttach;
    }

    MediaFinder.prototype.removeMediaItem = function ($element) {
        $element.closest('.media-finder').remove()
        if (!this.options.isMulti)
            this.$container.append(this.$blankTemplate.innerHTML)
    }

    MediaFinder.prototype.updateFinder = function ($element, items) {
        var item,
            $listElement = this.$container.closest('.image-list'),
            $finderElement = $element.closest('.media-finder'),
            isPopulated = $('[data-find-value]', $finderElement).val(),
            $template = $(this.$template.innerHTML)

        if (isPopulated || !this.options.isMulti) {
            item = items[0];
            this.populateValue(item, $template)
            $finderElement.html($template.html())
        }

        if (!$listElement)
            return;

        var start = isPopulated ? 1 : 0
        for (var i = start, len = items.length; i < len; i++) {
            item = items[i]
            this.populateValue(item, $template)
            $listElement.find('> .media-finder:last-child').before($template.clone())
        }
    }

    MediaFinder.prototype.populateValue = function (item, $template) {
        var $findIdentifier = $template.find('[data-find-identifier]'),
            $findName = $template.find('[data-find-name]'),
            $findImage = $template.find('[data-find-image]'),
            $findValue = $template.find('[data-find-value]')

        if ($findIdentifier.length) $findIdentifier.val(item.identifier)
        if ($findName.length) $findName.text(item.path)
        if ($findImage.length) $findImage.attr('src', item.publicUrl)
        if ($findValue.length) $findValue.val(item.path)
    }

    MediaFinder.DEFAULTS = {
        alias: undefined,
        mode: null,
        isMulti: null,
        chooseButtonText: 'Choose',
        useAttachment: false,
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

    $(document).render(function () {
        $('[data-control="mediafinder"]').mediaFinder();
    })

}(window.jQuery);
