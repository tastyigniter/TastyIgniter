/*
 * The request API
 */

if (window.jQuery === undefined)
    throw new Error('TastyIgniter Javascript requires jQuery.');

if (window.jQuery.request !== undefined)
    throw new Error('The TastyIgniter Javascript framework is already loaded.');

/*
 * Custom event that unifies document.ready with window.ajaxUpdateComplete
 *
 * $(document).render(function() { })
 * $(document).on('render', function() { })
 */
+function ($) {
    "use strict";

    $(document).ready(function () {
        $(document).trigger('render')
    })

    $(window).on('ajaxUpdateComplete', function () {
        $(document).trigger('render')
    })

    $.fn.render = function (callback) {
        $(document).on('render', callback)
    }
}(window.jQuery);

/*
 * TastyIgniter AJAX plugin..
 *
 * Adapted from OctoberCMS AJAX plugin
 *
 * $.request('handler', function() { })
 * $(form).request('handler', function() { })
 */
+function ($) {
    "use strict";

    // REQUEST CLASS DEFINITION
    // =========================

    var Request = function (element, handler, options) {
        var $el = this.$el = $(element)
        this.options = options || {}

        // Prepare the options and execute the request
        var
            $form = options.form ? $(options.form) : $el.closest('form'),
            $triggerEl = !!$form.length ? $form : $el,
            context = {handler: handler, options: options},
            loading = options.loading !== undefined && options.loading.length ? $(options.loading) : null,
            isRedirect = options.redirect !== undefined && options.redirect.length

            var _event = jQuery.Event('ajaxSetup')
            $triggerEl.trigger(_event, context)
            if (_event.isDefaultPrevented()) return

        if ($.type(loading) == 'string') loading = $(loading)

        var requestData,
            inputName,
            submitForm = !!options.submit,
            data = {}

        $.each($el.parents('[data-request-data]').toArray().reverse(), function extendRequest() {
            $.extend(data, stringToObj('data-request-data', $(this).data('request-data')))
        })

        if ($el.is(':input') && !$form.length) {
            inputName = $el.attr('name')
            if (inputName !== undefined && options.data[inputName] === undefined) {
                options.data[inputName] = $el.val()
            }
        }

        if (options.data !== undefined && !$.isEmptyObject(options.data)) {
            $.extend(data, options.data)
        }

        if (submitForm) {
            data['_handler'] = handler
            $form.append(appendObjToForm(data, $form))
        } else {
            requestData = [$form.serialize(), $.param(data)].filter(Boolean).join('&')
        }

        var requestOptions = {
            context: context,
            headers: {
                'X-IGNITER-REQUEST-HANDLER': handler,
            },
            success: function (data, textStatus, jqXHR) {
                // Stop beforeUpdate() OR data-request-before-update returns false
                if (this.options.beforeUpdate.apply(this, [data, textStatus, jqXHR]) === false) return
                if (options.fireBeforeUpdate && eval('(function($el, context, data, textStatus, jqXHR) {' +
                    options.fireBeforeUpdate + '}.call($el.get(0), $el, context, data, textStatus, jqXHR))') === false) return

                // Trigger 'ajaxBeforeUpdate' on the form, stop if event.preventDefault() is called
                var _event = jQuery.Event('ajaxBeforeUpdate')
                $triggerEl.trigger(_event, [context, data, textStatus, jqXHR])
                if (_event.isDefaultPrevented()) return

                // Proceed with the update process
                var updatePromise = requestOptions.handleUpdateResponse(data, textStatus, jqXHR)

                updatePromise.done(function () {
                    $triggerEl.trigger('ajaxSuccess', [context, data, textStatus, jqXHR])
                    options.fireSuccess && eval('(function($el, context, data, textStatus, jqXHR) {' + options.fireSuccess + '}.call($el.get(0), $el, context, data, textStatus, jqXHR))')
                })

                return updatePromise
            },
            error: function (jqXHR, textStatus, errorThrown) {
                var errorMsg,
                    updatePromise = $.Deferred()

                if (errorThrown == 'abort')
                    return

                isRedirect = false
                options.redirect = null

                if (jqXHR.status == 406 && jqXHR.responseJSON) {
                    errorMsg = jqXHR.responseJSON['X_IGNITER_ERROR_MESSAGE']
                    updatePromise = requestOptions.handleUpdateResponse(jqXHR.responseJSON, textStatus, jqXHR)
                } else {
                    errorMsg = jqXHR.responseText ? jqXHR.responseText : jqXHR.statusText
                    updatePromise.resolve()
                }

                updatePromise.done(function () {
                    var _event = jQuery.Event('ajaxError')
                    $triggerEl.trigger(_event, [context, textStatus, jqXHR])
                    if (_event.isDefaultPrevented()) return

                    // Stop here if the data-request-error attribute returns false
                    if (options.fireError && eval('(function($el, context, textStatus, jqXHR) {' + options.fireError + '}.call($el.get(0), $el, context, textStatus, jqXHR))') === false)
                        return

                    requestOptions.handleErrorMessage(errorMsg)
                })

                return updatePromise

            },
            complete: function (data, textStatus, jqXHR) {
                $triggerEl.trigger('ajaxComplete', [context, data, textStatus, jqXHR])
                options.fireComplete && eval('(function($el, context, data, textStatus, jqXHR) {' + options.fireComplete + '}.call($el.get(0), $el, context, data, textStatus, jqXHR))')
            },

            // Custom function, requests confirmation from the user
            handleConfirmMessage: function (message) {
                var _event = jQuery.Event('ajaxConfirmMessage')

                _event.promise = $.Deferred()
                if ($(window).triggerHandler(_event, [message]) !== undefined) {
                    _event.promise.done(function () {
                        options.confirm = null
                        new Request(element, handler, options)
                    })
                    return false
                }

                if (_event.isDefaultPrevented()) return
                if (message) return confirm(message)
            },

            handleErrorMessage: function (message) {
                var _event = jQuery.Event('ajaxErrorMessage')
                $(window).trigger(_event, [message])
                if (_event.isDefaultPrevented()) return
                if (message) alert(message)
            },

            handleValidationMessage: function(message, fields) {
                $triggerEl.trigger('ajaxValidation', [context, message, fields])

                var isFirstInvalidField = true
                $.each(fields, function focusErrorField(fieldName, fieldMessages) {
                    fieldName = fieldName.replace(/\.(\w+)/g, '[$1]')

                    var fieldElement = $form.find('[name="'+fieldName+'"], [name="'+fieldName+'[]"], [name$="['+fieldName+']"], [name$="['+fieldName+'][]"]').filter(':enabled').first()
                    if (fieldElement.length > 0) {

                        var _event = jQuery.Event('ajaxInvalidField')
                        $(window).trigger(_event, [fieldElement.get(0), fieldName, fieldMessages, isFirstInvalidField])

                        if (isFirstInvalidField) {
                            if (!_event.isDefaultPrevented()) fieldElement.focus()
                            isFirstInvalidField = false
                        }
                    }
                })
            },

            // Custom function, redirect the browser to another location
            handleRedirectResponse: function (url) {
                window.location.href = url
            },

            // Custom function, handle any application specific response
            handleUpdateResponse: function (data, textStatus, jqXHR) {
                var updatePromise = $.Deferred().done(function () {
                    var dataArray = []
                    try {
                        dataArray = jQuery.type(data) === 'object' ? data : jQuery.parseJSON(data)
                    } catch (e) {
                    }

                    for (var partial in dataArray) {
                        var selector = partial
                        if (jQuery.type(selector) === 'string' && selector.charAt(0) == '@') {
                            $(selector.substring(1)).append(dataArray[partial]).trigger('ajaxUpdate', [context, data, textStatus, jqXHR])
                        } else if (jQuery.type(selector) == 'string' && selector.charAt(0) == '^') {
                            $(selector.substring(1)).prepend(dataArray[partial]).trigger('ajaxUpdate', [context, data, textStatus, jqXHR])
                        } else if (jQuery.type(selector) == 'string' && selector.charAt(0) == '~') {
                            $(selector.substring(1)).replaceWith(data[partial]).trigger('ajaxUpdate', [context, data, textStatus, jqXHR])
                        } else {
                            $(selector).trigger('ajaxBeforeReplace')
                            $(selector).html(dataArray[partial]).trigger('ajaxUpdate', [context, data, textStatus, jqXHR])
                        }
                    }

                    // Wait for .html() method to finish rendering from partial updates
                    setTimeout(function () {
                        $(window)
                            .trigger('ajaxUpdateComplete', [context, data, textStatus, jqXHR])
                            .trigger('resize')
                    }, 0)
                })

                // Handle redirect
                if (data['X_IGNITER_REDIRECT']) {
                    options.redirect = data['X_IGNITER_REDIRECT']
                    isRedirect = true
                }

                if (isRedirect)
                    requestOptions.handleRedirectResponse(options.redirect)

                if (data['X_IGNITER_ERROR_FIELDS'])
                    requestOptions.handleValidationMessage(data['X_IGNITER_ERROR_MESSAGE'], data['X_IGNITER_ERROR_FIELDS'])

                updatePromise.resolve()

                return updatePromise
            },
        }

        // Allow default business logic to be called from user functions
        context.success = requestOptions.success
        context.error = requestOptions.error
        context.complete = requestOptions.complete
        requestOptions = $.extend(requestOptions, options)
        requestOptions.data = requestData

        // Initiate request
        if (options.confirm && !requestOptions.handleConfirmMessage(options.confirm)) {
            return
        }

        if (loading) loading.show()

        if (submitForm) {
            $form.submit()
            return;
        }

        $(window).trigger('ajaxBeforeSend', [context])
        $el.trigger('ajaxPromise', [context])
        return $.ajax(requestOptions)
            .fail(function (jqXHR, textStatus, errorThrown) {
                if (!isRedirect) {
                    $el.trigger('ajaxFail', [context, textStatus, jqXHR])
                }
            })
            .done(function (data, textStatus, jqXHR) {
                if (!isRedirect) {
                    $el.trigger('ajaxDone', [context, data, textStatus, jqXHR])
                }

                if (loading) loading.hide()
            })
            .always(function (dataOrXhr, textStatus, xhrOrError) {
                $el.trigger('ajaxAlways', [context, dataOrXhr, textStatus, xhrOrError])
            })
    }

    Request.DEFAULTS = {
        type: 'POST',
        update: {},
        beforeUpdate: function (data, textStatus, jqXHR) {
        },
        fireBeforeUpdate: null,
        fireSuccess: null,
        fireError: null,
        fireComplete: null
    }

    // REQUEST PLUGIN DEFINITION
    // ============================

    var old = $.fn.request

    $.fn.request = function (handler, option) {
        var $this = $(this).first()
        var data = {
            fireBeforeUpdate: $this.data('request-before-update'),
            fireSuccess: $this.data('request-success'),
            fireError: $this.data('request-error'),
            fireComplete: $this.data('request-complete'),
            confirm: $this.data('request-confirm'),
            redirect: $this.data('request-redirect'),
            loading: $this.data('request-loading'),
            submit: $this.data('request-submit'),
            form: $this.data('request-form'),
            update: stringToObj('data-request-update', $this.data('request-update')),
            data: stringToObj('data-request-data', $this.data('request-data'))
        }
        if (!handler) handler = $this.data('request')
        var options = $.extend(true, {}, Request.DEFAULTS, data, typeof option == 'object' && option)
        return new Request($this, handler, options)
    }

    $.fn.request.Constructor = Request

    $.request = function (handler, option) {
        return $('<form />').request(handler, option)
    }

    // REQUEST NO CONFLICT
    // =================

    $.fn.request.noConflict = function () {
        $.fn.request = old
        return this
    }

    // REQUEST DATA-API
    // ==============

    $(document).on('submit', '[data-request]', function () {
        $(this).request()
        return false
    })

    $(document).on('change', 'select[data-request]', function () {
        $(this).request()
        return false
    })

    $(document).on('click', 'a[data-request], button[data-request]', function (e) {
        e.preventDefault()
        $(this).request()
        if ($(this).is('[type=submit]'))
            return false
    })

    function stringToObj(name, value) {
        if (value === undefined) value = ''
        if (typeof value == 'object') return value

        try {
            return JSON.parse(JSON.stringify(eval("({" + value + "})")))
        } catch (e) {
            throw new Error('Error parsing the ' + name + ' attribute value. ' + e)
        }
    }

    function appendObjToForm(objToAppend, $appendToForm) {
        $.each(objToAppend, function (key, value) {
            var input = $("<input>").attr({
                'type': 'hidden',
                'name': key
            }).val(value)

            $appendToForm.append(input)
        })
    }
}(window.jQuery);
