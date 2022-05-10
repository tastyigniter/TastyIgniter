// Store active form tab into cookie
$(function () {
    var ti_activeFormTabs = Cookies.get('ti_activeFormTabs'),
        activeFormTabs = {}

    try {
        activeFormTabs = $.parseJSON(ti_activeFormTabs)
    } catch (err) {
    }

    $(document).on('show.bs.tab', '[data-control="form-tabs"] a[data-bs-toggle="tab"]', function (event) {
        var $selectedTab = $(event.target),
            storeName = $selectedTab.closest('[data-control="form-tabs"]').data('storeName'),
            selectedTab = $selectedTab.attr('href')

        if (storeName && storeName.length) {
            activeFormTabs[storeName] = selectedTab
            Cookies.set('ti_activeFormTabs', JSON.stringify(activeFormTabs))
        }
    })

    $(document).render(function () {
        $('[data-control="inputmask"]').inputmask();
    });

    $(document).on('click.bs.dropdown', '[data-control="form-save-actions"] .dropdown-menu', function (event) {
        event.stopPropagation();
    });

    $(document).on('change', '[name="toolbar_save_action"]', function (event) {
        var $el = $(event.currentTarget),
            $selectedAction = $el.val()

        $('[data-form-save-action]').attr('name', $selectedAction).attr('value', '1')
        Cookies.set('ti_activeFormSaveAction', JSON.stringify($selectedAction))
    })
})
