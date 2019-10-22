+function ($) {
    "use strict";

    var TranslationsEditor = function () {
        this.init()
    }

    TranslationsEditor.prototype.constructor = TranslationsEditor

    TranslationsEditor.prototype.init = function () {
        $(document).on('change', '[data-control="string-filter"]', $.proxy(this.onSubmit))
        $('[data-control="search-translations"]').keyup($.proxy(this.onSubmitSearch))
    }

    // EVENT HANDLERS
    // ============================

    TranslationsEditor.prototype.onSubmit = function (event) {
        $(event.target).request();
    }

    TranslationsEditor.prototype.onSubmitSearch = function (event) {
        if (event.keyCode === 13) {
            $(event.target).request();
        }
    }

    // INITIALIZATION
    // ============================

    $(document).render(function () {
        new TranslationsEditor()
    })
}(window.jQuery);