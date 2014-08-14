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
						<label for="input-code" class="col-sm-2 control-label">Code:
							<span class="help-block">Language url prefix</span>
						</label>
						<div class="col-sm-5">
							<input type="text" name="code" id="input-code" class="form-control" value="<?php echo set_value('code', $code); ?>" />
							<?php echo form_error('code', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-image" class="col-sm-2 control-label">Icon:</label>
						<div class="col-sm-5">
							<div class="thumbnail imagebox imagebox-sm" id="selectImage">
								<div class="preview">
									<img src="<?php echo $image['path']; ?>" class="thumb img-responsive" id="thumb" />
								</div>
								<div class="caption">
									<center class="name"><?php echo $image['name']; ?></center>
									<input type="hidden" name="image" value="<?php echo set_value('image', $image['input']); ?>" id="field" />
									<p>
										<a id="select-image" class="btn btn-select-image" onclick="imageUpload('field');"><i class="fa fa-picture-o"></i></a>
										<a class="btn btn-times" onclick="$('#thumb').attr('src', '<?php echo $no_photo; ?>'); $('#field').attr('value', 'data/no_photo.png'); $(this).parent().parent().find('center').html('no_photo.png');"><i class="fa fa-times-circle"></i></a>
									</p>
								</div>
							</div>
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
	var html  = '<?php echo base_url("assets/img/flags"); ?>/' + value;
	$('#flag').attr('src', html);
});

$('select[name="image"]').trigger('change');
//--></script> 
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