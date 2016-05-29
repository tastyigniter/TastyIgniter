<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab"><?php echo lang('text_tab_general'); ?></a></li>
				<li><a href="#tab-details" data-toggle="tab"><?php echo lang('text_tab_details'); ?></a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="" accept-charset="utf-8" method="POST" action="<?php echo $_action; ?>">
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-bottom active">
					<div class="col-sm-12 col-md-5">
						<div class="row modules-row">
							<?php foreach ($modules as $mod) { ?>
								<div class="col-sm-12 col-md-6 wrap-bottom">
									<div class="dropdown">
										<button class="btn btn-default btn-block btn-lg dropdown-toggle" type="button" id="<?php echo $mod['module_code']; ?>" data-toggle="dropdown"><?php echo $mod['title']; ?></button>
										<ul class="dropdown-menu" role="menu">
											<li role="presentation" class="dropdown-header"><?php echo lang('column_partial'); ?></li>
											<li class="divider"></li>
											<?php foreach ($theme_partials as $partial) { ?>
												<li><a class="module-toggle" data-partial="<?php echo $partial['id']; ?>" data-module-title="<?php echo $mod['title']; ?>" data-module-code="<?php echo $mod['module_code']; ?>" data-module-row="<?php echo (!empty($partial_modules[$partial['id']])) ? count($partial_modules[$partial['id']]) : '0'; ?>"><?php echo $partial['name']; ?></a></li>
											<?php } ?>
										</ul>
									</div>
									<p class="text-muted small wrap-top"><?php echo $mod['description']; ?></p>
								</div>
							<?php } ?>
						</div>
					</div>
					<div class="col-sm-12 col-md-7 wrap-vertical">
						<div class="partials well">
							<?php $partial_count = 1; ?>
							<?php foreach ($theme_partials as $partial) { ?>
								<?php echo ($partial_count === 1) ? '<div class="col-sm-12 col-md-6 wrap-none">' : ''; ?>
								<div class="panel panel-group panel-partial">
									<div class="panel-heading" data-toggle="collapse" data-target="#partial-<?php echo $partial['id']; ?>" aria-expanded="true" aria-controls="partial-<?php echo $partial['id']; ?>">
										<h4 class="panel-title"><b><?php echo $partial['name']; ?></b></h4>
									</div>
									<div class="panel-body collapse in border-top partial-modules" id="partial-<?php echo $partial['id']; ?>" data-partial="<?php echo $partial['id']; ?>">
										<?php if (!empty($partial_modules[$partial['id']])) { ?>
											<?php $module_row = 1; ?>
											<?php foreach ($partial_modules[$partial['id']] as $module) { ?>
												<?php if ($partial['id'] === $module['partial']) { ?>
													<div class="panel panel-default panel-partial-module">
														<div class="panel-heading handle clickable" data-toggle="collapse" data-target="#partial-<?php echo $module['partial']; ?>-module-<?php echo $module_row; ?>" aria-expanded="false" aria-controls="partial-<?php echo $module['partial']; ?>-module-<?php echo $module_row; ?>">
															<i class="fa fa-arrows"></i>&nbsp;&nbsp;
															<b><?php echo $module['name']; ?></b>
															<a class="pull-right" onclick="confirm('<?php echo lang('alert_warning_confirm'); ?>') ? $(this).parent().parent().remove() : false;" title="<?php echo lang('text_remove'); ?>"><i class="fa fa-times-circle text-danger"></i></a>
														</div>
														<div class="panel-body collapse border-top" id="partial-<?php echo $module['partial']; ?>-module-<?php echo $module_row; ?>">
															<input type="hidden" name="modules[<?php echo $module['partial']; ?>][<?php echo $module_row; ?>][module_code]" value="<?php echo set_value('modules['.$module['partial'].']['.$module_row.'][module_code]', $module['module_code']); ?>" />
															<input type="hidden" name="modules[<?php echo $module['partial']; ?>][<?php echo $module_row; ?>][partial]" class="module-partial" value="<?php echo set_value('modules['.$module['partial'].']['.$module_row.'][partial]', $module['partial']); ?>" />
															<?php echo form_error('modules['.$module['partial'].']['.$module_row.'][module_code]', '<span class="text-danger small">', '</span>'); ?>
															<?php echo form_error('modules['.$module['partial'].']['.$module_row.'][partial]', '<span class="text-danger small">', '</span>'); ?>
															<div class="form-group">
																<input type="text" name="modules[<?php echo $module['partial']; ?>][<?php echo $module_row; ?>][title]" id="input-module-title" class="form-control" placeholder="<?php echo lang('label_module_title'); ?>" value="<?php echo set_value('modules['.$module['partial'].']['.$module_row.'][title]', $module['title']); ?>" />
																<?php echo form_error('modules['.$module['partial'].']['.$module_row.'][title]', '<span class="text-danger">', '</span>'); ?>
															</div>
															<div class="form-group">
																<div class="btn-group btn-group-switch btn-module-fixed" data-toggle="buttons" data-partial-module="#partial-<?php echo $module['partial']; ?>-module-<?php echo $module_row; ?>">
																	<?php if ($module['fixed'] == '1') { ?>
																		<label class="btn btn-default"><input type="radio" name="modules[<?php echo $module['partial']; ?>][<?php echo $module_row; ?>][fixed]" value="0" <?php echo set_radio('modules['.$module['partial'].']['.$module_row.'][fixed]', '0'); ?>><b class="pull-left"><?php echo lang('label_module_fixed'); ?></b>  <?php echo lang('text_no'); ?></label>
																		<label class="btn btn-default active"><input type="radio" name="modules[<?php echo $module['partial']; ?>][<?php echo $module_row; ?>][fixed]" value="1" <?php echo set_radio('modules['.$module['partial'].']['.$module_row.'][fixed]', '1', TRUE); ?>><b class="pull-left"><?php echo lang('label_module_fixed'); ?></b>  <?php echo lang('text_yes'); ?></label>
																	<?php } else { ?>
																		<label class="btn btn-default active"><input type="radio" name="modules[<?php echo $module['partial']; ?>][<?php echo $module_row; ?>][fixed]" value="0" <?php echo set_radio('modules['.$module['partial'].']['.$module_row.'][fixed]', '0', TRUE); ?>><b class="pull-left"><?php echo lang('label_module_fixed'); ?></b>  <?php echo lang('text_no'); ?></label>
																		<label class="btn btn-default"><input type="radio" name="modules[<?php echo $module['partial']; ?>][<?php echo $module_row; ?>][fixed]" value="1" <?php echo set_radio('modules['.$module['partial'].']['.$module_row.'][fixed]', '1'); ?>><b class="pull-left"><?php echo lang('label_module_fixed'); ?></b>  <?php echo lang('text_yes'); ?></label>
																	<?php } ?>
																</div>
																<?php echo form_error('modules['.$module['partial'].']['.$module_row.'][fixed]', '<span class="text-danger">', '</span>'); ?>
															</div>
															<div class="form-group module-fixed-offset">
																<label for="input-fixed-top-offset" class="control-label"><?php echo lang('label_fixed_offset'); ?></label>
																<div class="control-group control-group-2">
																	<input type="text" name="modules[<?php echo $module['partial']; ?>][<?php echo $module_row; ?>][fixed_top_offset]" class="form-control" value="<?php echo set_value('modules['.$module['partial'].']['.$module_row.'][fixed_top_offset]', $module['fixed_top_offset']); ?>" />
																	<input type="text" name="modules[<?php echo $module['partial']; ?>][<?php echo $module_row; ?>][fixed_bottom_offset]" class="form-control" value="<?php echo set_value('modules['.$module['partial'].']['.$module_row.'][fixed_bottom_offset]', $module['fixed_bottom_offset']); ?>" />
																</div>
																<?php echo form_error('modules['.$module['partial'].']['.$module_row.'][fixed_top_offset]', '<span class="text-danger">', '</span>'); ?>
																<?php echo form_error('modules['.$module['partial'].']['.$module_row.'][fixed_bottom_offset]', '<span class="text-danger">', '</span>'); ?>
															</div>
															<div class="form-group">
																<div class="btn-group btn-group-switch" data-toggle="buttons">
																	<?php if ($module['status'] === '1') { ?>
																		<label class="btn btn-danger"><input type="radio" name="modules[<?php echo $module['partial']; ?>][<?php echo $module_row; ?>][status]" value="0" <?php echo set_radio('modules['.$module['partial'].']['.$module_row.'][status]', '0'); ?>><b class="pull-left"><?php echo lang('label_module_status'); ?></b>  <?php echo lang('text_disabled'); ?></label>
																		<label class="btn btn-success active"><input type="radio" name="modules[<?php echo $module['partial']; ?>][<?php echo $module_row; ?>][status]" value="1" <?php echo set_radio('modules['.$module['partial'].']['.$module_row.'][status]', '1', TRUE); ?>><b class="pull-left"><?php echo lang('label_module_status'); ?></b>  <?php echo lang('text_enabled'); ?></label>
																	<?php } else { ?>
																		<label class="btn btn-danger active"><input type="radio" name="modules[<?php echo $module['partial']; ?>][<?php echo $module_row; ?>][status]" value="0" <?php echo set_radio('modules['.$module['partial'].']['.$module_row.'][status]', '0', TRUE); ?>><b class="pull-left"><?php echo lang('label_module_status'); ?></b>  <?php echo lang('text_disabled'); ?></label>
																		<label class="btn btn-success"><input type="radio" name="modules[<?php echo $module['partial']; ?>][<?php echo $module_row; ?>][status]" value="1" <?php echo set_radio('modules['.$module['partial'].']['.$module_row.'][status]', '1'); ?>><b class="pull-left"><?php echo lang('label_module_status'); ?></b>  <?php echo lang('text_enabled'); ?></label>
																	<?php } ?>
																</div>
																<?php echo form_error('modules['.$module['partial'].']['.$module_row.'][status]', '<span class="text-danger small">', '</span>'); ?>
															</div>
														</div>
													</div>
													<?php $module_row++; ?>
												<?php } ?>
											<?php } ?>
										<?php } else { ?>
											<span class="empty-partial"><?php echo lang('text_partial_empty'); ?></span>
										<?php } ?>
									</div>
								</div>
								<?php echo ($partial_count == round(count($theme_partials)/2)) ? '</div><div class="col-sm-12 col-md-6 wrap-none">' : ''; ?>
								<?php $partial_count++; ?>
							<?php } ?>
						</div>
					</div>
				</div>
				</div>

				<div id="tab-details" class="tab-pane row wrap-horizontal">
					<div class="form-horizontal">
						<div class="col-xs-12">
							<div class="form-group">
								<label for="input-name" class="col-sm-2 control-label"><?php echo lang('label_name'); ?></label>
								<div class="col-sm-5">
									<input type="text" name="name" id="input-name" class="form-control" value="<?php echo set_value('name', $name); ?>" />
									<?php echo form_error('name', '<span class="text-danger">', '</span>'); ?>
								</div>
							</div>
							<h4 class="tab-pane-title"></h4>
							<div class="form-group wrap-top">
								<label for="input-routes" class="col-sm-2 control-label"><?php echo lang('column_uri_route'); ?></label>
								<div class="col-sm-7">
									<div class="panel panel-default panel-table">
										<div class="table-responsive">
											<table class="table table-striped table-border">
												<tbody id="routes">
												<?php $table_row = 0; ?>
												<?php foreach ($layout_routes as $route) { ?>
													<tr id="table-row<?php echo $table_row; ?>">
														<td class="action action-one"><a class="btn btn-danger" onclick="confirm('<?php echo lang('alert_warning_confirm'); ?>') ? $(this).parent().parent().remove() : false;"><i class="fa fa-times-circle"></i></a></td>
														<td><input type="text" name="routes[<?php echo $table_row; ?>][uri_route]" class="form-control" value="<?php echo $route['uri_route']; ?>" />
															<?php echo form_error('routes['.$table_row.'][uri_route]', '<span class="text-danger">', '</span>'); ?>
														</td>
													</tr>
													<?php $table_row++; ?>
												<?php } ?>
												</tbody>
												<tfoot>
												<tr id="tfoot">
													<td class="action action-one"><a class="btn btn-primary btn-lg" onclick="addRoute();"><i class="fa fa-plus"></i></a></td>
													<td></td>
												</tr>
												</tfoot>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {
	$(document).on('click', '.module-toggle', function() {
		var data = $(this).data();

		data.moduleRow = data.moduleRow + 1;
		addModule(data);

		$('a[data-partial="'+ data.partial +'"]').attr('data-module-row', data.moduleRow);
	});

	$(document).on('change', '.btn-module-fixed input[type="radio"]', function() {
		if (this.value == '1') {
			$($(this).parent().parent().attr('data-partial-module') + ' .module-fixed-offset').fadeIn();
		} else {
			$($(this).parent().parent().attr('data-partial-module') + ' .module-fixed-offset').fadeOut();
		}
	});

	$('.btn-module-fixed input[type="radio"]').trigger('change');
});

