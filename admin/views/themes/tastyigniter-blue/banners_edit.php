<?php echo $header; ?>
<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab">Banner Details</a></li>
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
						<label for="input-type" class="col-sm-2 control-label">Type:</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-toggle btn-group-3" data-toggle="buttons">
								<?php if ($type == 'image') { ?>
									<label class="btn btn-default active" data-btn="btn-info"><input type="radio" name="type" value="image" <?php echo set_radio('type', 'image', TRUE); ?>>Image</label>
								<?php } else { ?>
									<label class="btn btn-default" data-btn="btn-info"><input type="radio" name="type" value="image" <?php echo set_radio('type', 'image'); ?>>Image</label>
								<?php } ?>
								<?php if ($type == 'carousel') { ?>
									<label class="btn btn-default active" data-btn="btn-primary"><input type="radio" name="type" value="carousel" <?php echo set_radio('type', 'carousel', TRUE); ?>>Carousel</label>
								<?php } else { ?>
									<label class="btn btn-default" data-btn="btn-primary"><input type="radio" name="type" value="carousel" <?php echo set_radio('type', 'carousel'); ?>>Carousel</label>
								<?php } ?>
								<?php if ($type == 'custom') { ?>
									<label class="btn btn-default active" data-btn="btn-warning"><input type="radio" name="type" value="custom" <?php echo set_radio('type', 'custom', TRUE); ?>>Custom</label>
								<?php } else { ?>
									<label class="btn btn-default" data-btn="btn-warning"><input type="radio" name="type" value="custom" <?php echo set_radio('type', 'custom'); ?>>Custom</label>
								<?php } ?>
							</div>
							<?php echo form_error('type', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div id="image-type" class="type">
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Image:</label>
							<div class="col-sm-5">
								<div class="thumbnail imagebox" id="selectImage">
									<div class="preview"><img src="<?php echo $image['url']; ?>" class="thumb img-responsive" id="thumb"></div>
									<div class="caption">
										<center class="name"><?php echo $image['name']; ?></center>
										<input type="hidden" name="image_path" value="<?php echo set_value('image_path', $image['path']); ?>" id="field" />
										<p>
											<a id="select-image" class="btn btn-primary" onclick="imageUpload('field');"><i class="fa fa-picture-o"></i>&nbsp;&nbsp;Select</a>
											<a class="btn btn-danger" onclick="$('#thumb').attr('src', '<?php echo $no_photo; ?>'); $('#field').attr('value', 'data/no_photo.png'); $(this).parent().parent().find('center').html('no_photo.png');"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Remove</a>
										</p>
									</div>
								</div>
								<?php echo form_error('image_path', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
					</div>
					<div id="carousel-type" class="type">
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Images:</label>
							<div class="col-sm-7">
								<ul class="thumbnail-list">
								<?php $image_row = 0; ?>
								<?php if ($carousels) { ?>
									<?php foreach ($carousels as $carousel) { ?>
										<li id="image-row<?php echo $image_row; ?>">
											<div class="thumbnail imagebox">
												<div class="preview">
													<img src="<?php echo $carousel['url']; ?>" class="thumb img-responsive" id="thumb<?php echo $image_row; ?>" />
												</div>
												<div class="caption">
													<center class="name"><?php echo $carousel['name']; ?></center>
													<input type="hidden" name="carousels[<?php echo $image_row; ?>]" value="<?php echo $carousel['path']; ?>" id="field<?php echo $image_row; ?>" />
													<p>
														<a id="select-image" class="btn btn-primary" onclick="imageUpload('field<?php echo $image_row; ?>');"><i class="fa fa-picture-o"></i>&nbsp;&nbsp;Select</a>
														<a class="btn btn-danger" onclick="$(this).parent().parent().parent().remove();"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Remove</a>
													</p>
												</div>
											</div>
											<?php echo form_error('carousels['.$image_row.']', '<span class="text-danger">', '</span>'); ?>
										</li>
									<?php $image_row++; ?>
									<?php } ?>
								<?php } ?>
									<li id="add-image">
										<div class="thumbnail">
											<a class="btn btn-primary" onclick="addImage();"><i class="fa fa-plus"></i>&nbsp;<i class="fa fa-picture-o"></i></a>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div id="image-type-extra" class="type">
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Dimension:
								<span class="help-block">(Height x Width)</span>
							</label>
							<div class="col-sm-5">
								<div class="control-group control-group-2">
									<input type="text" name="image_height" class="form-control" value="<?php echo $image_height; ?>" />
									<input type="text" name="image_width" class="form-control" value="<?php echo $image_width; ?>" />
								</div>
								<?php echo form_error('image_height', '<span class="text-danger">', '</span>'); ?>
								<?php echo form_error('image_width', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						<div class="form-group">
							<label for="input-alt-text" class="col-sm-2 control-label">Alternative Text:</label>
							<div class="col-sm-5">
								<input type="text" name="alt_text" id="input-alt-text" class="form-control" value="<?php echo set_value('alt_text', $alt_text); ?>" />
								<?php echo form_error('alt_text', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
					</div>
					<div id="custom-type" class="type">
						<div class="form-group">
							<label for="input-custom-code" class="col-sm-2 control-label">Custom Code:</label>
							<div class="col-sm-5">
								<textarea name="custom_code" id="input-custom-code" class="form-control" rows="7"><?php echo set_value('custom_code', $custom_code); ?></textarea>
								<?php echo form_error('custom_code', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="form-group">
						<label for="input-click-url" class="col-sm-2 control-label">Click URL:</label>
						<div class="col-sm-5">
							<input type="text" name="click_url" id="input-click-url" class="form-control" value="<?php echo set_value('click_url', $click_url); ?>" />
							<?php echo form_error('click_url', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-name" class="col-sm-2 control-label">Language:</label>
						<div class="col-sm-5">
							<select name="language_id" id="input-language" class="form-control">
								<?php foreach ($languages as $language) { ?>
								<?php if ($language['language_id'] === $language_id) { ?>
									<option value="<?php echo $language['language_id']; ?>" selected="selected"><?php echo $language['name']; ?></option>
								<?php } else { ?>
									<option value="<?php echo $language['language_id']; ?>"><?php echo $language['name']; ?></option>
								<?php } ?>
								<?php } ?>
							</select>
							<?php echo form_error('language_id', '<span class="text-danger">', '</span>'); ?>
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
$('input[name="type"]').on('change', function() {
	$('.type').hide();
	$('#' + $(this).val() + '-type').show();

	if ($(this).val() == 'image' || $(this).val() == 'carousel') {
		$('#image-type-extra').show();
	}
});

$('input[name=\'type\']').trigger('change');
//--></script>
<link type="text/css" rel="stylesheet" href="<?php echo root_url("assets/js/fancybox/jquery.fancybox.css"); ?>">
<script src="<?php echo root_url("assets/js/fancybox/jquery.fancybox.js"); ?>"></script>
<script type="text/javascript"><!--
function imageUpload(field) {
	$('#image-manager').remove();

	var iframe_url = js_site_url('image_manager?popup=iframe&field_id=') + encodeURIComponent(field);

	$('body').append('<div id="image-manager" style="padding: 3px 0px 0px 0px;"><iframe src="'+ iframe_url +'" width="980" height="550" frameborder="0"></iframe></div>');

	$.fancybox({
 		href:"#image-manager",
		autoScale: false,
		afterClose: function() {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: js_site_url('image_manager/resize?image=') + encodeURIComponent($('#' + field).attr('value')) + '&width=120&height=120',
					dataType: 'json',
					success: function(json) {
						var thumb = $('#' + field).parent().parent().find('.thumb');
						$(thumb).replaceWith('<img src="' + json + '" alt="" class="thumb img-responsive" />');
					}
				});
			}
		}
	});
};
//--></script>
<script type="text/javascript"><!--
var image_row = <?php echo $image_row; ?>;

function addImage() {
	html  = '<li id="image-row' + image_row + '">';
	html += '	<div class="thumbnail imagebox"><div class="preview">';
	html += '		<img src="<?php echo $no_photo; ?>" class="thumb img-responsive" id="thumb' + image_row + '" />';
	html += '	</div>';
	html += '	<div class="caption">';
	html += '		<input type="hidden" name="carousels[' + image_row + ']" value="data/no_photo.png" id="field' + image_row + '" />';
	html += '		<center class="name">no_photo.png</center>';
	html += '		<p>';
	html += '			<a id="select-image" class="btn btn-primary" onclick="imageUpload(\'field' + image_row + '\');"><i class="fa fa-picture-o"></i>&nbsp;&nbsp;Select</a>';
	html += '			<a class="btn btn-danger" onclick="$(this).parent().parent().parent().remove();"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Remove</a>';
	html += '		</p>';
	html += '	</div>';
	html += '</li>';

	$('.thumbnail-list #add-image').before(html);

	image_row++;
}
//--></script>
<?php echo $footer; ?>