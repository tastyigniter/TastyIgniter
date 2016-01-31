<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
        <div class="row">
            <div class="col-sm-12 col-md-3 hide">
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

            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3 class="panel-title"><?php echo lang('text_compose_message'); ?></h3></div>
                    <div class="panel-body">
                        <form role="form" id="compose-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
                            <div class="form-group">
                                <label for="input-recipient" class="col-sm-3 control-label"><?php echo lang('label_to'); ?></label>
                                <div class="col-sm-9">
                                    <select name="recipient" id="input-recipient" class="form-control">
                                        <?php foreach ($recipients as $key => $value) { ?>
                                            <?php if ($key === $recipient) { ?>
                                                <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                    <?php echo form_error('recipient', '<span class="text-danger">', '</span>'); ?>
                                </div>
                            </div>
                            <div id="recipient-customer-group" class="recipient">
                                <div class="form-group">
                                    <label for="input-customer-group" class="col-sm-3 control-label"><?php echo lang('label_customer_group'); ?></label>
                                    <div class="col-sm-9">
                                        <select name="customer_group_id" id="input-customer-group" class="form-control">
                                            <?php foreach ($customer_groups as $customer_group) { ?>
                                                <option value="<?php echo $customer_group['customer_group_id']; ?>" <?php echo set_select('customer_group_id', $customer_group['customer_group_id']); ?>><?php echo $customer_group['group_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                        <?php echo form_error('customer_group_id', '<span class="text-danger">', '</span>'); ?>
                                    </div>
                                </div>
                            </div>
                            <div id="recipient-staff-group" class="recipient">
                                <div class="form-group">
                                    <label for="input-staff-group" class="col-sm-3 control-label"><?php echo lang('label_staff_group'); ?></label>
                                    <div class="col-sm-9">
                                        <select name="staff_group_id" id="input-staff-group" class="form-control">
                                            <?php foreach ($staff_groups as $staff_group) { ?>
                                                <option value="<?php echo $staff_group['staff_group_id']; ?>" <?php echo set_select('staff_group_id', $staff_group['staff_group_id']); ?>><?php echo $staff_group['staff_group_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                        <?php echo form_error('staff_group_id', '<span class="text-danger">', '</span>'); ?>
                                    </div>
                                </div>
                            </div>
                            <div id="recipient-customers" class="recipient">
                                <div class="form-group">
                                    <label for="input-customer" class="col-sm-3 control-label"><?php echo lang('label_customers'); ?></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="customer" id="input-customer" class="form-control" value="" placeholder="Start typing customer name..." />
                                        <?php echo form_error('customer', '<span class="text-danger">', '</span>'); ?>
                                    </div>
                                </div>
                                <div id="customers-box" class="form-group">
                                    <label for="" class="col-sm-3 control-label"></label>
                                    <div class="col-sm-9">
                                        <div class="panel-selected">
                                            <table class="table table-striped table-border">
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="recipient-staffs" class="recipient">
                                <div class="form-group">
                                    <label for="input-staff" class="col-sm-3 control-label"><?php echo lang('label_staff'); ?></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="staff" id="input-staff" class="form-control" value="" placeholder="Start typing staff name..." />
                                        <?php echo form_error('staff', '<span class="text-danger">', '</span>'); ?>
                                    </div>
                                </div>
                                <div id="staffs-box" class="form-group">
                                    <label for="" class="col-sm-3 control-label"></label>
                                    <div class="col-sm-9">
                                        <div class="panel-selected">
                                            <table class="table table-striped table-border">
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="send-type" class="">
                                <div class="form-group">
                                    <label for="input-send-type" class="col-sm-3 control-label"><?php echo lang('label_send_type'); ?></label>
                                    <div class="col-sm-9">
                                        <div class="btn-group btn-group-switch" data-toggle="buttons">
                                            <?php if ($send_type === 'account') { ?>
                                                <label class="btn btn-default active"><input type="radio" name="send_type" value="account" checked="checked"><?php echo lang('text_account'); ?></label>
                                                <label class="btn btn-default"><input type="radio" name="send_type" value="email"><?php echo lang('text_email'); ?></label>
                                            <?php } else if ($send_type === 'email') { ?>
                                                <label class="btn btn-default"><input type="radio" name="send_type" value="account"><?php echo lang('text_account'); ?></label>
                                                <label class="btn btn-default active"><input type="radio" name="send_type" value="email" checked="checked"><?php echo lang('text_email'); ?></label>
                                            <?php } else { ?>
                                                <label class="btn btn-default active"><input type="radio" name="send_type" value="account" checked="checked"><?php echo lang('text_account'); ?></label>
                                                <label class="btn btn-default"><input type="radio" name="send_type" value="email"><?php echo lang('text_email'); ?></label>
                                            <?php } ?>
                                        </div>
                                        <?php echo form_error('send_type', '<span class="text-danger">', '</span>'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-subject" class="col-sm-3 control-label"><?php echo lang('label_subject'); ?></label>
                                <div class="col-sm-9">
                                    <input type="text" name="subject" id="input-subject" class="form-control" value="<?php echo set_value('subject', $subject); ?>" size="40" />
                                    <?php echo form_error('subject', '<span class="text-danger">', '</span>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <textarea name="body" id="input-wysiwyg" class="form-control" style="height:300px;width:100%;"><?php echo set_value('body', $body); ?></textarea>
                                    <?php echo form_error('body', '<span class="text-danger">', '</span>'); ?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>
<script type="text/javascript">
    $('#input-wysiwyg').summernote({
        height: 300,
    });
</script>
<script type="text/javascript"><!--

function saveAsDraft() {
    $('#compose-form').append('<input type="hidden" name="save_as_draft" value="1" />');
    $('#compose-form').submit();
}

$('select[name="recipient"]').on('change', function() {
	$('.recipient').hide();

	$('#recipient-' + $(this).val().replace('_', '-')).show();
});

$('select[name=\'recipient\']').trigger('change');
//--></script>
<script type="text/javascript"><!--
$('input[name=\'customer\']').select2({
	minimumInputLength: 2,
	ajax: {
		url: '<?php echo site_url("/customers/autocomplete"); ?>',
		dataType: 'json',
		quietMillis: 100,
		data: function (term, page) {
			return {
				term: term, //search term
				page_limit: 10 // page size
			};
		},
		results: function (data, page, query) {
			return { results: data.results };
		}
	},
	initSelection: function(element, callback) {
		return $.getJSON('<?php echo site_url("/customers/autocomplete?customer_id="); ?>' + (element.val()), null, function(json) {
        	var data = {id: json.results[0].id, text: json.results[0].text};
			return callback(data);
		});
	}
});

$('input[name=\'customer\']').on('select2-selecting', function(e) {
	$('#customer' + e.choice.id).remove();
	$('#customers-box table tbody').append('<tr id="customer' + e.choice.id + '"><td class="name">' + e.choice.text + '<td class="text-right">' + '<a class="btn btn-danger btn-xs" onclick="confirm(\'<?php echo lang('alert_warning_confirm'); ?>\') ? $(this).parent().parent().remove() : false;"><i class="fa fa-times-circle"></i></a>' + '<input type="hidden" name="customers[]" value="' + e.choice.id + '" /></tr>');
});
//--></script>
<script type="text/javascript"><!--
$('input[name=\'staff\']').select2({
	minimumInputLength: 2,
	ajax: {
		url: '<?php echo site_url("/staffs/autocomplete"); ?>',
		dataType: 'json',
		quietMillis: 100,
		data: function (term, page) {
			return {
				term: term, //search term
				page_limit: 10 // page size
			};
		},
		results: function (data, page, query) {
			return { results: data.results };
		}
	},
	initSelection: function(element, callback) {
		return $.getJSON('<?php echo site_url("/staffs/autocomplete?staff_id="); ?>' + (element.val()), null, function(json) {
        	var data = {id: json.results[0].id, text: json.results[0].text};
			return callback(data);
		});
	}
});

$('input[name=\'staff\']').on('select2-selecting', function(e) {
	$('#staff' + e.choice.id).remove();
	$('#staffs-box table tbody').append('<tr id="staff' + e.choice.id + '"><td class="name">' + e.choice.text + '<td class="text-right">' + '<a class="btn btn-danger btn-xs" onclick="confirm(\'<?php echo lang('alert_warning_confirm'); ?>\') ? $(this).parent().parent().remove() : false;"><i class="fa fa-times-circle"></i></a>' + '<input type="hidden" name="staffs[]" value="' + e.choice.id + '" /></tr>');
});
//--></script>
<?php echo get_footer(); ?>