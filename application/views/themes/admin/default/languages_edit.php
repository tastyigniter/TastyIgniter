<?php echo $header; ?>
<div class="row content">
	<div class="col-md-12">
		<div id="notification">
			<div class="alert alert-dismissable">
				<?php if (!empty($alert)) { ?>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<?php echo $alert; ?>
				<?php } ?>
				<?php if (validation_errors()) { ?>
					<p class="alert-danger">Sorry but validation has failed, please check for errors.</p>
				<?php } ?>
			</div>
		</div>

		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab">Details</a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="post" action="<?php echo $action; ?>">
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-name" class="col-sm-2 control-label">Name:</label>
						<div class="col-sm-5">
							<input type="text" name="name" id="input-name" class="form-control" value="<?php echo set_value('name', $name); ?>" />
							<?php echo form_error('name', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-code" class="col-sm-2 control-label">Language Code:
							<span class="help-block">Language url code</span>
						</label>
						<div class="col-sm-5">
							<input type="text" name="code" id="input-code" class="form-control" value="<?php echo set_value('code', $code); ?>" />
							<?php echo form_error('code', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-image" class="col-sm-2 control-label">Image Icon:
							<span class="help-block">Language image filename</span>
						</label>
						<div class="col-sm-5">
							<select name="image" id="input-image" class="form-control inline-block">
								<?php foreach ($flags as $flag) { ?>
								<?php if ($flag['file'] === $image) { ?>
									<option value="<?php echo $flag['file']; ?>" selected="selected"><?php echo $flag['name']; ?></option>
								<?php } else { ?>
									<option value="<?php echo $flag['file']; ?>"><?php echo $flag['name']; ?></option>
								<?php } ?>
								<?php } ?>
							</select>
							<img id="flag" alt="<?php echo $image; ?>" class="inline-block" src="<?php echo $image_url; ?>" style="margin-bottom: -6px;" />
							<?php echo form_error('image', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-directory" class="col-sm-2 control-label">Directory Name:
							<span class="help-block">Language directory name.</span>
						</label>
						<div class="col-sm-5">
							<input type="text" name="directory" id="input-directory" class="form-control" value="<?php echo set_value('directory', $directory); ?>" />
							<?php echo form_error('directory', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-status" class="col-sm-2 control-label">Status:</label>
						<div class="col-sm-5">
							<select name="status" id="input-status" class="form-control">
								<?php if ($status === '1') { ?>
									<option value="1" selected="selected">Enabled</option>
									<option value="0">Disabled</option>
								<?php } else { ?>
									<option value="1">Enabled</option>
									<option value="0" selected="selected">Disabled</option>
								<?php } ?>
							</select>
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
	var html  = '<?php echo base_url("assets/img/flags"); ?>/' + value;
	$('#flag').attr('src', html);
});

$('select[name="image"]').trigger('change');
//--></script> 
<?php echo $footer; ?>