var table_row = <?php echo $table_row; ?>;

function addRoute() {
	var html = '<tr id="table-row' + table_row + '">';
	html += '	<td class="action action-one"><a class="btn btn-danger" onclick="confirm(\'<?php echo lang('alert_warning_confirm'); ?>\') ? $(this).parent().parent().remove() : false;"><i class="fa fa-times-circle"></i></a></td>';
	html += '	<td><input type="text" name="routes[' + table_row + '][uri_route]" class="form-control" value="<?php echo set_value("routes[' + table_row + '][uri_route]"); ?>" size="50" />';
	html += '</tr>';

	$('#routes').append(html);

	table_row++;
}

function addModule(data) {
	var html = '<div class="panel panel-default panel-partial-module">';
	html += '	<div class="panel-heading handle" data-toggle="collapse" data-target="#partial-' + data.partial + '-module-' + data.moduleRow + '" aria-expanded="false" aria-controls="partial-' + data.partial + '-module-' + data.moduleRow + '">';
	html += '<i class="fa fa-arrows clickable"></i>&nbsp;&nbsp;' + data.moduleTitle + '<a class="pull-right" onclick="confirm(\'<?php echo lang('alert_warning_confirm'); ?>\') ? $(this).parent().parent().remove() : false;" title="<?php echo lang('text_remove'); ?>"><i class="fa fa-times-circle text-danger"></i></a>';
	html += '	</div>';
	html += '	<div class="panel-body collapse border-top" id="partial-' + data.partial + '-module-' + data.moduleRow + '">';
	html += '		<input type="hidden" name="modules[' + data.partial + '][' + data.moduleRow + '][module_code]" value="' + data.moduleCode + '" />';
	html += '		<input type="hidden" name="modules[' + data.partial + '][' + data.moduleRow + '][partial]" class="module-partial" value="' + data.partial + '" />';
	html += '		<div class="form-group">';
	html += '			<input type="text" name="modules[' + data.partial + '][' + data.moduleRow + '][title]" id="input-module-title" class="form-control" placeholder="<?php echo lang('label_module_title'); ?>" value="" />';
	html += '		</div>';
	html += '		<div class="form-group">';
	html += '			<div class="btn-group btn-group-switch btn-module-fixed" data-toggle="buttons" data-partial-module="#partial-' + data.partial + '-module-' + data.moduleRow + '">';
	html += '				<label class="btn btn-default active"><input type="radio" name="modules[' + data.partial + '][' + data.moduleRow + '][fixed]" value="0" checked="checked"><b class="pull-left"><?php echo lang('label_module_fixed'); ?></b>  <?php echo lang('text_no'); ?></label>';
	html += '				<label class="btn btn-default"><input type="radio" name="modules[' + data.partial + '][' + data.moduleRow + '][fixed]" value="1"><b class="pull-left"><?php echo lang('label_module_fixed'); ?></b>  <?php echo lang('text_yes'); ?></label>';
	html += '			</div>';
	html += '		</div>';
	html += '		<div class="form-group module-fixed-offset">';
	html += '			<label for="input-fixed-top-offset" class="control-label"><?php echo lang('label_fixed_offset'); ?></label>';
	html += '			<div class="control-group control-group-2">';
	html += '				<input type="text" name="modules[' + data.partial + '][' + data.moduleRow + '][fixed_top_offset]" class="form-control" value="" />';
	html += '				<input type="text" name="modules[' + data.partial + '][' + data.moduleRow + '][fixed_bottom_offset]" class="form-control" value="" />';
	html += '			</div>';
	html += '		</div>';
	html += '		<div class="form-group">';
	html += '			<div class="btn-group btn-group-switch" data-toggle="buttons">';
	html += '				<label class="btn btn-danger"><input type="radio" name="modules[' + data.partial + '][' + data.moduleRow + '][status]" value="0" ><b class="pull-left"><?php echo lang('label_module_status'); ?></b>  <?php echo lang('text_disabled'); ?></label>';
	html += '				<label class="btn btn-success active"><input type="radio" name="modules[' + data.partial + '][' + data.moduleRow + '][status]" value="1" checked="checked"><b class="pull-left"><?php echo lang('label_module_status'); ?></b>  <?php echo lang('text_enabled'); ?></label>';
	html += '			</div>';
	html += '		</div>';
	html += '	</div>';
	html += '</div>';

	$('#partial-' + data.partial + ' .empty-partial').remove();
	$('#partial-' + data.partial).append(html);
	$('#partial-' + data.partial +' .btn-group-switch input[type="radio"]:checked').trigger('change');
}

