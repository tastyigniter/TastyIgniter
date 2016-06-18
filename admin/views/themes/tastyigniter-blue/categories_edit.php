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
							<input type="text" name="name" id="input-name" class="form-control" value="<?php echo set_value('name', $name); ?>"/>
							<?php echo form_error('name', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-slug" class="col-sm-3 control-label"><?php echo lang('label_permalink_slug'); ?>
							<span class="help-block"><?php echo lang('help_permalink'); ?></span>
						</label>
						<div class="col-sm-5">
							<input type="hidden" name="permalink[permalink_id]" value="<?php echo set_value('permalink[permalink_id]', $permalink['permalink_id']); ?>"/>
							<input type="text" name="permalink[slug]" id="input-slug" class="form-control" value="<?php echo set_value('permalink[slug]', $permalink['slug']); ?>"/>
							<?php echo form_error('permalink[permalink_id]', '<span class="text-danger">', '</span>'); ?>
                            <?php echo form_error('permalink[slug]', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label"><?php echo lang('label_parent'); ?></label>
						<div class="col-sm-5">
							<select name="parent_id" id="category" class="form-control">
								<option value=""><?php echo lang('text_none'); ?></option>
							<?php foreach ($categories as $category) { ?>
							<?php if ($category['category_id'] === $parent_id) { ?>
								<option value="<?php echo $category['category_id']; ?>" <?php echo set_select('parent', $category['category_id'], TRUE); ?> ><?php echo $category['category_name']; ?></option>
							<?php } else { ?>
								<option value="<?php echo $category['category_id']; ?>" <?php echo set_select('parent', $category['category_id']); ?> ><?php echo $category['category_name']; ?></option>
							<?php } ?>
							<?php } ?>
							</select>
							<?php echo form_error('parent', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-description" class="col-sm-3 control-label"><?php echo lang('label_description'); ?></label>
						<div class="col-sm-5">
							<textarea name="description" id="input-description" class="form-control" rows="7"><?php echo set_value('description', $description); ?></textarea>
							<?php echo form_error('description', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-3 control-label"><?php echo lang('label_image'); ?>
							<span class="help-block"><?php echo lang('help_photo'); ?></span>
						</label>
						<div class="col-sm-5">
							<div class="thumbnail imagebox imagebox-sm" id="selectImage">
								<div class="preview">
									<img src="<?php echo $image_url; ?>" class="thumb img-responsive" id="thumb">
								</div>
								<div class="caption">
									<span class="name text-center"><?php echo $image_name; ?></span>
									<input type="hidden" name="image" value="<?php echo set_value('image', $image); ?>" id="field" />
									<p>
										<a id="select-image" class="btn btn-primary" onclick="mediaManager('field');"><i class="fa fa-picture-o"></i></a>
										<a class="btn btn-danger" onclick="$('#thumb').attr('src', '<?php echo $no_image; ?>'); $('#field').attr('value', ''); $(this).parent().parent().find('.name').html('');"><i class="fa fa-times-circle"></i></a>
									</p>
								</div>
							</div>
							<?php echo form_error('image', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
                    <div class="form-group">
                        <label for="input-priority" class="col-sm-3 control-label"><?php echo lang('label_priority'); ?></label>
                        <div class="col-sm-5">
                            <input type="text" name="priority" id="input-priority" class="form-control" value="<?php echo set_value('priority', $priority); ?>"/>
                            <?php echo form_error('priority', '<span class="text-danger">', '</span>'); ?>
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
<?php echo get_footer(); ?>