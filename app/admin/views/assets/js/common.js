// Creates event handler input tags and append to form before submitting
$(function () {
    $(document).on('click', 'a[data-request], button[data-request]', function () {
        var $element = $(this),
            handler = $element.data('request'),
            $form = $($element.data('requestForm'))

        $form = $form.length ? $form : $element.closest('form')

        if (handler && $form) {
            if ($element.data('requestConfirm') && !confirm($element.data('requestConfirm'))) {
                return false
            }

            var params = stringToObj('data-request-data', $(this).data('request-data'))
            for (var index in params) {
                $form.find('input[name="' + index + '"]').remove()
                $form.append('<input type="hidden" name="' + index + '" value="' + params[index] + '" />')
            }

            $form.find('input[name="_handler"]').remove()
            $form.append('<input type="hidden" name="_handler" value="' + handler + '" />')

            $form.submit()
        }
    })

    function stringToObj(name, value) {
        if (value === undefined) value = ''
        if (typeof value == 'object') return value

        try {
            return JSON.parse(JSON.stringify(eval("({" + value + "})")))
        }
        catch (e) {
            throw new Error('Error parsing the ' + name + ' attribute value. ' + e)
        }
    }
})

$(function () {
    $("#side-menu").metisMenu()
})

//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
// $(function () {
//
//     var collapseState = Cookies.set('ti_sidebarToggleState')
//
//     $(window).bind("load resize", function () {
//         topOffset = 50
//         width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width
//         if (width < 768) {
//             $('.navbar-top .navbar-collapse').addClass('collapse')
//             $('#wrapper').removeClass('hide-sidebar')
//             topOffset = 100 // 2-row-menu
//         } else {
//             $('.navbar-top .navbar-collapse').removeClass('collapse')
//             if (collapseState == 'hide') {
//                 $('#wrapper').addClass('hide-sidebar')
//             }
//         }
//
//         height = (this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height
//         height = height - topOffset
//         if (height < 1) height = 1
//         if (height > topOffset) {
//             $("#page-wrapper").css("min-height", (height - 35) + "px")
//             $("#page-wrapper").css("height", "100%")
//         }
//     })
//
//     $(document).on('click', '.sidebar-toggle', function () {
//         if ($('#wrapper').hasClass('hide-sidebar')) {
//             $('#wrapper').removeClass('hide-sidebar')
//             Cookies.set('ti_sidebarToggleState', 'show')
//         } else {
//             $('#wrapper').addClass('hide-sidebar')
//             Cookies.set('ti_sidebarToggleState', 'hide')
//         }
//     })
// })

// List Filter State Toggle
// Uses user cookie value to show/hide list filter bar
// todo: move to widget assets file.
$(function () {
    var $listFilterElement = $('[data-toggle="list-filter"]'),
        displayFilterPanel = Cookies.set('ti_displayFilterPanel')

    $listFilterElement.on('click', function () {
        var $filterButton = $(this),
            $filterTarget = $($filterButton.data('target'))

        $filterTarget.slideToggle(function () {
            $filterButton.button('toggle')
            Cookies.set($filterTarget.data('storeName'), $filterTarget.is(':visible') ? 1 : 0)
        })
    })

    if (displayFilterPanel > 0) {
        $listFilterElement.addClass('active')
    }
})

// Alert Collapsible
$(function () {
    var alertMsgs = $('.alert-collapsible .alert-hide')
    var dropdownButton = $('.btn-dropdown')
    alertMsgs.hide()

    //Click dropdown
    dropdownButton.click(function () {
        //current button
        var currentButton = $(this)
        alertMsgs.slideToggle(400, function () {
            //Completed slidetoggle
            if (alertMsgs.is(':visible')) {
                currentButton.html('<i class="fa fa-chevron-up text-muted"></i>')
            } else {
                currentButton.html('<i class="fa fa-chevron-down text-muted"></i>')
            }
        })
    })
})

// Checkbox button toggle
$(function () {
    $('.button-checkbox').each(function () {
        // Setting
        var $widget = $(this),
            $button = $widget.find('button'),
            $checkbox = $widget.find('input:checkbox'),
            color = $button.data('color'),
            settings = {
                on: {
                    icon: 'fa fa-check-square-o'
                },
                off: {
                    icon: 'fa fa-square-o'
                }
            }

        // Event Handlers
        $button.on('click', function () {
            $checkbox.prop('checked', !$checkbox.is(':checked'))
            $checkbox.triggerHandler('change')
            updateDisplay()
        })
        $checkbox.on('change', function () {
            updateDisplay()
        })

        // Actions
        function updateDisplay() {
            var isChecked = $checkbox.is(':checked')

            // Set the button's state
            $button.data('state', (isChecked) ? "on" : "off")

            // Set the button's icon
            $button.find('.state-icon')
                .removeClass()
                .addClass('state-icon ' + settings[$button.data('state')].icon)

            // Update the button's color
            if (isChecked) {
                $button
                    .removeClass('btn-default')
                    .addClass('btn-' + color + ' active')
            }
            else {
                $button
                    .removeClass('btn-' + color + ' active')
                    .addClass('btn-default')
            }
        }

        // Initialization
        function init() {

            updateDisplay()

            // Inject the icon if applicable
            if ($button.find('.state-icon').length == 0) {
                $button.prepend('<i class="state-icon ' + settings[$button.data('state')].icon + '"></i>')
            }
        }

        init()
    })
})

$(document).ready(function () {
    $('[data-toggle="score"]').on('click', function () {
        displayRatings($(this).attr('data-score-hints'))
    })
})

function displayRatings(ratings) {
    $('.rating-star').raty({
        score: function () {
            return $(this).attr('data-score')
        },
        scoreName: function () {
            return $(this).attr('data-score-name')
        },
        readOnly: function () {
            return $(this).attr('data-readonly') == 'true'
        },
        hints: ratings,
        starOff: 'fa fa-star-o',
        starOn: 'fa fa-star',
        cancel: false, half: false, starType: 'i'
    })

    $('.rating-star i[title]').tooltip({placement: 'bottom'})
}

// Multiple Modal Fix
$(document).on('show.bs.modal', '.modal', function () {
    var zIndex = 1040 + (10 * $('.modal:visible').length + 1)
    $(this).css('z-index', zIndex)
    $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 2).addClass('modal-stack')
    setTimeout(function () {
        $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack')
    }, 0)
})

$(document).on('hidden.bs.modal', '.modal', function () {
    $('.modal:visible').length && $(document.body).addClass('modal-open')
})