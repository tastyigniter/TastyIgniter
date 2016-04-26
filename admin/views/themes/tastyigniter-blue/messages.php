<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
        <div class="row">
            <div class="col-xs-12 col-md-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?php echo lang('text_folders'); ?></h3>
                    </div>
                    <div class="panel-body wrap-none">
                        <div class="list-group list-group-hover">
                            <?php foreach ($folders as $key => $folder) { ?>
                                <?php if ($key === $filter_folder) { ?>
                                    <a class="list-group-item active" href="<?php echo $folder['url']; ?>"><i class="fa <?php echo $folder['icon']; ?>"></i>&nbsp;&nbsp;<?php echo $folder['title']; ?>&nbsp;&nbsp;<span class="label label-primary pull-right"><?php echo $folder['badge']; ?></span></a>
                                <?php } else { ?>
                                    <a class="list-group-item" href="<?php echo $folder['url']; ?>"><i class="fa <?php echo $folder['icon']; ?>"></i>&nbsp;&nbsp;<?php echo $folder['title']; ?>&nbsp;&nbsp;<span class="label label-primary pull-right"><?php echo $folder['badge']; ?></span></a>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?php echo lang('text_labels'); ?></h3>
                    </div>
                    <div class="panel-body wrap-none">
                        <div class="list-group list-group-hover">
                            <?php foreach ($labels as $key => $label) { ?>
                                <?php if ($key === $filter_type) { ?>
                                    <a class="list-group-item active" href="<?php echo $label['url']; ?>"><i class="fa <?php echo $label['icon']; ?>"></i>&nbsp;&nbsp;<?php echo $label['title']; ?></a>
                                <?php } else { ?>
                                    <a class="list-group-item" href="<?php echo $label['url']; ?>"><i class="fa <?php echo $label['icon']; ?>"></i>&nbsp;&nbsp;<?php echo $label['title']; ?></a>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-md-10">
                <div class="panel panel-default panel-table">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?php echo (isset($folders[$filter_folder]['title'])) ? $folders[$filter_folder]['title'] : ucwords($filter_folder); ?></h3>
                        <div class="pull-right">
                            <button class="btn btn-filter btn-xs"><i class="fa fa-filter"></i></button>
                        </div>
                    </div>
                    <div class="panel-body panel-filter">
                        <form role="form" id="filter-form" accept-charset="utf-8" method="GET" action="<?php echo current_url(); ?>">
                            <div class="filter-bar">
                                <div class="form-inline">
                                    <div class="row">
                                        <div class="col-md-4 pull-right text-right">
                                            <div class="form-group">
                                                <input type="text" name="filter_search" class="form-control input-sm" value="<?php echo $filter_search; ?>" placeholder="<?php echo lang('text_filter_search'); ?>" />&nbsp;&nbsp;&nbsp;
                                            </div>
                                            <a class="btn btn-grey" onclick="filterList();" title="<?php echo lang('text_search'); ?>"><i class="fa fa-search"></i></a>
                                        </div>

                                        <div class="col-md-8 pull-left">
                                            <?php if ($filter_folder === 'all' OR $filter_folder === 'sent') { ?>
                                                <div class="form-group">
                                                    <select name="filter_recipient" class="form-control input-sm">
                                                        <option value=""><?php echo lang('text_filter_recipient'); ?></option>
                                                        <option value="all_newsletters" <?php echo set_select('filter_recipient', 'all_newsletters'); ?> ><?php echo lang('text_all_newsletters'); ?></option>
                                                        <option value="all_customers" <?php echo set_select('filter_recipient', 'all_customers'); ?> ><?php echo lang('text_all_customers'); ?></option>
                                                        <option value="customer_group" <?php echo set_select('filter_recipient', 'customer_group'); ?> ><?php echo lang('text_customer_group'); ?></option>
                                                        <option value="customers" <?php echo set_select('filter_recipient', 'customers'); ?> ><?php echo lang('text_customers'); ?></option>
                                                        <option value="all_staffs" <?php echo set_select('filter_recipient', 'all_staffs'); ?> ><?php echo lang('text_all_staff'); ?></option>
                                                        <option value="staff_group" <?php echo set_select('filter_recipient', 'staff_group'); ?> ><?php echo lang('text_staff_group'); ?></option>
                                                        <option value="staffs" <?php echo set_select('filter_recipient', 'staffs'); ?> ><?php echo lang('text_staff'); ?></option>
                                                    </select>
                                                </div>
                                            <?php } ?>
                                            <div class="form-group">
                                                <select name="filter_date" class="form-control input-sm">
                                                    <option value=""><?php echo lang('text_filter_date'); ?></option>
                                                    <?php foreach ($message_dates as $key => $value) { ?>
                                                        <?php if ($key === $filter_date) { ?>
                                                            <option value="<?php echo $key; ?>" <?php echo set_select('filter_date', $key, TRUE); ?> ><?php echo $value; ?></option>
                                                        <?php } else { ?>
                                                            <option value="<?php echo $key; ?>" <?php echo set_select('filter_date', $key); ?> ><?php echo $value; ?></option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <a class="btn btn-grey" onclick="filterList();" title="<?php echo lang('text_filter'); ?>"><i class="fa fa-filter"></i></a>&nbsp;
                                            <a class="btn btn-grey" href="<?php echo page_url(); ?>" title="<?php echo lang('text_clear'); ?>"><i class="fa fa-times"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <form role="form" id="message-form" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
                        <div class="message-controls">
                            <input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);">&nbsp;&nbsp;
                            <?php if ($filter_folder === 'archive') { ?>
                                <button class="btn btn-default" title="<?php echo lang('text_move_to_inbox'); ?>" onclick="moveToInbox()"><i class="fa fa-inbox"></i>&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-left"></i></button>
                            <?php } else if ($filter_folder === 'inbox' OR $filter_folder === 'sent') { ?>
                                <button class="btn btn-default" title="<?php echo lang('text_move_to_archive'); ?>" onclick="moveToArchive()"><i class="fa fa-archive"></i></button>
                            <?php } ?>

                            <button class="btn btn-default" title="<?php echo lang('text_move_to_trash'); ?>" onclick="moveToTrash()"><i class="fa fa-trash text-danger"></i></button>
                            <button class="btn btn-default" title="<?php echo lang('text_refresh'); ?>"><i class="fa fa-refresh"></i></button>

                            <div class="btn-group">
                                <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="true"><i class="fa fa-ellipsis-h"></i> &nbsp;<i class="caret"></i></button>
                                <ul class="dropdown-menu">
                                    <?php if ($filter_folder === 'inbox') { ?>
                                        <li><a onclick="markAsRead()"><?php echo lang('text_mark_as_read'); ?></a></li>
                                        <li><a onclick="markAsUnread()"><?php echo lang('text_mark_as_unread'); ?></a></li>
                                    <?php } else { ?>
                                        <li class="disabled"><a><?php echo lang('text_mark_as_read'); ?></a></li>
                                        <li class="disabled"><a><?php echo lang('text_mark_as_unread'); ?></a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>

                        <div class="table-responsive wrap-none">
                            <table border="0" class="table table-border message-list table-no-spacing">
                                <tbody>
                                    <?php if ($messages) {?>
                                        <?php foreach ($messages as $message) { ?>
                                            <tr class="<?php echo $message['state']; ?>">
                                                <td class="action">
                                                    <input type="checkbox" value="<?php echo ($filter_folder === 'draft') ? $message['message_id'] : $message['message_meta_id']; ?>" name="delete[]" />&nbsp;&nbsp;&nbsp;
                                                    <i class="fa fa-star-o text-warning"></i>
                                                </td>
                                                <td><?php echo $message['recipient']; ?></a></td>
                                                <td width="65%">
                                                    <?php if ($filter_folder === 'all') foreach ($folders as $key => $folder) { ?>
                                                        <?php if ($key === $message['folder']) { ?>
                                                            <i class="fa <?php echo $folder['icon']; ?> text-muted"></i>&nbsp;&nbsp;&nbsp;
                                                        <?php } ?>
                                                    <?php } ?>
                                                    <a class="message-subject" href="<?php echo $message['view']; ?>"><?php echo $message['subject']; ?></a>&nbsp;-&nbsp;
                                                    <small><?php echo $message['body']; ?></small>
                                                </td>
                                                <td class="text-center text-muted"><i title="<?php echo $message['send_type']; ?>" class="fa <?php echo $message['send_type_class']; ?>"></i></td>
                                                <td class="text-center"><?php echo $message['date_added']; ?></td>
                                            </tr>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <tr>
                                            <td colspan="5"><?php echo lang('text_empty'); ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </form>

                    <div class="pagination-bar clearfix">
                        <div class="links"><?php echo $pagination['links']; ?></div>
                        <div class="info"><?php echo $pagination['info']; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript"><!--
function filterList() {
	$('#filter-form').submit();
}
//--></script>
<script type="text/javascript">
function markAsRead() {
	if ($('#message-form input:checkbox:checked').length > 0) {
		$('#message-form').append('<input type="hidden" name="message_state" value="read" />');
		$('#message-form').submit();
	}
}

function markAsUnread() {
	if ($('#message-form input:checkbox:checked').length > 0) {
		$('#message-form').append('<input type="hidden" name="message_state" value="unread" />');
		$('#message-form').submit();
	}
}

function moveToInbox() {
	if ($('#message-form input:checkbox:checked').length > 0) {
		$('#message-form').append('<input type="hidden" name="message_state" value="restore" />');
		$('#message-form').submit();
	}
}

function moveToArchive() {
	if ($('#message-form input:checkbox:checked').length > 0 && confirm('<?php echo lang('alert_warning_confirm'); ?>')) {
		$('#message-form').append('<input type="hidden" name="message_state" value="archive" />');
		$('#message-form').submit();
	} else {
		return false;
	}
}

function moveToTrash() {
	if ($('#message-form input:checkbox:checked').length > 0 && confirm('<?php echo lang('alert_warning_confirm_undo'); ?>')) {
		$('#message-form').append('<input type="hidden" name="message_state" value="trash" />');
		$('#message-form').submit();
	} else {
		return false;
	}
}
</script>
<?php echo get_footer(); ?>