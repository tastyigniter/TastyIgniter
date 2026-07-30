/*
 * Custom event that unifies document.ready with livewire:init
 *
 * $(document).render(function() { })
 * $(document).on('render', function() { })
 */
+function ($) {
    "use strict";

    app.requestTimeout = 150

    $(document).on('livewire:init', () => {
        setTimeout(() => {
            $(document).trigger('render')
        }, app.requestTimeout)

        Livewire.hook('request', ({uri, options, payload, respond, succeed, fail}) => {
            $(window).trigger('ajaxBeforeSend', [uri, options, payload, respond, succeed, fail])

            respond(({status, response}) => {
                setTimeout(() => {
                    $(document).trigger('render')
                    $(window).trigger('ajaxAlways', [status, response])
                }, app.requestTimeout)
            })
            succeed(({status, json}) => {
                setTimeout(() => {
                    $(window).trigger('ajaxDone', [status, json])
                }, app.requestTimeout)
            })
            fail(({status, content, preventDefault}) => {
                setTimeout(() => {
                    $(window).trigger('ajaxFail', [status, content, preventDefault])
                }, app.requestTimeout)
            })
        })
    })

    $.fn.render = function (callback) {
        $(document).on('render', callback)
    }
}(window.jQuery);

/*
 * Ensure the CSRF token is added to all AJAX requests.
 */
$.ajaxPrefilter(function (options) {
    var token = $('meta[name="csrf-token"]').attr('content')

    if (token) {
        if (!options.headers) options.headers = {}
        options.headers['X-CSRF-TOKEN'] = token
    }
});

$(function () {
    $(window).on('ajaxError', function (event, context, textStatus, jqXHR) {
        if (!jqXHR.responseJSON || !jqXHR.responseJSON.X_IGNITER_ERROR_FIELDS) return
        var fields = jqXHR.responseJSON.X_IGNITER_ERROR_FIELDS
        for (let field in fields) {
            var fieldName = dotToArrayString(field),
                $field = $('input[name="'+fieldName+'"], select[name="'+fieldName+'"]'),
                $floating = $field.closest('.form-floating')
            $field.attr('required', true)
            $field.addClass('is-invalid')
            $floating.addClass('is-invalid')
            $floating.find('.invalid-feedback').html(fields[field][0])
        }

        event.preventDefault()
    })

    $(window).on('ajaxErrorMessage', function (event, message) {
        event.preventDefault()
        Swal.fire({class: 'danger', text: message})
    })

    function dotToArrayString(str) {
        if (str.indexOf('.') !== -1) {
            let parts = str.split('.'), output = parts[0]
            for (var i = 1; i < parts.length; i++) output += '['+parts[i]+']'

            return output
        } else {
            return str
        }
    }
});

// CURRENCY HELPER FUNCTION DEFINITION
// ============================
$(function () {
    if (app) {
        app.currencyFormat = function (amount) {
            if (!app.currency) throw 'Currency values not defined in app scope';

            return currency(amount, {
                decimal: app.currency.decimal_sign,
                precision: app.currency.decimal_precision,
                separator: app.currency.thousand_sign,
                symbol: app.currency.symbol,
                pattern: app.currency.symbol_position ? '#!' : '!#',
            }).format();

        };
    }
});

// Geolocate user position
$(function () {
    $(document).on('click', '[data-control="user-position"]', (event) => {
        const $button = $(event.currentTarget)
        $button.addClass('disabled')
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition((position) => {
                Livewire.dispatch('userPositionUpdated', {
                    position: [position.coords.latitude, position.coords.longitude], updateMap: true
                })
            }, (error) => {
                $button.removeClass('disabled')
                Swal.fire({class: 'danger', text: `ERROR(${error.code}): ${error.message}`})
            }, {
                enableHighAccuracy: true, maximumAge: 30000, timeout: 10000
            });
        } else {
            Swal.fire("Geolocation is not supported by your browser.");
        }
    });
});

// Show selected menu item modal
window.OrangeShowSelectedMenuItemModal = () => {
    return {
        init() {
            this.$nextTick(() => {
                setTimeout(() => {
                    $(this.$refs['selectedMenuItemTrigger']).trigger('click');

                    const urlObj = new URL(window.location.href.toString());
                    urlObj.searchParams.delete('menuId');
                    history.replaceState({}, '', urlObj.toString());
                }, 300)
            })
        }
    }
};
