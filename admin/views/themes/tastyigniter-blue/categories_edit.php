<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab">Category Details</a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="post" action="<?php echo $action; ?>">
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label">Name:</label>
						<div class="col-sm-5">
							<input type="text" name="name" id="input-name" class="form-control" value="<?php echo set_value('name', $name); ?>"/>
							<?php echo form_error('name', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-slug" class="col-sm-3 control-label">Slug:
							<span class="help-block">Use ONLY alpha-numeric lowercase characters, underscores or dashes and make sure it is unique GLOBALLY.</span>
						</label>
						<div class="col-sm-5">
                            <div class="input-group">
                                <span class="input-group-addon text-sm"><?php echo $permalink['url']; ?></span>
                                <input type="hidden" name="permalink[permalink_id]" value="<?php echo set_value('permalink[permalink_id]', $permalink['permalink_id']); ?>"/>
                                <input type="text" name="permalink[slug]" id="input-slug" class="form-control" value="<?php echo set_value('permalink[slug]', $permalink['slug']); ?>"/>
                            </div>
                            <?php echo form_error('permalink[permalink_id]', '<span class="text-danger">', '</span>'); ?>
                            <?php echo form_error('permalink[slug]', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label">Parent:</label>
						<div class="col-sm-5">
							<select name="parent_id" id="category" class="form-control">
								<option value="">None</option>
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
						<label for="input-description" class="col-sm-3 control-label">Description:</label>
						<div class="col-sm-5">
							<textarea name="description" id="input-description" class="form-control" rows="7"><?php echo set_value('description', $description); ?></textarea>
							<?php echo form_error('description', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-3 control-label">Image:
							<span class="help-block">Select a file to update category image, otherwise leave blank.</span>
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
										<a class="btn btn-danger" onclick="$('#thumb').attr('src', '<?php echo $no_image; ?>'); $('#field').attr('value', 'data/no_photo.png'); $(this).parent().parent().find('.name').html('no_photo.png');"><i class="fa fa-times-circle"></i></a>
									</p>
								</div>
							</div>
							<?php echo form_error('image', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<?php echo get_footer(); ?>