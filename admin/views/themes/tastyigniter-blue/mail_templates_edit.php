<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab">General</a></li>
				<?php if ($template_data) { ?>
					<li><a href="#templates" data-toggle="tab">Templates</a></li>
				<?php } ?>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="post" action="<?php echo $action; ?>">
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label">Name:</label>
						<div class="col-sm-5">
							<input type="text" name="name" id="input-name" class="form-control" value="<?php echo set_value('name', $name); ?>" />
							<?php echo form_error('name', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-language" class="col-sm-3 control-label">Language:</label>
						<div class="col-sm-5">
							<select name="language_id" id="input-language" class="form-control">
								<option value="1" <?php echo set_select('language_id', '1'); ?> >English</option>
							</select>
							<?php echo form_error('language_id', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<?php if (empty($template_id)) { ?>
					<div class="form-group">
						<label for="input-clone_template" class="col-sm-3 control-label">Clone Template:</label>
						<div class="col-sm-5">
							<select name="clone_template_id" id="input-clone_template" class="form-control">
								<?php foreach ($templates as $template) { ?>
									<option value="<?php echo $template['template_id']; ?>" <?php echo set_select('clone_template_id', $template['template_id']); ?> ><?php echo $template['name']; ?></option>
								<?php } ?>
							</select>
							<?php echo form_error('clone_template_id', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<?php } ?>
					<div class="form-group">
						<label for="input-status" class="col-sm-3 control-label">Status:</label>
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

				<?php if ($template_data) { ?>
				<div id="templates" class="tab-pane row wrap-all">
					<div class="panel panel-default panel-table">
						<div class="table-responsive">
							<table border="0" class="table table-striped table-border table-templates">
								<thead>
									<tr>
										<th class="action action-one"></th>
										<th class="left">Title</th>
										<th class="text-right">Date Updated</th>
										<th class="text-right">Date Added</th>
									</tr>
								</thead>
								<tbody id="accordion">
									<?php $template_row = 1; ?>
									<?php foreach ($template_data as $tpl_data) { ?>
									<tr>
		  								<td colspan="4">
		    								<div class="template-heading">
												<div class="table-responsive">
			  										<table border="0" class="table-template">
														<tr data-toggle="collapse" data-parent="#accordion" data-target="#template-row-<?php echo $tpl_data['template_data_id']; ?>">
															<td class="action action-one">
																<i class="fa fa-angle-double-up up"></i>
																<i class="fa fa-angle-double-down down"></i>
															</td>
															<td class="left"><?php echo $tpl_data['title']; ?></td>
															<td class="text-right"><?php echo $tpl_data['date_updated']; ?></td>
															<td class="text-right"><?php echo $tpl_data['date_added']; ?></td>
														</tr>
													</table>
												</div>
		    								</div>
											<div id="template-row-<?php echo $tpl_data['template_data_id']; ?>" class="collapse">
												<div class="template-content">
													<div class="form-group">
														<div class="col-sm-3">
                                                            <label for="input-subject" class="control-label">Subject:</label>
                                                        </div>
                                                        <div class="col-sm-7">
															<input type="hidden" name="templates[<?php echo $tpl_data['template_data_id']; ?>][code]" id="input-subject" class="form-control" value="<?php echo set_value('templates['.$tpl_data['template_data_id'].'][code]', $tpl_data['code']); ?>" />
															<input type="text" name="templates[<?php echo $tpl_data['template_data_id']; ?>][subject]" id="input-subject" class="form-control" value="<?php echo set_value('templates['.$tpl_data['template_data_id'].'][subject]', $tpl_data['subject']); ?>" />
															<?php echo form_error('subject', '<span class="text-danger">', '</span>'); ?>
														</div>
														<div class="col-sm-2">
															<a class="btn btn-info btn-block" data-toggle="modal" data-target=".mail-variable-container #mail-variables">Variables &nbsp;&nbsp; <i class="fa fa-info-circle"></i></a>
														</div>
													</div>

													<div class="form-group">
														<div id="input-wysiwyg" class="col-md-12">
															<textarea name="templates[<?php echo $tpl_data['template_data_id']; ?>][body]" style="height:300px;width:100%;" class="form-control"><?php echo set_value('templates['.$tpl_data['template_data_id'].'][body]', $tpl_data['body']); ?></textarea>
														</div>
													</div>
												</div>
											</div>
										</td>
									</tr>
									<?php $template_row++; ?>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
		</form>

		<div class="mail-variable-container"></div>
	</div>
</div>
<script type="text/javascript">
tinymce.init({
    selector: 'textarea',
    menubar: false,
	plugins : 'table link image code charmap autolink lists textcolor variable',
	toolbar1: 'bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | formatselect | bullist numlist | table hr code',
	toolbar2: 'forecolor backcolor | outdent indent | undo redo | link unlink anchor image | subscript superscript | charmap variable',
	removed_menuitems: 'newdocument',
    theme: 'modern',
	skin : 'tiskin',
	convert_urls : false,
    file_browser_callback : imageManager
});

$(document).ready(function() {
	$('.mail-variable-container').load(js_site_url('mail_templates/variables'));
});

$(document).on('click', '.show_hide', function() {
	$('.mail-variable-container').load(js_site_url('mail_templates/variables'));

	if ($('#supported-var').hasClass('hide')) {
		$('#input-body').removeClass('col-md-12').addClass('col-md-9');
		$('#supported-var').removeClass('hide');
	} else {
		$('#input-body').removeClass('col-md-9').addClass('col-md-12');
		$('#supported-var').addClass('hide');
	}
});
</script>
<?php echo get_footer(); ?>