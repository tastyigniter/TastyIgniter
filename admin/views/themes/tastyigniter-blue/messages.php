<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
        <div class="row">
            <div class="col-sm-12 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Folders</h3>
                    </div>
                    <div class="panel-body wrap-none">
                        <div class="list-group list-group-hover">
                            <?php foreach ($folders as $key => $folder) { ?>
                                <?php if ($key === $filter_folder) { ?>
                                    <a class="list-group-item active" href="<?php echo $folder['url']; ?>"><i class="fa <?php echo $folder['icon']; ?>"></i>&nbsp;&nbsp;<?php echo ucwords($key); ?>&nbsp;&nbsp;<span class="label label-primary pull-right"><?php echo $folder['badge']; ?></span></a>
                                <?php } else { ?>
                                    <a class="list-group-item" href="<?php echo $folder['url']; ?>"><i class="fa <?php echo $folder['icon']; ?>"></i>&nbsp;&nbsp;<?php echo ucwords($key); ?>&nbsp;&nbsp;<span class="label label-primary pull-right"><?php echo $folder['badge']; ?></span></a>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Labels/Types</h3>
                    </div>
                    <div class="panel-body wrap-none">
                        <div class="list-group list-group-hover">
                            <?php foreach ($labels as $key => $label) { ?>
                                <?php if ($key === $filter_type) { ?>
                                    <a class="list-group-item active" href="<?php echo $label['url']; ?>"><i class="fa <?php echo $label['icon']; ?>"></i>&nbsp;&nbsp;<?php echo ucwords($key); ?></a>
                                <?php } else { ?>
                                    <a class="list-group-item" href="<?php echo $label['url']; ?>"><i class="fa <?php echo $label['icon']; ?>"></i>&nbsp;&nbsp;<?php echo ucwords($key); ?></a>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-9">
                <div class="panel panel-default panel-table">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?php echo ucwords($filter_folder); ?></h3>
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
                                                <input type="text" name="filter_search" class="form-control input-sm" value="<?php echo $filter_search; ?>" placeholder="Search sender or subject." />&nbsp;&nbsp;&nbsp;
                                            </div>
                                            <a class="btn btn-grey" onclick="filterList();" title="Search"><i class="fa fa-search"></i></a>
                                        </div>

                                        <div class="col-md-8 pull-left">
                                            <?php if ($filter_folder === 'all' OR $filter_folder === 'sent') { ?>
                                                <div class="form-group">
                                                    <select name="filter_recipient" class="form-control input-sm">
                                                        <option value="">View all recipients</option>
                                                        <option value="all_newsletters" <?php echo set_select('filter_recipient', 'all_newsletters'); ?> >All Newsletter Subscribers</option>
                                                        <option value="all_customers" <?php echo set_select('filter_recipient', 'all_customers'); ?> >All Customers</option>
                                                        <option value="customer_group" <?php echo set_select('filter_recipient', 'customer_group'); ?> >Customer Group</option>
                                                        <option value="customers" <?php echo set_select('filter_recipient', 'customers'); ?> >Customers</option>
                                                        <option value="all_staffs" <?php echo set_select('filter_recipient', 'all_staffs'); ?> >All Staffs</option>
                                                        <option value="staff_group" <?php echo set_select('filter_recipient', 'staff_group'); ?> >Staff Group</option>
                                                        <option value="staffs" <?php echo set_select('filter_recipient', 'staffs'); ?> >Staffs</option>
                                                    </select>
                                                </div>
                                            <?php } ?>
                                            <div class="form-group">
                                                <select name="filter_date" class="form-control input-sm">
                                                    <option value="">View all dates</option>
                                                    <?php foreach ($message_dates as $key => $value) { ?>
                                                        <?php if ($key === $filter_date) { ?>
                                                            <option value="<?php echo $key; ?>" <?php echo set_select('filter_date', $key, TRUE); ?> ><?php echo $value; ?></option>
                                                        <?php } else { ?>
                                                            <option value="<?php echo $key; ?>" <?php echo set_select('filter_date', $key); ?> ><?php echo $value; ?></option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <a class="btn btn-grey" onclick="filterList();" title="Filter"><i class="fa fa-filter"></i></a>&nbsp;
                                            <a class="btn btn-grey" href="<?php echo page_url(); ?>" title="Clear"><i class="fa fa-times"></i></a>
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
                                <button class="btn btn-default" title="Move to Inbox" onclick="moveToInbox()"><i class="fa fa-inbox"></i></button>
                            <?php } else { ?>
                                <button class="btn btn-default" title="Move to Archive" onclick="moveToArchive()"><i class="fa fa-archive"></i></button>
                            <?php } ?>
                            <button class="btn btn-default" title="Refresh"><i class="fa fa-refresh"></i></button>
                            <div class="btn-group">
                                <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="true"><i class="fa fa-ellipsis-h"></i> &nbsp;<i class="caret"></i></button>
                                <ul class="dropdown-menu">
                                    <?php if ($filter_folder === 'inbox') { ?>
                                        <li><a onclick="markAsRead()">Mark as read</a></li>
                                        <li><a onclick="markAsUnread()">Mark as unread</a></li>
                                    <?php } else { ?>
                                        <li class="disabled"><a>Mark as read</a></li>
                                        <li class="disabled"><a>Mark as unread</a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>

                        <div class="table-responsive wrap-none">
                            <table border="0" class="table table-striped table-border message-list table-no-spacing">
                                <tbody>
                                    <?php if ($messages) {?>
                                        <?php foreach ($messages as $message) { ?>
                                            <tr class="<?php echo $message['state']; ?>">
                                                <td class="action"><input type="checkbox" value="<?php echo $message['message_id']; ?>" name="delete[]" />&nbsp;&nbsp;&nbsp;
                                                    <i class="fa fa-star-o text-warning"></i>
                                                </td>
                                                <td><a href="<?php echo $message['view']; ?>"><?php echo $message['recipient']; ?></a></td>
                                                <td><span class="message-subject"><?php echo $message['subject']; ?></span> - <small><?php echo $message['body']; ?></small></td>
<!--                                                <td>--><?php //echo $message['recipient']; ?><!--</td>-->
                                                <td><i title="<?php echo $message['send_type']; ?>" class="fa fa-<?php echo $message['type_icon']; ?>"></i></td>
                                                <td class="text-center"><?php echo $message['date_added']; ?></td>
                                            </tr>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <tr>
                                            <td colspan="6"><?php echo $text_empty; ?></td>
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
		$('#message-form').append('<input type="hidden" name="message_state" value="inbox" />');
		$('#message-form').submit();
	}
}

function moveToArchive() {
	if (confirm('Are you sure you want to do this?')) {
		$('#message-form').append('<input type="hidden" name="message_state" value="archive" />');
		$('#message-form').submit();
	} else {
		return false;
	}
}
</script>
<?php echo get_footer(); ?>