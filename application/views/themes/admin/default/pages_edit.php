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
				<li class="active"><a href="#general" data-toggle="tab">General</a></li>
				<li><a href="#content-f" data-toggle="tab">Content</a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="post" action="<?php echo $action; ?>">
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-name" class="col-sm-2 control-label">Name:</label>
						<div class="col-sm-5">
							<input type="text" name="name" id="" class="form-control" value="<?php echo set_value('name', $name); ?>" />
							<?php echo form_error('name', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-title" class="col-sm-2 control-label">Title:</label>
						<div class="col-sm-5">
							<input type="text" name="title" id="input-title" class="form-control" value="<?php echo set_value('title', $page_title); ?>" />
							<?php echo form_error('title', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-heading" class="col-sm-2 control-label">Heading:</label>
						<div class="col-sm-5">
							<input type="text" name="heading" id="input-heading" class="form-control" value="<?php echo set_value('heading', $page_heading); ?>" />
							<?php echo form_error('heading', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-meta-description" class="col-sm-2 control-label">Meta Description:</label>
						<div class="col-sm-5">
							<textarea name="meta_description" id="input-meta-description" class="form-control" rows="5" cols="45"><?php echo set_value('meta_description', $meta_description); ?></textarea>
							<?php echo form_error('meta_description', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-meta-keywords" class="col-sm-2 control-label">Meta Keywords:</label>
						<div class="col-sm-5">
							<textarea name="meta_keywords" rows="5" id="input-meta-keywords" class="form-control"><?php echo set_value('meta_keywords', $meta_keywords); ?></textarea>
							<?php echo form_error('meta_keywords', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-layout" class="col-sm-2 control-label">Layout:</label>
						<div class="col-sm-5">
							<select name="layout_id" id="input-layout" class="form-control">
								<option value="0">None</option>
								<?php foreach ($layouts as $layout) { ?>
								<?php if ($layout['layout_id'] === $layout_id) { ?>
									<option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
								<?php } else { ?>  
									<option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
								<?php } ?>  
								<?php } ?>
							</select>
							<?php echo form_error('layout_id', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-language" class="col-sm-2 control-label">Language:</label>
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
						<label for="input-permalink" class="col-sm-2 control-label">Permalink:
							<span class="help-block">Use ONLY alpha-numeric characters, underscores or dashes and make sure it is unique GLOBALLY.</span>
						</label>
						<div class="col-sm-5">
							<input type="text" name="permalink" id="input-permalink" class="form-control" value="<?php echo set_value('permalink', $permalink); ?>"/>
							<?php echo form_error('permalink', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-menu-location" class="col-sm-2 control-label">Menu Location:</label>
						<div class="col-sm-5">
							<select name="menu_location" id="input-menu-location" class="form-control">
								<?php foreach ($menu_locations as $key => $value) { ?>
								<?php if ($menu_location == $key) { ?>
									<option value="<?php echo $key; ?>" <?php echo set_select('menu_location', '0', TRUE); ?> ><?php echo $value; ?></option>
								<?php } else { ?>  
									<option value="<?php echo $key; ?>" <?php echo set_select('menu_location', '0'); ?> ><?php echo $value; ?></option>
								<?php } ?>  
								<?php } ?>  
							</select>
							<?php echo form_error('menu_location', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-status" class="col-sm-2 control-label">Status:</label>
						<div class="col-sm-5">
							<select name="status" id="input-status" class="form-control">
								<option value="0" <?php echo set_select('status', '0'); ?> >Disabled</option>
								<?php if ($status === '1') { ?>
									<option value="1" <?php echo set_select('status', '1', TRUE); ?> >Enabled</option>
								<?php } else { ?>  
									<option value="1" <?php echo set_select('status', '1'); ?> >Enabled</option>
								<?php } ?>  
							</select>
							<?php echo form_error('status', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>

				<div id="content-f" class="tab-pane row wrap-all">
					<textarea name="content" id="page-content" style="height:400px;width:100%;"><?php echo set_value('content', $content); ?></textarea>
					<?php echo form_error('content', '<span class="text-danger">', '</span>'); ?>
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url("assets/js/tinymce/tinymce.js"); ?>"></script>
<script type="text/javascript">
tinymce.init({
    selector: '#page-content',
    menubar: false,
	plugins : 'table link image code charmap autolink lists textcolor',
	toolbar1: 'bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | formatselect | bullist numlist',
	toolbar2: 'forecolor backcolor | outdent indent | undo redo | link unlink anchor image code | hr table | subscript superscript | charmap',
	removed_menuitems: 'newdocument',
	skin : 'tiskin'
});
</script>
<?php echo $footer; ?>