$(function () {
	$('.partial-modules').sortable({
		group: 'partial-modules',
		containerSelector: '.partial-modules',
		itemPath: '> .panel-body',
		itemSelector: '.panel-partial-module',
		placeholder: '<div class="panel-partial-module placeholder"></div>',
		handle: '.handle',
		onDrop: function  ($item, container, _super) {
			var partial = $item.find('.module-partial').val(),
				findPartial = new RegExp(partial, "g"),
				replacePartial = $(container.el[0]).data('partial'),
				modRow = parseInt($item.find('.panel-heading').attr('aria-controls').match(/\d+/)[0]),
				findModRow = parseInt($('a[data-partial="' + partial + '"]').attr('data-module-row')),
				replaceModRow = (partial == replacePartial) ? modRow : parseInt($('a[data-partial="' + replacePartial + '"]').attr('data-module-row')) + 1,
				findRow = new RegExp('\\[' + modRow + '\\]', "g"),
				replaceRow = '[' + replaceModRow + ']',
				findModID = new RegExp($item.find('.panel-heading').attr('aria-controls'), "g"),
				replaceModID = 'partial-' + replacePartial + '-module-' + replaceModRow;

			if (partial != replacePartial) {
				$item.html($item[0].innerHTML.replace(findModID, replaceModID).replace(findRow, replaceRow).replace(findPartial, replacePartial));
				$('#partial-' + replacePartial + ' .empty-partial').remove();
				$('a[data-partial="' + replacePartial + '"]').attr('data-module-row', replaceModRow);
				$('a[data-partial="' + partial + '"]').attr('data-module-row', (partial != replacePartial) ? modRow : findModRow - 1);
            }

			_super($item, container);
		}
	})
});
//--></script>
<?php echo get_footer(); ?>