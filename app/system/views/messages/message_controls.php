<div class="btn-group dropdown">
    <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
        <i class="fa fa-ellipsis-h"></i> &nbsp;<i class="caret"></i>
    </button>
    <ul class="dropdown-menu">
        <li>
            <a
                data-request="onMark"
                data-request-form="#list-form"
                data-request-data="action: 'read'"
            ><?= lang('system::messages.text_mark_as_read'); ?></a></li>
        <li>
            <a
                data-request="onMark"
                data-request-form="#list-form"
                data-request-data="action: 'unread'"
            ><?= lang('system::messages.text_mark_as_unread'); ?></a></li>
    </ul>
</div>