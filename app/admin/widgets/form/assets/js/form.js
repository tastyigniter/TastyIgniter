// Store active form tab into cookie
$(function () {
    var ti_activeFormTabs = Cookies.set('ti_activeFormTabs'),
        activeFormTabs = (typeof ti_activeFormTabs === 'string')
            ? $.parseJSON(ti_activeFormTabs) : {}

    $(document).on('show.bs.tab', '[data-control="form-tabs"] a[data-toggle="tab"]', function (event) {
        var $selectedTab = $(event.target),
            storeName = $selectedTab.closest('[data-control="form-tabs"]').data('storeName'),
            selectedTab = $selectedTab.attr('href')

        if (!storeName || !storeName.length)
            return

        activeFormTabs[storeName] = selectedTab
        Cookies.set('ti_activeFormTabs', JSON.stringify(activeFormTabs))
    })
})
