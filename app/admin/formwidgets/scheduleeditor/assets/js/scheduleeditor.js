+function ($) {
    "use strict";

    var ScheduleEditor = function (element, options) {
        this.$el = $(element)
        this.options = options
        this.editorModal = null

        this.init()
    }

    ScheduleEditor.prototype.constructor = ScheduleEditor

    ScheduleEditor.prototype.dispose = function () {
        this.editorModal.remove()
        this.editorModal = null
    }

    ScheduleEditor.prototype.init = function () {
        this.$el.on('click', '[data-editor-control]', $.proxy(this.onControlClick, this))
    }

    ScheduleEditor.prototype.loadRecordForm = function (event) {
        var $button = $(event.currentTarget)

        this.editorModal = new $.ti.recordEditor.modal({
            alias: this.options.alias,
            recordId: $button.data('schedule-code'),
            onSave: function () {
                this.hide()
            }
        })
    }

    // EVENT HANDLERS
    // ============================

    ScheduleEditor.prototype.onControlClick = function (event) {
        var control = $(event.currentTarget).data('editor-control')

        switch (control) {
            case 'load-schedule':
                this.loadRecordForm(event)
                break;
        }
    }

    ScheduleEditor.DEFAULTS = {
        data: {},
        alias: undefined
    }

    // FormTable PLUGIN DEFINITION
    // ============================

    var old = $.fn.scheduleEditor

    $.fn.scheduleEditor = function (option) {
        var args = Array.prototype.slice.call(arguments, 1), result
        this.each(function () {
            var $this = $(this)
            var data = $this.data('ti.scheduleEditor')
            var options = $.extend({}, ScheduleEditor.DEFAULTS, $this.data(), typeof option == 'object' && option)
            if (!data) $this.data('ti.scheduleEditor', (data = new ScheduleEditor(this, options)))
            if (typeof option == 'string') result = data[option].apply(data, args)
            if (typeof result != 'undefined') return false
        })

        return result ? result : this
    }

    $.fn.scheduleEditor.Constructor = ScheduleEditor

    // ScheduleEditor NO CONFLICT
    // =================

    $.fn.scheduleEditor.noConflict = function () {
        $.fn.scheduleEditor = old
        return this
    }

    // ScheduleEditor DATA-API
    // ===============
    $(document).render(function () {
        $('[data-control="scheduleeditor"]').scheduleEditor()
    })
}(window.jQuery);
