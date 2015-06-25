<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
        <div class="row">
            <div class="col-sm-12 col-md-3">
                <a href="<?php echo site_url('messages/compose'); ?>" class="btn btn-primary btn-block"><?php echo lang('button_compose'); ?></a><br />
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?php echo lang('text_folders'); ?></h3>
                    </div>
                    <div class="panel-body wrap-none">
                        <div class="list-group list-group-hover">
                            <?php foreach ($folders as $key => $folder) { ?>
                                <a class="list-group-item" href="<?php echo $folder['url']; ?>"><i class="fa <?php echo $folder['icon']; ?>"></i>&nbsp;&nbsp;<?php echo $folder['title']; ?>&nbsp;&nbsp;<span class="label label-primary pull-right"><?php echo $folder['badge']; ?></span></a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-9">
                <div class="panel panel-default panel-table">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?php echo lang('text_view_message'); ?></h3>
                    </div>
                    <div class="panel-body wrap-none wrap-bottom">
                        <div class="message-view-info">
                            <h4><?php echo $subject; ?></h4>
                            <h6>From: <?php echo $from; ?>
                                <span class="message-view-time pull-right"><?php echo $date_added; ?></span>
                            </h6>
                            <h6>To: <a class="recipient"><?php echo $recipient; ?></a>
                                <span class="message-view-time pull-right"><?php echo $send_type; ?></span>
                            </h6>
                        </div>
                        <div class="message-view-controls text-center">
                            <?php if ($message_deleted) { ?>
                                <button class="btn btn-default btn-sm" title="Move to Inbox" onclick="moveToInbox()"><i class="fa fa-inbox"></i></button>
                            <?php } else { ?>
                                <button class="btn btn-default btn-sm" title="Archive" onclick="moveToArchive()"><i class="fa fa-archive"></i></button>
                            <?php } ?>
                            <button class="btn btn-default btn-sm" title="Resend" onclick="resendList()"><i class="fa fa-share"></i></button>
                            <div class="btn-group">
                                <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="true">
                                    <i class="fa fa-ellipsis-h"></i> &nbsp;<i class="caret"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li class="disabled"><a><?php echo lang('text_mark_as_read'); ?></a></li>
                                    <li><a onclick="markAsUnread()"><?php echo lang('text_mark_as_unread'); ?></a></li>
                                </ul>
                            </div>
                        </div>
                        <form role="form" id="message-form" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
                            <div class="message-body"><?php echo $body; ?></div>
                        </form>
                    </div>

                    <div class="panel-heading">
                        <h3 class="panel-title"><?php echo lang('text_recipient_list'); ?></h3>
                    </div>

                    <div class="panel-body">
                        <div id="recipients" class="table-responsive" style="display:none">
                            <table class="table table-striped table-border table-no-spacing">
                                <?php if ($recipients) { ?>
                                    <thead>
                                    <tr>
                                        <th class="action action-one"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
                                        <th><?php echo ($send_type === 'Email') ? lang('text_email') : lang('text_recipient'); ?></th>
                                        <th class="text-center"><?php echo lang('column_status'); ?></th>
                                        <th class="id"><?php echo lang('column_id'); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($recipients as $recipient) { ?>
                                        <tr>
                                            <?php if ($send_type === 'Email') { ?>
                                                <td class="action action-one"><input type="checkbox" value="<?php echo $recipient['message_recipient_id']; ?>" name="delete[]" /></td>
                                                <td><?php echo $recipient['recipient_email']; ?></td>
                                                <td class="text-center"><?php echo $recipient['status']; ?></td>
                                                <td class="id"><?php echo $recipient['message_recipient_id']; ?></td>
                                            <?php } ?>
                                            <?php if ($send_type === 'Account') { ?>
                                                <td class="action action-one"><input type="checkbox" value="<?php echo $recipient['message_recipient_id']; ?>" name="delete[]" /></td>
                                                <td><?php echo $recipient['recipient_name']; ?></td>
                                                <td class="text-center"><?php echo $recipient['status']; ?></td>
                                                <td class="id"><?php echo $recipient['message_recipient_id']; ?></td>
                                            <?php } ?>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                <?php } else { ?>
                                    <tbody>
                                    <tr>
                                        <td><?php echo lang('text_no_recipient'); ?></td>
                                    </tr>
                                    </tbody>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
  	$('.recipient').on('click', function() {
  		if ($('#recipients').is(':visible')) {
     		$('#recipients').fadeOut();
   			$('.recipient').attr('class', '');
		} else {
   			$('#recipients').fadeIn();
   			$('.recipient').attr('class', 'active');
		}
	});
});
</script>
<script type="text/javascript">
function markAsUnread() {
	$('#message-form').append('<input type="hidden" name="message_state" value="unread" />');
	$('#message-form').submit();
}

function moveToInbox() {
	$('#message-form').append('<input type="hidden" name="message_state" value="inbox" />');
	$('#message-form').submit();
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