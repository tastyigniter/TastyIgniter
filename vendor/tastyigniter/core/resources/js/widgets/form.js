// Store active form tab into cookie
$(function () {
    $(document).on('click.bs.dropdown', '[data-control="form-save-actions"] .dropdown-menu', function (event) {
        event.stopPropagation();
    });

    $(document).on('change', '[name="toolbar_save_action"]', function (event) {
        var $el = $(event.currentTarget),
            selectedAction = $el.val()

        $el.request($el.data('handler'), {data: {action: selectedAction}})
        
        $('[data-form-save-action]').attr('name', selectedAction).attr('value', '1')
    })
});
