+function ($) {
    "use strict";

    var StatusEditor = function (element, options) {
        this.$el = $(element)
        this.options = options
        this.editorModal = null

        this.init()
    }

    StatusEditor.prototype.constructor = StatusEditor

    StatusEditor.prototype.init = function () {
        this.$el.on('shown.bs.modal', '[data-status-editor]', $.proxy(this.onModalShown, this))
        this.$el.on('hidden.bs.modal', '[data-status-editor]', $.proxy(this.onModalHidden, this))
    }

    StatusEditor.prototype.updateStatusField = function (status) {
        this.$el.find('[data-status-color]').css('color', status.status_color)
        this.$el.find('[data-status-name]').text(status.status_name)
        this.$el.find('[data-status-value]').val(status.status_id)
    }

    StatusEditor.prototype.updateModalValues = function (status) {
        if (!this.editorModal)
            return

        this.editorModal.find('[data-status-comment]').html(status.status_comment)
        this.editorModal.find('[data-status-notify]').each(function () {
            if (this.value == status.notify_customer)
                $(this).trigger('click')
        })
    }

    // EVENT HANDLERS
    // ============================

    StatusEditor.prototype.onStatusChanged = function (event) {
        var value = $(event.target).val()

        if (!this.options.data[value])
            return

        var status = this.options.data[value]

        this.updateStatusField(status)
        this.updateModalValues(status)
    }

    StatusEditor.prototype.onModalShown = function (event) {
        this.editorModal = $(event.target)
        this.editorModal.on('change', '[data-status-value]', $.proxy(this.onStatusChanged, this))
        this.editorModal.find('[data-status-value]').trigger('change')
    }

    StatusEditor.prototype.onModalHidden = function (event) {
        this.editorModal = $(event.target)
        this.editorModal.off('change', '[data-status-value]', $.proxy(this.onStatusChanged, this))
    }

    StatusEditor.DEFAULTS = {
        data: {},
    }

    // FormTable PLUGIN DEFINITION
    // ============================

    var old = $.fn.statusEditor

    $.fn.statusEditor = function (option) {
        var args = Array.prototype.slice.call(arguments, 1), result
        this.each(function () {
            var $this = $(this)
            var data = $this.data('ti.statusEditor')
            var options = $.extend({}, StatusEditor.DEFAULTS, $this.data(), typeof option == 'object' && option)
            if (!data) $this.data('ti.statusEditor', (data = new StatusEditor(this, options)))
            if (typeof option == 'string') result = data[option].apply(data, args)
            if (typeof result != 'undefined') return false
        })

        return result ? result : this
    }

    $.fn.statusEditor.Constructor = StatusEditor

    // StatusEditor NO CONFLICT
    // =================

    $.fn.statusEditor.noConflict = function () {
        $.fn.statusEditor = old
        return this
    }

    // StatusEditor DATA-API
    // ===============
    $(document).render(function () {
        $('[data-control="status-editor"]').statusEditor()
    })
}(window.jQuery);