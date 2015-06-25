<div class="row content">
	<div class="col-md-12">

		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab">General</a></li>
				<li><a href="#slides" data-toggle="tab">Slides</a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-title" class="col-sm-3 control-label">Title:</label>
						<div class="col-sm-5">
							<input type="text" name="title" id="input-title" class="form-control" value="<?php echo set_value('title', $title); ?>" />
							<?php echo form_error('title', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-3 control-label">Dimension:
							<span class="help-block">(W x H)</span>
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
						<label for="input-effect" class="col-sm-3 control-label">Effect</label>
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
						<label for="input-speed" class="col-sm-3 control-label">Transition Speed:
							<span class="help-block">(Slide transition speed)</span>
						</label>
						<div class="col-sm-5">
							<input type="text" name="speed" id="input-speed" class="form-control" value="<?php echo set_value('speed', $speed); ?>" />
							<?php echo form_error('speed', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>

				<div id="slides" class="tab-pane row wrap-all">
					<ul class="thumbnail-list thumbnail-list-horizontal">
						<?php $slide_row = 0; ?>
						<?php foreach ($slides as $slide) { ?>
							<li id="image-row<?php echo $slide_row; ?>">
								<div class="col-md-1">
									<a class="btn btn-danger btn-lg" onclick="$(this).parent().parent().remove();"><i class="fa fa-times-circle"></i></a>
								</div>
								<div class="col-md-4">
									<div class="thumbnail imagebox">
										<div class="preview">
											<img src="<?php echo $slide['preview']; ?>" class="thumb img-responsive" id="thumb<?php echo $slide_row; ?>" /><br />
											<?php echo form_error('slides['.$slide_row.'][image_src]', '<span class="text-danger">', '</span>'); ?>
										</div>
										<div class="caption">
											<span class="name text-center">
												<input type="text" class="form-control" name="slides[<?php echo $slide_row; ?>][name]" value="<?php echo $slide['name']; ?>" /><br />
												<?php echo form_error('slides['.$slide_row.'][name]', '<span class="text-danger">', '</span>'); ?>
											</span>
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
	html += '		<a class="btn btn-danger btn-lg" onclick="$(this).parent().parent().remove();"><i class="fa fa-times-circle"></i></a>';
	html += '	</div>';
	html +=	'	<div class="col-md-4">';
	html += '		<div class="thumbnail imagebox">';
	html +=	'			<div class="preview">';
	html += '				<img src="<?php echo $no_photo; ?>" class="thumb img-responsive" id="thumb' + slide_row + '" />';
	html += '			</div>';
	html += '			<div class="caption">';
	html += '				<input type="hidden" name="slides[' + slide_row + '][image_src]" value="data/no_photo.png" id="field' + slide_row + '" />';
	html += '				<span class="name text-center"><input type="text" class="form-control" name="slides[' + slide_row + '][name]" value="no_photo.png" /></span>';
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