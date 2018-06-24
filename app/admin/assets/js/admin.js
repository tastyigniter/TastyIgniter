jQuery(function ($) {
    $("#side-nav-menu").metisMenu({
        toggle: true,
        collapseInClass: 'show'
    })

    $(function () {
        $('a, span, button').tooltip({placement: 'bottom'});

        $.fn.select2.defaults.set('width', null);
        $.fn.select2.defaults.set('theme', 'bootstrap');
        $.fn.select2.defaults.set('minimumResultsForSearch', 10);
        $('select.form-control', document).select2();

        $('.alert', document).alert();
    });

    // List Filter State Toggle
    // Uses user cookie value to show/hide list filter bar
    // todo: move to widget assets file.
    $(function () {
        var $listFilterButton = $('[data-toggle="list-filter"]'),
            $listFilterTarget = $($listFilterButton.data('target')),
            listFilterStoreName = $listFilterTarget.data('storeName'),
            displayFilterPanel = Cookies.set(listFilterStoreName)

        $listFilterButton.on('click', function () {
            var $button = $(this)

            $listFilterTarget.slideToggle(function () {
                $button.button('toggle')
                if (!listFilterStoreName || !listFilterStoreName.length)
                    return

                Cookies.set(listFilterStoreName, $listFilterTarget.is(':visible') ? 1 : 0)
            })
        })

        if (displayFilterPanel > 0) {
            $listFilterButton.addClass('active')
        }
    })

    // Submit list filter form on select change
    $(function () {
        $(document).on('change', '.filter-scope select', function (event) {
            $(event.currentTarget).closest('form').submit()
        })
    })

    // List setup form sortables
    $('#lists-setup-modal-content').sortable({
        // containerSelector: '.form-check-group',
        itemPath: '.modal-body .list-group',
        itemSelector: '.list-group-item',
        placeholder: '<div class="placeholder sortable-placeholder"></div>',
        handle: '.form-check-handle',
        nested: false
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

    // Varying modal content
    $(document).on('show.bs.modal', '.modal', function (event) {
        var $modal = $(this),
            $button = $(event.relatedTarget)

        if (!$button.length)
            return

        $.each($button.get(0).attributes, function(index, attribute) {
            if (/^data-modal-/.test(attribute.name)) {
                var attrName = attribute.name.substr(11),
                    attrValue = attribute.value

                $modal.find('[data-modal-text="'+attrName+'"]').text(attrValue)
                $modal.find('[data-modal-input="'+attrName+'"]').val(attrValue)
            }
        });
    })
})
