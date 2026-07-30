+function ($) {
    "use strict";

    var TranslationsEditor = function () {
        this.init()
    }

    TranslationsEditor.prototype.constructor = TranslationsEditor

    TranslationsEditor.prototype.init = function () {
        $(document).on('change', '[data-control="string-filter"]', $.proxy(this.onSubmit))
        $(document).on('click', '[data-control="edit-translation"]', $.proxy(this.onToggleEditMode))
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

    TranslationsEditor.prototype.onToggleEditMode = function (event) {
        var $el = $(event.currentTarget),
            $container = $el.closest('tr'),
            $icon = $container.find('[data-control="edit-translation"] i'),
            inputName = $el.data('input-name'),
            source = $el.data('source'),
            translation = $el.data('translation');

        if (!$container.hasClass('editing')) {
            $container.addClass('editing')
            $icon.removeClass('fa-pencil').addClass('fa-xmark-circle')
            $container.find('[data-toggle="translation-preview"]').hide()
            $container.find('[data-toggle="translation-input"]').html(
                '<input type="hidden" name="'+inputName+'[source]">'
                +'<textarea rows="1" name="'+inputName+'[translation]" class="form-control"></textarea>'
            )

            $container.find('input').val(source)
            $container.find('textarea').text(translation).focus()
        } else if ($el.is('a')) {
            if (confirm('Are you sure you want to cancel editing this translation?')) {
                $container.removeClass('editing')
                $icon.addClass('fa-pencil').removeClass('fa-xmark-circle')
                $container.find('[data-toggle="translation-preview"]').show()
                $container.find('[data-toggle="translation-input"]').empty()
            }
        }
    }

    // INITIALIZATION
    // ============================

    $(document).render(function () {
        new TranslationsEditor()
    })
}(window.jQuery);
