+function ($) {
    "use strict";

    var PermissionEditor = function () {
        this.init()
    }

    PermissionEditor.prototype.constructor = PermissionEditor

    PermissionEditor.prototype.init = function () {
        $(document).on('click', '.permission-editor table .action', $.proxy(this.onPermissionActionClick))
        $(document).on('click', '.permission-editor table .name', $.proxy(this.onPermissionNameClick))
    }

    // EVENT HANDLERS
    // ============================

    PermissionEditor.prototype.onPermissionActionClick = function (event) {
        var action = $(event.currentTarget).data('action'),
            $table = $(event.currentTarget).closest('table'),
            $checkbox = $table.find('input[value*="' + action + '"]');

        $checkbox.prop('checked', !$checkbox[0].checked);
    }

    PermissionEditor.prototype.onPermissionNameClick = function (event) {
        var $row = $(event.target).closest('tr'),
            $checkbox = $row.find(':checkbox');

        $checkbox.prop('checked', !$checkbox[0].checked);
    }

    // INITIALIZATION
    // ============================

    $(document).render(function () {
        new PermissionEditor()
    })

}(window.jQuery);