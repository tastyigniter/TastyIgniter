/* ========================================================================
 * TastyIgniter: flashmessage.js v2.2.0
 * https://tastyigniter.com/docs/javascript
 * ======================================================================== */
+function ($) {
    "use strict"

    var FlashMessage = function (options, el) {
        options = $.extend({}, FlashMessage.DEFAULTS, options)

        if (options.interval > 0) {
            options.timer = options.interval * 1000
        }

        if (!options.allowDismiss || options.important) {
            options.timer = 0
            options.allowOutsideClick = false
            options.allowEscapeKey = false
        }

        if (options.overlay) {
            return FlashMessage.overlay(options)
        }

        options = $.extend(FlashMessage.TOAST_DEFAULTS, options, FlashMessage.getIcon(options))

        return Swal.fire(FlashMessage.parseOptions(options))
    }

    FlashMessage.overlay = function (options) {
        options = $.extend({},
            FlashMessage.DEFAULTS,
            FlashMessage.SWAL_DEFAULTS,
            options, FlashMessage.getIcon(options)
        )

        return Swal.fire(FlashMessage.parseOptions(options)).then((result) => {
            if (result.isConfirmed && options.actionUrl) {
                window.location.assign(options.actionUrl)
            }
        })
    }

    FlashMessage.confirm = function (message, confirmCallback, cancelCallback) {
        var options = $.extend({
            text: message,
            showCancelButton: true,
            allowOutsideClick: false,
            allowEscapeKey: false,
        }, FlashMessage.DEFAULTS, FlashMessage.SWAL_DEFAULTS)

        return Swal.fire(FlashMessage.parseOptions(options)).then((result) => {
            if (result.isConfirmed) {
                confirmCallback()
            } else if (result.isDismissed) {
                cancelCallback()
            }
        })
    }

    FlashMessage.getIcon = function (options) {
        return FlashMessage.ICONS[options.level ?? options.class]
    }

    FlashMessage.parseOptions = function (options) {
        return Object.keys(options)
            .filter(key => !Object.keys(FlashMessage.DEFAULTS)
                .includes(key)).reduce((obj, key) => {
                obj[key] = options[key];
                return obj;
            }, {});
    }

    FlashMessage.TOAST_DEFAULTS = {
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 0,
        timerProgressBar: true,
        showClass: {
            popup: 'animated fadeInRight'
        },
        hideClass: {
            popup: 'animated fadeOutRight'
        },
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        },
    }

    FlashMessage.SWAL_DEFAULTS = {
        position: 'top',
        timerProgressBar: true,
        reverseButtons: true,
        buttonsStyling: false,
        customClass: {
            container: 'modal-backdrop',
            confirmButton: 'btn btn-primary mx-2',
            cancelButton: 'btn btn-light mx-2',
            closeButton: 'btn btn-danger mx-2',
            denyButton: 'btn btn-danger mx-2',
        },
        showClass: {
            popup: 'animated fadeInDown'
        },
        hideClass: {
            popup: 'animated fadeOutUp'
        },
    }

    FlashMessage.DEFAULTS = {
        control: undefined,
        container: '#notification',
        level: undefined,
        important: undefined,
        overlay: undefined,
        class: 'success',
        interval: 5,
        allowDismiss: true,
        actionUrl: undefined,
    }

    FlashMessage.ICONS = {
        warning: {
            icon: 'warning',
            iconHtml: '<i class="fa fa-fw fa-xs fa-exclamation-triangle"></i>',
        },
        danger: {
            icon: 'error',
            iconHtml: '<i class="fa fa-fw fa-xs fa-times-circle"></i>',
        },
        success: {
            icon: 'success',
            iconHtml: '<i class="fa fa-fw fa-xs fa-circle-check"></i>',
        },
        info: {
            icon: 'info',
            iconHtml: '<i class="fa fa-fw fa-xs fa-info-circle"></i>',
        },
        question: {
            icon: 'question',
            iconHtml: '<i class="fa fa-fw fa-xs fa-question-circle"></i>',
        },
    }

    // FLASH MESSAGE PLUGIN DEFINITION
    // ============================

    if ($.ti === undefined)
        $.ti = {}

    $.ti.flashMessage = FlashMessage

    // FLASH MESSAGE DATA-API
    // ===============

    $(document).render(function () {
        $('[data-control="flash-message"]:not(.loaded)').each(function (index, element) {
            setTimeout(function () {
                $.ti.flashMessage($(element).data(), element)
            }, (index+1) * 500)
            $(element).addClass('loaded')
        })

        $('[data-control="flash-overlay"]:not(.loaded)').each(function (index, element) {
            $.ti.flashMessage.overlay($.extend({}, $(element).data(), $(element).data('closeOnEsc') === true ? {
                timer: (index+1) * 3000
            } : {}))
            $(element).addClass('loaded')
        })
    })

    $(document).on('ajaxValidation', '[data-request][data-request-validate]', function (event, context, errorMsg, fields) {
        var $this = $(this).closest('form'),
            $container = $('[data-validate-error]', $this),
            messages = [],
            $field

        $.each(fields, function (fieldName, fieldMessages) {
            $field = $('[data-validate-for="'+fieldName+'"]', $this)
            messages = $.merge(messages, fieldMessages)
            if (!!$field.length) {
                if (!$field.text().length || $field.data('emptyMode') == true) {
                    $field
                        .data('emptyMode', true)
                        .text(fieldMessages.join(', '))
                }
                $field.addClass('visible')
            }
        })

        if (!!$container.length) {
            $container = $('[data-validate-error]', $this)
        }

        if (!!$container.length) {
            var $oldMessages = $('[data-message]', $container)
            $container.addClass('visible')

            if (!!$oldMessages.length) {
                var $clone = $oldMessages.first()

                $.each(messages, function (key, message) {
                    $clone.clone().text(message).insertAfter($clone)
                })

                $oldMessages.remove()
            } else {
                $container.text(errorMsg)
            }
        }

        $this.one('ajaxError', function (event) {
            event.preventDefault()
        })
    })

    $(document).on('ajaxPromise', '[data-request][data-request-validate]', function () {
        var $this = $(this).closest('form')
        $('[data-validate-for]', $this).removeClass('visible')
        $('[data-validate-error]', $this).removeClass('visible')
    })

    $(window).on('ajaxInvalidField', function (event, fieldElement, fieldName, fieldMessages) {
        var $fieldContainer = $(fieldElement).addClass('has-error').closest('[data-field-name]'),
            $feedbackElement = $('<div />')
                .attr('data-error-name', fieldName)
                .addClass('text-sm text-danger mt-1').text(fieldMessages.join('<br>'))

        $fieldContainer.find('[data-error-name]').remove()
        $fieldContainer.find('.form-label').addClass('text-danger')
        $fieldContainer.append($feedbackElement)
    })

    $(document).on('input', 'input.has-error, textarea.has-error, select.has-error', function (e) {
        var $fieldContainer = $(this).closest('[data-field-name]')
        $fieldContainer.find('[data-error-name]').remove()
        $fieldContainer.find('.form-label').removeClass('text-danger')
    })

    window.legacyAlert = window.alert;
    window.alert = function (message, title, type, params) {
        $.ti.flashMessage.overlay($.extend({
            title: title,
            text: message,
            type: type
        }, params || {}));
    };
}(window.jQuery)
