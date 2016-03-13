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
						<label for="input-language" class="col-sm-3 control-label"><?php echo lang('label_language'); ?></label>
						<div class="col-sm-5">
							<select name="language_id" id="input-language" class="form-control">
								<option value="1" <?php echo set_select('language_id', '1'); ?> ><?php echo lang('text_english_option'); ?></option>
							</select>
							<?php echo form_error('language_id', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<?php if (empty($template_id)) { ?>
					<div class="form-group">
						<label for="input-clone_template" class="col-sm-3 control-label"><?php echo lang('label_clone'); ?></label>
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

					<div id="templates" class="row wrap-top">
						<div class="panel panel-default panel-table">
							<div class="panel-heading">
								<h3 class="panel-title"><?php echo lang('text_tab_templates'); ?></h3>
							</div>
							<?php if ($template_data) { ?>
								<div class="table-responsive">
									<table border="0" class="table table-striped table-border table-no-spacing table-templates">
										<thead>
											<tr>
												<th class="action action-one"></th>
												<th class="left"><?php echo lang('column_title'); ?></th>
												<th class="text-right"><?php echo lang('column_date_updated'); ?></th>
												<th class="text-right"><?php echo lang('column_date_added'); ?></th>
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
																<tr data-toggle="collapse" data-parent="#accordion" aria-expanded="false" aria-controls="template-row-<?php echo $tpl_data['template_data_id']; ?>" data-target="#template-row-<?php echo $tpl_data['template_data_id']; ?>">
																	<td class="action action-one">
																		<i class="fa fa-chevron-up up"></i>
																		<i class="fa fa-chevron-down down"></i>
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
		                                                            <label for="input-subject" class="control-label"><?php echo lang('label_subject'); ?></label>
		                                                        </div>
		                                                        <div class="col-sm-7">
																	<input type="hidden" name="templates[<?php echo $tpl_data['template_data_id']; ?>][code]" id="input-subject" class="form-control" value="<?php echo set_value('templates['.$tpl_data['template_data_id'].'][code]', $tpl_data['code']); ?>" />
																	<input type="text" name="templates[<?php echo $tpl_data['template_data_id']; ?>][subject]" id="input-subject" class="form-control" value="<?php echo set_value('templates['.$tpl_data['template_data_id'].'][subject]', $tpl_data['subject']); ?>" />
																	<?php echo form_error('subject', '<span class="text-danger">', '</span>'); ?>
																</div>
																<div class="col-sm-2">
																	<a class="btn btn-info btn-block" data-toggle="modal" data-target=".mail-variable-container #mail-variables" data-filter="<?php echo $tpl_data['code']; ?>"><?php echo lang('text_variables'); ?>&nbsp;&nbsp; <i class="fa fa-info-circle"></i></a>
																</div>
															</div>

															<div class="form-group">
																<div id="input-wysiwyg" class="col-md-12">
																	<textarea name="templates[<?php echo $tpl_data['template_data_id']; ?>][body]" style="height:300px;width:100%;" class="form-control"><?php echo set_value('templates['.$tpl_data['template_data_id'].'][body]', $tpl_data['body']); ?></textarea>
																	<?php echo form_error('templates['.$tpl_data['template_data_id'].'][body]', '<span class="text-danger">', '</span>'); ?>
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
							<?php } else { ?>
								<div class="panel-body">
									<div class="alert alert-info">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
										<?php echo lang('alert_template_missing'); ?>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</form>

		<div class="mail-variable-container"></div>
	</div>
</div>
<script type="text/javascript">
	$('textarea').summernote({
		height: 300,
	});

	$(document).ready(function() {
		$('.mail-variable-container').load(js_site_url('mail_templates/variables'));
	});
</script>
<?php echo get_footer(); ?>