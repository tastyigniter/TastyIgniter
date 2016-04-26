<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
        <div class="row">
            <div class="col-sm-12 col-md-2">
                <a href="<?php echo site_url('messages/compose'); ?>" class="btn btn-primary btn-block"><?php echo lang('button_compose'); ?></a><br />
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?php echo lang('text_folders'); ?></h3>
                    </div>
                    <div class="panel-body wrap-none">
                        <div class="list-group list-group-hover">
                            <?php foreach ($folders as $key => $folder) { ?>
                                <a class="list-group-item <?php echo ($key === $message_folder) ? 'active' : ''; ?>" href="<?php echo $folder['url']; ?>"><i class="fa <?php echo $folder['icon']; ?>"></i>&nbsp;&nbsp;<?php echo $folder['title']; ?>&nbsp;&nbsp;
                                    <span class="label label-primary pull-right"><?php echo $folder['badge']; ?></span></a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-10">
                <div class="panel panel-default panel-table">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?php echo lang('text_view_message'); ?></h3>
                    </div>
                    <div class="panel-body wrap-none wrap-bottom">
                        <div class="message-view-info">
                            <h4><?php echo $subject; ?> &nbsp;&nbsp;
                                <span class="text-muted pull-right">
                                    <span class="fa <?php echo (isset($labels[$send_type]['icon'])) ? $labels[$send_type]['icon'] : ''; ?>" title="<?php echo (isset($labels[$send_type]['title'])) ? $labels[$send_type]['title'] : ''; ?>"></span>&nbsp;|&nbsp;
                                    <span class="fa <?php echo (isset($folders[$message_folder]['icon'])) ? $folders[$message_folder]['icon'] : ''; ?>" title="<?php echo (isset($folders[$message_folder]['title'])) ? $folders[$message_folder]['title'] : ''; ?>"></span>
                                </span>
                            </h4>
                            <h6><?php echo lang('label_from'); ?>: <?php echo $from; ?>
                                <span class="message-view-time pull-right"><?php echo $date_added; ?></span>
                            </h6>
                            <h6><?php echo lang('label_to'); ?>: <a class="recipient"><?php echo $recipient; ?></a></h6>
                        </div>
                        <div class="message-view-controls text-center">
                            <?php if ($message_folder === 'archive') { ?>
                                <button class="btn btn-default btn-sm" title="<?php echo lang('text_move_to_inbox'); ?>" onclick="moveToInbox()">
                                    <i class="fa fa-inbox"></i></button>
                            <?php } else if ($message_folder === 'inbox' OR $message_folder === 'sent') { ?>
                                <button class="btn btn-default btn-sm" title="<?php echo lang('text_move_to_archive'); ?>" onclick="moveToArchive()">
                                    <i class="fa fa-archive"></i></button>
                            <?php } ?>
                            <button class="btn btn-default" title="<?php echo lang('text_move_to_trash'); ?>" onclick="moveToTrash()">
                                <i class="fa fa-trash text-danger"></i></button>
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
                            <input type="hidden" value="<?php echo $message_meta_id; ?>" name="delete[]"/>&nbsp;&nbsp;&nbsp;
                            <div class="message-body"><?php echo $body; ?></div>
                        </form>
                    </div>

                    <div id="recipients" class="wrap-vertical" style="display:none">
                        <h4 class="border-bottom wrap-bottom"><?php echo lang('text_recipient_list'); ?></h4>

                        <div class="table-responsive wrap-none wrap-bottom">
                            <table class="table table-striped table-border table-no-spacing">
                                <?php if ($recipients) { ?>
                                    <thead>
                                    <tr>
                                        <th class="action action-one">
                                            <input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);">
                                        </th>
                                        <?php if ($send_type === 'email') { ?>
                                            <th><?php echo lang('text_email'); ?></th>
                                        <?php } else if ($send_type === 'account') { ?>
                                            <th><?php echo lang('text_recipient'); ?></th>
                                        <?php } ?>
                                        <th class="text-center"><?php echo lang('column_sent'); ?></th>
                                        <?php if ($send_type === 'account') { ?>
                                            <th class="text-center"><?php echo lang('column_read'); ?></th>
                                            <th class="text-center"><?php echo lang('column_deleted'); ?></th>
                                        <?php } ?>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($recipients as $recipient) { ?>
                                        <tr>
                                            <td class="action action-one"><input type="checkbox"
                                                                                 value="<?php echo $recipient['message_meta_id']; ?>"
                                                                                 name="resend[]"/></td>
                                            <?php if ($send_type === 'email') { ?>
                                                <td><?php echo $recipient['recipient_email']; ?></td>
                                            <?php } else if ($send_type === 'account') { ?>
                                                <td><?php echo $recipient['recipient_name']; ?></td>
                                            <?php } ?>
                                            <td class="text-center"><?php echo $recipient['sent']; ?></td>
                                            <?php if ($send_type === 'account') { ?>
                                                <td class="text-center"><?php echo $recipient['read']; ?></td>
                                                <td class="text-center"><?php echo $recipient['deleted']; ?></td>
                                            <?php } ?>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                <?php } else { ?>
                                    <tbody>
                                    <tr>
                                        <td <?php echo ($send_type === 'email') ? 'colspan="2"' : 'colspan="4"'; ?>><?php echo lang('text_no_recipient'); ?></td>
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
            $('#recipients').slideUp();
   			$('.recipient').attr('class', '');
		} else {
            $('#recipients').slideDown();
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
    $('#message-form').append('<input type="hidden" name="message_state" value="restore" />');
	$('#message-form').submit();
}

function moveToArchive() {
    if (confirm('<?php echo lang('alert_warning_confirm'); ?>')) {
		$('#message-form').append('<input type="hidden" name="message_state" value="archive" />');
		$('#message-form').submit();
	} else {
		return false;
	}
}

function moveToTrash() {
    if (confirm('<?php echo lang('alert_warning_confirm_undo'); ?>')) {
        $('#message-form').append('<input type="hidden" name="message_state" value="trash" />');
        $('#message-form').submit();
    } else {
        return false;
    }
}
</script>
<?php echo get_footer(); ?>