<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab">Details</a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="post" action="<?php echo $action; ?>">
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label">Name:</label>
						<div class="col-sm-5">
							<input type="text" name="name" id="input-name" class="form-control" value="<?php echo set_value('name', $name); ?>" />
							<?php echo form_error('name', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-code" class="col-sm-3 control-label">Code:
							<span class="help-block">Language url prefix</span>
						</label>
						<div class="col-sm-5">
							<input type="text" name="code" id="input-code" class="form-control" value="<?php echo set_value('code', $code); ?>" />
							<?php echo form_error('code', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-image" class="col-sm-3 control-label">Icon:</label>
						<div class="col-sm-5">
                            <div class="input-group">
                                <span class="input-group-addon lg-addon" title="<?php echo $image['name']; ?>">
                                    <i><img class="thumb img-responsive" id="input-image-thumb" width="24px" src="<?php echo $image['path']; ?>"></i>
                                </span>
                                <input type="text" class="form-control" id="input-image" value="<?php echo set_value('image', $image['input']); ?>" name="image">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" onclick="mediaManager('input-image');" type="button"><i class="fa fa-picture-o"></i></button>
                                    <button class="btn btn-danger" onclick="$('#input-image-thumb').attr('src', '<?php echo $no_photo; ?>'); $('#input-image').attr('value', '');" type="button"><i class="fa fa-times-circle"></i></button>
                                </span>
                            </div>
							<?php echo form_error('image', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-directory" class="col-sm-3 control-label">Directory Name:
							<span class="help-block">Language directory name.</span>
						</label>
						<div class="col-sm-5">
							<input type="text" name="directory" id="input-directory" class="form-control" value="<?php echo set_value('directory', $directory); ?>" />
							<?php echo form_error('directory', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-status" class="col-sm-3 control-label">Status:</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-toggle" data-toggle="buttons">
								<?php if ($status == '1') { ?>
									<label class="btn btn-default" data-btn="btn-danger"><input type="radio" name="status" value="0" <?php echo set_radio('status', '0'); ?>>Disabled</label>
									<label class="btn btn-default active" data-btn="btn-success"><input type="radio" name="status" value="1" <?php echo set_radio('status', '1', TRUE); ?>>Enabled</label>
								<?php } else { ?>
									<label class="btn btn-default active" data-btn="btn-danger"><input type="radio" name="status" value="0" <?php echo set_radio('status', '0', TRUE); ?>>Disabled</label>
									<label class="btn btn-default" data-btn="btn-success"><input type="radio" name="status" value="1" <?php echo set_radio('status', '1'); ?>>Enabled</label>
								<?php } ?>
							</div>
							<?php echo form_error('status', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript"><!--
$('select[name="image"]').on('change', function() {
	var value = $('select[name="image"]').val();
	var html  = '<?php echo root_url("assets/img/flags"); ?>/' + value;
	$('#flag').attr('src', html);
});

$('select[name="image"]').trigger('change');
//--></script>
<?php echo get_footer(); ?>