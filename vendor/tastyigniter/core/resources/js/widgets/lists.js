// Submit list filter form on select change
$(function () {
    $(document).on('change', '.filter-scope select, .filter-scope input[type="checkbox"]', function (event) {
        $(event.currentTarget).closest('form').submit()
    })
})

$(function ($) {
    // List setup form sortables
    $('#lists-setup-modal-content').on('ajaxUpdate', function () {
        Sortable.create($('#lists-setup-sortable').get(0), {
            handle: '.form-check-handle',
        })
    })
});

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

    $selectAllRecordsButton.on('click', function (event) {
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
});

// List auto-refresh
$(function ($) {
    var pendingRequests = {}

    $('[data-list-refresh-interval]').each(function () {
        var id = $(this).attr('id'),
            interval = parseInt($(this).data('list-refresh-interval'), 10),
            handler = $(this).data('list-refresh-handler')

        if (!id || !interval || !handler)
            return;

        scheduleRefresh(id, handler, interval * 1000)
    })

    // A fresh lookup by id is required on every tick because onRefresh
    // replaces the list root element (~#id), leaving any cached
    // jQuery object referencing a detached node.
    function scheduleRefresh(id, handler, delay) {
        setTimeout(function () {
            var $list = $('#' + id)

            if (!$list.length)
                return;

            if (shouldSkipRefresh(id, $list)) {
                scheduleRefresh(id, handler, delay)
                return;
            }

            pendingRequests[id] = true
            $list.request(handler).always(function () {
                pendingRequests[id] = false
                scheduleRefresh(id, handler, delay)
            })
        }, delay)
    }

    function shouldSkipRefresh(id, $list) {
        if (document.visibilityState !== 'visible')
            return true;

        if (pendingRequests[id])
            return true;

        if ($list.find('input[name*=checked]:checked').length)
            return true;

        var $activePage = $list.find('.page-item.active .page-link')
        if ($activePage.length && $activePage.first().text().trim() !== '1')
            return true;

        return false;
    }
});
