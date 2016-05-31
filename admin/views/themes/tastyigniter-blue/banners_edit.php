<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab"><?php echo lang('text_tab_general'); ?></a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo $_action; ?>">
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label"><?php echo lang('label_name'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="name" id="input-name" class="form-control" value="<?php echo set_value('name', $name); ?>" />
							<?php echo form_error('name', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-type" class="col-sm-3 control-label"><?php echo lang('label_type'); ?></label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-toggle btn-group-3" data-toggle="buttons">
								<?php if ($type == 'image') { ?>
									<label class="btn btn-default active"><input type="radio" name="type" value="image" <?php echo set_radio('type', 'image', TRUE); ?>><?php echo lang('text_image'); ?></label>
								<?php } else { ?>
									<label class="btn btn-default"><input type="radio" name="type" value="image" <?php echo set_radio('type', 'image'); ?>><?php echo lang('text_image'); ?></label>
								<?php } ?>
								<?php if ($type == 'carousel') { ?>
									<label class="btn btn-default active"><input type="radio" name="type" value="carousel" <?php echo set_radio('type', 'carousel', TRUE); ?>><?php echo lang('text_carousel'); ?></label>
								<?php } else { ?>
									<label class="btn btn-default"><input type="radio" name="type" value="carousel" <?php echo set_radio('type', 'carousel'); ?>><?php echo lang('text_carousel'); ?></label>
								<?php } ?>
								<?php if ($type == 'custom') { ?>
									<label class="btn btn-default active"><input type="radio" name="type" value="custom" <?php echo set_radio('type', 'custom', TRUE); ?>><?php echo lang('text_custom'); ?></label>
								<?php } else { ?>
									<label class="btn btn-default"><input type="radio" name="type" value="custom" <?php echo set_radio('type', 'custom'); ?>><?php echo lang('text_custom'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('type', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div id="image-type" class="type">
						<div class="form-group">
							<label for="" class="col-sm-3 control-label"><?php echo lang('label_image'); ?></label>
							<div class="col-sm-5">
								<div class="thumbnail imagebox" id="selectImage">
									<div class="preview"><img src="<?php echo $image['url']; ?>" class="thumb img-responsive" id="thumb"></div>
									<div class="caption">
										<span class="name text-center"><?php echo $image['name']; ?></span>
										<input type="hidden" name="image_path" value="<?php echo set_value('image_path', $image['path']); ?>" id="field" />
										<p>
											<a id="select-image" class="btn btn-primary" onclick="mediaManager('field');"><i class="fa fa-picture-o"></i>&nbsp;&nbsp;<?php echo lang('text_select'); ?></a>
											<a class="btn btn-danger" onclick="$('#thumb').attr('src', '<?php echo $no_photo; ?>'); $('#field').attr('value', 'data/no_photo.png'); $(this).parent().parent().find('.name').html('no_photo.png');"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;<?php echo lang('text_remove'); ?></a>
										</p>
									</div>
								</div>
								<?php echo form_error('image_path', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
					</div>
					<div id="carousel-type" class="type">
						<div class="form-group">
							<label for="" class="col-sm-3 control-label"><?php echo lang('label_images'); ?></label>
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
													<span class="name text-center"><?php echo $carousel['name']; ?></span>
													<input type="hidden" name="carousels[<?php echo $image_row; ?>]" value="<?php echo $carousel['path']; ?>" id="field<?php echo $image_row; ?>" />
													<p>
														<a id="select-image" class="btn btn-primary" onclick="mediaManager('field<?php echo $image_row; ?>');"><i class="fa fa-picture-o"></i>&nbsp;&nbsp;Select</a>
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
							<label for="input-alt-text" class="col-sm-3 control-label"><?php echo lang('label_alt_text'); ?></label>
							<div class="col-sm-5">
								<input type="text" name="alt_text" id="input-alt-text" class="form-control" value="<?php echo set_value('alt_text', $alt_text); ?>" />
								<?php echo form_error('alt_text', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
					</div>
					<div id="custom-type" class="type">
						<div class="form-group">
							<label for="input-custom-code" class="col-sm-3 control-label"><?php echo lang('label_custom_code'); ?></label>
							<div class="col-sm-5">
								<textarea name="custom_code" id="input-custom-code" class="form-control" rows="7"><?php echo set_value('custom_code', $custom_code); ?></textarea>
								<?php echo form_error('custom_code', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="form-group">
						<label for="input-click-url" class="col-sm-3 control-label"><?php echo lang('label_click_url'); ?>
							<span class="help-block"><?php echo lang('help_click_url') ?></span>
						</label>
						<div class="col-sm-5">
							<input type="text" name="click_url" id="input-click-url" class="form-control" value="<?php echo set_value('click_url', $click_url); ?>" />
							<?php echo form_error('click_url', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label"><?php echo lang('label_language'); ?></label>
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
						<label for="input-status" class="col-sm-3 control-label"><?php echo lang('label_status'); ?></label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if ($status == '1') { ?>
									<label class="btn btn-danger"><input type="radio" name="status" value="0" <?php echo set_radio('status', '0'); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="status" value="1" <?php echo set_radio('status', '1', TRUE); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } else { ?>
									<label class="btn btn-danger active"><input type="radio" name="status" value="0" <?php echo set_radio('status', '0', TRUE); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success"><input type="radio" name="status" value="1" <?php echo set_radio('status', '1'); ?>><?php echo lang('text_enabled'); ?></label>
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
<script type="text/javascript"><!--
var image_row = <?php echo $image_row; ?>;

function addImage() {
	html  = '<li id="image-row' + image_row + '">';
	html += '	<div class="thumbnail imagebox"><div class="preview">';
	html += '		<img src="<?php echo $no_photo; ?>" class="thumb img-responsive" id="thumb' + image_row + '" />';
	html += '	</div>';
	html += '	<div class="caption">';
	html += '		<input type="hidden" name="carousels[' + image_row + ']" value="data/no_photo.png" id="field' + image_row + '" />';
	html += '		<span class="name text-center">no_photo.png</span>';
	html += '		<p>';
	html += '			<a id="select-image" class="btn btn-primary" onclick="mediaManager(\'field' + image_row + '\');"><i class="fa fa-picture-o"></i>&nbsp;&nbsp;<?php echo lang('text_select'); ?></a>';
	html += '			<a class="btn btn-danger" onclick="$(this).parent().parent().parent().remove();"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;<?php echo lang('text_remove'); ?></a>';
	html += '		</p>';
	html += '	</div>';
	html += '</li>';

	$('.thumbnail-list #add-image').before(html);

	image_row++;
}
//--></script>
<?php echo get_footer(); ?>