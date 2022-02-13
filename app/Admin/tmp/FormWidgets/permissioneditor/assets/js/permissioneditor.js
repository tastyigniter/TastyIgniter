+function ($) {
    "use strict";

    var PermissionEditor = function () {
        this.init()
    }

    PermissionEditor.prototype.constructor = PermissionEditor

    PermissionEditor.prototype.init = function () {
        $(document).on('click', '[data-toggle="permission"]', $.proxy(this.onPermissionClick))
        $(document).on('click', '[data-toggle="permission-group"]', $.proxy(this.onPermissionGroupClick))
        $(document).on('change', 'input[data-permission-group]', $.proxy(this.onPermissionChanged))
    }

    // EVENT HANDLERS
    // ============================

    PermissionEditor.prototype.onPermissionClick = function (event) {
        var $row = $(event.target).closest('tr'),
            $checkbox = $row.find(':checkbox');

        $checkbox.prop('checked', !$checkbox[0].checked)
        $checkbox.trigger('change')
    }

    PermissionEditor.prototype.onPermissionGroupClick = function (event) {
        var permissionGroup = $(event.currentTarget).data('permissionGroup'),
            $table = $(event.currentTarget).closest('table'),
            $checkbox = $table.find('input[data-permission-group*="' + permissionGroup + '"]')

        $checkbox.prop('checked', !$checkbox[0].checked)
        $checkbox.trigger('change')
    }

    PermissionEditor.prototype.onPermissionChanged = function (event) {
        var $checkbox = $(event.target),
            $row = $checkbox.closest('tr')

        $row.toggleClass('text-muted', !$checkbox.is(':checked'))
    }

    // INITIALIZATION
    // ============================

    $(document).render(function () {
        new PermissionEditor()
    })

}(window.jQuery);