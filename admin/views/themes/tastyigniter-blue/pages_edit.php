<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab"><?php echo lang('text_tab_general'); ?></a></li>
				<li><a href="#content-f" data-toggle="tab"><?php echo lang('text_tab_content'); ?></a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo $_action; ?>">
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-title" class="col-sm-3 control-label"><?php echo lang('label_title'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="title" id="input-title" class="form-control" value="<?php echo set_value('title', $page_title); ?>" />
							<?php echo form_error('title', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-heading" class="col-sm-3 control-label"><?php echo lang('label_heading'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="heading" id="input-heading" class="form-control" value="<?php echo set_value('heading', $page_heading); ?>" />
							<?php echo form_error('heading', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-layout" class="col-sm-3 control-label"><?php echo lang('label_layout'); ?></label>
						<div class="col-sm-5">
							<select name="layout_id" id="input-layout" class="form-control">
								<option value="0"><?php echo lang('text_none'); ?></option>
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
						<label for="input-language" class="col-sm-3 control-label"><?php echo lang('label_language'); ?></label>
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
						<label for="input-slug" class="col-sm-3 control-label"><?php echo lang('label_permalink_slug'); ?>
							<span class="help-block"><?php echo lang('help_permalink'); ?></span>
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
						<label for="input-navigation" class="col-sm-3 control-label"><?php echo lang('label_navigation'); ?>
							<span class="help-block"><?php echo lang('help_navigation'); ?></span>
						</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-toggle btn-group-4" data-toggle="buttons">
								<?php if (in_array('none', $navigation)) { ?>
									<label class="btn btn-default active"><input type="checkbox" name="navigation[]" value="none" <?php echo set_checkbox('navigation[]', 'none', TRUE); ?>><?php echo lang('text_none'); ?></label>
								<?php } else { ?>
									<label class="btn btn-default"><input type="checkbox" name="navigation[]" value="none" <?php echo set_checkbox('navigation[]', 'none'); ?>><?php echo lang('text_none'); ?></label>
								<?php } ?>
								<?php if (in_array('header', $navigation)) { ?>
									<label class="btn btn-default active"><input type="checkbox" name="navigation[]" value="header" <?php echo set_checkbox('navigation[]', 'header', TRUE); ?>><?php echo lang('text_header'); ?></label>
								<?php } else { ?>
									<label class="btn btn-default"><input type="checkbox" name="navigation[]" value="header" <?php echo set_checkbox('navigation[]', 'header'); ?>><?php echo lang('text_header'); ?></label>
								<?php } ?>
								<?php if (in_array('side_bar', $navigation)) { ?>
									<label class="btn btn-default active"><input type="checkbox" name="navigation[]" value="side_bar" <?php echo set_checkbox('navigation[]', 'side_bar', TRUE); ?>><?php echo lang('text_side_bar'); ?></label>
								<?php } else { ?>
									<label class="btn btn-default"><input type="checkbox" name="navigation[]" value="side_bar" <?php echo set_checkbox('navigation[]', 'side_bar'); ?>><?php echo lang('text_side_bar'); ?></label>
								<?php } ?>
								<?php if (in_array('footer', $navigation)) { ?>
									<label class="btn btn-default active"><input type="checkbox" name="navigation[]" value="footer" <?php echo set_checkbox('navigation[]', 'footer', TRUE); ?>><?php echo lang('text_footer'); ?></label>
								<?php } else { ?>
									<label class="btn btn-default"><input type="checkbox" name="navigation[]" value="footer" <?php echo set_checkbox('navigation[]', 'footer'); ?>><?php echo lang('text_footer'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('navigation[]', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
                    <div class="form-group">
                        <label for="input-meta-description" class="col-sm-3 control-label"><?php echo lang('label_meta_description'); ?></label>
                        <div class="col-sm-5">
                            <textarea name="meta_description" id="input-meta-description" class="form-control" rows="5" cols="45"><?php echo set_value('meta_description', $meta_description); ?></textarea>
                            <?php echo form_error('meta_description', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-meta-keywords" class="col-sm-3 control-label"><?php echo lang('label_meta_keywords'); ?></label>
                        <div class="col-sm-5">
                            <textarea name="meta_keywords" rows="5" id="input-meta-keywords" class="form-control"><?php echo set_value('meta_keywords', $meta_keywords); ?></textarea>
                            <?php echo form_error('meta_keywords', '<span class="text-danger">', '</span>'); ?>
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

				<div id="content-f" class="tab-pane row">
					<div class="col-sm-12">
						<textarea name="content" id="input-wysiwyg" class="form-control" style="height:400px;width:100%;"><?php echo set_value('content', $content); ?></textarea>
						<?php echo form_error('content', '<span class="text-danger">', '</span>'); ?>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript">
	$('#input-wysiwyg').summernote({
		height: 300,
	});
</script>
<?php echo get_footer(); ?>