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
				<li class="active"><a href="#general" data-toggle="tab">Details</a></li>
				<li><a href="#values" data-toggle="tab">Values</a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="post" action="<?php echo $action; ?>">
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-name" class="col-sm-2 control-label">Name:</label>
						<div class="col-sm-5">
							<input type="text" name="option_name" id="input-name" class="form-control" value="<?php echo set_value('option_name', $option_name); ?>" />
							<?php echo form_error('option_name', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-display-type" class="col-sm-2 control-label">Display Type:</label>
						<div class="col-sm-5">
							<select name="display_type" id="input-display-type" class="form-control">
								<?php if ($display_type == 'radio') { ?>
									<option value="radio" selected="selected" <?php echo set_select('display_type', 'radio'); ?> >Radio</option>
								<?php } else { ?>
									<option value="radio" <?php echo set_select('display_type', 'radio'); ?> >Radio</option>
								<?php } ?>
								<?php if ($display_type == 'checkbox') { ?>
									<option value="checkbox" selected="selected" <?php echo set_select('display_type', 'checkbox'); ?> >Checkbox</option>
								<?php } else { ?>
									<option value="checkbox" <?php echo set_select('display_type', 'checkbox'); ?> >Checkbox</option>
								<?php } ?>
								<?php if ($display_type == 'select') { ?>
									<option value="select" selected="selected" <?php echo set_select('display_type', 'select'); ?> >Select</option>
								<?php } else { ?>
									<option value="select" <?php echo set_select('display_type', 'select'); ?> >Select</option>
								<?php } ?>
							</select>
							<?php echo form_error('display_type', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-priority" class="col-sm-2 control-label">Priority:</label>
						<div class="col-sm-5">
							<input type="text" name="priority" id="input-priority" class="form-control" value="<?php echo set_value('priority', $priority); ?>" />
							<?php echo form_error('priority', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>

				<div id="values" class="tab-pane row wrap-all">
					<table class="table table-striped table-border table-sortable">
						<thead>
							<tr>
								<th class="action action-one"></th>
								<th class="action action-one"></th>
								<th>Value</th>
								<th>Price</th>
								<th class="id">ID</th>
							</tr>
						</thead>
						<tbody>
							<?php $table_row = 1; ?>
							<?php foreach ($values as $value) { ?>
								<tr id="table-row<?php echo $table_row; ?>">
									<td class="action action-one"><i class="fa fa-sort handle"></i></td>
									<td class="action action-one"><a class="btn btn-times" onclick="$(this).parent().parent().remove();"><i class="fa fa-times-circle"></i></a></td>
									<td>
										<input type="text" name="values[<?php echo $table_row; ?>][value]" class="form-control" value="<?php echo set_value('values[$table_row][value]', $value['value']); ?>" />
										<?php echo form_error('values['.$table_row.'][value]', '<span class="text-danger">', '</span>'); ?>
									</td>
									<td>
										<input type="text" name="values[<?php echo $table_row; ?>][price]" class="form-control" value="<?php echo set_value('values[$table_row][price]', $value['price']); ?>" />
										<?php echo form_error('values['.$table_row.'][price]', '<span class="text-danger">', '</span>'); ?>
									</td>
									<td class="id">
										<input type="hidden" name="values[<?php echo $table_row; ?>][option_value_id]" class="form-control" value="<?php echo set_value('values[$table_row][option_value_id]', $value['option_value_id']); ?>" />
										<?php echo $value['option_value_id']; ?>
									</td>
								</tr>
							<?php $table_row++; ?>
							<?php } ?>  
						</tbody>
						<tfoot>
							<tr id="tfoot">
								<td class="action action-one"><i class="fa fa-plus" onclick="addValue();"></i></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
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

function addValue() {	
	html  = '<tr id="table-row' + table_row + '">';
    html += '	<td class="action action-one"><i class="fa fa-sort handle"></i></td>';
	html += '	<td class="action action-one"><a class="btn btn-times" onclick="$(this).parent().parent().remove();"><i class="fa fa-times-circle"></i></a></td>';
	html += '	<td>';
	html += '		<input type="text" name="values[' + table_row + '][value]" class="form-control" value="<?php echo set_value("values[' + table_row + '][value]"); ?>" />';
	html += '	</td>';
	html += '	<td><input type="text" name="values[' + table_row + '][price]" class="form-control" value="<?php echo set_value("values[' + table_row + '][price]"); ?>" /></td>';
	html += '	<td class="id">';
	html += '		<input type="hidden" name="values[' + table_row + '][option_value_id]" class="form-control" value="<?php echo set_value("values[' + table_row + '][option_value_id]"); ?>" />';
	html += '	-</td>';
	html += '</tr>';
	
	$('.table-sortable tbody').append(html);
	
	table_row++;
}
//--></script>
<script src="<?php echo base_url("assets/js/jquery-sortable.js"); ?>"></script>
<script type="text/javascript"><!--
$(function () {
	$('.table-sortable').sortable({
		containerSelector: 'table',
		itemPath: '> tbody',
		itemSelector: 'tr',
		placeholder: '<tr class="placeholder"><td colspan="3"></td></tr>',
		handle: '.handle'
	})
})
//--></script> 
<?php echo $footer; ?>