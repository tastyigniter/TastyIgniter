<div class="btn-group dropdown">
    <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
        <i class="fa fa-ellipsis-h"></i> &nbsp;<i class="caret"></i>
    </button>
    <div class="dropdown-menu">
        <a
            class="dropdown-item"
            data-request="onMark"
            data-request-form="#list-form"
            data-request-data="action: 'read'"
        ><?= lang('system::lang.messages.text_mark_as_read'); ?></a>
        <a
            class="dropdown-item"
            data-request="onMark"
            data-request-form="#list-form"
            data-request-data="action: 'unread'"
        ><?= lang('system::lang.messages.text_mark_as_unread'); ?></a>
    </div>
</div>