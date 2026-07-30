+function ($) {
    "use strict"

    $(document).render(function () {
        $(document).find('[data-control="country-code-picker"]').each(function () {
            const $el = $(this),
                $telephoneInput = $('#'+$el.data('hiddenInputId')),
                $feedbackEl = $('<div>').attr('class', 'text-danger'),
                errorMessages = $el.data('errorMessages') || {},
                options = {
                    initialCountry: (app.country.iso_code_2 || '').toLowerCase(),
                    separateDialCode: true,
                    nationalMode: true,
                    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.4/js/utils.js"
                };

            $telephoneInput.after($feedbackEl)

            var telephonePicker = intlTelInput($el.get(0), $.extend(options, $el.data()));

            $el.on('keyup change', function () {
                const event = new Event('telephoneChange', {bubbles: true});

                if ($el.val() && telephonePicker.isValidNumber()) {
                    $feedbackEl.text('')
                    $telephoneInput.val(telephonePicker.getNumber())
                } else {
                    const errorCode = telephonePicker.getValidationError()
                    $feedbackEl.text(errorMessages[errorCode] || "Invalid number")
                }

                $telephoneInput.get(0).dispatchEvent(event)
            })
        });
    });
}(window.jQuery)
