<div class="row content">
	<div class="col-md-12">

		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab"><?php echo lang('text_tab_general'); ?></a></li>
				<li><a href="#slides" data-toggle="tab"><?php echo lang('text_tab_slides'); ?></a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="" class="col-sm-3 control-label"><?php echo lang('label_dimension'); ?>
							<span class="help-block"><?php echo lang('help_dimension'); ?></span>
						</label>
						<div class="col-sm-5">
							<div class="control-group control-group-2">
								<input type="text" name="dimension_w" class="form-control" value="<?php echo $dimension_w; ?>" />
                                <input type="text" name="dimension_h" class="form-control" value="<?php echo $dimension_h; ?>" />
                            </div>
							<?php echo form_error('dimension_w', '<span class="text-danger">', '</span>'); ?>
                            <?php echo form_error('dimension_h', '<span class="text-danger">', '</span>'); ?>
                        </div>
					</div>
					<div class="form-group">
						<label for="input-effect" class="col-sm-3 control-label"><?php echo lang('label_effect'); ?></label>
						<div class="col-sm-5">
							<select name="effect" id="input-effect" class="form-control">
								<?php foreach ($effects as $key => $value) { ?>
								<?php if ($value === $effect) { ?>
									<option value="<?php echo $value; ?>" selected="selected"><?php echo $value; ?></option>
								<?php } else { ?>
									<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
								<?php } ?>
								<?php } ?>
							</select>
							<?php echo form_error('effect', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-speed" class="col-sm-3 control-label"><?php echo lang('label_speed'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="speed" id="input-speed" class="form-control" value="<?php echo set_value('speed', $speed); ?>" />
							<?php echo form_error('speed', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-display" class="col-sm-3 control-label"><?php echo lang('label_display'); ?></label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if ($display == '1') { ?>
									<label class="btn btn-default"><input type="radio" name="display" value="0" <?php echo set_radio('display', '0'); ?>><?php echo lang('text_hide'); ?></label>
									<label class="btn btn-default active"><input type="radio" name="display" value="1" <?php echo set_radio('display', '1', TRUE); ?>><?php echo lang('text_show'); ?></label>
								<?php } else { ?>
									<label class="btn btn-default active"><input type="radio" name="display" value="0" <?php echo set_radio('display', '0', TRUE); ?>><?php echo lang('text_hide'); ?></label>
									<label class="btn btn-default"><input type="radio" name="display" value="1" <?php echo set_radio('display', '1'); ?>><?php echo lang('text_show'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('display', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>

				<div id="slides" class="tab-pane row wrap-all">
					<ul class="thumbnail-list thumbnail-list-horizontal">
						<?php $slide_row = 0; ?>
						<?php foreach ($slides as $slide) { ?>
							<li id="image-row<?php echo $slide_row; ?>">
								<div class="col-md-1">
									<a class="btn btn-danger btn-lg" onclick="confirm('<?php echo lang('alert_warning_confirm'); ?>') ? $(this).parent().parent().remove() : false;"><i class="fa fa-times-circle"></i></a>
								</div>
								<div class="col-md-4">
									<div class="thumbnail imagebox">
										<div class="preview">
											<img src="<?php echo $slide['preview']; ?>" class="thumb img-responsive" id="thumb<?php echo $slide_row; ?>" /><br />
											<?php echo form_error('slides['.$slide_row.'][image_src]', '<span class="text-danger">', '</span>'); ?>
										</div>
										<div class="caption">
											<input type="hidden" name="slides[<?php echo $slide_row; ?>][image_src]" value="<?php echo $slide['image_src']; ?>" id="field<?php echo $slide_row; ?>" />
											<p>
												<a id="select-image" class="btn btn-primary" onclick="mediaManager('field<?php echo $slide_row; ?>');"><i class="fa fa-picture-o"></i></a>&nbsp;&nbsp;&nbsp;
											</p>
										</div>
									</div>
									</div>
								<div class="col-md-6">
									<textarea class="form-control" name="slides[<?php echo $slide_row; ?>][caption]" rows="8" cols="4"><?php echo $slide['caption']; ?></textarea><br />
									<?php echo form_error('slides['.$slide_row.'][caption]', '<span class="text-danger">', '</span>'); ?>
								</div>
							</li>
							<?php $slide_row++; ?>
						<?php } ?>
						<li id="add-image">
							<div class="thumbnail">
								<a class="btn btn-add-image" onclick="addSlide();"><i class="fa fa-plus"></i>&nbsp;<i class="fa fa-picture-o"></i></a>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript"><!--
var slide_row = <?php echo $slide_row; ?>;

function addSlide() {
	html  = '<li id="image-row' + slide_row + '">';
	html += '	<div class="col-md-1">';
	html += '		<a class="btn btn-danger btn-lg" onclick="confirm(\'<?php echo lang('alert_warning_confirm'); ?>\') ? $(this).parent().parent().remove() : false;"><i class="fa fa-times-circle"></i></a>';
	html += '	</div>';
	html +=	'	<div class="col-md-4">';
	html += '		<div class="thumbnail imagebox">';
	html +=	'			<div class="preview">';
	html += '				<img src="<?php echo $no_photo; ?>" class="thumb img-responsive" id="thumb' + slide_row + '" />';
	html += '			</div>';
	html += '			<div class="caption">';
	html += '				<input type="hidden" name="slides[' + slide_row + '][image_src]" value="data/no_photo.png" id="field' + slide_row + '" />';
	html += '				<p>';
	html += '					<a id="select-image" class="btn btn-primary" onclick="mediaManager(\'field' + slide_row + '\');"><i class="fa fa-picture-o"></i></a>&nbsp;&nbsp;&nbsp;';
	html += '				</p>';
	html += '			</div>';
	html += '		</div>';
	html += '	</div>';
	html += '	<div class="col-md-6">';
	html += '		<textarea class="form-control" name="slides[' + slide_row + '][caption]" rows="11" cols="4"></textarea>';
	html += '	</div>';
	html += '</li>';

	$('.thumbnail-list #add-image').before(html);

	slide_row++;
}
//--></script>