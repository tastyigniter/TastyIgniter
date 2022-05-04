// List Filter State Toggle
// Uses user cookie value to show/hide list filter bar
$(function () {
    var $listFilterButton = $('[data-toggle="list-filter"]'),
        $listFilterTarget = $($listFilterButton.data('target')),
        listFilterStoreName = $listFilterTarget.data('storeName'),
        displayFilterPanel = Cookies.get(listFilterStoreName)

    $listFilterButton.on('click', function () {
        var $button = $(this)

        $listFilterTarget.slideToggle(function () {
            $button.toggleClass('active')
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
    $(document).on('change', '.filter-scope select, .filter-scope input[type="checkbox"]', function (event) {
        $(event.currentTarget).closest('form').submit()
    })
})

$(function ($) {
    // List setup form sortables
    $('#lists-setup-modal-content').on('ajaxUpdate', function() {
        Sortable.create($('#lists-setup-sortable').get(0), {
            handle: '.form-check-handle',
        })
    })
})

// Bulk actions
$(function ($) {
    var checkedSelector = '.list-table input[name*=checked]:checked',
        $bulkActionsContainer = $('[data-control="bulk-actions"]'),
        $selectAllRecordsButton = $('[data-control="check-total-records"]')

    if (!$bulkActionsContainer.length)
        return;

    $(document).on('change', '.list-table input[name*=checked]', function (event) {
        onChangeListCheckboxes($(this))
    })

    $(document).on('change', '.list-table input[id^="checkboxAll-"]', function (event) {
        $('input[id^="checkboxAll-"]').prop('checked', this.checked)
        $selectAllRecordsButton.toggleClass('hide', !(this.checked && parseInt($bulkActionsContainer.data('actionTotalRecords')) > $(checkedSelector).length))
        onChangeListCheckboxes($(this))
    })

    $selectAllRecordsButton.on('click', function(event) {
        var $el = $(event.currentTarget)
        $el.toggleClass('active')
        $('[data-action-select-all]').prop('disabled', !$el.hasClass('active'))
        $('[data-action-counter]').html(
            $el.hasClass('active') ? $bulkActionsContainer.data('actionTotalRecords') : $(checkedSelector).length
        )
    })

    $(checkedSelector).trigger('change')

    function onChangeListCheckboxes($el) {
        var counter = $(checkedSelector).length
        if ($el.is(':checked')) {
            $bulkActionsContainer.removeClass('hide')
        }

        if (counter < 1) {
            $bulkActionsContainer.addClass('hide')
        }

        $('[data-action-counter]').html(counter)
        $('[data-action-select-all]').prop('disabled', true)
    }
})
