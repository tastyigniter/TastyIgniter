+function ($) {
    "use strict";

    if ($.ti.recordEditor === undefined)
        $.ti.recordEditor = {}

    var RecordEditorModal = function (options) {
        this.modal = null
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
        delete RecordEditorModal.DEFAULTS.recordDataCache[this.options.alias]
    }

    RecordEditorModal.prototype.init = function () {
        this.$modalRootElement = $('<div/>', this.options.attributes)

        this.$modalRootElement.one('hide.bs.modal', $.proxy(this.onModalHidden, this))
        this.$modalRootElement.one('shown.bs.modal', $.proxy(this.onModalShown, this))
    }

    RecordEditorModal.prototype.show = function () {
        this.$modalRootElement.html(
            '<div class="modal-dialog"><div class="modal-content"><div class="modal-body"><div class="text-center">'
            +'<div class="ti-loading spinner-border fa-3x fa-fw" role="status"></div><div class="fw-bold mt-2">Loading...</div>'
            +'</div></div></div></div>'
        );

        $('body').append(this.$modalRootElement)

        this.modal = new bootstrap.Modal('#'+this.options.attributes.id)
        this.modal.show()
    }

    RecordEditorModal.prototype.hide = function () {
        if (this.$modalElement)
            this.modal.hide()
    }

    RecordEditorModal.prototype.handleFormSetup = function (event, context) {
        if (this.options.onSubmit !== undefined)
            this.options.onSubmit.call(this, context)
    }

    RecordEditorModal.prototype.handleFormError = function (event, context, textStatus, jqXHR) {
        if (this.options.onFail !== undefined)
            this.options.onFail.call(this, context, jqXHR)
    }

    RecordEditorModal.prototype.handleFormDone = function (event, data, textStatus, jqXHR) {
        if (this.options.onSave !== undefined)
            this.options.onSave.call(this, data, jqXHR)
    }

    RecordEditorModal.prototype.onRecordLoaded = function (data) {
        this.$modalElement.html(data.result);

        var _event = jQuery.Event('recordEditorModalShown')
        $(window).trigger(_event, [this.$modalElement])
        if (_event.isDefaultPrevented()) return

        if (this.options.onLoad !== undefined)
            this.options.onLoad.call(this, data)

        this.$modalElement.find('form').on('ajaxSetup', $.proxy(this.handleFormSetup, this))
        this.$modalElement.find('form').on('ajaxError', $.proxy(this.handleFormError, this))
        this.$modalElement.find('form').on('ajaxDone', $.proxy(this.handleFormDone, this))
    }

    RecordEditorModal.prototype.onModalHidden = function (event) {
        this.dispose()

        if (this.options.onClose !== undefined)
            this.options.onClose.call(this)
    }

    RecordEditorModal.prototype.onModalShown = function (event) {
        var self = this,
            handler = this.options.handler ? this.options.handler : this.options.alias + '::onLoadRecord',
            recordData = this.options.recordData ? this.options.recordData : {recordId: this.options.recordId}

        self.$modalElement = $(event.target)

        if (this.options.alias)
            RecordEditorModal.DEFAULTS.recordDataCache[this.options.alias] = recordData

        $.request(handler, {
            data: recordData,
        }).done($.proxy(this.onRecordLoaded, this)).fail(function () {
            self.$modalElement.modal('hide')
        }).always(function () {
            self.$modalElement.modal('handleUpdate')
        })
    }

    RecordEditorModal.DEFAULTS = {
        alias: undefined,
        handler: undefined,
        recordId: undefined,
        recordData: undefined,
        onLoad: undefined,
        onSubmit: undefined,
        onSave: undefined,
        onFail: undefined,
        onClose: undefined,
        attributes: {
            id: 'record-editor-modal',
            class: 'record-modal modal fade',
            role: 'dialog',
            tabindex: -1,
            ariaLabelled: '#record-editor-modal',
            ariaHidden: true,
        },
        recordDataCache: {}
    }

    $.ti.recordEditor.modal = RecordEditorModal

    $(document).on('click', '[data-toggle="record-editor"]', function (event) {
        var $button = $(event.currentTarget),
            options = $.extend({
                onSave: function () {
                    this.hide()
                }
            }, $button.data())

        event.preventDefault()

        new $.ti.recordEditor.modal(options)
    })

    $.ajaxPrefilter(function(options) {
        if (!$.isEmptyObject(RecordEditorModal.DEFAULTS.recordDataCache)) {
            if (!options.headers) options.headers = {}
            options.headers['X-IGNITER-RECORD-EDITOR-REQUEST-DATA'] = JSON.stringify(RecordEditorModal.DEFAULTS.recordDataCache)
        }
    })
}(window.jQuery);

