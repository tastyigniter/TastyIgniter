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
						<label for="input-name" class="col-sm-2 control-label">Country:</label>
						<div class="col-sm-5">
							<input type="text" name="country_name" id="input-name" class="form-control" value="<?php echo set_value('country_name', $country_name); ?>" />
							<?php echo form_error('country_name', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-iso-code-2" class="col-sm-2 control-label">ISO Code 2:</label>
						<div class="col-sm-5">
							<input type="text" name="iso_code_2" id="input-iso-code-2" class="form-control" value="<?php echo set_value('iso_code_2', $iso_code_2); ?>" size="5" />
							<?php echo form_error('iso_code_2', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-iso-code-3" class="col-sm-2 control-label">ISO Code 3:</label>
						<div class="col-sm-5">
							<input type="text" name="iso_code_3" id="input-iso-code-3" class="form-control" value="<?php echo set_value('iso_code_3', $iso_code_3); ?>" size="5" />
							<?php echo form_error('iso_code_3', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-name" class="col-sm-2 control-label">Flag:</label>
						<div class="col-sm-5">
							<div class="thumbnail imagebox imagebox-sm" id="selectImage">
								<div class="preview">
									<img src="<?php echo $flag['path']; ?>" class="thumb img-responsive" id="thumb" />
								</div>
								<div class="caption">
									<center class="name"><?php echo $flag['name']; ?></center>
									<input type="hidden" name="flag" value="<?php echo set_value('flag', $flag['input']); ?>" id="field" />
									<p>
										<a id="select-image" class="btn btn-select-image" onclick="imageUpload('field');"><i class="fa fa-picture-o"></i></a>
										<a class="btn btn-times" onclick="$('#thumb').attr('src', '<?php echo $no_photo; ?>'); $('#field').attr('value', 'data/no_photo.png'); $(this).parent().parent().find('center').html('no_photo.png');"><i class="fa fa-times-circle"></i></a>
									</p>
								</div>
							</div>
							<?php echo form_error('flag', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-format" class="col-sm-2 control-label">Format:
							<span class="help-block">Address 1 = {address_1}<br />Address 2 = {address_2}<br />City = {city}<br />Postcode = {postcode}<br />State = {state}<br />Country = {country}</span>
						</label>
						<div class="col-sm-5">
							<textarea name="format" id="input-format" class="form-control" rows="7"><?php echo set_value('format', $format); ?></textarea>
							<?php echo form_error('format', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-status" class="col-sm-2 control-label">Status:</label>
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
<link type="text/css" rel="stylesheet" href="<?php echo base_url("assets/js/fancybox/jquery.fancybox.css"); ?>">
<script src="<?php echo base_url("assets/js/fancybox/jquery.fancybox.js"); ?>"></script>
<script type="text/javascript"><!--
function imageUpload(field) {
	$('#image-manager').remove();
		
	var iframe_url = js_site_url('admin/image_manager?popup=iframe&field_id=') + encodeURIComponent(field);

	$('body').append('<div id="image-manager" style="padding: 3px 0px 0px 0px;"><iframe src="'+ iframe_url +'" width="980" height="550" frameborder="0"></iframe></div>');
	
	$.fancybox({	
 		href:"#image-manager",
		autoScale: false,
		afterClose: function() {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: js_site_url('admin/image_manager/resize?image=') + encodeURIComponent($('#' + field).attr('value')),
					dataType: 'json',
					success: function(json) {
						var thumb = $('#' + field).parent().parent().find('.thumb');
						$(thumb).replaceWith('<img src="' + json + '" alt="" class="thumb" id="thumb" />');
					}
				});
			}
		}
	});
};
//--></script>
<?php echo $footer; ?>