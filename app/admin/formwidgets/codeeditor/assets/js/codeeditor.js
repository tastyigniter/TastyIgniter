/*
 * Code editor form field control
 *
 * Data attributes:
 * - data-control="code-editor" - enables the summer note plugin
 *
 * JavaScript API:
 * $('textarea').codeEditor()
 */
+function ($) {
    "use strict"

    // CODEEDITOR CLASS DEFINITION
    // ============================

    var CodeEditor = function (element, options) {
        this.$el = $(element)
        this.options = options
        this.$textarea = this.$el.find(">textarea:first")
        this.$form = this.$el.closest("form")
        this.editor = null

        this.init()
    }

    CodeEditor.prototype.constructor = CodeEditor

    CodeEditor.DEFAULTS = {
        changedSelector: null,
        theme: 'default',
        mode: 'css',
        lineSeparator: null,
        readOnly: false,
        lineNumbers: true,
        dragDrop: false,
        // tabSize: 2,
        height: 600
    }

    CodeEditor.prototype.init = function () {
        this.$el.one("dispose-control", $.proxy(this.dispose))

        // Textarea must have an identifier
        if (!this.$textarea.attr("id")) {
            this.$textarea.attr("id", "element-" + Math.random().toString(36).substring(7))
        }

        this.registerHandlers()

        // Initialize code mirror
        this.initCodeMirror()
    }

    CodeEditor.prototype.registerHandlers = function () {
        // this.$textarea.on("summernote.init", $.proxy(this.onInit, this))
        this.$form.on("submit", $.proxy(this.onSaveChanges, this))
    }

    CodeEditor.prototype.unregisterHandlers = function () {

    }

    CodeEditor.prototype.dispose = function () {
        this.unregisterHandlers()

        this.$textarea.summernote("destroy")

        this.$el.removeData("ti.codeEditor")

        this.options = null
        this.$el = null
        this.$textarea = null
        this.$form = null
        this.editor = null
    }

    CodeEditor.prototype.initCodeMirror = function () {
        this.editor = CodeMirror.fromTextArea(this.$textarea[0], this.options)
        this.editor.setSize(null, this.options.height)
        console.log(this.options)
    }

    CodeEditor.prototype.onSaveChanges = function () {
        var $element = $(this.options.changedSelector, this.$el)

        $element.val(this.editor.isClean() ? "0" : "1")
    }

    CodeEditor.prototype.replaceImageDialogButton = function () {
        var $button = $("[data-event=\"showImageDialog\"]")

        if (!$button.length) return

        $button.attr("data-event", false)
        $button.on("click", $.proxy(this.onShowImageDialog, this))
    }

    CodeEditor.prototype.onShowImageDialog = function (event) {
        var self = this,
            $button = $(event.target)

        new $.ti.mediaManager.modal({
            alias: "mediamanager",
            selectMode: this.options.mediaSelectMode,
            chooseButton: true,
            // goToItem: $findValue.val(),
            onInsert: function (items) {
                if (!items.length) {
                    alert("Please select image(s) to insert.")
                    return
                }

                self.insertImageFromMediaPopup($button, items)

                this.hide()
            }
        })
    }

    CodeEditor.prototype.insertImageFromMediaPopup = function ($element, items) {
        var start = 0
        for (var i = start, len = items.length; i < len; i++) {
            var item = items[i].querySelector("[data-media-item]"),
                filename = item.getAttribute('data-media-item-name'),
                url = item.getAttribute('data-media-item-url')

            this.$textarea.summernote('insertImage', url, filename)
        }
    }

    // CodeEditor PLUGIN DEFINITION
    // ============================

    var old = $.fn.codeEditor

    $.fn.codeEditor = function (option) {
        var args = Array.prototype.slice.call(arguments, 1), result
        this.each(function () {
            var $this = $(this)
            var data = $this.data("ti.codeEditor")
            var options = $.extend({}, CodeEditor.DEFAULTS, $this.data(), typeof option == "object" && option)
            if (!data) $this.data("ti.codeEditor", (data = new CodeEditor(this, options)))
            if (typeof option == "string") result = data[option].apply(data, args)
            if (typeof result != "undefined") return false
        })

        return result ? result : this
    }

    $.fn.codeEditor.Constructor = CodeEditor

    // CodeEditor NO CONFLICT
    // =================

    $.fn.codeEditor.noConflict = function () {
        $.fn.codeEditor = old
        return this
    }

    // CodeEditor DATA-API
    // ===============
    $(document).ready(function () {
        $("[data-control=\"code-editor\"]").codeEditor()
    })


    // BUTTON DEFINITIONS
    // =================

    if ($.ti === undefined)
        $.ti = {}

    $.ti.codeEditorButtons = [
        "paragraphFormat",
        "paragraphStyle",
        "quote",
        "bold",
        "italic",
        "align",
        "formatOL",
        "formatUL",
        "insertTable",
        "insertLink",
        "insertImage",
        "insertVideo",
        "insertAudio",
        "insertFile",
        "insertHR",
        "fullscreen",
        "html"
    ]

}(window.jQuery)
