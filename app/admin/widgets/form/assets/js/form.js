// Store active form tab into cookie
$(function () {
    var ti_activeFormTabs = Cookies.get('ti_activeFormTabs'),
        activeFormTabs = {}

    try {
        activeFormTabs = $.parseJSON(ti_activeFormTabs)
    } catch (err) {
    }

    $(document).on('show.bs.tab', '[data-control="form-tabs"] a[data-toggle="tab"]', function (event) {
        var $selectedTab = $(event.target),
            storeName = $selectedTab.closest('[data-control="form-tabs"]').data('storeName'),
            selectedTab = $selectedTab.attr('href')

        if (storeName && storeName.length) {
            activeFormTabs[storeName] = selectedTab
            Cookies.set('ti_activeFormTabs', JSON.stringify(activeFormTabs))
        }
    })
})
