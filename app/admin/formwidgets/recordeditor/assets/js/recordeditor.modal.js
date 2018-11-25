+function ($) {
    "use strict";

    if ($.ti.recordEditor === undefined)
        $.ti.recordEditor = {}

    var RecordEditorModal = function (options) {
        this.$modalRootElement = null

        this.options = $.extend({}, RecordEditorModal.DEFAULTS, options)

        this.init()
        this.show()
    }

    RecordEditorModal.prototype.dispose = function () {
        this.$modalElement.remove()
        this.$modalRootElement.remove()
        this.$modalElement = null
        this.$modalRootElement = null
    }

    RecordEditorModal.prototype.init = function () {
        if (this.options.alias === undefined)
            throw new Error('Record editor modal option "alias" is not set.')

        this.$modalRootElement = $('<div/>', this.options.attributes)

        this.$modalRootElement.one('hide.bs.modal', $.proxy(this.onModalHidden, this))
        this.$modalRootElement.one('shown.bs.modal', $.proxy(this.onModalShown, this))
    }

    RecordEditorModal.prototype.show = function () {
        this.$modalRootElement.html(
            '<div class="modal-dialog"><div class="modal-content"><div class="modal-body">'
            +'<span class="spinner"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></span>'
            +'</div></div></div>'
        );

        this.$modalRootElement.modal({backdrop: 'static', keyboard: false})
    }

    RecordEditorModal.prototype.hide = function () {
        if (this.$modalElement)
            this.$modalElement.modal('hide')
    }

    RecordEditorModal.prototype.handleFormError = function (event, dataOrXhr, textStatus, jqXHR) {
        $.ti.flashMessage({
            container: '#modal-notification',
            class: 'danger',
            text: jqXHR.responseText,
            interval: 0
        })

        event.preventDefault()
    }

    RecordEditorModal.prototype.onRecordSaved = function (event, data, textStatus, jqXHR) {
        if (this.options.onSave !== undefined)
            this.options.onSave.call(this, data, jqXHR)
    }

    RecordEditorModal.prototype.onRecordLoaded = function (json) {
        this.$modalElement.html(json);
        $(window).trigger('ajaxUpdateComplete')

        this.$modalElement.find('form').on('ajaxError', $.proxy(this.handleFormError, this))
        this.$modalElement.find('form').on('ajaxDone', $.proxy(this.onRecordSaved, this))
    }

    RecordEditorModal.prototype.onModalHidden = function (event) {
        this.dispose()

        if (this.options.onClose !== undefined)
            this.options.onClose.call(this)
    }

    RecordEditorModal.prototype.onModalShown = function (event) {
        var self = this,
            handler = this.options.alias + '::onLoadRecord'

        this.$modalElement = $(event.target)

        $.request(handler, {
            data: {
                recordId: this.options.recordId,
            },
            success: $.proxy(this.onRecordLoaded, this),
        })
    }

    RecordEditorModal.DEFAULTS = {
        alias: undefined,
        recordId: undefined,
        onSave: undefined,
        onClose: undefined,
        attributes: {
            id: 'record-editor-modal',
            class: 'record-modal modal fade',
            role: 'dialog',
            tabindex: -1,
            ariaLabelled: '#record-editor-modal',
            ariaHidden: true,
        }
    }

    $.ti.recordEditor.modal = RecordEditorModal
}(window.jQuery);

