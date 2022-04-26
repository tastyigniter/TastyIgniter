+function ($) {
    "use strict";

    if ($.ti.mediaManager === undefined)
        $.ti.mediaManager = {}

    var MediaManagerModal = function (options) {
        this.modal = null
        this.$modalRootElement = null

        this.options = $.extend({}, MediaManagerModal.DEFAULTS, options)

        this.init()
        this.show()
    }

    MediaManagerModal.prototype.dispose = function () {
        this.modal.hide()
        this.$modalRootElement.remove()
        this.$modalElement = null
        this.$modalRootElement = null
    }

    MediaManagerModal.prototype.init = function () {
        if (this.options.alias === undefined)
            throw new Error('Media Manager modal option "alias" is not set.')

        this.$modalRootElement = $('<div/>', {
            id: 'media-manager',
            class: 'media-modal modal fade',
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
            handler = this.options.alias + '::onLoadPopup'

        var data = {
            selectMode: this.options.selectMode,
            goToItem: this.options.goToItem,
            chooseButton: this.options.chooseButton ? 1 : 0,
            chooseButtonText: this.options.chooseButtonText,
        }

        $.ti.loadingIndicator.show()
        $.request(handler, {data: data})
            .done(function (json) {
                self.$modalRootElement.html(json.result);
                $('body').append(self.$modalRootElement)
                self.modal = new bootstrap.Modal(self.$modalRootElement)
                self.modal.show()

            })
            .always(function () {
                $.ti.loadingIndicator.hide()
            })
    }

    MediaManagerModal.prototype.hide = function () {
        if (this.$modalElement)
            this.modal.hide()
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

        this.dispose()

        mediaManager.mediaManager('dispose')
        mediaManager.remove()

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

