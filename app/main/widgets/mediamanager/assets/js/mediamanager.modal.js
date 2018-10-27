+function ($) {
    "use strict";

    if ($.ti.mediaManager === undefined)
        $.ti.mediaManager = {}

    var MediaManagerModal = function (options) {
        this.$modalRootElement = null

        this.options = $.extend({}, MediaManagerModal.DEFAULTS, options)

        this.init()
        this.show()
    }

    MediaManagerModal.prototype.dispose = function () {
        this.$modalElement.modal('hide')
        this.$modalRootElement.remove()
        this.$modalElement = null
        this.$modalRootElement = null
    }

    MediaManagerModal.prototype.init = function () {
        if (this.options.alias === undefined)
            throw new Error('Media Manager modal option "alias" is not set.')

        this.$modalRootElement = $('<div/>', {
            id: 'media-manager',
            class: 'media-modal modal',
            role: 'dialog',
            tabindex: -1,
            ariaLabelled: '#media-manager',
            ariaHidden: true,
        })

        this.$modalRootElement.one('hide.bs.modal', $.proxy(this.onModalHidden, this))
        this.$modalRootElement.one('shown.bs.modal', $.proxy(this.onModalShown, this))
    }

    MediaManagerModal.prototype.show = function () {
        var self = this,
            handler = this.options.alias + '::onLoadPopup',
            spinner = '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>',
            $loadingIndicator = $('<div/>').addClass('loading-fixed')
                .append($('<span />').addClass('spinner'))

        var data = {
            selectMode: this.options.selectMode,
            goToItem: this.options.goToItem,
            chooseButton: this.options.chooseButton ? 1 : 0,
            chooseButtonText: this.options.chooseButtonText,
        }

        $loadingIndicator.find('.spinner').html(spinner)
        $(document.body).append($loadingIndicator);

        $.request(handler, {
            data: data,
            success: function (json) {
                self.$modalRootElement.html(json);
                self.$modalRootElement.modal()
                $loadingIndicator.remove()
            },
        })
    }

    MediaManagerModal.prototype.hide = function () {
        if (this.$modalElement)
            this.$modalElement.trigger('hide.bs.modal')
    }

    MediaManagerModal.prototype.getMediaManagerElement = function () {
        return this.$modalElement.find('[data-control="media-manager"]')
    }

    MediaManagerModal.prototype.insertMedia = function () {
        var items = this.getMediaManagerElement().mediaManager('getSelectedItems')

        if (this.options.onInsert !== undefined)
            this.options.onInsert.call(this, items)
    }

    MediaManagerModal.prototype.onModalHidden = function (event) {
        var mediaManager = this.$modalElement.find('[data-control="media-manager"]')

        mediaManager.mediaManager('dispose')
        mediaManager.remove()

        this.dispose()

        if (this.options.onClose !== undefined)
            this.options.onClose.call(this)
    }

    MediaManagerModal.prototype.onModalShown = function (event) {
        this.$modalElement = $(event.target)

        this.$modalElement.on('insert.media.ti.mediamanager', $.proxy(this.insertMedia, this))

        this.$modalElement.find('[data-control="media-manager"]').mediaManager('selectMarkedItem')
    }

    MediaManagerModal.DEFAULTS = {
        alias: undefined,
        selectMode: undefined,
        onInsert: undefined,
        onClose: undefined
    }

    $.ti.mediaManager.modal = MediaManagerModal
}(window.jQuery);

