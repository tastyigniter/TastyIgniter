/*
 * Rich text editor form field control (WYSIWYG)
 *
 * Data attributes:
 * - data-control="rich-editor" - enables the summer note plugin
 *
 * JavaScript API:
 * $('textarea').richEditor()
 */
+function ($) {
    "use strict"

    // RICHEDITOR CLASS DEFINITION
    // ============================

    var RichEditor = function (element, options) {
        this.$el = $(element)
        this.options = options
        this.$textarea = this.$el.find(">textarea:first")
        this.$form = this.$el.closest("form")
        this.editor = null

        this.init()
    }

    RichEditor.prototype.constructor = RichEditor

    RichEditor.prototype.init = function () {
        this.$el.one("dispose-control", $.proxy(this.dispose))

        // Textarea must have an identifier
        if (!this.$textarea.attr("id")) {
            this.$textarea.attr("id", "element-" + Math.random().toString(36).substring(7))
        }

        this.registerHandlers()

        // Initialize Summer note
        this.initSummerNote()
    }

    RichEditor.prototype.registerHandlers = function () {
    }

    RichEditor.prototype.unregisterHandlers = function () {

    }

    RichEditor.prototype.dispose = function () {
        this.unregisterHandlers()

        this.$textarea.summernote("destroy")

        this.$el.removeData("ti.richEditor")

        this.options = null
        this.$el = null
        this.$textarea = null
        this.$form = null
        this.editor = null
    }

    RichEditor.prototype.initSummerNote = function () {
        if (this.options.buttons.mediafinder === undefined) {
            this.options.buttons.mediafinder = $.proxy(this.mediaFinderButton, this)
        }

        this.editor = this.$textarea.summernote(this.options)
    }

    RichEditor.prototype.mediaFinderButton = function (context) {
        var ui = $.summernote.ui;

        var $finderButton = ui.button({
            contents: '<i class="fa fa-image"/>',
            click: $.proxy(this.onShowImageDialog, this)
        });

        return $finderButton.render();
    }

    RichEditor.prototype.onShowImageDialog = function (event) {
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

    RichEditor.prototype.insertImageFromMediaPopup = function ($element, items) {
        var start = 0
        for (var i = start, len = items.length; i < len; i++) {
            var item = items[i].querySelector("[data-media-item]"),
                filename = item.getAttribute('data-media-item-name'),
                url = item.getAttribute('data-media-item-url')

            this.$textarea.summernote('insertImage', url, filename);
        }
    }

    RichEditor.DEFAULTS = {
        mediaSelectMode: "multi",
        height: 300,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'mediafinder']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ],
        buttons: { mediafinder: undefined }        
    }

    // RICHEDITOR PLUGIN DEFINITION
    // ============================

    var old = $.fn.richEditor

    $.fn.richEditor = function (option) {
        var args = Array.prototype.slice.call(arguments, 1), result
        this.each(function () {
            var $this = $(this)
            var data = $this.data("ti.richEditor")
            var options = $.extend({}, RichEditor.DEFAULTS, $this.data(), typeof option == "object" && option)
            if (!data) $this.data("ti.richEditor", (data = new RichEditor(this, options)))
            if (typeof option == "string") result = data[option].apply(data, args)
            if (typeof result != "undefined") return false
        })

        return result ? result : this
    }

    $.fn.richEditor.Constructor = RichEditor

    // RICHEDITOR NO CONFLICT
    // =================

    $.fn.richEditor.noConflict = function () {
        $.fn.richEditor = old
        return this
    }

    // RICHEDITOR DATA-API
    // ===============
    $(document).render(function () {
        $("[data-control=\"rich-editor\"]").richEditor()
    })

}(window.jQuery)
