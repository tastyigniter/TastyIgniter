+function ($) {
    "use strict";

    var MarkdownEditor = function (element, options) {
        this.$el = $(element)
        this.options = options || {}
        this.$textarea = $('textarea:first', this.$el)
        this.editor = null
        this.$form = null

        this.init()
    }

    MarkdownEditor.prototype.constructor = MarkdownEditor

    MarkdownEditor.prototype.init = function () {

        // Control must have an identifier
        if (!this.$el.attr('id')) {
            this.$el.attr('id', 'element-' + Math.random().toString(36).substring(7))
        }

        this.$form = this.$el.closest('form')

        this.initEditor()

        // this.$toolbar.on('click', '.btn, .md-dropdown-button', this.proxy(this.onClickToolbarButton))
    }

    MarkdownEditor.prototype.dispose = function () {
        this.$el.off('dispose-control', this.proxy(this.dispose))

        this.$toolbar.off('click', '.btn, .md-dropdown-button', this.proxy(this.onClickToolbarButton))

        this.$el.removeData('ti.markdownEditor')

        this.$el = null
        this.$textarea = null
        this.$toolbar = null
        this.editor = null
        this.$form = null

        this.options = null
    }

    MarkdownEditor.prototype.initEditor = function () {

        this.editor = editormd({
            id: this.$el.attr('id'),
            // width   : "90%",
            height: 640,
            path: "/app/admin/formwidgets/markdowneditor/assets/vendor/editormd/lib/"
        });
    }

    //
    // Events
    //

    MarkdownEditor.prototype.onClickToolbarButton = function (ev) {
        var $target = $(ev.target),
            $button = $target.is('a') ? $target : $target.closest('.btn'),
            action = $button.data('button-action'),
            template = $button.data('button-template')

        $button.blur()

        this.pauseUpdates()

        if (template) {
            this[action](template)
        }
        else {
            this[action]()
        }

        this.resumeUpdates()
        this.handleChange()
    }

    //
    // Media Manager
    //

    MarkdownEditor.prototype.launchMediaManager = function (onSuccess) {
        var self = this

        new $.ti.mediaManager.popup({
            alias: 'timediamanager',
            cropAndInsertButton: true,
            onInsert: function (items) {
                if (!items.length) {
                    alert('Please select image(s) to insert.')
                    return
                }

                if (items.length > 1) {
                    alert('Please select a single item.')
                    return
                }

                var path, publicUrl
                for (var i = 0, len = items.length; i < len; i++) {
                    path = items[i].path
                    publicUrl = items[i].publicUrl
                }

                // Spaces in URLs break Markdown syntax
                publicUrl = publicUrl.replace(/\s/g, '%20')

                onSuccess(publicUrl)

                this.hide()
            }
        })
    }

    MarkdownEditor.DEFAULTS = {
        vendorPath: '/',
        refreshHandler: null,
        buttons: ['formatting', 'bold', 'italic', 'unorderedlist', 'orderedlist', 'link', 'horizontalrule'],
        viewMode: 'tab'
    }

    // PLUGIN DEFINITION
    // ============================

    var old = $.fn.markdownEditor

    $.fn.markdownEditor = function (option) {
        var args = Array.prototype.slice.call(arguments, 1), items, result

        items = this.each(function () {
            var $this = $(this)
            var data = $this.data('ti.markdownEditor')
            var options = $.extend({}, MarkdownEditor.DEFAULTS, $this.data(), typeof option == 'object' && option)
            if (!data) $this.data('ti.markdownEditor', (data = new MarkdownEditor(this, options)))
            if (typeof option == 'string') result = data[option].apply(data, args)
            if (typeof result != 'undefined') return false
        })

        return result ? result : items
    }

    $.fn.markdownEditor.Constructor = MarkdownEditor

    $.fn.markdownEditor.noConflict = function () {
        $.fn.markdownEditor = old
        return this
    }

    $(document).render(function () {
        $('[data-control="markdowneditor"]').markdownEditor()
    })

    // BUTTON DEFINITIONS
    // =================

    if ($.ti === undefined)
        $.ti = {}

    $.ti.markdownEditorButtons = {}

}(window.jQuery);
