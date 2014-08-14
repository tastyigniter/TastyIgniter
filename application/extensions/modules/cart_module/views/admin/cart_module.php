<div class="row content">
	<div class="col-xs-12">
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
				<li><a href="#layouts" data-toggle="tab">Layouts</a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-name" class="col-sm-2 control-label">Name:</label>
						<div class="col-sm-5">
							<input type="text" name="name" id="input-name" class="form-control" value="<?php echo set_value('name', $name); ?>" />
							<?php echo form_error('name', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>

				<div id="layouts" class="tab-pane row wrap-all">
					<table class="table table-striped table-border table-sortable">
						<thead> 
							<tr>
								<th class="action action-one"></th>
								<th>Layout</th>
								<th>Position</th>
								<th>Priority</th>
								<th>Status</th>
							</tr>
						</thead> 
						<tbody> 
							<?php $table_row = 0; ?>
							<?php foreach ($modules as $module) { ?>
							<tr id="module-row<?php echo $table_row; ?>">
								<td class="action action-one"><a class="btn btn-times" onclick="$(this).parent().parent().remove();"><i class="fa fa-times-circle"></i></a></td>
								<td><select name="layouts[<?php echo $table_row; ?>][layout_id]" class="form-control">
									<?php foreach ($layouts as $layout) { ?>
									<?php if ($layout['layout_id'] === $module['layout_id']) { ?>
										<option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
									<?php } else { ?>  
										<option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
									<?php } ?>  
									<?php } ?>  
									</select>
									<?php echo form_error('layouts['.$table_row.'][layout_id]', '<span class="text-danger small">', '</span>'); ?>
								</td>
								<td><select name="layouts[<?php echo $table_row; ?>][position]" class="form-control">
									<?php if ($module['position'] === 'right') { ?>
										<option value="right" selected="selected">Right</option>
										<option value="left">Left</option>
									<?php } else if ($module['position'] === 'left') { ?>  
										<option value="right">Right</option>
										<option value="left" selected="selected">Left</option>
									<?php } else { ?>  
										<option value="right">Right</option>
										<option value="left">Left</option>
									<?php } ?>  
									</select>
									<?php echo form_error('layouts['.$table_row.'][position]', '<span class="text-danger small">', '</span>'); ?>
								</td>
								<td><input type="text" name="layouts[<?php echo $table_row; ?>][priority]" class="form-control" value="<?php echo $module['priority']; ?>" />
									<?php echo form_error('layouts['.$table_row.'][priority]', '<span class="text-danger small">', '</span>'); ?>
								</td>
								<td>
									<div class="btn-group btn-group-toggle" data-toggle="buttons">
										<?php if ($module['status'] === '1') { ?>
											<label class="btn btn-default" data-btn="btn-danger"><input type="radio" name="layouts[<?php echo $table_row; ?>][status]" value="0" <?php echo set_radio('layouts['.$table_row.'][status]', '0'); ?>>Disabled</label>
											<label class="btn btn-default active" data-btn="btn-success"><input type="radio" name="layouts[<?php echo $table_row; ?>][status]" value="1" <?php echo set_radio('layouts['.$table_row.'][status]', '1', TRUE); ?>>Enabled</label>
										<?php } else { ?>  
											<label class="btn btn-default active" data-btn="btn-danger"><input type="radio" name="layouts[<?php echo $table_row; ?>][status]" value="0" <?php echo set_radio('layouts['.$table_row.'][status]', '0', TRUE); ?>>Disabled</label>
											<label class="btn btn-default" data-btn="btn-success"><input type="radio" name="layouts[<?php echo $table_row; ?>][status]" value="1" <?php echo set_radio('layouts['.$table_row.'][status]', '1'); ?>>Enabled</label>
										<?php } ?>  
									</div>
									<?php echo form_error('layouts['.$table_row.'][status]', '<span class="text-danger small">', '</span>'); ?>
								</td>
							</tr>
							<?php $table_row++; ?>
							<?php } ?>  
						</tbody> 
						<tfoot> 
							<tr id="tfoot">
								<td class="action action-one"><i class="fa fa-plus" onclick="addModule();"></i></td>
								<td colspan="4"></td>
							</tr>		 
						</tfoot> 
					</table>
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript"><!--
var table_row = <?php echo $table_row; ?>;

function addModule() {	
	html  = '<tr id="module-row' + table_row + '">';
	html += '	<td class="action action-one"><a class="btn btn-times" onclick="$(this).parent().parent().remove();"><i class="fa fa-times-circle"></i></a></td>';
    html += '	<td><select name="layouts[' + table_row + '][layout_id]" class="form-control">';
		<?php foreach ($layouts as $layout) { ?>
			html += '<option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>';
		<?php } ?>  
    html += '	</select></td>';
    html += '	<td><select name="layouts[' + table_row + '][position]" class="form-control">';    
		html += '	<option value="right">Right</option>';
		html += '	<option value="left">Left</option>';
    html += '	</select></td>';    
	html += '	<td><input type="text" name="layouts[' + table_row + '][priority]" class="form-control" value="" /></td>';
	html += '   <td><div class="btn-group btn-group-toggle" data-toggle="buttons">';
	html += '   	<label class="btn btn-default active" data-btn="btn-danger"><input type="radio" name="layouts[' + table_row + '][status]" value="0" checked="checked">Disabled</label>';
	html += '   	<label class="btn btn-default" data-btn="btn-success"><input type="radio" name="layouts[' + table_row + '][status]" value="1">Enabled</label>';
	html += '   </div></td>';
	html += '</tr>';
	
	$('.table-sortable tbody').append(html);
	$('select.form-control').selectpicker('refresh');
	$('.btn-group-toggle input[type="radio"]:checked').trigger('change');
	
	table_row++;
}
//--></script> 